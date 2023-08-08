@extends('back.layouts.app', ['title' => $title])

@section('page_css')
    <style>
        .topBtns {
            margin-bottom: 10px;
        }
    </style>
@endsection

@section('content')
    <div class="content-wrapper pl-3 pr-2">
        <section class="content-header">
            <div class="row">
                <div class="col-md-5 col-sm-12 jawadcls">
                    <ol class="breadcrumb">
                        <li><a href="{{ admin_url() }}"> <i class="fas fa-tachometer-alt"></i> Home </a></li>
                        <li class="active">Manage Message Templates</li>
                    </ol>
                </div>
                <div class="col-md-7 col-sm-12 jawadcls"> @include('back.common_views.quicklinks') </div>
            </div>
        </section>
        <section class="content">
            @if (\Session::has('success'))
                <div class="alert alert-success alert-dismissible mb-2" role="alert">
                    <button type="button" class="btn close" data-bs-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                    <strong>Success!</strong> {{ session('success') }}

                </div>
            @endif
            @if ($errors->all())
                <div class="alert alert-danger alert-dismissible mb-2" role="alert">
                    <button type="button" class="btn close" data-bs-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                    <strong>Danger!</strong>
                    @foreach ($errors->all() as $error)
                        {{ $error }}
                    @endforeach
                </div>
            @endif

            <div class="text-end topBtns">

                <button data-bs-toggle="modal" data-bs-target="#AddserviceModal" class="btn btn-success"><i
                        class="fas fa-plus"></i> Add New Template</button>



            </div>
            <div class="box-body table-responsive">
                <table id="table_id" class="table table-bordered table-hover">
                    <thead class="thead-dark">
                        <tr>
                            <th>ID</th>
                            <th width="25%">Title</th>
                            <th width="50%">Message Body</th>
                            <th style="display: none;">Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if (!$result->isEmpty())
                            @foreach ($result as $row)
                                <tr id="row_{{ $row->id }}">
                                    <td>{{ $row->id }}</td>
                                    <td>{{ $row->title }}</td>
                                    <td>{!! $row->body !!}</td>
                                    <td style="display: none;"></td>

                                    <td>
                                        <a class="btn-sm btn-success my-a" href="{{ route('message.edit', $row->id) }}"
                                            id="update_btn" data-id="{{ $row->id }}"><i class="fas fa-edit"
                                                aria-hidden="true"></i> Edit</a>

                                        <!--<a class="btn-sm btn-danger my-a"  href="javascript:;" onClick="delete_record({{ $row->id }})"><i class="fas fa-trash"></i> Delete</a> -->
                                    </td>

                                </tr>
                            @endforeach
                        @else
                            <tr class="text-center">
                                <td colspan="8">No record found!</td>
                            </tr>
                        @endif
                    </tbody>
                </table>
            </div>
        </section>
    </div>


    <!--------- ADD Start Modal Here------->
    <div class="modal fade" id="AddserviceModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header custom_modal_header">
                    <h5 class="modal-title" id="exampleModalLabel">Add New Message Template</h5>
                    <button type="button" class="btn close" data-bs-dismiss="modal" aria-label="Close">
                        
                    </button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('custom_msg_store') }}" method="post" enctype="multipart/form-data">
                        @csrf
                        <div class="form-group">
                            <label for="">Title</label>
                            <input type="text" required="" class="form-control" name="title">
                        </div>
                        <div class="form-group">
                            <label for="message-text" class="col-form-label"><strong>Message Body:</strong></label>
                            <textarea class="form-control" id="add_ckeditor" id="body" name="body"></textarea>
                        </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn-sm btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn-sm btn-primary">Submit</button>
                </div>
                </form>
            </div>
        </div>
    </div>
    <!--------- End Modal Here------->


@endsection

@section('page_scripts')
    <script src="//cdn.ckeditor.com/4.13.0/standard/ckeditor.js"></script>


    <script>
        $(document).ready(function() {

            var textarea = document.getElementById('add_ckeditor');
            bindCKeditor(textarea);
            // var u_textarea = document.getElementById('update_ckeditor');
            // bindCKeditor(u_textarea);

            $(document).on('click', '#update_btn', function() {
                var id = $(this).attr('data-id');

                get_url = 'services';
                $.ajax({
                    url: "{{ admin_url() . 'message/' }}" + id,
                    type: 'GET',
                    success: function(data) {
                        console.log(data)
                        $('#u_id').val(data.id);
                        $('#body').html(data.body);

                        // ckeditors.body.setData(data.body);
                        $('#u_title').val(data.title);
                        $('#UpdateserviceModal').modal({
                            show: true
                        });
                    }

                })
            })
        });

        function delete_record(id) {

            $('.message-container').fadeOut(3000);
            if (confirm('Are you sure delete this data?')) {
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
                $.ajax({
                    url: "{{ admin_url() . 'message/' }}" + id,
                    type: "DELETE",
                    success: function(data) {
                        if (data.status == "success") {
                            location.reload();
                        } else {
                            alert('Error adding / update data');
                        }
                    },
                    error: function(jqXHR, textStatus, errorThrown) {
                        alert('Error adding / update data');
                        console.log(jqXHR);
                        console.log(textStatus);
                        console.log(errorThrown);
                    }
                });
            }
        }
    </script>
@endsection
