<script>
    /****************************************************/
    var cms_module_type = "{{ $module->type }}";
    var cms_module_id = {{ $module->id }};
    var cms_module_data_id = {{ isset($moduleData)? $moduleData->id:0 }};
    var session_id = "{{ session()->getId() }}";
    var uploadMoreUrl = "{{ admin_url() }}module_image/upload_more_images";



    $('.more_images_label').on('click', function() {
        $('.more_images').toggle();
    })

    function deleteModuleDataImage(imageId, file_name) {
        if (confirm("Are you sure?")) {
            let formData = new FormData();
            formData.append("_token", csrfToken);
            formData.append("folder", folder);
            formData.append("file_name", file_name);
            formData.append("module_data_image_id", imageId);
            $.ajax({
                url: deleteUrl,
                type: "POST",
                data: formData,
                processData: false,
                contentType: false,
                success: function(response) {
                    $('#more_image_' + imageId).remove();
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

    function uploadModuleDataImages() {
        var total_files = document.getElementById("uploadFile").files.length;
        if (total_files > 0) {
            $('#moreImageLoader').show();
            $('#btnSave').attr('disabled', true);
            let formData = new FormData();
            formData.append("_token", csrfToken);
            formData.append("folder", folder);
            formData.append("module_type", cms_module_type);
            formData.append("module_id", cms_module_id);
            formData.append("module_data_id", cms_module_data_id);
            formData.append("session_id", session_id);
            $.each($("#uploadFile")[0].files, function(i, file) {
                formData.append('uploadFile[]', file);
            });
            $.ajax({
                url: uploadMoreUrl,
                type: "POST",
                data: formData,
                processData: false,
                contentType: false,
                dataType: "json",
                success: function(response) {
                    $('#moreImages').append(response.html);
                    $('#btnSave').attr('disabled', false);
                    $('#moreImageLoader').hide();
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    console.log(jqXHR);
                    console.log(textStatus);
                    console.log(errorThrown);
                    alert('Error adding / update data');
                }
            });
        } else {
            alert('Please select images');
        }
    }

    function openModuleDataImageZoomModal(url) {
        $('#moduleDataImageZoomImage').attr('src', url);
        $('#moduleDataImageZoomModal').modal('show');
    }

    function openModuleDataImageAltTitleModal(image_id) {
        $.ajax({
            url: "{{ admin_url() . 'getModuleDataImageAltTitle' }}",
            type: "POST",
            dataType: "JSON",
            data: {image_id:image_id, _token: '{{ csrf_token() }}'},
            success: function(data) {
                $('#moduleDataImageAltTitleForm').find('#image_id').val(image_id);
                $('#moduleDataImageAltTitleForm').find('#image_alt').val(data.image_alt);
                $('#moduleDataImageAltTitleForm').find('#image_title').val(data.image_title);
                $('#moduleDataImageAltTitleModal').modal('show');
            },
            error: function(jqXHR, textStatus, errorThrown) {}
        });
    }

    function saveModuleDataImageAltTitle() {
        $.ajax({
            url: "{{ admin_url() . 'saveModuleDataImageAltTitle' }}",
            type: "POST",
            dataType: "JSON",
            data: $('#moduleDataImageAltTitleForm').serialize(),
            success: function(data) {
                $('#moduleDataImageAltTitleModal').modal('hide');
            },
            error: function(jqXHR, textStatus, errorThrown) {}
        });
    }

    function bind_cropper_preview_module_data_image(image_id) {
        $('#module_data_image_crop_form').find('#image_id').val(image_id);
        let image_name = $('#image_' + image_id).attr('data-imgname');
        let path = '{{ base_url() }}uploads/'+folder+'/';
        $('#module_data_image_crop_form').find('#image').attr('src', path + '/' + image_name);
        $('#module_data_image_crop_form').find('#source_image').val(image_name);
        $('#module_data_image_cropper_form').modal('show');
    }
    $('#module_data_image_cropper_form').on('hidden.bs.modal', function() {
        var $image = $('#module_data_image_crop_form').find('#image');
        $image.cropper('destroy');
    });
    $('#module_data_image_cropper_form').on('shown.bs.modal', function() {
        var $image = $('#module_data_image_crop_form').find('#image');
        var cropBoxData;
        var canvasData;
        $image.cropper({
            autoCropArea: 0.75,
            viewMode: 1,
            dragMode: 'crop',
            guides: true,
            restore: true,
            highlight: true,
            movable: false,
            zoomable: false,
            cropBoxMovable: true,
            cropBoxResizable: true,
            /* aspectRatio: 1, */
            minCropBoxWidth: 10,
            minCropBoxHeight: 10,
            ready: function() {
                $image.cropper('setCanvasData', canvasData);
                $image.cropper('setCropBoxData', cropBoxData);
            },
            crop: function(e) {
                var imageData = $(this).cropper('getImageData');
                $('#module_data_image_crop_form').find('#crop_x').val(e.x);
                $('#module_data_image_crop_form').find('#crop_y').val(e.y);
                $('#module_data_image_crop_form').find('#crop_height').val(e.height);
                $('#module_data_image_crop_form').find('#crop_width').val(e.width);
                $('#module_data_image_crop_form').find('#crop_rotate').val(e.rotate);
            }
        });
    });

    function save_module_data_cropped_img() {
        let image_id = $('#module_data_image_crop_form').find('#image_id').val();
        $.ajax({
            url: "{{ admin_url() . 'save_module_data_image_crop_image' }}",
            type: "POST",
            dataType: "JSON",
            data: $('#module_data_image_crop_form').serialize(),
            success: function(data) {
                console.log(data.cropped_image);
                $('#image_' + image_id).attr('src', base_url + 'uploads/' + folder +
                    '/thumb/' + data.cropped_image);
                $('#image_' + image_id).attr('data-imgname', data.cropped_image);
                $('#module_data_image_crop_form').find('#image').attr('src', '');
                $('#module_data_image_crop_form').find('#source_image').val('');
                $('#module_data_image_cropper_form').modal('hide');
            },
            error: function(jqXHR, textStatus, errorThrown) {}
        });
    }
</script>