@extends('back.layouts.app', ['title' => $title])
@section('content')
<div class="content-wrapper pl-3 pr-2">
        <section class="content-header">
            <h1>Send Invoice</h1>
            <ol class="breadcrumb">
                <li>
                    <a href="{{ admin_url() }}">
                        <i class="fas fa-gauge"></i> Home
                    </a>
                </li>
                <li class="active"><a href="{{ admin_url() }}invoice">Invoices</a></li>
                <li class="active">Send Invoice</li>
            </ol>
        </section>
        <section class="content">

            <div class="row">
                <div class="col-xs-12 col-md-12">
                    <div class="box">
                        <div class="box-header">
                            <h3 class="box-title">Send Invoice</h3>

                        </div>
                        <!-- /.box-header -->
                        <div class="box-body table-responsive">
                            <div class="text-end" style="padding-bottom:2px;">
                            </div>
                            <div class="menu-menagement">

                                <form action="{{ base_url() }}adminmedia/post_send_invoice" accept-charset="utf-8"
                                    name="send_invoice_frm" id="send_invoice_frm" method="POST">
                                    @csrf
                                    <input type="hidden" name="view_state_controller" value="Invoice">
                                    <input type="hidden" name="action" value="sendInvoice">
                                    <div class="row" style="width: 100%">
                                        <div class="col-lg-12">
                                            <label class="form-label">Invoice ID:</label>
                                            <input type="text" name="invoice_id" value="Invoice-{{ $maxID }}"
                                                id="invoice_id" class="form-control" placeholder="Invoice ID">
                                            <span class="error"></span>
                                        </div>
                                    </div>
                                    <div class="row" style="width: 100%">
                                        <div class="col-lg-6">
                                            <label class="form-label">Client Name:</label>
                                            <input type="text" name="client_name" value="" id="client_name"
                                                class="form-control" placeholder="Client Name"> <span class="error"></span>
                                        </div>

                                        <div class="col-lg-6">
                                            <label class="form-label">Case reference:</label>
                                            <input type="text" name="case_reference" value="" id="case_reference"
                                                class="form-control" placeholder="Case reference"> <span
                                                class="error"></span>
                                        </div>

                                        <div class="col-lg-6">
                                            <label class="form-label">Client Email:</label>
                                            <input type="text" name="client_email" value="" id="client_email"
                                                class="form-control" placeholder="Client Email"> <span
                                                class="error"></span>
                                        </div>

                                        <div class="col-lg-6">
                                            <label class="form-label">Amount:</label>
                                            <div class="mb-2 mb-3">
                                                <div class="mb-2-prepend">
                                                    <span class="mb-2-text">$</span>
                                                </div>
                                                <input type="number" name="amount" value="" id="amount"
                                                    class="form-control" placeholder="Amount">
                                            </div>
                                        </div>

                                        <div class="col-lg-12">
                                            <label class="form-label">Comments:</label>
                                            <textarea name="comments" cols="40" rows="10" id="comments" class="form-control" placeholder="Comments"></textarea> <span class="error"></span>
                                        </div>

                                        <div class="col-lg-4">
                                            <label class="form-label"><strong>Payment options:</strong></label>
                                            <br />

                                            @foreach ($paymentOption as $kk => $val)
                                                <label class="cbcontainer"> {{ $val->title }}
                                                    <input type="checkbox" name="payment_options[]"
                                                        value="{{ $val->id }}" id="bank_info">
                                                    <span class="checkmark"></span>
                                                </label>
                                            @endforeach
                                            <span class="error"></span>
                                        </div>
                                        <div class="col-lg-8">
                                            <div class="text-center">
                                                <h4>Email Copy (<em>cc</em> / <em>bcc</em>)</h4>
                                            </div>
                                            <br />
                                            <?php $heading = 'BCC';
                                            $name = 'bcc'; ?>
                                            <div id="more_textbox">
                                                <?php 
      $ArrBCC=(array)json_decode(get_meta_val('invoice_bcc'));
      $ArrCC=json_decode(get_meta_val('invoice_cc'));
      $cnt=0;
      foreach($ArrBCC as $key=>$val){?>
                                                <div class="row" id="p<?php echo $cnt; ?>" style="margin-bottom:10px;">
                                                    <div class="col-sm-4 text-end"><?php echo $heading; ?>:</div>
                                                    <div class="col-sm-6"><input class="form-control" type="text"
                                                            name="<?php echo $name; ?>[]" value="<?php echo $val; ?>">
                                                    </div>
                                                    <div class="col-sm-2 text-start"><a href="javascript:;"
                                                            class="btn btn-sm btn-danger"
                                                            onClick="remove_textbox_element('<?php echo $cnt; ?>');">-</a>
                                                    </div>
                                                </div>
                                                <?php $cnt++;}?>
                                                <?php 
$heading='CC';$name='cc';
      foreach($ArrBCC as $key=>$val){?>
                                                <div class="row" id="p<?php echo $cnt; ?>"
                                                    style="margin-bottom:10px;">
                                                    <div class="col-sm-4 text-end"><?php echo $heading; ?>:</div>
                                                    <div class="col-sm-6"><input class="form-control" type="text"
                                                            name="<?php echo $name; ?>[]" value="<?php echo $val; ?>">
                                                    </div>
                                                    <div class="col-sm-2 text-start"><a href="javascript:;"
                                                            class="btn btn-sm btn-danger"
                                                            onClick="remove_textbox_element('<?php echo $cnt; ?>');">-</a>
                                                    </div>
                                                </div>
                                                <?php $cnt++;}?>

                                            </div>
                                            <div class="row" style="margin-bottom:20px;">
                                                <div class="col-sm-4"></div>
                                                <div class="col-sm-2"><a href="javascript:;" class="btn btn-sm btn-info"
                                                        onClick="add_textbox('CC','cc');">+ CC</a></div>
                                                <div class="col-sm-2"></div>
                                                <div class="col-sm-2 text-start"><a href="javascript:;"
                                                        class="btn btn-sm btn-info" onClick="add_textbox('BCC','bcc');">+
                                                        BCC</a></div>
                                            </div>
                                        </div>

                                        <div class="col-lg-12" style="margin-top: 20px;">
                                            <button type="button" class="btn btn-success btn-lg subm"
                                                onclick="submitMyForm();">Send</button>
                                        </div>

                                    </div>
                                    <div class="clear"></div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection
@section('beforeBodyClose')
<script type="text/javascript" src="{{ asset_storage('') }}back/mod/mod_js.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@9"></script>
    <script>
        function submitMyForm() {
            var pageName = "{{ base_url() }}adminmedia/invoice/post_send_invoice";

            $(".subm").attr('disabled', true);
            var btnText = $(".subm").html();
            $(".subm").html('<i class="fas fa-sync fa-spin" aria-hidden="true"></i> Processing');
            $.ajax({
                type: "POST",
                timeout: 200000,
                url: pageName,
                //data: parameters,
                data: new FormData($("#send_invoice_frm")[0]),
                contentType: false,
                cache: false, // To unable request pages to be cached
                processData: false,
                beforeSend: function() {},
                success: function(msg) {
                    $(".subm").attr('disabled', false);
                    $(".subm").html(btnText);
                    if (isJson_page(msg) == false) {
                        alert('ERROR::' + msg);
                        $("#loader_div").hide();
                        return false;
                    }
                    obj = JSON.parse(msg);
                    if (obj.success == 'done') {
                        $("#send_invoice_frm")[0].reset();
                        Swal.fire({
                            position: 'top-end',
                            icon: 'success',
                            title: 'Invoice Sent Successfully',
                            showConfirmButton: false,
                            timer: 2000
                        });
                    } else {
                        $(".subm").attr('disabled', false);
                        Swal.fire({
                            icon: 'error',
                            title: 'Oops...',
                            html: obj.errormsg
                        });

                    }
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    $(".subm").html(btnText);
                    $("#loader_div").hide();
                    $(".subm").attr('disabled', false);
                    if (textStatus === "timeout") {
                        alert("ERROR: Connection problem"); //Handle the timeout
                    } else {
                        alert("ERROR: There is something wrong.");
                    }
                }
            });

        }
        function add_textbox(heading, name) {
            var size = $("#more_textbox div.row").length;

            $("#more_textbox").append('<div id="p' + size +
                '" class="row" style="margin-bottom:10px;"><div class="col-sm-4 text-end">' + heading +
                ':</div><div class="col-sm-6"><input class="form-control" type="text" name="' + name +
                '[]" value=""></div><div class="col-sm-2 text-start"><a href="javascript:;" class="btn btn-sm btn-danger" onClick="remove_textbox_element(\'' +
                size + '\');">-</a></div></div>');
        }

        function remove_textbox() {
            var size = $("#more_textbox div.row").length;
            if (size > 1) {
                $("#more_textbox div.row").last().remove();
            }
        }

        function remove_textbox_element(pos) {

            $("#p" + pos).remove();

        }
    </script>
@endsection
