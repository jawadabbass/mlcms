@extends('back.layouts.app', ['title' => $title])
@section('content')
<div class="pl-3 pr-2 content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="row">
            <div class="col-md-5 col-sm-12">
                <ol class="breadcrumb">
                    <li>
                        <a href="{{ base_url() . 'adminmedia' }}">
                            <i class="fa fa-dashboard"></i> Home
                        </a>
                    </li>
                    <li class="active">
                        <a href="{{ base_url() . 'adminmedia/lead-stats' }}">
                            Lead Stats
                        </a>
                    </li>
                </ol>
            </div>
            <div class="col-md-7 col-sm-12">
                @include('back.common_views.quicklinks')
            </div>
        </div>
    </section>
        <!-- Main content -->
        <section class="content">
            <div class="row">
                <div class="col-xs-12 col-md-12">
                    <div class="box">
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="box-header">
                                    <h3 class="box-title">Lead Stats</h3>
                                </div>
                                @include('flash::message')
                            </div>
                        </div>
                        <div class="box-body">
                            <div class="row">
                                <div class="mb-3 col-md-6">
                                    <form method="get" action="{{ route('lead.stats.index') }}" id="search_form">
                                        <div class="row" onKeyPress="return checkSubmit(event)">
                                            <div class="col-md-6 form-group">
                                                <input type="hidden" name="previous_dates" id="previous_dates"
                                                    value="<?php if (isset($_GET['dates'])) {
                                                        echo $_GET['dates'];
                                                    } ?>">
                                                <input type="text" name="dates" id="date_range" class="form-control">
                                            </div>
                                            <div class="text-left col-md-2">
                                                <button type="submit" class="btn btn-info"><i class="fa fa-search"
                                                        aria-hidden="true"></i> Search</button>
                                            </div>
                                            <div class="col-md-2" style="margin-left: 20px;">
                                                <a class="btn btn-warning" href="{{ route('lead.stats.index') }}"><i
                                                        class="fa fa-refresh" aria-hidden="true"></i>Reset</a>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                                <div class="mb-3 text-right col-md-6">
                                    <a class="btn btn-primary" target="_blank"
                                        href="{{ url('adminmedia/leadStatUrls') }}">Manage URLs</a>
                                </div>
                                <div class="mb-3 col-md-12">
                                    <h2></h2>
                                    <table class="table table-bordered table-inverse table-hover">
                                        <thead>
                                            <tr>
                                                <th>Impressions</th>
                                                <th>Leads</th>                                                
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td>
                                                    <span class="font-weight-bold">{{ getImpressions() }}</span>
                                                </td>
                                                <td>
                                                    <span class="font-weight-bold">{{ getLeads() }}</span>
                                                    @if (getImpressions() > 0 && getLeads() > 0)
                                                        @php
                                                            $ratio = (getLeads() / getImpressions()) * 100;
                                                        @endphp
                                                        &nbsp;-&nbsp;
                                                        <span class="text text-success font-weight-bold">
                                                            {{ number_format($ratio, 0) }}% </span>
                                                    @endif
                                                </td>                                                
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                                @if (count($referrerArray) > 0)
                                    <div class="mt-3 mb-3 col-md-12">
                                        <h2>Get Quote Page</h2>
                                        <table class="table table-bordered table-inverse table-hover">
                                            <thead>
                                                <tr>
                                                    <th>Referrer</th>
                                                    <th>Impressions</th>
                                                    <th>Leads</th>
                                                    <th>Ratio</th>
                                                    <th></th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @php
                                                    $Bstatus = '';
                                                    $BGcolor = '';
                                                @endphp
                                                @foreach ($referrerArray as $row)
                                                    @php
                                                        $bgColor =
                                                            isset($bgColor) && $bgColor == '#f9f9f9'
                                                                ? '#FFFFFF'
                                                                : '#f9f9f9';
                                                    @endphp
                                                    <tr>
                                                        <td>{{ $row['referrer'] }} <a href="javascript:void(0);"
                                                                onclick="loadEditLeadStatUrlModal({{ $row['id'] }});"
                                                                class="btn btn-primary"><i class="fa fa-external-link"
                                                                    aria-hidden="true"></i></a></td>
                                                        <td>{{ $row['totalReferrerCount'] }}</td>
                                                        <td>
                                                            {{ $row['totalLeadsByReferrerCount'] }}

                                                            @if ($row['totalLeadsByReferrerCount'] > 0)
                                                                <a class="btn btn-sm btn-success" target="_blank"
                                                                    href="{{ url('adminmedia/contact_request?dates=' . request()->input('dates', '') . '&referrer_url_id=' . $row['id']) }}">
                                                                    <i class="fa fa-eye" aria-hidden="true"></i> View
                                                                </a>
                                                            @endif
                                                        </td>
                                                        <td>
                                                            @if ($row['totalReferrerCount'] > 0 && $row['totalLeadsByReferrerCount'] > 0)
                                                                @php
                                                                    $ratio =
                                                                        ($row['totalLeadsByReferrerCount'] /
                                                                            $row['totalReferrerCount']) *
                                                                        100;
                                                                @endphp
                                                                {{ number_format($ratio, 0) }}%
                                                            @endif
                                                        </td>
                                                        <td>
                                                            @if ($row['totalReferrerCount'] > 0)
                                                                <a href="{{ route('clear.lead.stats', ['referrer'=>$row['referrer']]) }}" onclick="return confirm('Are you sure?')" class="m-1 btn btn-sm btn-warning d-none"><i class="fa fa-trash" aria-hidden="true"></i>Clear Stats</a>
                                                            @endif
                                                            <a href="{{ route('delete.lead.referrer', ['referrer' => $row['referrer']]) }}"
                                                                onclick="return confirm('Are you sure?')"
                                                                class="m-1 btn btn-sm btn-danger"><i class="fa fa-trash"
                                                                    aria-hidden="true"></i></a>
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        </div>
    @endsection
    @section('beforeBodyClose')
        @include('back.lead_stat_urls.edit_url_js')
        <script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
        <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
        <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />
        <script type="text/javascript">
            $(function() {
                var value = $("#previous_dates").val();
                if (value == '') {
                    var start = moment('10/01/2024', 'MM-DD-YYYY');
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
                    $('#date_range span').html(start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'));
                }
                $('#date_range').daterangepicker({
                    startDate: start,
                    endDate: end,
                    "linkedCalendars": false,
                    "closeText": false,
                    ranges: {
                        'Last 7 Days': [moment().subtract(6, 'days'), moment()],
                        'Last 30 Days': [moment().subtract(30, 'days'), moment()],
                        'Last 60 Days': [moment().subtract(60, 'days'), moment()],
                        'This Month': [moment().startOf('month'), moment().endOf('month')],
                        'This Year': [moment().startOf('year'), moment().endOf('year')]
                    }
                }, cb);
                cb(start, end);
            });
        </script>
        <script>
            document.onkeydown = function(evt) {
                var keyCode = evt ? (evt.which ? evt.which : evt.keyCode) : event.keyCode;
                if (keyCode == 13) {
                    $("#search_form").submit();
                }
            }
        </script>
    @endsection
