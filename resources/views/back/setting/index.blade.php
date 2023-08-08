@extends('back.layouts.app', ['title' => $title])
@section('beforeHeadClose')
    <link href="{{ base_url() . 'module/settings/admin/css/settings.css' }}" rel="stylesheet" type="text/css" />
    <link href="{{ base_url() . 'back/css/magicsuggest.css' }}" rel="stylesheet" type="text/css" />
    <link href="{{ base_url() . 'module/settings/admin/css/setting.css' }}" rel="stylesheet" type="text/css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/flag-icon-css/3.1.0/css/flag-icon.min.css"
        integrity="sha256-D+ZpDJjhGxa5ffyQkuTvwii4AntFGBZa4jUhSpdlhjM=" crossorigin="anonymous" />
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
                    <i class="fas fa-arrow-circle-o-down" aria-hidden="true"></i> Basic Settings
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
                                                echo date_format($date, $metaArray['date_format']);
                                            @endphp
                                        </option>
                                        <option value="m/d/Y">
                                            @php echo date_format($date,'m/d/Y'); @endphp
                                        </option>
                                        <option value="m/d/y">
                                            @php echo date_format($date,'m/d/y'); @endphp
                                        </option>
                                        <option value="M d, Y">
                                            @php echo date_format($date,'M d, Y'); @endphp
                                        </option>
                                        <option value="m-d-Y">
                                            @php echo date_format($date,'m-d-Y'); @endphp
                                        </option>
                                        <option value="l, d F Y">
                                            @php echo date_format($date,'l, d F Y'); @endphp
                                        </option>
                                        <option value="d-F-Y">
                                            @php echo date_format($date,'d-F-Y'); @endphp
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
                                                echo date_format($date, $metaArray['date_time_format']);
                                            @endphp
                                        </option>
                                        <option value="m/d/Y h:i:s A">
                                            @php echo date_format($date,'m/d/Y h:i:s A'); @endphp
                                        </option>
                                        <option value="m/d/y h:i:s A">
                                            @php echo date_format($date,'m/d/y h:i:s A'); @endphp
                                        </option>
                                        <option value="M. d, Y h:i:s A">
                                            @php echo date_format($date,'M. d, Y h:i:s A'); @endphp
                                        </option>
                                        <option value="M. d, Y h:i A">
                                            @php echo date_format($date,'M. d, Y h:i A'); @endphp
                                        </option>
                                        <option value="m-d-Y h:i:s A">
                                            @php echo date_format($date,'m-d-Y h:i:s A'); @endphp
                                        </option>
                                        <option value="l, d F Y h:i:s A">
                                            @php echo date_format($date,'l, d F Y h:i:s A'); @endphp
                                        </option>
                                        <option value="d-F-Y h:i:s A">
                                            @php echo date_format($date,'d-F-Y h:i:s A'); @endphp
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
        <section><hr/></section>
        <section class="content" id="google-analytics">
            <div class="box">
                <h2 class="box-title">
                    <i class="fas fa-arrow-circle-o-down" aria-hidden="true"></i> Google Analytics Code
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
        <section><hr/></section>
        <section class="content" id="google-adsense">
            <div class="box">
                <h2 class="box-title">
                    <i class="fas fa-arrow-circle-o-down" aria-hidden="true"></i> Google adsense code
                    @php echo helptooltip('google_adsense_content') @endphp
                </h2>
                <form name="emp_network_detail" method="post" action="{{ route('settings.update', 0) }}">
                    @csrf
                    <input type="hidden" name="_method" value="PUT">
                    <div class="mb-2">
                        <div id="g_adsense" class="row">
                            <div class="col-md-4">
                                <div class="myfldrow">
                                    <strong>Footer Adsense code</strong>
                                    <textarea type="text" class="form-control" name="google_adsense_footer" placeholder="Footer Adsense code"
                                        rows="7">{{ $setting_result->google_adsense_footer }}</textarea>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="myfldrow">
                                    <strong>Left Adsense code</strong>
                                    <textarea class="form-control" name="google_adsense_left" placeholder="Left Adsense code" rows="7">{{ $setting_result->google_adsense_left }}</textarea>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="myfldrow">
                                    <strong>Right Adsense code</strong>
                                    <textarea class="form-control" name="google_adsense_right" placeholder="Right Adsense code" rows="7">{{ $setting_result->google_adsense_right }}</textarea>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <p><a href="https://www.google.com/adsense/" target="_blank">Sign Up or Manage
                                        Adsense</a> by clicking this link</p>
                            </div>
                            <div class="col-md-12">
                                <br />
                                <input type="submit" name="change_network_details" value="update" class="sitebtn" />
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </section>
        <section><hr/></section>
        <section class="content" id="google-captcha">
            <div class="box">
                <h2 class="box-title"><i class="fas fa-arrow-circle-o-down" aria-hidden="true"></i> ContactUs
                    Captcha
                </h2>
                <form name="emp_network_detail" method="post" action="{{ admin_url() . 'setting/captcha' }}">
                    @csrf
                    <div class="mb-2">
                        <div class="row">
                            <div class="col-md-12">
                                <span style="font-size:12px">
                                    <div class="alert alert-success alert-dismissible" role="alert">
                                        <button type="button" class="btn-close" data-bs-dismiss="alert"
                                            aria-label="Close">
                                        </button>
                                        Google reCAPTCHA is a free service that protects your website from spam and abuse.
                                        reCAPTCHA uses an advanced risk analysis engine and adaptive CAPTCHAs to keep
                                        automated
                                        software
                                        from submittting your forms. It does this while letting your valid users pass
                                        through
                                        with ease.
                                        You can get the Keys for reCapcha from here
                                        <a href="https://www.google.com/recaptcha/admin"
                                            target="_blank">https://www.google.com/recaptcha/admin</a>
                                    </div>
                                </span>
                            </div>
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
                </form>
            </div>
        </section>
        <section><hr/></section>
        @include('back.setting.paypal_inner')
        <section><hr/></section>
        <section class="content" id="traffic-restriction">
            <form name="emp_network_detail" method="post" action="{{ base_url() . 'adminmedia/setting/ip-address' }}">
                @csrf
                <div class="edu-wrap">
                    <!--Copy code below-->
                    <div class="row">
                        <div class="col-md-12">
                            <div class="mb-2">
                                <label class="form-label">
                                    <input id="restrict_traffic" name="restrict_traffic" type="checkbox"
                                        data-toggle="toggle" data-on="On" data-off="Off" data-onstyle="success"
                                        data-offstyle="danger" {{ $metaArray['restrict_traffic'] ? 'checked' : '' }}>
                                    Restrict Traffic Based on Countries
                                </label>
                                @php echo helptooltip('country_block_message') @endphp
                            </div>
                        </div>
                        <div class="col-md-8 col-sm-7">
                            <div class="formrow bdrbtm">
                                <strong>
                                    <span class="radiobtn">
                                        <input type="radio" name="block_list_active" id="countries1" value="1"
                                            {{ $metaArray['block_list_active'] ? 'checked' : '' }}>
                                        <i class="checkmark"></i>
                                        Block the following countries.
                                    </span>
                                </strong>
                                <input type="text" id="blockedCounties" class="form-control" name="blockedCounties[]"
                                    placeholder="Type to search Countries" />
                            </div>
                            <div class="formrow">
                                <strong>
                                    <span class="radiobtn">
                                        <input type="radio" name="block_list_active" id="countries2" value="0"
                                            {{ $metaArray['block_list_active'] ? '' : 'checked' }}>
                                        <i class="checkmark"></i>
                                        Only allow the following countries
                                    </span>
                                </strong>
                                <input type="text" id="openCounties" class="form-control" name="openedCounties[]"
                                    placeholder="Type to search Countries" />
                            </div>
                            <div class="formrow">
                                <strong>
                                    <span class="">
                                        Add IPs or IP ranges to block them
                                    </span>
                                </strong>
                                <div class="how_this_work"><a href="javascript:;"
                                        onClick="$('#mod_info').slideToggle();">How

                                        does it work?</a></div>
                                <div id="mod_info" style="display:none;" role="alert"
                                    class=" description alert alert-warning alert-dismissible "><strong>You can block
                                        exact IP or a range of IP addresses
                                        If you put * it will be taken as full range.</strong> <br />for example<br>
                                    (1). If you type <strong>165.139.149.169</strong> then this exact IP will be
                                    blocked. <br>
                                    (2). If you type <strong>165.139.149.*</strong> then all IPs in the last set will be
                                    blocked

                                    like 165.139.149.1, 165.139.149.102, 165.139.149.169 etc<br>
                                    (3). If you type <strong>165.139.*.*</strong> then all IPs starting 165.139. onwards
                                    will be blocked like 165.139.149.169, 165.139.100.102, 165.139.35.169 etc<br>
                                    <br>
                                    <strong>Your are not allowed to type 165.*.*.* OR *.*.*.*</strong> <br>
                                    Your own IP at this time is: <strong>{{ $_SERVER['REMOTE_ADDR'] }}</strong>
                                </div>
                                <input type="text" id="ipAddresses" class="form-control" name="ipAddresses[]"
                                    placeholder="Type IP to add" />
                            </div>
                        </div>
                        <div class="col-md-4 col-sm-5">
                            <div class="blockarea">
                                <h4>Website blocked area</h4>
                                <div class="formrow">
                                    <strong>
                                        <span class="radiobtn">
                                            <input type="radio" name="blocked_area" id="blockedContact1"
                                                value="contact_us"
                                                {{ strcmp($metaArray['blocked_area'], 'contact_us') ? '' : 'checked' }}>
                                            <i class="checkmark"></i> Contact us form
                                        </span>
                                    </strong>
                                </div>
                                <div class="formrow">
                                    <strong>
                                        <span class="radiobtn">
                                            <input type="radio" name="blocked_area" id="blockedContact2"
                                                value="website"
                                                {{ strcmp($metaArray['blocked_area'], 'website') ? '' : 'checked' }}>
                                            <i class="checkmark"></i> Whole website
                                        </span>
                                    </strong>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-8">
                            <div class="mb-2 margin-15">
                                <label class="form-label">Website Block Message</label>
                                <textarea class="form-control" id="web_blocked_msg" name="web_blocked_msg">{{ $metaArray['web_blocked_msg'] }}</textarea>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <input type="submit" name="change_network_details" value="update" id="ipAddressFormSubmit"
                                class="sitebtn" />
                        </div>
                    </div>
                </div>
            </form>
        </section>
        <section><hr/></section>
        <section class="content" id="disable-website">
            <div class="box">
                <h2 class="box-title"><i class="fas fa-arrow-circle-o-down" aria-hidden="true"></i> Disable Website
                </h2>
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
                        <div id="d_web">
                            <textarea class="form-control" id="web_down_msg" name="web_down_msg">
                                {{ old('web_down_msg') ? old('down_msg') : $setting_result->web_down_msg }}
                            </textarea>
                            <p></p>
                            <div class="mb-2">
                                <label class="form-label">
                                    @php
                                        $statusVal = old('web_down_status') ? old('web_down_status') : $setting_result->web_down_status;
                                        $checked = $statusVal == 1 ? 'checked' : '';
                                    @endphp
                                    <input id="web_down_status" name="web_down_status" type="checkbox"
                                        {{ $checked }} data-toggle="toggle" data-on="On" data-off="Off"
                                        data-onstyle="danger" data-offstyle="success">
                                    Disable Status
                                </label>
                                @php echo helptooltip('web_down_status') @endphp
                            </div>
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
    <script type="text/javascript" src="{{ base_url() . 'module/settings/admin/js/settings.js' }}"></script>
    <script type="text/javascript" src="{{ base_url() . 'back/js/magicsuggest.js' }}"></script>
    <script type="text/javascript">
        var countryList = new Array();
        @foreach ($countries as $country)
            countryList.push('{{ $country }}');
        @endforeach
        @php
            $allowed = $metaArray['allowed_countries'];
            $blocked = $metaArray['blocked_countries'];
            $blockedIPA = $metaArray['blocked_ips'];
            if (isset($allowed) && trim($allowed) != '') {
                $openCountries = explode(',', $metaArray['allowed_countries']);
            } else {
                $openCountries = [];
            }
            if (isset($allowed) && trim($allowed) != '') {
                $blockCountries = explode(',', $metaArray['blocked_countries']);
            } else {
                $blockIPs = [];
            }
            if (isset($blockedIPA) && trim($blockedIPA) != '') {
                $blockIPs = explode(',', $blockedIPA);
            } else {
                $blockIPs = [];
            }
        @endphp
        var openCounties = new Array();
        @foreach ($openCountries as $country)
            openCounties.push('{{ $country }}');
        @endforeach
        var blockedCounties = new Array();
        @foreach ($blockCountries as $country)
            blockedCounties.push('{{ $country }}');
        @endforeach
        var blockedIps = new Array();
        @foreach ($blockIPs as $ip)
            blockedIps.push('{{ $ip }}');
        @endforeach
        $(document).ready(function(e) {
            $('#openCounties').magicSuggest({
                data: 'setting/countries',
                method: 'GET',
                selectionPosition: 'bottom',
                valueField: 'iso',
                displayField: 'nicename',
                value: openCounties,
                maxSelection: 300,
                allowFreeEntries: false,
                renderer: function(data) {
                    return '<div class="country">' +
                        '<span class="flag-icon flag-icon-' + data.iso.toLowerCase() + '"></span> ' +
                        data.nicename +
                        '</div>';
                },
                selectionRenderer: function(data) {
                    return '<span class="flag-icon flag-icon-' + data.iso.toLowerCase() + '"></span> ' +
                        data.nicename;
                }
            });
            $('#blockedCounties').magicSuggest({
                data: 'setting/countries',
                method: 'GET',
                selectionPosition: 'bottom',
                valueField: 'iso',
                displayField: 'nicename',
                value: blockedCounties,
                allowFreeEntries: false,
                maxSelection: 300,
                renderer: function(data) {
                    return '<div class="country">' +
                        '<span class="flag-icon flag-icon-' + data.iso.toLowerCase() + '"></span> ' +
                        data.nicename +
                        '</div>';
                },
                selectionRenderer: function(data) {
                    return '<span class="flag-icon flag-icon-' + data.iso.toLowerCase() + '"></span> ' +
                        data.nicename;
                }
            });
            var IpMs = $('#ipAddresses').magicSuggest({
                data: blockedIps,
                value: blockedIps,
                selectionPosition: 'bottom',
                maxSelection: 2000,
                valueField: 'ipAddresses[]',
                vregex: /^([0-9]{1,3}\.){2}([0-9,*]{1,3}\.)[0-9,*]{1,3}$/
            });
            $(IpMs).on(
                'selectionchange',
                function(e, cb, s) {
                    if (this.isValid()) {
                        $("#ipAddressFormSubmit").attr("disabled", false);
                    } else {
                        alert("Invalid Input IP");
                        $("#ipAddressFormSubmit").attr("disabled", true);
                    }
                }
            );
        });
    </script>
@endsection
