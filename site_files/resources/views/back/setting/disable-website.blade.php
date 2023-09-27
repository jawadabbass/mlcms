@extends('back.layouts.app', ['title' => $title])
@section('beforeHeadClose')
    <link href="{{ public_path_to_storage('') . 'module/settings/admin/css/settings.css' }}" rel="stylesheet" type="text/css" />
    <link href="{{ public_path_to_storage('') . 'back/css/magicsuggest.css' }}" rel="stylesheet" type="text/css" />
    <link href="{{ public_path_to_storage('') . 'module/settings/admin/css/setting.css' }}" rel="stylesheet" type="text/css" />
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
        <section class="content" id="disable-website">
            <div class="box">
                <h2 class="box-title"><i class="fas fa-arrow-circle-o-down" aria-hidden="true"></i> Disable Website </h2>
                <form name="emp_network_detail" action="{{ route('settings.edit', 0) }}">
                    <div class="mb-2">
                        <span style="color:red; font-size:12px">
                            @php
                                if ($setting_result->web_down_status == 1) {
                                    echo '<div class="alert alert-danger alert-dismissible" role="alert">
                                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">
                                    </button>
                                    <strong>Warning</strong>: (Currenly Website is down!!!). </div>';
                                }
                            @endphp
                        </span>
                        <br />
                        <div class="mb-2">
                            <label class="form-label">
                                @php
                                    $statusVal = old('web_down_status') ? old('web_down_status') : $setting_result->web_down_status;
                                    $checked = $statusVal == 1 ? 'checked' : '';
                                @endphp
                                <input id="web_down_status" name="web_down_status" type="checkbox" {{ $checked }}
                                    data-toggle="toggle" data-on="On" data-off="Off" data-onstyle="danger"
                                    data-offstyle="success">
                                Disable Status
                            </label>
                            @php echo helptooltip('web_down_status') @endphp
                        </div>
                        <div id="d_web">
                            <textarea class="form-control" id="web_down_msg" name="web_down_msg">
                                {{ old('web_down_msg') ? old('down_msg') : $setting_result->web_down_msg }}
                            </textarea>

                            <br>
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
    <script type="text/javascript">
        $(function() {
            $('#web_down_status').bootstrapToggle();            
        });
    </script>
    <script type="text/javascript" src="{{ public_path_to_storage('') . 'module/settings/admin/js/settings.js' }}"></script>
    <script type="text/javascript" src="{{ public_path_to_storage('') . 'back/js/magicsuggest.js' }}"></script>
@endsection
