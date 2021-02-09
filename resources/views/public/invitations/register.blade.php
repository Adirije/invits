@extends('public.layout.app')

@section('styles')
    <style>
        
    </style>
@endsection

@section('content')
<main>

    <!-- Contact form Start -->
    <div class="contact-form section-padding2 fix">
        <div class="container">
            <div class="row">
                <div class="col-xl-6 col-lg-6 offset-lg-3 offset-xl-3">
                    <div class="form-wrapper">
                         <!-- section tittle -->
                        <div class="row ">
                            <div class="col-lg-12">
                                <div class="section-tittle tittle-form text-center">
                                    <img src="/assets/img/memories/section_tittle_flowre.png" alt="">
                                    <h2>Are you attending?</h2>
                                </div>
                            </div>
                        </div>
                        @if (count($invite->event->tickets))
                            <form id="registerForm" action="{{ route('public.invites.store', ['slug' => $invite->slug]) }}" method="POST">
                                <div class="row">
                                    <div class="col-lg-12">
                                        <div class="form-box mb-30">
                                            <input type="text" name="firstName" id="firstName" placeholder="First Name">
                                        </div>
                                    </div>
                                    <div class="col-lg-12">
                                        <div class="form-box subject-icon mb-30">
                                            <input type="text" name="lastName" id="lastName" placeholder="Last Name">
                                        </div>
                                    </div>
                                    <div class="col-lg-12">
                                        <div class="form-box subject-icon mb-30">
                                            <input class="form-control-plaintext" readonly  type="email" name="email" placeholder="Email" value="{{ $invite->email }}">
                                        </div>
                                    </div>
                                    <div class="col-lg-12">
                                        <div class="form-box subject-icon mb-30">
                                            <input type="tel" name="phone" id="phone" placeholder="Phone (Optional)">
                                        </div>
                                    </div>
                                    <div class="col-lg-12 mb-30">
                                        <div class="select-itms">
                                            <select name="ticket" id="ticket">
                                                <option value="">-- Choose Ticket --</option>
                                                @foreach ($invite->event->activeTickets() as $ticket)
                                                    <option value="{{$ticket->id}}">{{$ticket->name}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-lg-12">
                                        <div class="submit-info" id="submitBtnArea">
                                            <button class="btn2 w-100" type="submit" id="payBtn">R.S.V.P</button>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        @else
                            <form id="registerFormFree" action="{{ route('public.invites.store', ['slug' => $invite->slug]) }}" method="POST">
                                <div class="row">
                                    <div class="col-lg-12">
                                        <div class="form-box mb-30">
                                            <input type="text" name="firstName" id="firstName" placeholder="First Name">
                                        </div>
                                    </div>
                                    <div class="col-lg-12">
                                        <div class="form-box subject-icon mb-30">
                                            <input type="text" name="lastName" id="lastName" placeholder="Last Name">
                                        </div>
                                    </div>
                                    <div class="col-lg-12">
                                        <div class="form-box subject-icon mb-30">
                                            <input class="form-control-plaintext" readonly  type="email" name="email" placeholder="Email" value="{{ $invite->email }}">
                                        </div>
                                    </div>
                                    <div class="col-lg-12">
                                        <div class="form-box subject-icon mb-30">
                                            <input type="tel" name="phone" id="phone" placeholder="Phone (Optional)">
                                        </div>
                                    </div>
                                    <div class="col-lg-12">
                                        <div class="submit-info" id="submitBtnArea">
                                            <button class="btn2 w-100" type="submit" id="payBtn">R.S.V.P</button>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        @endif

                        <!-- Shape inner Flower -->
                        <div class="shape-inner-flower">
                            <img src="/assets/img/flower/form-smoll-left.png" class="top1" alt="">
                            <img src="/assets/img/flower/form-smoll-right.png" class="top2" alt="">
                            <img src="/assets/img/flower/form-smoll-b-left.png"class="top3"  alt="">
                            <img src="/assets/img/flower/form-smoll-b-right.png"class="top4"  alt="">
                        </div>
                        <!-- Shape outer Flower -->
                        <div class="shape-outer-flower">
                            <img src="/assets/img/flower/from-top.png" class="outer-top" alt="">
                            <img src="/assets/img/flower/from-bottom.png" class="outer-bottom" alt="">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Contact form End -->

    <!-- ================ Map ================= -->
    <section class="contact-sections">
        <div class="d-area">
            <div id="map" style="height: 500px; position: relative; overflow: hidden;"></div>
            <script>
                function initMap() {
                    var uluru = {
                        lat: -25.363,
                        lng: 131.044
                    };
                    var grayStyles = [{
                            featureType: "all",
                            stylers: [{
                                    saturation: -90
                                },
                                {
                                    lightness: 50
                                }
                            ]
                        },
                        {
                            elementType: 'labels.text.fill',
                            stylers: [{
                                color: '#ccdee9'
                            }]
                        }
                    ];
                    var map = new google.maps.Map(document.getElementById('map'), {
                        center: {
                            lat: -31.197,
                            lng: 150.744
                        },
                        zoom: 9,
                        styles: grayStyles,
                        scrollwheel: false
                    });
                }
            </script>
            <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDpfS1oRGreGSBU5HHjMmQ3o5NLw7VdJ6I&amp;callback=initMap">
            </script>
        </div>
    </section>
     <!-- ================ Map ================= -->

     <div class="brand-area section-padding2">
        <div class="container">
             <!-- section tittle -->
             <div class="row ">
                <div class="col-lg-12">
                    <div class="section-tittle text-center">
                        <img src="/assets/img/memories/section_tittle_flowre.png" alt="">
                        <h2>OUR LOVELY PARTNERS</h2>
                    </div>
                </div>
            </div>
            <div class="brand-active brand-border">
                <div class="single-brand">
                    <img src="/assets/img/service/brand1.jpg" alt="">
                </div>
                <div class="single-brand">
                    <img src="/assets/img/service/brand2.jpg" alt="">
                </div>
                <div class="single-brand">
                    <img src="/assets/img/service/brand3.jpg" alt="">
                </div>
                <div class="single-brand">
                    <img src="/assets/img/service/brand4.jpg" alt="">
                </div>
                <div class="single-brand">
                    <img src="/assets/img/service/brand5.jpg" alt="">
                </div>
                <div class="single-brand">
                    <img src="/assets/img/service/brand3.jpg" alt="">
                </div>
            </div>
        </div>
    </div>

</main>

@endsection

@section('scripts')
<script src="https://js.paystack.co/v1/inline.js"></script> 
<script>
    axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';
    axios.defaults.headers.common['X-CSRF-TOKEN'] = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
</script>

<script>
    (function($){
        var invite = JSON.parse("{!! addslashes(json_encode($invite)) !!}");
        var tickets = JSON.parse("{!! addslashes(json_encode($invite->event->activeTickets())) !!}");
        var ticket = null;

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
            return $('<button></button>').addClass('btn2 w-100')
                                        .attr({type: 'submit', id: 'payBtn'})
                                        .text('R.S.V.P');
        }

        function findTicket(id){
            ticket = Object.values(tickets).find(t => t.id == id)
        }

        $('#registerFormFree').submit(function(e){
            e.preventDefault();

            $('#saveErrors').remove();

            $('#submitBtnArea').html(createLoadingBtn());

            var formData = new FormData(this);

            axios.post(this.action, formData).then(response => {
                window.location = response.data.url;
            }).catch(e => {
                let ul = $('<ul></ul>').addClass('list-unstyled alert alert-danger mt-3').attr('id', 'saveErrors');
                
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

                // ul[0].scrollIntoView();
            }).finally(() => {
                $('#submitBtnArea').html(createSubmitBtn());
            });
        });

        $('#registerForm').submit(function(e){
            e.preventDefault();

            $('#saveErrors').remove();

            $('#submitBtnArea').html(createLoadingBtn());

            var formData = new FormData(this);

            axios.post(this.action, formData).then(response => {
                var handler = PaystackPop.setup({
                    email: invite.email, 
    
                    key: 'pk_test_66a2631328f1f70e9639f85d28b7be50a5eb3513',
    
                    amount: parseFloat(ticket.price) * 100, // the amount value is multiplied by 100 to convert to the lowest currency unit
    
                    currency: 'NGN',
    
                    callback: function(response) {
    
                        // Make an AJAX call to your server with the reference to verify the transaction
                        const url = '/payments/verify-invite/' + response.reference;

                        formData.append('invite', invite.slug)

                        axios.post(url, formData).then(response => {
                            window.location = response.data.url;
                        }).catch(e => {
                            //
                        }).finally(() => {
                            $('#submitBtnArea').html(createSubmitBtn());
                        });
    
                    },
    
                    onClose: function() {
                        $('#submitBtnArea').html(createSubmitBtn());
                    },
                });
            
                handler.openIframe();

            }).catch(e => {
                $('#submitBtnArea').html(createSubmitBtn());
                
                let ul = $('<ul></ul>').addClass('list-unstyled alert alert-danger mt-3').attr('id', 'saveErrors');
                
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

                // ul[0].scrollIntoView();
            });
            
        })

        $('#ticket').on('change', function(e){
            findTicket(e.target.value)
        })

        $(document).ready(function(e){
            try{
                var ticketId = document.getElementById('ticket').value;
                if(ticketId){
                    findTicket(ticketId) 
                }
            }catch(e){}
        });
    })(jQuery)
</script>

@endsection 