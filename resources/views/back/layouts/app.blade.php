<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="shortcut icon" type="image/png" href="{!! getImage('admin_logo_favicon', config('admin_logo_favicon.admin_favicon'), 'main') !!}">
    <title>{{ $title?? 'MLCMS' }}</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    @include('back.common_views.before_head_close')
    @yield('beforeHeadClose')
</head>
<body class="sidebar-mini layout-fixed layout-navbar-fixed layout-footer-fixed text-sm {{ session('leftSideBar') == 1 ? 'sidebar-collapse' : '' }}">
    <div class="wrapper">
        <div class="lContainer" style="display: none;" id="lContainer">
            <div class="loader"></div>
        </div>
        @include('back.common_views.after_body_open')
        @include('back.common_views.header')
        @include('back.common_views.left_side')
        @yield('content')
        @include('back.common_views.footer')
        @include('back.common_views.before_body_close')
        @yield('beforeBodyClose')
        <style>
            .jFiler-theme-default .jFiler-input {
                width: 100%;
            }
        </style>
    </div>
</body>

</html>
