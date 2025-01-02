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
        @if (\Session::has('updated_action'))
            <div class="message-container">
                <div class="callout callout-success">
                    <h4>{{ \Session::get('updated_action') }}</h4>
                </div>
            </div>
        @endif
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
                    <i class="fas fa-arrow-circle-o-down" aria-hidden="true"></i> Banner Popup Settings
                    @php echo helptooltip('banner_popup') @endphp
                </h2>
                <br>
                <form name="banner_popup_frm" id="banner_popup_frm" method="post"
                    action="{{ base_url() . 'adminmedia/setting/banner_popup' }}" enctype="multipart/form-data">
                    @csrf
                    <div id="g_analy" >
                        <div class="row">
                            <div class="col-md-12">
                                <img src="{!! getImage('banner_popup', $metaArray['banner_popup_image'], 'main') !!}" />
                            </div>
                            <div class="mb-3 col-md-12">
                                <div class="mb-2">
                                    <label class="form-label">Image</label>
                                    <input type="file" name="banner_popup_image"
                                        class="form-control basic_setting_height">
                                </div>
                            </div>
                            <div class="mb-3 col-md-12">
                                <div class="mb-2">
                                    <label class="form-label">Status</label>
                                    <select name="banner_popup_status" id="banner_popup_status" class="form-control basic_setting_height">
                                        <option value="active" {{ ($metaArray['banner_popup_status'] == 'active')? 'selected="selected"':'' }}>Active</option>
                                        <option value="inactive" {{ ($metaArray['banner_popup_status'] == 'inactive')? 'selected="selected"':'' }}>Inactive</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <br><br>
                        <input type="submit"  name="banner_popup_btn" value="Update" class="sitebtn" />
                    </div>
                </form>
            </div>
        </section>
    </div>
@endsection
@section('beforeBodyClose')
    <script type="text/javascript" src="{{ base_url() . 'module/settings/admin/js/settings.js' }}"></script>
@endsection
