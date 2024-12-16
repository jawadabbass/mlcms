@extends('back.layouts.app', ['title' => $title])
@section('content')
    <aside class="right-side {{ session('leftSideBar') == 1 ? 'strech' : '' }}">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="row">
                <div class="col-md-8 col-sm-6">
                    <ol class="breadcrumb">
                        <li>
                            <a href="{{ base_url() . 'adminmedia' }}">
                                <i class="fa fa-dashboard"></i> Home
                            </a>
                        </li>
                        <li class="active">
                            <a href="{{ base_url() . 'adminmedia/leadStatUrls' }}">
                                Lead Stat Urls Management
                            </a>
                        </li>
                    </ol>
                </div>
                <div class="col-md-4 col-sm-6">
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
                                    <h3 class="box-title">All Lead Stat Urls</h3>
                                </div>
                                @include('flash::message')
                            </div>
                        </div>
                        <!-- /.box-header -->
                        <div class="box-body table-responsive">
                            <form method="post" id="leadStatUrl-search-form">
                                <div class="row mb-3">
                                    <div class="col-lg-4">
                                        <button type="button" class="btn btn-info" onclick="showFilters();"
                                            id="showFilterBtn">Show
                                            Filters</button>
                                        <button type="button" class="btn btn-warning" onclick="hideFilters();"
                                            id="hideFilterBtn" style="display: none;">Hide Filters</button><br><br>
                                    </div>
                                    <div class="col-sm-8 text-right">
                                        <div class="text-right" style="padding-bottom:2px;">
                                            <a href="{{ route('lead.stats.index') }}" class="btn btn-small btn-warning"
                                                target="_blank">Lead Stats</a>
                                            <a href="{{ route('leadStatUrl.create') }}"
                                                class="btn btn-small btn-success">Add Lead Stat Url</a>
                                        </div>
                                    </div>
                                </div>
                                <div class="row mb-3" id="filterForm" style="display: none;">
                                    <div class="col-md-3 form-group">
                                        <label>Referrer</label>
                                        <input id="referrer" name="referrer" type="text" placeholder="Referrer"
                                            value="{{ request('referrer', '') }}" class="form-control">
                                    </div>
                                    <div class="col-md-3 form-group">
                                        <label>URL</label>
                                        <input id="url_search" name="url" type="text" placeholder="URL"
                                            value="{{ request('url', '') }}" class="form-control">
                                    </div>
                                </div>
                                <table class="table table-striped table-bordered" style="width: 100%"
                                    id="leadStatUrlDatatableAjax">
                                    <thead>
                                        <tr>
                                            <th>Referrer</th>
                                            <th>Internal/External</th>
                                            <th>URL / Keyword</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    </tbody>
                                </table>
                            </form>
                        </div>
                        <!-- /.box-body -->
                    </div>
                    <!-- /.box -->
                    <!-- /.box -->
                </div>
            </div>
        </section>
        <!-- /.content -->
    </aside>
    @include('back.common_views.spinner')
@endsection
@push('beforeBodyClose')
    @include('back.lead_stat_urls.edit_url_js')
@endpush
@section('beforeBodyClose')
    <script>
        $(function() {
            var oTable = $('#leadStatUrlDatatableAjax').DataTable({
                "autoWidth": true,
                processing: true,
                serverSide: true,
                stateSave: true,
                searching: false,
                "order": [
                    [0, "asc"]
                ],
                paging: true,
                info: true,
                ajax: {
                    url: '{!! route('fetchLeadStatUrlsAjax') !!}',
                    data: function(d) {
                        d.referrer = $('#referrer').val();
                        d.url = $('#url_search').val();
                    }
                },
                columns: [
                    {
                        data: 'referrer',
                        name: 'referrer'
                    },
                    {
                        data: 'url_internal_external',
                        name: 'url_internal_external'
                    },
                    {
                        data: 'url',
                        name: 'url'
                    },
                    {
                        data: 'action',
                        name: 'action',
                        orderable: false,
                        searchable: false
                    }
                ]
            });
            $('#leadStatUrl-search-form').on('submit', function(e) {
                oTable.draw();
                e.preventDefault();
            });
            $('#url').on('keyup', function(e) {
                oTable.draw();
                e.preventDefault();
            });
        });

        function showFilters() {
            $('#filterForm').show('slow');
            $('#showFilterBtn').hide('slow');
            $('#hideFilterBtn').show('slow');
        }

        function hideFilters() {
            $('#filterForm').hide('slow');
            $('#showFilterBtn').show('slow');
            $('#hideFilterBtn').hide('slow');
        }

        function deleteLeadStatUrl(id) {
            var msg = 'Are you sure?';
            var url = '{{ url('adminmedia/leadStatUrl/') }}/' + id;
            if (confirm(msg)) {
                $.post(url, {
                        id: id,
                        _method: 'DELETE',
                        _token: '{{ csrf_token() }}'
                    })
                    .done(function(response) {
                        if (response.includes('ok')) {
                            var table = $('#leadStatUrlDatatableAjax').DataTable();
                            table.row('leadStatUrlDtRow' + id).remove().draw(false);
                            alert('Deleted Successfully!');
                        } else {
                            alert('Request Failed!');
                        }
                    });
            }
        }
    </script>
    <!-- Filer -->
@endsection
