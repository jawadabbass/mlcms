@extends('back.layouts.app', ['title' => $title])
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
        @if (isAllowed('Can Manage Basic Settings'))
            @include('back.setting.templates.basic_inner')
            <section>
                <hr />
            </section>
        @endif
        @if (isAllowed('Can Manage Google Analytics'))
            @include('back.setting.templates.analytics_inner')
            <section>
                <hr />
            </section>
        @endif
        @if (isAllowed('Can Manage Google Adsense'))
            @include('back.setting.templates.adsense_inner')
            <section>
                <hr />
            </section>
        @endif
        @if (isAllowed('Can Manage Google Captcha'))
            @include('back.setting.templates.captcha_inner')
            <section>
                <hr />
            </section>
        @endif
        @if (isAllowed('Can Manage Paypal'))
            @include('back.setting.templates.paypal_inner')
            <section>
                <hr />
            </section>
        @endif
        @if (isAllowed('Can Manage Block Traffic'))
            @include('back.setting.templates.restriction_inner')
            <section>
                <hr />
            </section>
        @endif
        @if (isAllowed('Can Manage Disable Website'))
            @include('back.setting.templates.disable-website_inner')
            <section>
                <hr />
            </section>
        @endif
        @if (isAllowed('Can Manage Javascript Code'))
            @include('back.setting.templates.js_inner')
            <section>
                <hr />
            </section>
        @endif
        @if (isAllowed('Can Manage Admin Logo/Favicon'))
            @include('back.setting.templates.admin_logo_favicon_inner')
            <section>
                <hr />
            </section>
        @endif
    </div>
@endsection
