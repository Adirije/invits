@extends('admin.app')

@section('page-header', 'Ticket sales')

@section('styles')
    <link rel="stylesheet" href="/css/swiper.min.css">
    <style>
     
        .w-40-px{
            width: 40px;
        }

        .bg-md-white{
            box-shadow: none;
            background-color: #f4f6f9;
        }
        @media(min-width: 576px){
            .w-sm-100-px{
                width: 100px;
            }
        }

        @media(min-width: 768px){
            .bg-md-white{
                background-color: var(--white) !important;
                box-shadow: 0 0 1px rgba(0,0,0,.125),0 1px 3px rgba(0,0,0,.2);
            }
        }
    </style>
@endsection

@section('content')
<div class="container-fluid">
    <div class="card bg-md-white shadow-none shadow mb-3">
        <div class="card-body p-0 p-md-3">
            <div class="row mb-4">
                <div class="col-6">
                    <h4>Event Information</h4>
                    <div><span class="text-muted">Name:</span> {{ $ticket->event->name }}</div>
                    <div><span class="text-muted">Location:</span> {{ $ticket->event->location->address }}</div>
                </div>
                <div class="col-6">
                    <h4 class="text-center">Ticket Information</h4>
                    <div class="row text-center">
                        <div class="col-6">
                            <div><span class="text-muted">Name:</span> {{ $ticket->name }}</div>
                            <div><span class="text-muted">Price:</span> @naira($ticket->price)</div>
                        </div>
                        <div class="col-6">
                            <div><span class="text-muted">Sold:</span> {{ $ticket->quantity_sold }}</div>
                            <div><span class="text-muted">Available:</span> {{$ticket->volume - $ticket->quantity_sold}}</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="card bg-md-white shadow-none shadow">
        <div class="card-header">
            <h2 class="card-title">Transactions</h2>
        </div>
        <div class="card-body p-0 p-md-3">

            <table class="table w-100" id="usersTable">
                <thead>
                    <tr>
                        <th class="d-none d-md-table-cell" style="width: 10px">#</th>
                        <th style="width:200px">Guest</th>
                        <th class="d-none d-md-table-cell" style="width:100px">Reference</th>
                        <th class="d-none d-md-table-cell" style="width:50px">Quantity</th>
                        <th class="d-none d-md-table-cell" style="width:100px">Channel</th>
                        <th class="d-none d-md-table-cell" style="width:100px">Amount</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($transactions as $i => $transaction)
                        <tr>
                            <td class="d-none d-md-table-cell">{{ $i + 1 }}</td>
                            <td>
                                <div>{{ $transaction->guest->name }}</div>
                                <span class="text-muted">{{ $transaction->guest->email }}</span>
                            </td>
                            <td class="d-none d-md-table-cell">{{ $transaction->payment->reference }}</td>
                            <td class="d-none d-md-table-cell">{{ $transaction->ticket_quantity }}</td>
                            <td class="d-none d-md-table-cell">{{ ucfirst($transaction->payment->channel) }}</td>
                            <td class="d-none d-md-table-cell">
                                <div>@naira($transaction->ticket_quantity * $ticket->price)</div>
                                <div><span class="text-muted">Paid:</span> @naira($transaction->payment->amount)</div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

@endsection

@section('scripts')

<script>

    $(document).ready(function(){
        $('#usersTable').DataTable();
    });

</script>
@endsection