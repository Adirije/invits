@extends('admin.app')

@section('page-header', 'Financial Records')


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
            <div class="direct-chat-messages" style="height: auto" id="eventFormHolder">
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

    @if (isset($records))
        <div class="card bg-md-white shadow-none shadow">
            <div class="card-body p-0 p-md-3">
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

        @if (count($records))
            <div class="row">
                <div class="col-4">
                    <div class="small-box bg-info">
                        <div class="inner">
                          <h3>@naira($event->budget)</h3>
                          <p>Budget</p>
                        </div>
                        <div class="icon">
                          <i class="ion ion-stats-bars"></i>
                        </div>
                        <a href="{{ route('admin.events.edit', ['id' => $event->id]) }}" class="small-box-footer">Edit <i class="fas fa-edit"></i></a>
                    </div>
                </div>
                <div class="col-4">
                    <div class="small-box bg-danger">
                        <div class="inner">
                          <h3>@naira($records['totalExpense'])</h3>
          
                          <p>Expenditure</p>
                        </div>
                        <div class="icon">
                          <i class="ion ion-stats-bars"></i>
                        </div>
                        <a href="{{ route('admin.finance.expenses.index', ['eventId' => $event->id]) }}" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                    </div>
                </div>
                <div class="col-4">
                   
                    <div class="small-box bg-success">
                        <div class="inner">
                            <h3>@naira($records['totalIncome'])</h3>
            
                            <p>Income</p>
                        </div>
                        <div class="icon">
                            <i class="ion ion-stats-bars"></i>
                        </div>
                        <a href="{{ route('admin.finance.income.index', ['eventId' => $event->id]) }}" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                    </div>
                        
                </div>
            </div>
        @else
            <div class="card bg-md-white shadow-none shadow">
                <div class="card-body p-0 p-md-3">
                    <p>No finacial record exists for the chosen event</p>
                </div>
            </div>
        @endif
    @endif
</div>

@endsection

@section('scripts')

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
                    var form = $('#eventForm');
                    var eventId = document.getElementById('event').value

                    form.attr('action', '/admin/finance/events/' +eventId);

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
            createSubmitBtn(document.getElementById('event'));
        })
           
    })(jQuery);

</script>
@endsection