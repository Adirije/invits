<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>{{ config('app.name') }} | @yield('title')</title>
    
        <meta name="msapplication-TileColor" content="#da532c">
        <meta name="theme-color" content="#ffffff">

        <link rel="manifest" href="/site.webmanifest">
        <link rel="shortcut icon" type="image/x-icon" href="/assets/img/favicon.ico">
    
        <!-- Google Font: Source Sans Pro -->
        <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
        <!-- Font Awesome -->
        <link rel="stylesheet" href="/admin_assets/plugins/fontawesome-free/css/all.min.css">
        <!-- icheck bootstrap -->
        <link rel="stylesheet" href="/admin_assets/plugins/icheck-bootstrap/icheck-bootstrap.min.css">
        <!-- Theme style -->
        <link rel="stylesheet" href="/css/custom.css">
        <link rel="stylesheet" href="/admin_assets/dist/css/adminlte.min.css">
        @yield('styles')
    </head>

    <body class="hold-transition @yield('page-class')">

        @yield('content')
        
        <script src="/admin_assets/plugins/jquery/jquery.min.js"></script>
        <script src="/admin_assets/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
        <script src="/admin_assets/dist/js/adminlte.min.js"></script>
        
        @include('plugins.axios')

        @yield('scripts')
    </body>
</html>