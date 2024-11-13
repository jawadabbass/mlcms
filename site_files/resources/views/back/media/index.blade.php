@extends('back.layouts.app', ['title' => $title])
@section('beforeBodyClose')
    @include('back.media.media_js');
@endsection
@section('content')
    <div class="content-wrapper pl-3 pr-2">
        <!-- Inner Header -->
        <section class="content-header">
            <div class="row">
                <div class="col-md-5 col-sm-12">
                    <ol class="breadcrumb">
                        <li><a href="{{ admin_url() }}"><i class="fas fa-gauge"></i> Home</a></li>
                        <li class="active">Manage Images</li>
                    </ol>
                </div>
                <div class="col-md-7 col-sm-12"> @include('back.common_views.quicklinks') </div>
            </div>
        </section>
        <!-- Main Content starts --->
        <section class="content">
            <div class="card p-2">
                <div class="row">
                    <div class="col-xs-12 col-md-12">
                        <div class="row">
                            <div class="col-sm-8">
                                <h3 class=" card-title">Manage Images</h3>
                            </div>
                            <div class="col-sm-4">
                                <div class="text-end" style="padding-bottom:2px;">
                                    <a class="btn btn-warning" href="{{ admin_url() }}files"><i aria-hidden="true"
                                            class="fas fa-file"></i>
                                        Manage Documents
                                    </a>
                                    <a class="btn btn-info" data-bs-target="#modal-1" data-bs-toggle="modal"
                                        href="javascript:;"><i class="fas fa-folder-o" aria-hidden="true"></i>
                                        Create Folder
                                    </a>
                                </div>
                            </div>
                        </div>
                        <!-- Image Uploader  -->
                        <div class="upload_adm_area" id="upload_adm_area">
                            <h5>Upload Image(s) </h5>
                            <hr>
                            <form action="{{ route('upload_media_images') }}" enctype="multipart/form-data" method="post">
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
                                        <input onchange="uploaded_files_show();" class="form-control" id="uploadFile"
                                            multiple="" name="uploadFile[]" type="file" />
                                        <div class="text-danger"><em>Max :</em> {{ getMaxUploadSize() }} MB</div>
                                    </div>
                                    <div class="col-md-3">
                                        <input class="btn btn-success" name="submitImage" type="submit"
                                            value="Upload Image(s)" />
                                    </div>
                                </div>
                                <div id="image_preview" class="row">
                                </div>
                            </form>
                            <hr />
                        </div>
                        <!-- End Image Uploader  -->
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
                <div class="folderselect">
                    <h3>Select Folder</h3>
                    <div class="btn-group">
                        @foreach ($albumsObj as $ak => $av)
                            <button type="button" class="fldbtns btn btn-default <?php if ($av['album_title'] == 'root') {
                                echo 'active';
                            } ?>"
                                onClick="show_section('{{ $ak }}',this)" aria-haspopup="true"
                                aria-expanded="false">
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
                                    {{-- <a href="javascript:;" class="btn btn-warning" onClick="edit_album({{$val['album_id']}},'{{$val['album_title']}}');" data-bs-toggle="tooltip" title="Edit Folder"><i class="fas fa-edit" aria-hidden="true"></i></a> --}}
                                    @if ($val['album_title'] != 'root')
                                        <a href="javascript:;" class="btn btn-danger"
                                            onClick="delete_album('{{ $val['album_path'] }}',{{ $val['album_id'] }});"
                                            data-bs-toggle="tooltip" title="Delete this Folder and Image(s)"><i
                                                class="fas fa-trash" aria-hidden="true"></i></a>
                                    @endif
                                    <a href="javascript:;" class="btn btn-success"
                                        onclick="upload_imgs('{{ $val['album_path'] }}');" data-bs-toggle="tooltip"
                                        title="Add Image(s) in this Folder">
                                        <i aria-hidden="true" class="fas fa-plus-circle">
                                        </i>
                                    </a>
                                </h3>
                            </div>
                        </div>

                        <div class="row  section_{{ $val['album_id'] }}">
                            @foreach ($val['all'] as $k => $v)
                                @php
                                    $imgID = $val['album_id'] . '_' . $k;
                                @endphp
                                <div class="col-md-3 mb30" id="id_{{ $imgID }}">
                                    <div class="thumbnail">
                                        <img alt="Lights" src="{{ asset_uploads($v['url']) }}" style="width:100%">
                                        <div class="myadelbtn">
                                            <a class="btn btn-success" data-bs-toggle="tooltip" data-placement="left"
                                                title="Copy image path" href="javascript:;"
                                                onclick="copyMyTxt('{{ asset_uploads($v['url']) }}');"><i
                                                    class="fas fa-copy" aria-hidden="true"></i></a>
                                            <a class="btn btn-danger" data-bs-toggle="tooltip" data-placement="left"
                                                title="Delete this image" href="javascript:;"
                                                onclick="delete_image('{{ storage_uploads($v['url']) }}','{{ $imgID }}');"><i
                                                    class="fas fa-trash"></i></a>
                                        </div>
                                    </div>
                                    <div class="caption">{{ $v['name'] }}</div>
                                </div>
                            @endforeach
                        </div>
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
                <input style="display: none;" type="text" name="txt_copy22" id="txt_copy22" class="form-control"
                    value="" placeholder="">
                <div class="spinner" id="spinner" style="display: none;">
                    <i class="fas fa-spinner fa-spin" aria-hidden="true"></i><span>Processing ...</span>
                </div>
            </div>
    </div>
    </section>
@endsection('content')
@section('beforeBodyClose')
    <script>
        jQuery(document).ready(function($) {
            $("#left-sidebar").addClass("collapse-left");
            $(".right-side").addClass("strech");
        });
    </script>
@endsection
