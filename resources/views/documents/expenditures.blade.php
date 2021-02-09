@extends('documents.app')

@section('content')
<div>
    <div style="text-align: center">
        <h3>{{ $event->name }}</h3>
        <p>Expenditures</p>
    </div>

    <div>Summary of Expenditure</div>
    <table style="width: 100%; margin-bottom: 20px">
        <thead>
            <tr>
                <th>Budget</th>
                <th>Expenditure</th>
                <th>% Budget Spent</th>
                <th>% Budget Left</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td><span style="font-family: DejaVu Sans;">&#x20A6;</span>{{ number_format($event->budget, 2) }}</td>
                <td><span style="font-family: DejaVu Sans;">&#x20A6;</span>{{ number_format($totalExpense, 2) }}</td>
                <td>{{ number_format($precentageBudgetSpent, 2) }}<span style="font-size: 15px">%</span></td>
                <td>{{ number_format($precentageBudgetLeft, 2) }}<span style="font-size: 15px">%</span></td>
            </tr>
        </tbody>
    </table>
    

    <div>List of Expenses</div>
    <table style="width: 100%;">
        <thead>
            <tr>
                <th style="width: 20px">#</th>
                <th>Name</th>
                <th style="width:100px">Amount</th>
                <th>Info</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($event->expenses as $i => $expense)
                <tr>
                    <td>{{ $i + 1 }}</td>
                    <td>{{ $expense->title }}</td>
                    <td><span style="font-family: DejaVu Sans;">&#x20A6;</span>{{number_format($expense->amount, 2)}}</td>
                    <td>{{ $expense->info }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
