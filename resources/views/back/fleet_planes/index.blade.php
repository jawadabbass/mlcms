@extends('back.layouts.app',['title'=>$title])
@section('content')
    <aside class="right-side {{ session('leftSideBar') == 1 ? 'strech' : '' }}">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="row">
                <div class="col-md-8 col-sm-6">
                    <ol class="breadcrumb">
                        <li>
                            <a href="{{ base_url() . 'adminmedia' }}">
                                <i class="fa-solid fa-dashboard"></i> Home
                            </a>
                        </li>
                        <li class="active">Fleet Planes Management</li>
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
                                    <h3 class="box-title">All Fleet Planes</h3>
                                </div>
                            </div>
                        </div>
                        <!-- /.box-header -->
                        <div class="box-body table-responsive">
                            <form method="post" id="fleetPlane-search-form">
                                <div class="row mb-3">
                                    <div class="col-lg-4">

                                        <button type="button" class="btn btn-info" onclick="showFilters();"
                                            id="showFilterBtn">Show
                                            Filters</button>
                                        <button type="button" class="btn btn-warning" onclick="hideFilters();"
                                            id="hideFilterBtn" style="display: none;">Hide Filters</button><br><br>
                                    </div>

                                    <div class="col-sm-8 text-end">
                                        <div class="text-end" style="padding-bottom:2px;">
                                            <a href="{{ route('fleetPlanes.create') }}" class="sitebtn">Add Fleet Plane</a>
                                        </div>
                                        <a href="{{ route('fleetPlanes.sort') }}" class="btn btn-warning">
                                            <i class="la la-bars"></i>Sort Fleet Plane
                                        </a>
                                    </div>

                                </div>

                                <div class="row mb-3" id="filterForm" style="display: none;">
                                    <div class="col-md-3 form-group">
                                        <label>Fleet Category</label>
                                        <select class="form-control" name="fleet_category_id" id="fleet_category_id">
                                            {!! generateFleetCategoriesDropDown(request('fleet_category_id'), true) !!}
                                        </select>
                                    </div>
                                    <div class="col-md-3 form-group">
                                        <label>Plane Name</label>
                                        <input id="plane_name" name="plane_name" type="text" placeholder="Plane Name" value="{{ request('plane_name', '') }}" class="form-control">
                                    </div>
                                    <div class="col-md-3 form-group">
                                        <label for="status">Status:</label>
                                        <select class="form-control" name="status" id="status">
                                            {!! generateFleetPlaneStatusDropDown(request('status', '')) !!}
                                        </select>
                                    </div>
                                </div>
                                <table class="table table-striped table-bordered" style="width: 100%"
                                    id="fleetPlaneDatatableAjax">
                                    <thead>
                                        <tr>
                                            <th>Image</th>
                                            <th>Category</th>
                                            <th>Plane Name</th>
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
    </aside>
    @include('back.common_views.spinner')
@endsection
@section('beforeBodyClose')
    <script>
        $(function() {
            var oTable = $('#fleetPlaneDatatableAjax').DataTable({
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
                    url: '{!! route('fetchFleetPlanesAjax') !!}',
                    data: function(d) {
                        d.fleet_category_id = $('#fleet_category_id').val();
                        d.plane_name = $('#plane_name').val();
                        d.status = $('#status').val();
                    }
                },
                columns: [
                    {
                        data: 'image',
                        name: 'image'
                    },
                    {
                        data: 'fleet_category_id',
                        name: 'fleet_category_id'
                    },
                    {
                        data: 'plane_name',
                        name: 'plane_name'
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

            $('#fleetPlane-search-form').on('submit', function(e) {
                oTable.draw();
                e.preventDefault();
            });
            $('#fleet_category_id').on('change', function(e) {
                oTable.draw();
                e.preventDefault();
            });
            $('#plane_name').on('keyup', function(e) {
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

        function deleteFleetPlane(id) {
            var msg = 'Are you sure?';
            var url = '{{ url('adminmedia/fleetPlanes/') }}/' + id;
            if (confirm(msg)) {
                $.post(url, {
                        id: id,
                        _method: 'DELETE',
                        _token: '{{ csrf_token() }}'
                    })
                    .done(function(response) {
                        if (response == 'ok') {
                            var table = $('#fleetPlaneDatatableAjax').DataTable();
                            table.row('fleetPlaneDtRow' + id).remove().draw(false);
                        } else {
                            alert('Request Failed!');
                        }
                    });
            }
        }

        function updateFleetPlaneStatus(id, prev_status, status) {
            var url = '{{ url('adminmedia/updateFleetPlaneStatus/') }}';
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
