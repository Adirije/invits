@extends('public.layout.app')

@section('content')
<main>
    <!-- slider Area Start-->
    <div class="slider-area ">
        <!-- Mobile Menu -->
        <div class="single-slider slider-height2  hero-overly d-flex align-items-center" data-background="/assets/img/hero/about_hero.jpg">
            <div class="container">
                <div class="row">
                    <div class="col-xl-12">
                        <div class="hero-cap text-center">
                            <h2>Our Story</h2>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- slider Area End-->

    <!-- Our Story Start -->
    @include('public.about.components.our-story')
    <!-- Our Story Ende -->
    
    <!-- Gift Start -->
    @include('public.home._gift')
    <!-- Gift End -->

    <!-- our Memories start -->
    @include('public.gallery.components.our-memories')
    <!-- our Memories End-->

    <!-- ================ Map ================= -->
    @include('public.about.components.map')
    <!-- ================ Map ================= -->

    @include('public.about.components.partners')

</main>
@endsection