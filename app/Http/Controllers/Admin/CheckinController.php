<?php

namespace App\Http\Controllers\Admin;

use PDF;
use App\Models\Event;
use App\Models\Guest;
use App\Models\Ticket;
use App\Models\Payment;
use App\Models\Transaction;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\EventRegistration;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class CheckinController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($eventId = null)
    {
        $events = Event::all();

        if(is_null($eventId)){
            return view('admin.checkins.index', compact('events'));
        }

        $event = Event::with([
            'registrations' => function($query) use ($eventId){
                $query->where('event_id', $eventId);

                $query->where('checked_in', true);
            },

            'registrations.guest'
        ])->findOrFail($eventId);

        return view('admin.checkins.index', compact('events', 'event'));
    }

    /**
     * Show the form for creating a new resource.
     * 
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function create($eventId)
    {
        $event = Event::findOrFail($eventId);

        $registrations = EventRegistration::with('guest')->where('event_id', $eventId)
                                            ->where('checked_in', false)
                                            ->get();

        return view('admin.checkins.create', compact('event', 'registrations'));
    }

    public function verifyCode($code){
        $reg = EventRegistration::where('checkin_code', $code)->where('checked_in', false)->first();
        
        if(! $reg){
            return response()->json('registered', 422);
        }

        return response()->json($reg->guest);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $reg = EventRegistration::where('checkin_code', $request->code)->first();

        if($reg->checked_in){
            return response()->json(['errors' => ['code' => ['Guest already checked in.']]], 422);
        }

        $guest = Guest::firstOrNew(
            [
                'firstname' => $request->firstname,
                'lastname' => $request->lastname,
                'lastname' => $request->lastname,
                'email' => $request->email,
            ],
            ['phone' => $request->phone]
        );

        $guest->save();

        $reg->guest_id = $guest->id;
        $reg->checked_in =  true;

        $reg->save();

        $notice = [
            'type' => 'success',
            'title' => 'Done!', 
            'text' => 'Guest checked in successfuly'
        ];

        $request->session()->flash('notification', json_encode($notice));

        return response()->json([], 201);
    }

    public function storeOffline(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'firstName' => ['bail', 'required', 'string'],
            'lastName' => ['bail', 'required', 'string'],
            'email' => ['bail', 'sometimes', 'nullable', 'email'],
            'phone' => ['bail', 'sometimes', 'nullable', 'string'],
            'amount' => ['bail', 'required', 'numeric'],
            'ticket' => ['bail', 'required', 'integer'],
        ]);

        $ticket = Ticket::find($request->ticket);

        $validator->after(function ($validator) use ($ticket) {
            if(is_null($ticket) || $ticket->sold_out){
                $validator->errors()->add('ticket', 'Ticket sold out or does not exist anymore.');
            }
        });

        $validator->validate();

        $transactions = [];

        $event = Event::find($request->event);

        $guest = $this->createGuest($request);

        $payment = $this->createPayment($request, $event);

        $transaction = $this->createTransaction($request, $guest, $payment);

        $regs = $this->createRegistrations($request, $guest, $ticket, $transaction);

        $transactions[] = $transaction;

        $url =  redirect()
                ->route('public.tickets.printPaid')
                ->with('data', compact('guest', 'event', 'transactions'))
                ->getTargetUrl();
        

        return response()->json(['url' => $url]);
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

    public function printIndex($eventId){
        $event = Event::with([
            'registrations' => function($query) use ($eventId){
                $query->where('event_id', $eventId);

                $query->where('checked_in', true);
            },

            'registrations.guest'
        ])->findOrFail($eventId);

        // return view('documents.checkins', compact('event'));

        $pdf = PDF::loadView('documents.checkins', compact('event'))
                    ->setOptions(['defaultFont' => 'sans-serif']);

        return $pdf->download($event->name . '_checkins.pdf');
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

    protected function createTransaction($request, $guest, $payment)
    {
        $transaction = new Transaction;
    
        $transaction->payment_id = $payment->id;
        $transaction->guest_id = $guest->id;
        $transaction->ticket_id = $request->ticket;
        $transaction->ticket_quantity = 1;

        $transaction->save();

        return $transaction;
    }

    protected function createPayment($request, $event)
    {
        $payment = new Payment;
        $payment->reference = 'TX' . strtoupper(Str::random(17));
        $payment->amount = $request->amount;
        $payment->currency = 'NGN';
        $payment->status = 'success';
        $payment->channel = 'venue';
        $payment->event_id = $event->id;
        $payment->log = json_encode(['info' => 'paid on venue']);

        $payment->save();

        return $payment;
    }

    protected function createRegistrations($request, $guest, $ticket, $transaction)
    {
        $regs = [];

        $count = 1;

        while($count <= $ticket->guests){
            $reg = new EventRegistration;
    
            $reg->guest_id = $guest->id;
            $reg->event_id = $request->event;
            $reg->ticket_id = $request->ticket;
            $reg->transaction_id = $transaction->id;
            $reg->channel = 'venue';
            $reg->seat = $count . '/' . $ticket->guests;
            
            //in case of a ticket for multiple guests, checkin only the first person
            //and then capture the information of the other guets
            if($count == 1){
                $reg->checked_in = true;
            }

            $reg->save();

            $regs[] = $reg;

            $count++;
        }

        return $reg;
    }

    protected function createGuest($request)
    {
        $guest = new Guest;

        $guest->firstname = $request->firstName;
        $guest->lastname = $request->lastName;
        $guest->email = $request->email;
        $guest->phone = $request->phone;

        $guest->save();

        return $guest;
    }
}
