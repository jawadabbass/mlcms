@extends('back.layouts.app', ['title' => $title])
@section('content')
    <div class="content-wrapper pl-3 pr-2">
        <section class="content-header">
            <div class="row">
                <div class="col-md-5 col-sm-12 jawadcls">
                    <ol class="breadcrumb">
                        <li><a href="{{ admin_url() }}"> <i class="fas fa-gauge"></i> Home </a></li>
                        <li class="active"><a href="{{ admin_url() }}videos">Videos</a></li>
                        <li class="active">Add</li>
                    </ol>
                </div>
                <div class="col-md-7 col-sm-12 jawadcls"> @include('back.common_views.quicklinks') </div>
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
                        <select class="form-control" name="testimonial_type" id="testimonial_type">
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
                        <input type="text" name="linkk" id="linkk" class="form-control" value=""
                            placeholder="https://www.youtube.com/watch?v=C0DPdy98e4c">
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
                        <button id="submit" type="submit" class="btn btn-info"
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
        
        $("#testimonial_type").change(function(event) {
            console.clear();
            if ($(this).val() != 'upload') {
                $("#thumbnail_div").hide();
                if ($(this).val() == 'Youtube') {
                    $("#linkk").remove();
                    $("#field_type_div").html(
                        '<input type="text" name="linkk" id="linkk" class="form-control" value="" placeholder="">'
                        );
                    $("#linkk").prop('type', 'text');
                    $("#s_title").html($(this).val() + " Link:");
                    $("#linkk").attr('placeholder', 'https://www.youtube.com/watch?v=C0DPdy98e4c');
                }
                if ($(this).val() == 'Vimeo') {
                    $("#linkk").remove();
                    $("#field_type_div").html(
                        '<input type="text" name="linkk" id="linkk" class="form-control" value="" placeholder="">'
                        );
                    $("#linkk").prop('type', 'text');
                    $("#s_title").html($(this).val() + " Link:");
                    $("#linkk").attr('placeholder', 'https://vimeo.com/167566292');
                }
                if ($(this).val() == 'Text') {
                    $("#linkk").remove();
                    $("#field_type_div").html('<textarea name="linkk" id="linkk" class="form-control"></textarea>');
                    $("#linkk").prop('type', 'text');
                    $("#s_title").html("Write Video");
                    $("#linkk").attr('placeholder', 'Write Video');
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
