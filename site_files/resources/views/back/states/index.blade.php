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
                        <li class="active">States Management</li>
                    </ol>
                </div>
                <div class="col-md-7 col-sm-12">
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
                                    <h3 class="box-title">All States</h3>
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="text-end" style="padding-bottom:2px;">
                                    <a href="{{ route('states.create') }}" class="sitebtn">Add State</a>
                                </div>
                            </div>
                        </div>
                        <!-- /.box-header -->
                        <div class="box-body table-responsive">
                            <form method="post" id="state-search-form">
                                <div class="row mb-3">
                                    <div class="col-lg-6">

                                        <button type="button" class="btn btn-info" onclick="showFilters();"
                                            id="showFilterBtn">Show
                                            Filters</button>
                                        <button type="button" class="btn btn-warning" onclick="hideFilters();"
                                            id="hideFilterBtn" style="display: none;">Hide Filters</button><br><br>
                                    </div>
                                     
                                    <div class="col-lg-6 text-end">
                                        <a href="{{ route('states.sort') }}" class="btn btn-warning">
                                            <i class="la la-bars"></i>Sort States
                                        </a>
                                    </div>
                                    
                                </div>

                                <div class="row" id="filterForm" style="display: none;">
                                    <div class="col-md-3 form-group">
                                        <label>State Code</label>
                                        <input id="state_code" name="state_code" type="text" placeholder="State Code"
                                            value="{{ old('state_code', '') }}" class="form-control">
                                    </div>
                                    <div class="col-md-3 form-group">
                                        <label>State Name</label>
                                        <input id="state_name" name="state_name" type="text" placeholder="State Name"
                                            value="{{ old('state_name', '') }}" class="form-control">
                                    </div>
                                    <div class="col-md-3 form-group">
                                        <label for="status">Status:</label>
                                        <select class="form-control" name="status" id="status">
                                            {!! generateStatusDropDown(old('status', '')) !!}
                                        </select>
                                    </div>
                                </div>

                                <table class="table table-striped table-bordered" style="width: 100%"
                                    id="stateDatatableAjax">
                                    <thead>
                                        <tr>
                                            <th>State Code</th>
                                            <th>State Name</th>
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
            var oTable = $('#stateDatatableAjax').DataTable({
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
                    url: '{!! route('fetchStatesAjax') !!}',
                    data: function(d) {
                        d.state_code = $('#state_code').val();
                        d.state_name = $('#state_name').val();
                        d.status = $('#status').val();
                    }
                },
                columns: [
                    {
                        data: 'state_code',
                        name: 'state_code'
                    },
                    {
                        data: 'state_name',
                        name: 'state_name'
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

            $('#state-search-form').on('submit', function(e) {
                oTable.draw();
                e.preventDefault();
            });
            $('#state_code').on('keyup', function(e) {
                oTable.draw();
                e.preventDefault();
            });
            $('#state_name').on('keyup', function(e) {
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

        function deleteState(id) {
            var msg = 'Are you sure? this will delete all related Counties and Cities';
            var url = '{{ url('adminmedia/states/') }}/' + id;
            if (confirm(msg)) {
                $.post(url, {
                        id: id,
                        _method: 'DELETE',
                        _token: '{{ csrf_token() }}'
                    })
                    .done(function(response) {
                        if (response.includes('ok')) {
                            var table = $('#stateDatatableAjax').DataTable();
                            table.row('stateDtRow' + id).remove().draw(false);
                        } else {
                            alert('Request Failed!');
                        }
                    });
            }
        }

        function updateStateStatus(id, prev_status, status) {
            var url = '{{ url('adminmedia/updateStateStatus/') }}';
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
