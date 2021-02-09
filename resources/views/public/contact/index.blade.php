@extends('public.layout.app')

@section('content')
    <!-- slider Area Start-->
    <div class="slider-area ">
        <!-- Mobile Menu -->
        <div class="single-slider slider-height2  hero-overly d-flex align-items-center" data-background="assets/img/hero/contact_hero.jpg">
            <div class="container">
                <div class="row">
                    <div class="col-xl-12">
                        <div class="hero-cap text-center">
                            <h2>Contact Us</h2>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- slider Area End-->

    <!-- ================ contact section start ================= -->
    <section class="contact-section">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <h2 class="contact-title">Get in Touch</h2>
                </div>
                <div class="col-lg-8">
                    <form class="form-contact contact_form" action="contact_process.php" method="post" id="contactForm" novalidate="novalidate">
                        <div class="row">
                            <div class="col-12">
                                <div class="form-group">
                                    <textarea class="form-control w-100" name="content" id="content" cols="30" rows="9" onfocus="this.placeholder = ''" onblur="this.placeholder = 'Enter Message'" placeholder=" Enter Message"></textarea>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <input class="form-control valid" name="name" id="name" type="text" onfocus="this.placeholder = ''" onblur="this.placeholder = 'Enter your name'" placeholder="Enter your name">
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <input class="form-control valid" name="email" id="email" type="email" onfocus="this.placeholder = ''" onblur="this.placeholder = 'Enter email address'" placeholder="Email">
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-group">
                                    <input class="form-control" name="subject" id="subject" type="text" onfocus="this.placeholder = ''" onblur="this.placeholder = 'Enter Subject'" placeholder="Enter Subject">
                                </div>
                            </div>
                        </div>
                        <div class="form-group mt-3" id="submitBtnArea">
                            <button type="submit" class="button button-contactForm boxed-btn">Send</button>
                        </div>
                    </form>
                </div>
                <div class="col-lg-3 offset-lg-1">
                    <div class="media contact-info">
                        <span class="contact-info__icon"><i class="ti-home"></i></span>
                        <div class="media-body">
                            <p>{{config('app.adrress')}}</p>
                        </div>
                    </div>
                    <div class="media contact-info">
                        <span class="contact-info__icon"><i class="ti-tablet"></i></span>
                        <div class="media-body">
                            <h3>{{config('app.phone')}}</h3>
                            <p>Mon to Fri 9am to 6pm</p>
                        </div>
                    </div>
                    <div class="media contact-info">
                        <span class="contact-info__icon"><i class="ti-email"></i></span>
                        <div class="media-body">
                            <h3>{{config('app.email')}}</h3>
                            <p>Send us your query anytime!</p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="d-none d-sm-block mb-5 pb-4">
                @include('public.about.components.map')
            </div>
        </div>
    </section>
<!-- ================ contact section end ================= -->

<!-- Gift Start -->
@include('public.home._gift')
<!-- Gift End -->

@endsection


@section('scripts')

<script>
    $(function(){
        let createLoadingBtn = function(){
            let loadingBtn = $('<button></button>').addClass('button button-contactForm boxed-btn')
                                                    .attr({disabled: true, type: 'button'})
                                                    .text('wait...');

            let spinner = $('<span></span>').addClass('spinner-border spinner-border-sm mr-2')
                                            .attr({"role": "status", "aria-hidden": "true"});
            
            loadingBtn.prepend(spinner);

            return loadingBtn;
        }

        let createSubmitBtn = function(){
            return $('<button></button>').addClass('button button-contactForm boxed-btn')
                                        .text('Send')
                                        .attr('type', 'submit');
        }
        $('#contactForm').submit(function(e){
            e.preventDefault();

            $('#submitBtnArea').html(createLoadingBtn());

            let formData = new FormData(this);

            try{
                $('#loginErrors').remove();
            }catch(e){}

            axios.post('/contact-message', formData).then(() => {
                location.reload(true);
            }).catch(e => {
                $('#submitBtnArea').html(createSubmitBtn());

                let ul = $('<ul></ul>').addClass('list-unstyled alert alert-danger').attr('id', 'loginErrors');
                
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

                $(this).prepend(ul);
            });;
        });
    })
</script>
@endsection