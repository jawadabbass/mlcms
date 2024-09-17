@extends('back.layouts.app', ['title' => $title])
@include('back.files.files_js');
@section('content')
    <div class="content-wrapper pl-3 pr-2">
        <!-- Inner Header -->
        <section class="content-header">
            <div class="row">
                <div class="col-md-5 col-sm-12">
                    <ol class="breadcrumb">
                        <li><a href="{{ admin_url() }}"><i class="fas fa-gauge"></i> Home</a></li>
                        <li class="active">Files</li>
                    </ol>
                </div>
                <div class="col-md-7 col-sm-12"> @include('back.common_views.quicklinks') </div>
            </div>
        </section>

        <!-- Main Content starts --->
        <section class="content">
            <div class="row">
                <div class="col-xs-12 col-md-12">
                    <div class="row">
                        <div class="col-sm-8">
                            <h3 class=" card-title">Manage Files</h3>
                        </div>
                        <div class="col-sm-4">
                            <div class="text-end" style="padding-bottom:2px;">
                                <a class="btn btn-warning" href="{{ admin_url() }}media"><i class="fas fa-image"
                                        aria-hidden="true"></i>
                                    Manage Images
                                </a>
                                <a class="btn btn-info" data-bs-target="#modal-1" data-bs-toggle="modal" href="javascript:;"><i
                                        class="fas fa-folder-o" aria-hidden="true"></i>
                                    Create Folder
                                </a>
                            </div>
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
                        <h5>Upload File(s)</h5>
                        <hr>

                        <form action="{{ route('upload_files_images') }}" enctype="multipart/form-data" method="post">
                            {{ csrf_field() }}
                            <input type="hidden" name="cat_id" value="">
                            <div class="row">
                                <div class="col-md-3 text-end">Folder:</div>
                                <div class="col-md-3">
                                    <select id="album" name="album" class="form-control">

                                        @foreach ($albumsObj as $ak => $av)
                                            <option value="{{ $av['album_path'] }}">
                                                {{ $av['album_title'] }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-3">
                                    <input class="form-control" id="uploadFile" multiple="" name="uploadFile[]"
                                        type="file" />
                                    <div class="text-danger"><em>Max :</em> {{ getMaxUploadSize() }} MB</div>
                                </div>
                                <div class="col-md-3">
                                    <input
                                        class="btn btn-success" name="submitImage" type="submit"  value="Upload File(s)" />
                                </div>
                            </div>
                            <div id="image_preview" class="row">
                                <div class="col-sm-12 text-center">
                                    <strong>Allowed Extensions:</strong>
                                    @foreach ($filesExts as $key => $val)
                                        <span class="badge badge-warning"
                                            title="{{ $key }} file">{!! $val !!}
                                            {!! $key !!}</span>
                                    @endforeach
                                </div>
                            </div>
                        </form>

                        </hr>
                    </div>
                    <!-- End Image Uploader  -->
                </div>
            </div>
        </section>
        <div class="folderselect">
            <h3>Select Folder</h3>
            <div class="btn-group">
                @foreach ($albumsObj as $ak => $av)
                    <button type="button" class="fldbtns btn btn-default <?php if ($av['album_title'] == 'root') {
                        echo 'active';
                    } ?>"
                        onClick="show_section('{{ $ak }}',this)" aria-haspopup="true" aria-expanded="false">
                        {{ $av['album_title'] }}
                    </button>
                @endforeach
            </div>
        </div>
        @foreach ($albumsObj as $kk => $val)
            <div class="myasection mediaup">
                <div class="row mystr section_{{ $val['album_id'] }}">

                    <div class="col-md-8">
                        <h1>
                            <i class="fas fa-folder-open-o" aria-hidden="true"></i> {{ $val['album_title'] }}
                        </h1>
                    </div>
                    <div class="col-md-4 text-end">
                        <h3>
                            @if ($val['album_title'] != 'root')
                                <a href="javascript:;" class="btn btn-danger"
                                    onClick="delete_album('{{ $val['album_path'] }}',{{ $val['album_id'] }});"
                                    data-bs-toggle="tooltip" title="Delete this Folder and File(s)"><i class="fas fa-trash"
                                        aria-hidden="true"></i></a>
                            @endif
                            <a href="javascript:;" class="btn btn-success"
                                onclick="upload_imgs('{{ $val['album_path'] }}');" data-bs-toggle="tooltip"
                                title="Add File(s) in this Folder">
                                <i aria-hidden="true" class="fas fa-plus-circle">
                                </i>
                            </a>
                        </h3>
                    </div>
                </div>
                <ul class="row fileslist  section_{{ $val['album_id'] }}">
                    @foreach ($val['all'] as $k => $v)
                        @php
                            $imgID = $val['album_id'] . '_' . $k;
                        @endphp
                        <li class="col-md-6" id="id_{{ $imgID }}">
                            <div class="filedata">
                                <span class="fileico">
                                    @php
                                        $path_info = pathinfo(storage_uploads($v['url']));
                                        if (isset($path_info['extension']) && isset($filesExts[$path_info['extension']])) {
                                            echo $filesExts[$path_info['extension']];
                                        } else {
                                            echo '<i class="fas fa-file-o" aria-hidden="true"></i>';
                                        }
                                    @endphp
                                </span>
                                <a target="_blank" class="filepath"
                                    href="{{ asset_uploads($v['url']) }}">{{ $v['name'] }}</a>
                                <a class="btn btn-danger" data-bs-toggle="tooltip" data-placement="left"
                                    title="Delete this file" href="javascript:;"
                                    onclick="delete_image('{{ storage_uploads($v['url']) }}','{{ $imgID }}');"><i
                                        class="fas fa-trash"></i></a>
                                <span class="badge badge-secondary"><?php echo human_filesize(filesize(storage_uploads($v['url']))); ?></span>
                                <a class="btn btn-success" data-bs-toggle="tooltip" data-placement="left"
                                    title="Copy file path" href="javascript:;"
                                    onclick="copyMyTxt('{{ asset_uploads($v['url']) }}');"><i class="fas fa-copy"
                                        aria-hidden="true"></i></a>

                            </div>

                        </li>
                    @endforeach
                </ul>
            </div>
        @endforeach
        {{-- Modal 1 For Add Folder --}}
        <div class="modal fade" id="modal-1">
            <div class="modal-dialog" role="document">
                <form action="" id="add_album_frm" name="add_album_frm" enctype="multipart/form-data">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title">
                                Add Folder
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
        <div class="modal fade" id="copy_modal">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">
                            Copy
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
                            <div class="col-md-9"><input class="form-control" id="txt_copy" name="txt_copy"
                                    type="text" value=""></div>
                            <div class="col-md-3"><a href="javascript:;" onClick="copyMyTxt2();" id="copy_btn"
                                    class="btn btn-info">Copy</a></div>
                        </div>

                    </div>

                </div>
            </div>
            <!-- /.modal-dialog -->
        </div>
        <input style="display: none;" type="text" name="txt_copy22" id="txt_copy22" class="form-control"
            value="" placeholder="">
        <div class="spinner" id="spinner" style="display: none;">
            <i class="fas fa-spinner fa-spin" aria-hidden="true"></i><span>Processing ...</span>
        </div>
    @endsection('content')
    @section('beforeBodyClose')
        <script>
            jQuery(document).ready(function($) {
                $("#left-sidebar").addClass("collapse-left");
                $(".right-side").addClass("strech");
            });
        </script>
    @endsection
