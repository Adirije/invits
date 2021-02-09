@extends('admin.app')

@section('page-header', 'Check-in Guests')

@section('actionBtn')
<div class="d-flex">
    <a href="{{  route('admin.checkins', ['id' => $event->id]) }}" id="addBtn" class="btn btn-warning"><i class="fas fa-eye"></i> View Check-ins</a>
</div>
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
    <div class="card bg-md-white shadow-none shadow mb-3">
        <div class="card-body p-0 p-md-3">
            <div class="row">
                <div class="col-6">
                    <h4>Event Information</h4>
                    <div><span class="text-muted">Name:</span> {{ $event->name }}</div>
                    <div><span class="text-muted">Location:</span> {{ $event->location->address }}</div>
                </div>
                <div class="col-6">
                    <h4>Check-in Summary</h4>
                    <div><span class="text-muted">Registered:</span> {{ $event->registrations()->count() }}</div>
                    <div><span class="text-muted">Checked-in:</span> {{ $event->checkIns()->count() }}</div>
                </div>
            </div>
        </div>
    </div>

    <div class="card bg-md-white shadow-none shadow mb-3">
        <div class="card-body p-0 p-md-3">
            <div class="d-flex justify-content-between align-items-baseline mb-3">
                <h4>Pass Code</h4>
                <button data-toggle="modal" data-target="#createGuestModal" class="btn btn-success" type="button"><i class="fas fa-plus"></i> Add</button>
            </div>
            <select class="j2-select custom-select" name="code" id="checkinCode" required form="checkinForm">
                <option value="">-- choose pass code --</option>
                @foreach ($registrations as $reg)
                    <option value="{{ $reg->checkin_code }}">{{ $reg->checkin_code }}</option>
                @endforeach
            </select>
        </div>
    </div>

    <div class="card bg-md-white shadow-none shadow mb-3">
        <div class="card-body p-0 p-md-3">
            <h4>Guest Information</h4>
            <form class="needs-validation" novalidate id="checkinForm" action="{{ route('admin.checkins.store') }}">
                @csrf
                <div id="checkinFormControls" class="d-none">
                    <div class="row">
                       <div class="col-md-6 mb-3">
                           <label for="firstName">First name</label>
                           <input type="text" name="firstname" class="form-control" id="firstName" placeholder="" required>
                           <div class="invalid-feedback">
                               Valid first name is required.
                           </div>
                       </div>

                       <div class="col-md-6 mb-3">
                           <label for="lastName">Last name</label>
                           <input type="text" name="lastname" class="form-control" id="lastName" placeholder="" required>
                           <div class="invalid-feedback">
                               Valid last name is required.
                           </div>
                       </div>

                       <div class="col-md-6 mb-4">
                          <label for="email">Email</label>
                          <input type="email" name="email" class="form-control" id="email" placeholder="you@example.com">
                          <div class="invalid-feedback">
                              Please enter a valid email address.
                          </div>
                      </div>

                       <div class="col-md-6 mb-4">
                            <label for="phone">Phone</label>
                            <input type="tel" name="phone" class="form-control" id="phone" placeholder="">
                        </div>
                    </div>
                </div>
               <button id="checkinBtn" class="btn btn-primary btn-lg btn-block" disabled type="submit">Check In</button>
           </form>
        </div>
    </div>
</div>
@if (count($event->tickets))
    @include('admin.checkins.components.new-guest-modal')
@else
    @include('admin.checkins.components.new-guest-modal-free')
@endif
@endsection

@section('scripts')
<script src="/js/utils.js"></script>

<script>

    (function($){
        var event = null;

        try {
            event = document.getElementById('event').value;
        } catch (error) {}

        var selectedTicket = null;
        var fomartter = new Intl.NumberFormat("en-NG", {
            style: "currency",
            currency: "NGN",
            minimumFractionDigits: 2,
            currencyDisplay: "symbol",
        });

        var tickets = JSON.parse("{!! addslashes(json_encode($event->activeTickets())) !!}")

        function createOnlineLoadingBtn(){
            let loadingBtn = $('<button></button>').addClass('btn btn-primary btn-lg btn-block')
                                                    .attr({disabled: true, type: 'button', id: 'ldnBtn'})
                                                    .text('wait...');

            let spinner = $('<span></span>').addClass('spinner-border spinner-border-sm mr-2')
                                            .attr({"role": "status", "aria-hidden": "true"});
            
            loadingBtn.prepend(spinner);

            return loadingBtn;
        }

        function createOnlineSubmitBtn(){
            return $('<button></button>').addClass('btn btn-primary btn-lg btn-block')
                                        .attr({type: 'submit', id: 'checkinBtn'})
                                        .text('Check In');
        }

        $('#usersTable').DataTable();
        $('.j2-select').select2();

        $('#checkinCode').on('change', function(e){

            if(! this.value){
                $('#checkinFormControls').addClass('d-none');
                $('#checkinBtn').attr('disabled', true);

                $('#firstName').val('');
                $('#lastName').val('');
                $('#email').val('');
                $('#phone').val('');

                return;
            }

            $('#checkinForm').append(createOnlineLoadingBtn());

            $('#checkinBtn').remove();

            axios.get('/admin/checkins/verifycode/' + this.value).then(response => {
                $('#checkinFormControls').removeClass('d-none');
                $('#checkinBtn').attr('disabled', false);

                $('#firstName').val(response.data.firstname)
                $('#lastName').val(response.data.lastname)
                $('#email').val(response.data.email)
                $('#phone').val(response.data.phone)

            }).catch(e => {
                if(e.response.status == 404){

                    PNotify.error({
                        title: 'Oh No!',
                        text: 'The client may have been deleted already.'
                    });

                    setTimeout(() => {
                        location.reload(true);
                    }, 2000);

                    return;
                }

                if(e.response.status == 422){
                    PNotify.error({
                        title: 'Rejected!',
                        text: 'The guest has already been checked in.'
                    });
                }

                PNotify.error({
                    title: 'Oh No!',
                    text: 'An unknown error has occured. Please try again later'
                });
            }).finally(() => {
                $('#ldnBtn').remove()
                $('#checkinForm').append(createOnlineSubmitBtn());
            })
        })
            
        $('#checkinForm').submit(function(e){
            e.preventDefault();

            if(! this.phone.value && !this.email.value){
                PNotify.error({
                    title: 'Invalid details!',
                    text: 'The email or phone is required'
                });

                return;
            }

            if(!this.code.value){
                PNotify.error({
                    title: 'Invalid details!',
                    text: 'The check in code is required'
                });

                return;
            }

            $('#checkinBtn').remove();
            $(this).append(createOnlineLoadingBtn());

            var formData = new FormData(this);

            formData.append('event', event);

            axios.post(this.action, formData).then(response => {
                location.reload();
            }).catch(e => {
                $('#ldnBtn').remove()
                $('#checkinForm').append(createOnlineSubmitBtn());
            })
        });

        //free guest
        $('#createFreeGuestForm').submit(function(e)
        {
            e.preventDefault();
            
            if(! this.phone.value && !this.email.value){
                PNotify.error({
                    title: 'Invalid details!',
                    text: 'The email or phone is required'
                });
                
                return;
            }

            var formData = new FormData(this);
            
            $('#submitBtnArea').html(createLoadingBtn());

            clearErrors('#saveErrors');

            axios.post(this.action, formData)
            .then(response => {

               window.location = response.data.url;

               $('#submitBtnArea').html(createSubmitBtn(this.id));

               $('#createGuestModal').modal('hide');
                
               PNotify.success({
                  title: 'Done!',
                  text: 'Your registration has been created successfully. Please print your ticket.'
               });
            })
            .catch(e => {
               $('#submitBtnArea').html(createSubmitBtn(this.id));
                     
               let ul = $('<ul></ul>').addClass('list-unstyled alert alert-danger').attr('id', 'saveErrors');
                
               if(! e.response){
                  var li = $('<li></li>').text('An uknown error has occured. Please try again later.' + e);
                  console.log(e);
                  ul.append(li);

               }else if(e.response.status == 422){

                  let errs = Object.values(e.response.data.errors).reduce((acc, val) =>  acc.concat(val), []);

                  for(let err of errs){
                     ul.append($('<li></li>').text(err));
                  }

               }else{
                  var li = $('<li></li>').text('An uknown error has occured. Please try again later.');
                  ul.append(li);
               }

               $(this).append(ul);

               $('#createGuestModal').modal('handleUpdate');
               
               ul[0].scrollIntoView();
            })
         })


        //paid guest
        $('#createGuestForm').submit(function(e)
        {
            e.preventDefault();

            if(!selectedTicket){
                PNotify.error({
                    title: 'Invalid details!',
                    text: 'No ticket chosen'
                });
                
                return;
            }

            var amount = parseFloat(this.amount.value);

            if(amount < selectedTicket.price){
                PNotify.error({
                    title: 'Invalid details!',
                    text: 'The amount entered is lower than the price of the ticket chosen.'
                });
                
                return;
            }
            
            if(! this.phone.value && !this.email.value){
                PNotify.error({
                    title: 'Invalid details!',
                    text: 'The email or phone is required'
                });
                
                return;
            }

            var formData = new FormData(this);
            
            $('#submitBtnArea').html(createLoadingBtn());

            clearErrors('#saveErrors');

            axios.post('/admin/checkin/offline', formData)
            .then(response => {

                location = response.data.url;

                $('#submitBtnArea').html(createSubmitBtn(this.id));
                $('#createGuestModal').modal('hide');
                
                if(selectedTicket.guests > 1){
                    PNotify.success({
                        title: 'Done!',
                        text: 'The first guest has been checked in. Once the ticket has been generated, refresh the page and check in other guests'
                    });

                }else{
                    PNotify.success({
                        title: 'Done!',
                        text: 'The first guest has been checked in successfuly.'
                    });
                }

            })
            .catch(e => {
                $('#submitBtnArea').html(createSubmitBtn(this.id));
                        
                let ul = $('<ul></ul>').addClass('list-unstyled alert alert-danger').attr('id', 'saveErrors');
                
                if(e.response.status == 422){

                    let errs = Object.values(e.response.data.errors).reduce((acc, val) =>  acc.concat(val), []);

                    for(let err of errs){
                        ul.append($('<li></li>').text(err));
                    }

                }else{
                    var li = $('<li></li>').text('An uknown error has occured. Please try again later.');
                    ul.append(li);
                }

                $(this).append(ul);

                $('#createGuestModal').modal('handleUpdate');
                
                ul[0].scrollIntoView();
            })
        })

        $('#createGuestModal').on('shown.bs.modal', function(e){
            $('.j2-select2').select2();
            
            var ticket = null;
            
            try {
                ticket = document.getElementById('ticket').value;
            } catch (e) {}

            if(ticket){
                selectedTicket = tickets.find(t => t.id == ticket);
                
                $('#amount').attr('min', selectedTicket.price);
                $('#min').text('Minimum: ' + fomartter.format(selectedTicket.price))
            }
            
        });

        $('#ticket').on('change', function(e){
            if(this.value){
                selectedTicket = tickets.find(ticket => ticket.id == this.value);
                $('#amount').attr('min', selectedTicket.price).val(selectedTicket.price)
                $('#min').text('Minimum: ' + fomartter.format(selectedTicket.price))
            }else{
                selectedTicket = null;
                $('#amount').attr('min', 0).val('');
                $('#min').text('');
            }
        });
           
    })(jQuery);

</script>
@endsection