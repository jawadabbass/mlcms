<script type="text/javascript">
    var save_method; //for save method string
    var table;
    $(document).ready(function() {
        additional_fields({{ ucwords($module->additional_fields) }});
    });

    function bind_cropper_preview() {
        var $previews = $('.preview');
        var $image = $('#image');
        var cropBoxData;
        var canvasData;
        $('#cropper_form').on('shown.bs.modal', function() {
            $image.cropper({
                autoCropArea: 0.5,
                viewMode: 1,
                dragMode: 'move',
                guides: false,
                restore: false,
                highlight: false,
                cropBoxMovable: true,
                cropBoxResizable: false,
                aspectRatio: {{ $module->feature_img_thmb_width }} /
                    {{ $module->feature_img_thmb_height }},
                minCropBoxWidth: {{ $module->feature_img_thmb_width }},
                minCropBoxHeight: {{ $module->feature_img_thmb_height }},
                ready: function() {
                    var $clone = $(this).clone().removeClass('cropper-hidden');
                    $clone.css({
                        display: 'block',
                        width: '100%',
                        minWidth: 0,
                        minHeight: 0,
                        maxWidth: 'none',
                        maxHeight: 'none'
                    });
                    $previews.css({
                        width: '100%',
                        overflow: 'hidden'
                    }).html($clone);
                    $image.cropper('setCanvasData', canvasData);
                    $image.cropper('setCropBoxData', cropBoxData);
                },
                crop: function(e) {
                    var imageData = $(this).cropper('getImageData');
                    var previewAspectRatio = e.width / e.height;
                    $('#crop_x').val(e.x);
                    $('#crop_y').val(e.y);
                    $('#crop_height').val(e.height);
                    $('#crop_width').val(e.width);
                    $('#crop_rotate').val(e.rotate);
                    $previews.each(function() {
                        var $preview = $(this);
                        var previewWidth = $preview.width();
                        var previewHeight = previewWidth / previewAspectRatio;
                        var imageScaledRatio = e.width / previewWidth;
                        $preview.height(previewHeight).find('img').css({
                            width: imageData.naturalWidth / imageScaledRatio,
                            height: imageData.naturalHeight / imageScaledRatio,
                            marginLeft: -e.x / imageScaledRatio,
                            marginTop: -e.y / imageScaledRatio
                        });
                    });
                }
            });
        });
    }

    function save_cropped_img() {
        var json = [
            '{"x":' + $('#crop_x').val(),
            '"y":' + $('#crop_y').val(),
            '"height":' + $('#crop_height').val(),
            '"width":' + $('#crop_width').val(),
            '"rotate":' + $('#crop_rotate').val() + '}'
        ].join();
        $.ajax({
            url: "{{ admin_url() . 'modul/crop_image' }}",
            type: "POST",
            dataType: "JSON",
            data: $('#crop_form').serialize(),
            success: function(data) {
                console.log(data.cropped_image);
                $('#featured_img').val(data.cropped_image);
                $('.jFiler-item-thumb-image').find('img').attr('src', asset_uploads +
                    'module/{{ $module->type }}/thumb/' + data.cropped_image);
                $('#cropper_form').modal('hide');
            },
            error: function(jqXHR, textStatus, errorThrown) {}
        });
    }

    function bind_filer() {}



    function update_module_status(id) {
        var current_status = $("#sts_" + id + " span").html();
        current_status = current_status.trim();
        var myurl = baseUrl + 'adminmedia/module/{{ $module->type }}/create?id=' + id + '&&current_status=' +
            current_status;
        $.get(myurl, function(sts) {
            var class_label = 'success';
            if (sts != 'active')
                var class_label = 'danger';
            $("#sts_" + id).html('<span class="label label-' + class_label + '">' + sts + '</span>');
        });
    }

    function update_module_status_toggle(id) {
        var current_status = 'notset';
        var myurl = baseUrl + 'adminmedia/module/{{ $module->type }}/create?id=' + id + '&&current_status=' +
            current_status;
        $.get(myurl, function(sts) {
            alertme('<i class="fas fa-check" aria-hidden="true"></i> Done Successfully ',
                'success', true, 1500);
        });
    }


    function add_content() {
        reset_model();
        save_method = 'add';
        $('#modal_form_title').text('Add {{ ucwords($module->term) }}');
        tinyMCE.get('editor1').setContent('');
    }

    function save() {
        var url;
        var content = tinyMCE.get('editor1').getContent();
        $('#module_description1').val(content);
        if (save_method == 'add') {
            url = "{{ admin_url() . 'module/' . $module->type }}";
        } else {
            var id = $('[name="id"]').val();
            mId = $('#module_id').val();
            url = "{{ admin_url() . 'module/' }}" + mId + "/" + id;
            console.log(id);
            console.log(url);
        }


        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $.ajax({
            url: url,
            type: "POST",
            data: $("#form").serialize(),
            success: function(data, status) {
                console.log(data);
                if ($.isEmptyObject(data.error)) {
                    $('#modal_form').modal('hide');
                    $('#' + save_method + '_action').show();

                    if ($("#from_page_update").val() == "yess") {
                        redirect_url = "{{ admin_url() . 'module/' . $module->type }}";
                        window.location.href = redirect_url;
                    } else {
                        location.reload();
                    }

                } else {
                    errorsHtml = '<div class="alert alert-danger"><ul>';
                    $.each(data, function(key, value) {
                        errorsHtml += '<li>' + value[0] + '</li>'; //showing only the first error.
                    });
                    errorsHtml += '</ul></di>';
                    $('#form-errors').html(errorsHtml);
                }
                $('#loading').hide();
            },
            error: function(jqXHR, textStatus, errorThrown) {
                $('#loading').hide();
                console.log(jqXHR);
                console.log(textStatus);
                console.log(errorThrown);
                alert('Error adding / update data');
            }
        });
    }

    function delete_content(id) {
        $('.message-container').fadeOut(3000);
        var mess_alert = '';
        mess_alert = 'Are you sure you want to delete this';
        if (confirm(mess_alert)) {
            // ajax delete data to database
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            console.log(id);
            $.ajax({
                url: "{{ base_url() . 'adminmedia/module/delete' }}/" + id,
                type: "DELETE",
                success: function(data) {
                    //if success reload ajax table
                    $('#modal_form').modal('hide');
                    $('#item_' + id).hide();
                    $('#delete_action').show();
                    location.reload();
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

    function remove_featured_img(id) {
        if (confirm("Are you sure you want to delete this {{ ucwords($module->term) }} Image?")) {
            url = "{{ base_url() }}adminmedia/modul/remove_image?id=" + id + '&&type={{ $module->type }}';
            $.ajax({
                url: url,
                type: "GET",
                success: function(data) {
                    $('#featured_img').hide();
                    $('#featured_img').html("");
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
