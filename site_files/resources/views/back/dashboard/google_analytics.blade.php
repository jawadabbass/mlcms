@if ($is_show_analytics)
    <div class="content m-3">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-6">
                    <div class="card card-success collapsed-card">
                        <div class="card-header">
                            <h3 class="card-title">Visitors And Page Views</h3>
                            <div class="card-tools">
                                <button type="button" class="btn btn-tool" data-card-widget="maximize">
                                    <i class="fas fa-expand"></i>
                                </button>
                                <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                    <i class="fas fa-plus"></i>
                                </button>
                            </div>
                        </div>
                        <div class="card-body p-0">
                            <table class="table table-striped">
                                <tr>
                                    <th>Page Title</th>
                                    <th>Active Users</th>
                                    <th>Screen Page Views</th>
                                </tr>
                                @foreach ($visitorsAndPageViews as $row)
                                    @php
                                        $row = (object) $row;
                                        //dd($row);
                                    @endphp
                                    <tr>
                                        <td>{{ $row->pageTitle }}</td>
                                        <td>{{ $row->activeUsers }}</td>
                                        <td>{{ $row->screenPageViews }}</td>
                                    </tr>
                                @endforeach
                            </table>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="card card-warning collapsed-card">
                        <div class="card-header">
                            <h3 class="card-title">Visitors And Page Views By Date</h3>
                            <div class="card-tools">
                                <button type="button" class="btn btn-tool" data-card-widget="maximize">
                                    <i class="fas fa-expand"></i>
                                </button>
                                <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                    <i class="fas fa-plus"></i>
                                </button>
                            </div>
                        </div>
                        <div class="card-body p-0">
                            <table class="table table-striped">
                                <tr>
                                    <th>Date</th>
                                    <th>Page Title</th>
                                    <th>Active Users</th>
                                    <th>Screen Page Views</th>
                                </tr>
                                @foreach ($visitorsAndPageViewsByDate as $row)
                                    @php
                                        $row = (object) $row;
                                        //dd($row);
                                    @endphp
                                    <tr>
                                        <td>{{ date('m-d-Y', strtotime($row->date)) }}</td>
                                        <td>{{ $row->pageTitle }}</td>
                                        <td>{{ $row->activeUsers }}</td>
                                        <td>{{ $row->screenPageViews }}</td>
                                    </tr>
                                @endforeach
                            </table>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="card card-danger collapsed-card">
                        <div class="card-header">
                            <h3 class="card-title">Total Visitors And Page Views</h3>
                            <div class="card-tools">
                                <button type="button" class="btn btn-tool" data-card-widget="maximize">
                                    <i class="fas fa-expand"></i>
                                </button>
                                <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                    <i class="fas fa-plus"></i>
                                </button>
                            </div>
                        </div>
                        <div class="card-body p-0">
                            <table class="table table-striped">
                                <tr>
                                    <th>Date</th>
                                    <th>Active Users</th>
                                    <th>Screen Page Views</th>
                                </tr>
                                @foreach ($totalVisitorsAndPageViews as $row)
                                    @php
                                        $row = (object) $row;
                                        //dd($row);
                                    @endphp
                                    <tr>
                                        <td>{{ date('m-d-Y', strtotime($row->date)) }}</td>
                                        <td>{{ $row->activeUsers }}</td>
                                        <td>{{ $row->screenPageViews }}</td>
                                    </tr>
                                @endforeach
                            </table>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="card card-info collapsed-card">
                        <div class="card-header">
                            <h3 class="card-title">Most Visited Pages</h3>
                            <div class="card-tools">
                                <button type="button" class="btn btn-tool" data-card-widget="maximize">
                                    <i class="fas fa-expand"></i>
                                </button>
                                <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                    <i class="fas fa-plus"></i>
                                </button>
                            </div>
                        </div>
                        <div class="card-body p-0">
                            <table class="table table-striped">
                                <tr>
                                    <th>Page Title</th>
                                    <th>Full Page Url</th>
                                    <th>Screen Page Views</th>
                                </tr>
                                @foreach ($mostVisitedPages as $row)
                                    @php
                                        $row = (object) $row;
                                        //dd($row);
                                    @endphp
                                    <tr>
                                        <td>{{ $row->pageTitle }}</td>
                                        <td>{{ $row->fullPageUrl }}</td>
                                        <td>{{ $row->screenPageViews }}</td>
                                    </tr>
                                @endforeach
                            </table>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="card card-success collapsed-card">
                        <div class="card-header">
                            <h3 class="card-title">Top Referrers</h3>
                            <div class="card-tools">
                                <button type="button" class="btn btn-tool" data-card-widget="maximize">
                                    <i class="fas fa-expand"></i>
                                </button>
                                <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                    <i class="fas fa-plus"></i>
                                </button>
                            </div>
                        </div>
                        <div class="card-body p-0">
                            <table class="table table-striped">
                                <tr>
                                    <th>Page Referrer</th>
                                    <th>Screen Page Views</th>
                                </tr>
                                @foreach ($topReferrers as $row)
                                    @php
                                        $row = (object) $row;
                                        //dd($row);
                                    @endphp
                                    <tr>
                                        <td>{{ $row->pageReferrer }}</td>
                                        <td>{{ $row->screenPageViews }}</td>
                                    </tr>
                                @endforeach
                            </table>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="card card-warning collapsed-card">
                        <div class="card-header">
                            <h3 class="card-title">User Types</h3>
                            <div class="card-tools">
                                <button type="button" class="btn btn-tool" data-card-widget="maximize">
                                    <i class="fas fa-expand"></i>
                                </button>
                                <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                    <i class="fas fa-plus"></i>
                                </button>
                            </div>
                        </div>
                        <div class="card-body p-0">
                            <table class="table table-striped">
                                <tr>
                                    <th>New / Returning</th>
                                    <th>Active Users</th>
                                </tr>
                                @foreach ($userTypes as $row)
                                    @php
                                        $row = (object) $row;
                                        //dd($row);
                                    @endphp
                                    <tr>
                                        <td>{{ $row->newVsReturning }}</td>
                                        <td>{{ $row->activeUsers }}</td>
                                    </tr>
                                @endforeach
                            </table>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="card card-danger collapsed-card">
                        <div class="card-header">
                            <h3 class="card-title">Top Browsers</h3>
                            <div class="card-tools">
                                <button type="button" class="btn btn-tool" data-card-widget="maximize">
                                    <i class="fas fa-expand"></i>
                                </button>
                                <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                    <i class="fas fa-plus"></i>
                                </button>
                            </div>
                        </div>
                        <div class="card-body p-0">
                            <table class="table table-striped">
                                <tr>
                                    <th>Browser</th>
                                    <th>Screen Page Views</th>
                                </tr>
                                @foreach ($topBrowsers as $row)
                                    @php
                                        $row = (object) $row;
                                        //dd($row);
                                    @endphp
                                    <tr>
                                        <td>{{ $row->browser }}</td>
                                        <td>{{ $row->screenPageViews }}</td>
                                    </tr>
                                @endforeach
                            </table>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="card card-info collapsed-card">
                        <div class="card-header">
                            <h3 class="card-title">Top Countries</h3>
                            <div class="card-tools">
                                <button type="button" class="btn btn-tool" data-card-widget="maximize">
                                    <i class="fas fa-expand"></i>
                                </button>
                                <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                    <i class="fas fa-plus"></i>
                                </button>
                            </div>
                        </div>
                        <div class="card-body p-0">
                            <table class="table table-striped">
                                <tr>
                                    <th>Country</th>
                                    <th>Screen Page Views</th>
                                </tr>
                                @foreach ($topCountries as $row)
                                    @php
                                        $row = (object) $row;
                                        //dd($row);
                                    @endphp
                                    <tr>
                                        <td>{{ $row->country }}</td>
                                        <td>{{ $row->screenPageViews }}</td>
                                    </tr>
                                @endforeach
                            </table>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="card card-info collapsed-card">
                        <div class="card-header">
                            <h3 class="card-title">Top Operating Systems</h3>
                            <div class="card-tools">
                                <button type="button" class="btn btn-tool" data-card-widget="maximize">
                                    <i class="fas fa-expand"></i>
                                </button>
                                <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                    <i class="fas fa-plus"></i>
                                </button>
                            </div>
                        </div>
                        <div class="card-body p-0">
                            <table class="table table-striped">
                                <tr>
                                    <th>Operating System</th>
                                    <th>Screen Page Views</th>
                                </tr>
                                @foreach ($topOperatingSystems as $row)
                                    @php
                                        $row = (object) $row;
                                        //dd($row);
                                    @endphp
                                    <tr>
                                        <td>{{ $row->operatingSystem }}</td>
                                        <td>{{ $row->screenPageViews }}</td>
                                    </tr>
                                @endforeach
                            </table>
                        </div>
                    </div>
                </div>
                {{-- <div class="col-md-6">
                        <canvas id="visitorsAndPageViews" width="400" height="100" aria-label="Hello ARIA World"
                            role="img">
                            <p>visitorsAndPageViews</p>
                        </canvas>
                    </div> --}}
            </div>
            <!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
@endif
@section('beforeHeadClose')
@endsection
@section('beforeBodyClose')
    @if ($is_show_analytics)
        <script>
            /* const data = {!! $visitorsAndPageViews !!};
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
                            ); */
        </script>
    @endif
@endsection
