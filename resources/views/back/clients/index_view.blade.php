@extends('back.layouts.app', ['title' => $title])
@section('content')
    <aside class="right-side {{ session('leftSideBar') == 1 ? 'strech' : '' }}">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="row">
                <div class="col-md-8 col-sm-6">
                    <ol class="breadcrumb">
                        <li><a href="{{ admin_url() }}"> <i class="fa-solid fa-dashboard"></i> Home </a></li>
                        <li class="active">Manage Clients</li>
                    </ol>
                </div>
                <div class="col-md-4 col-sm-6"> @include('back.common_views.quicklinks') </div>
            </div>
        </section>
        <!-- Main content -->
        <section class="content">
            <div class="row">
                <div class="col-xs-12 col-md-12">
                    <div class="box">
                        <div class="box-body">
                            @if (session('success'))
                                <div style="padding-top:5px;" class="alert alert-success">{{ session('success') }}
                                </div>
                            @endif
                            @if (session('error'))
                                <div style="padding-top:5px;" class="alert alert-danger">{{ session('error') }}
                                </div>
                            @endif
                            @if (Session::has('msg'))
                                <p class="alert alert-success">{{ Session::get('msg') }}</p>
                            @endif
                            <div class="text-end">
                                <a href="{{ admin_url() }}manage_clients/create" class="btn btn-info">
                                    <i class="fa-solid fa-plus-circle" aria-hidden="true"></i> Add New
                                    Client</a>
                                <a href="{{ route('email_templates.index') }}" class="btn btn-info">
                                    <i class="fa-solid fa-envelope-square" aria-hidden="true"></i>&nbsp;Email Template
                                    Management</a>
                                <a href="{{ route('message.index') }}" class="btn btn-info">
                                    <i class="fa-solid awesome_style fa-share" aria-hidden="true"></i>&nbsp;Message Template
                                    Management</a>
                                <a href="javascript:;" onclick="send_template_email('','client','combine')"
                                    class="btn btn-info">
                                    <i class="fa-solid fa-envelope-square" aria-hidden="true"></i>&nbsp;Send Email
                                </a>
                                <a href="javascript:;" onclick="send_template_sms('','client','combine')"
                                    class="btn btn-info">
                                    <i class="fa-solid awesome_style fa-share" aria-hidden="true"></i>&nbsp;Send SMS
                                </a>
                            </div>
                            <br>
                            <form method="get" action="{{ route('manage_clients.index') }}" id="search_form">
                                <div class="row">
                                </div>
                                <div class="row">
                                    <div class="col-md-3 form-group">
                                        <input type="text" name="name" class="form-control"
                                            placeholder="Search By Name,Email" value='<?php if (isset($_GET['name'])) {
                                                echo $_GET['name'];
                                            } ?>'>
                                    </div>
                                    <input type="hidden" name="previous_sts" id="previous_sts" value="<?php if (isset($_GET['dates'])) {
                                        echo $_GET['dates'];
                                    } ?>">
                                    <div class="col-md-3 form-group">
                                        <input type="text" name="dates" id="reportrange" placeholder="All"
                                            class="form-control">
                                    </div>
                                    <div class="col-md-3 form-group ">
                                        <select class="btn btn-info form-group" name="package" aria-hidden="true"
                                            id="package"
                                            style="width:100%;background-color:white;color: gray;border-color: #edcbcb;">
                                            <option class="form-control" value="">Search By Package</option>
                                            @foreach ($get_all_packages as $package)
                                                <option class="form-control" value="{{ $package->id }}"
                                                    @if (isset($_GET['package']) && $_GET['package'] == $package->id)  @endif>{{ $package->heading }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-md-1 text-start">
                                        <button type="submit" class="btn btn-info"><i class="fa-solid fa-search"
                                                aria-hidden="true"></i> Search</button>
                                    </div>
                                    <div class="col-md-1" style="margin-left: 20px;">
                                        <a class="btn btn-warning" href="{{ route('manage_clients.index') }}"><i
                                                class="fa-solid fa-refresh" aria-hidden="true"></i>Reset</a>
                                    </div>
                                </div>
                            </form>
                            <form method="post" onSubmit="return confirm('Are you sure?');"
                                action="{{ route('client.delete') }}" id="delete_client_form">
                                @csrf

                                <table class="table table-bordered table-inverse table-hover">
                                    <thead>
                                        <tr>
                                            <th>
                                                <input type="checkbox" id="client_check_all" />
                                                <button type="submit" class="btn btn-small btn-danger"
                                                    id="client_delete_all" style="display:none;">Delete</button>
                                            </th>
                                            <th>
                                            </th>
                                            <th>ID</th>
                                            <th>First Name</th>
                                            <th>First Name</th>
                                            <th>Email</th>
                                            <th>Phone</th>
                                            <th>Package</th>
                                            <th>Status</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @php
                                            $Bstatus = '';
                                            $BGcolor = '';
                                            
                                            $statusArr = ['active', 'Blocked'];
                                            
                                            $client_check_array = [];
                                        @endphp
                                        @if (count($result) > 0)
                                            @foreach ($result as $row)
                                                @php
                                                    $bgColor = isset($bgColor) && $bgColor == '#f9f9f9' ? '#FFFFFF' : '#f9f9f9';
                                                    
                                                    if (isset($_GET['package']) && !empty($_GET['package'])) {
                                                        $response = $_GET['package'];
                                                    } else {
                                                        $response = 'all';
                                                    }
                                                    
                                                @endphp
                                                @if (!in_array($row->id, $client_check_array))
                                                    <tr id="trr{{ $row->id }}">
                                                        <td><input type="checkbox" class="client_check"
                                                                name="client_check[]"
                                                                value="<?php echo $row->id; ?>" /></td>
                                                        <td><a style="font-size: 24px;" data-toggle="tooltip"
                                                                title="" href="javascript:;"
                                                                onclick="showme_page('#subtrr{{ $row->id }}',this)"
                                                                data-original-title="Show more"><i
                                                                    class="fa-solid fa-angle-double-down"
                                                                    aria-hidden="true"></i></a>
                                                        </td>
                                                        <td>{{ $row->id }}</td>
                                                        <td>{{ $row->name }}</td>
                                                        <td>{{ $row->last_name }}</td>
                                                        <td><a href="mailto:{{ $row->email }}">{{ $row->email }}</a>
                                                        </td>
                                                        <td><a href="tel:{{ $row->phone }}">{{ $row->phone }}</a>
                                                        </td>
                                                        <td><?php echo client_package($row->id, $response); ?> </td>
                                                        <td>
                                                            <select class="form-control"
                                                                onchange="update_status('{{ $row->id }}',this.value)">
                                                                <option value="">-Select-</option>
                                                                @foreach ($statusArr as $kk => $val)
                                                                    <option value="{{ $val }}"
                                                                        @if ($row->status == $val) selected="" @endif>
                                                                        {{ $val }}</option>
                                                                @endforeach
                                                            </select>
                                                        </td>
                                                    </tr>
                                                    <tr style="display: none;" id="subtrr{{ $row->id }}">
                                                        <td colspan="2">
                                                            <strong>IP: </strong><code>{{ $row->ip }}</code> <br>
                                                            <strong>Date:
                                                            </strong><code>{{ format_date($row->dated, 'date_time') }}</code>
                                                            <br>
                                                            <strong>Added By:
                                                            </strong><code>{{ $row->user->name ?? '-' }}</code>
                                                            <br>
                                                        </td>
                                                        <td colspan="5">
                                                            <div class="row">
                                                                <div class="col-lg-3">
                                                                    <a class="btn btn-info"
                                                                        href="mailto:{{ $row->email }}"
                                                                        title="Reply via Email">
                                                                        <i class="fa-solid fa-reply" aria-hidden="true"></i>
                                                                        Reply</a>
                                                                    <a class="btn btn-sm btn-danger" href="javascript:"
                                                                        onclick="del_recrod('{{ $row->id }}');"
                                                                        title="Delete"><i
                                                                            class="glyphicon glyphicon-trash"></i>
                                                                        Delete</a>
                                                                </div>
                                                                <div class="col-lg-2">
                                                                    <a href="{{ admin_url() }}manage_clients/{{ $row->id }}"
                                                                        class="btn btn-success  btn-sm"><i
                                                                            class="fa-solid fa-history" aria-hidden="true"></i>
                                                                        History</a>
                                                                </div>
                                                                <div class="col-lg-3">
                                                                    <a href="javascript:;" class="btn btn-success  btn-sm"
                                                                        style="color:white;"
                                                                        onclick="comment_model({{ $row->id }})"><i
                                                                            class="fa-solid fa-pencil"
                                                                            aria-hidden="true"></i> Add
                                                                        Comment</a>
                                                                </div>
                                                                <div class="col-lg-3">
                                                                    <a href="{{ admin_url() }}manage_clients/{{ $row->id }}/edit"
                                                                        class="btn btn-info  btn-sm"><i
                                                                            class="fa-solid fa-pencil-square-o"
                                                                            aria-hidden="true"></i>
                                                                        Edit</a>
                                                                </div>
                                                            </div>
                                                            <div class="row" style="margin-top: 10px;">
                                                                <div class="col-lg-3">
                                                                    <a class="btn btn-sm btn-info"
                                                                        onclick="send_template_email('{{ $row->id }}','client','single')"
                                                                        href="javascript:"><i
                                                                            class="fa-solid fa-envelope-square"></i>Send
                                                                        Email</a>
                                                                </div>
                                                                <div class="col-lg-3">
                                                                    <a href="javascript:;"
                                                                        onclick="send_template_sms('{{ $row->id }}','client','single')"
                                                                        class="btn btn-sm btn-info" href="javascript:"><i
                                                                            class="fa-solid awesome_style fa-share"></i>Send
                                                                        Message</a>
                                                                </div>
                                                                @if ($row->assesment_status == 'sent')
                                                                    <div class="col-lg-3">
                                                                        <a onclick="send_assessment_email('{{ $row->id }}','client')"
                                                                            class="btn btn-sm btn-primary"
                                                                            href="javascript:"><i
                                                                                class="fa-solid fa-envelope-square"></i> ReSend
                                                                            Questionnaire</a>
                                                                    </div>
                                                                @elseif($row->assesment_status == 'receive')
                                                                    <div class="col-lg-3">
                                                                        <a class="btn btn-sm btn-info" href="javascript:"
                                                                            data-toggle="modal"
                                                                            data-target="#largeShoes-<?php echo $row->id; ?>"><i
                                                                                class="fa-solid fa-envelope-square"></i>View
                                                                            Answered
                                                                            Questions</a>
                                                                    </div>
                                                                @else
                                                                    <div class="col-lg-3">
                                                                        <a href="javascript:;"
                                                                            onclick="send_assessment_email('{{ $row->id }}','client')"
                                                                            class="btn btn-sm btn-primary"
                                                                            href="javascript:"><i
                                                                                class="fa-solid fa-envelope-square"></i> Send
                                                                            Questionnaire</a>
                                                                    </div>
                                                                @endif
                                                            </div>
                                                            <div class="modal" id="largeShoes-<?php echo $row->id; ?>"
                                                                tabindex="-1" role="dialog"
                                                                aria-labelledby="modalLabelLarge" aria-hidden="true">
                                                                <div class="modal-dialog modal-lg">
                                                                    <div class="modal-content">
                                                                        <div class="modal-header">
                                                                            <h4 class="modal-title" id="modalLabelLarge">
                                                                                Answered
                                                                                Questions</h4>
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
                                                                                        @if (!$row->client_assessment == null)
                                                                                            <?php $q = 0; ?>
                                                                                            @foreach ($row->client_assessment as $p_question)
                                                                                                <tr>
                                                                                                    <td>{{ $p_question->assessment_question->question }}
                                                                                                    </td>
                                                                                                    <td class="down_answer_que{{ $q }}"
                                                                                                        style="text-align: center;">
                                                                                                        <a style="font-size: 24px;"
                                                                                                            onclick="show_hides('answer_que{{ $q }}')"><i
                                                                                                                class="fa-solid fa-angle-double-down"
                                                                                                                aria-hidden="true"></i></a>
                                                                                                    </td>
                                                                                                    <td class="up_answer_que{{ $q }}"
                                                                                                        style="display:none;text-align: center;">
                                                                                                        <a style="font-size: 24px;"
                                                                                                            onclick="hide_show('answer_que{{ $q }}')"><i
                                                                                                                class="fa-solid fa-angle-double-up"
                                                                                                                aria-hidden="true"></i></a>
                                                                                                    </td>
                                                                                                </tr>
                                                                                                <tr style="display:none;"
                                                                                                    class="answer_que{{ $q }}">
                                                                                                    <td colspan="2"
                                                                                                        style="width:100%;border:none;">
                                                                                                        @if (is_array(json_decode($p_question->answer)) || is_object(json_decode($p_question->answer)))
                                                                                                            @foreach (json_decode($p_question->answer) as $key => $ans)
                                                                                                                {{ $key }}<br>
                                                                                                            @endforeach
                                                                                                        @else
                                                                                                            {{ $p_question->answer }}
                                                                                                        @endif
                                                                                                    </td>
                                                                                                </tr>
                                                                                                <?php $q++; ?>
                                                                                            @endforeach
                                                                                        @endif
                                                                                    </tbody>
                                                                                </table>
                                                                            </div>
                                                                            <label>Conditions </label>
                                                                            <div class="row">
                                                                                @foreach ($content_condition as $content)
                                                                                    <div class="col-md-2"
                                                                                        style="margin-left: 15px;">
                                                                                        <input type="checkbox"
                                                                                            class="form-check-input"
                                                                                            id="content{{ $content->id }}"
                                                                                            onchange="update_conditions('{{ $row->id }}','{{ $content->id }}')"
                                                                                            name="condition_content[]"
                                                                                            value="{{ $content->id }}"
                                                                                            <?php if($row->conditions != NULL){ 
             $decode=json_decode($row->conditions);
             if(is_array($decode)){
              foreach($decode as $dec){
                  if($dec==$content->id){ 
            ?> checked
                                                                                            <?php  }
             }
             } } ?>>
                                                                                        <label class="form-check-label"
                                                                                            for="{{ $content->title }}">{{ $content->title }}</label>
                                                                                    </div>
                                                                                @endforeach
                                                                            </div>
                                                                            @if (goals($row->id) != '')
                                                                                <label><b>Goals</b> </label>
                                                                                <div class="row">
                                                                                    <div class="col-md-12" style="">
                                                                                        <table style="display:block;">
                                                                                            <tbody style="display:block;">
                                                                                                <?php echo goals($row->id); ?>
                                                                                            </tbody>
                                                                                        </table>
                                                                                    </div>
                                                                                </div>
                                                                            @endif
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                @endif
                                                @php
                                                    
                                                    $client_check_array[] = $row->id;
                                                    
                                                @endphp
                                            @endforeach
                                        @else
                                            <tr>
                                                <td> No Record found!</td>
                                            </tr>
                                        @endif
                                    </tbody>
                                </table>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <div>
                @if (!isset($_GET['package']))
                    {{ $result->links() }}
                @endif
            </div>
        </section>
        <td>
            <div class="modal fade" id="exampleModal-comment" tabindex="-1" role="dialog"
                aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Add
                                Comment</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                            </button>
                        </div>
                        <form name="frm_process" id="contactFormComment" class="contact-form">
                            @csrf
                            <div class="modal-body">
                                <input type="hidden" name="contact_id" class="form-control" id="contact_id">
                                <div class="col-sm-12">
                                    <label>Enter Comment</label>
                                    <textarea class="form-control" name="message" id="comment"></textarea>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                {{-- <input type="submit" value="Send Request Review Email" class="btn btn-primary"> --}}
                                <button type="button" class="btn btn-primary" onclick="comment_save()">Save
                                    Comment</button>
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
                                        <input type="checkbox" name="sms_send_to_client" id="sms_send_to_client_id">
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
        </td>
    </aside>
    @include('back.clients.common.modal')
@endsection
@section('beforeBodyClose')
    <script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />
    <script src="{{ asset('lib/sweetalert/sweetalert2.js') }}"></script>
    <script type="text/javascript" src="{{ base_url() }}back/mod/mod_js.js"></script>
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
                    url: "{{ admin_url() }}manage_clients/" + id,
                    data: {
                        '_token': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function(data) {
                        if (JSON.parse(data).status) {
                            $("#trr" + id).fadeOut(1000);
                            $("#subtrr" + id).fadeOut(1000);
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

        function update_status(cid, sts) {
            console.log(sts);
            postMyForm(
                '{{ admin_url() }}' + "manage_clients/status", {
                    idds: cid,
                    sts: sts,
                    _token: $("meta[name=csrf-token]").attr("content")
                },
                function() {
                    alertme('<i class="fa-solid fa-check" aria-hidden="true"></i> Status Updated ', 'success', true, 1500);
                }
            );
        }

        function update_conditions(id, val) {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                url: "{{ env('APP_URL') . 'adminmedia/manage_clients/update_condition' }}",
                type: "POST",
                data: {
                    'id': id,
                    'val': val
                },
                success: function(data) {
                    swal(
                        'Success',
                        'Condition Update Successfully!',
                        'success'
                    );
                },
            });
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
                    'Last 30 Days': [moment().subtract(29, 'days'), moment()],
                    'Last 60 Days': [moment().subtract(59, 'days'), moment()],
                    'This Month': [moment().startOf('month'), moment().endOf('month')],
                    'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1,
                        'month').endOf('month')]
                }
            }, cb);
            cb(start, end);
        });
    </script>
    <script>
        function comment_model(id) {
            $("#contact_id").val(id);
            $("#exampleModal-comment").modal('show');
        }

        function comment_save() {
            var id = $('#contact_id').val();
            $('#btnSave').css('display', 'none');
            $('#loader').css('display', 'block');
            url = "{{ route('client_comments') }}";
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
                        $('#exampleModal-comment-' + id).modal('hide');
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

        function validateForm1() {
            $("#comment").css('background-color', '');
            var valid = true;
            var text = '';
            var comment = $("#comment").val();
            if (comment.length < 3) {
                text += "*Message must be valid <br>";
                $("#comment").css('background-color', '#e6cfcf');
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
        document.onkeydown = function(evt) {
            var keyCode = evt ? (evt.which ? evt.which : evt.keyCode) : event.keyCode;
            if (keyCode == 13) {
                $("#search_form").submit();
            }
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
                    alertme('<i class="fa-solid fa-check" aria-hidden="true"></i> Questionnaire Email Has Been Sent Successfully',
                        'success', true,
                        1500);
                    location.reload();
                },
            });
        }

        function show_hides(id) {
            $('.' + id).css("display", "table-row");
            $('.down_' + id).css("display", "none");
            $('.up_' + id).css("display", "block");
        }

        function hide_show(id) {
            $('.' + id).css("display", "none");
            $('.down_' + id).css("display", "block");
            $('.up_' + id).css("display", "none");
        }

        $('#client_check_all').on('change', function() {
            if ($('#client_check_all').is(':checked')) {
                $('.client_check').prop('checked', true);
            } else {
                $('.client_check').prop('checked', false);
            }
            checkUncheckDelCheckBoxes();
        })

        $('.client_check').on('change', function() {
            checkUncheckDelCheckBoxes();
        })

        function checkUncheckDelCheckBoxes() {
            if ($('.client_check:checked').length == $('.client_check').length) {
                $('#client_check_all').prop('checked', true);
            } else {
                $('#client_check_all').prop('checked', false);
            }

            if ($('.client_check:checked').length > 0) {
                $('#client_delete_all').show();
            } else {
                $('#client_delete_all').hide();
                $('#client_check_all').prop('checked', false);
            }
        }
    </script>
@endsection
