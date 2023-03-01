@extends('back.layouts.app', ['title' => $title])

@section('content')
    <aside class="right-side {{ session('leftSideBar') == 1 ? 'strech' : '' }}">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="row">
                <div class="col-md-8 col-sm-6">
                    <ol class="breadcrumb">
                        <li>
                            <a href="{{ env('APP_URL') . 'adminmedia' }}">
                                <i class="fa-solid fa-dashboard"></i> Home
                            </a>
                        </li>
                        <li class="active">Manage Content Of {{ $main_package->heading }} Package</li>
                    </ol>
                </div>
                <div class="col-md-4 col-sm-6">
                    @include('back.common_views.quicklinks')
                </div>
            </div>
        </section>
        <!-- Main content -->
        <section class="content">

            <div class="row">
                <div class="col-xs-12 col-md-12">
                    <div class="box">



                        <div class="box-body">
                            <!-- image section start-->
                            <div class="row">
                                <div class="col-sm-8">
                                    <div class="box-header">
                                        <h3 class="box-title">Manage Images Of {{ $main_package->heading }} Package

                                        </h3>
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="text-end" style="padding-bottom:2px;">
                                        <a href="javascript:;" onclick="PackageManageContentShow('image')"
                                            class="btn btn-primary">Add New Image
                                        </a>
                                    </div>
                                </div>
                            </div>
                            <br>
                            <div class="row">
                                @if (!$images == null)
                                    @foreach ($images as $show_img)
                                        <div class="col-sm-3">

                                            <i class="deleteIcon" onclick="delete_record('{{ $show_img->id }}')"><span
                                                    style="display:none;">{{ $show_img->image }};image;{{ $show_img->image }}</span></i>
                                            <img src="{{ asset('uploads/package_content/images/' . $show_img->image) }}"
                                                height="200px">
                                        </div>
                                    @endforeach
                                @endif
                            </div>
                            <hr>
                            <!-- image section End-->



                            <!-- Video section start-->
                            <div class="row">
                                <div class="col-sm-8">
                                    <div class="box-header">
                                        <h3 class="box-title">Manage Video Of {{ $main_package->heading }} Package

                                        </h3>
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="text-end" style="padding-bottom:2px;">
                                        <a href="javascript:;" onclick="PackageManageContentShow('video')"
                                            class="btn btn-primary">Add New Video
                                        </a>
                                    </div>
                                </div>
                            </div>
                            <br>
                            <div class="row">
                                @if (!$videos == null)
                                    @foreach ($videos as $show_vd)
                                        <div class="col-sm-3">

                                            <i class="deleteIcon" onclick="delete_record('{{ $show_vd->id }}')"><span
                                                    style="display:none;">{{ $show_vd->video }};image;{{ $show_vd->video }}</span></i>
                                            <video id="video1" width="300">
                                                <source
                                                    src="{{ asset('uploads/package_content/videos/' . $show_vd->video) }}"
                                                    type="video/mp4">
                                            </video>
                                        </div>
                                    @endforeach
                                @endif
                            </div>
                            <hr>
                            <!-- Video section End-->


                            <!-- document section start-->
                            <div class="row">
                                <div class="col-sm-8">
                                    <div class="box-header">
                                        <h3 class="box-title">Manage Document Of {{ $main_package->heading }} Package

                                        </h3>
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="text-end" style="padding-bottom:2px;">
                                        <a href="javascript:;" onclick="PackageManageContentShow('document')"
                                            class="btn btn-primary">Add New Document(Only Pdf)
                                        </a>
                                    </div>
                                </div>
                            </div>
                            <br>
                            <div class="row">
                                @if (!$documents == null)
                                    @foreach ($documents as $show_do)
                                        <div class="col-sm-3">

                                            <i class="deleteIcon" onclick="delete_record('{{ $show_do->id }}')"><span
                                                    style="display:none;">{{ $show_do->document }};image;{{ $show_do->document }}</span></i>
                                            <iframe
                                                src="{{ asset('uploads/package_content/documents/' . $show_do->document) }}"
                                                width="180px" height="180px"></iframe>
                                        </div>
                                    @endforeach
                                @endif
                            </div>
                            <hr>
                            <!-- document section End-->


                            <!--Content section start-->
                            <div class="row">
                                <div class="col-sm-8">
                                    <div class="box-header">
                                        <h3 class="box-title">Manage Content Of {{ $main_package->heading }} Package

                                        </h3>
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="text-end" style="padding-bottom:2px;">
                                        <a href="javascript:;" onclick="PackageManageContentShow('content')"
                                            class="btn btn-primary">Add New Content
                                        </a>
                                    </div>
                                </div>
                            </div>
                            <br>
                            <div class="row">
                                @if (!$contents == null)
                                    @foreach ($contents as $show_co)
                                        <div class="col-sm-3">

                                            <i class="deleteIcon" style="margin-top: 0px !important"
                                                onclick="delete_record('{{ $show_co->id }}')"><span
                                                    style="display:none;">{{ $show_co->content }};image;{{ $show_co->content }}</span></i>
                                            <li class="fa-solid fa-edit"
                                                onclick="edit_content_show('{{ $show_co->id }}','{{ $show_co->content }}')"
                                                style="margin-left: 24px;font-size:14px;color:green;">
                                            </li>
                                            <p>{!! $show_co->content !!}</p>
                                        </div>
                                    @endforeach
                                @endif
                            </div>
                            <hr>
                            <!--Content section End-->

                        </div>

                        <!-- /.box-body -->
                    </div>

                    <!-- /.box -->
                    <!-- /.box -->
                </div>
            </div>


            <!--model add content start -->


            <div class="modal fade" id="packageManageContent" tabindex="-1" role="dialog"
                aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Add Package Content</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                                
                            </button>
                        </div>
                        <div class="modal-body">
                            <div style="display: none;" class="error-div alert alert-danger"></div>
                            <form id="content_add_store" enctype="multipart/form-data" method="post">

                                <input type="hidden" name="type" id="type" />
                                <input type="hidden" name="package_id" value="{{ $main_package->id }}">
                                <input type="hidden" name="ck_editor" id="ck_editor" />
                                <div id="image" style="display: none;">
                                    <div class="form-group">
                                        <label for="recipient-name" class="col-form-label">Select Image:</label>
                                        <input type="file" name="image" class="form-control" id="p_image"
                                            accept="image/*">
                                    </div>
                                </div>
                                <div id="video" style="display: none;">
                                    <div class="form-group">
                                        <label for="recipient-name" class="col-form-label">Select Video:</label>
                                        <input type="file" name="video" class="form-control" id="p_video"
                                            accept="video/*">
                                    </div>
                                </div>

                                <div id="document" style="display: none;">
                                    <div class="form-group">
                                        <label for="recipient-name" class="col-form-label">Select Document:</label>
                                        <input type="file" name="document" class="form-control" id="p_document"
                                            accept=".pdf">
                                    </div>
                                </div>

                                <div id="content" style="display: none;">
                                    <div class="form-group">
                                        <label for="recipient-name" class="col-form-label">Add Content</label>
                                        <textarea id="text_content" name="content"></textarea>
                                    </div>
                                </div>

                            </form>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            <button type="button" class="btn btn-primary subm" onclick="store_content()">Save</button>
                        </div>
                    </div>
                </div>
            </div>


            <!--modal add content end -->






            <!--model edit content start -->


            <div class="modal fade" id="package_edit_Content" tabindex="-1" role="dialog"
                aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Edit Package Content</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                                
                            </button>
                        </div>
                        <div class="modal-body">
                            <div style="display: none;" class="error-div alert alert-danger"></div>
                            <form id="content_edit_store" enctype="multipart/form-data" method="post">

                                <input type="hidden" name="edit_item" id="edit_item" />

                                <input type="hidden" name="edit_ck_editor" id="edit_ck_editor_id" />


                                    <div class="form-group">
                                        <label for="recipient-name" class="col-form-label">Edit Content</label>
                                        <textarea id="edit_ck_editor" name="edit_content"></textarea>
                                    </div>


                            </form>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            <button type="button" class="btn btn-primary subm" onclick="edit_store_content()">Save</button>
                        </div>
                    </div>
                </div>
            </div>


            <!--modal edit content end -->
        </section>
        <!-- /.content -->


    </aside>
@endsection
@section('beforeBodyClose')
    <script src="{{ asset('lib/sweetalert/sweetalert2.js') }}"></script>
    <script>
        function PackageManageContentShow($type) {

            $("#type").val($type);
            if ($type == 'image') {
                $("#image").show();
                $("#video").hide();
                $("#document").hide();
                $("#content").hide();

            } else if ($type == 'video') {

                $("#image").hide();
                $("#video").show();
                $("#document").hide();
                $("#content").hide();
            } else if ($type == 'document') {

                $("#image").hide();
                $("#video").hide();
                $("#document").show();
                $("#content").hide();
            } else {

                $("#image").hide();
                $("#video").hide();
                $("#document").hide();
                $("#content").show();
            }
            $("#packageManageContent").modal('show');

        }

        function store_content() {
            var my_editor_id = 'text_content';
            var content = CKEDITOR.instances[my_editor_id].getData();

            $("#ck_editor").val(content);
            var get_url = "{{ route('package_content_store') }}";


            //var form =new FormData( this );
            var form = new FormData($('#content_add_store')[0]);


            var btnText = $(".subm").html();
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                url: get_url,
                type: "post",
                processData: false,
                contentType: false,
                cache: false,
                data: form,
                beforeSend: function(data, status) {
                    $(".subm").attr('disabled', true);
                    $(".cancel").attr('disabled', true);
                    $(".subm").html('<i class="fa-solid fa-refresh fa-spin" aria-hidden="true"></i> Processing');

                },
                error: function(xhr) {},
                success: function(data) {
                    //var data = JSON.parse(data);
                    if (data.status == "success")

                    {
                        swal({
                            type: 'success',
                            title: 'Success!',
                            text: data.message,
                            buttonsStyling: false,
                            confirmButtonClass: 'btn btn-lg btn-success'
                        });
                        $('#packageManageContent').modal('hide');
                        location.reload();
                    }

                    if (data.status == "danger") {
                        var html;
                        $('.error-div').html("");
                        $('.error-div').show();
                        $('.error-div').append(data.message);
                        var offset = $(".error-div").offset().top;
                        $('html,body').animate({
                            scrollTop: 0
                        }, 1000);
                        $('#packageManageContent').animate({
                            scrollTop: 0
                        }, 1000);
                        setTimeout(function() {
                            $('.error-div').fadeOut()
                        }, 4000);
                    }
                },
                complete: function(data, status) {
                    $(".subm").attr('disabled', false);
                    $(".cancel").attr('disabled', false);
                    $(".subm").html(btnText);
                }
            }); // End Aajax Request
        };


        //Delete record


        function delete_record($id) {

            swal({
                title: "Are you sure?",
                text: "Deleting the item may remove it from all  Clients Purshed Package?",
                type: "warning",
                showCancelButton: true,
                confirmButtonColor: "#DD6B55",
                confirmButtonText: "Yes, delete it!",
                closeOnConfirm: false
            }).then(isConfirmed => {
                $.ajax({
                    type: "get",
                    dataType: 'json',
                    cache: false,
                    url: "{{ route('package_content_delete', '') }}" + "/" + $id,
                    data: {
                        '_token': $('meta[name="csrf-token"]').attr('content')

                    },
                    success: function(data) {
                        swal("Done!", "Record Deleted Successfully.", "success");
                        location.reload();
                    },
                });
            });

        }


        function edit_content_show($id, $content) {

            $("#edit_item").val($id);

            CKEDITOR.instances['edit_ck_editor'].setData($content);
            $("#package_edit_Content").modal('show');


        }


        function edit_store_content() {
            var my_editor_id = 'edit_ck_editor';
            var content = CKEDITOR.instances[my_editor_id].getData();

            $("#edit_ck_editor_id").val(content);
            var get_url = "{{ route('package_content_store_edit') }}";


            //var form =new FormData( this );
            var form = new FormData($('#content_edit_store')[0]);


            var btnText = $(".subm").html();
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                url: get_url,
                type: "post",
                processData: false,
                contentType: false,
                cache: false,
                data: form,
                beforeSend: function(data, status) {
                    $(".subm").attr('disabled', true);
                    $(".cancel").attr('disabled', true);
                    $(".subm").html('<i class="fa-solid fa-refresh fa-spin" aria-hidden="true"></i> Processing');

                },
                error: function(xhr) {},
                success: function(data) {
                    //var data = JSON.parse(data);
                    if (data.status == "success")

                    {
                        swal({
                            type: 'success',
                            title: 'Success!',
                            text: data.message,
                            buttonsStyling: false,
                            confirmButtonClass: 'btn btn-lg btn-success'
                        });
                        $('#package_edit_Content').modal('hide');
                        location.reload();
                    }

                    if (data.status == "danger") {
                        var html;
                        $('.error-div').html("");
                        $('.error-div').show();
                        $('.error-div').append(data.message);
                        var offset = $(".error-div").offset().top;
                        $('html,body').animate({
                            scrollTop: 0
                        }, 1000);
                        $('#package_edit_Content').animate({
                            scrollTop: 0
                        }, 1000);
                        setTimeout(function() {
                            $('.error-div').fadeOut()
                        }, 4000);
                    }
                },
                complete: function(data, status) {
                    $(".subm").attr('disabled', false);
                    $(".cancel").attr('disabled', false);
                    $(".subm").html(btnText);
                }
            }); // End Aajax Request
        };
    </script>

    <script type="text/javascript">
        $(function() {
            CKEDITOR.replace('text_content');
            CKEDITOR.config.allowedContent = true;
            CKEDITOR.config.autoParagraph = false;
        });

        $(function() {
            CKEDITOR.replace('edit_content');
            CKEDITOR.config.allowedContent = true;
            CKEDITOR.config.autoParagraph = false;
        });
    </script>
@endsection
