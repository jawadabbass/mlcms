@extends('back.layouts.app', ['title' => $title])
@section('beforeHeadClose')
    <link href="{{ base_url() . 'module/settings/admin/css/settings.css' }}" rel="stylesheet" type="text/css" />
    <link href="{{ base_url() . 'back/css/magicsuggest.css' }}" rel="stylesheet" type="text/css" />
    <link href="{{ base_url() . 'module/settings/admin/css/setting.css' }}" rel="stylesheet" type="text/css" />
@endsection
@section('content')
    <aside class="right-side {{ session('leftSideBar') == 1 ? 'strech' : '' }}">
        <section class="content-header">
            <div class="row">
                <div class="col-md-8 col-sm-6">
                    <ol class="breadcrumb">
                        <li>
                            <a href="{{ admin_url() }}"><i class="fa-solid fa-gauge"></i> Home</a>
                        </li>
                        <li class="active"> Site Settings</li>
                    </ol>
                </div>
                <div class="col-md-4 col-sm-6">
                    @include('back.common_views.quicklinks')
                </div>
            </div>
        </section>
        @if ($errors->any())
            <div class="message-container">
                <div class="callout callout-danger">
                    <h4>Please correct These error.</h4>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </div>
            </div>
        @endif
        @if (\Session::has('action') && \Session::get('action') == 'error')
            <div class="message-container">
                <div class="callout callout-danger">
                    <h4>Please select admin user to assign the tickets.</h4>
                </div>
            </div>
        @endif
        @if (\Session::has('action') && \Session::get('action') == 'network_error')
            <div class="message-container">
                <div class="callout callout-danger">
                    <h4>Please Fill correctly.</h4>
                </div>
            </div>
        @endif
        @if (\Session::has('updated_action'))
            <div class="message-container">
                <div class="callout callout-success">
                    <h4>Updated successfully.</h4>
                </div>
            </div>
        @endif
        <section class="content" id="google-analytics">
            <div class="box">
                <h2 class="box-title">
                    <i class="fa-solid fa-arrow-circle-o-down" aria-hidden="true"></i> Google Analytics Code
                    @php echo helptooltip('google_analytics_content') @endphp
                </h2>
                <form name="emp_network_detail" method="post" action="{{ route('settings.store') }}">
                    @csrf
                    <div class="mb-2">
                        <div id="g_analy">
                            <div class="myfldrow">
                                <textarea class="form-control" name="google_analytics">{{ $setting_result->google_analytics }}</textarea>
                                <p>Copy google analytics code with "script" tag and paste above</p>
                                <p><a href="https://www.google.com/analytics" target="_blank">Sign Up or Manage
                                        Analytics </a> by clicking this link</p>
                            </div>
                            <input type="submit" name="change_network_details" value="update" class="sitebtn" />
                        </div>
                    </div>
                </form>
            </div>
        </section>
    </aside>
@endsection
@section('beforeBodyClose')
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-toggle/2.2.2/css/bootstrap-toggle.min.css"
        rel="stylesheet">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-toggle/2.2.2/js/bootstrap-toggle.min.js"></script>
    <script type="text/javascript" src="{{ base_url() . 'module/settings/admin/js/settings.js' }}"></script>
@endsection
