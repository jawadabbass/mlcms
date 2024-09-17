@extends('back.layouts.app', ['title' => $title])
@section('content')
    <div class="content-wrapper pl-3 pr-2">
        <section class="content-header">
            <div class="row">
                <div class="col-md-5 col-sm-12">
                    <ol class="breadcrumb">
                        <li><a href="{{ admin_url() }}"><i class="fas fa-gauge"></i> Home</a></li>
                        <li class="active">Website User Management</li>
                    </ol>
                </div>
                <div class="col-md-7 col-sm-12"> @include('back.common_views.quicklinks') </div>
            </div>
        </section>
        <div class="content">
            <div class="card p-2">
                <div class=" card-body table-responsive">
                    <table id="example2" class="table table-bordered table-hover">
                        <thead>
                            <tr>
                                <th>Created Date</th>
                                <th>Name</th>
                                <th>Email</th>
                                {{-- <th>Status</th> --}}
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>

                            @if ($result)
                                @foreach ($result as $row)
                                    <tr id="row_{{ $row->id }}">
                                        <td>{{ format_date($row->created_at, 'date') }}</td>
                                        <td>{{ $row->name }}</td>
                                        <td>{{ $row->email }}</td>
                                        {{-- <td> --}}

                                        {{-- @if ($row->active) --}}

                                        {{-- <a href="{{ ("load_users/block/?user_id=" . $row->id) }}" --}}
                                        {{-- class="btn btn-success btn-sm">Active</a> --}}

                                        {{-- @else --}}

                                        {{-- <a href="<{{ ("load_users/activate/?user_id=" . $row->id) }}" --}}
                                        {{-- class="btn btn-danger btn-sm">Blocked</a> --}}

                                        {{-- @endif --}}

                                        {{-- </td> --}}
                                        <td><a href="{{ route('front.edit', $row->id) }}" class="btn btn-info btn-sm">Edit

                                                User</a> <a href="javascript:;"
                                                onClick="delete_front_user({{ $row->id }})"
                                                class="btn btn-info btn-sm btn-danger">Delete User</a></td>
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
        <div> {{ $result->links() }} </div>
    </div>
@endsection
@section('beforeBodyClose')
    <script>
        function delete_front_user(id) {
            $('.message-container').fadeOut(3000);
            if (confirm('Are you sure delete this data?')) {
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
                $.ajax({
                    url: "{{ admin_url() . 'user/front/' }}" + id,
                    type: "DELETE",
                    success: function(data) {
                        //if success reload ajax table
                        $('#modal_form').modal('hide');
                        location.reload();
                    },
                    error: function(jqXHR, textStatus, errorThrown) {
                        alert('Error adding / update data ' + ' ' + textStatus + ' ' + errorThrown);
                    }
                });
            }
        }
    </script>
@endsection
