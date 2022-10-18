<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    @php
        if (isset($seoArr)) {
            echo seo_print($seoArr);
        }
    @endphp
    @php $settingArr = settingArr(); @endphp
    @include('front.common_views.before_head_close')
    @yield('beforeHeadClose')
    @yield('page_css')
</head>

<body>
    <div class="main-header">
        <!--Header-->
        @include('front.common_views.header')
        <!--Header end-->
        @yield('content')
        <!--footer-->
        <!--footer end-->
    </div>
    @include('front.common_views.footer')
    @include('front.common_views.before_body_close')
    @yield('beforeBodyClose')
    @yield('page_scripts')
</body>

</html>
