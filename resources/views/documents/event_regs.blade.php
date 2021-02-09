@extends('documents.app')

@section('content')
    <div style="text-align: center">
        <h1>{{ $event->name }}</h1>
        <p>Registrations</p>
    </div>
    <table style="width: 100%">
        <thead>
            <tr>
                <th style="width: 20px">#</th>
                <th>Guest</th>
                <th>Ticket</th>
                <th>Pass Code</th>
                <th>Seat</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($event->registrations as $i => $reg)
                <tr>
                    <td>{{ $i + 1 }}</td>
                    <td>
                        <div>{{ $reg->guest->name }}</div>
                        <div class="info">{{ $reg->guest->email }}</div>
                        <div class="info">{{ $reg->guest->phone }}</div>
                    </td>
                    <td>{{ $reg->ticket->name ?? 'Free' }}</td>
                    <td>{{ $reg->checkin_code }}</td>
                    <td>{{ $reg->seat }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
@endsection
