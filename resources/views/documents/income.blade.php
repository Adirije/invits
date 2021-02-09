@extends('documents.app')

@section('content')
<div>
    <div style="text-align: center">
        <h3>{{ $event->name }}</h3>
        <p>Income Information</p>
    </div>

    <div>Income Summary</div>
    <table style="width: 100%; margin-bottom: 20px">
        <thead>
            <tr>
                <th>Online</th>
                <th>Venue</th>
                <th>Auxilliary</th>
                <th>Total</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td><span style="font-family: DejaVu Sans;">&#x20A6;</span>{{ number_format($onlineTotal, 2) }}</td>
                <td><span style="font-family: DejaVu Sans;">&#x20A6;</span>{{ number_format($venueTotal, 2) }}</td>
                <td><span style="font-family: DejaVu Sans;">&#x20A6;</span>{{ number_format($customTotal, 2) }}</td>
                <td><span style="font-family: DejaVu Sans;">&#x20A6;</span>{{ number_format($total, 2) }}</td>
            </tr>
        </tbody>
    </table>
    

    <div>Income Breakdown</div>
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
            @foreach ($event->payments as $i => $payment)
                <tr>
                    <td>{{ $i + 1 }}</td>
                    <td>Ticket Payment ({{ $payment->channel }})</td>
                    <td><span style="font-family: DejaVu Sans;">&#x20A6;</span>{{number_format($payment->amount, 2)}}</td>
                    <td>Payment reference {{ $payment->reference }}
                        <div style="color: #6c757d">
                            Date: {{$payment->created_at->toDayDateTimeString()}}
                        </div>
                    </td>
                </tr>
            @endforeach

            @php
                $count = isset($i) ? $i + 1 : 0;
            @endphp

            @foreach ($event->incomes as $income)
                <tr>
                    <td class="d-none d-md-table-cell">{{ $count + 1}}</td>
                    <td>{{ $income->title }}</td>
                    <td><span style="font-family: DejaVu Sans;">&#x20A6;</span>{{number_format($income->amount, 2)}}</td>
                    <td>{{ $income->info }}</td>
                </tr>
                @php
                    $count++;
                @endphp
            @endforeach
        </tbody>
    </table>
</div>
@endsection
