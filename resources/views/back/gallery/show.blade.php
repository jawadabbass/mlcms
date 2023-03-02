@extends('back.layouts.app', ['title' => $title])
@section('beforeHeadClose')
    <link href="https://gitcdn.github.io/bootstrap-toggle/2.2.2/css/bootstrap-toggle.min.css" rel="stylesheet">
    <link href="{{ asset('back/css/cropper.css') }}" rel="stylesheet">
    <style>
        .sortable121 span i {
            background-color: #b4b3b3;
            text-align: center;
            line-height: 24px;
            width: 30px;
            height: 26px;
            display: inline-block;
            cursor: all-scroll;
            border-radius: 4px;
            padding-top: 0px;
        }
    </style>
@endsection
@section('content')
    <aside class="right-side {{ session('leftSideBar') == 1 ? 'strech' : '' }}">
        <!-- Inner Header -->
        <section class="content-header">
            <div class="row">
                <div class="col-md-8 col-sm-6">
                    <ol class="breadcrumb">
                        <li><a href="{{ base_url() . 'adminmedia' }}">
                                <i class="fa-solid fa-gauge"></i> Home</a></li>
                        <li><a href="{{ base_url() . 'adminmedia/gallery' }}">
                                <i class="fa-solid fa-gauge"></i> Albums</a></li>
                        <li class="active">{{ $album_name }}</li>
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
                        <div class="col-sm-12">
                            <h3 class="box-title">{{ $album_name }} Gallery</h3>
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
                    <!-- Image Uploader  -->
                    <div class="upload_adm_area" id="upload_adm_area">
                        <h5>Upload Image(s) </h5>
                        <hr>
                        <form action="{{ route('upload_album_images') }}" enctype="multipart/form-data" method="post">
                            {{ csrf_field() }}
                            <input type="hidden" name="album" value="{{ request()->route('id') }}">
                            <div class="row">
                                <div class="col-md-12 mb-3">
                                    <input class="form-control" id="uploadFile" multiple="" name="uploadFile[]"
                                        type="file" onchange="uploaded_files_show();" />
                                    <div class="text-danger"><em>Max :</em> {{ getMaxUploadSize() }} MB</div>
                                </div>
                                <div class="col-md-12 mb-3">
                                    <input type="checkbox" name="isBeforeAfter" value="1"
                                        style="width: 15px; height:15px;" /> <b>Is Before After?</b>
                                </div>
                                <div class="col-md-12 mb-3">
                                    <input onclick="document.getElementById('spinner').style.display='block'"
                                        class="btn btn-success" name="submitImage" type="submit" value="Upload Image(s)" />
                                </div>
                            </div>
                            <div id="image_preview" class="row">
                            </div>
                        </form>
                        </hr>
                    </div>
                    <!-- End Image Uploader  -->
                </div>
            </div>
        </section>
        <div class="myasection">
            <div class="row sortable121">
                @forelse($images as $image)
                    <div class="col-md-4" id="{{ $image->id }}">
                        <div class="mb-3 sort2">
                            <div class="imagebox">
                                <a href="javascript:void(0);" title="{{ $image->image_title }}"
                                    onclick="openGalleryImageZoomModal('{{ base_url() }}uploads/gallery/{{ $image->album_id }}/{{ $image->imageUrl . '?' . time() }}');">
                                    <img id="image_{{ $image->id }}" data-imgname="{{ $image->imageUrl }}"
                                        src="{{ base_url() }}uploads/gallery/{{ $image->album_id }}/thumb/{{ $image->imageUrl . '?' . time() }}"
                                        style="width:100%" alt="{{ $image->image_alt }}"
                                        title="{{ $image->image_title }}">
                                </a>
                            </div>
                            <div class="caption myadelbtn">
                            </div>
                            <div class="image_btn mt-2">
                                <span class="drag" title="Drag and Drop to sort"><i class="fa-solid fa-arrows" aria-hidden="true"></i></span>
                                <a  title="Active/Inactive" onClick="update_status({{ $image->id }}, this)" href="javascript:void(0)"
                                    class="mb-1 btn btn-{{ $image->status == 1 ? 'success' : 'secondary' }}"
                                    id="{{ 'status_' . $image->id }}"><i class="fa-solid fa-eye"
                                        aria-hidden="true"></i></a>
                                <a  title="Featured/Not Featured" onClick="update_featured({{ $image->id }}, this)" href="javascript:void(0)"
                                    class="mb-1 btn btn-{{ $image->isFeatured == 1 ? 'success' : 'secondary' }}"
                                    id="{{ 'featured_' . $image->id }}"><i class="fa-solid fa-star"
                                        aria-hidden="true"></i></a>
                                <a  title="Delete Image" onclick="deleteImage({{ $image->id }}, this);" class="mb-1 btn btn-danger"
                                    data-bs-toggle="tooltip" data-placement="left" title="Delete this image"
                                    href="javascript:;"> <i class="fa-solid fa-trash"></i></a>
                                @if ((bool) $image->isBeforeAfter == false)
                                    <a onClick="markBeforeAfter({{ $image->id }}, this)" href="javascript:void(0)"
                                        class="mb-1 btn btn-warning">Mark Before After</a>
                                @endif
                                <a  title="Crop Image" onClick="bind_cropper_preview_gallery_image({{ $image->album_id }}, {{ $image->id }});"
                                    href="javascript:void(0)" class="mb-1 btn btn-warning"><i class="fa-solid fa-crop"
                                        aria-hidden="true"></i></a>
                                <a  title="Image Alt/Title" onClick="openImageAltTitleModal({{ $image->album_id }}, {{ $image->id }});"
                                    href="javascript:void(0)" class="mb-1 btn btn-success"><i class="fa-solid fa-bars"
                                        aria-hidden="true"></i></a>
                            </div>
                        </div>
                    </div>
                @empty
                    <div>There is no image found in the album.</div>
                @endforelse
            </div>
        </div>
        <div class="modal fade" id="gallery_image_cropper_form" role="dialog">
            <div class="modal-dialog modal-lg">
                <form action="#" id="gallery_image_crop_form" class="form-horizontal" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 id="cropper_form_title" class="modal-title">Image Cropper Form</h4>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                aria-label="Close"></button>
                        </div>
                        <div class="modal-body form">
                            <div class="box-body">
                                <div class="row">
                                    <div class="col-md-12" id="large_image"><img id="image" src=""
                                            alt="Crop Picture"></div>
                                    {{-- <div class="col-md-4">
                                        <div class="preview"></div>
                                    </div> --}}
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <input type="hidden" name="source_image" id="source_image" value="" />
                            <input type="hidden" name="crop_x" id="crop_x" value="" />
                            <input type="hidden" name="crop_y" id="crop_y" value="" />
                            <input type="hidden" name="crop_height" id="crop_height" value="" />
                            <input type="hidden" name="crop_width" id="crop_width" value="" />
                            <input type="hidden" name="crop_rotate" id="crop_rotate" value="" />
                            <input type="hidden" name="album_id" id="album_id" value="">
                            <input type="hidden" name="image_id" id="image_id" value="">
                            <button type="button" id="btnCrop" onclick="save_gallery_cropped_img();"
                                class="btn btn-primary">Crop
                                Image
                            </button>
                            <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Cancel</button>
                        </div>
                    </div>
                    <!-- /.modal-content -->
                </form>
            </div>
        </div>
        <div class="modal fade" id="galleryImageAltTitleModal" role="dialog">
            <div class="modal-dialog modal-lg">
                <form action="#" id="galleryImageAltTitleForm" class="form-horizontal">
                    @csrf
                    <input type="hidden" name="album_id" id="album_id" value="">
                    <input type="hidden" name="image_id" id="image_id" value="">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title">Image Alt-Title Form</h4>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                aria-label="Close"></button>
                        </div>
                        <div class="modal-body form">
                            <div class="box-body">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="mb-3">
                                            <label for="image_alt" class="form-label">Image Alt</label>
                                            <input type="text" name="image_alt" id="image_alt" class="form-control"
                                                placeholder="Image Alt">
                                        </div>
                                        <div class="mb-3">
                                            <label for="image_title" class="form-label">Image Title</label>
                                            <input type="text" name="image_title" id="image_title"
                                                class="form-control" placeholder="Image Title">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" id="btnCrop" onclick="saveGalleryImageAltTitle();"
                                class="btn btn-primary">Save
                            </button>
                            <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Cancel</button>
                        </div>
                    </div>
                    <!-- /.modal-content -->
                </form>
            </div>
        </div>
        <div class="modal fade" id="galleryImageZoomModal" role="dialog">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <img src="" id="galleryImageZoomImage" />
                </div>
            </div>
        </div>
    @endsection('content')
    @section('beforeBodyClose')
        <script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.10.3/jquery-ui.min.js"></script>
        <script src="https://gitcdn.github.io/bootstrap-toggle/2.2.2/js/bootstrap-toggle.min.js"></script>
        <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
        <script src="{{ asset('back/js/cropper.js') }}"></script>
        @include('back.gallery.gallery_js');
        <script>
            $(function() {
                $('.sortable121').sortable({
                    opacity: 1,
                    handle: 'span',
                    update: function(event, ui) {
                        console.log(event);
                        var list_sortable = $(this).sortable('toArray').toString();
                        $.ajax({
                            url: "{{ url('/adminmedia/albums/gallery/order') }}",
                            type: 'GET',
                            data: {
                                list_order: list_sortable
                            },
                            success: function(data) {},
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
        </script>
        <script>
            function deleteImage(id, elem) {
                swal({
                    title: "Are you sure?",
                    text: "Once deleted, you will not be able to recover this imaginary file!",
                    icon: "warning",
                    buttons: true,
                    dangerMode: true,
                }).then((willDelete) => {
                    if (willDelete) {
                        $.ajax({
                            url: "{{ url('/adminmedia/albums/gallery/delete/') }}/" + id,
                            method: 'get',
                            data: id,
                            success: function(response) {
                                if (response.status) {
                                    elem.parentElement.parentElement.parentElement.remove();
                                    swal("Poof! Your image has been deleted!", {
                                        icon: "success",
                                    });
                                }
                            }
                        });
                    } else {
                        swal("Your imaginary file is safe!");
                    }
                });
            }

            function update_status(id, elem) {
                $.ajax({
                    url: "{{ url('/adminmedia/albums/gallery/status') }}",
                    method: 'post',
                    data: {
                        "_token": "{{ csrf_token() }}",
                        "id": id,
                    },
                    success: function(response) {
                        if (response.message == 'active') {
                            elem.classList.remove('btn-secondary');
                            elem.classList.add('btn-success');
                        } else {
                            elem.classList.remove('btn-success');
                            elem.classList.add('btn-secondary');
                        }
                        console.log(response);
                    }
                });
            }

            function update_featured(id, elem) {
                $.ajax({
                    url: "{{ url('/adminmedia/albums/gallery/is_feature') }}",
                    method: 'post',
                    data: {
                        "_token": "{{ csrf_token() }}",
                        "id": id,
                    },
                    success: function(response) {
                        if (response.message == 'enabled') {
                            elem.classList.remove('btn-secondary');
                            elem.classList.add('btn-success');
                        } else {
                            elem.classList.remove('btn-success');
                            elem.classList.add('btn-secondary');
                        }
                        console.log(response);
                    }
                });
            }

            function markBeforeAfter(id, elem) {
                $.ajax({
                    url: "{{ url('/adminmedia/albums/gallery/markBeforeAfter') }}",
                    method: 'post',
                    data: {
                        "_token": "{{ csrf_token() }}",
                        "id": id,
                    },
                    success: function(response) {
                        if (response.message == 'marked') {
                            $(elem).remove();
                            $('#image_' + id).attr('src', response.src);
                        }
                        console.log(response);
                    }
                });
            }
        </script>
        <script>
            function openGalleryImageZoomModal(url) {
                $('#galleryImageZoomImage').attr('src', url);
                $('#galleryImageZoomModal').modal('show');
            }
        </script>
    @endsection
