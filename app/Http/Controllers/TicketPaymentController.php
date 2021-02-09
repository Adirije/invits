<?php

namespace App\Http\Controllers;

use PDF; 
use App\Models\Event;
use App\Models\Guest;
use App\Models\Ticket;
use App\Models\Payment;
use App\Models\Invitation;
use App\Models\Transaction;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\EventRegistration;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Http;

class TicketPaymentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     * 
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request, $eventSlug)
    {
        $event = Event::with('tickets')->where('slug', $eventSlug)->firstOrFail();

        return view('public.events.checkout', compact('event'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, $eventSlug)
    {
        
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function initPayment(Request $request)
    {
        $returningGuest = Guest::where('email', $request['guest']['email'])
                        ->where('firstname', $request['guest']['firstname'])
                        ->where('lastname', $request['guest']['lastname'])
                        ->first();
        
        $guest = $returningGuest ?? $this->createGuest($request);

        $error = [];

        foreach($request['cart'] as $ticketIncart)
        {
            $ticket = Ticket::find($ticketIncart['id']);

            if(is_null($ticket) || $ticket->quantity_sold  >= $ticket->volume){
                $error[$ticket->id] = $ticket->name . 'Sold out!';
            }

            if(is_null($ticket) ||  $ticketIncart['quantity'] > $ticket->volume){
                $error[$ticket->id] = $ticket->name . ' Sold out!';
            }
        }

        if(count($error)){
            return response()->json($error, 422);
        }

        return response()->json($guest, 200);
    }

    public function verifyInvitePayment(Request $request, $reference)
    {
        $response = Http::withHeaders([
            "Authorization" => 'Bearer ' . env('PAYSTACK_SECRET')
        ])->get('https://api.paystack.co/transaction/verify/' . $reference);

        $paymentValidationResponse = $response->json();

        Log::debug($paymentValidationResponse);

        if($paymentValidationResponse['data']['status'] !== 'success'){
            return response()->json(['Payment failed!'], 422);
        }

        $invite = Invitation::where('slug', $request->invite)->first();

        $guest = new Guest;
        $guest->firstname = $request->firstName;
        $guest->lastname = $request->lastName;
        $guest->email = $invite->email;
        $guest->phone = $invite->phone;
        $guest->save();

        $payment = $this->createPayment($paymentValidationResponse, $invite->event);
        
        $ticket = Ticket::find($request->ticket);

        $transaction = new Transaction;
        $transaction->payment_id = $payment->id;
        $transaction->guest_id = $guest->id;
        $transaction->ticket_id = $ticket->id;
        $transaction->ticket_quantity = 1;
        $transaction->save();
        
        $transactions = [];
        $transactions[] = $transaction;

        $event = $invite->event;

        $guestCount = 1;
               
        while($guestCount <= $ticket->guests){
            $reg = new EventRegistration;
            $reg->event_id = $event->id;
            $reg->guest_id = $guest->id;
            $reg->ticket_id = $ticket->id;
            $reg->transaction_id = $transaction->id;
            $reg->seat = $guestCount . '/' . $ticket->guests;
            $reg->save();

            $guestCount++;
        }

        $invite->status = 'ok';
        $invite->save();
        
        $url = redirect()
                ->route('public.tickets.printPaid')
                ->with('data', compact('guest', 'event', 'transactions'))
                ->getTargetUrl();

        return response()->json(['url' => $url]);   
    }

    public function verifyPayment(Request $request, $reference)
    {
        $response = Http::withHeaders([
            "Authorization" => 'Bearer ' . env('PAYSTACK_SECRET')
        ])->get('https://api.paystack.co/transaction/verify/' . $reference);

        $paymentValidationResponse = $response->json();

        Log::debug($paymentValidationResponse);

        if($paymentValidationResponse['data']['status'] !== 'success'){
            return response()->json(['Payment failed!'], 422);
        }

        if($paymentValidationResponse['data']['amount'] < ($request->totalCost * 100)){
            return response()->json(['invalid amount paid. Please contact support for assistance'], 422);
        }

        $guest = Guest::where('slug', $request['guest']['slug'])->first();

        $event = Event::find($request['event']);

        $payment = $this->createPayment($paymentValidationResponse, $event);

        $transactions = $this->createTransactions($request, $guest, $payment);

        $url =  redirect()
                ->route('public.tickets.printPaid')
                ->with('data', compact('guest', 'event', 'transactions'))
                ->getTargetUrl();
        
        return response()->json(['url' => $url]);
    }

    protected function createTransactions($request, $guest, $payment){
        
        $guestCount = 0;

        $transactions = [];
        
        foreach($request['cart'] as $i => $ticket){
            $transaction = new Transaction;
    
            $transaction->payment_id = $payment->id;
            $transaction->guest_id = $guest->id;
            $transaction->ticket_id = $ticket['id'];
            $transaction->ticket_quantity = $ticket['quantity'];

            $transaction->save();

            //create reservations for guests
            for($i = 1; $i <= $ticket['quantity']; $i++)
            {
                $guestCount = 1;
               
                while($guestCount <= $ticket['guests']){
                    $reg = new EventRegistration;
                    $reg->event_id = $request['event'];
                    $reg->guest_id = $guest->id;
                    $reg->ticket_id = $ticket['id'];
                    $reg->transaction_id = $transaction->id;
                    $reg->seat = $guestCount . '/' . $ticket['guests'];
                    $reg->save();
    
                    $guestCount++;
                }
            }

            $transactions[] = $transaction;
        }

        return $transactions;

    }

    protected function createGuest($request){
        
        $guest = new Guest;

        $guest->firstname = $request['guest']['firstname'];
        $guest->lastname = $request['guest']['lastname'];
        $guest->email = $request['guest']['email'];

        $guest->save();

        return $guest;
    }

    protected function createPayment($paymentValidationResponse, $event){
        $payment = new Payment;

        $payment->reference = $paymentValidationResponse['data']['reference'];
        $payment->amount = $paymentValidationResponse['data']['amount'] / 100;
        $payment->currency = $paymentValidationResponse['data']['currency'];
        $payment->status = $paymentValidationResponse['data']['status'];
        $payment->event_id = $event->id;
        $payment->log = json_encode($paymentValidationResponse);

        $payment->save();

        return $payment;
    }
}
