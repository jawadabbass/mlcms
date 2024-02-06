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
        echo cms_page_heading('Google Calendar',261)
    @endphp
    @php echo cms_edit_page('cms',$data->id);@endphp
    <div class="about-wrap">
        <div class="contact-area default-padding">
            <div class="container">
                <div class="row">
                    <div class="contact-items bg-contain" style="background-image: url(assets/img/map.svg);">                        
                        <div class="col-md-3">
                        </div>
                        <div class="col-md-6 contact-form">
                            <h2>Add Event</h2>
                            <a class="text-primary" href="{{ url('show-google-calendar') }}" target="_blank">Show Google Calendar</a>
                            @php  echo adjustUrl($data->content) @endphp
                            <div id="errorMessages"></div>
                            <form action="#" method="POST" name="frm_process" id="eventForm" class="contact-form">
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
                                            <input name="startDate" type="date" placeholder="Start Date "
                                                value="{{ old('startDate') }}" class="form-control" id="startDate" required>
                                            <div id="startDate-error" class="error"></div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <input name="startTime" type="time" placeholder="Start Time"
                                                value="{{ old('startTime') }}" class="form-control" id="startTime" required>
                                            <div id="startTime-error" class="error"></div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <input name="endDate" type="date" placeholder="End Date "
                                                value="{{ old('endDate') }}" class="form-control" id="endDate" required>
                                            <div id="endDate-error" class="error"></div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <input name="endTime" type="time" placeholder="End Time"
                                                value="{{ old('endTime') }}" class="form-control" id="endTime" required>
                                            <div id="endTime-error" class="error"></div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <select name="eventColor" class="form-control" id="eventColor" required>
                                            <option value="1">1</option>
                                            <option value="2">2</option>
                                            <option value="3">3</option>
                                            <option value="4">4</option>
                                            <option value="5">5</option>
                                            <option value="6">6</option>
                                            <option value="7">7</option>
                                            <option value="8">8</option>
                                            <option value="9">9</option>
                                            <option value="10">10</option>
                                            <option value="11">11</option>
                                            </select>
                                            <div id="eventColor-error" class="error"></div>
                                        </div>
                                    </div>
                                </div>        
                                <div class="col-md-12">
                                    <div class="row">
                                        <div class="g-recaptcha" data-sitekey="{{ config('recaptcha.siteKey') }}"></div>
                                        <div id="g-recaptcha-response-error" class="error"></div>
                                        <button type="button" onclick="submitEventForm();">Save Event <i
                                                class="fa fa-paper-plane"></i> </button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('beforeBodyClose')
    <script type="text/javascript">
        $(document).ready(function() {
            $("#eventForm").validate({
                rules: {
                    name: {
                        required: true
                    },
                    startDate: {
                        required: true
                    },
                    startTime: {
                        required: true
                    },                    
                    endDate: {
                        required: true
                    },
                    endTime: {
                        required: true
                    },
                    'g-recaptcha-response': {
                        //required: true
                    }
                },
                messages: {
                    name: {
                        required: "Please enter event name"
                    },
                    startDate: {
                        required: "Please provide start date"
                    },
                    startTime: {
                        required: "Please provide start time"
                    },
                    endDate: {
                        required: "Please provide end date"
                    },
                    endTime: {
                        required: "Please provide end time"
                    },
                    'g-recaptcha-response': {
                        required: "Please prove you are not a robot"
                    }
                },
                errorPlacement: function(error, element) {
                    var key = element[0].id;
                    $('#eventForm').find('#' + key + '-error').html(error);
                    $('#eventForm').find('#' + key + '-error').addClass('formValidationErrors');
                    $('#eventForm').find('#' + key + '-error').show();
                    scrollToErrors('.formValidationErrors');
                    $('#eventForm').find('#g-recaptcha-response').hide();
                },
                submitHandler: function() {
                    submitEventFormAjax();
                }
            });
        });

        function submitEventForm() {
            $('#eventForm').find('#g-recaptcha-response').prop('style', 'width:1px;height:1px;');
            $('#eventForm').find('#g-recaptcha-response').show();
            $('#eventForm').submit();
        }
    </script>
    <script>
        function submitEventFormAjax() {
            url = "{{ base_url() }}google-calendar";
            method = 'POST';
            header = '';
            let formData = new FormData($('#eventForm')[0]);
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
                        $("#eventForm").trigger('reset');
                        Swal.fire({
                            title: 'Thank you!',
                            html: 'Your event has been saved.',
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
                            $('#eventForm').find('#' + key + '-error').html(value);
                            $('#eventForm').find('#' + key + '-error').addClass('formValidationErrors');
                            $('#eventForm').find('#' + key + '-error').show();
                            scrollToErrors('.formValidationErrors');
                        });
                    }
                }
            });
        }
    </script>
@endsection
