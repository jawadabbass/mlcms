<script>
    /****************************************************/
    var session_id = "{{ session()->getId() }}";
    var folder = "services";
    var service_id = "{{ $serviceObj->id }}";
    var uploadServiceExtraImagesUrl = "{{ admin_url() }}uploadServicesExtraImages";
    var deleteServiceExtraImageUrl = "{{ admin_url() }}removeServiceExtraImage";
    var csrfToken = "{{ csrf_token() }}";

    $(document).ready(function() {
        $('.service_extra_images_sortable_row').sortable({
            opacity: 1,
            handle: '.service_extra_images_sortable_div',
            update: function(event, ui) {
                console.log(event);
                var list_sortable = $(this).sortable('toArray').toString();
                $.ajax({
                    url: "{{ url('/adminmedia/saveServiceExtraImagesSortOrder') }}",
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

    function deleteServiceExtraImage(imageId, file_name) {
        if (confirm("Are you sure?")) {
            let formData = new FormData();
            formData.append("_token", csrfToken);
            formData.append("folder", folder);
            formData.append("file_name", file_name);
            formData.append("service_extra_image_id", imageId);
            $.ajax({
                url: deleteServiceExtraImageUrl,
                type: "POST",
                data: formData,
                processData: false,
                contentType: false,
                success: function(response) {
                    $('#service_extra_image_' + imageId).remove();
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

    function uploadServiceExtraImages() {
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
            $('#service_extraImageLoader').show();
            $('#btnSave').attr('disabled', true);
            let formData = new FormData();
            formData.append("_token", csrfToken);
            formData.append("folder", folder);
            formData.append("service_id", service_id);
            formData.append("session_id", session_id);
            formData.append("isBeforeAfter", isBeforeAfter);
            formData.append("isBeforeAfterHaveTwoImages", isBeforeAfterHaveTwoImages);
            formData.append("image_name", image_name);
            formData.append("image_name2", image_name2);
            $.each($("#uploadFile")[0].files, function(i, file) {
                formData.append('uploadFile[]', file);
            });
            $.ajax({
                url: uploadServiceExtraImagesUrl,
                type: "POST",
                data: formData,
                processData: false,
                contentType: false,
                dataType: "json",
                success: function(response) {
                    $('#service_extraImages').append(response.html);
                    $('#btnSave').attr('disabled', false);
                    $('#service_extraImageLoader').hide();
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

    function openServiceExtraImageZoomModal(url) {
        $('#serviceExtraImageZoomImage').attr('src', url);
        $('#serviceExtraImageZoomModal').modal('show');
    }

    function openServiceExtraImageAltTitleModal(image_id) {
        $.ajax({
            url: "{{ admin_url() . 'getServiceExtraImageAltTitle' }}",
            type: "POST",
            dataType: "JSON",
            data: {
                image_id: image_id,
                _token: '{{ csrf_token() }}'
            },
            success: function(data) {
                $('#serviceExtraImageAltTitleForm').find('#image_id').val(image_id);
                $('#serviceExtraImageAltTitleForm').find('#image_alt').val(data.image_alt);
                $('#serviceExtraImageAltTitleForm').find('#image_title').val(data.image_title);
                $('#serviceExtraImageAltTitleModal').modal('show');
            },
            error: function(jqXHR, textStatus, errorThrown) {}
        });
    }

    function saveServiceExtraImageAltTitle() {
        $.ajax({
            url: "{{ admin_url() . 'saveServiceExtraImageAltTitle' }}",
            type: "POST",
            dataType: "JSON",
            data: $('#serviceExtraImageAltTitleForm').serialize(),
            success: function(data) {
                $('#serviceExtraImageAltTitleModal').modal('hide');
            },
            error: function(jqXHR, textStatus, errorThrown) {}
        });
    }

    function bind_cropper_preview_service_extra_image(image_id, image_1_2) {
        $('#service_extra_image_crop_form').find('#image_id').val(image_id);
        let image_name = $('#image_' + image_1_2 + '_' + image_id).attr('data-imgname');
        let path = '{{ asset_uploads('') }}' + folder + '/';
        $('#service_extra_image_crop_form').find('#image').attr('src', path + '/' + image_name);
        $('#service_extra_image_crop_form').find('#source_image').val(image_name);
        $('#service_extra_image_crop_form').find('#image_1_2').val(image_1_2);
        $('#service_extra_image_cropper_form').modal('show');
    }
    $(document).on('hidden.bs.modal', '#service_extra_image_cropper_form', function() {
        var $image = $('#service_extra_image_crop_form').find('#image');
        $image.cropper('destroy');
    });
    $(document).on('show.bs.modal', '#service_extra_image_cropper_form', function() {

        setTimeout(() => {
            var $image = $('#service_extra_image_crop_form').find('#image');
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
            cropBoxResizable: true,
            //aspectRatio: 1,
            minCropBoxWidth: 400,
            minCropBoxHeight: 300,
            ready: function() {
                $image.cropper('setCanvasData', canvasData);
                $image.cropper('setCropBoxData', cropBoxData);
            },
            crop: function(e) {
                var imageData = $(this).cropper('getImageData');
                $('#service_extra_image_crop_form').find('#crop_x').val(e.x);
                $('#service_extra_image_crop_form').find('#crop_y').val(e.y);
                $('#service_extra_image_crop_form').find('#crop_height').val(e.height);
                $('#service_extra_image_crop_form').find('#crop_width').val(e.width);
                $('#service_extra_image_crop_form').find('#crop_rotate').val(e.rotate);
            }
        });
        }, 500);
    });

    function save_service_extra_cropped_img() {
        let image_id = $('#service_extra_image_crop_form').find('#image_id').val();
        let image_1_2 = $('#service_extra_image_crop_form').find('#image_1_2').val();
        $.ajax({
            url: "{{ admin_url() . 'saveServiceExtraImageCropImage' }}",
            type: "POST",
            dataType: "JSON",
            data: $('#service_extra_image_crop_form').serialize(),
            success: function(data) {
                console.log(data.cropped_image);
                $('#image_' + image_1_2 + '_' + image_id).attr('src', asset_uploads + folder + '/thumb/' +
                    data.cropped_image);
                $('#image_' + image_1_2 + '_' + image_id).attr('data-imgname', data.cropped_image);
                $('#service_extra_image_crop_form').find('#image').attr('src', '');
                $('#service_extra_image_crop_form').find('#source_image').val('');
                $('#service_extra_image_cropper_form').modal('hide');
            },
            error: function(jqXHR, textStatus, errorThrown) {}
        });
    }

    function markServiceExtraImageBeforeAfter(id, elem) {
        $.ajax({
            url: "{{ url('/adminmedia/saveServiceExtraImagesMarkBeforeAfter') }}",
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

    function show_service_extra_image_before_after_have_two_images() {
        $('.before_after_have_two_images').show();
        $('.before_after_not_have_two_images').hide();
    }

    function hide_service_extra_image_before_after_have_two_images() {
        $('.before_after_have_two_images').hide();
        $('.before_after_not_have_two_images').show();
    }

    function toggle_service_extra_image_before_after_have_two_images() {
        if ($('#isBeforeAfter').is(':checked')) {
            $('#is_before_after_have_two_images').show();
            if ($("[name='isBeforeAfterHaveTwoImages']:checked").val() == 1) {
                show_service_extra_image_before_after_have_two_images();
            }
        } else {
            $('#is_before_after_have_two_images').hide();
            hide_service_extra_image_before_after_have_two_images();
        }
    }
    @if (old('isBeforeAfter', 0) == 1)
        $('#is_before_after_have_two_images').show();
    @endif
    @if (old('isBeforeAfterHaveTwoImages', 0) == 1)
        show_service_extra_image_before_after_have_two_images();
    @endif
</script>
