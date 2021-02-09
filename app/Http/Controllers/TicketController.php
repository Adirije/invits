<?php

namespace App\Http\Controllers;

use PDF;
use App\Models\Event;
use App\Models\Ticket;
use Illuminate\Support\Str;
use Illuminate\Http\Request;

class TicketController extends Controller
{
    public function printFree(Request $request){
        $regData = $request->session()->get('free-reg-data');

        $reg = $regData['reg'];

        $pdf = PDF::loadView('documents.tickets.free-ticket', compact('reg'))
                ->setOptions(['defaultFont' => 'sans-serif']);

        return $pdf->download($reg->guest->slug . $reg->event->name . Str::random(5) . Str::random(5) . 'ticket.pdf');

        
    }

    
    public function printTickets(Request $request){
        $data = $request->session()->get('data');
        $guest = $data['guest'];
        $event = $data['event'];
        $transactions = $data['transactions'];

        $pdf = PDF::loadView('documents.tickets.ticket', compact('transactions', 'event'))
                ->setOptions(['defaultFont' => 'sans-serif']);

        return $pdf->download($guest->slug . $event->name . Str::random(5) . Str::random(5) . 'tickets.pdf');
        
    }
}
