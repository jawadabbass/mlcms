@extends('back.layouts.app', ['title' => $title])

@section('content')
    <aside class="right-side {{ session('leftSideBar') == 1 ? 'strech' : '' }}">
        <!-- Inner Header -->
        <section class="content-header">
            <div class="row">
                <div class="col-md-8 col-sm-6">
                    <ol class="breadcrumb">
                        <li><a href="{{ env('APP_URL') . 'adminmedia' }}"><i class="fa-solid fa-gauge"></i> Home</a></li>
                        <li class="active">Albums</li>
                    </ol>
                </div>
                <div class="col-md-4 col-sm-6"> @include('back.common_views.quicklinks') </div>
            </div>
        </section>

        <!-- Main Content starts --->

        <section class="content">

            <div class="row">
                <div class="col-xs-12 col-md-12">
                    <div class="row">
                        <div class="col-sm-8">
                            <h3 class="box-title">Manage Album</h3>
                        </div>
                        <div class="col-sm-4">
                            <div class="text-end" style="padding-bottom:2px;">
                                <a class="btn btn-info" data-bs-target="#modal-1" data-bs-toggle="modal" href="javascript:;"><i
                                        aria-hidden="true" class="fa-solid fa-plus-circle"></i>
                                    Add Album
                                </a>
                            </div>
                        </div>
                    </div>

                    @if (session('success'))
                        <div class="alert alert-success">
                            <i class="fa-solid fa-check" aria-hidden="true"></i> {{ session('success') }}
                        </div>
                    @endif


                    @if ($errors->any())
                        <div class="row">
                            <div class="col-md-12">
                                <div class="alert alert-danger" role="alert">
                                    <ul>
                                        @foreach ($errors->all() as $errmsg)
                                            <li>* {{ $errmsg }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </section>

        <div class="box-body table-responsive">
            <table id="table" class="table table-bordered table-hover">
                <thead>
                    <tr>
                        <th>#:</th>
                        <th>Title</th>
                        <th>Image</th>
                        <th class="text-center">Status</th>
                        <th class="text-center">Featured</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody id="sortable">
                    @forelse($allAlbums as $album)
                        <tr id="{{ $album->id }}">
                            <td>{{ $loop->index + 1 }}</td>
                            <td>{{ $album->title }}</td>
                            <td width="100">
                                <img src="{{ base_url() }}uploads/gallery/{{ $album->f_img }}">
                            </td>
                            <td class="text-center"><a href="javascript:;" onclick="activate({{ $album->id }}, this)">
                                    {!! $album->status == 1 ? "<i class='label label-success'>Active</i>" : "<i class='label label-danger'>Blocked</i>" !!}</a>
                            </td>
                            <td class="text-center">
                                <a href="javascript:;" class="text-white" onclick="isFeatured({{ $album->id }}, this)">
                                    {!! $album->isFeatured == 1 ? '<i class="fa-solid fa-star bg-success bg-success p-2 text-white" aria-hidden="true"></i>' : "<i class='fa-solid fa-star p-2 bg-secondary' aria-hidden='true'></i>" !!}
                                </a>
                            </td>
                            <td>
                                <a href="javascript:;" class="btn btn-warning"
                                    onClick="edit_album({{ $album->id }},'{{ $album->title }}');" data-bs-toggle="tooltip"
                                    title="Edit Album"><i class="fa-solid fa-edit" aria-hidden="true"></i></a>
                                <a href="{{ route('album.gallery.create', $album->id) }}" class="btn btn-success"
                                    data-bs-toggle="tooltip" title="Add Image(s) in this Album">
                                    <i aria-hidden="true" class="fa-solid fa-plus-circle">
                                    </i>
                                </a>
                                <a href="javascript:;" class="btn btn-danger"
                                    onclick="deleteAlbum({{ $album->id }}, this)" data-bs-toggle="tooltip"
                                    title="Delete this Album and Image(s)"><i class="fa-solid fa-trash"
                                        aria-hidden="true"></i></a>
                                <span></span>
                            </td>
                        </tr>
                    @empty
                    @endforelse
                </tbody>
                <tfoot></tfoot>
            </table>
        </div>
        
        {{-- Modal 1 For Add Album --}}
        <div class="modal fade" id="modal-1">
            <div class="modal-dialog" role="document">
                <form action="" id="add_album_frm" name="add_album_frm" enctype="multipart/form-data">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title">
                                Add Album
                            </h4>
                            <button aria-label="Close" class="btn-close" data-bs-dismiss="modal" type="button">
                                <span aria-hidden="true">×</span>
                                <span class="sr-only">Close</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <div class="row">
                                <div class="col-md-4 text-end">Title:</div>
                                <div class="col-md-8"><input class="form-control" id="title" name="title"
                                        placeholder="" type="text" value=""></div>
                            </div>
                            <div class="row">
                                <div class="col-md-6"></div>
                                <div class="col-md-6"></div>
                            </div>

                            <div class="row">
                                <div class="col-md-4 text-end">Featured Image:</div>
                                <div class="col-md-8"><input class="form-control" type="file" name="f_mg"
                                        id="f_mg"></div>
                            </div>

                        </div>
                        <div class="modal-footer">
                            <button class="btn btn-secondary" data-bs-dismiss="modal" type="button">
                                Close
                            </button>
                            <button class="btn btn-primary" onclick="add_album();" type="button">
                                Save changes
                            </button>
                        </div>
                    </div>
                    <input type="hidden" name="_token" value="<?php echo csrf_token(); ?>">
                    <input type="hidden" name="album_id" value="">
                </form>
                <!-- /.modal-content -->
            </div>
            <!-- /.modal-dialog -->
        </div>



        <!-- Edit modal-dialog -->
        <div class="modal fade" id="modal-2">
            <div class="modal-dialog" role="document">
                <form action="POST" id="frm2" name="frm2" enctype="multipart/form-data">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title">
                                Edit Category
                            </h4>
                            <button aria-label="Close" class="btn-close" data-bs-dismiss="modal" type="button">
                                <span aria-hidden="true">
                                    ×
                                </span>
                                <span class="sr-only">
                                    Close
                                </span>
                            </button>
                        </div>
                        <div class="modal-body">


                            <div class="row">
                                <div class="col-md-4 text-end">Title:</div>
                                <div class="col-md-8"><input class="form-control" id="title_edit" name="title"
                                        placeholder="" type="text" value=""></div>
                            </div>
                            <div class="row">
                                <div class="col-md-6"></div>
                                <div class="col-md-6"></div>
                            </div>

                            <div class="row">
                                <div class="col-md-4 text-end">Featured Image:</div>
                                <div class="col-md-8"><input class="form-control" type="file" name="f_mg"
                                        id="f_mg"></div>
                            </div>

                        </div>
                        <div class="modal-footer">
                            <button class="btn btn-secondary" data-bs-dismiss="modal" type="button">
                                Close
                            </button>
                            <button class="btn btn-primary" onclick="update_album();" type="button">
                                Save changes
                            </button>
                        </div>
                    </div>
                    <input type="hidden" name="_token" value="<?php echo csrf_token(); ?>">
                    <input type="hidden" name="idd" id="idd" value="">
                </form>
                <!-- /.modal-content -->
            </div>
            <!-- /.modal-dialog -->
        </div>
        <!-- End Edit modal-dialog -->
    @endsection('content')

    @section('beforeBodyClose')
    @include('back.gallery.gallery_js');
        <script src="{{ asset('lib/sweetalert/sweetalert2.js') }}"></script>
        
        <script>
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            function activate(id, elem) {
                debugger;
                let formData = new FormData();
                formData.append('id', id);
                $.ajax({
                    url: "{{ route('album.activate') }}",
                    type: 'post',
                    data: formData,
                    async: true,
                    cache: false,
                    contentType: false,
                    processData: false,
                    success: function(data) {
                        if (data.message == 'active') {
                            elem.innerHTML = "<i class='label label-success'>Active</i>";

                        } else {
                            elem.innerHTML = "<i class='label label-Danger'>Blocked</i>";
                            elem.parentElement.nextElementSibling.children[0].innerHTML =
                                "<i class='fa-solid fa-star bg-secondary p-2 text-white' aria-hidden='true'></i>";
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


            function isFeatured(id, elem) {
                let formData = new FormData();
                formData.append('id', id);
                $.ajax({
                    url: "{{ route('album.feature') }}",
                    type: 'post',
                    data: formData,
                    async: true,
                    cache: false,
                    contentType: false,
                    processData: false,
                    success: function(data) {
                        if (!data.status) {
                            return swal('Sorry!', data.message, 'error');
                        }
                        if (data.message != 'disabled') {
                            elem.innerHTML =
                                '<i class="fa-solid fa-star bg-success bg-success p-2 text-white" aria-hidden="true"></i>';
                        } else {
                            elem.innerHTML =
                                "<i class='fa-solid fa-star p-2 bg-secondary p-2 text-white' aria-hidden='true'></i>";
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

            {{-- var module = '{{ $module->type }}'; --}}
            $(function() {
                $('#sortable').sortable({
                    axis: 'y',
                    opacity: 0.7,
                    handle: 'span',
                    update: function(event, ui) {
                        var list_sortable = $(this).sortable('toArray').toString();
                        // change order in the database using Ajax
                        console.log(list_sortable);
                        $.ajax({
                            url: base_url + 'adminmedia/albums/order',
                            type: 'get',
                            data: {
                                list_order: list_sortable
                            },
                            success: function(data) {
                                console.log(data);
                            },
                            error: function(jqXHR, textStatus, errorThrown) {
                                alert('Error adding / update data');
                                console.log(jqXHR);
                                console.log(textStatus);
                                console.log(errorThrown);
                            }
                        });
                    }
                }); // fin sortable
            });

            //Delete Complete Album
            function deleteAlbum(id, elem) {
                debugger;

                if (confirm("Are you sure you want to delete this album and image(s) under this section?") == false) {
                    return false;
                }

                var myurl = baseUrl + 'adminmedia/gallery/delete_album/' + id;

                $.ajax({
                    type: "GET",
                    url: myurl,
                    data: {},
                    success: function(data) {
                        data = JSON.parse(data);
                        if (data.status) {
                            elem.parentElement.parentElement.remove();
                        } else {
                            alert('OOps! Something went wrong.');
                            console.log(data.status);
                        }
                    },
                });
            }
        </script>
    @endsection
