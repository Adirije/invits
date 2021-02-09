<!-- Main Sidebar Container -->

@php
    $activeRoute = explode('.', Route::currentRouteName());
@endphp


<aside class="main-sidebar sidebar-dark-info elevation-4">
    <!-- Brand Logo -->
    <a href="#" class="brand-link" style="font-size: 1.5rem">
        <span class="brand-text font-weight-bold">{{ config('app.name') }}</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column nav-flat" data-widget="treeview" role="menu" data-accordion="false">


                {{-- <li class="nav-item">
                    <a href="{{ route('admin.events.index') }}" class="nav-link">
                        <i class="nav-icon fas fa-users"></i>
                        <p>Events</p>
                    </a>
                </li> --}}

                <li class="nav-item ">
                    <a href="{{ route('admin.events.index') }}" class="nav-link {{ $activeRoute[1] == 'events' ? 'active' : '' }}">
                        <i class="nav-icon fas fa-comments"></i>
                        <p>Events</p>
                    </a>
                </li>

                <li class="nav-item ">
                    <a href="{{ route('admin.locations.index') }}" class="nav-link {{ Route::currentRouteName() == 'admin.locations.index' ? 'active' : '' }}">
                        <i class="nav-icon fas fa-map-marker-alt"></i>
                        <p>Locations (Venues)</p>
                    </a>
                </li>

                <li class="nav-item ">
                    <a href="{{ route('admin.clients.index') }}" class="nav-link {{ Route::currentRouteName() == 'admin.clients.index' ? 'active' : '' }}">
                        <i class="nav-icon fas fa-users"></i>
                        <p>Clients</p>
                    </a>
                </li>

                <li class="nav-item ">
                    <a href="{{ route('admin.invitations.index') }}" class="nav-link {{ $activeRoute[1] == 'invitations'  ? 'active' : '' }}">
                        <i class="nav-icon fas fa-envelope-open-text"></i>
                        <p>Invitations</p>
                    </a>
                </li>

                <li class="nav-item ">
                    <a href="{{ route('admin.registrations') }}" class="nav-link {{  $activeRoute[1] == 'registrations'  ? 'active' : '' }}">
                        <i class="nav-icon fas fa-id-card"></i>
                        <p>Registrations</p>
                    </a>
                </li>

                <li class="nav-item ">
                    <a href="{{ route('admin.checkins') }}" class="nav-link {{ $activeRoute[1] == 'checkins' ? 'active' : '' }}">
                        <i class="nav-icon fas fa-user-check"></i>
                        <p>Check-ins</p>
                    </a>
                </li>

                <li class="nav-item ">
                    <a href="{{ route('admin.finance.index') }}" class="nav-link {{ $activeRoute[1] == 'finance' ? 'active' : '' }}">
                        <i class="nav-icon fas fa-chart-line"></i>
                        <p>Finance</p>
                    </a>
                </li>

                <li class="nav-item ">
                    <a href="{{ route('admin.gallery.index') }}" class="nav-link {{ $activeRoute[1] == 'gallery' ? 'active' : '' }}">
                        <i class="nav-icon fas fa-images"></i>
                        <p>Gallery</p>
                    </a>
                </li>

                <li class="nav-item">
                    <a href="{{ route('admin.messages.index') }}" class="nav-link {{ $activeRoute[1] == 'messages' ? 'active' : '' }}">
                        <i class="nav-icon fas fa-envelope"></i>
                        <p>
                            Messages
                            @if ($unreadMessages)
                                <span class="badge badge-light">{{ $unreadMessages }}</span>
                            @endif
                        </p>
                    </a>
                </li>

                <li class="nav-item">
                    <a href="javascript:void(0)" class="nav-link" id="logoutBtn">
                        <i class="nav-icon fas fa-power-off text-danger"></i>
                        <p>Logout</p>
                    </a>
                </li>

                <form action="{{ route('admin.logout') }}" id="logoutForm" method="POST">
                    @csrf
                </form>
            </ul>
        </nav>
    </div>
</aside>