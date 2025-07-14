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
                                        <label for="is_featured">IsFeatured:</label>
                                        <select class="form-control" name="is_featured" id="is_featured">
                                            {!! generateServiceIsFeaturedDropDown(request('is_featured', '')) !!}
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
                                            <th>Sort Order</th>
                                            <th>Title</th>
                                            <th>Parent Category</th>
                                            <th>Is Featured?</th>
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
                stateSave: false,
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
                "drawCallback": function(settings) {
                    setToggles();
                },
                columns: [{
                        data: 'sort_order',
                        name: 'sort_order'
                    },
                    {
                        data: 'title',
                        name: 'title'
                    },
                    {
                        data: 'parent_id',
                        name: 'parent_id'
                    },
                    {
                        data: 'is_featured',
                        name: 'is_featured'
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
            oTable.column(0).visible(false);
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
            $('#is_featured').on('change', function(e) {
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
                            Toast.fire({
                                icon: "success",
                                title: "Service Deleted Successfully"
                            });
                        } else {
                            Toast.fire({
                                icon: "danger",
                                title: "Service Deletion Failed"
                            });
                        }
                    });
            }
        }

        function updateServiceIsFeatured(id) {
            var old_is_featured = 1;
            var new_is_featured = 0;
            if ($('#is_featured_' + id).val() == 0) {
                old_is_featured = 0;
                new_is_featured = 1;
            }
            var url = base_url + 'adminmedia/updateServiceIsFeatured';
            $.post(url, {
                    id: id,
                    is_featured: new_is_featured,
                    _token: '{{ csrf_token() }}'
                })
                .done(function(sts) {
                    if (sts == 'Done Successfully!') {
                        $('#is_featured_' + id).val(new_is_featured);
                        alertme('<i class="fas fa-check" aria-hidden="true"></i> ' + sts, 'success', true, 1500);
                    } else {
                        $('#is_featured_' + id).val(old_is_featured);
                        if (old_is_featured == 0) {
                            $('#is_featured_' + id).bootstrapToggle('off', true)
                        } else {
                            $('#is_featured_' + id).bootstrapToggle('on', true)
                        }
                        alertme('<i class="fas fa-check" aria-hidden="true"></i> ' + sts, 'danger', true, 1500);
                    }
                });

        }

        function updateServiceStatus(id) {
            var old_status = 1;
            var new_status = 0;
            if ($('#status_' + id).val() == 0) {
                old_status = 0;
                new_status = 1;
            }
            var url = base_url + 'adminmedia/updateServiceStatus';
            $.post(url, {
                    id: id,
                    status: new_status,
                    _token: '{{ csrf_token() }}'
                })
                .done(function(sts) {
                    if (sts == 'Done Successfully!') {
                        $('#status_' + id).val(new_status);
                        alertme('<i class="fas fa-check" aria-hidden="true"></i> ' + sts, 'success', true, 1500);
                    } else {
                        $('#status_' + id).val(old_status);
                        if (old_status == 0) {
                            $('#status_' + id).bootstrapToggle('off', true)
                        } else {
                            $('#status_' + id).bootstrapToggle('on', true)
                        }
                        alertme('<i class="fas fa-check" aria-hidden="true"></i> ' + sts, 'danger', true, 1500);
                    }
                });

        }

        function setToggles() {
            $('input[data-toggle="toggle_is_featured"]').bootstrapToggle();
            $('input[data-toggle="toggle_status"]').bootstrapToggle();
        }
        $(document).on('change', 'input[data-toggle="toggle_is_featured"]', function() {
            let id = $(this).attr('data-id');
            updateServiceIsFeatured(id);
        });
        $(document).on('change', 'input[data-toggle="toggle_status"]', function() {
            let id = $(this).attr('data-id');
            updateServiceStatus(id);
        });
    </script>
    <!-- Filer -->
@endsection
