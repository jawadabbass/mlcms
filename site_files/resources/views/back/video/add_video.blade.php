@extends('back.layouts.app', ['title' => $title])
@section('content')
    <div class="content-wrapper pl-3 pr-2">
        <section class="content-header">
            <div class="row">
                <div class="col-md-5 col-sm-12">
                    <ol class="breadcrumb">
                        <li><a href="{{ admin_url() }}"> <i class="fas fa-gauge"></i> Home </a></li>
                        <li class="active"><a href="{{ admin_url() }}videos">Videos</a></li>
                        <li class="active">Add</li>
                    </ol>
                </div>
                <div class="col-md-7 col-sm-12"> @include('back.common_views.quicklinks') </div>
            </div>
        </section>
        <section class="content">


            <form method="post" action="{{ admin_url() }}videos/add" enctype="multipart/form-data">
                @csrf
                <div class="row">
                    <div class="col-md-4 text-end">Heading:</div>
                    <div class="col-md-8"><input type="text" name="heading" id="heading" class="form-control"
                            value="" placeholder=""></div>
                </div>
                <br>
                <div class="row">
                    <div class="col-md-4 text-end">Video Type:</div>
                    <div class="col-md-8">
                        <select class="form-control" name="video_type" id="video_type">
                            <option value="Youtube" selected="">YouTube Video</option>
                            <option value="Vimeo">Vimeo Video</option>
                            <option value="upload">Video Upload</option>
                        </select>
                    </div>
                </div>
                <br>
                <div class="row">
                    <div class="col-md-4 text-end"><span id="s_title">Youtube Video:</span> </div>
                    <div class="col-md-8" id="field_type_div">
                        <textarea name="linkk" id="linkk" class="form-control" placeholder="Embed Code Here!"></textarea>
                    </div>
                </div>
                <br>
                <div class="row">
                    <div class="col-md-4 text-end">Short Description:</div>
                    <div class="col-md-8">
                        <textarea name="descp" id="descp" class="form-control"></textarea>
                    </div>
                </div>
                <br>

                <div class="row" id="thumbnail_div" style="display: none;">
                    <div class="col-md-4 text-end">Thumbnail Image:</div>
                    <div class="col-md-8"><input type="file" name="fimg" id="fimg" class="form-control"
                            value="" placeholder=""></div>
                </div>
                <br>
                <div class="row">
                    <div class="col-md-4 text-end"></div>
                    <div class="col-md-8">
                        <button id="submit" type="submit"  class="btn btn-info"
                            onClick="document.getElementsById('submit').display='none'"><i class="fas fa-plus-circle"
                                aria-hidden="true"></i> Submit</button>
                    </div>
                </div>
            </form>


        </section>
    </div>
@endsection
@section('beforeBodyClose')
    <script type="text/javascript">
        
        $("#video_type").change(function(event) {
            console.clear();
            if ($(this).val() != 'upload') {
                $("#thumbnail_div").hide();
                if ($(this).val() == 'Youtube' || $(this).val() == 'Vimeo') {
                    $("#linkk").remove();
                    $("#field_type_div").html(
                        '<textarea name="linkk" id="linkk" class="form-control" placeholder="Embed Code Here!"></textarea>'
                        );
                    $("#s_title").html($(this).val() + " Embed Code:");
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
