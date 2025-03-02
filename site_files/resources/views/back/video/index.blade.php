@extends('back.layouts.app', ['title' => $title])
@section('beforeHeadClose')
    @include('back.common_views.switch_css')
@endsection
@section('content')
    <div class="pl-3 pr-2 content-wrapper">
        <section class="content-header">
            <div class="row">
                <div class="col-md-5 col-sm-12">
                    <ol class="breadcrumb">
                        <li><a href="{{ admin_url() }}"><i class="fas fa-gauge"></i> Home</a></li>
                        <li class="active">Video Management</li>
                    </ol>
                </div>
                <div class="col-md-7 col-sm-12"> @include('back.common_views.quicklinks') </div>
            </div>
        </section>
        <!-- Main content -->
        <section class="content">
            <div class="row">
                <div class="col-xs-12 col-md-12">
                    <div class="p-2 card">
                        <div class="row">
                            <div class="col-sm-8">
                                <h3 class=" card-title">All Videos</h3>
                            </div>
                            <div class="col-sm-4">
                                <div class="text-end" style="padding-bottom:2px;">
                                    <a href="{{ admin_url() }}videos/add" class="btn btn-info">Add New Videos</a>
                                </div>
                            </div>
                        </div>
                        <div class=" card-body table-responsive">
                            <table id="example2" class="table table-bordered table-hover">
                                <thead>
                                    <tr>
                                        <th>Added Date</th>
                                        <th>Video</th>
                                        <th>Status</th>
                                        <th>Action</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody id="sortable">
                                    @if ($result)
                                        @foreach ($result as $row)
                                            <tr id="{{ $row->id }}" class="row_{{ $row->id }}">
                                                <td>{{ format_date($row->dated, 'date') }}</td>
                                                <td>
                                                    {{ $row->heading }}<br/><br/>
                                                    {!! showUploadedVideo(adjustUrl($row->content), $row->video_type, '100%', 300, 'd-block', 'uploads/videos/video/') !!}
                                                </td>
                                                <td>
                                                        <label class="switch">
                                                            <input type="checkbox" name="{{ 'sts_' . $row->id }}"
                                                                id="{{ 'sts_' . $row->id }}" <?php echo $row->sts == 1 ? ' checked' : ''; ?>
                                                                value="<?php echo $row->sts; ?>"
                                                                onClick="update_videos_sts({{ $row->id }})">
                                                            <div class="slider round">
                                                                <strong class="on">Active</strong>
                                                                <strong class="off">Inactive</strong>
                                                            </div>
                                                        </label>
                                                    </td>
                                                <td>
                                                    <a href="{{ admin_url() }}videos/edit/{{ $row->id }}"
                                                        class="btn btn-success btn-sm">Edit</a>
                                                        <a href="javascript:delete_videos({{ $row->id }});"
                                                            class="btn btn-danger btn-sm">Delete</a>                                                        
                                                </td>
                                                <td align="center">
                                                    <span></span>
                                                </td>
                                            </tr>
                                        @endforeach
                                    @else
                                        <tr>
                                            <td colspan="6" align="center" class="text-red">No Record found!</td>
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
            <div> {{ $result->links() }} </div>
        </section>
    </div>
    <div class="modal fade" id="add_page_form" data-backdrop="static">
        <div class="modal-dialog modal-lg">
            <form name="frm_block" id="frm_block" role="form" method="post" action="{{ admin_url() . 'videos' }}"
                enctype="multipart/form-data">
                @csrf
                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">Add New Video</h4>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">

                        </button>
                    </div>
                    <div class="modal-body">
                        <!-- /.box-header -->
                        <div class=" card-body">
                            <div class="mb-2">
                                <label class="form-label">Video Heading</label>
                                <textarea class="form-control" id="heading" name="heading" placeholder="Video Heading">{{ old('heading') }}</textarea>
                            </div>
                            <div class="mb-2">
                                <label class="form-label">Short description</label>
                                <textarea class="form-control" id="short_detail" name="short_detail" placeholder="Short Description">{{ old('short_detail') }}</textarea>
                            </div>
                            <strong><input type="radio" name="add_video_type" id="add_video_type" value="code"
                                    onclick="showVideoTypeDivAdd()"> Embed Code</strong>
                            <br />
                            <strong><input type="radio" name="add_video_type" id="add_video_type" value="upload"
                                    onclick="showVideoTypeDivAdd()"> Upload Video (Max:
                                <code>{{ file_upload_max_size() }}MB</code>)</strong>

                            <hr>
                            <div class="mb-2" style="display: none;" id="add_type_code">
                                <label class="form-label">Video Embed Code</label>
                                <textarea id="content" class="form-control" name="contents" rows="8" cols="76"
                                    placeholder="Add embed Ifram">{{ old('content') }}</textarea>
                            </div>
                            <div class="mb-2" style="display: none;" id="add_type_upload">
                                <label class="form-label">Upload Video(<code>mp4</code>)</label>
                                <input type="file" name="add_uplad_video" id="add_uplad_video">
                                <br><br>
                                <label class="form-label">Video Thumbnail Image</label>
                                <input type="file" name="video_img" id="video_img">
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <div class="loader_div" id="loader_div" style="display: none;"><img
                                src="{{ asset_storage('back/images/loader.gif') }}" alt=""></div>
                        <button type="button" id="close_btn" class="btn btn-default"
                            data-bs-dismiss="modal">Close</button>
                        <button type="submit"  name="submitter" class="btn btn-primary"
                            onclick="this.style.display = 'none';document.getElementById('close_btn').style.display='none';document.getElementById('loader_div').style.display='block'">Submit</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <div class="modal fade" id="edit_page_form" data-backdrop="static">
        <div class="modal-dialog modal-lg">
            <form name="frm_block" id="edit_frm_block" role="form" method="post"
                action="{{ route('videos.update', 0) }}" onSubmit="return(this)">
                @csrf
                <input type="hidden" name="_method" value="PUT">
                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">Edit Video</h4>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">

                        </button>
                    </div>
                    <div class="modal-body">
                        <div class=" card-body">
                            <div class="mb-2">
                                <label class="form-label">Video Heading</label>
                                <textarea class="form-control" id="edit_heading" name="edit_heading" placeholder="Video Heading">{{ old('heading') }}</textarea>
                            </div>
                            <div class="mb-2">
                                <label class="form-label">Short description</label>
                                <textarea class="form-control" id="edit_short_detail" name="short_detail" placeholder="Short Description">{{ old('short_detail') }}</textarea>
                            </div>
                            {{-- <div class="mb-2"> --}}
                            {{-- <input type="hidden" class="form-control" name="slug" id="edit_video_slug" --}}
                            {{-- value="{{ old('slug') }}" placeholder="video Slug"> --}}
                            {{-- </div> --}}
                            <strong><input type="radio" name="video_type" id="code_video_type" value="code"
                                    onclick="showVideoTypeDiv()"> Embed Code</strong>
                            <br />
                            <strong><input type="radio" name="video_type" id="upload_video_type" value="upload"
                                    onclick="showVideoTypeDiv()"> Upload Video</strong>

                            <hr>
                            <div class="mb-2" id="type_code" style="display: none">
                                <label class="form-label">Video Embed Code</label>
                                <textarea id="edit_content" class="form-control" name="edit_content" rows="8" cols="70"
                                    placeholder="Add embed Ifram">{{ old('content') }}</textarea>
                            </div>
                            <div class="mb-2" id="type_upload" style="display: none">
                                <label class="form-label">Video Embed Code</label>
                                <input type="file" name="video" id="video" class="form-control">
                            </div>
                            <input type="hidden" name="video_id" id="video_id" />
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-default" data-bs-dismiss="modal">Close</button>
                            <button type="submit"  name="submitter" class="btn btn-primary">Update</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection
@section('beforeBodyClose')
    <script type="text/javascript">
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
                        url: base_url + 'adminmedia/videos/ordering-set/',
                        type: 'GET',
                        data: {
                            list_order: list_sortable
                        },
                        success: function(data) {
                            console.log(data);
                        },
                        error: function(jqXHR, textStatus, errorThrown) {
                            alert('Error adding / update data ' + ' ' + textStatus + ' ' + errorThrown);
                            console.log(jqXHR);
                            console.log(textStatus);
                            console.log(errorThrown);
                        }
                    });
                }
            }); // fin sortable
        });

        $(document).ready(function(e) {
            $("#heading").change(function() {
                string_to_slug('heading', 'video_slug');
            });
            $("#video_slug").change(function() {
                check_slug('video_slug');
            });
            @if ($errors->any())
                load_video_add_form();
            @endif
        });

        function showVideoTypeDiv() {
            var radioValue = $("input[name='video_type']:checked").val();
            console.log("#type_" + radioValue);
            $("#type_code").hide();
            $("#type_upload").hide();
            $("#type_" + radioValue).show();
        }

        function showVideoTypeDivAdd() {
            var radioValue = $("input[name='add_video_type']:checked").val();
            console.log("#type_" + radioValue);
            $("#add_type_code").hide();
            $("#add_type_upload").hide();
            $("#add_type_" + radioValue).show();
        }
    </script>
    <script type="text/javascript" src="{{ asset_storage('') . 'module/videos/admin/js/videos.js' }}"></script>
@endsection
