@extends('public.layout.app')

@section('content')
<main>

    <!-- slider Area Start-->
    <div class="slider-area ">
        <!-- Mobile Menu -->
        <div class="single-slider slider-height2  hero-overly d-flex align-items-center" data-background="assets/img/hero/about_hero.jpg">
            <div class="container">
                <div class="row">
                    <div class="col-xl-12">
                        <div class="hero-cap text-center">
                            <h2>Our Gallery</h2>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- slider End -->

    <!-- our Memories start -->
    @include('public.gallery.components.our-memories')
    <!-- our Memories End-->

</main>
@endsection