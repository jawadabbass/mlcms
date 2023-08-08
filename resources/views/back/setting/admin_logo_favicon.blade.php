@extends('back.layouts.app', ['title' => $title])
@section('beforeHeadClose')
    <link href="{{ base_url() . 'module/settings/admin/css/settings.css' }}" rel="stylesheet" type="text/css" />
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
        <section class="content" id="basic-setting">
            <div class="box">
                <h2 class="box-title">
                    <i class="fas fa-arrow-circle-o-down" aria-hidden="true"></i> Logo and Favicon Settings
                    @php echo helptooltip('admin_logo_favicon') @endphp
                </h2>
                <br>
                <form name="logo_favicon_frm" id="logo_favicon_frm" method="post"
                    action="{{ base_url() . 'adminmedia/setting/admin_logo_favicon' }}" enctype="multipart/form-data">
                    @csrf
                    <div id="g_analy" style="margin-left: -15px;">
                        <div class="row">
                            <div class="col-md-12">
                                <img src="{!! getImage('admin_logo_favicon', $setting_result->admin_login_page_logo, 'main') !!}" />
                            </div>
                            <div class="col-md-12 mb-3">
                                <div class="mb-2">
                                    <label class="form-label">Admin Login Page Logo</label>
                                    <input type="file" name="admin_login_page_logo"
                                        class="form-control basic_setting_height">
                                </div>
                            </div>

                            <div class="col-md-12">
                                <img src="{!! getImage('admin_logo_favicon', $setting_result->admin_header_logo, 'main') !!}" />
                            </div>
                            <div class="col-md-12 mb-3">
                                <div class="mb-2">
                                    <label class="form-label">Admin Header Logo</label>
                                    <input type="file" name="admin_header_logo"
                                        class="form-control basic_setting_height">
                                </div>
                            </div>
                            <div class="col-md-12">
                                <img src="{!! getImage('admin_logo_favicon', $setting_result->admin_favicon, 'main') !!}" />
                            </div>
                            <div class="col-md-12 mb-3">
                                <div class="mb-2">
                                    <label class="form-label">Admin Favicon</label>
                                    <input type="file" name="admin_favicon" class="form-control basic_setting_height">
                                </div>
                            </div>
                        </div>
                        <br><br>
                        <input type="submit" name="logo_favicon_btn" value="Update" class="sitebtn" />
                    </div>
                </form>
            </div>
        </section>
    </div>
@endsection
@section('beforeBodyClose')
    <script type="text/javascript" src="{{ base_url() . 'module/settings/admin/js/settings.js' }}"></script>
@endsection
