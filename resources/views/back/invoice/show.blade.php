@extends('back.layouts.app', ['title' => $title])
@section('content')
    <aside class="right-side {{ session('leftSideBar') == 1 ? 'strech' : '' }}">
        <section class="content-header">
            <div class="row">
                <div class="col-md-8 col-sm-6">
                    {!! getBC('Details', $bcArr) !!}
                </div>
                <div class="col-md-4 col-sm-6">
                    @include('back.common_views.quicklinks')
                </div>
            </div>
        </section>
        <section class="content">
            <div class="row">
                <div class="col-md-12">
                    <div class="box box-primary">
                        <div class="box-header">
                            <h3 class="box-title">
                                Details {!! $clientName !!}</code>
                            </h3>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <table class="table">

                                    <tbody>
                                        @php
                                            $arrF = [
                                                'id' => ['id', ''],
                                                'invoice id' => ['invoice_id', ''],
                                                /* 'fk_admin_id'=>['fk_admin_id',''], */
                                                'Email' => ['email', 'mailto'],
                                                'Created Date' => ['created_date', 'date'],
                                                'Sent Date' => ['sent_date', 'date'],
                                                'status' => ['status', 'code'],
                                                'price Unit' => ['price_unit', 'code'],
                                                'amount' => ['amount', 'price_code'],
                                                'IP' => ['user_ip', 'ip'],
                                                'comment' => ['comments', 'comment'],
                                                /* 'copy_me'=>['copy_me','email'], */
                                                'No.of Times Sent' => ['time_sent', 'time'],
                                                /* 'paid_alert_status'=>['paid_alert_status',''], */
                                            ];
                                            
                                        @endphp
                                        @foreach ($arrF as $key => $val)
                                            @php
                                                $cval = $val[0];
                                            @endphp
                                            <tr>
                                                <td><strong>{{ ucwords($key) }}</strong></td>
                                                <td>{!! ModTBuild($client->$cval, $val[1], 'invoice/') !!}</td>
                                            </tr>
                                        @endforeach
                                        <tr>
                                            <td><strong>Payment</strong></td>
                                            <td>

                                                @foreach ($client->paymet_method as $kk => $val)
                                                    <i class="fa-solid fa-check-square-o" aria-hidden="true"></i>
                                                    @if ($val->fk_payment_option_id == 2)
                                                        <a rel="nofollow" data-bs-toggle="tooltip"
                                                            title="Web link using Paypal" target="_blank"
                                                            href="{{ base_url() }}invoice/<?php echo $client->invoice_webkey; ?>"
                                                            class="get-weblink"><i class="fa-solid fa-external-link"
                                                                aria-hidden="true"></i> PayPal</a>
                                                    @elseif($val->fk_payment_option_id == 5)
                                                        <a rel="nofollow" data-bs-toggle="tooltip"
                                                            title="Web link using Authoze.NET" target="_blank"
                                                            href="{{ base_url() }}invoice/pay/<?php echo $client->invoice_webkey; ?>"
                                                            class="get-weblink"><i class="fa-solid fa-external-link"
                                                                aria-hidden="true"></i> Authoze.NET</a>
                                                    @else
                                                        {{ $val->payment_name->title }}
                                                    @endif
                                                    <br>
                                                @endforeach
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                            <div class="col-md-6"></div>


                        </div>
                    </div>
                </div>
            </div>
        </section>
    </aside>
@endsection
@section('beforeBodyClose')
    <script type="text/javascript">
        function loadmorediv() {
            $(".tracking-item").slice(0, 10).show();
            $(".tracking-item:hidden").slice(0, 10).slideDown();
            if ($(".tracking-item:hidden").length == 0) {
                $("#loadMore").fadeOut('slow');
            }
        }
    </script>
@endsection
