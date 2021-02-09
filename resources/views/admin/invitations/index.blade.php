@extends('admin.app')

@section('page-header')
<div>
    <i class="fas fa-envelope-open-text"></i>
    <span>Special Invitations</span>
</div>
@endsection

@section('actionBtn')
    @isset($event)
        <div class="d-flex">
            <button data-toggle="modal" data-target="#creataInvitationModal" id="addBtn" class="btn btn-warning mr-2"><i class="fas fa-paper-plane"></i> Send Invitations</button>
        </div>
    @endisset
@endsection


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

    @if (isset($event))
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

        @if (count($event->invitations))
            <div class="card bg-md-white shadow-none shadow">
                <div class="card-body p-0 p-md-3">
                    <table class="table w-100" id="usersTable">
                        <thead>
                            <tr>
                                <th class="d-none d-md-table-cell" style="width: 10px">#</th>
                                <th style="width:200px">Email</th>
                                <th class="d-none d-md-table-cell" style="width:100px">Status</th>
                                <th class="w-sm-100-px w-40-px">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($event->invitations as $i => $invitation)
                                <tr>
                                    <td class="d-none d-md-table-cell">{{ $i + 1 }}</td>
                                    <td>{{ $invitation->email }}</td>
                                    <td class="d-none d-md-table-cell">                                      
                                        @switch($invitation->status)
                                             @case('ok')
                                                <span class="badge badge-success">Registered</span>
                                                @break
                                            @case('pending')
                                                <span class="badge badge-warning">Pending</span>
                                                @break
                                            @default
                                                <span class="badge badge-danger">Declined</span>
                                        @endswitch
                                    </td>
                                    <td>
                                        <button class="btn btn-xs btn-danger __delBtn" data-link={{ $invitation->del_link }} title="delete"><i class="fas fa-trash"></i> Delete</button>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        @else
            <div class="card bg-md-white shadow-none shadow">
                <div class="card-body p-0 p-md-3">
                    <p>No invitations record exists for the chosen event</p>
                </div>
            </div>
        @endif
    @endif
</div>

@endsection

@isset($event)
    @include('admin.invitations.send-invitation-modal')
@endisset

@section('scripts')
<script src="/js/utils.js"></script>
<script>

    (function($){
        function createSubmitLocalBtn(eventInput){

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

                    form.attr('action', '/admin/invitations/events/' +eventId);

                    form.submit()
                });
            }
        }

        $('.j2-select').select2();

        $('#event').on('change', function(e){
            createSubmitLocalBtn(this)
        });

        $('#createInvitationForm').submit(function(e){
            e.preventDefault();

            $('#submitBtnArea').html(createLoadingBtn());

            //remove existing error messages if any
            clearErrors('#saveErrors');

            var formData = new FormData(this);

            axios.post(this.action, formData).then(r => {
                location.reload();
            })
            .catch(e => {
                $('#submitBtnArea').html(createSubmitBtn(this.id));
                
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

                $(this).append(ul);

                ul[0].scrollIntoView();
            });
        })

        $('#usersTable').on( 'draw.dt', function () {
            $('.__delBtn').click(function(e){
                _confirmAction('Are you sure?', 'Expense will be permanently deleted').then(() => {
                    axios.post($(this).data('link'), {}).then(response => {
                        location.reload();
                    })
                })
            })
        } );

        $(document).ready(function(e){
            createSubmitLocalBtn(document.getElementById('event'));

            $('.__delBtn').click(function(e){
                _confirmAction('Are you sure?', 'Expense will be permanently deleted').then(() => {
                    axios.post($(this).data('link'), {}).then(response => {
                        location.reload();
                    })
                })
            })
        })
           
    })(jQuery);

</script>
@endsection