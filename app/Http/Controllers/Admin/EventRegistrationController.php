<?php

namespace App\Http\Controllers\Admin;

use PDF;
use App\Models\Event;
use App\Models\Guest;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\EventRegistration;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class EventRegistrationController extends Controller
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
            return view('admin.registrations.index', compact('events'));
        }

        $event = Event::with(['registrations.guest', 'registrations.ticket'])->find($eventId);

        return view('admin.registrations.index', compact('event', 'events'));
    }

    public function print($eventId){
        $event = Event::with(['registrations.guest', 'registrations.ticket'])->find($eventId);

        // return view('documents.event_regs', compact('event'));
        
        $pdf = PDF::loadView('documents.event_regs', compact('event'))
                ->setOptions(['defaultFont' => 'sans-serif']);

        return $pdf->download($event->name . '_registrations.pdf');
        
    }

    /**
     * Store a newly created free registration in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'firstName'  => ['bail', 'required', 'string', 'max:191'],
            'lastName' => ['bail', 'required', 'string', 'max:191'],
            'email' => ['bail', 'sometimes', 'nullable', 'email', 'max:191'],
            'phone' => ['bail', 'sometimes', 'nullable', 'string', 'max:191'],
            
        ]);

        $event = Event::findOrFail($id);

        $validator->after(function($validator) use ($event){
            if(! $event->tickets){
                $validator->errors()->add('event', 'Event requires payment to register');
            }
        });
        
        $validator->validate();

        $guest = new Guest;

        $guest->firstname = $request->firstName;
        $guest->lastname = $request->lastName;
        $guest->email = $request->email;
        $guest->phone = $request->phone;
        $guest->save();

        $reg = new EventRegistration;
        $reg->event_id = $id;
        $reg->guest_id = $guest->id;
        $reg->seat = '1/1';
        $reg->checked_in = $request->boolean('checkin');
        $reg->save();

        $url =  redirect()
                ->route('public.tickets.printFree')
                ->with('free-reg-data', compact('reg'))
                ->getTargetUrl();
        
        return response()->json(['url' => $url]); 
    }

 
}
