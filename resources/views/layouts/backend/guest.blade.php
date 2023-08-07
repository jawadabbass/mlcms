<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <link href="{{ asset('back/jquery-ui/jquery-ui.min.css') }}" rel="stylesheet" type="text/css" />
    <!-- Font Awesome -->
    <link href="{{ asset('back/fontawesome/css/all.min.css') }}" rel="stylesheet" type="text/css" />
    <!-- icheck bootstrap -->
    <link rel="stylesheet" href="{{ asset('back/icheck-bootstrap/icheck-bootstrap.min.css') }}">
    <!-- Theme style -->
    <link href="{{ asset('back/js/AdminLTE/dist/css/adminlte.min.css') }}" rel="stylesheet" type="text/css" />
    <link rel="icon" type="image/x-icon" href="{{ asset(config('site.favicon')) }}">
</head>

<body class="hold-transition login-page">
    <div class="login-box">
        <div class="login-logo">
            <a href="{{ url('admin') }}"><img src="{!! getImage('admin_logo_favicon', config('admin_logo_favicon.admin_login_page_logo'), 'main') !!}" /></a>
        </div>
        <!-- /.login-logo -->
        @yield('content')
        <div class="text-center m-3">Powered By <a title="MediaLinkers" href="http://www.medialinkers.com" target="_blank"><img
            src="{{ base_url() . 'back/images/ml-icon.png' }}" /></a></div>
    </div>
    <!-- /.login-box -->

    <script src="{{ asset('back/js/jquery.min.js') }}"></script>
    <script src="{{ asset('back/jquery-ui/jquery-ui.min.js') }}"></script>
    <script src="{{ asset('back/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('back/js/AdminLTE/dist/js/adminlte.min.js') }}"></script>
    @yield('beforeBodyClose')
</body>

</html>
