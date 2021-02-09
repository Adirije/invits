<div class="our-memories-area section-padding2">
    <div class="container">
        <!-- section tittle -->
        <div class="row ">
            <div class="col-lg-12">
                <div class="section-tittle text-center">
                    <img src="/assets/img/memories/section_tittle_flowre.png" alt="">
                    <h2>OUR MEMORIES</h2>
                </div>
            </div>
        </div>
        <div class="row no-gutters">
            @foreach ($galleryImages as $galleryImage)
                <div class="col-lg-4 col-md-4">
                    <div class="memory">
                        <div class="memories-img">
                            <img style="width: 389px; height: 481px" src="{{ $galleryImage->img }}" alt="">
                            <div class="menorie-icon" href="{{ $galleryImage->img }}">
                                <i class="ti-plus"></i>
                            </div>
                        </div>
                    </div>
                </div> 
            @endforeach
        </div>
    </div>
    <!-- Shape Img -->
    <div class="memories-shape d-none d-xl-block">
        <img src="/assets/img/memories/left-img.png" class="memories-shape1" alt="">
        <img src="/assets/img/memories/right-img.png" class="memories-shape2" alt="">
    </div>
</div>