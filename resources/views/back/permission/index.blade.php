@extends('back.layouts.app')
@section('content')
    <div class="content-wrapper pl-3 pr-2">
        <!--begin::Subheader-->
        <div class="subheader py-2 py-lg-6 subheader-transparent" id="kt_subheader">
            <div class="container d-flex align-items-center justify-content-between flex-wrap flex-sm-nowrap">
                <!--begin::Info-->
                <div class="d-flex align-items-center flex-wrap mr-1">
                    <!--begin::Page Heading-->
                    <div class="d-flex align-items-baseline flex-wrap mr-5">
                        <!--begin::Page Title-->
                        <h5 class="text-dark font-weight-bold my-1 mr-5">Manage Permissions</h5>
                        <!--end::Page Title-->
                        <!--begin::Breadcrumb-->
                        <ul class="breadcrumb breadcrumb-transparent breadcrumb-dot font-weight-bold p-0 my-2 font-size-sm">
                            <li class="breadcrumb-item text-muted">
                                <a href="{{ url('adminmedia/') }}" class="text-muted">Home</a>
                            </li>
                            <li class="breadcrumb-item text-muted">
                                <a href="{{ route('permissions.index') }}" class="text-muted">Permissions</a>
                            </li>
                        </ul>
                        <!--end::Breadcrumb-->
                    </div>
                    <!--end::Page Heading-->
                </div>
                <!--end::Info-->
            </div>
        </div>
        <!--end::Subheader-->
        <!--begin::Entry-->
        <div class="d-flex flex-column-fluid">
            <!--begin::Container-->
            <div class="container">
                <!--begin::Notice-->
                @include('back.common_views.alert')
                <!--end::Notice-->
                <!--begin::Card-->
                <div class="card card-custom">
                    <div class="card-header">
                        <div class="card-title">
                            <span class="card-icon">
                                <i class="flaticon2-layers text-primary"></i>
                            </span>
                            <h3 class="card-label">Permissions Management</h3>
                        </div>
                        <div class="card-toolbar">
                            <!--begin::Button-->
                            @if(isAllowed('Sort Permissions'))
                            <a href="{{ route('permissions.sort') }}" class="btn btn-text-primary btn-hover-light-primary font-weight-bold mr-2">
                                <i class="la la-bars"></i>Sort Permission
                            </a>
                            @endif
                            @if(isAllowed('Add new Permission'))
                            <a href="{{ route('permissions.create') }}" class="btn btn-primary font-weight-bolder">
                                <i class="la la-plus"></i>New Permission</a>
                            @endif
                            <!--end::Button-->
                        </div>
                    </div>
                    <div class="card-body">
                        <form method="post" role="form" id="permission-search-form" class="mb-15">
                            <button type="button" class="btn btn-success" onclick="showFilters();" id="showFilterBtn">Show
                                Filters</button>
                            <button type="button" class="btn btn-success" onclick="hideFilters();" id="hideFilterBtn"
                                style="display: none;">Hide Filters</button><br><br>
                            <div class="row mb-6" id="filterForm" style="display: none;">
                                <div class="col-lg-3 mb-lg-0 mb-6">
                                    <label>Permission Title:</label>
                                    <input type="text" name="title" id="title" value="{{ old('title') }}" class="form-control datatable-input" placeholder="Title" data-col-index="0">
                                </div>
                                <div class="col-lg-3 mb-lg-0 mb-6">
                                    <label>Permission Group:</label>
                                    <select class="form-control datatable-input" name="permission_group_id" id="permission_group_id" data-col-index="1">
                                        {!! generatePermissionGroupsDropDown(old('permission_group_id', '')) !!}
                                        </select>
                                </div>
                            </div>
                        </form>
                        <!--begin: Datatable-->
                            <table class="table table-responsive table-bordered table-hover table-checkable dataTable dtr-inline" id="permissionDatatableAjax">
                                <thead>
                                    <tr>
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
            <!--end::Container-->
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
                    [0, "asc"]
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
                columns: [
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
            $('#permission').on('keyup', function(e) {
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
                $.post("{{ url('permissions/') }}/" + id, {
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
