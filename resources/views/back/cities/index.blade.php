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
                        <li class="active">Cities Management</li>
                    </ol>
                </div>
                <div class="col-md-4 col-sm-6">
                    @include('back.common_views.quicklinks')
                </div>
            </div>
        </section>
        <!-- Main content -->
        <section class="content">
            <div class="message-container" id="add_action" style="display: none">
                <div class="callout callout-success">
                    <h4>New Wish has been created successfully.</h4>
                </div>
            </div>
            <div class="message-container" id="update_action" style="display: none;">
                <div class="callout callout-success">
                    <h4>Wish has been updated successfully.</h4>
                </div>
            </div>
            <div class="message-container" id="delete_action" style="display: none">
                <div class="callout callout-danger">
                    <h4>Wish has been deleted successfully.</h4>
                </div>
            </div>
            <div class="row">
                <div class="col-xs-12 col-md-12">
                    <div class="box">
                        <div class="row">
                            <div class="col-sm-8">
                                <div class="box-header">
                                    <h3 class="box-title">All Cities</h3>
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="text-end" style="padding-bottom:2px;">
                                    <a href="{{ route('cities.create') }}" class="sitebtn">Add City</a>
                                </div>
                            </div>
                        </div>
                        <!-- /.box-header -->
                        <div class="box-body table-responsive">
                            <form method="post" id="city-search-form">
                                <div class="row mb-3">
                                    <div class="col-lg-6">

                                        <button type="button" class="btn btn-info" onclick="showFilters();"
                                            id="showFilterBtn">Show
                                            Filters</button>
                                        <button type="button" class="btn btn-warning" onclick="hideFilters();"
                                            id="hideFilterBtn" style="display: none;">Hide Filters</button><br><br>
                                    </div>

                                    <div class="col-lg-6 text-end">
                                        <a href="{{ route('cities.sort') }}" class="btn btn-warning">
                                            <i class="la la-bars"></i>Sort Cities
                                        </a>
                                    </div>

                                </div>

                                <div class="row" id="filterForm" style="display: none;">
                                    <div class="col-md-3 form-group">
                                        <label>State</label>
                                        <select class="form-control select2" name="state_id" id="state_id">
                                            {!! generateStatesDropDown(request('state_id', 0), true) !!}
                                        </select>
                                    </div>
                                    <div class="col-md-3 form-group" id="counties_dd_div">
                                        <label>County</label>
                                        <select class="form-control select2" name="county_id" id="county_id">
                                            {!! generateCountiesDropDown(request('county_id', 0), request('state_id', 0), true) !!}
                                        </select>
                                    </div>
                                    <div class="col-md-3 form-group">
                                        <label>City Name</label>
                                        <input id="city_name" name="city_name" type="text" placeholder="City Name"
                                            value="{{ request('city_name', '') }}" class="form-control">
                                    </div>
                                    <div class="col-md-3 form-group">
                                        <label for="status">Status:</label>
                                        <select class="form-control" name="status" id="status">
                                            {!! generateStatusDropDown(request('status', '')) !!}
                                        </select>
                                    </div>
                                </div>

                                <table class="table table-striped table-bordered" style="width: 100%"
                                    id="cityDatatableAjax">
                                    <thead>
                                        <tr>
                                            <th>City Name</th>
                                            <th>State</th>
                                            <th>County</th>
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
            var oTable = $('#cityDatatableAjax').DataTable({
                "autoWidth": true,
                processing: true,
                serverSide: true,
                citySave: true,
                searching: false,
                "order": [
                    [0, "asc"]
                ],
                paging: true,
                info: true,
                ajax: {
                    url: '{!! route('fetchCitiesAjax') !!}',
                    data: function(d) {
                        d.state_id = $('#state_id').val();
                        d.county_id = $('#county_id').val();
                        d.city_name = $('#city_name').val();
                        d.status = $('#status').val();
                    }
                },
                columns: [{
                        data: 'city_name',
                        name: 'city_name'
                    },
                    {
                        data: 'state_id',
                        name: 'state_id'
                    },
                    {
                        data: 'county_id',
                        name: 'county_id'
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

            $('#city-search-form').on('submit', function(e) {
                oTable.draw();
                e.preventDefault();
            });
            $('#state_id').on('change', function(e) {
                oTable.draw();
                e.preventDefault();
                filterCountiesAjax();
            });
            $(document).on('change', '#county_id', function(e) {
                oTable.draw();
                e.preventDefault();
            });
            $('#city_name').on('keyup', function(e) {
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

        function deleteCity(id) {
            var msg = 'Are you sure?';
            var url = '{{ url('adminmedia/cities/') }}/' + id;
            if (confirm(msg)) {
                $.post(url, {
                        id: id,
                        _method: 'DELETE',
                        _token: '{{ csrf_token() }}'
                    })
                    .done(function(response) {
                        if (response.includes('ok')) {
                            var table = $('#cityDatatableAjax').DataTable();
                            table.row('cityDtRow' + id).remove().draw(false);
                        } else {
                            alert('Request Failed!');
                        }
                    });
            }
        }

        function updateCityStatus(id, prev_status, status) {
            var url = '{{ url('adminmedia/updateCityStatus/') }}';
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
