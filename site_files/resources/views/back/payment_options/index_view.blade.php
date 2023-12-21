@extends('back.layouts.app', ['title' => $title])
@section('content')
    <div class="content-wrapper pl-3 pr-2">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="row">
                <div class="col-md-5 col-sm-12">
                    <ol class="breadcrumb">
                        <li><a href="{{ admin_url() }}"> <i class="fas fa-gauge"></i> Home </a></li>
                        <li class="active">Payment Options</li>
                    </ol>
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
                                <p class="alert alert-success">{!! Session::get('msg') !!}</p>
                            @endif
                            @if ($errors->any())
                                <div class="alert alert-danger">
                                    <ul>
                                        @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif
                            <div class="text-end"><a href="{{ admin_url() }}payment_options/create" class="btn btn-info">
                                    <i class="fas fa-plus-circle" aria-hidden="true"></i> Add New
                                    Payment Option</a></div>
                            <table class="table table-bordered table-inverse table-hover">
                                <thead>
                                    <tr>

                                        <th>ID</th>
                                        <th>Title</th>
                                        <th>Detais</th>
                                        <th>Status</th>
                                        <th>Action</th>

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
                                            <tr id="trr{{ $row->id }}">

                                                <td>{{ $row->id }}</td>
                                                <td>{{ $row->title }}
                                                    @if ($row->id == 5 && $row->sts == 'Yes')
                                                        <br />
                                                        @if (get_meta_val('authorize_test') == 'Yes')
                                                            (<span class="text-danger"><strong>Test Mode</strong></span>)
                                                        @else
                                                            (<span class="text-success"><strong>Live</strong></span>)
                                                        @endif
                                                    @endif
                                                </td>
                                                <td>
                                                    @php
                                                        $webKey = Str::random(10);
                                                        $authLink = base_url() . 'invoice/pay/' . $webKey;
                                                        $authLinkPaypal = base_url() . 'invoice/' . $webKey;
                                                        $paymentDetails = str_replace('{AUTHORIZE_PAYNOW_BUTTON}', $authLink, $row->details);
                                                        $paymentDetails = str_replace('{PAYPAL_PAYNOW_BUTTON}', $authLinkPaypal, $paymentDetails);
                                                        
                                                    @endphp
                                                    {!! $paymentDetails !!}</td>
                                                <td>
                                                    @if ($row->sts == 'Yes')
                                                        <a href="javascript:;" id="sts_{{ $row->id }}"
                                                            onClick="update_status('{{ $row->id }}','No');"
                                                            class="btn btn-success btn-sm">Active</a>
                                                    @else
                                                        <a href="javascript:;" id="sts_{{ $row->id }}"
                                                            onClick="update_status('{{ $row->id }}','Yes');"
                                                            class="btn btn-danger btn-sm">Blocked</a>
                                                    @endif
                                                </td>
                                                <td>
                                                    <div class="row">

                                                        <div class="col-lg-5">
                                                            @if ($row->id == 2)
                                                                <a href="javascript:;" data-bs-toggle="modal"
                                                                    data-bs-target="#modal_1" class="btn btn-info btn-sm"><i
                                                                        class="fas fa-paypal" aria-hidden="true"></i> Paypal
                                                                    Email</a>
                                                            @endif
                                                            @if ($row->id == 5)
                                                                <a href="javascript:;" data-bs-toggle="modal"
                                                                    data-bs-target="#modal_2"
                                                                    class="btn btn-info btn-sm">Account Credentials</a>
                                                            @endif
                                                            @if ($row->id > 5)
                                                                <a class="btn btn-sm btn-danger" href="javascript:"
                                                                    onclick="del_recrod('{{ $row->id }}');"
                                                                    title="Delete"><i class="fas fa-minus-circle"
                                                                        aria-hidden="true"></i> Delete</a>
                                                            @endif
                                                        </div>
                                                        <div class="col-lg-4">
                                                            <a href="{{ admin_url() }}payment_options/{{ $row->id }}"
                                                                class="btn btn-info  btn-sm"><i class="fas fa-info-circle"
                                                                    aria-hidden="true"></i> Details</a>
                                                        </div>
                                                        <div class="col-lg-3">
                                                            <a href="{{ admin_url() }}payment_options/{{ $row->id }}/edit"
                                                                class="btn btn-info  btn-sm"><i
                                                                    class="fas fa-pen-to-square"
                                                                    aria-hidden="true"></i>
                                                                Edit</a>
                                                        </div>
                                                    </div>
                                                </td>



                                            </tr>
                                        @endforeach
                                    @else
                                        <tr id="trr{{ $row->id }}">
                                            <td> No Record found!</td>
                                        </tr>
                                    @endif
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <div> {{ $result->links() }} </div>
        </section>
    </div>
    <div class="modal fade" id="modal_1">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    
                    <h4 class="modal-title">Paypal Email</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">

                        <span class="sr-only">Close</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form method="post" name="frm" id="frm"
                        action="{{ admin_url() }}payment_options/paypal_email" enctype="multipart/form-data">
                        @csrf
                        <input type="email" name="email" id="email" class="form-control"
                            value="{{ get_meta_val('paypal_email') }}" placeholder="Enter Paypal account email address"
                            required="">
                        <input type="checkbox" name="sts" id="sts" value="Yes" checked=""> Active Payment
                        Option
                        <div class="row">
                            <div class="col-lg-6"></div>
                            <div class="col-lg-6 text-end"><button type="submit" class="btn btn-info">Submit</button>
                            </div>
                        </div>
                    </form>
                </div>

            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div>
    <div class="modal fade" id="modal_2">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    
                    <h4 class="modal-title">Authorize.Net</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">

                        <span class="sr-only">Close</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form method="post" name="frm" id="frm"
                        action="{{ admin_url() }}payment_options/authorize_net" enctype="multipart/form-data">
                        @csrf

                        <div class="row" style="margin-bottom: 15px;">
                            <div class="col-lg-4">Login ID:</div>
                            <div class="col-lg-8"><input type="text" name="authorize_net_login_id"
                                    id="authorize_net_login_id" class="form-control"
                                    value="{{ get_meta_val('authorize_net_login_id') }}" placeholder="Login ID"
                                    required=""></div>
                        </div>
                        <div class="row" style="margin-bottom: 15px;">
                            <div class="col-lg-4">Transaction Key:</div>
                            <div class="col-lg-8"><input type="text" name="authorize_net_trans_id"
                                    id="authorize_net_trans_id" class="form-control"
                                    value="{{ get_meta_val('authorize_net_trans_id') }}" placeholder="Transaction Key"
                                    required=""></div>
                        </div>
                        <div class="row" style="margin-bottom: 15px;">
                            <div class="col-lg-4">Payment Mode:</div>
                            <div class="col-lg-8">
                                <input type="radio" name="authorize_test" id="Yes" value="Yes"
                                    @if (get_meta_val('authorize_test') == 'Yes') checked="" @endif> Sandbox(<span
                                    class="text-danger">Test Mode</span>)
                                <br />
                                <input type="radio" name="authorize_test" id="No" value="No"
                                    @if (get_meta_val('authorize_test') == 'No') checked="" @endif> Live
                            </div>
                        </div>
                        <input type="checkbox" name="sts" id="sts" value="Yes" checked=""> Active
                        Payment Option
                        <div class="row">
                            <div class="col-lg-6"></div>
                            <div class="col-lg-6 text-end"><button type="submit" class="btn btn-info">Submit</button>
                            </div>
                        </div>
                    </form>
                </div>

            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div>
@endsection
@section('beforeBodyClose')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@9"></script>
    <script type="text/javascript" src="{{ asset_storage('') }}back/mod/mod_js.js"></script>
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
                    url: "{{ admin_url() }}payment_options/" + id,
                    data: {
                        '_token': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function(data) {
                        if (JSON.parse(data).status) {
                            $("#trr" + id).fadeOut(1000);
                            $("#subtrr" + id).fadeOut(1000);
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
            if (sts == 'No') {
                var js = "update_status('" + cid + "','Yes')";
                $("#sts_" + cid).attr('onclick', js);
                $("#sts_" + cid).removeClass('btn-success');
                $("#sts_" + cid).addClass('btn-danger');
                $("#sts_" + cid).html('Blocked');
            }
            if (sts == 'Yes') {
                var js = "update_status('" + cid + "','No')";
                $("#sts_" + cid).attr('onclick', js);
                $("#sts_" + cid).removeClass('btn-danger');
                $("#sts_" + cid).addClass('btn-success');
                $("#sts_" + cid).html('Active');
            }

            postMyForm_status(
                '{{ admin_url() }}' + "payment_options/status", {
                    idds: cid,
                    sts: sts,
                    _token: $("meta[name=csrf-token]").attr("content")
                },
                function() {
                    alertme('<i class="fas fa-check" aria-hidden="true"></i> Status Updated ', 'success', true, 1500);
                },
                function() {
                    if (sts == 'Yes') {
                        var js = "update_status('" + cid + "','Yes')";
                        $("#sts_" + cid).attr('onclick', js);
                        $("#sts_" + cid).removeClass('btn-success');
                        $("#sts_" + cid).addClass('btn-danger');
                        $("#sts_" + cid).html('Blocked');
                    }
                }
            );

        }

        function postMyForm_status(postURL, dataObj, cbfunc, errCbFunc) {
            var pageName = postURL;
            $.ajax({
                type: "POST",
                timeout: 200000,
                url: pageName,
                //data: parameters,
                data: dataObj,
                beforeSend: function() {},
                success: function(msg) {
                    if (isJson_page(msg) == false) {
                        alert('ERROR::' + msg);
                        $("#loader_div").hide();
                        return false;
                    }
                    obj = JSON.parse(msg);
                    if (obj.success == 'done') {
                        cbfunc();
                    } else {
                        if (obj.errormsg == 'paypal_email') {
                            $("#modal_1").modal('show');
                        } else if (obj.errormsg == 'authorize_net') {
                            $("#modal_2").modal('show');
                        } else {
                            Swal.fire({
                                icon: 'error',
                                title: 'Oops...',
                                html: obj.errormsg
                            });
                        }
                        errCbFunc();


                    }
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    if (errorThrown == 'Unauthorized') {
                        Swal.fire({
                            icon: 'error',
                            title: 'ERROR!',
                            text: 'You are not logged in!',
                            footer: '<a href="' + base_url + 'login">Click here</a> to login'
                        });
                        return false;
                    }
                    if (textStatus === "timeout") {
                        alert("ERROR: Connection problem"); //Handle the timeout
                    } else {
                        alert("ERROR: There is something wrong.");
                    }
                    //RR location.reload();
                }
            });

        }
    </script>
@endsection
