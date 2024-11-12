@extends('back.layouts.app', ['title' => $title])
@section('content')
    <div class="content-wrapper pl-3 pr-2">
        <section class="content-header">
            <div class="row">
                <div class="col-md-5 col-sm-12">
                    <ol class="breadcrumb">
                        <li><a href="{{ admin_url() }}"> <i class="fas fa-gauge"></i> Home </a></li>
                        <li class="active"><a href="{{ admin_url() }}videos">Videos</a></li>
                        <li class="active">Edit</li>
                    </ol>
                </div>
                <div class="col-md-7 col-sm-12"> @include('back.common_views.quicklinks') </div>
            </div>
        </section>
        <section class="content">
            <div class="card p-3">
                <div class="card-header">
                    <div class="row">
                        <div class="col-md-6">
                            <h3>Edit Video</h3>
                        </div>
                        <div class="col-md-6 text-right">
                            <a href="{{ url('adminmedia/record-update-history/Video/' . $rec->ID) }}"
                                target="_blank" class=""><i class="fas fa-bars" aria-hidden="true"></i>
                                History
                            </a>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    @include('flash::message')
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form method="post" action="{{ admin_url() }}videos/edit" enctype="multipart/form-data">
                        @csrf
                        <div class="row">
                            <div class="col-md-4 text-end">Heading:</div>
                            <div class="col-md-8"><input type="text" name="heading" id="heading" class="form-control"
                                    value="{{ $rec->heading }}" placeholder=""></div>
                        </div>
                        <br>
                        <div class="row">
                            <div class="col-md-4 text-end">Video Type:</div>
                            <div class="col-md-8">
                                <select class="form-control" name="video_type" id="video_type">
                                    <option value="Youtube">YouTube Video</option>
                                    <option value="Vimeo">Vimeo Video</option>
                                    <option value="upload">Video Upload</option>
                                </select>
                            </div>
                        </div>
                        <br>
                        <div class="row">
                            <div class="col-md-4 text-end"><span id="s_title">Youtube:</span> </div>
                            <div class="col-md-8" id="field_type_div">
                                <textarea name="linkk" id="linkk" class="form-control" placeholder="Embed Code Here!">{!! adjustUrl($rec->content) !!}</textarea>
                            </div>
                        </div>
                        <br>
                        <div class="row">
                            <div class="col-md-4 text-end">Short Description:</div>
                            <div class="col-md-8">
                                <textarea name="descp" id="descp" class="form-control">{{ $rec->short_detail }}</textarea>
                            </div>
                        </div>
                        <br>
                        <div class="row">
                            <div class="col-md-4 text-end">Featured Image:</div>
                            <div class="col-md-8"><input type="file" name="fimg" id="fimg" class="form-control"
                                    value="" placeholder=""></div>
                        </div>
                        <div class="row mt-3" id="thumbnail_div">
                            <div class="offset-md-4 col-md-8">
                                @if ($rec->video_img != '')
                                    <img class="img" width=""
                                        src="{{ asset_uploads('') }}videos/thumb/{{ $rec->video_img }}" alt="">
                                @endif
                            </div>
                        </div>
                        <br>
                        <div class="row">
                            <div class="col-md-4 text-end"></div>
                            <div class="col-md-8">
                                <input type="hidden" name="idd" id="idd" value="{{ $rec->ID }}">
                                <div id="old_content" style="display: none;">{!! adjustUrl($rec->content) !!}</div>
                                <p id="old_type" style="display: none;">{{ $rec->additional_field_4 }}</p>
                                <button id="submit" type="submit" class="btn btn-info"
                                    onClick="document.getElementsById('submit').display='none'"><i
                                        class="fas fa-pen-to-square" aria-hidden="true"></i> Update</button>
                            </div>
                        </div>
                    </form>

                </div>
        </section>
    </div>
@endsection
@section('beforeBodyClose')
    <script type="text/javascript">
        $(document).ready(function() {
            $("#video_type").val('{{ $rec->video_type }}');
            var cval = '{{ $rec->video_type }}';
            if (cval != 'upload') {

                if (cval == 'Youtube' || cval == 'Vimeo') {
                    $("#linkk").remove();
                    $("#field_type_div").html(
                        '<textarea name="linkk" id="linkk" class="form-control" placeholder="Embed Code Here!"></textarea>'
                    );
                    $("#s_title").html(cval + " Embed Code:");
                    $("#linkk").val($("#old_content").html());
                }
            } else {
                $("#s_title").html(
                    "Please select (<code>.mp4</code>) file: <br/><p class=\"text-red\">Maximum allowed size on server: {{ $file_upload_max_size }}MB</p>"
                );
                $("#linkk").attr('placeholder', '');
                $("#linkk").remove();
                $("#field_type_div").html(
                    '<input type="file" name="linkk" id="linkk" class="form-control" value="" placeholder="">');
                $("#linkk").prop('type', 'file');
            }

        });

        $("#video_type").change(function(event) {
            if ($(this).val() != 'upload') {
                $("#thumbnail_div").hide();

                if ($(this).val() == 'Youtube' || $(this).val() == 'Vimeo') {
                    $("#linkk").remove();
                    $("#field_type_div").html(
                        '<textarea name="linkk" id="linkk" class="form-control" placeholder="Embed Code Here!"></textarea>'
                    );
                    $("#s_title").html($(this).val() + " Embed Code:");
                    if ($(this).val() == $("#old_type").html()) {
                        $("#linkk").val($("#old_content").html());
                    }
                }
            } else {
                $("#s_title").html(
                    "Please select (<code>.mp4</code>) file: <br/><p class=\"text-red\">Maximum allowed size on server: {{ $file_upload_max_size }}MB</p>"
                );
                $("#linkk").attr('placeholder', '');
                $("#linkk").remove();
                $("#field_type_div").html(
                    '<input type="file" name="linkk" id="linkk" class="form-control" value="" placeholder="">');
                $("#linkk").prop('type', 'file');
                $("#thumbnail_div").show();
            }
        });
    </script>
@endsection
