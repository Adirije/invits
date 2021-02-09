<?php

namespace App\Http\Controllers\Admin;

use PDF;
use App\Models\Event;
use App\Models\Income;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class IncomeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($eventId)
    {
        $event = Event::with(['payments', 'incomes'])->findOrFail($eventId);

        $onlineTotal = $event->payments
                ->filter(function($payment){
                    return $payment->channel == 'online';
                })
                ->reduce(function($sum, $payment){
                    return  $sum + $payment->amount;
                }, 0);

        $venueTotal = $event->payments
                ->filter(function($payment){
                    return $payment->channel == 'venue';
                })
                ->reduce(function($sum, $payment){
                    return  $sum + $payment->amount;
                }, 0);

        $customTotal = $event->incomes
                        ->reduce(function($sum, $income){
                            return $sum + $income->amount;
                        }, 0);

        $total = $onlineTotal + $venueTotal + $customTotal;
        
        return view('admin.finance.income', compact('event', 'total', 'onlineTotal', 'venueTotal', 'customTotal'));
    }
    
    public function print($eventId){
        $event = Event::with(['payments', 'incomes'])->findOrFail($eventId);

        $onlineTotal = $event->payments
                        ->filter(function($payment){
                            return $payment->channel == 'online';
                        })
                        ->reduce(function($sum, $payment){
                            return  $sum + $payment->amount;
                        }, 0);

        $venueTotal = $event->payments
                        ->filter(function($payment){
                            return $payment->channel == 'venue';
                        })
                        ->reduce(function($sum, $payment){
                            return  $sum + $payment->amount;
                        }, 0);

        $customTotal = $event->incomes
                        ->reduce(function($sum, $income){
                            return $sum + $income->amount;
                        }, 0);
        
        $total = $onlineTotal + $venueTotal + $customTotal;
        
        // return view('documents.income', compact('event'));
        
        $pdf = PDF::loadView('documents.income', compact('event', 'total', 'onlineTotal', 'venueTotal', 'customTotal'))
                ->setOptions(['defaultFont' => 'sans-serif']);

        return $pdf->download($event->name . '_income.pdf');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, $eventId)
    {
        $request->validate([
            'title' => ['bail', 'required', 'string'],
            'amount' => ['bail', 'required', 'numeric'],
            'info' => ['bail', 'sometimes', 'nullable', 'string'],
        ]);

        $income = new Income;

        $income->title = $request->title;
        $income->amount = $request->amount;
        $income->info = $request->info;
        $income->event_id = $eventId;

        $income->save();

        $notice = [
            'type' => 'success',
            'title' => 'Done!', 
            'text' => 'Income added successfuly'
        ];

        $request->session()->flash('notification', json_encode($notice));

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
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'title' => ['bail', 'required', 'string'],
            'amount' => ['bail', 'required', 'numeric'],
            'info' => ['bail', 'sometimes', 'nullable', 'string'],
        ]);

        $income = Income::findOrFail($id);

        $income->title = $request->title;
        $income->amount = $request->amount;
        $income->info = $request->info;

        $income->save();

        $notice = [
            'type' => 'success',
            'title' => 'Done!', 
            'text' => 'Income updated successfuly'
        ];

        $request->session()->flash('notification', json_encode($notice));

        return response()->json([], 201);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $id)
    {
        Income::destroy($id);

        $notice = [
            'type' => 'success',
            'title' => 'Done!', 
            'text' => 'Income deleted successfuly'
        ];

        $request->session()->flash('notification', json_encode($notice));

        return response()->json([], 201);
    }
}
