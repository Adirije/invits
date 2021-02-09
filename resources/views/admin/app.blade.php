<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    
    <title>{{ config('app.name') }} - Admin | @yield('title')</title>

    <link rel="manifest" href="site.webmanifest">
    <link rel="shortcut icon" type="image/x-icon" href="/assets/img/favicon.ico">
    
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    
    <link rel="stylesheet" href="/admin_assets/plugins/fontawesome-free/css/all.min.css">

    <link rel="stylesheet" href="/admin_assets/plugins/overlayScrollbars/css/OverlayScrollbars.min.css">
    
    <link rel="stylesheet" href="/js/select2/css/select2.min.css">
    <link rel="stylesheet" href="/js/datepicker/jquery.datetimepicker.min.css">
    <link rel="stylesheet" href="/css/custom.css">
    <link rel="stylesheet" href="/admin_assets/dist/css/adminlte.min.css">

    {{-- PNotify --}}
    @include('plugins.pnotify.styles')

    @if (env('APP_ENV') == 'production')
        <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/bs4/dt-1.10.21/b-1.6.3/b-colvis-1.6.3/cr-1.5.2/kt-2.5.2/r-2.2.5/sc-2.0.2/sp-1.1.1/sl-1.3.1/datatables.min.css"/>
    @else
        <link rel="stylesheet" type="text/css" href="/DataTables/datatables.min.css"/>
    @endif

    <style>
        .pointer:hover{
            cursor: pointer;
        }
    </style>

    @yield('styles')
</head>
<body class="hold-transition sidebar-mini layout-fixed">
    
    <div class="wrapper">
        @include('admin.navbar')

        @include('admin.sidebar')

        
        <main class="content-wrapper">
            
            <section class="content-header">
                <div class="container-fluid">
                    <div class="d-flex mb-2 justify-content-between">
                        <div class="">
                            <h1>@yield('page-header')</h1>
                        </div>
                        <div class="">
                            @yield('actionBtn')
                        </div>
                    </div>
                </div>
            </section>

            <section class="content">
                @yield('content')
            </section>

        </main>
        

        <footer class="main-footer">
            <div class="float-right d-none d-sm-block">
                {{-- <b>Version</b> 3.1.0-pre --}}
            </div>
            <strong>Copyright &copy; {{Date('Y')}} {{ config('app.name') }}.</strong> All rights reserved.
        </footer>

        
        <aside class="control-sidebar control-sidebar-dark">
            
        </aside>
        
    </div>
    

    
    <script src="/admin_assets/plugins/jquery/jquery.min.js"></script>
    
    <script src="/admin_assets/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
    
    <script src="/admin_assets/plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js"></script>
    
    <script src="/admin_assets/dist/js/adminlte.min.js"></script>
    
    <script src="/admin_assets/dist/js/demo.js"></script>

    <script src="/js/select2/js/select2.min.js"></script>
    <script src="/js/datepicker/jquery.datetimepicker.full.min.js"></script>
    
    @include('plugins.axios')
    
    @include('plugins.pnotify.scripts')

    @if (env('APP_ENV') == 'production')
        <script type="text/javascript" src="https://cdn.datatables.net/v/bs4/dt-1.10.21/b-1.6.3/b-colvis-1.6.3/cr-1.5.2/kt-2.5.2/r-2.2.5/sc-2.0.2/sp-1.1.1/sl-1.3.1/datatables.min.js"></script>
    @else
        <script type="text/javascript" src="/DataTables/datatables.min.js"></script>
    @endif

    @auth('admin')
        <script>
            $('#logoutBtn').click(function(){
                $('#logoutForm').submit();
            });
        </script>
    @endauth

    <script>

    </script>

    @yield('scripts')

    @include('plugins.pnotify.notice')
</body>
</html>
