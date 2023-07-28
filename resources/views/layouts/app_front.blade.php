<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    @include('back.common_views.meta_tags')
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ FindInsettingArr('business_name') }}</title>
    @include('back.common_views.before_head_close')
    <meta name="robots" content="noindex">
</head>

<body>
    <div class="companybrand">
        <div class="mainlogologin"><img src="{!! getImage('admin_logo_favicon', config('admin_logo_favicon.admin_login_page_logo'), 'main') !!}" /></div>
    </div>
    @yield('content')
    <div class="sitecredits">Powered By <a title="MediaLinkers" href="http://www.medialinkers.com" target="_blank"><img
                src="{{ base_url() . 'back/images/ml-icon.png' }}" /></a></div>
</body>

</html>