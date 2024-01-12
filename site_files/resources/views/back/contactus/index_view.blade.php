@extends('back.layouts.app', ['title' => $title])
@section('content')
    <div class="content-wrapper pl-3 pr-2">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="row">
                <div class="col-md-5 col-sm-12">
                    <div class="animation_ul" id="bell_reset">
                        <a href="{{ admin_url() }}"> <i class="fas fa-tachometer-alt"></i> Home </a> - Contact Leads
                        @if ($contact > 0)
                            <span class="ringing-bell blink_me" style="color:red;"> <i
                                    class='fas fa-bell faa-ring animated fa-2x'></i>
                            </span>
                        @endif
                    </div>
                </div>
                <div class="col-md-7 col-sm-12"> @include('back.common_views.quicklinks') </div>
            </div>
        </section>
        <!-- Main content -->
        <section class="content">
            <div class="row">
                <div class="col-xs-12 col-md-12">
                    <div class="box">
                        <div class="box-body">
                            @if (Session::has('msg'))
                                <p class="alert alert-success">{{ Session::get('msg') }}</p>
                            @endif
                            <div class="text-end">
                                <a href="{{ admin_url() }}contact_request/export/excel" class="btn btn-warning">
                                    <i class="fa fa-list" aria-hidden="true"></i> Export To Excel
                                </a>

                                <a href="{{ admin_url() }}contact_request/create" class="btn btn-info">
                                    <i class="fas fa-plus-circle" aria-hidden="true"></i> Add New
                                    Lead</a>
                                <a href="{{ route('email_templates.index') }}" class="btn btn-info">
                                    <i class="fas fa-envelope-square" aria-hidden="true"></i>&nbsp;Email Template
                                    Management</a>
                                {{-- <a href="{{ route('message.index') }}" class="btn btn-info">
                                    <i class="fas awesome_style fa-share" aria-hidden="true"></i>&nbsp;Message Template
                                    Management</a> --}}
                                <a href="javascript:;" onclick="send_template_email('','lead','combine')"
                                    class="btn btn-info">
                                    <i class="fas fa-envelope-square" aria-hidden="true"></i>&nbsp;Send Email
                                </a>
                                {{-- <a href="javascript:;" onclick="send_template_sms('','lead','combine')"
                                    class="btn btn-info">
                                    <i class="fas awesome_style fa-share" aria-hidden="true"></i>&nbsp;Send SMS
                                </a> --}}
                            </div>
                            <br>
                            <form method="get" action="{{ route('contact_request.index') }}" id="search_form">
                                <input type="hidden" name="read_lead" id="read_lead"
                                    value="{{ request()->input('read_lead', 2) }}" />
                                <input type="hidden" name="previous_sts" id="previous_sts" value="<?php if (isset($_GET['dates'])) {
                                    echo $_GET['dates'];
                                } ?>">
                                <div class="row" onKeyPress="return checkSubmit(event)">
                                    <div class="col-md-3">
                                        <input type="text" name="name" class="form-control"
                                            placeholder="Search By Name,Email" value='<?php if (isset($_GET['name'])) {
                                                echo $_GET['name'];
                                            } ?>'>
                                    </div>
                                    <div class="col-md-3 form-group">
                                        <input type="text" name="dates" id="reportrange" placeholder="All"
                                            class="form-control">
                                    </div>
                                    <div class="col-md-2 text-start">
                                        <button type="submit" onclick="showLoader();" class="btn btn-info"><i class="fas fa-search"
                                                aria-hidden="true"></i> Search</button>
                                        <a class="btn btn-warning" href="{{ route('contact_request.index') }}"><i
                                                class="fas fa-sync" aria-hidden="true"></i>Reset</a>
                                    </div>
                                </div>
                            </form>
                            <form method="post" onSubmit="return confirm('Are you sure?');"
                                action="{{ route('contact_request.bulk.actions') }}" id="bulk_actions_contact_request_form">
                                @csrf
                                <input type="hidden" name="bulk_action" id="bulk_action" value="delete" />
                                <div class="row">
                                    <div class="col-md-12">
                                        <button type="submit" onclick="showLoader();" class="btn btn-small btn-primary m-1 bulk_actions"
                                            onclick="setBulkAction('read');" style="display:none;">Mark All Read</button>
                                        <button type="submit" onclick="showLoader();" class="btn btn-small btn-danger m-1 bulk_actions"
                                            onclick="setBulkAction('delete');" style="display:none;">Delete</button>
                                        @if (request()->input('read_lead', 2) == 1 || request()->input('read_lead', 2) == 2)
                                            <button type="button" class="btn btn-small btn-warning m-1"
                                                onclick="filterReadStatus(0);">Show Unread</button>
                                        @else
                                            <button type="button" class="btn btn-small btn-warning m-1"
                                                onclick="filterReadStatus(2);">Show All</button>
                                        @endif
                                    </div>
                                </div>
                                <div class="table-responsive">
                                    <table class="table table-bordered table-inverse table-hover">
                                        <thead>
                                            <tr>
                                                <th>
                                                    <input type="checkbox" id="contact_request_check_all" />
                                                </th>
                                                <th></th>
                                                <th width="8%">ID</th>
                                                <th>Name</th>
                                                <th>Email</th>
                                                <th>Phone</th>
                                                <th>Service</th>
                                                {{-- <th>Package</th> --}}
                                                <th>Date</th>
                                                <th>Comment</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @php
                                                $Bstatus = '';
                                                $BGcolor = '';
                                            @endphp
                                            @if (count($result) > 0)
                                                @foreach ($result as $row)
                                                    @php
                                                        $bgColor = isset($bgColor) && $bgColor == '#f9f9f9' ? '#FFFFFF' : '#f9f9f9';
                                                    @endphp
                                                    <tr id="trr{{ $row->id }}"
                                                        onclick="read_data(<?php echo $row->id; ?>)">
                                                        <td><input type="checkbox" class="contact_request_check"
                                                                name="contact_request_check[]"
                                                                value="<?php echo $row->id; ?>" />
                                                        </td>
                                                        <td><a style="font-size: 24px;" data-toggle="tooltip"
                                                                title="" href="javascript:;"
                                                                onclick="showme_page('#subtrr{{ $row->id }}',this)"
                                                                data-original-title="Show more"><i
                                                                    class="fas fa-angle-double-down"
                                                                    aria-hidden="true"></i></a></td>
                                                        <td>{{ $row->id }}
                                                            @if ($row->read_lead == 0)
                                                                <strong style="color: red;font-size: 20px;"
                                                                    class="blink_me"
                                                                    id="read11_value-<?php echo $row->id; ?>">!</strong>
                                                            @endif
                                                        </td>
                                                        <td>{{ $row->name }}</td>
                                                        <td><a href="mailto:{{ $row->email }}">{{ $row->email }}</a>
                                                        </td>
                                                        <td><a href="tel:{{ $row->phone }}">{{ $row->phone }}</a>
                                                        </td>
                                                        <td>{{ $row->service }}</td>
                                                        {{-- <td>
                                                            <select class="form-control"
                                                                onchange="update_package('{{ $row->id }}',this.value)">
                                                                <option value="">-Select-</option>
                                                                @foreach ($get_all_packages as $kk => $package)
                                                                    <option value="{{ $package->id }}"
                                                                        @if ($row->package_id == $package->id) selected="" @endif>
                                                                        {{ $package->heading }}</option>
                                                                @endforeach
                                                            </select>
                                                        </td> --}}
                                                        <td>{{ format_date($row->dated, 'date_time') }}</td>
                                                        <td>
                                                            <a href="javascript:;" data-bs-toggle="popover" data-bs-trigger="focus"
                                                                class="btn btn-sm btn-success" data-bs-placement="bottom"
                                                                data-bs-title="User Comment"
                                                                data-bs-content="{{ $row->comments }}">
                                                                <i class="fas fa-comment" aria-hidden="true"></i>
                                                            </a>
                                                        </td>
                                                    </tr>
                                                    <tr style="display: none;" id="subtrr{{ $row->id }}">
                                                        <td colspan="2">
                                                            <strong>IP: </strong>{{ $row->ip }} <br>
                                                            <strong>Added By: </strong>{{ $row->user->name ?? '-' }} <br>
                                                        </td>
                                                        <td colspan="7">
                                                            <a class="btn btn-sm btn-info"
                                                                href="mailto:{{ $row->email }}"
                                                                title="Reply via Email">
                                                                <i class="fas fa-reply" aria-hidden="true"></i>
                                                                Reply</a>

                                                            <a onclick="comment_model({{ $row->id }})"
                                                                class="btn btn-success  btn-sm" style="color: white;"><i
                                                                    class="fas fa-edit" aria-hidden="true"></i> Add
                                                                Comment</a>
                                                            <a href="{{ route('contact_request.show', $row->id) }}"
                                                                class="btn btn-success  btn-sm"><i class="fas fa-history"
                                                                    aria-hidden="true"></i>
                                                                History</a>
                                                            @if (isset($clientArr[$row->email]))
                                                                <a class="btn btn-sm btn-success" target="_blank"
                                                                    href="{{ admin_url() }}manage_clients/{{ $clientArr[$row->email] }}"><i
                                                                        class="fas fa-user" aria-hidden="true"></i>
                                                                    Existing Client</a>
                                                            @else
                                                                <a class="btn btn-sm btn-warning" href="javascript:;"
                                                                    onclick="convert_client('{{ $row->id }}')"><i
                                                                        class="fas fa-user" aria-hidden="true"></i>
                                                                    Convert to Client</a>
                                                            @endif
                                                            <a class="btn btn-sm btn-info"
                                                                onclick="send_template_email('{{ $row->id }}','lead','single')"
                                                                href="javascript:"><i class="fas fa-envelope-square"></i>
                                                                Send
                                                                Email</a>
                                                            {{-- <a onclick="send_template_sms('{{ $row->id }}','lead','single')"
                                                                class="btn btn-sm btn-info" href="javascript:"><i
                                                                    class="fas awesome_style fa-share"></i> Send
                                                                Message</a> --}}
                                                            @if ($row->assesment_status == 'sent')
                                                                <a onclick="send_assessment_email('{{ $row->id }}','lead')"
                                                                    class="btn btn-sm btn-primary" href="javascript:"><i
                                                                        class="fas fa-envelope-square"></i> reSend
                                                                    Questionnaire</a>
                                                            @elseif($row->assesment_status == 'receive')
                                                                <a class="btn btn-sm btn-info" href="javascript:"
                                                                    data-toggle="modal"
                                                                    data-target="#largeShoes-<?php echo $row->id; ?>"><i
                                                                        class="fas fa-envelope-square"></i>View
                                                                    Answered
                                                                    Questions</a>
                                                            @else
                                                                {{-- <a href="javascript:;"
                                                                    onclick="send_assessment_email('{{ $row->id }}','lead')"
                                                                    class="btn btn-sm btn-primary" href="javascript:"><i
                                                                        class="fas fa-envelope-square"></i> Send
                                                                    Questionnaire</a> --}}
                                                            @endif
                                                            <a class="btn btn-sm btn-danger" href="javascript:"
                                                                onclick="del_recrod('{{ $row->id }}');"
                                                                title="Delete"><i class="fas fa-trash"
                                                                    aria-hidden="true"></i>
                                                                Delete</a>
                                                            <div class="modal" id="largeShoes-<?php echo $row->id; ?>"
                                                                tabindex="-1" role="dialog"
                                                                aria-labelledby="modalLabelLarge" aria-hidden="true">
                                                                <div class="modal-dialog modal-lg">
                                                                    <div class="modal-content">
                                                                        <div class="modal-header">
                                                                            <h4 class="modal-title" id="modalLabelLarge">
                                                                                Answered Questions</h4>
                                                                            <button type="button" class="close"
                                                                                data-bs-dismiss="modal"
                                                                                aria-label="Close">
                                                                            </button>
                                                                        </div>
                                                                        <div class="modal-body">
                                                                            <div class="table-responsive">
                                                                                <table class="table table-striped">
                                                                                    <thead>
                                                                                        <tr>
                                                                                            <th scope="col">Question(s)
                                                                                            </th>
                                                                                            <th scope="col">Answer(s)
                                                                                            </th>
                                                                                        </tr>
                                                                                    </thead>
                                                                                    <tbody>
                                                                                        @if (!$row->assessment == null)
                                                                                            @foreach ($row->assessment as $p_question)
                                                                                                <tr>
                                                                                                    <td>{{ $p_question->assessment_question->question }}
                                                                                                    </td>
                                                                                                    <td>
                                                                                                        @if (is_array(json_decode($p_question->answer)) || is_object(json_decode($p_question->answer)))
                                                                                                            @foreach (json_decode($p_question->answer) as $key => $ans)
                                                                                                                {{ $key }}<br>
                                                                                                            @endforeach
                                                                                                        @else
                                                                                                            {{ $p_question->answer }}
                                                                                                        @endif
                                                                                                    </td>
                                                                                                </tr>
                                                                                            @endforeach
                                                                                        @endif
                                                                                    </tbody>
                                                                                </table>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            @else
                                                <tr>
                                                    <td> No Record found!</td>
                                                </tr>
                                            @endif
                                        </tbody>
                                    </table>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <div> {{ $result->links() }} </div>
            <div class="modal fade" id="exampleModal-comment" tabindex="-1" role="dialog"
                aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Add Comment</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                            </button>
                        </div>
                        <form name="frm_process" id="contactFormComment" class="contact-form">
                            @csrf
                            <div class="modal-body">
                                <input type="hidden" name="contact_id" class="form-control" id="request_comment">
                                <div class="col-sm-12">
                                    <label>Enter Comment</label>
                                    <textarea class="form-control" name="message" id="message"></textarea>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                {{-- <input type="submit" onclick="showLoader();" value="Send Request Review Email" class="btn btn-primary"> --}}
                                <button type="button" class="btn btn-primary" onclick="comment_save()">Save
                                    Comment</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <div class="modal fade" id="exampleModal-price" tabindex="-1" role="dialog"
                aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Current Price Is
                                <strong id="price_value"></strong>
                            </h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                            </button>
                        </div>
                        <form name="frm_process" id="contactFormPrice" class="contact-form">
                            @csrf
                            <div class="modal-body">
                                <input type="hidden" name="contact_id" class="form-control" id="contact_ids"
                                    value="">
                                <div class="col-sm-12">
                                    <label>Enter Price</label>
                                    <input type="number" name="price" class="form-control" id="price"
                                        value="">
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                {{-- <input type="submit" onclick="showLoader();" value="Send Request Review Email" class="btn btn-primary"> --}}
                                {{-- @if ($row->price == 0) --}}
                                <button type="button" class="btn btn-primary" onclick="Price_save()">Save Price</button>
                                {{-- @endif --}}
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <div class="modal fade" id="SMS_Template_model" tabindex="-1" role="dialog"
                aria-labelledby="SMS_Template_model-2" aria-hidden="true">
                <div class="modal-dialog modal-lg" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="SMS_Template_model-2">SMS Template</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                            </button>
                        </div>
                        <form id="smsTemplateForm">
                            @csrf
                            <div class="modal-body">
                                <input type="hidden" name="sms_receiver_user_id" id="sms_receiver_user_id">
                                <input type="hidden" name="sms_receiver_type" id="sms_receiver_type">
                                <input type="hidden" name="sms_value_send" id="sms_value_send">
                                <div class="form-group">
                                    <label for="">Select SMS Template</label>
                                    <select class="form-control" name="sms_template_id" id="sms_template_id">
                                        @foreach ($sms_template as $temp)
                                            <option value="{{ $temp->id }}">{{ $temp->title }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="">Subject Of SMS</label>
                                    <input name="sms_subject" id="sms_subject" class="form-control">
                                </div>
                                <div class="form-group">
                                    <div id="user_email_area">
                                        <div class="row" style="margin-top:10px;">
                                            <div class="col-sm-12">
                                                <label for="User SMS Body:">User SMS Body:</label>
                                                <textarea name="sms_user_body" id="sms_user_body" class="form-control" required="">
                                        </textarea>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div id="sms_combine_send" style="display: none;">
                                    <div class="form-group">
                                        <label style="margin-top: 10px;font-size:18px;">Do You Want Send This SMS To
                                            Client's</label>
                                        <input type="checkbox" name="sms_send_to_client">
                                    </div>
                                    <div class="col-sm-12" id="sms_client_packages_id" style="display:none;">
                                        <p>Please Select Package</p>
                                        <div class="row">
                                            @foreach ($get_all_packages as $package)
                                                <div class="col-sm-3">
                                                    <div class="form-group">
                                                        <label
                                                            style="margin-top: 10px;font-size:18px;">{{ $package->heading }}</label>
                                                        <input type="checkbox"
                                                            name="sms_client_package[{{ $package->id }}]">
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label style="margin-top: 10px;font-size:18px;">Do You Want Send This SMS To
                                            Leads's</label>
                                        <input type="checkbox" name="sms_send_to_leads">
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <label style="margin-top: 10px;">Save Changes In Selected SMS Template</label>
                                    <input type="checkbox" name="new_temp">
                                    <button type="button" class="btn btn-secondary"
                                        data-bs-dismiss="modal">Close</button>
                                    <button type="button" class="btn btn-primary" onclick="save_sms_record_send()">Send
                                        SMS</button>
                                </div>
                        </form>
                    </div>
                </div>
            </div>
        </section>
    </div>
    @include('back.clients.common.modal')
@endsection
@section('beforeBodyClose')
    <script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />
    <script src="{{ asset_storage('lib/sweetalert/sweetalert2.js') }}"></script>
    <script type="text/javascript" src="{{ asset_storage('') }}back/mod/mod_js.js"></script>
    @include('back.clients.common.scripts')
    @include('back.clients.common.sms_script')
    <script>
        $(document).ready(function() {
            $('[data-bs-toggle="popover"]').popover();
        });

        $('html').on('mouseup', function(e) {
            if (!$(e.target).closest('.popover').length) {
                $('.popover').each(function() {
                    $(this.previousSibling).popover('hide');
                });
            }
        });

        function del_recrod(id) {
            if (confirmDel()) {
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
                $.ajax({
                    type: "DELETE",
                    url: "{{ admin_url() }}contact_request/" + id,
                    data: {
                        '_token': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function(data) {
                        if (JSON.parse(data).status) {
                            $("#trr" + id).fadeOut(1000);
                            $("#subtrr" + id).hide(1000);
                            $("#subtr" + id).fadeOut(1000);
                            var tolrec = $("#total_rec").html();
                            var tolrec = $("#total_rec").html(parseInt(tolrec) - 1);
                            // location.reload();
                        } else {
                            alert('ERROR: Deleting');
                            console.log(data);
                        }
                    },
                });
            }
        }

        function convert_client(id) {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                type: "GET",
                url: "{{ route('lead_convert_client', '') }}" + "/" + id,
                data: {
                    '_token': $('meta[name="csrf-token"]').attr('content')
                },
                success: function(response) {
                    var data = JSON.parse(response);
                    if (data.status == 'error') {
                        alertme('<i class="fas fa-check" aria-hidden="true"></i> Sorry This Client Already Exist ',
                            'danger', true, 1500);
                    } else {
                        // location.reload();
                        alertme('<i class="fas fa-check" aria-hidden="true"></i> Done Successfully ',
                            'success',
                            true, 1500);
                        $("#trr" + id).fadeOut(1000);
                        $("#subtrr" + id).hide(1000);
                        $("#subtr" + id).fadeOut(1000);
                        var tolrec = $("#total_rec").html();
                        var tolrec = $("#total_rec").html(parseInt(tolrec) - 1);
                    }
                }
            });
        }

        function read_data(id) {
            $.ajax({
                type: "GET",
                url: "{{ admin_url() }}read_data_contact_lead/" + id,
                data: {
                    '_token': $('meta[name="csrf-token"]').attr('content')
                },
                success: function(data) {
                    $("#read11_value-" + id).remove();
                    // $("#contact_us_lead").reload();
                    $("#bell_reset").load(location + " #bell_reset");
                },
            });
        }
    </script>
    <script>
        function comment_save() {
            var id = $('#contact_id').val();
            if (validateForm1()) {
                $('#btnSave').css('display', 'none');
                $('#loader').css('display', 'block');
                url = "{{ route('lead_comments') }}";
                method = 'POST';
                header = '';
                let formData = new FormData($('#contactFormComment')[0]);
                // console.log(formData);
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
                            $("#contactFormComment").trigger('reset');
                            // $('#exampleModal-comment-'+id).modal('hide');
                            $('#exampleModal-comment').modal('hide');
                            $("#message").val('');
                            swal(
                                'Thank you!',
                                'Your Comment Has Been Saved.',
                                'success'
                            );
                            location.reload();
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

        function validateForm1() {
            $("#message").css('background-color', '');
            var valid = true;
            var text = '';
            var message = $("#message").val();
            if (message.length < 3) {
                text += "*Message must be valid <br>";
                $("#message").css('background-color', '#e6cfcf');
                valid = false;
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
    </script>
    <script type="text/javascript">
        $(function() {
            var value = $("#previous_sts").val();
            if (value == '') {
                var start = moment('01/01/2010', 'MM-DD-YYYY');
                var end = moment();
            } else {
                var myarray = value.split('-');
                var from = myarray[0];
                var to = myarray[1];
                var date1 = new Date(from);
                var date2 = new Date(to);
                var Difference_In_Time = date2.getTime() - date1.getTime();
                var Difference_In_Days = Difference_In_Time / (1000 * 3600 * 24);
                var start = moment().subtract(Difference_In_Days, 'days');
                var end = moment();
            }

            function cb(start, end) {
                $('#reportrange span').html(start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'));
            }
            $('#reportrange').daterangepicker({
                startDate: start,
                endDate: end,
                "linkedCalendars": false,
                "closeText": false,
                ranges: {
                    'Today': [moment(), moment()],
                    'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
                    'Last 7 Days': [moment().subtract(6, 'days'), moment()],
                    'Last 15 Days': [moment().subtract(14, 'days'), moment()],
                    'Last 30 Days': [moment().subtract(29, 'days'), moment()],
                    'Last 60 Days': [moment().subtract(59, 'days'), moment()],
                    'This Month': [moment().startOf('month'), moment().endOf('month')],
                    'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1,
                        'month').endOf('month')]
                }
            }, cb);
            cb(start, end);
        });
        (function blink() {
            $('.blink_me').fadeOut(500).fadeIn(500, blink);
        })();
    </script>
    <script>
        document.onkeydown = function(evt) {
            var keyCode = evt ? (evt.which ? evt.which : evt.keyCode) : event.keyCode;
            if (keyCode == 13) {
                $("#search_form").submit();
            }
        }
    </script>
    <script>
        function Price_save() {
            var id = $("#contact_id").val();
            if (validateForm()) {
                $('#btnSave').css('display', 'none');
                $('#loader').css('display', 'block');
                url = "{{ route('lead_price') }}";
                method = 'POST';
                header = '';
                let formData = new FormData($('#contactFormPrice')[0]);
                // console.log(formData);
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
                            $("#contactFormPrice").trigger('reset');
                            // $('#exampleModal-comment-'+id).modal('hide');
                            $('#exampleModal-price').modal('hide');
                            swal(
                                'Thank you!',
                                'Price  Has Been Saved.',
                                'success'
                            );
                            location.reload();
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
            $("#price").css('background-color', '');
            var valid = true;
            var text = '';
            var price = $("#price").val();
            if (price.length < 1) {
                text += "*Price must be valid <br>";
                $("#price").css('background-color', '#e6cfcf');
                valid = false;
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
    </script>
    <script>
        function comment_model(id) {
            $("#request_comment").val(id);
            $("#exampleModal-comment").modal('show');
        }

        function price_model(id, price) {
            $("#contact_ids").val(id);
            $("#price_value").text('$' + price);
            $("#exampleModal-price").modal('show');
        }

        function update_package(cid, sts) {
            $.ajax({
                type: "GET",
                url: "{{ route('package-change-contact-lead') }}",
                data: {
                    '_token': $('meta[name="csrf-token"]').attr('content'),
                    'id': cid,
                    'package_id': sts
                },
                success: function(data) {
                    alertme('<i class="fas fa-check" aria-hidden="true"></i> Package  Updated Successfully',
                        'success', true,
                        1500);
                },
            });
        }

        function send_assessment_email(id, sts) {
            $.ajax({
                type: "GET",
                url: "{{ route('send_assesment_email') }}",
                data: {
                    '_token': $('meta[name="csrf-token"]').attr('content'),
                    'id': id,
                    'status': sts
                },
                success: function(data) {
                    alertme('<i class="fas fa-check" aria-hidden="true"></i> Questionnaire Email Has Been Sent Successfully',
                        'success', true,
                        1500);
                    location.reload();
                },
            });
        }

        $('#contact_request_check_all').on('change', function() {
            if ($('#contact_request_check_all').is(':checked')) {
                $('.contact_request_check').prop('checked', true);
            } else {
                $('.contact_request_check').prop('checked', false);
            }
            checkUncheckDelCheckBoxes();
        })

        $('.contact_request_check').on('change', function() {
            checkUncheckDelCheckBoxes();
        })

        function checkUncheckDelCheckBoxes() {
            if ($('.contact_request_check:checked').length == $('.contact_request_check').length) {
                $('#contact_request_check_all').prop('checked', true);
            } else {
                $('#contact_request_check_all').prop('checked', false);
            }

            if ($('.contact_request_check:checked').length > 0) {
                $('.bulk_actions').show();
            } else {
                $('.bulk_actions').hide();
                $('#contact_request_check_all').prop('checked', false);
            }
        }

        function setBulkAction(action = 'delete') {
            $('#bulk_action').val(action);
        }

        function filterReadStatus(status) {
            $('#read_lead').val(status);
            $('#search_form').submit();
        }
    </script>
@endsection
