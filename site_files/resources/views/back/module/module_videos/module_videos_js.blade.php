<script>
    /****************************************************/
    var cms_module_type = "{{ $module->type }}";
    var cms_module_id = {{ $module->id }};
    var cms_module_data_id = {{ isset($moduleData) ? $moduleData->id : 0 }};
    var session_id = "{{ session()->getId() }}";
    var videoUploadUrl = "{{ admin_url() }}module_video/upload_video";

    $('.upload_video_label').on('click', function() {
        $('#upload_video_div').toggle();
    })

    $("#video_type").change(function(event) {
        console.clear();
        if ($(this).val() != 'Upload') {
            $("#video_thumbnail_div").hide();
            if ($(this).val() == 'Youtube') {
                $("#video_link_embed_code").remove();
                $("#field_type_div").html(
                    '<input type="text" name="video_link_embed_code" id="video_link_embed_code" class="form-control" value="" placeholder="">'
                );
                $("#video_link_embed_code").prop('type', 'text');
                $("#s_title").html($(this).val() + " Link:");
                $("#video_link_embed_code").attr('placeholder', 'https://www.youtube.com/watch?v=C0DPdy98e4c');
            }
            if ($(this).val() == 'Vimeo') {
                $("#video_link_embed_code").remove();
                $("#field_type_div").html(
                    '<input type="text" name="video_link_embed_code" id="video_link_embed_code" class="form-control" value="" placeholder="">'
                );
                $("#video_link_embed_code").prop('type', 'text');
                $("#s_title").html($(this).val() + " Link:");
                $("#video_link_embed_code").attr('placeholder', 'https://vimeo.com/167566292');
            }
            if ($(this).val() == 'Text') {
                $("#video_link_embed_code").remove();
                $("#field_type_div").html(
                    '<textarea name="video_link_embed_code" id="video_link_embed_code" class="form-control"></textarea>'
                );
                $("#video_link_embed_code").prop('type', 'text');
                $("#s_title").html("Write Video");
                $("#video_link_embed_code").attr('placeholder', 'Write Video');
            }
        } else {
            $("#s_title").html(
                "Please select (<code>.mp4</code>) file: <br/><p class=\"text-red\">Maximum allowed size on server: {{ file_upload_max_size() }}MB</p>"
            );
            $("#video_link_embed_code").attr('placeholder', '');
            $("#video_link_embed_code").remove();
            $("#field_type_div").html(
                '<input type="file" name="video_link_embed_code" id="video_link_embed_code" class="form-control" value="" placeholder="">'
            );
            $("#video_link_embed_code").prop('type', 'file');
            $("#video_thumbnail_div").show();
        }
    });

    function uploadModuleVideo() {
        var video_type = $('#video_type').val();
        if ($('#video_link_embed_code').attr('type') == 'file') {
            var video_link_embed_code = $('#video_link_embed_code')[0].files[0];
        } else {
            var video_link_embed_code = $('#video_link_embed_code').val();
        }
        var video_thumb_img = $('#video_thumb_img')[0].files[0];
        var process = true;
        var error_msg = '';

        console.clear();
        console.log($('#video_link_embed_code').attr('type'));
        console.log(video_type);
        console.log(video_link_embed_code);
        console.log(video_thumb_img);

        if (video_type != '') {
            if (video_link_embed_code == null) {
                process = false;
                error_msg += 'Select video<br/>';
            }
            if (video_type == 'Upload') {
                if (video_thumb_img == null) {
                    process = false;
                    error_msg += 'Select video thumb image<br/>';
                }
            }
        } else {
            process = false;
            error_msg += 'Select video type<br/>';
        }
        if (process) {
            $('#upload_video_div').hide();
            $('#upload_video_loader_div').show();
            var data_form = new FormData();
            data_form.append("post_slug", $('#slug_field').val());
            data_form.append("session_id", session_id);
            data_form.append("moduleId", cms_module_id);
            data_form.append("moduleDataId", cms_module_data_id);
            data_form.append("video_type", video_type);
            data_form.append("video_link_embed_code", video_link_embed_code);
            data_form.append("video_thumb_img", video_thumb_img);
            data_form.append("_token", '{{ csrf_token() }}');
            $.ajax({
                url: videoUploadUrl,
                type: "POST",
                data: data_form,
                processData: false,
                contentType: false,
                dataType: "json",
                cache: false,
                success: function(response) {
                    $('#module_videos_div').append(response.html);
                    $('#upload_video_loader_div').hide();
                    $('#upload_video_div').show();
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    $('#upload_video_loader_div').hide();
                    $('#upload_video_div').show();
                    console.log(jqXHR);
                    console.log(textStatus);
                    console.log(errorThrown);
                    alert('Error adding / update data');
                }
            });
        } else {
            swal('Error!', error_msg, 'error');
        }
    }

    function remove_module_video(id) {
        if (confirm("Are you sure you want to delete this Video?")) {
            url = "{{ base_url() }}adminmedia/module_video/remove_video";
            $.ajax({
                url: url,
                data: {
                    id: id,
                    _token: '{{ csrf_token() }}'
                },
                type: "POST",
                success: function(data) {
                    $('#module_video_' + id).remove();
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    console.log(jqXHR);
                    console.log(textStatus);
                    console.log(errorThrown);
                    alert('Error adding / update data');
                }
            });
        }
    }
</script>
