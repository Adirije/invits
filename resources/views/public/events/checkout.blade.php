@extends('public.layout.app')

@section('styles')
    <style>
        .bd-placeholder-img {
            font-size: 1.125rem;
            text-anchor: middle;
            -webkit-user-select: none;
            -moz-user-select: none;
            -ms-user-select: none;
            user-select: none;
        }

        @media (min-width: 768px) {
            .bd-placeholder-img-lg {
            font-size: 3.5rem;
            }
        }
        .container {
            max-width: 960px;
        }

        .lh-condensed { line-height: 1.25; }
    </style>
    
@endsection
 @section('content')
    <div class="container">
       <div class="py-5 text-center">
           <img class="d-block mx-auto mb-4" src="{{ $event->feature_img }}" width="72" height="72">
           <h2>{{ $event->name }}</h2>
           <p class="lead">Get Tickets</p>
       </div>

       <div class="row">
           <div class="col-md-4 order-md-2 mb-4">
               <h4 class="d-flex justify-content-between align-items-center mb-3">
                   <span class="text-muted">Your cart</span>
                   <span class="badge badge-secondary badge-pill" id="ticketCount">0</span>
               </h4>
               <ul class="list-group mb-3" id="cartView">
                   <li class="list-group-item d-flex justify-content-between">
                       <span>Total (USD)</span>
                       <strong>@naira(0)</strong>
                   </li>
               </ul>
           </div>

           <div class="col-md-8 order-md-1">
                <h4 class="mb-3">Available Tickets</h4>
                <ul class="list-group mb-5">
                    @foreach ($event->activeTickets() as $idx => $ticket)
                        <li class="list-group-item d-flex justify-content-between lh-condensed">
                            <div>
                                <h6 class="mb-3">{{$ticket->name}}</h6>
                                <small class="text-muted d-block">Guests: {{$ticket->guests}}</small>
                                <small class="text-muted d-block">Available: {{ $ticket->volume - $ticket->quantity_sold}}</small>
                            </div>
                            <div>
                                <div class="text-success">@naira($ticket->price)</div>
                                <div class="input-group mt-3 input-group-sm">
                                    <div class="input-group-prepend">
                                        <button data-quantity="quantity-{{ $idx }}" class="input-group-text pointer __subBtn"><i class="fas fa-minus"></i></button>
                                    </div>
                                    <input data-ticket-id="{{ $ticket->id }}" id="quantity-{{ $idx }}" type="number" class="form-control __ticketQuantity" style="width: 100px" placeholder="Quantity" aria-label="quantity to purchase">
                                    <div class="input-group-append">
                                      <button data-quantity="quantity-{{ $idx }}" class="input-group-text pointer __addBtn"><i class="fas fa-plus"></i></button>
                                    </div>
                                </div>
                            </div>
                        </li>
                    @endforeach
                </ul>

               <h4 class="mb-3">Your Information</h4>
               <form class="needs-validation" novalidate id="checkoutForm">
                    <input type="hidden" name="event" id="event" value="{{ $event->id }}">
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
                    </div>

                    <div class="mb-3">
                       <label for="email">Email</label>
                       <input type="email" name="email" class="form-control" id="email" placeholder="you@example.com" required>
                       <div class="invalid-feedback">
                           Please enter a valid email address.
                       </div>
                       <small>We'll email your ticket to this address.</small>
                   </div>

                   <hr class="mb-4">
                   <button id="payBtn" class="btn btn-primary btn-lg btn-block" type="submit">Continue to checkout</button>
               </form>
           </div>
       </div>

       <footer class="my-5 pt-5 text-muted text-center text-small">
           <p class="mb-1">&copy; 2017-2019 Company Name</p>
           <ul class="list-inline">
               <li class="list-inline-item"><a href="checkout.htm#">Privacy</a></li>
               <li class="list-inline-item"><a href="checkout.htm#">Terms</a></li>
               <li class="list-inline-item"><a href="checkout.htm#">Support</a></li>
           </ul>
       </footer>
   </div>
     
 @endsection

@section('scripts')
<script src="/js/checkout-validation.js"></script>
<script src="https://js.paystack.co/v1/inline.js"></script> 

<script>
    axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';
    axios.defaults.headers.common['X-CSRF-TOKEN'] = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
    axios.interceptors.response.use(
    response => {
        return response;
    },

    error => {

        if(error.response){

            if(error.response.status == 419){
                const refreshFromServer = true;
    
                window.location.reload(refreshFromServer);
            }
        }

        return Promise.reject(error);
    }
)
    function createLoadingBtn(){
        let loadingBtn = $('<button></button>').addClass('btn btn-primary btn-lg btn-block')
                                                .attr({disabled: true, type: 'button', id: 'ldnBtn'})
                                                .text('wait...');

        let spinner = $('<span></span>').addClass('spinner-border spinner-border-sm mr-2')
                                        .attr({"role": "status", "aria-hidden": "true"});
        
        loadingBtn.prepend(spinner);

        return loadingBtn;
    }

    function createSubmitBtn(){
        return $('<button></button>').addClass('btn btn-primary btn-lg btn-block')
                                    .attr({type: 'submit', id: 'payBtn'})
                                    .text('Continue to checkout');
    }

</script>

    <script>
        (function(){
            var tickets = JSON.parse("{!! addslashes(json_encode($event->activeTickets())) !!}");
            var cart = [];
            var totalCost = 0;
            var event = document.getElementById('event').value;
            var fomartter = new Intl.NumberFormat("en-NG", {
                style: "currency",
                currency: "NGN",
                minimumFractionDigits: 2,
                currencyDisplay: "symbol",
            });

            function addToCart(ticket, quantity){
            
                if(isNaN(quantity) || quantity === -0){
                    return;
                }

                var storedTicketIdx = cart.reduce((acc, val) => acc.concat(val.id), [])
                                        .indexOf(ticket.id);

                if(storedTicketIdx !== -1){
                    cart[storedTicketIdx].quantity = (cart[storedTicketIdx].quantity + quantity < 0) ? 0 : cart[storedTicketIdx].quantity + quantity;
                    cart[storedTicketIdx].totalCost = cart[storedTicketIdx].quantity *  cart[storedTicketIdx].price;
                    
                    if(cart[storedTicketIdx].quantity == 0){
                        cart.splice(storedTicketIdx, 1)
                    }
                }else{
                    ticket.quantity = (quantity < 0) ? 0 : quantity;
                    ticket.totalCost = ticket.price * ticket.quantity
                    if(ticket.quantity > 0){
                        cart.push(ticket);
                    }
                }

                updateCartView();
            }

            function updateCartView()
            {
                $('#cartView').html('');

                totalCost = 0;

                cart.forEach(ticket => {
                    var li = $('<li />').addClass('list-group-item d-flex justify-content-between lh-condensed')
                    
                    var h6 = $('<h6 />').addClass('my-0').text(ticket.name);
                    var small = $('<small />').addClass('text-muted').text('Guests: ' + ticket.guests + ' X ' + ticket.quantity)
                    var span = $('<span />').addClass('text-muted').text(fomartter.format(ticket.price) + ' X ' + ticket.quantity)
                    
                    var div = $('<div />')

                    div.append(h6);
                    div.append(small);

                    li.append(div);
                    li.append(span);

                    $('#cartView').append(li)

                    totalCost += ticket.totalCost;
                });

                var li = $('<li />').addClass('list-group-item d-flex justify-content-between lh-condensed')
                var payBtn = document.getElementById('payBtn')
                var span = $('<span />').text('Total (NGN)');
                var strong = $('<strong />').text(fomartter.format(totalCost));

                li.append(span);
                li.append(strong);

                $('#ticketCount').text(cart.length);

                $('#cartView').append(li)

                payBtn.disabled = false;
                payBtn.classList.remove('d-none');

                if(cart.length < 1){
                    payBtn.disabled = true;
                    payBtn.classList.add('d-none');
                }
            }
            

            $('.__addBtn').click(function(e){
                var quantityId = $(this).data('quantity');
                var quantity = parseInt($('#' + quantityId).val());
                var ticketId = $('#' + quantityId).data('ticketId');
                var ticket = tickets.find(t => t.id == ticketId);
                
                addToCart(ticket, quantity);
            });

            $('.__subBtn').click(function(e){
                var quantityId = $(this).data('quantity');
                var quantity = $('#' + quantityId).val();
                var ticketId = $('#' + quantityId).data('ticketId');
                var ticket = tickets.find(t => t.id == ticketId);

                addToCart(ticket, -quantity);
            });

            $(document).ready(function(){
                updateCartView();
            })

            $('#checkoutForm').submit(function(e){
                e.preventDefault();
                
                var guest = {};

                guest.email = document.getElementById('email').value;
                guest.firstname = document.getElementById('firstName').value;
                guest.lastname = document.getElementById('lastName').value;

                if(!guest.email || !guest.firstname || !guest.lastname){
                    return;
                }

                $('#payBtn').remove();

                $(this).append(createLoadingBtn());
                
                axios.post("{{route('public.events.initPayment')}}", {guest, cart})
                    .then( response => {
                        guest = response.data;

                        var handler = PaystackPop.setup({
                            email: guest.slug + "@" + window.location.hostname, 
        
                            key: 'pk_test_66a2631328f1f70e9639f85d28b7be50a5eb3513',
        
                            amount: totalCost * 100, // the amount value is multiplied by 100 to convert to the lowest currency unit
        
                            currency: 'NGN',
        
                            callback: function(response) {
        
                                // Make an AJAX call to your server with the reference to verify the transaction
                                const url = '/payments/verify/' + response.reference;
        
                                axios.post(url, {cart, guest, totalCost, event}).then(response => {
                                    window.location = response.data.url;
                                }).catch(e => {
                                    console.log(e)
                                });
        
                            },
        
                            onClose: function() {
                                // alert('Transaction was not completed, window closed.');
                            },
                        });
                    
                        handler.openIframe();
                }).catch(e => {
                    console.log(e.response)
                    if(e.response.status == 422){
                        PNotify.error({
                            title: 'Attention!',
                            text: 'Some tickets in your cart have been sold out. You may refresh the page to show the latest available tickets.'
                        });
                        
                        return;
                    }
                }).finally(() => {
                    $('#ldnBtn').remove();
                    $(this).append(createSubmitBtn());
                })

            })
        })()

    </script>
@endsection
