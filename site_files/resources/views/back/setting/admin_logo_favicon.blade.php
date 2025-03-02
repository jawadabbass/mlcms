@extends('back.layouts.app', ['title' => $title])
@section('content')
    <div class="pl-3 pr-2 content-wrapper">
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
        <section class="content" id="basic-setting">
            <div class="p-2 card">
                <h2 class=" card-title">
                    <i class="fas fa-arrow-circle-o-down" aria-hidden="true"></i> Logo and Favicon Settings
                    @php echo helptooltip('admin_logo_favicon') @endphp
                </h2>
                <br>
                <form name="logo_favicon_frm" id="logo_favicon_frm" method="post"
                    action="{{ base_url() . 'adminmedia/setting/admin_logo_favicon' }}" enctype="multipart/form-data">
                    @csrf
                    <div id="g_analy">
                        <div class="row">
                            <div class="col-md-12">
                                <img src="{!! getImage('admin_logo_favicon', $setting_result->admin_login_page_logo, 'main') !!}" />
                            </div>
                            <div class="mb-3 col-md-12">
                                <div class="mb-2">
                                    <label class="form-label">Admin Login Page Logo</label>
                                    <input type="file" name="admin_login_page_logo"
                                        class="form-control basic_setting_height">
                                </div>
                            </div>

                            <div class="col-md-12">
                                <img src="{!! getImage('admin_logo_favicon', $setting_result->admin_header_logo, 'main') !!}" />
                            </div>
                            <div class="mb-3 col-md-12">
                                <div class="mb-2">
                                    <label class="form-label">Admin Header Logo</label>
                                    <input type="file" name="admin_header_logo"
                                        class="form-control basic_setting_height">
                                </div>
                            </div>
                            <div class="col-md-12">
                                <img src="{!! getImage('admin_logo_favicon', $setting_result->admin_favicon, 'main') !!}" />
                            </div>
                            <div class="mb-3 col-md-12">
                                <div class="mb-2">
                                    <label class="form-label">Admin Favicon</label>
                                    <input type="file" name="admin_favicon" class="form-control basic_setting_height">
                                </div>
                            </div>
                            <div class="col-md-12">
                                <img src="{!! getImage('admin_logo_favicon', $setting_result->og_image, 'main') !!}" />
                            </div>
                            <div class="mb-3 col-md-12">
                                <div class="mb-2">
                                    <label class="form-label">Open Graph Image</label>
                                    <input type="file" name="og_image" class="form-control basic_setting_height">
                                    <code>Just make sure that the image size does not exceed 5MB and 1200 x 627 pixels should be the limit as these are Facebook limitations for image tags</code>
                                </div>
                            </div>
                        </div>
                        <br><br>
                        <input type="submit"  name="logo_favicon_btn" value="Update" class="sitebtn" />
                    </div>
                </form>
            </div>
        </section>
    </div>
@endsection
@section('beforeBodyClose')
    <script type="text/javascript" src="{{ asset_storage('') . 'module/settings/admin/js/settings.js' }}"></script>
@endsection
