<script>
    /****************************************************/
    var cms_module_type = "{{ $module->type }}";
    var cms_module_id = {{ $module->id }};
    var cms_module_data_id = {{ isset($moduleData) ? $moduleData->id : 0 }};
    var session_id = "{{ session()->getId() }}";
    var uploadMoreUrl = "{{ admin_url() }}module_image/upload_more_images";


    $(document).ready(function() {
        $('.sortable_row').sortable({
            opacity: 1,
            handle: '.sortable_div',
            update: function(event, ui) {
                console.log(event);
                var list_sortable = $(this).sortable('toArray').toString();
                $.ajax({
                    url: "{{ url('/adminmedia/module_image/order') }}",
                    type: 'POST',
                    data: {
                        list_order: list_sortable,
                        _token: '{{ csrf_token() }}'
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
        });
    });

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
                    alert('Error adding / update data ' + ' ' + textStatus + ' ' + errorThrown);
                }
            });
        }
    }

    function uploadModuleDataImages() {
        var total_files = document.getElementById("uploadFile").files.length;
        var image_name = '';
        var image_name2 = '';

        if ($('#image_name').length > 0) {
            var image_name = $('#image_name').prop('files')[0];
        }
        if ($('#image_name2').length > 0) {
            var image_name2 = $('#image_name2').prop('files')[0];
        }
        var isBeforeAfter = 0;
        if ($('#isBeforeAfter').is(":checked")) {
            isBeforeAfter = 1;
        }
        var isBeforeAfterHaveTwoImages = $('input[name="isBeforeAfterHaveTwoImages"]:checked').val();

        console.log(total_files);
        console.log(image_name);
        console.log(image_name2);
        console.log(isBeforeAfter);
        console.log(isBeforeAfterHaveTwoImages);

        if (
            (total_files > 0) ||
            (
                (($('#image_name').length > 0) && ($('#image_name').val() != '')) &&
                (($('#image_name2').length > 0) && ($('#image_name2').val() != ''))
            )
        ) {
            $('#moreImageLoader').show();
            $('#btnSave').attr('disabled', true);
            let formData = new FormData();
            formData.append("_token", csrfToken);
            formData.append("folder", folder);
            formData.append("module_type", cms_module_type);
            formData.append("module_id", cms_module_id);
            formData.append("module_data_id", cms_module_data_id);
            formData.append("session_id", session_id);
            formData.append("isBeforeAfter", isBeforeAfter);
            formData.append("isBeforeAfterHaveTwoImages", isBeforeAfterHaveTwoImages);
            formData.append("image_name", image_name);
            formData.append("image_name2", image_name2);
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
                    alert('Error adding / update data ' + ' ' + textStatus + ' ' + errorThrown);
                }
            });
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
            data: {
                image_id: image_id,
                _token: '{{ csrf_token() }}'
            },
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

    function bind_cropper_preview_module_data_image(image_id, image_1_2) {
        $('#module_data_image_crop_form').find('#image_id').val(image_id);
        let image_name = $('#image_' + image_1_2 + '_' + image_id).attr('data-imgname');
        let path = '{{ asset_uploads('') }}' + folder + '/';
        $('#module_data_image_crop_form').find('#image').attr('src', path + '/' + image_name);
        $('#module_data_image_crop_form').find('#source_image').val(image_name);
        $('#module_data_image_crop_form').find('#image_1_2').val(image_1_2);
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
            autoCropArea: 0.5,
            viewMode: 1,
            dragMode: 'crop',
            guides: true,
            restore: true,
            highlight: true,
            movable: false,
            zoomable: false,
            cropBoxMovable: true,
            cropBoxResizable: false,
            aspectRatio: 1,
            minCropBoxWidth: 400,
            minCropBoxHeight: 300,
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
        let image_1_2 = $('#module_data_image_crop_form').find('#image_1_2').val();
        $.ajax({
            url: "{{ admin_url() . 'save_module_data_image_crop_image' }}",
            type: "POST",
            dataType: "JSON",
            data: $('#module_data_image_crop_form').serialize(),
            success: function(data) {
                console.log(data.cropped_image);
                $('#image_' + image_1_2 + '_' + image_id).attr('src', asset_uploads + folder + '/thumb/' +
                    data.cropped_image);
                $('#image_' + image_1_2 + '_' + image_id).attr('data-imgname', data.cropped_image);
                $('#module_data_image_crop_form').find('#image').attr('src', '');
                $('#module_data_image_crop_form').find('#source_image').val('');
                $('#module_data_image_cropper_form').modal('hide');
            },
            error: function(jqXHR, textStatus, errorThrown) {}
        });
    }

    function markBeforeAfter(id, elem) {
        $.ajax({
            url: "{{ url('/adminmedia/saveModuleDataImagesMarkBeforeAfter') }}",
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
