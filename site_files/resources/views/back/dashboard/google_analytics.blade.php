@php
    //dd($visitorsAndPageViews);
@endphp
@extends('back.layouts.app', ['title' => FindInsettingArr('business_name') . ' | Dashboard'])
@section('content')
    <div class="content-wrapper pl-3 pr-2">
        <!-- Content Header (Page header) -->
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-md-5 col-sm-12">
                        <h1 class="m-0">Google Analytics</h1>
                    </div><!-- /.col -->
                    <div class="col-md-7 col-sm-12">
                        @include('back.common_views.quicklinks')
                    </div><!-- /.col -->
                    <div class="col-sm-12">@include('flash::message')</div>
                </div><!-- /.row -->
            </div><!-- /.container-fluid -->
        </div>
        <!-- /.content-header -->
        <!-- Main content -->
        <div class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-12">
                        <table class="table">
                            <tr><th>Page Title</th><th>Active Users</th><th>Screen Page Views</th></tr>
                            @foreach($visitorsAndPageViews as $row)
                            @php
                            $row = (object)$row;
                            //dd($row);
                            @endphp
                            <tr><td>{{ $row->pageTitle }}</td><td>{{ $row->activeUsers }}</td><td>{{ $row->screenPageViews }}</td></tr>
                            @endforeach
                        </table>
                    </div>
                    <div class="col-md-6">
                        <canvas id="visitorsAndPageViews" width="400" height="100" aria-label="Hello ARIA World"
                            role="img">
                            <p>visitorsAndPageViews</p>
                        </canvas>
                    </div>
                </div>
                <!-- /.row -->
            </div><!-- /.container-fluid -->
        </div>
        <!-- /.content -->
    </div>
@endsection
@section('beforeHeadClose')
@endsection
@section('beforeBodyClose')
    <script>
        const data = {!! $visitorsAndPageViews !!};
        const myChart = new Chart(
            document.getElementById('visitorsAndPageViews'), {
                type: 'bar',
                data: {
                    labels: data.map(row => row.pageTitle),
                    datasets: [{
                        type: 'bar',
                        label: 'Active Users',
                        data: data.map(row => row.activeUsers)
                    }, {
                        type: 'bar',
                        label: 'Screen Page views',
                        data: data.map(row => row.screenPageViews)
                    }]
                }
            }
        );
    </script>
@endsection
