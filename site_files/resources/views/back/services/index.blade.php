@extends('back.layouts.app', ['title' => $title])

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
                        <li class="active">
                            <a href="{{ base_url() . 'adminmedia/services' }}">
                                Services Management
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
                    <div class="card">
                        <div class="row card-header">
                            <div class="col-sm-8">
                                <h3 class="card-title">All Services</h3>
                            </div>
                            <div class="col-sm-4 text-end">
                                <a href="{{ route('services.create') }}" class="btn btn-success">Add Service</a>
                                <a href="{{ route('services.sort') }}" class="btn btn-warning">Sort Services</a>
                            </div>
                        </div>

                        <!-- /.card-header -->
                        <div class="card-body table-responsive">
                            <form method="post" id="service-search-form">

                                <div class="row" id="filterForm">
                                    <div class="col-md-3 form-group">
                                        <label>Title</label>
                                        <input id="title" name="title" type="text" placeholder="Title"
                                            value="{{ request('title', '') }}" class="form-control">
                                    </div>
                                    <div class="col-md-3 form-group">
                                        <label>Parent Category</label>
                                        <select class="form-control" name="parent_id" id="parent_id">
                                            {!! generateParentServicesDropDown(request('parent_id', '')) !!}
                                        </select>
                                    </div>
                                    <div class="col-md-3 form-group">
                                        <label for="status">Status:</label>
                                        <select class="form-control" name="status" id="status">
                                            {!! generateServiceStatusDropDown(request('status', '')) !!}
                                        </select>
                                    </div>
                                </div>

                                <table class="table table-striped table-bordered" style="width: 100%"
                                    id="serviceDatatableAjax">
                                    <thead>
                                        <tr>
                                            <th>Title</th>
                                            <th>Parent Category</th>
                                            <th>Status</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    </tbody>
                                </table>
                            </form>
                        </div>
                        <!-- /.card-body -->
                    </div>
                    <!-- /.card -->
                    <!-- /.card -->
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
            var oTable = $('#serviceDatatableAjax').DataTable({
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
                    url: '{!! route('fetchServicesAjax') !!}',
                    data: function(d) {
                        d.title = $('#title').val();
                        d.parent_id = $('#parent_id').val();
                        d.status = $('#status').val();
                    }
                },
                columns: [{
                        data: 'title',
                        name: 'title'
                    },
                    {
                        data: 'parent_id',
                        name: 'parent_id'
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

            $('#service-search-form').on('submit', function(e) {
                oTable.draw();
                e.preventDefault();
            });
            $('#title').on('keyup', function(e) {
                oTable.draw();
                e.preventDefault();
            });
            $('#parent_id').on('change', function(e) {
                oTable.draw();
                e.preventDefault();
            });
            $('#status').on('change', function(e) {
                oTable.draw();
                e.preventDefault();
            });
        });

        function deleteService(id) {
            var msg = 'Are you sure?';
            var url = '{{ url('adminmedia/services/') }}/' + id;
            if (confirm(msg)) {
                $.post(url, {
                        id: id,
                        _method: 'DELETE',
                        _token: '{{ csrf_token() }}'
                    })
                    .done(function(response) {
                        if (response == 'ok') {
                            var table = $('#serviceDatatableAjax').DataTable();
                            table.row('serviceDtRow' + id).remove().draw(false);
                        } else {
                            alert('Request Failed!');
                        }
                    });
            }
        }

        function updateServiceStatus(id, prev_status, status) {
            var url = '{{ url('adminmedia/updateServiceStatus/') }}';
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
