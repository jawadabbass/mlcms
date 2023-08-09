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
                            <a href="{{ base_url() . 'adminmedia/roles' }}">
                                Roles
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
        <section class="container">
            <!--begin::Notice-->
            @include('back.common_views.alert')
            <!--end::Notice-->
            <!--begin::Card-->
            <div class="card  card-info card-custom">
                <div class="card-header">
                    <div class="card-title">
                        <span class="card-icon">
                            <i class="text-primary"></i>
                        </span>
                        <h3 class="card-label">Roles Management</h3>
                    </div>
                    <div class="card-toolbar text-right">
                        <!--begin::Button-->
                        @if(isAllowed('Sort Roles'))
                        <a href="{{ route('roles.sort') }}" class="btn btn-warning mr-2">
                            <i class="fas fa-bars"></i> Sort Role
                        </a>
                        @endif
                        @if(isAllowed('Add new Role'))
                        <a href="{{ route('roles.create') }}" class="btn btn-danger">
                            <i class="fas fa-plus"></i> New Role</a>
                        @endif
                        <!--end::Button-->
                    </div>
                </div>
                <div class="card-body">
                    <form method="post" role="form" id="roles-search-form" class="mb-3">
                        <button type="button" class="btn btn-success" onclick="showFilters();" id="showFilterBtn">Show
                            Filters</button>
                        <button type="button" class="btn btn-success" onclick="hideFilters();" id="hideFilterBtn"
                            style="display: none;">Hide Filters</button><br><br>
                        <div class="row mb-2" id="filterForm" style="display: none;">
                            <div class="col-lg-3 mb-lg-0 mb-2">
                                <label>Role Title:</label>
                                <input type="text" name="title" id="title" value="{{ old('title') }}" class="form-control datatable-input" placeholder="Title" data-col-index="0">
                            </div>
                        </div>
                    </form>
                    <!--begin: Datatable-->
                    <table class="table table-striped table-bordered" style="width: 100%" id="rolesDatatableAjax">
                            <thead>
                                <tr>
                                    <th>Role Title</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                        </table>
                    <!--end: Datatable-->
                </div>
            </div>
            <!--end::Card-->
        </section>
        <!--end::Entry-->
    </div>
@endsection
@section('beforeBodyClose')
    <script>
        $(function() {
            var oTable = $('#rolesDatatableAjax').DataTable({
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
                    url: '{!! route('fetchRolesAjax') !!}',
                    data: function(d) {
                        d.title = $('#title').val();
                    }
                },
                columns: [{
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
            $('#roles-search-form').on('submit', function(e) {
                oTable.draw();
                e.preventDefault();
            });
            $('#roles').on('keyup', function(e) {
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


        function deleteRole(id) {
            var msg = 'Are you sure?';
            if (confirm(msg)) {
                $.post("{{ url('adminmedia/roles/') }}/" + id, {
                        id: id,
                        _method: 'DELETE',
                        _token: '{{ csrf_token() }}'
                    })
                    .done(function(response) {
                        if (response == 'ok') {
                            var table = $('#rolesDatatableAjax').DataTable();
                            table.row('rolesDtRow' + id).remove().draw(false);
                        } else {
                            alert('Request Failed!');
                        }
                    });
            }
        }
    </script>
@endsection
