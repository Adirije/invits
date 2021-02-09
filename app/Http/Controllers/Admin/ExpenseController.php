<?php

namespace App\Http\Controllers\Admin;

use PDF;
use App\Models\Event;
use App\Models\Expense;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ExpenseController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($eventId)
    {
        $event = Event::with('expenses')->findOrFail($eventId);
        
        $totalExpense = $event->expenses->reduce(function($sum, $expense){
            return $sum + $expense->amount;
        }, 0);

        $precentageBudgetSpent = round($totalExpense / $event->budget * 100, PHP_ROUND_HALF_UP );
        
        $precentageBudgetLeft = 100 - $precentageBudgetSpent;

        return view('admin.finance.expense', compact('event', 'totalExpense', 'precentageBudgetSpent', 'precentageBudgetLeft'));
    }

    public function print($eventId){
        $event = Event::with('expenses')->findOrFail($eventId);
        
        $totalExpense = $event->expenses->reduce(function($sum, $expense){
            return $sum + $expense->amount;
        }, 0);

        $precentageBudgetSpent = round($totalExpense / $event->budget * 100, PHP_ROUND_HALF_UP );
        
        $precentageBudgetLeft = 100 - $precentageBudgetSpent;

        // return view('documents.expenditures', compact('event', 'totalExpense', 'precentageBudgetSpent', 'precentageBudgetLeft'));
        
        $pdf = PDF::loadView('documents.expenditures', compact('event', 'totalExpense', 'precentageBudgetSpent', 'precentageBudgetLeft'))
                ->setOptions(['defaultFont' => 'sans-serif']);

        return $pdf->download($event->name . '_expenditure.pdf');

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

        $expense = new Expense;

        $expense->title = $request->title;
        $expense->amount = $request->amount;
        $expense->info = $request->info;
        $expense->event_id = $eventId;

        $expense->save();

        $notice = [
            'type' => 'success',
            'title' => 'Done!', 
            'text' => 'Expenditure added successfuly'
        ];

        $request->session()->flash('notification', json_encode($notice));

        return response()->json([], 201);
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

        $expense = Expense::findOrFail($id);

        $expense->title = $request->title;
        $expense->amount = $request->amount;
        $expense->info = $request->info;

        $expense->save();

        $notice = [
            'type' => 'success',
            'title' => 'Done!', 
            'text' => 'Expenditure updated successfuly'
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
        Expense::destroy($id);

        $notice = [
            'type' => 'success',
            'title' => 'Done!', 
            'text' => 'Expenditure deleted successfuly'
        ];

        $request->session()->flash('notification', json_encode($notice));

        return response()->json([], 201);
    }
}
