@extends('back.layouts.app', ['title' => $title])
@section('beforeHeadClose')
    <link href="{{ base_url() . 'module/settings/admin/css/settings.css' }}" rel="stylesheet" type="text/css" />
    <link href="{{ base_url() . 'back/css/magicsuggest.css' }}" rel="stylesheet" type="text/css" />
    <link href="{{ base_url() . 'module/settings/admin/css/setting.css' }}" rel="stylesheet" type="text/css" />
@endsection
@section('content')
    <div class="content-wrapper pl-3 pr-2">
        <section class="content-header">
            <div class="row">
                <div class="col-md-5 col-sm-12">
                    <ol class="breadcrumb">
                        <li>
                            <a href="{{ admin_url() }}"><i class="fas fa-gauge"></i> Home</a>
                        </li>
                        <li class="active"> Site Settings</li>
                    </ol>
                </div>
                <div class="col-md-7 col-sm-12">
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
        <section class="content" id="google-captcha">
            <div class="box">
                <h2 class="box-title"><i class="fas fa-arrow-circle-o-down" aria-hidden="true"></i> ContactUs Captcha
                </h2>
                <form name="emp_network_detail" method="post" action="{{ admin_url() . 'setting/captcha' }}">
                    @csrf
                    <div class="mb-2">
                        <br><br>
                        <span style="font-size:12px">
                            <div class="alert alert-success alert-dismissible" role="alert">
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">
                                    </button>
                                Google reCAPTCHA is a free service that protects your website from spam and abuse.
                                reCAPTCHA uses an advanced risk analysis engine and adaptive CAPTCHAs to keep automated
                                software
                                from submittting your forms. It does this while letting your valid users pass through
                                with ease.
                                You can get the Keys for reCapcha from here
                                <a href="https://www.google.com/recaptcha/admin"
                                    target="_blank">https://www.google.com/recaptcha/admin</a>
                            </div>
                        </span>
                        <div id="d_web">
                            <p></p>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-2">
                                        <label class="form-label">reCAPTCHA SITE KEY</label>
                                        <input type="text" class="form-control" name="siteKey" placeholder="Site Key"
                                            value="{{ $metaArray['recaptcha_site_key'] }}">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-2">
                                        <label class="form-label">reCAPTCHA SECRET KEY</label>
                                        <input type="text" class="form-control" name="secretKey" placeholder="Secret Key"
                                            value="{{ $metaArray['recaptcha_secret_key'] }}">
                                    </div>
                                </div>
                            </div>
                            <input type="submit" name="change_network_details" value="update" class="sitebtn" />
                        </div>
                    </div>
                </form>
            </div>
        </section>
    </div>
@endsection
@section('beforeBodyClose')
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-toggle/2.2.2/css/bootstrap-toggle.min.css"
        rel="stylesheet">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-toggle/2.2.2/js/bootstrap-toggle.min.js"></script>
    <script type="text/javascript" src="{{ base_url() . 'module/settings/admin/js/settings.js' }}"></script>
@endsection
