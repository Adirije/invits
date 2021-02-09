@extends('public.layout.app')

@section('styles')
    <style>
        
    </style>
@endsection

@section('content')
<main>
    <!-- Slider Area Start-->
    <div class="slider-area ">
        <div class="slider-active">
            <div class="single-slider slider-height hero-overly d-flex align-items-center" data-background="{{ $majorEvent->feature_img }}">
                <div class="container">
                    <div class="row d-flex align-items-center">
                        <div class="col-lg-7 col-md-9 ">
                            <div class="hero__caption text-center d-flex align-items-center caption-bg">
                               <div class="circle-caption">
                                    <span data-animation="fadeInUp" data-delay=".3s">{{ $majorEvent->starts->toFormattedDateString() }}</span>
                                    <h1 data-animation="fadeInUp" data-delay=".5s">{{ $majorEvent->name }}</h1>
                                    <p data-animation="fadeInUp" data-delay=".9s">{{ $majorEvent->tagline }}</p>
                               </div>

                            </div>
                            <a class="btn float-right" href="{{ $majorEvent->link }}">Learn More</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Slider Area End-->

    <!-- Our Story Start -->
    @include('public.about.components.our-story')
    <!-- Our Story Ende -->

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

    <!-- our Memories start -->
    @include('public.gallery.components.our-memories')
    <!-- our Memories End-->

    <!-- Gift Start -->
    @include('public.home._gift')
    <!-- Gift End -->

    <!-- ================ Map ================= -->
    @include('public.about.components.map')
    <!-- ================ Map ================= -->
    
    @include('public.about.components.partners')

</main>

@endsection