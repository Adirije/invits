<?php

namespace App\Http\Controllers\Admin;

use App\Models\Event;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class FinanceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($eventId = null)
    {
        $events = Event::all();
        $records = null;
        $event = null;

        if($eventId){
            $event = Event::with(['expenses', 'payments', 'incomes'])->findOrFail($eventId);

            $records['totalExpense'] = $event->expenses->reduce(function($sum, $expense){
                return $sum + $expense->amount;
            }, 0);

            $totalPayments = $event->payments->reduce(function($sum, $payment){
                return  $sum + $payment->amount;
            }, 0);

            $totalCustomeIncomes = $event->incomes->reduce(function($sum, $income){
                return  $sum + $income->amount;
            }, 0);

            $records['totalIncome'] = $totalPayments + $totalCustomeIncomes;
        }

        return view('admin.finance.index', compact('events', 'records', 'event'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
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
}
