@extends('back.layouts.app', ['title' => $title])
@section('beforeHeadClose')
    <link href="{{ base_url() . 'module/settings/admin/css/settings.css' }}" rel="stylesheet" type="text/css" />
    <link href="{{ base_url() . 'back/css/magicsuggest.css' }}" rel="stylesheet" type="text/css" />
    <link href="{{ base_url() . 'module/settings/admin/css/setting.css' }}" rel="stylesheet" type="text/css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/flag-icon-css/3.1.0/css/flag-icon.min.css"
        integrity="sha256-D+ZpDJjhGxa5ffyQkuTvwii4AntFGBZa4jUhSpdlhjM=" crossorigin="anonymous" />
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
        <section class="content" id="basic-setting">
            <div class="box">
                <h2 class="box-title">
                    <i class="fa-solid fa-arrow-circle-o-down" aria-hidden="true"></i> Basic Settings
                    @php echo helptooltip('meta_data_content') @endphp
                </h2>
                <br>
                <form name="emp_network_detail" method="post" action="{{ base_url() . 'adminmedia/setting/meta_data' }}">
                    @csrf
                    <div id="g_analy" style="margin-left: -15px;">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-2">
                                    <label class="form-label">Time Zone</label>
                                    <select class="form-control basic_setting_height" name="timeZone">
                                        <option value="{{ $metaArray['time_zone'] }}">{{ $metaArray['time_zone'] }}</option>
                                        <?php foreach(tz_list() as $t) { ?>
                                        <option value="<?php print $t['zone']; ?>"
                                            {{ strcmp($metaArray['time_zone'], $t['zone']) ? '' : 'selected' }}>
                                            <?php print $t['diff_from_GMT'] . ' - ' . $t['zone']; ?>
                                        </option>
                                        <?php } ?>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-2">
                                    <label class="form-label">Date Display Format</label>
                                    <select class="form-control basic_setting_height" type="text" name="dateFormat"
                                        id="DATE_FORMAT_DISPLAY">
                                        <option value="{{ $metaArray['date_format'] }}">
                                            @php
                                                $date = date_create();
                                                echo format_date_tz('now', $metaArray['date_format']);
                                                //echo date_format($date,$metaArray['date_format']);
                                            @endphp
                                        </option>
                                        <option value="m/d/Y">
                                            @php echo format_date_tz('now','m/d/Y'); @endphp
                                        </option>
                                        <option value="m/d/y">
                                            @php echo format_date_tz('now','m/d/y'); @endphp
                                        </option>
                                        <option value="M d, Y">
                                            @php echo format_date_tz('now','M d, Y'); @endphp
                                        </option>
                                        <option value="m-d-Y">
                                            @php echo format_date_tz('now','m-d-Y'); @endphp
                                        </option>
                                        <option value="l, d F Y">
                                            @php echo format_date_tz('now','l, d F Y'); @endphp
                                        </option>
                                        <option value="d-F-Y">
                                            @php echo format_date_tz('now','d-F-Y'); @endphp
                                        </option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-2">
                                    <label class="form-label">Date & Time Display Format</label>
                                    <select class="form-control basic_setting_height" type="text" name="dateTimeFormat"
                                        id="DATE_FORMAT_TIME_DISPLAY">
                                        <option value="{{ $metaArray['date_time_format'] }}">
                                            @php
                                                $date = date_create();
                                                echo format_date_tz('now', $metaArray['date_time_format']);
                                            @endphp
                                        </option>
                                        <option value="m/d/Y h:i:s A">
                                            @php echo format_date_tz('now','m/d/Y h:i:s A'); @endphp
                                            {{-- @php echo date_format($date,'m/d/Y h:i:s A'); @endphp --}}
                                        </option>
                                        <option value="m/d/y h:i:s A">
                                            @php echo format_date_tz('now','m/d/y h:i:s A'); @endphp
                                            {{-- @php echo date_format($date,'m/d/y h:i:s A'); @endphp --}}
                                        </option>
                                        <option value="M. d, Y h:i:s A">
                                            @php echo format_date_tz('now','M. d, Y h:i:s A'); @endphp
                                            {{-- @php echo date_format($date,'M. d, Y h:i:s A'); @endphp --}}
                                        </option>
                                        <option value="M. d, Y h:i A">
                                            @php echo format_date_tz('now','M. d, Y h:i A'); @endphp
                                            {{-- @php echo date_format($date,'M. d, Y h:i A'); @endphp --}}
                                        </option>
                                        <option value="m-d-Y h:i:s A">
                                            @php echo format_date_tz('now','m-d-Y h:i:s A'); @endphp
                                            {{-- @php echo date_format($date,'m-d-Y h:i:s A'); @endphp --}}
                                        </option>
                                        <option value="l, d F Y h:i:s A">
                                            @php echo format_date_tz('now','l, d F Y h:i:s A'); @endphp
                                            {{-- @php echo date_format($date,'l, d F Y h:i:s A'); @endphp --}}
                                        </option>
                                        <option value="d-F-Y h:i:s A">
                                            @php echo format_date_tz('now','d-F-Y h:i:s A'); @endphp
                                            {{-- @php echo date_format($date,'d-F-Y h:i:s A'); @endphp --}}
                                        </option>
                                        <option value="m/d/Y h:i A">
                                            @php echo format_date_tz('now','m/d/Y h:i A'); @endphp

                                        </option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-2">
                                    <label class="form-label">Maximum allowed size for Image in MBs </label>
                                    <input type="number" min="0" max="{{ $maxSizeAllowed }}" class="form-control"
                                        name="imageMaxSize" placeholder="Max Image Size"
                                        value="{{ $metaArray['max_image_size'] }}">
                                    <span style="color: red;font-size: 15px">Server allowed Size: {{ $maxSizeAllowed }}
                                        MB</span>
                                </div>
                            </div>
                        </div>
                        <br><br>
                        <input type="submit" name="change_network_details" value="update" class="sitebtn" />
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
