@extends('documents.app')

@section('content')
<div>
    <div style="text-align: center">
        <h3>{{ $event->name }}</h3>
        <p>Check-ins</p>
    </div>

    <table style="width: 100%">
        <thead>
            <tr>
                <th style="width: 20px">#</th>
                <th>Guest</th>
                <th>Contact</th>
                <th>Registration Channel</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($event->registrations as $i => $reg)
                <tr>
                    <td>{{ $i + 1 }}</td>
                    <td>{{ $reg->guest->name }}</td>
                    <td>
                        <div>{{ $reg->guest->email }}</div> 
                        <div>{{ $reg->guest->phone }}</div>
                    </td>
                    <td>{{ ucfirst($reg->channel)}}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
