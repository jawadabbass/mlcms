@extends('back.layouts.app', ['title' => $title])
@section('beforeHeadClose')
    <link href="{{ asset_storage('') . 'module/settings/admin/css/settings.css' }}" rel="stylesheet" type="text/css" />
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
        <section class="content" id="basic-setting">
            <div class="box">
                <h2 class="box-title">
                    <i class="fas fa-arrow-circle-o-down" aria-hidden="true"></i> Analytics Property ID and Settings
                    @php echo helptooltip('analytics_property_id_and_json_file') @endphp
                </h2>
                <br>
                <form name="analytics_property_id_frm" id="analytics_property_id_frm" method="post"
                    action="{{ base_url() . 'adminmedia/setting/savePropertyIdAndJsonFile' }}"
                    enctype="multipart/form-data">
                    @csrf
                    <div id="g_analy" style="margin-left: -15px;">
                        <div class="row">
                            <div class="col-md-12 mb-3">
                                <div class="mb-2">
                                    <label class="form-label">Show Analytics?</label>
                                    <select class="form-control" name="is_show_analytics" id="is_show_analytics">
                                        <option value="1" {{ $metaArray['is_show_analytics'] == 1 ? 'selected' : '' }}>Yes</option>
                                        <option value="0" {{ $metaArray['is_show_analytics'] == 0 ? 'selected' : '' }}>No</option>
                                    </select>                                    
                                </div>
                            </div>
                            <div class="col-md-12 mb-3">
                                <div class="mb-2">
                                    <label class="form-label">Analytics Property ID</label>
                                    <input type="text" class="form-control" name="analytics_property_id"
                                        id="analytics_property_id" value="{{ $metaArray['analytics_property_id'] }}" />
                                    <p>Put Google ANALYTICS PROPERTY ID above</p>
                                    <p><a href="https://github.com/spatie/laravel-analytics" target="_blank">About
                                            Spatie Laravel Analytics Package </a></p>
                                </div>
                            </div>
                            <div class="col-md-12 mb-3">
                                <div class="mb-2">
                                    <label class="form-label">Service Account Credentials Json</label>
                                    <input type="file" name="service_account_credentials_json"
                                        class="form-control basic_setting_height">
                                        {{ $metaArray['service_account_credentials_json'] }}
                                </div>
                            </div>
                        </div>
                        <br><br>
                        <input type="submit" name="service_account_credentials_json_btn" value="Update" class="sitebtn" />
                    </div>
                </form>
            </div>
        </section>
    </div>
@endsection
@section('beforeBodyClose')
    <script type="text/javascript" src="{{ asset_storage('') . 'module/settings/admin/js/settings.js' }}"></script>
@endsection
