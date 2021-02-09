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
                            <h2>Events</h2>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- slider Area End-->
    <!-- Services Area Start-->
    <div class="service-area ">
        <div class="container">
            <div class="row">
                @foreach ($events as $event)
                    <div class="col-lg-4">
                        <x-event-entry :event="$event" />
                    </div>
                @endforeach
            </div>
         </div>
    </div>
    <!-- Services Area End-->

    <!-- ================ Map ================= -->
    @include('public.about.components.map')
    <!-- ================ Map ================= -->
    

</main>
@endsection