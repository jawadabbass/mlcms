@extends('back.layouts.app', ['title' => $title])
@section('content')
    <div class="content-wrapper pl-3 pr-2">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="row">
                <div class="col-md-5 col-sm-12 jawadcls">
                    <ol class="breadcrumb">
                        <li><a href="{{ admin_url() }}"> <i class="fas fa-gauge"></i> Home </a></li>
                        <li class="active">Invoices</li>
                    </ol>
                </div>
                <div class="col-md-7 col-sm-12 jawadcls"> @include('back.common_views.quicklinks') </div>
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
                            <div class="text-end"><a href="{{ admin_url() }}invoice/send_invoice" class="btn btn-info">
                                    <i class="fas fa-plus-circle" aria-hidden="true"></i> Create Invoice</a></div>
                            <table class="table table-bordered table-inverse table-hover">
                                <thead>
                                    <tr>
                                        <th>Invoice ID</th>
                                        <th>Date Sent</th>
                                        <th>Amount</th>
                                        <th>Status</th>
                                        <th># Sent</th>
                                        <th>Payments</th>
                                        <th>Weblink</th>
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
                                            <tr id="row_<?php echo $row->id; ?>" class="gradeA">
                                                <td><?php echo $row->invoice_id; ?></td>
                                                <td><?php echo date_formats($row->sent_date, 'j M, Y h:i A'); ?></td>
                                                <td><i style="font-size:13px" class="fa">&#xf155;</i><?php echo $row->amount; ?>
                                                </td>
                                                <td>
                                                    <form style="text-align: center;">
                                                        <select class="form-control" id="invoice_status_<?php echo $row->id; ?>"
                                                            style="width:100px !important">
                                                            <option value="Sent" <?php echo $row->status == 'Sent' ? 'selected' : ''; ?>>Sent</option>
                                                            <option value="Paid" <?php echo $row->status == 'Paid' ? 'selected' : ''; ?>>Paid</option>
                                                            <option value="Deferred" <?php echo $row->status == 'Deferred' ? 'selected' : ''; ?>>Deferred</option>
                                                            <option value="Written Off" <?php echo $row->status == 'Written Off' ? 'selected' : ''; ?>>Written Off
                                                            </option>
                                                            <option value="Canceled" <?php echo $row->status == 'Canceled' ? 'selected' : ''; ?>>Canceled</option>
                                                        </select>
                                                        <a id="change_status_link" rel="nofollow" href="javascript:void(0)"
                                                            class=""
                                                            onClick="change_status('<?php echo $row->id; ?>');">change</a>
                                                    </form>
                                                    <?php echo $row->status == 'Future' ? '<br /><span class="inovice-type color-class">(' . date('j M, Y', strtotime($row->future_specific_date)) . ')</span>' : ''; ?>
                                                </td>
                                                <td class="center"><span
                                                        id="timesent_{{ $row->id }}"><?php echo $row->time_sent; ?></span></td>
                                                <td class="center">
                                                    <?php if ($row->status != 'Future') { ?>
                                                    <a href="{{ admin_url() }}invoice/{{ $row->id }}" class="btn btn-teal btn-small">Payments</a>
                                                    <?php } ?>
                                                </td>
                                                <td class="center">
                                                    @if (isset($PaymentArr[$row->id . '_2']))
                                                        <a rel="nofollow" data-bs-toggle="tooltip"
                                                            title="Web link using Paypal" target="_blank"
                                                            href="{{ base_url() }}invoice/<?php echo $row->invoice_webkey; ?>"
                                                            class="get-weblink"><i class="fas fa-external-link"
                                                                aria-hidden="true"></i> PayPal</a>
                                                    @endif
                                                    @if (isset($PaymentArr[$row->id . '_5']))
                                                        <br>
                                                        <a rel="nofollow" data-bs-toggle="tooltip"
                                                            title="Web link using Authoze.NET" target="_blank"
                                                            href="{{ base_url() }}invoice/pay/<?php echo $row->invoice_webkey; ?>"
                                                            class="get-weblink"><i class="fas fa-external-link"
                                                                aria-hidden="true"></i> Authoze.NET</a>
                                                    @endif
                                                </td>
                                                <td class="center">
                                                    @if ($row->status != 'Paid')
                                                        <a href="javascript:;" id="resent_{{ $row->id }}"
                                                            onclick="re_send_invoice('{{ $row->id }}');"
                                                            class="btn btn-teal btn-sm btn-warning"><i class="fas fa-share"
                                                                aria-hidden="true"></i> Resend</a><br><br>
                                                        <a href="javascript:void(0)"
                                                            onClick="del_recrod('{{ $row->id }}')"
                                                            class="btn btn-teal delete_invoice btn-sm btn-danger"><i
                                                                class="fas fa-minus-circle" aria-hidden="true"></i>
                                                            Delete</a>
                                                    @endif
                                                </td>
                                            </tr>
                                            <tr style="display: none;" id="subtrr{{ $row->id }}">
                                                <td colspan="4">

                                                </td>


                                                <td colspan="3">
                                                    <div class="row">

                                                        <div class="col-lg-3"><a class="btn btn-sm btn-danger"
                                                                href="javascript:"
                                                                onclick="del_recrod('{{ $row->id }}');"
                                                                title="Delete"><i class="glyphicon glyphicon-trash"></i>
                                                                Delete</a></div>
                                                        <div class="col-lg-3">
                                                            <a href="{{ admin_url() }}invoice/{{ $row->id }}"
                                                                class="btn btn-info  btn-sm">Details</a>
                                                        </div>
                                                        <div class="col-lg-3">
                                                            <a href="{{ admin_url() }}invoice/{{ $row->id }}/edit"
                                                                class="btn btn-info  btn-sm"><i
                                                                    class="fas fa-pen-to-square" aria-hidden="true"></i>
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
@endsection
@section('beforeBodyClose')
    <script type="text/javascript" src="{{ base_url() }}back/mod/mod_js.js"></script>
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
                    url: "{{ admin_url() }}invoice/" + id,
                    data: {
                        '_token': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function(data) {
                        if (JSON.parse(data).status) {
                            $("#row_" + id).fadeOut(1000);
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

        function change_status(cid) {
            var sts = $("#invoice_status_" + cid).val();
            postMyForm(
                '{{ admin_url() }}' + "invoice/status", {
                    idds: cid,
                    sts: sts,
                    _token: $("meta[name=csrf-token]").attr("content")
                },
                function() {
                    alertme('<i class="fas fa-check" aria-hidden="true"></i> Status Updated ', 'success', true, 1500);
                }
            );

        }

        function re_send_invoice(cid) {
            $("#resent_" + cid).html('<i class="text-warning fas fa-sync fa-spin" aria-hidden="true"></i> Resend');
            postMyForm(
                '{{ admin_url() }}' + "invoice/re_send_invoice", {
                    idd: cid,
                    _token: $("meta[name=csrf-token]").attr("content")
                },
                function() {
                    $(".fa-spin").hide();
                    var cnt = parseInt($("#timesent_" + cid).html());
                    cnt = cnt + 1;
                    $("#timesent_" + cid).html(cnt);
                    $("#resent_" + cid).html('<i class="text-success fas fa-check" aria-hidden="true"></i> Resend');
                    alertme('<i class="fas fa-check" aria-hidden="true"></i> Invoice Resent ', 'success', true, 1500);
                },
                function() {
                    $(".fa-spin").hide();
                    alert('error');
                }
            );

        }
    </script>
@endsection
