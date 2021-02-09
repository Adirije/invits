<header>
    <!-- Header Start -->
   <div class="header-area">
        <div class="main-header header-sticky">
            <div class="container">
                <div class="row align-items-center">
                    <!-- Logo -->
                    <div class="col-xl-2 col-lg-2 col-md-2">
                        <div class="logo">
                            <a href="{{ route('public.home') }}"><img src="/assets/img/logo/logo.png" alt=""></a>
                        </div>
                    </div>
                    <div class="col-xl-10 col-lg-10 col-md-10">
                        <!-- Main-menu -->
                        <div class="main-menu f-right d-none d-lg-block">
                            <nav>                              
                                <ul id="navigation">    
                                    <li><a href="{{ route('public.events') }}">Events</a></li>
                                    <li><a href="{{ route('public.gallery') }}">Gallery</a></li>
                                    <li><a href="{{ route('public.about') }}">About</a></li>
                                    <li><a href="{{ route('public.contact.index') }}">contact</a></li>
                                    @auth('admin')
                                        <li><a href="/admin">Admin</a></li>
                                    @endauth
                                </ul>
                            </nav>
                        </div>
                    </div> 
                    <!-- Mobile Menu -->
                    <div class="col-12">
                        <div class="mobile_menu d-block d-lg-none"></div>
                    </div>
                </div>
            </div>
        </div>
   </div>
    <!-- Header End -->
</header>
