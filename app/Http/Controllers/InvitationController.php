<?php

namespace App\Http\Controllers;

use App\Models\Guest;
use App\Models\Ticket;
use App\Models\Invitation;
use Illuminate\Http\Request;
use App\Models\EventRegistration;
use Illuminate\Support\Facades\Validator;

class InvitationController extends Controller
{
    public function showRegForm($inviteSlug){

        $invite = Invitation::with('event')
                    ->where('slug', $inviteSlug)
                    ->where('status', 'pending')
                    ->firstOrFail();

        return view('public.invitations.register', compact('invite'));
    }

    public function store(Request $request, $inviteSlug){
        $validator = Validator::make($request->all(), [
            'firstName' => ['bail', 'required', 'string', 'max:191'],
            'lastName' => ['bail', 'required', 'string', 'max:191'],
            'phone' => ['bail', 'sometimes', 'nullable', 'string', 'max:191'],
        ]);
        
        $invite = Invitation::where('slug', $inviteSlug)->first();

        $validator->sometimes('ticket', ['required', 'exists:tickets,id'], function($input) use ($invite){
            return count($invite->event->tickets) > 0;
        });

        $ticket = Ticket::find($request->ticket);

        $validator->after(function($validator) use ($invite, $ticket, $request){
            if(is_null($invite) || $invite->status != 'pending'){
                $validator->errors()->add('invitation', 'The invitation may already be honoured or does not exist.');
            }

            if(!is_null($request->ticket) && (is_null($ticket) || $ticket->sold_out) && count($invite->event->tickets) > 0){
                $validator->errors()->add('ticket', 'Ticket sold out or does not exist anymore.');
            }
        });

        $validator->validate();
        
        if(count($invite->event->tickets)){
            return response([], 201);
        }

        $event = $invite->event;

        $guest = new Guest;
        $guest->firstname = $request->firstName;
        $guest->lastname = $request->lastName;
        $guest->email = $invite->email;
        $guest->phone = $request->phone;
        $guest->save();

        $reg = new EventRegistration;
        $reg->event_id = $event->id;
        $reg->guest_id = $guest->id;
        $reg->seat = '1/1';
        $reg->save();

        $invite->status = 'ok';
        $invite->save();

        $url =  redirect()
                ->route('public.tickets.printFree')
                ->with('free-reg-data', compact('reg'))
                ->getTargetUrl();
        
        return response()->json(['url' => $url]); 

    }

    public function showDeclinePage(Request $request, $slug){
        $invite = Invitation::where('slug', $slug)->where('status', 'pending')->firstOrFail();
        return view('public.invitations.decline', compact('invite'));
    }

    public function decline(Request $request, $slug){
        $invite = Invitation::where('slug', $slug)->firstOrFail();
        $invite->status = 'declined';

        $invite->save();

        $notice = [
            'type' => 'success',
            'title' => 'Done!', 
            'text' => 'Invitation declined.'
        ];

        $request->session()->flash('notification', json_encode($notice));

        return redirect(route('public.home'));
    }
}
