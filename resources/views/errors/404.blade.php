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
                                    <h2>We are sorry you got here!</h2>
                                </div>
                            </div>
                        </div>
                        
                        <div>
                            <p>
                                The page or resource your are trying to access may have been moved or does not exist.
                            </p>
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="submit-info" id="submitBtnArea">
                                        <a href="{{ route('public.home') }}" class="btn2 w-100 text-center">Go Home</a>
                                    </div>
                                </div>
                            </div>
                        </div>

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