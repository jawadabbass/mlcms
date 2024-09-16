@extends('back.layouts.app', ['title' => $title ?? ''])
@section('content')
    <div class="content-wrapper pl-3 pr-2">
        <section class="content-header">
            <div class="row">
                <div class="col-md-5 col-sm-12">
                    <ol class="breadcrumb">
                        <li><a href="{{ admin_url() }}"><i class="fas fa-tachometer-alt"></i> Home</a></li>
                        <li class="active">Manage Admin Users</li>
                    </ol>
                </div>
                <div class="col-md-7 col-sm-12">
                    @include('back.common_views.quicklinks')
                </div>
            </div>
        </section>
        <section class="content">
            <div class="row">
                <div class="col-xs-12 col-md-12">
                    <div class="card p-2">
                        <form method="post" class="needs-validation" name="mass_mail_frm" id="mass_mail_frm"
                            action="{{ route('submit.mass.mail') }}" enctype="multipart/form-data" novalidate>
                            @csrf
                            <input type="hidden" name="save_update_template_or_just_send_mail"
                                id="save_update_template_or_just_send_mail" value="">
                            <input type="hidden" name="date" id="date" value="{{ date('m-d-Y') }}">
                            <input type="hidden" name="time" id="time" value="{{ date('h:i A') }}">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="row">
                                        <div class="col-md-2">
                                            <label>
                                                <h4>Send Email To:</h4>
                                            </label>
                                        </div>
                                        <div class="col-md-2">
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" value="Yes"
                                                    name="professionals" id="professionals" checked="checked">
                                                <label class="form-check-label mt-2 ml-2" for="professionals">
                                                    Professionals
                                                </label>
                                                <div class="invalid-feedback">
                                                    Please select send mail to option.
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-8">
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="checkbox" value="Yes"
                                                            name="contact" id="contact" checked="checked">
                                                        <label class="form-check-label  mt-2 ml-2" for="contact">
                                                            Leads
                                                        </label>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row" id="lead_date_from_to_div">
                                                <div class="col-md-3">
                                                    <label>
                                                        From:
                                                    </label>
                                                    <div class="input-group mb-3">
                                                        <input type="text" class="form-control" name="lead_date_from"
                                                            id="lead_date_from"
                                                            value="{{ date('m-d-Y', strtotime('-30 days')) }}"
                                                            required="required">
                                                        <div class="input-group-append" id="lead_date_from_calendar">
                                                            <span class="input-group-text"><i class="fa fa-calendar"
                                                                    aria-hidden="true" style="font-size: 22px;"></i></span>
                                                        </div>
                                                        <div class="invalid-feedback">
                                                            Please select Date From.
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-3">
                                                    <label>
                                                        To:
                                                    </label>
                                                    <div class="input-group mb-3">
                                                        <input type="text" class="form-control" name="lead_date_to"
                                                            id="lead_date_to" value="{{ date('m-d-Y') }}"
                                                            required="required">
                                                        <div class="input-group-append" id="lead_date_to_calendar">
                                                            <span class="input-group-text"><i class="fa fa-calendar"
                                                                    aria-hidden="true" style="font-size: 22px;"></i></span>
                                                        </div>
                                                        <div class="invalid-feedback">
                                                            Please select Date To.
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <hr />
                                    </div>
                                    {{--
                                <div class="col-md-12">
                                    <div class="row">
                                        <div class="col-md-3">
                                            <label>
                                                <h4>Date:</h4>
                                            </label>
                                            <div class="input-group mb-3">
                                                <input type="text" class="form-control" name="date" id="date"
                                                    value="{{ date('m-d-Y') }}">
                                                <div class="input-group-append" id="date_calendar">
                                                    <span class="input-group-text"><i class="fa fa-calendar"
                                                            aria-hidden="true" style="font-size: 22px;"></i></span>
                                                </div>
                                                <div class="invalid-feedback">
                                                    Please select Date.
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <label>
                                                <h4>Time:</h4>
                                            </label>
                                            <div class="input-group mb-3">
                                                <select class="form-control" name="time" id="time">
                                                    <option value="">Select Time</option>
                                                    @foreach (getTimeSlotsArray(0, 23) as $timeSlot)
                                                        <option value="{{ $timeSlot }}" {!! $timeSlot == '10:30 AM' ? 'selected="selected"' : '' !!}>
                                                            {{ $timeSlot }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                                <div class="input-group-append" id="time_picker">
                                                    <span class="input-group-text"><i class="fa fa-clock-o"
                                                            aria-hidden="true" style="font-size: 22px;"></i></span>
                                                </div>
                                                <div class="invalid-feedback">
                                                    Please select Time.
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <hr />
                                </div>
                                 --}}
                                    <div class="col-md-12">
                                        <label>
                                            <h4>Create new template or select one:</h4>
                                        </label>
                                        <div class="row">
                                            <div class="col-md-3">
                                                <input class="m-1" type="radio" value="new"
                                                    name="template_new_or_select" id="template_new" checked="checked">
                                                <label class="m-1">Create new template</label>
                                            </div>
                                            <div class="col-md-3">
                                                <input class="m-1" type="radio" value="select"
                                                    name="template_new_or_select" id="template_select">
                                                <label class="m-1">Select from templates</label>
                                            </div>
                                        </div>
                                        <hr />
                                        <div class="row mb-4" id="select_template_div" style="display: none;">
                                            <div class="col-md-3">
                                                <label>
                                                    <h4>Select template:</h4>
                                                </label>
                                                <select class="form-control" name="template_id" id="template_id">
                                                    {!! generateMailTemplatesDropDown('', true) !!}
                                                </select>
                                                <div class="invalid-feedback">
                                                    Please select Template.
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row" id="template_div"></div>
                                        <hr />
                                    </div>
                                </div>
                            </div>
                        </form>
                        <br>
                        <div class="row">
                            <div class="col-md-12 text-right">
                                <button type="button" class="btn btn-warning m-2" id="save_new_template"
                                    onclick="sendMassMail('save_new_template');">
                                    <i class="fa fa-envelope-o" aria-hidden="true"></i> Save New Template and Send
                                    Email</button>
                                <button type="button" class="btn btn-warning m-2"
                                    onclick="sendMassMail('update_selected_template');" id="update_selected_template">
                                    <i class="fa fa-envelope-o" aria-hidden="true"></i> Update Selected Template and Send
                                    Email</button>
                                <button type="button" class="btn btn-primary m-2"
                                    onclick="sendMassMail('do_not_update_selected_template');"
                                    id="do_not_update_selected_template">
                                    <i class="fa fa-envelope-o" aria-hidden="true"></i> Send Email</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
    @include('back.common_views.spinner')
@endsection
@section('beforeBodyClose')
    <script src="{{ asset('lib/sweetalert2.js') }}"></script>
    <script type="text/javascript">
        function initDateTimePicker() {
            var date = [{
                "mask": "__-__-____"
            }];
            /**********************************/
            /**********************************/
            $("#date").datepicker({
                changeMonth: true,
                changeYear: true,
                minDate: 0,
                dateFormat: 'mm-dd-yy',
                showButtonPanel: true
            });
            $('#date').inputmask({
                mask: date,
                greedy: false,
                definitions: {
                    '_': {
                        validator: "[0-9]",
                        cardinality: 1
                    }
                }
            });
            /**********************************/
            /**********************************/
            $("#lead_date_from").datepicker({
                changeMonth: true,
                changeYear: true,
                dateFormat: 'mm-dd-yy',
                showButtonPanel: true
            });
            $('#lead_date_from').inputmask({
                mask: date,
                greedy: false,
                definitions: {
                    '_': {
                        validator: "[0-9]",
                        cardinality: 1
                    }
                }
            });
            $("#lead_date_to").datepicker({
                changeMonth: true,
                changeYear: true,
                dateFormat: 'mm-dd-yy',
                showButtonPanel: true
            });
            $('#lead_date_to').inputmask({
                mask: date,
                greedy: false,
                definitions: {
                    '_': {
                        validator: "[0-9]",
                        cardinality: 1
                    }
                }
            });
        }
        $(document).ready(function() {
            getMailTemplateView(0);
            initDateTimePicker();
        });
        $('#date_calendar').on('click', function() {
            $("#date").trigger("focus");
        });
        $('#lead_date_from_calendar').on('click', function() {
            $("#lead_date_from").trigger("focus");
        });
        $('#lead_date_to_calendar').on('click', function() {
            $("#lead_date_to").trigger("focus");
        });

        $('#contact').on('change', function() {
            $('#lead_date_from').attr('required', false);
            $('#lead_date_to').attr('required', false);
            $('#lead_date_from_to_div').hide();
            if ($('#contact').is(":checked")) {
                $('#lead_date_from').attr('required', true);
                $('#lead_date_to').attr('required', true);
                $('#lead_date_from_to_div').show();
            }
        });

        function sendMassMail(val) {

            $('#save_update_template_or_just_send_mail').val(val);

            $('#professionals').attr('required', false);
            $('#contact').attr('required', false);
            if (!$('#professionals').is(":checked") && !$('#contact').is(":checked")) {
                $('#professionals').attr('required', true);
                $('#contact').attr('required', true);
            }

            $('#template_id').attr('required', false);
            if ($('#template_select').is(":checked")) {
                $('#template_id').attr('required', true);
            }

            $('#locations_error').hide();
            $('input[name="locations[]"]').attr('required', false);
            if ($('input[name="locations[]"]:checked').length == 0) {
                $('input[name="locations[]"]').attr('required', true);
                $('#locations_error').show();
            }

            //$('#email_template').css('visibility', 'visible');
            $('#email_template').css('display', 'block');
            $('#email_template').css('height', '1px');
            $('#email_template').css('width', '1px');
            $('#email_template').attr('required', true);

            var form = $('#mass_mail_frm')[0];
            form.classList.add('was-validated');
            if (form.checkValidity()) {
                $('#mass_mail_frm').submit();
                $('.spinner').show();

            }

        }

        $('input[name="locations[]"]').on('change', function() {
            if ($('input[name="locations[]"]:checked').length == 0) {
                $('input[name="locations[]"]').attr('required', true);
                $('#locations_error').show();
            } else {
                $('input[name="locations[]"]').attr('required', false);
                $('#locations_error').hide();
            }
        });

        function toggleSaveNewTemplateButton(show_hide) {
            if (show_hide == 'show') {
                $('#save_new_template').show();
                $('#update_selected_template').hide();
                $('#do_not_update_selected_template').hide();
            } else {
                $('#save_new_template').hide();
                $('#update_selected_template').show();
                $('#do_not_update_selected_template').show();
            }
        }

        $('input[name="template_new_or_select"]').on('change', function() {
            if ($('input[name="template_new_or_select"]:checked').val() == 'new') {
                $('#template_div').show();
                getMailTemplateView(0);
                $('#select_template_div').hide();
            } else {
                $('#template_div').hide();
                $('#select_template_div').show();
                toggleSaveNewTemplateButton('hide');
                if ($('#template_id').val() > 0) {
                    getMailTemplateView($('#template_id').val());
                    $('#template_div').show();
                }
            }
        });

        $('#template_id').on('change', function() {
            if ($('#template_id').val() > 0) {
                getMailTemplateView($('#template_id').val());
                $('#template_div').show();
            } else {
                $('#template_div').html('');
                $('#template_div').hide();
            }
        });

        function getMailTemplateView(id) {
            $('#template_div').html('');
            $.ajax({
                url: '{{ route('get.mail.template.view') }}',
                method: 'post',
                data: {
                    "id": id,
                    "_token": "{{ csrf_token() }}"
                },
                success: function(response) {
                    $('#template_div').html(response);
                    initCKEDITOR('email_template');
                    if (id > 0) {
                        toggleSaveNewTemplateButton('hide');
                    } else {
                        toggleSaveNewTemplateButton('show');
                    }
                }
            });
        }

        function initCKEDITOR(id) {
            var editor = CKEDITOR.replace(id);
            CKEDITOR.config.allowedContent = true;
            CKEDITOR.config.autoParagraph = false;
            editor.on('change', function(evt) {
                $('#email_template').val(evt.editor.getData());
            });
        }
    </script>
@endsection
