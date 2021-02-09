@extends('admin.app')

@section('page-header')
<div>
    <i class="nav-icon fas fa-id-card"></i> <span>Guest registrations</span>
</div>
@endsection

@section('styles')
    <link rel="stylesheet" href="/css/swiper.min.css">
    <style>
        .card-body::after, .card-footer::after, .card-header::after {
            content: none;
        }

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
    <div class="card direct-chat direct-chat-primary">
        <div class="card-header">
            <h3 class="card-title">Choos Event</h3>
            <div class="card-tools">
              <button type="button" class="btn btn-tool" data-card-widget="collapse">
                <i class="fas fa-minus"></i>
              </button>
            </div>
        </div>

        <div class="card-body">
            <div class="direct-chat-messages" style="height: auto; padding-left:15px; padding-right: 15px" id="eventFormHolder">
                <form method="GET" id="eventForm">
                    <select class="j2-select custom-select" name="event" id="event" required form="createForm">
                        <option value="">-- choose an event --</option>
                        @foreach ($events as $evt)
                            <option value="{{ $evt->id }}">{{ $evt->name }}</option>
                        @endforeach
                    </select>
                </form>
                <button type="button" class="btn d-block mt-3 w-100 btn-success" id="eventFormSubmtBtn">Submit</button>
            </div>
        </div>
    </div>
    
    @if(isset($event))
    
        <div class="card direct-chat direct-chat-primary bg-info">
            <div class="card-header">
                <h3 class="card-title">Event Information</h3>
                <div class="card-tools">
                    <button type="button" class="btn btn-tool" data-card-widget="collapse">
                        <i class="fas fa-minus"></i>
                    </button>
                    <button type="button" class="btn btn-tool" data-card-widget="remove">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
            </div>

            <div class="card-body">
                <div class="direct-chat-messages" style="height: auto; padding-left:15px; padding-right: 15px">
                    <h3>{{$event->name}}</h3>
                    <div class="row">
                        <div class="col-6">
                            <p>Starts: {{ $event->starts->toDayDateTimeString() }}</p>
                        </div>

                        <div class="col-6">
                            <p>Ends: {{ $event->ends->toDayDateTimeString() }}</p>
                        </div>

                        <div class="col-12">
                            <h4>Venue</h4>
                            <p>{{ $event->location->name }}</p>
                            <p>{{ $event->location->address }}</p>
                        </div>
                    </div>
                </div> 
            </div>
        </div>

        <div class="card bg-md-white shadow-none shadow">
            <div class="card-header d-flex justify-content-between align-items-baseline">
                <h3 class="card-title">Registrations</h3>
                @if(isset($event) && count($event->registrations))
                    <button id="exportBtn" class="btn btn-info"><i class="fas fa-print"></i> Export</button>
                @endif
            </div>
            <div class="card-body p-0 p-md-3">
                <table class="table w-100" id="usersTable">
                    <thead>
                        <tr>
                            <th class="d-none d-md-table-cell" style="width: 10px">#</th>
                            <th style="width:200px">Guest</th>
                            <th class="d-none d-md-table-cell" style="width:100px">Ticket</th>
                            <th class="w-sm-100-px w-40-px">Pass Code</th>
                            <th class="w-sm-100-px w-40-px">Seat</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($event->registrations as $i => $reg)
                            <tr>
                                <td class="d-none d-md-table-cell">{{ $i + 1 }}</td>
                                <td>
                                    <div>{{ $reg->guest->name }}</div>
                                    <div class="text-muted small">{{ $reg->guest->email }}</div>
                                    <div class="text-muted small">{{ $reg->guest->phone }}</div>
                                </td>
                                <td class="d-none d-md-table-cell">{{ $reg->ticket->name ?? 'Free' }}</td>
                                <td>{{ $reg->checkin_code }}</td>
                                <td>{{ $reg->seat }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    @endif
</div>

@endsection

@section('scripts')

@isset($event)
    <script>
        (function($){
            $('#exportBtn').click(function(e){
                window.open("{{  route('admin.registrations.print', ['id' => $event->id]) }}", '_blank')
            });
        })(jQuery)
    </script>
@endisset

<script>
    (function($){

        function createSubmitBtn(eventInput){
        
            $('#eventFormSubmtBtn').remove();
        
            if(eventInput.value){
                var submtBtn = $('<button />').attr({
                    class: 'btn d-block mt-3 w-100 btn-success',
                    id: 'eventFormSubmtBtn',
                    type: 'button'
                }).text('Submit');
        
                $('#eventFormHolder').append(submtBtn);
        
                $('#eventFormSubmtBtn').click(function(e){
                    var form = document.getElementById('eventForm');
                    var eventId = document.getElementById('event').value;
        
                    form.action = '/admin/registrations/events/' + eventId;
                    
                    console.log(form)
                    
                    form.submit()
                });
        
            }
        }
        
        $('.j2-select').select2();
        
        $('#event').on('change', function(e){
            createSubmitBtn(this)
        });

        $(document).ready(function(e){
            $('#usersTable').DataTable({
                "lengthMenu": [[10, 25, 50, 100, -1], [10, 25, 50, 100, "All"]]
            });

            createSubmitBtn(document.getElementById('event'));
        })
        
    })(jQuery)
</script>
@endsection