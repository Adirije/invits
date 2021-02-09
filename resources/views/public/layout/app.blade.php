<!doctype html>
<html class="no-js" lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="x-ua-compatible" content="ie=edge">
        <title>Wedding HTML-5 Template </title>
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <meta name="description" content="">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <link rel="manifest" href="site.webmanifest">
		<link rel="shortcut icon" type="image/x-icon" href="/assets/img/favicon.ico">

		<!-- CSS here -->
        <link rel="stylesheet" href="/assets/css/bootstrap.min.css">
        <link rel="stylesheet" href="/assets/css/owl.carousel.min.css">
        <link rel="stylesheet" href="/assets/css/flaticon.css">
        <link rel="stylesheet" href="/assets/css/slicknav.css">
        <link rel="stylesheet" href="/assets/css/animate.min.css">
        <link rel="stylesheet" href="/assets/css/magnific-popup.css">
        <link rel="stylesheet" href="/assets/css/fontawesome-all.min.css">
        <link rel="stylesheet" href="/assets/css/themify-icons.css">
        <link rel="stylesheet" href="/assets/css/slick.css">
        <link rel="stylesheet" href="/assets/css/nice-select.css">
        <link rel="stylesheet" href="/assets/css/style.css">
        @include('plugins.pnotify.styles')
        <style>
            body{
                overflow-x: hidden !important;
            }
            .event-link:hover{
                color: var(--dark);
            }
            .pointer{
                cursor: pointer;
            }

            @media (max-width: 767px){
                .testimonial-padding {
                    padding-top:80px;padding-bottom:60px
                }
            }
            .footer-padding{
                padding-top:100px; 
                padding-bottom:74px
            }
            

        </style>

        @yield('styles')
   </head>

   <body>
       
        <!-- Preloader Start -->
        <div id="preloader-active">
            <div class="preloader d-flex align-items-center justify-content-center">
                <div class="preloader-inner position-relative">
                    <div class="preloader-circle"></div>
                    <div class="preloader-img pere-text">
                        <img src="/assets/img/logo/logo.png" alt="">
                    </div>
                </div>
            </div>
        </div>
        <!-- Preloader Start -->

        <x-public-navbar />

        @yield('content')
    
        <footer>
            <!-- Footer Start-->
            <div class="footer-main footer-bg">
                <div class="footer-area footer-padding">
                    <div class="container">
                        <div class="d-flex justify-content-center">
                            <div> <!-- logo -->
                                <div class="footer-logo">
                                    <a href="{{route('public.home')}}"><img src="/assets/img/logo/logo2_footer.png" alt=""></a>
                                </div>
                            </div>
                        </div>
                        <div class="row d-flex justify-content-between">
                            <div class="col-xl-4 col-lg-4 col-md-5 col-sm-8">
                                <div class="single-footer-caption mb-50">
                                    <div class="single-footer-caption">
                                        <div class="footer-tittle">
                                            <div class="footer-pera">
                                                <p class="info2"><i class="fas fa-map-marker"></i> {{config('app.adrress')}}</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-3 col-lg-4 col-md-5 col-sm-7">
                                <div class="single-footer-caption mb-50">
                                    <div class="footer-tittle">
                                        <div class="footer-pera">
                                            <p class="info2"><i class="fas fa-envelope"></i> {{config('app.email')}}</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-2 col-lg-3 col-md-5 col-sm-7">
                                <div class="single-footer-caption mb-50">
                                    <div class="footer-tittle">
                                        <div class="footer-pera">
                                            <p class="info2"><i class="fas fa-phone"></i> {{config('app.phone')}}</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-3 col-lg-3 col-md-5 col-sm-7">
                                <div class="single-footer-caption mb-50">
                                    <div class="footer-tittle">
                                        <div class="footer-pera">
                                            <p class="info2"><i class="fab fa-facebook"></i> <span>@</span>{{config('app.name')}}</p>
                                            <p class="info2"><i class="fab fa-instagram"></i> <span>@</span>{{config('app.name')}}</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- footer-bottom aera -->
                <div class="footer-bottom-area footer-bg">
                    <div class="container">
                        <div class="footer-border">
                            <div class="row d-flex align-items-center">
                                <div class="col-xl-12 ">
                                    <div class="footer-copy-right text-center">
                                        <p>Copyright &copy;<script>document.write(new Date().getFullYear());</script> All rights reserved </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Footer End-->
        </footer>
   
	    <!-- JS here -->
	
		<!-- All JS Custom Plugins Link Here here -->
        <script src="/assets/js/vendor/modernizr-3.5.0.min.js"></script>
		<!-- Jquery, Popper, Bootstrap -->
		<script src="/assets/js/vendor/jquery-1.12.4.min.js"></script>
        <script src="/assets/js/popper.min.js"></script>
        <script src="/assets/js/bootstrap.min.js"></script>
	    <!-- Jquery Mobile Menu -->
        <script src="/assets/js/jquery.slicknav.min.js"></script>

		<!-- Jquery Slick , Owl-Carousel Plugins -->
        <script src="/assets/js/owl.carousel.min.js"></script>
        <script src="/assets/js/slick.min.js"></script>
        <!-- Date Picker -->
        <script src="/assets/js/gijgo.min.js"></script>
		<!-- One Page, Animated-HeadLin -->
        <script src="/assets/js/wow.min.js"></script>
		<script src="/assets/js/animated.headline.js"></script>
        <script src="/assets/js/jquery.magnific-popup.js"></script>

		<!-- Scrollup, nice-select, sticky -->
        <script src="/assets/js/jquery.scrollUp.min.js"></script>
        <script src="/assets/js/jquery.nice-select.min.js"></script>
		<script src="/assets/js/jquery.sticky.js"></script>
        
        <!-- contact js -->
        <script src="/assets/js/contact.js"></script>
        <script src="/assets/js/jquery.form.js"></script>
        <script src="/assets/js/jquery.validate.min.js"></script>
        <script src="/assets/js/mail-script.js"></script>
        <script src="/assets/js/jquery.ajaxchimp.min.js"></script>
        
		<!-- Jquery Plugins, main Jquery -->	
        <script src="/assets/js/plugins.js"></script>
        <script src="/assets/js/main.js"></script>

        @include('plugins.axios')

        @include('plugins.pnotify.scripts')

        @yield('scripts')

        @include('plugins.pnotify.notice')
    </body>
</html>