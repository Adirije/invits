@extends('admin.app')

@section('page-header')
    <span><i class="fas fa-users"></i> Manage Event</span>
@endsection

@section('actionBtn')
<div class="d-flex">
    <a href="{{  route('admin.invitations.index', ['eventId' => $event->id]) }}" id="addBtn" class="btn btn-warning mr-2"><i class="fas fa-envelope"></i> Invitations</a>
    <a href="{{  route('admin.registrations', ['id' => $event->id]) }}" id="addBtn" class="btn btn-warning mr-2"><i class="fas fa-id-card"></i> Registrations</a>
    <a href="{{  route('admin.checkins.guests', ['id' => $event->id]) }}" id="addBtn" class="btn btn-warning mr-2"><i class="fas fa-user-check"></i> Check-ins</a>
    <a href="{{  route('admin.events.edit', ['id' => $event->id]) }}" id="addBtn" class="btn btn-warning"><i class="fas fa-edit"></i> Edit</a>
</div>
@endsection

@section('styles')
    <link rel="stylesheet" href="/admin_assets/plugins/summernote/summernote-bs4.min.css">
    <style>
        .view-ticket-row:hover{
            cursor: pointer;
            background-color: #e5e7e8;
        }
    </style>
@endsection

@section('content')
    <main class="container-fluid">
        <section class="card card-danger card-outline">
            <div class="card-header">
                <h3 class="card-title">{{$event->name}}</h3>
            </div>

            <div class="card-body">
                <div class="row">
                    <div class="col-7">
                        <img class="img-fluid" src="{{ $event->feature_img }}" alt="">
                        <div class="row my-3">
                            <div class="col-6">
                                <div class="text-muted">Name</div>
                                <div>{{ $event->name }}</div>
                            </div>
                            <div class="col-6">
                                <div class="text-muted">Tag line</div>
                                <div>{{ $event->tagline }}</div>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-6">
                                <div class="text-muted">Type</div>
                                <div>{{ ucfirst($event->type)}}</div>
                            </div>
                            <div class="col-6">
                                <div class="text-muted">Budget</div>
                                <div>&#8358; {{ ucfirst($event->budget)}}</div>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-6">
                                <div class="text-muted">Starts</div>
                                <div>{{ $event->starts->toDayDateTimeString() }} ({{ $event->starts->diffForHumans() }})</div>
                            </div>
                            <div class="col-6">
                                <div class="text-muted">Ends</div>
                                <div>{{ $event->ends->toDayDateTimeString() }} ({{ $event->ends->diffForHumans($event->starts) }})</div>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-3">
                                <div class="text-muted">Major</div>
                                @if ($event->major)
                                    <div><i class="fas text-success fa-check-circle"></i> Yes</div>
                                @else
                                    <div><i class="fas text-danger fa-times"></i> No</div>
                                @endif
                            </div>
                            <div class="col-3">
                                <div class="text-muted">Featured</div>
                                @if ($event->featured)
                                    <div><i class="fas text-success fa-check-circle"></i> Yes</div>
                                @else
                                    <div><i class="fas text-danger fa-times"></i> No</div>
                                @endif
                            </div>
                            <div class="col-3">
                                <div class="text-muted">Published</div>
                                @if ($event->published)
                                    <div><i class="fas text-success fa-check-circle"></i> Yes</div>
                                @else
                                    <div><i class="fas text-danger fa-times"></i> No</div>
                                @endif
                            </div>
                            <div class="col-3">
                                <div class="text-muted">Enabled</div>
                                @if ($event->enabled)
                                    <div><i class="fas text-success fa-check-circle"></i> Yes</div>
                                @else
                                    <div><i class="fas text-danger fa-times"></i> No</div>
                                @endif
                            </div>
                        </div>

                        <div>
                            <div class="text-muted">Description</div>
                            {!! $event->desc !!}
                        </div>
                    </div>
                    <div class="col-5 bg-light rounded-top p-3">
                        <div>
                            <h4 class="text-center"><i class="fas fa-ticket-alt"></i> Tickets</h4>
                            @if (count($event->tickets))
                                <table class="table">
                                    <tbody>
                                        @foreach ($event->tickets as $idx => $ticket)
                                            <tr data-ticket="{{ $ticket }}" class="view-ticket-row">
                                                <td style="width: 10px">{{ $idx + 1 }}.</td>
                                                @if ($ticket->enabled)
                                                    <td class="text-success">{{ $ticket->name }}</td>
                                                @else
                                                    <td>{{ $ticket->name }}</td>
                                                @endif
                                                <td>&#8358; {{ $ticket->price_str }}</td>
                                                <td>{{ $ticket->quantity_sold }}/{{ $ticket->volume }}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            @else
                                <p class="text-center">No tickets have been added for this event</p>
                            @endif
                            <div class="text-center mt-3">
                                <button class="btn btn-success btn-sm" data-toggle="modal" data-target="#createTicketModal"><i class="fas fa-plus"></i> Add Ticket</button>
                            </div>
                        </div>

                        <div class="mt-5">
                            <h4 class="text-center"><i class="fa fa-user-tie"></i> Client</h4>
                            <div class="mb-3">
                                <div class="text-muted">Name</div>
                                <div>{{ $event->client->name }}</div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-6">
                                    <div class="text-muted">Email</div>
                                    <div>{{ $event->client->email }}</div>
                                </div>
                                <div class="col-6">
                                    <div class="text-muted">Phone</div>
                                    <div>{{ $event->client->phone }}</div>
                                </div>
                            </div>
                            <div class="mb-3">
                                <div class="text-muted">Address</div>
                                <div>{{ $event->client->address }}</div>
                            </div>
                        </div>

                        <div class="mt-5">
                            <h4 class="text-center"><i class="fas fa-map-marker-alt"></i> Location</h4>
                            <div class="mb-3">
                                <div class="text-muted">Type</div>
                                <div>{{ ucfirst($event->location->type) }}</div>
                            </div>
                            <div class="mb-3">
                                <div class="text-muted">Name</div>
                                <div>{{ ucfirst($event->location->name) }}</div>
                            </div>
                            <div class="mb-3">
                                <div class="text-muted">Address</div>
                                <div>{{ ucfirst($event->location->address) }}</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </main>

    @include('admin.events.components.tickets.show-modal')
    @include('admin.events.components.tickets.edit-modal')
    @include('admin.events.components.tickets.create-modal')
@endsection

@section('scripts')
    <script src="/admin_assets/plugins/summernote/summernote-bs4.min.js"></script>
    <script src="/js/utils.js"></script>
    <script>
        $(function () {
            var event = JSON.parse("{!! addslashes(json_encode($event)) !!}");
            $('#compose-textarea').summernote({
                placeholder: 'Write your event description here...',
                minHeight: 100,
            });

            $('#compose-textarea').summernote('code', event.desc);

        })
    </script>

    <script>

        function saveTicket(event, el){

            event.preventDefault();

            $('#submitBtnArea').html(createLoadingBtn());

            //remove existing error messages if any
            clearErrors('#saveErrors');
    
            let formData = new FormData(el);
    
            axios.post(el.action, formData)
                .then(response => {
                    location.reload(true);
                })
                .catch(e => {
                    $('#submitBtnArea').html(createSubmitBtn(el.id));
                    
                    let ul = $('<ul></ul>').addClass('list-unstyled alert alert-danger').attr('id', 'saveErrors');
                    
                    if(e.response.status == 422){

                        let errs = Object.values(e.response.data.errors).reduce((acc, val) =>  acc.concat(val), []);

                        for(let err of errs){
                            let li = $('<li></li>').text(err);
                            ul.append(li);
                        }

                    }else{
                        let li = $('<li></li>').text('An uknown error has occured. Please try again later.');
                        ul.append(li);
                    }

                    $(el).append(ul);

                    ul[0].scrollIntoView();
                });
        }

        function updateTicket(event, el){

            event.preventDefault();

            $('#submitBtnAreaEdit').html(createLoadingBtn());

            //remove existing error messages if any
            clearErrors('#updateErrors');
    
            let formData = new FormData(el);
    
            axios.post(el.action, formData)
                .then(response => {
                    location.reload(true);
                })
                .catch(e => {
                    $('#submitBtnAreaEdit').html(createSubmitBtn(el.id));
                    
                    let ul = $('<ul></ul>').addClass('list-unstyled alert alert-danger').attr('id', 'updateErrors');
                    
                    if(e.response.status == 422){

                        let errs = Object.values(e.response.data.errors).reduce((acc, val) =>  acc.concat(val), []);

                        for(let err of errs){
                            let li = $('<li></li>').text(err);
                            ul.append(li);
                        }

                    }else{
                        let li = $('<li></li>').text('An uknown error has occured. Please try again later.');
                        ul.append(li);
                    }

                    $(el).append(ul);

                    ul[0].scrollIntoView();
                });

        }

        function showTicketPreview(event, el){

            var ticket = $(el).data('ticket');

            $('#viewTicketName').text(ticket.name);
            $('#viewTicketGuests').text(ticket.guests);
            $('#viewTicketPrice').text(ticket.price);
            $('#viewTicketPrice').text(ticket.price_str);
            $('#viewTicketVolume').text(ticket.volume);
            $('#viewTicketSold').text(ticket.quantity_sold);
            $('#viewTicketAvailable').text(ticket.volume - ticket.quantity_sold);
            
            $('#ticketEditBtn').data('ticket', ticket);
            
            $('#viewTicketModal').modal('show');

            if(ticket.quantity_sold){
                $('#viewTicketSalesBtn').removeClass('d-none').attr('href', ticket.sales_page)
            }else{
                $('#viewTicketSalesBtn').addClass('d-none').attr('href', ticket.sales_page)
            }
        }

        function showTicketEditModal(event, el){
            var ticket = $(el).data('ticket');
            
            $('#nameEdit').val(ticket.name);
            $('#guestsEdit').val(ticket.guests);
            $('#volumeEdit').val(ticket.volume);
            $('#priceEdit').val(ticket.price);
            $('#enabledEdit').attr('checked', ticket.enabled);
            $('#editTicketForm').attr('action', ticket.edit_link);

            $('#editTicketModal').modal('show');
        }

        $(document).ready(function(){
            $('#createTicketForm').submit(function(e){
                saveTicket(e, this);
            })

            $('#createTicketModal').on('hide.bs.modal', function(e){
                clearErrors('#saveErrors');
            })

            $('#editTicketForm').submit(function(e){
                updateTicket(e, this);
            });

            $('.view-ticket-row').click(function(e){
                showTicketPreview(e, this);
            })

            $('#ticketEditBtn').click(function(e){
                $('#viewTicketModal').modal('hide');
                showTicketEditModal(e, this);
            })
        })
    </script>
@endsection