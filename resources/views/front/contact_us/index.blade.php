@extends('front.layout.app')
@section('beforeHeadClose')
    <link href="{{ base_url() . 'module/blog/front/css/blog.css' }}" rel="stylesheet" type="text/css" />
    @if (!$capImage)
        <script src='https://www.google.com/recaptcha/api.js'></script>
    @endif
@endsection
@section('content')
    @php $settingArr = settingArr(); @endphp
    @php
    //echo cms_page_heading('Contact us',118)
    @endphp
    @php echo cms_edit_page('cms',$data->id);@endphp
    <div class="about-wrap">

        <!-- Start Breadcrumb
        ============================================= -->
        <div class="breadcrumb-area shadow dark bg-fixed text-center text-light"
            style="background-image: url(<?php echo base_url(); ?>front/img/banner/23.jpg);">
            <div class="container">
                <div class="row">
                    <div class="col-lg-12 col-md-12">
                        <h1>Contact Us</h1>
                        <ul class="breadcrumb">
                            <li><a href="#"><i class="fas fa-home"></i> Home</a></li>
                            <li class="active">Contact</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        <!-- End Breadcrumb -->
        <!-- Start Contact Area
        ============================================= -->
        <div class="contact-area default-padding">
            <div class="container">
                <div class="row">
                    <div class="contact-items bg-contain" style="background-image: url(assets/img/map.svg);">
                        <div class="col-md-4 address">
                            <div class="address-items">
                                <ul class="info">
                                    @if (!empty($settingArr->address))
                                    <li>
                                        <h4>Office Location</h4>
                                        <div class="icon"><i class="fas fa-map-marked-alt"></i></div>
                                        <span> @php echo str_replace(chr(13), '<br/>', $settingArr->address); @endphp</span>

                                    </li>
                                    @endif
                                    <li>
                                        <h4>Phone</h4>
                                        <div class="icon"><i class="fas fa-phone"></i></div>
                                        <span>
                                            <a style="color:inherit;" href="tel:{{ $settingArr->mobile }}">+
                                                {{ strip_tags($settingArr->mobile) }}
                                            </a>
                                        </span>
                                    </li>
                                    <li>
                                        <h4>Email</h4>
                                        <div class="icon"><i class="fas fa-envelope"></i> </div>
                                        <span>
                                            <a style="color:inherit;" href="mail:{{ $settingArr->email }}">
                                                {{ strip_tags($settingArr->email) }}
                                            </a>
                                        </span>
                                    </li>
                                </ul>
                            </div>
                        </div>
                        <div class="col-md-8 contact-form">
                            <h2>Send Us A Message</h2>
                            @php  echo $data->content @endphp
                            <form action="#" method="POST" name="frm_process" id="contactForm" class="contact-form">
                                @csrf
                                <div class="col-md-12">
                                    <div class="row">
                                        <div class="form-group">
                                            <input name="name" type="text" placeholder="Name"
                                                value="{{ old('first_name') }}" class="form-control req" id="first_name"
                                                required>
                                            <span class="alert-error"></span>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <input name="email" type="email" placeholder="Email"
                                                value="{{ old('email') }}" class="form-control req valid_email"
                                                id="email" required>
                                            <span class="alert-error"></span>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <input name="phone" type="text" placeholder="Phone"
                                                value="{{ old('phone') }}" class="form-control req valid_phone"
                                                id="phone_number" data-placement="top" data-toggle="hover"
                                                title="Popover Header" data-content="Some content inside the popover"
                                                required>
                                            <span class="alert-error"></span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="row">
                                        <div class="form-group comments">
                                            <textarea name="message" placeholder="Message" class="form-control req" rows="6" id="message" required>{{ old('message') }}</textarea>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="row">
                                        @if (!$capImage)
                                            <div class="g-recaptcha" data-sitekey="{{ $siteKey }}"></div>
                                        @else
                                            <div class="form-group">
                                                <div class="image-captcha">Please type the following characters in the box
                                                    below: @php echo $capImage; @endphp
                                                    <a onclick="refreshCaptcha()" class="refresh_captcha"
                                                        href="javascript:void(0);">Refresh Captcha</a>
                                                </div>

                                            </div>
                                            <div class="form-group">
                                                <input type="text" name="cpt_code"
                                                    class="form-control contact-form small" id="cpt_code"
                                                    placeholder="Captcha Code" required>
                                            </div>
                                        @endif
                                        <div class="loader" id="loader" style="display: none"></div>
                                        <button type="button" id="btnSave" onclick="save()" class="sbutn"
                                            style="margin-bottom: 11px;margin-top: 5px;">Send Message <i
                                                class="fa fa-paper-plane"></i> </button>
                                    </div>
                                </div>
                                <!-- Alert Message -->
                                <div class="col-md-12 alert-notification">
                                    <div id="message" class="alert-msg"></div>
                                </div>
                            </form>

                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- End Contact Area -->
        <!-- Start Google Maps
        ============================================= -->
        @if ($settingArr->google_map_status == 1)
        <div class="maps-area">
            <div class="container-full">
                <div class="row">
                    <div class="google-maps">
                        <iframe src="https://maps.google.it/maps?q={{ strip_tags($settingArr->address) }}&output=embed">
                        </iframe>
                    </div>
                </div>
            </div>
        </div>
        @endif
        <!-- End Google Maps -->
    </div>
@endsection
@section('beforeBodyClose')
    <script src="{{ asset('lib/sweetalert2.js') }}"></script>
    <script>
        baseUrl = "{{ base_url() }}";

        function refreshCaptcha() {
            console.log("Refresh");
            var myurl = baseUrl + 'refresh';
            $.get(myurl, function(sts) {
                console.log(sts);
                $("#Imageid").attr("src", baseUrl + "captcha/images/" + sts.slice(1, -1));
            });
        }

        function save() {
            if (validateForm()) {
                $('#btnSave').css('display', 'none');
                $('#loader').css('display', 'block');
                url = "{{ base_url() }}contact-us";
                method = 'POST';
                header = '';
                let formData = new FormData($('#contactForm')[0]);
                console.log(formData);
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
                $.ajax({
                    url: url,
                    type: method,
                    data: formData,
                    headers: header,
                    async: true,
                    cache: false,
                    contentType: false,
                    processData: false,
                    success: function(data) {
                        console.log(data);
                        data = JSON.parse(data);
                        $('#btnSave').css('display', 'block');
                        $('#loader').css('display', 'none');
                        if (data.status) {
                            // $('#msgSuccess').text(data.error);
                            $("#contactForm").trigger('reset');
                            swal(
                                'Thank you!',
                                'Your message has been sent.',
                                'success'
                            );
                        } else {
                            swal(
                                'Sorry!',
                                data.error,
                                'error'
                            );
                            // $('#msgSuccess').text(data.error);
                        }
                    },
                    error: function(jqXHR, textStatus, errorThrown) {
                        alert('Error sending your request');
                        console.log(jqXHR);
                        console.log(textStatus);
                        console.log(errorThrown);
                    }
                });
            }
        }

        function validateForm() {
            $("#first_name").css('background-color', '');
            $("#phone_number").css('background-color', '');
            $("#email").css('background-color', '');
            $("#message").css('background-color', '');


            var text = '';
            var name = $("#first_name").val();
            var valid = true;
            if (name.length < 3) {
                text += "* Name must be valid <br>";
                $("#first_name").css('background-color', '#e6cfcf');
                valid = false;
            }
            var phone = $("#phone_number").val();
            var isnum = validatePhone(phone);
            console.log(isnum);
            if (!isnum || phone.length < 10) {
                text += "* Phone must be valid (<em>format: xxx-xxx-xxxx</em>) <br>";
                $("#phone_number").css('background-color', '#e6cfcf');
                valid = false;
            }
            var email = $("#email").val();
            if (!isEmail(email)) {
                text += "* Email must be valid  <br>";
                $("#email").css('background-color', '#e6cfcf');
                valid = false;
            }
            var message = $("#message").val();
            if (message.length < 10) {
                text += "* Message must be valid  <br>";
                $("#message").css('background-color', '#e6cfcf');
                valid = false;
            }
            if ($("#cpt_code").length > 0) {
                $("#cpt_code").css('background-color', '');
                var cpt_code = $("#cpt_code").val();
                if (cpt_code.length < 3) {
                    text += "* Captcha must be valid <br>";
                    $("#cpt_code").css('background-color', '#e6cfcf');
                    valid = false;
                }
            }
            if (!valid) {
                swal(
                    'ERROR',
                    text,
                    'error'
                );
                return false;
            }
            return true;
        }

        function isEmail(email) {
            var regex = /^([a-zA-Z0-9_.+-])+\@(([a-zA-Z0-9-])+\.)+([a-zA-Z0-9]{2,4})+$/;
            return regex.test(email);
        }

        function validatePhone(p) {
            var phoneRe = /^[1-9]\d{2}[1-9]\d{2}\d{4}$/;
            var digits = p.replace(/\D/g, "");
            return phoneRe.test(digits);
        }
        $('input.req,select.req,textarea.req').blur(function() {
            if ($(this).val() == '') {
                $(this).css("background-color", "#e6cfcf");
            } else {
                $(this).css("background-color", "");
            }
        });
        $('input.valid_email').blur(function() {
            if (isEmail($(this).val()) == false) {
                $(this).css("background-color", "#e6cfcf");
            } else {
                $(this).css("background-color", "");
            }

        });
        $('input.valid_phone').on('keydown', function(e) {
            var ssnval = $(this).val();
            var Len = ssnval.length;
            if (e.keyCode > 47 && e.keyCode < 58) {} else if (e.keyCode > 95 && e.keyCode < 106) {} else if (e
                .keyCode == 9) {
                return true;
            } else if (e.keyCode == 8 || e.keyCode == 13 || e.keyCode == 173) {} else {
                return false;
            }



            if (e.keyCode != 8) {
                if (e.keyCode != 173) {
                    if (Len == 3 || Len == 7) {

                        $(this).val($(this).val() + '-');
                    }
                    if (Len >= 12) {
                        return false;
                    }
                }
            }

        });
    </script>
@endsection
