@extends('back.layouts.app', ['title' => $title])
@section('beforeHeadClose')
    <link href="https://gitcdn.github.io/bootstrap-toggle/2.2.2/css/bootstrap-toggle.min.css" rel="stylesheet">
    <link href="{{ asset_storage('back/css/cropper.css') }}" rel="stylesheet">
    <style>
        .sortable_div {
            display: inline-block !important;
        }

        .sortable_div i {
            background-color: #b4b3b3;
            text-align: center;
            line-height: 24px;
            width: 30px;
            height: 26px;
            cursor: all-scroll;
            border-radius: 4px;
            padding-top: 0px;
        }
    </style>
@endsection
@section('content')
    <div class="content-wrapper pl-3 pr-2">
        <!-- Inner Header -->
        <section class="content-header">
            <div class="row">
                <div class="col-md-5 col-sm-12">
                    <ol class="breadcrumb">
                        <li><a href="{{ base_url() . 'adminmedia' }}">
                                <i class="fas fa-gauge"></i> Home</a></li>
                        <li><a href="{{ base_url() . 'adminmedia/gallery' }}">
                                <i class="fas fa-gauge"></i> Albums</a></li>
                        <li class="active">{{ $album_name }}</li>
                    </ol>
                </div>
                <div class="col-md-7 col-sm-12"> @include('back.common_views.quicklinks') </div>
            </div>
        </section>
        <!-- Main Content starts --->
        <section class="content p-3">
            <div class="row">
                <div class="col-xs-12 col-md-12">
                    <div class="row">
                        <div class="col-sm-12">
                            <h3 class=" card-title">{{ $album_name }} Gallery</h3>
                        </div>
                    </div>
                    @if (session('success'))
                        <div class="alert alert-success">
                            <i class="fas fa-check" aria-hidden="true"></i> {{ session('success') }}
                        </div>
                    @endif
                    @if ($errors->any())
                        <div class="row">
                            <div class="col-md-12">
                                <div class="alert alert-danger" role="alert">
                                    <ol>
                                        @foreach ($errors->all() as $errmsg)
                                            <li>{{ $errmsg }}</li>
                                        @endforeach
                                    </ol>
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
                                <div class="col-md-12 mb-3 before_after_not_have_two_images">
                                    <input class="form-control" id="uploadFile" multiple="" name="uploadFile[]"
                                        type="file" onchange="uploaded_files_show();" />
                                    <div class="text-danger"><em>Max :</em> {{ getMaxUploadSize() }} MB</div>
                                    <div id="image_preview" class="row"></div>
                                </div>
                                <div class="col-md-12 mb-3">
                                    <input type="checkbox" name="isBeforeAfter" id="isBeforeAfter" value="1"
                                        style="width: 15px; height:15px;" onclick="toggle_before_after_have_two_images();"
                                        {{ old('isBeforeAfter', 0) == 1 ? 'checked' : '' }} /> <b>Is Before After?</b>
                                </div>
                                <div class="col-md-12 mb-3" id="is_before_after_have_two_images" style="display: none;">
                                    <label>Is Before After Have Two Images?</label>
                                    <input type="radio" name="isBeforeAfterHaveTwoImages" value="1"
                                        style="width: 15px; height:15px;" onclick="show_before_after_have_two_images();"
                                        {{ old('isBeforeAfterHaveTwoImages', 0) == 1 ? 'checked' : '' }} />
                                    <b>Yes</b>
                                    <input type="radio" name="isBeforeAfterHaveTwoImages" value="0"
                                        {{ old('isBeforeAfterHaveTwoImages', 0) == 0 ? 'checked' : '' }}
                                        style="width: 15px; height:15px;" onclick="hide_before_after_have_two_images();" />
                                    <b>No</b>
                                </div>
                                <div class="col-md-12 mb-3 before_after_have_two_images" style="display: none;">
                                    <label>Before Image</label>
                                    <input class="form-control" id="before_image" name="before_image" type="file" />
                                    <div class="text-danger"><em>Max :</em> {{ getMaxUploadSize() }} MB</div>
                                    <div id="before_image_preview" class="row"></div>
                                </div>
                                <div class="col-md-12 mb-3 before_after_have_two_images" style="display: none;">
                                    <label>After Image</label>
                                    <input class="form-control" id="after_image" name="after_image" type="file" />
                                    <div class="text-danger"><em>Max :</em> {{ getMaxUploadSize() }} MB</div>
                                    <div id="after_image_preview" class="row"></div>
                                </div>
                                <div class="col-md-12 mb-3">
                                    <input class="btn btn-success" name="submitImage" type="submit"
                                        value="Upload Image(s)" />
                                </div>
                            </div>
                        </form>
                        </hr>
                    </div>
                    <!-- End Image Uploader  -->
                </div>
            </div>
        </section>
        <section class="content p-3">
            <div class="myasection">
                <div class="row sortable_row">
                    @forelse($images as $image)
                        @if ($image->isBeforeAfterHaveTwoImages == 0)
                            <div class="col-md-4" id="{{ $image->id }}">
                                <div class="mb-3">
                                    <div class="">
                                        <a href="javascript:void(0);" title="{{ $image->image_title }}"
                                            onclick="openGalleryImageZoomModal('{{ asset_uploads('') }}gallery/{{ $image->album_id }}/{{ $image->imageUrl . '?' . time() }}');">
                                            <img id="image_1_{{ $image->id }}" data-imgname="{{ $image->imageUrl }}"
                                                src="{{ asset_uploads('') }}gallery/{{ $image->album_id }}/thumb/{{ $image->imageUrl . '?' . time() }}"
                                                style="width:100%" alt="{{ $image->image_alt }}"
                                                title="{{ $image->image_title }}">
                                        </a>
                                    </div>
                                    <div class="caption myadelbtn">
                                    </div>
                                    <div class="image_btn mt-2">
                                        <div class="drag sortable_div" title="Drag and Drop to sort"><i
                                                class="fas fa-arrows" aria-hidden="true"></i></div>
                                        <a title="Active/Inactive" onClick="update_status({{ $image->id }}, this)"
                                            href="javascript:void(0)"
                                            class="mb-1 btn btn-{{ $image->status == 1 ? 'success' : 'secondary' }}"
                                            id="{{ 'status_' . $image->id }}"><i class="fas fa-eye"
                                                aria-hidden="true"></i></a>
                                        <a title="Featured/Not Featured"
                                            onClick="update_featured({{ $image->id }}, this)"
                                            href="javascript:void(0)"
                                            class="mb-1 btn btn-{{ $image->isFeatured == 1 ? 'success' : 'secondary' }}"
                                            id="{{ 'featured_' . $image->id }}"><i class="fas fa-star"
                                                aria-hidden="true"></i></a>
                                        <a title="Delete Image" onclick="deleteImage({{ $image->id }}, this);"
                                            class="mb-1 btn btn-danger" data-bs-toggle="tooltip" data-placement="left"
                                            title="Delete this image" href="javascript:;"> <i
                                                class="fas fa-trash"></i></a>
                                        @if ((bool) $image->isBeforeAfter == false)
                                            <a onClick="markBeforeAfter({{ $image->id }}, this)"
                                                href="javascript:void(0)" class="mb-1 btn btn-warning">Mark Before
                                                After</a>
                                        @endif
                                        <a title="Crop Image"
                                            onClick="bind_cropper_preview_gallery_image({{ $image->album_id }}, {{ $image->id }}, 1);"
                                            href="javascript:void(0)" class="mb-1 btn btn-warning"><i class="fas fa-crop"
                                                aria-hidden="true"></i></a>
                                        <a title="Image Alt/Title"
                                            onClick="openImageAltTitleModal({{ $image->album_id }}, {{ $image->id }});"
                                            href="javascript:void(0)" class="mb-1 btn btn-success"><i class="fas fa-bars"
                                                aria-hidden="true"></i></a>
                                    </div>
                                </div>
                            </div>
                        @else
                            <div class="col-md-12" id="{{ $image->id }}">
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="mb-3">
                                            <div class="">
                                                <a href="javascript:void(0);" title="{{ $image->image_title }}"
                                                    onclick="openGalleryImageZoomModal('{{ asset_uploads('') }}gallery/{{ $image->album_id }}/{{ $image->imageUrl . '?' . time() }}');">
                                                    <img id="image_1_{{ $image->id }}"
                                                        data-imgname="{{ $image->imageUrl }}"
                                                        src="{{ asset_uploads('') }}gallery/{{ $image->album_id }}/thumb/{{ $image->imageUrl . '?' . time() }}"
                                                        style="width:100%" alt="{{ $image->image_alt }}"
                                                        title="{{ $image->image_title }}">
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="mb-3">
                                            <div class="">
                                                <a href="javascript:void(0);" title="{{ $image->image_title }}"
                                                    onclick="openGalleryImageZoomModal('{{ asset_uploads('') }}gallery/{{ $image->album_id }}/{{ $image->imageUrl2 . '?' . time() }}');">
                                                    <img id="image_2_{{ $image->id }}"
                                                        data-imgname="{{ $image->imageUrl2 }}"
                                                        src="{{ asset_uploads('') }}gallery/{{ $image->album_id }}/thumb/{{ $image->imageUrl2 . '?' . time() }}"
                                                        style="width:100%" alt="{{ $image->image_alt }}"
                                                        title="{{ $image->image_title }}">
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="mb-3">
                                            <img-comparison-slider>
                                                <figure slot="first" class="before">
                                                    <img width="100%"
                                                        src="{{ asset_uploads('') }}gallery/{{ $image->album_id }}/thumb/{{ $image->imageUrl . '?' . time() }}">
                                                    <figcaption>Before</figcaption>
                                                </figure>
                                                <figure slot="second" class="after">
                                                    <img width="100%"
                                                        src="{{ asset_uploads('') }}gallery/{{ $image->album_id }}/thumb/{{ $image->imageUrl2 . '?' . time() }}">
                                                    <figcaption>After</figcaption>
                                                </figure>
                                            </img-comparison-slider>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12 text-center">
                                        <div class="mb-3">
                                            <div class="caption myadelbtn">
                                            </div>
                                            <div class="image_btn mt-2">
                                                <div class="drag sortable_div" title="Drag and Drop to sort"><i
                                                        class="fas fa-arrows" aria-hidden="true"></i></div>
                                                <a title="Active/Inactive"
                                                    onClick="update_status({{ $image->id }}, this)"
                                                    href="javascript:void(0)"
                                                    class="mb-1 btn btn-{{ $image->status == 1 ? 'success' : 'secondary' }}"
                                                    id="{{ 'status_' . $image->id }}"><i class="fas fa-eye"
                                                        aria-hidden="true"></i></a>
                                                <a title="Featured/Not Featured"
                                                    onClick="update_featured({{ $image->id }}, this)"
                                                    href="javascript:void(0)"
                                                    class="mb-1 btn btn-{{ $image->isFeatured == 1 ? 'success' : 'secondary' }}"
                                                    id="{{ 'featured_' . $image->id }}"><i class="fas fa-star"
                                                        aria-hidden="true"></i></a>
                                                <a title="Delete Image" onclick="deleteImage({{ $image->id }}, this);"
                                                    class="mb-1 btn btn-danger" data-bs-toggle="tooltip"
                                                    data-placement="left" title="Delete this image" href="javascript:;">
                                                    <i class="fas fa-trash"></i></a>
                                                @if ((bool) $image->isBeforeAfter == false)
                                                    <a onClick="markBeforeAfter({{ $image->id }}, this)"
                                                        href="javascript:void(0)" class="mb-1 btn btn-warning">Mark Before
                                                        After</a>
                                                @endif
                                                <a title="Crop Image"
                                                    onClick="bind_cropper_preview_gallery_image({{ $image->album_id }}, {{ $image->id }}, 1);"
                                                    href="javascript:void(0)" class="mb-1 btn btn-warning"><i
                                                        class="fas fa-crop" aria-hidden="true"></i></a>
                                                <a title="Crop Image"
                                                    onClick="bind_cropper_preview_gallery_image({{ $image->album_id }}, {{ $image->id }}, 2);"
                                                    href="javascript:void(0)" class="mb-1 btn btn-warning"><i
                                                        class="fas fa-crop" aria-hidden="true"></i></a>
                                                <a title="Image Alt/Title"
                                                    onClick="openImageAltTitleModal({{ $image->album_id }}, {{ $image->id }});"
                                                    href="javascript:void(0)" class="mb-1 btn btn-success"><i
                                                        class="fas fa-bars" aria-hidden="true"></i></a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endif
                    @empty
                        <div>There is no image found in the album.</div>
                    @endforelse
                </div>
            </div>
        </section>
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
                            <div class=" card-body">
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
                            <input type="hidden" name="image_1_2" id="image_1_2" value="">
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
                            <div class=" card-body">
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
        <script src="{{ asset_storage('back/js/cropper.js') }}"></script>
        @include('back.gallery.gallery_js')
        <script>
            $(function() {
                $('.sortable_row').sortable({
                    opacity: 1,
                    handle: '.sortable_div',
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
                                alert('Error adding / update data ' + ' ' + textStatus + ' ' +
                                    errorThrown);
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
                                    $('#' + id).remove();
                                    swal("Poof! Your image has been deleted!", {
                                        icon: "success",
                                        timer: 2000
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
        </script>
        <script>
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

            function openGalleryImageZoomModal(url) {
                $('#galleryImageZoomImage').attr('src', url);
                $('#galleryImageZoomModal').modal('show');
            }

            function show_before_after_have_two_images() {
                $('.before_after_have_two_images').show();
                $('.before_after_not_have_two_images').hide();
            }

            function hide_before_after_have_two_images() {
                $('.before_after_have_two_images').hide();
                $('.before_after_not_have_two_images').show();
            }

            function toggle_before_after_have_two_images() {
                if ($('#isBeforeAfter').is(':checked')) {
                    $('#is_before_after_have_two_images').show();
                    if ($("[name='isBeforeAfterHaveTwoImages']:checked").val() == 1) {
                        show_before_after_have_two_images();
                    }
                } else {
                    $('#is_before_after_have_two_images').hide();
                    hide_before_after_have_two_images();
                }
            }
            @if (old('isBeforeAfter', 0) == 1)
                $('#is_before_after_have_two_images').show();
            @endif
            @if (old('isBeforeAfterHaveTwoImages', 0) == 1)
                show_before_after_have_two_images();
            @endif
        </script>
    @endsection
