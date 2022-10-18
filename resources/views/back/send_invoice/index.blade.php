@extends('back.layouts.app', ['title' => $title])
@section('content')
    <aside class="right-side">
        <section class="content-header">
            <h1>Send Invoice</h1>
            <ol class="breadcrumb">
                <li>
                    <a href="{{ admin_url() }}">
                        <i class="fa-solid fa-gauge"></i> Home
                    </a>
                </li>
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
                                            <input type="number" name="amount" value="" id="amount"
                                                class="form-control" placeholder="Amount"> <span class="error"></span>
                                        </div>

                                        <div class="col-lg-12">
                                            <label class="form-label">Comments:</label>
                                            <textarea name="comments" cols="40" rows="10" id="comments" class="form-control" placeholder="Comments"></textarea> <span class="error"></span>
                                        </div>

                                        <div class="col-lg-12">
                                            <label class="form-label"><strong>Payment options:</strong></label>
                                            <br />
                                            <input type="checkbox" name="payment_options[]" value="bank_info"
                                                id="bank_info"> Bank Info &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input
                                                type="checkbox" name="payment_options[]" value="check_mail" id="check_mail">
                                            Check mailing address &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="checkbox"
                                                name="payment_options[]" value="pay_pal_info" id="pay_pal_info"> Paypal,
                                            Credit Card &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <span class="error"></span>
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
    </aside>
@endsection
@section('beforeBodyClose')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@9"></script>
    <script>
        function submitMyForm() {
            var pageName = "{{ base_url() }}adminmedia/post_send_invoice";

            $(".subm").attr('disabled', true);
            var btnText = $(".subm").html();
            $(".subm").html('<i class="fa-solid fa-refresh fa-spin" aria-hidden="true"></i> Processing');
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

        function isJson_page(str) {
            try {
                JSON.parse(str);
            } catch (e) {
                return false;
            }
            return true;
        }
    </script>
@endsection
