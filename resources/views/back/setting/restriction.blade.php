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
                <div class="col-md-8 col-sm-6">
                    <ol class="breadcrumb">
                        <li>
                            <a href="{{ admin_url() }}"><i class="fas fa-gauge"></i> Home</a>
                        </li>
                        <li class="active"> Site Settings</li>
                    </ol>
                </div>
                <div class="col-md-4 col-sm-6">
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
        @if (\Session::has('error'))
            <div class="message-container">
                <div class="callout callout-danger">
                    <h4>{{ \Session::get('error') }}</h4>
                </div>
            </div>
        @endif
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
                                        data-toggle="toggle" data-on="On" data-off="Off"
                                        onclick="show_hide('#restrict_area',false);" data-onstyle="success"
                                        data-offstyle="danger" {{ $metaArray['restrict_traffic'] ? 'checked' : '' }}>
                                    <strong>Restrict Traffic Based on Countries</strong>
                                </label>
                                @php echo helptooltip('country_block_message') @endphp
                            </div>
                        </div>
                        <div class="col-md-8 col-sm-7">
                            <div class="formrow bdrbtm" id="restrict_area">
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
                            <p> </p>
                            <hr />
                            <div class="formrow bdrbtm">
                                <strong>
                                    <span class="">
                                        Add IPs or IP ranges to block them
                                    </span>
                                </strong>
                                <div class="how_this_work"><a href="javascript:;"
                                        onClick="$('#mod_info').slideToggle();">How
                                        does it work?</a></div>
                                <div id="mod_info" style="display:none;" role="alert"
                                    class=" description alert alert-warning alert-dismissible ">You can block
                                    exact IP or a range of IP addresses
                                    If you put <code>*</code> it will be taken as full range. <br />for example<br>
                                    (1). If you type <code>165.139.149.169</code> then this exact IP will be
                                    blocked. <br>
                                    (2). If you type <code>165.139.149.*</code> then all IPs in the last set will be
                                    blocked
                                    like 165.139.149.1, 165.139.149.102, 165.139.149.169 etc<br>
                                    (3). If you type <code>165.139.*.*</code> then all IPs starting 165.139. onwards
                                    will be blocked like 165.139.149.169, 165.139.100.102, 165.139.35.169 etc<br>
                                    <br>
                                    <strong class="text text-danger">Your are not allowed to type <code>165.*.*.*</code> OR
                                        <code>*.*.*.*</code></strong> <br>
                                    Your own IP at this time is: <strong
                                        class="text text-danger">{{ $_SERVER['REMOTE_ADDR'] }}</strong>
                                </div>
                                <input type="text" id="ipAddresses" class="form-control" name="ipAddresses[]"
                                    placeholder="Type IP to add" />
                            </div>

                            <div class="formrow bdrbtm">
                                <strong>
                                    <span class="">
                                        Add Negative Keywords
                                    </span>
                                </strong>
                                <div class="how_this_work"><a href="javascript:;"
                                        onClick="$('#mod_negative_keywords_info').slideToggle();">How does it work?</a>
                                </div>
                                <div id="mod_negative_keywords_info" style="display:none;" role="alert"
                                    class=" description alert alert-warning alert-dismissible ">Example: If someone is
                                    abusing your website contact form frequently and one of his sentence is "I am Eric Jones
                                    from www.talkwithwebtraffic.com....." Then just block the keyword
                                    "www.talkwithwebtraffic.com" In this case if this keyword is used, the form will not get
                                    submitted. </div>
                                <input type="text" id="negativeKeywords" class="form-control" name="negativeKeywords[]"
                                    placeholder="Type to add negative keyword" />
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
    </div>
@endsection
@section('beforeBodyClose')
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-toggle/2.2.2/css/bootstrap-toggle.min.css"
        rel="stylesheet">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-toggle/2.2.2/js/bootstrap-toggle.min.js"></script>
    <script type="text/javascript" src="{{ base_url() . 'module/settings/admin/js/settings.js' }}"></script>
    <script type="text/javascript" src="{{ base_url() . 'back/js/magicsuggest.js' }}"></script>
    <script type="text/javascript">
        var countryList = new Array();
        var url = '{{ admin_url() }}';
        @foreach ($countries as $country)
            countryList.push('{{ $country }}');
        @endforeach
        @php
            $allowed = $metaArray['allowed_countries'];
            $blocked = $metaArray['blocked_countries'];
            $blockedIPA = $metaArray['blocked_ips'];
            $negativeKeywords = explode(',', $metaArray['negative_keywords']);
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

        var negativeKeywords = new Array();
        @foreach ($negativeKeywords as $negativeKeyword)
            negativeKeywords.push('{{ $negativeKeyword }}');
        @endforeach

        $(document).ready(function(e) {
            $('#openCounties').magicSuggest({
                data: url + 'setting/countries',
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
                data: url + 'setting/countries',
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

            var negativeKeywordsMS = $('#negativeKeywords').magicSuggest({
                data: negativeKeywords,
                value: negativeKeywords,
                selectionPosition: 'bottom',
                maxSelection: 5000,
                valueField: 'negativeKeywords[]'
            });
            $(negativeKeywordsMS).on(
                'selectionchange',
                function(e, cb, s) {
                    $("#ipAddressFormSubmit").attr("disabled", false);
                }
            );

        });
    </script>
@endsection
