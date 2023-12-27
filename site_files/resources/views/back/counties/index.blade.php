@extends('back.layouts.app',['title'=>$title])

@section('content')
    <div class="content-wrapper pl-3 pr-2">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="row">
                <div class="col-md-5 col-sm-12">
                    <ol class="breadcrumb">
                        <li>
                            <a href="{{ base_url() . 'adminmedia' }}">
                                <i class="fas fa-tachometer-alt"></i> Home
                            </a>
                        </li>
                        <li class="active">Counties Management</li>
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
                            <div class="col-sm-8">
                                <div class="box-header">
                                    <h3 class="box-title">All Counties</h3>
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="text-end" style="padding-bottom:2px;">
                                    <a href="{{ route('counties.create') }}" class="sitebtn">Add County</a>
                                </div>
                            </div>
                        </div>
                        <!-- /.box-header -->
                        <div class="box-body table-responsive">
                            <form method="post" id="county-search-form">
                                <div class="row mb-3">
                                    <div class="col-lg-6">

                                        <button type="button" class="btn btn-info" onclick="showFilters();"
                                            id="showFilterBtn">Show
                                            Filters</button>
                                        <button type="button" class="btn btn-warning" onclick="hideFilters();"
                                            id="hideFilterBtn" style="display: none;">Hide Filters</button><br><br>
                                    </div>
                                     
                                    <div class="col-lg-6 text-end">
                                        <a href="{{ route('counties.sort') }}" class="btn btn-warning">
                                            <i class="la la-bars"></i>Sort Counties
                                        </a>
                                    </div>
                                    
                                </div>

                                <div class="row" id="filterForm" style="display: none;">
                                    <div class="col-md-3 form-group">
                                        <label>State</label>
                                        <select class="form-control select2" name="state_id" id="state_id">
                                            {!! generateStatesDropDown(request('state_id', ''), true) !!}
                                        </select>
                                    </div>
                                    <div class="col-md-3 form-group">
                                        <label>County Name</label>
                                        <input id="county_name" name="county_name" type="text" placeholder="County Name"
                                            value="{{ request('county_name', '') }}" class="form-control">
                                    </div>
                                    <div class="col-md-3 form-group">
                                        <label for="status">Status:</label>
                                        <select class="form-control" name="status" id="status">
                                            {!! generateStatusDropDown(request('status', '')) !!}
                                        </select>
                                    </div>
                                </div>

                                <table class="table table-striped table-bordered" style="width: 100%"
                                    id="countyDatatableAjax">
                                    <thead>
                                        <tr>
                                            <th>County Name</th>
                                            <th>State</th>                                            
                                            <th>Status</th>
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
    </div>
    @include('back.common_views.spinner')
@endsection
@section('beforeBodyClose')
    <script>
        $(function() {
            var oTable = $('#countyDatatableAjax').DataTable({
                "autoWidth": true,
                processing: true,
                serverSide: true,
                countySave: true,
                searching: false,
                "order": [
                    [0, "asc"]
                ],
                paging: true,
                info: true,
                ajax: {
                    url: '{!! route('fetchCountiesAjax') !!}',
                    data: function(d) {
                        d.state_id = $('#state_id').val();
                        d.county_name = $('#county_name').val();
                        d.status = $('#status').val();
                    }
                },
                columns: [
                    {
                        data: 'county_name',
                        name: 'county_name'
                    },
                    {
                        data: 'state_id',
                        name: 'state_id'
                    },
                    {
                        data: 'status',
                        name: 'status'
                    },
                    {
                        data: 'action',
                        name: 'action',
                        orderable: false,
                        searchable: false
                    }
                ]
            });

            $('#county-search-form').on('submit', function(e) {
                oTable.draw();
                e.preventDefault();
            });
            $('#state_id').on('change', function(e) {
                oTable.draw();
                e.preventDefault();
            });
            $('#county_name').on('keyup', function(e) {
                oTable.draw();
                e.preventDefault();
            });
            $('#status').on('change', function(e) {
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

        function deleteCounty(id) {
            var msg = 'Are you sure? this will delete all related cities';
            var url = '{{ url('adminmedia/counties/') }}/' + id;
            if (confirm(msg)) {
                $.post(url, {
                        id: id,
                        _method: 'DELETE',
                        _token: '{{ csrf_token() }}'
                    })
                    .done(function(response) {
                        if (response.includes('ok')) {
                            var table = $('#countyDatatableAjax').DataTable();
                            table.row('countyDtRow' + id).remove().draw(false);
                        } else {
                            alert('Request Failed!');
                        }
                    });
            }
        }

        function updateCountyStatus(id, prev_status, status) {
            var url = '{{ url('adminmedia/updateCountyStatus/') }}';
            var msg = 'Are you sure?';
            if (confirm(msg)) {
                $.post(url, {
                        id: id,
                        status: status,
                        _token: '{{ csrf_token() }}'
                    })
                    .done(function(response) {
                        //
                    });
            } else {
                $('status_' + id).val(prev_status);
            }
        }
    </script>
    <!-- Filer -->
@endsection
