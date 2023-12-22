@extends('front.layout.app')
@section('beforeHeadClose')
    <link href="{{ asset_storage('') . 'module/blog/front/css/blog.css' }}" rel="stylesheet" type="text/css" />
    <script src='https://www.google.com/recaptcha/api.js'></script>
    <style>
        .error-bg {
            background-color: #e6cfcf;
        }

        .error {
            color: #FF0000;
        }
    </style>
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
                            @php  echo adjustUrl($data->content) @endphp
                            <div id="errorMessages"></div>
                            <form action="#" method="POST" name="frm_process" id="contactForm" class="contact-form">
                                @csrf
                                <div class="col-md-12">
                                    <div class="row">
                                        <div class="form-group">
                                            <input name="name" type="text" placeholder="Name"
                                                value="{{ old('name') }}" class="form-control" id="name" required>
                                            <div id="name-error" class="error"></div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <input name="email" type="email" placeholder="Email"
                                                value="{{ old('email') }}" class="form-control" id="email" required>
                                            <div id="email-error" class="error"></div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <input name="phone" type="text" placeholder="Phone"
                                                value="{{ old('phone') }}" class="form-control" id="phone" required>
                                            <div id="phone-error" class="error"></div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="row">
                                        <div class="form-group comments">
                                            <textarea name="comments" placeholder="Message" class="form-control" rows="6" id="comments">{{ old('comments') }}</textarea>
                                            <div id="comments-error" class="error"></div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="row">
                                        <div class="g-recaptcha" data-sitekey="{{ config('recaptcha.siteKey') }}"></div>
                                        <div id="g-recaptcha-response-error" class="error"></div>
                                        <button type="button" onclick="submitContactForm();">Send Message <i
                                                class="fa fa-paper-plane"></i> </button>
                                    </div>
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
                            <iframe
                                src="https://maps.google.it/maps?q={{ strip_tags($settingArr->address) }}&output=embed">
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
    <script type="text/javascript">
        $(document).ready(function() {
            $("#contactForm").validate({
                rules: {
                    name: {
                        required: true
                    },
                    email: {
                        required: true,
                        email: true
                    },
                    phone: {
                        required: true,
                        phoneUS: true
                    },
                    'g-recaptcha-response': {
                        required: true
                    }
                },
                messages: {
                    name: {
                        required: "Please enter your name"
                    },
                    email: {
                        required: "Please provide email",
                        email: "Please provide valid email"
                    },
                    phone: {
                        required: "Please provide phone",
                        phoneUS: "Valid phone number required"
                    },
                    'g-recaptcha-response': {
                        required: "Please prove you are not a robot"
                    }
                },
                errorPlacement: function(error, element) {
                    var key = element[0].id;
                    $('#contactForm').find('#' + key + '-error').html(error);
                    $('#contactForm').find('#' + key + '-error').addClass('formValidationErrors');
                    $('#contactForm').find('#' + key + '-error').show();
                    scrollToErrors('.formValidationErrors');
                    $('#contactForm').find('#g-recaptcha-response').hide();
                },
                submitHandler: function() {
                    submitContactFormAjax();
                }
            });
        });

        function submitContactForm() {
            $('#contactForm').find('#g-recaptcha-response').prop('style', 'width:1px;height:1px;');
            $('#contactForm').find('#g-recaptcha-response').show();
            $('#contactForm').submit();
        }
        $('#contactForm').find('#phone').inputmask("999-999-9999");
    </script>
    <script>
        function submitContactFormAjax() {
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
                    data = JSON.parse(data);
                    if (data.status) {
                        $("#contactForm").trigger('reset');
                        Swal.fire({
                            title: 'Thank you!',
                            html: 'Your message has been sent.',
                            timer: 2000,
                            timerProgressBar: false
                        })
                    } else {
                        Swal.fire({
                            title: 'Sorry!',
                            html: data.error,
                            timer: 2000,
                            timerProgressBar: true
                        })
                    }
                },
                error: function(data) {
                    if (data.status === 422) {
                        var responseText = $.parseJSON(data.responseText);
                        $.each(responseText.errors, function(key, value) {
                            $('#contactForm').find('#' + key + '-error').html(value);
                            $('#contactForm').find('#' + key + '-error').addClass('formValidationErrors');
                            $('#contactForm').find('#' + key + '-error').show();
                            scrollToErrors('.formValidationErrors');
                        });
                    }
                }
            });
        }
    </script>
@endsection
