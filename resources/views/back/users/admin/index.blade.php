@extends('back.layouts.app', ['title' => $title])
@section('content')
    <div class="content-wrapper pl-3 pr-2">
        <section class="content-header">
            <div class="row">
                <div class="col-md-8 col-sm-6">
                    <ol class="breadcrumb">
                        <li><a href="{{ admin_url() }}"><i class="fas fa-tachometer-alt"></i> Home</a></li>
                        <li class="active">Manage Admin Users</li>
                    </ol>
                </div>
                <div class="col-md-4 col-sm-6">
                    @include('back.common_views.quicklinks')
                </div>
            </div>
        </section>
        <section class="content">
            @if (\Session::has('added_action'))
                <div class="message-container">
                    <div class="callout callout-success">
                        <h4>New admin user has been created successfully.</h4>
                    </div>
                </div>
            @endif
            @if (\Session::has('update_action'))
                <div class="message-container">
                    <div class="callout callout-success">
                        <h4>Record has been updated successfully.</h4>
                    </div>
                </div>
            @endif
            <div class="row">
                <div class="col-xs-12 col-md-12">
                    <div class="box">
                        <div class="row">
                            <div class="col-sm-8">
                                <div class="box-header">
                                    <h3 class="box-title">Admin Users</h3>
                                    <div class="clearfix"></div>
                                    <br>
                                    <a class="btn btn-primary" href="{{ route('admin.show', 0) }}">User Access Controle List</a>
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="text-end" style="padding-bottom:2px;">
                                    @if (Auth::user()->type == config('Constants.USER_TYPE_SUPER_ADMIN'))
                                        <a type="button" class="sitebtn" href="{{ route('admin.create') }}">Add
                                            New Admin User</a>
                                    @endif
                                </div>
                            </div>
                        </div>
                        <div class="box-body table-responsive">
                            <table id="example2" class="table table-bordered table-hover">
                                <thead>
                                    <tr>
                                        <th>Created Date</th>
                                        <th>Name</th>
                                        <th>Email</th>
                                        @if (Auth::user()->type == config('Constants.USER_TYPE_SUPER_ADMIN'))
                                            <th>Type</th>
                                            <th>Action</th>
                                        @endif
                                    </tr>
                                </thead>
                                <tbody>
                                    @if ($result)
                                        @foreach ($result as $row)
                                            <tr id="row_{{ $row->id }}">
                                                <td>{{ format_date($row->created_at, 'date') }}</td>
                                                <td>{{ $row->name }}</td>
                                                <td>{{ $row->email }}</td>
                                                @if (Auth::user()->type == config('Constants.USER_TYPE_SUPER_ADMIN'))
                                                    <td>
                                                        @if ($row->type == config('Constants.USER_TYPE_SUPER_ADMIN'))
                                                            Super Admin
                                                        @endif

                                                        @if ($row->type == config('Constants.USER_TYPE_NORMAL_ADMIN'))
                                                            Normal Admin
                                                        @endif

                                                        @if ($row->type == config('Constants.USER_TYPE_REPS_ADMIN'))
                                                            Reps
                                                        @endif
                                                    </td>
                                                    <td>
                                                        <a href="{{ route('admin.edit', $row->id) }}"
                                                            class="btn btn-success btn-sm">Edit</a>
                                                        <a href="javascript:;"
                                                            onClick="delete_admin_user({{ $row->id }})"
                                                            class="btn btn-info btn-sm btn-danger">Delete User</a>
                                                    </td>
                                                @endif
                                            </tr>
                                        @endforeach
                                    @else
                                        <tr>
                                            <td colspan="8">No record found!</td>
                                        </tr>
                                    @endif
                                </tbody>
                                <tfoot>
                                </tfoot>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection
@section('beforeBodyClose')
    <script>
        function delete_admin_user(id) {
            $('.message-container').fadeOut(3000);
            if (confirm('Are you sure delete this data?')) {
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
                $.ajax({
                    url: "{{ admin_url() . 'user/admin/' }}" + id,
                    type: "DELETE",
                    success: function(data) {
                        //if success reload ajax table
                        $('#modal_form').modal('hide');
                        $('#delete_action').show();
                        location.reload();
                    },
                    error: function(jqXHR, textStatus, errorThrown) {
                        alert('Error adding / update data');
                    }
                });
            }
        }
    </script>
@endsection
