<?php

namespace App\Http\Controllers\Admin;

use App\Models\Ticket;
use App\Models\Transaction;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class TicketController extends Controller
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
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => ['bail', 'required', 'string', 'max:191'],
            'guests' => ['bail', 'required', 'integer'],
            'price' => ['bail', 'required', 'numeric'],
            'volume' => ['bail', 'required', 'integer'],
            'event' => ['bail', 'required', 'integer', 'exists:events,id'],
        ]);

        $ticket = new Ticket;
        
        $ticket->name = $request->name;
        $ticket->guests = $request->guests;
        $ticket->price = $request->price;
        $ticket->volume = $request->volume;
        $ticket->event_id = $request->event;
        $ticket->enabled = $request->boolean('enabled');

        $ticket->save();

        return response()->json([], 201);
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
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
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
        $request->validate([
            'name' => ['bail', 'required', 'string', 'max:191'],
            'guests' => ['bail', 'required', 'integer'],
            'price' => ['bail', 'required', 'numeric'],
            'volume' => ['bail', 'required', 'integer'],
        ]);

        $ticket = Ticket::findOrFail($id);
        
        $ticket->name = $request->name;
        $ticket->guests = $request->guests;
        $ticket->price = $request->price;
        $ticket->volume = $request->volume;
        $ticket->enabled = $request->boolean('enabled');

        $ticket->save();

        return response()->json([], 201);
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

    public function sales($id){
        $ticket = Ticket::with('event')->findOrFail($id);

        $transactions = Transaction::with(['payment', 'guest'])->where('ticket_id', $id)->get();

        return view('admin.events.components.tickets.sales', compact('ticket', 'transactions'));
    }
}
