@extends('back.layouts.app')
@section('content')
    <div class="content-wrapper pl-3 pr-2">
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
                            <a href="{{ base_url() . 'adminmedia/permissions' }}">
                                Permission
                            </a>
                        </li>
                    </ol>
                </div>
                <div class="col-md-7 col-sm-12">
                    @include('back.common_views.quicklinks')
                </div>
            </div>
        </section>
        <!--begin::Entry-->
        <div class="container">
            <!--begin::Notice-->
            @include('back.common_views.alert')
            <!--end::Notice-->
            <!--begin::Card-->
            <div class="card card-info">
                <div class="card-header">
                    <div class="card-title">
                        <h3 class="card-label">Permissions Management</h3>
                    </div>
                    <div class="card-toolbar text-right">
                        <!--begin::Button-->
                        @if (isAllowed('Sort Permissions'))
                            <a href="{{ route('permissions.sort') }}"
                                class="btn btn-warning mr-2">
                                <i class="fas fa-bars"></i> Sort Permissions
                            </a>
                        @endif
                        @if (isAllowed('Add new Permission'))
                            <a href="{{ route('permissions.create') }}" class="btn btn-danger">
                                <i class="fas fa-plus"></i> New Permission</a>
                        @endif
                        <!--end::Button-->
                    </div>
                </div>
                <div class="card-body">
                    <form method="post" role="form" id="permission-search-form" class="mb-3">
                        <button type="button" class="btn btn-success" onclick="showFilters();" id="showFilterBtn" style="display: none;">Show
                            Filters</button>
                        <button type="button" class="btn btn-success" onclick="hideFilters();" id="hideFilterBtn"
                            >Hide Filters</button><br><br>
                        <div class="row mb-2" id="filterForm">
                            <div class="col-lg-3 mb-lg-0 mb-2">
                                <label>Permission Title:</label>
                                <input type="text" name="title" id="title" value="{{ old('title') }}"
                                    class="form-control datatable-input" placeholder="Title" data-col-index="0">
                            </div>
                            <div class="col-lg-3 mb-lg-0 mb-2">
                                <label>Permission Group:</label>
                                <select class="form-control datatable-input" name="permission_group_id"
                                    id="permission_group_id" data-col-index="1">
                                    {!! generatePermissionGroupsDropDown(old('permission_group_id', ''), true) !!}
                                </select>
                            </div>
                        </div>
                    </form>
                    <!--begin: Datatable-->
                    <table class="table table-striped table-bordered" style="width: 100%"
                        id="permissionDatatableAjax">
                        <thead>
                            <tr>
                                <th></th>
                                <th>Permission Title</th>
                                <th>Permission Group</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                    </table>
                    <!--end: Datatable-->
                </div>
            </div>
            <!--end::Card-->
        </div>
        <!--end::Entry-->
    </div>
@endsection
@section('beforeBodyClose')
    <script>
        $(function() {
            var oTable = $('#permissionDatatableAjax').DataTable({
                processing: true,
                serverSide: true,
                stateSave: true,
                searching: false,
                order: [
                    [0, "asc"],
                    [1, "asc"]
                ],
                paging: true,
                info: true,
                ajax: {
                    url: '{!! route('fetchPermissionsAjax') !!}',
                    data: function(d) {
                        d.title = $('#title').val();
                        d.permission_group_id = $('#permission_group_id').val();
                    }
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
                        data: 'permission_group_id',
                        name: 'permission_group_id'
                    },
                    {
                        data: 'action',
                        name: 'action',
                        orderable: false,
                        searchable: false
                    }
                ]
            });
            $('#permission-search-form').on('submit', function(e) {
                oTable.draw();
                e.preventDefault();
            });
            $('#title').on('keyup', function(e) {
                oTable.draw();
                e.preventDefault();
            });
            $('#permission_group_id').on('change', function(e) {
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

        function deletePermission(id) {
            var msg = 'Are you sure?';
            if (confirm(msg)) {
                $.post("{{ url('adminmedia/permissions/') }}/" + id, {
                        id: id,
                        _method: 'DELETE',
                        _token: '{{ csrf_token() }}'
                    })
                    .done(function(response) {
                        if (response == 'ok') {
                            var table = $('#permissionDatatableAjax').DataTable();
                            table.row('permissionDtRow' + id).remove().draw(false);
                        } else {
                            alert('Request Failed!');
                        }
                    });
            }
        }

        function updatePermissionGroupId(id, prev_permission_group_id, permission_group_id) {
            var url = '{{ route('updatePermissionGroupId') }}';
            var msg = 'Are you sure?';
            if (confirm(msg)) {
                $.post(url, {
                        id: id,
                        permission_group_id: permission_group_id,
                        _token: '{{ csrf_token() }}'
                    })
                    .done(function(response) {
                        //
                    });
            } else {
                $('#permission_group_id_' + id).val(prev_permission_group_id);
            }
        }
    </script>
@endsection
