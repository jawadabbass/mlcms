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
                            <a href="{{ base_url() . 'adminmedia/admin-users' }}">
                                Admin Users
                            </a>
                        </li>
                    </ol>
                </div>
                <div class="col-md-7 col-sm-12">
                    @include('back.common_views.quicklinks')
                </div>
            </div>
        </section>
        <div class="container">
            <!--begin::Notice-->
            @include('back.common_views.alert')
            <!--end::Notice-->
            <!--begin::Card-->
            <div class="card card-info">
                <div class="card-header">
                    <div class="card-title">
                        <span class="card-icon">
                            <i class="flaticon2-layers text-primary"></i>
                        </span>
                        <h3 class="card-label">Admin Users Management</h3>
                    </div>
                    <div class="card-toolbar text-end">
                        <!--begin::Button-->
                        @if (isAllowed('Add new Admin User'))
                            <a href="{{ route('admin.user.create') }}" class="btn btn-warning mr-2">
                                <i class="fa fa-plus"></i>New Admin User</a>
                        @endif
                        <!--end::Button-->
                    </div>
                </div>
                <div class="card-body">
                    <form method="post" user="form" id="users-search-form" class="mb-3">
                        <button type="button" class="btn btn-success" onclick="showFilters();" id="showFilterBtn">Show
                            Filters</button>
                        <button type="button" class="btn btn-success" onclick="hideFilters();" id="hideFilterBtn"
                            style="display: none;">Hide Filters</button><br><br>
                        <div class="row mb-2" id="filterForm" style="display: none;">
                            <div class="col-lg-3 mb-lg-0 mb-2">
                                <label for="name">Name</label>
                                <input type="text" name="name" id="name" value="{{ old('name') }}"
                                    class="form-control datatable-input" placeholder="Name" data-col-index="0" />
                            </div>
                            <div class="col-lg-3 mb-lg-0 mb-2">
                                <label for="email">Email</label>
                                <input type="text" name="email" id="email" value="{{ old('email') }}"
                                    class="form-control datatable-input" placeholder="Email" data-col-index="1" />
                            </div>
                        </div>
                    </form>
                    <!--begin: Datatable-->
                    <table class="table table-striped table-bordered" style="width: 100%" id="usersDatatableAjax">
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                    </table>
                    <!--end: Datatable-->
                </div>
            </div>
            <!--end::Card-->
        </div>
    </div>
@endsection
@section('beforeBodyClose')
    <script>
        $(function() {
            var oTable = $('#usersDatatableAjax').DataTable({
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
                    url: '{!! route('admin.user.fetch.ajax') !!}',
                    data: function(d) {
                        d.name = $('#name').val();
                        d.email = $('#email').val();
                    }
                },
                columns: [{
                        data: 'name',
                        name: 'name'
                    },
                    {
                        data: 'email',
                        name: 'email'
                    },
                    {
                        data: 'action',
                        name: 'action',
                        orderable: false,
                        searchable: false
                    }
                ]
            });
            $('#users-search-form').on('submit', function(e) {
                oTable.draw();
                e.preventDefault();
            });
            $('#name').on('keyup', function(e) {
                oTable.draw();
                e.preventDefault();
            });
            $('#email').on('keyup', function(e) {
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
        function deleteUser(id) {
            var msg = 'Are you sure?';
            if (confirm(msg)) {
                $.post("{{ url('adminmedia/admin-user/') }}/" + id, {
                        id: id,
                        _method: 'DELETE',
                        _token: '{{ csrf_token() }}'
                    })
                    .done(function(response) {
                        if (response == 'ok') {
                            var table = $('#usersDatatableAjax').DataTable();
                            table.row('usersDtRow' + id).remove().draw(false);
                        } else {
                            alert('Request Failed!');
                        }
                    });
            }
        }
    </script>
@endsection
