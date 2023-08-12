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
                            <a href="{{ base_url() . 'adminmedia/permissionGroup' }}">
                                Permission Groups
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
            <div class="card card-info card-custom">
                <div class="card-header">
                    <div class="card-title">
                        <h3 class="card-label">Permission Groups Management</h3>
                    </div>
                    <div class="card-toolbar text-right">
                        <!--begin::Button-->
                        @if (isAllowed('Sort Permission Groups'))
                            <a href="{{ route('permissionGroup.sort') }}"
                                class="btn btn-warning mr-2">
                                <i class="fas fa-bars"></i> Sort Permission Group
                            </a>
                        @endif
                        @if (isAllowed('Add new Permission Group'))
                            <a href="{{ route('permissionGroup.create') }}" class="btn btn-danger">
                                <i class="fas fa-plus"></i> New Permission Group</a>
                        @endif
                        <!--end::Button-->
                    </div>
                </div>
                <div class="card-body">
                    <form method="post" role="form" id="permissionGroup-search-form" class="mb-3">
                        <button type="button" class="btn btn-success" onclick="showFilters();" id="showFilterBtn">Show
                            Filters</button>
                        <button type="button" class="btn btn-success" onclick="hideFilters();" id="hideFilterBtn"
                            style="display: none;">Hide Filters</button><br><br>
                        <div class="row mb-2" id="filterForm" style="display: none;">
                            <div class="col-lg-3 mb-lg-0 mb-2">
                                <label>Permission Group Title:</label>
                                <input type="text" name="title" id="title" value="{{ old('title') }}"
                                    class="form-control datatable-input" placeholder="Title" data-col-index="0">
                            </div>
                        </div>
                    </form>
                    <!--begin: Datatable-->
                    <table class="table table-striped table-bordered" style="width: 100%"
                        id="permissionGroupDatatableAjax">
                        <thead>
                            <tr>
                                <th></th>
                                <th>Permission Group Title</th>
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
            var oTable = $('#permissionGroupDatatableAjax').DataTable({
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
                    url: '{!! route('fetchPermissionGroupsAjax') !!}',
                    data: function(d) {
                        d.title = $('#title').val();
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
                        data: 'action',
                        name: 'action',
                        orderable: false,
                        searchable: false
                    }
                ]
            });
            $('#permissionGroup-search-form').on('submit', function(e) {
                oTable.draw();
                e.preventDefault();
            });
            $('#permissionGroup').on('keyup', function(e) {
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

        function deletePermissionGroup(id) {
            var msg = 'Are you sure?';
            if (confirm(msg)) {
                $.post("{{ url('adminmedia/permissionGroup/') }}/" + id, {
                        id: id,
                        _method: 'DELETE',
                        _token: '{{ csrf_token() }}'
                    })
                    .done(function(response) {
                        if (response == 'ok') {
                            var table = $('#permissionGroupDatatableAjax').DataTable();
                            table.row('permissionGroupDtRow' + id).remove().draw(false);
                        } else {
                            alert('Request Failed!');
                        }
                    });
            }
        }
    </script>
@endsection
