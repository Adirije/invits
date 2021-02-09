@extends('public.layout.app')

@section('content')
<main>
   <!-- slider Area Start-->
   <div class="slider-area ">
      <!-- Mobile Menu -->
      <div class="single-slider slider-height2  hero-overly d-flex align-items-center"
         data-background="/assets/img/hero/about_hero.jpg">
         <div class="container">
            <div class="row">
               <div class="col-xl-12">
                  <div class="hero-cap text-center">
                     <h2>{{ $event->name }}</h2>
                  </div>
               </div>
            </div>
         </div>
      </div>
   </div>

   <!--================Blog Area =================-->
   <section class="blog_area single-post-area section-padding">
      <div class="container">
         <div class="row">
            <div class="col-lg-8 posts-list">
               <div class="single-post">
                  <div class="feature-img">
                     <img class="img-fluid" src="{{ $event->feature_img }}" alt="">
                  </div>
                  <div class="blog_details">
                     <h2>{{ $event->name }}</h2>
                     <ul class="blog-info-link mt-3 mb-4">
                        <li><a href="#"><i class="fa fa-calendar-alt"></i> {{ $event->starts->toDayDateTimeString() }}</a></li>
                        <li><a href="#"><i class="fa fa-calendar-check"></i> {{ $event->ends->toDayDateTimeString() }}</a></li>
                     </ul>

                     <div class="quote-wrapper">
                        <div class="quotes">
                           {{ $event->tagline }}
                        </div>
                     </div>

                     <div class="excert">
                        {!! $event->desc !!}
                     </div>
                  </div>
               </div>
               
               <div class="blog-author">
                  <div class="media align-items-center">
                     <img src="/assets/img/blog/author.png" alt="">
                     <div class="media-body">
                        <a href="#">
                           <h4>{{ $event->client->name }}</h4>
                        </a>
                        @if ($event->client->about)
                           <div id="clientAbout"></div> 
                        @else
                           <p>This organiser has no public information</p>
                        @endif
                     </div>
                  </div>
               </div>
            </div>
            <div class="col-lg-4">
               <div class="blog_right_sidebar">
                  <aside class="single_sidebar_widget search_widget">
                     @if ($event->type == 'open')
                        @if (count($event->tickets))
                           @if (count($event->activeTickets()) > 1)
                              <p>Starting  at:</p>
                           @endif
                           <h3 class="text-success font-weight-bold">&#8358; {{ $event->cheapest_ticket_price }}</h3>
                           <button id="getTicketBtn" class="button rounded-0 mt-3 primary-bg text-white w-100 btn_1 boxed-btn"
                              type="submit">Get Tickets</button>
                        @else
                           <h3 class="text-success font-weight-bold">Free</h3>
                           <button id="registerBtn" data-toggle="modal" data-target="#createGuestModal" class="button rounded-0 mt-3 primary-bg text-white w-100 btn_1 boxed-btn"
                              type="submit">Register</button>
                              @endif
                        @else
                           <button id="registerBtn" class="button rounded-0 mt-3 primary-bg text-white w-100 btn_1 boxed-btn" type="submit">
                              Registration is by Invitation Only
                           </button>
                     @endif
                  </aside>
               </div>
            </div>
         </div>
      </div>
   </section>
   <!--================ Blog Area end =================-->
</main>

@include('public.events._register-guest-modal')
@endsection

@section('scripts')
   <script src="/js/utils.js"></script>
   <script>
      var event = JSON.parse("{!! addslashes(json_encode($event)) !!}");

      $(document).ready(function(){
         $('#clientAbout').html(preserveLineBreaks(event.client.about))

         $('#getTicketBtn').click(function(){
            location = "{{ route('public.tickets.initCheckout', ['slug' => $event->slug]) }}";
         })

         $('#createGuestForm').submit(function(e)
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

               location = response.data.url;

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
      })
   </script>
@endsection