<script type="text/javascript">
    function add_album() {
        if ($("#title").val() == '') {
            alert('Please Add Album Title');
            //return false;
        }
        if ($("#f_mg").val() == '') {
            alert('Please Add Featured Image');
            //return false;
        }
        $(".spinner").show();
        var myurl = base_url + 'adminmedia/gallery/add_album';
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $.ajax({
            type: "POST",
            url: myurl,
            data: new FormData(add_album_frm),
            contentType: false,
            cache: false, // To unable request pages to be cached
            processData: false,
            success: function(data) {
                data = JSON.parse(data);
                if (data.done == 'ok') {
                    $("#modal-1").modal('hide');
                    location.reload();
                } else {
                    $(".spinner").hide();
                    alert(
                        "Error: Please select valid image.\n Max Size: {{ getMaxUploadSize() }}MB"
                    );
                }
            },
            error: function(data, textStatus, errorThrown) {
                if (textStatus === "timeout") {
                    alert("ERROR: Connection problem"); //Handle the timeout
                } else {
                    alert("ERROR: There is something wrong. Please fill all fields correctly");
                }
            }
        });
    }
    //Delete Album  Image
    function delete_image(img_id, album_id) {
        var myurl = base_url + 'adminmedia/gallery/' + img_id;
        var is_confirm = confirm("Are you sure you want to delete this Image?");
        if (is_confirm) {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                type: "DELETE",
                url: myurl,
                data: {
                    '_token': $('meta[name="csrf-token"]').attr('content'),
                    'album_id': album_id
                },
                success: function(data) {
                    data = JSON.parse(data);
                    if (data.status) {
                        $("#id_" + img_id).fadeOut();
                        alert("Deleted");
                    } else {
                        alert('OOps! Something went wrong.');
                        console.log(data.status);
                    }
                    console.log(data);
                },
            });
        }
    }
    //On click Upload images in album 
    function upload_imgs(idd) {
        $("#album").val(idd);
        var offset = $(".upload_adm_area").offset().top;
        $('html,body').animate({
            scrollTop: offset
        }, 1000);
    }
    //Delete Complete Album
    function delete_album(id) {
        if (confirm("Are you sure you want to delete this album and image(s) under this section?") == false) {
            return false;
        }
        var myurl = base_url + 'adminmedia/gallery/delete_album/' + id;
        $.ajax({
            type: "GET",
            url: myurl,
            data: {},
            success: function(data) {
                data = JSON.parse(data);
                if (data.status) {
                    $(".section_" + id).hide();
                } else {
                    alert('OOps! Something went wrong.');
                    console.log(data.status);
                }
            },
        });
    }
    //On edit Popup Modal
    function edit_album(idd, title) {
        $("#idd").val(idd);
        $("#title_edit").val(title);
        $("#modal-2").modal('show');
    }
    // Update Album 
    function update_album() {
        if ($("#title_edit").val() == '') {
            alert('Please Enter Album heading');
            return false;
        }
        var myurl = base_url + 'adminmedia/gallery/update_album';
        $.ajax({
            type: "POST",
            url: myurl,
            data: new FormData(frm2),
            contentType: false,
            cache: false, // To unable request pages to be cached
            processData: false,
            success: function(data) {
                data = JSON.parse(data);
                if (data.done == 'ok') {
                    $("#modal-1").modal('hide');
                    location.reload();
                } else {
                    alert(
                        "Error: Please select valid image.\n Max Size: {{ getMaxUploadSize() }}MB"
                    );
                    console.log(data.status);
                }
            },
        });
    }

    function openImageAltTitleModal(album_id, image_id) {
        $.ajax({
            url: "{{ admin_url() . 'getGalleryImageAltTitle' }}",
            type: "POST",
            dataType: "JSON",
            data: {album_id:album_id,image_id:image_id, _token: '{{ csrf_token() }}'},
            success: function(data) {
                $('#galleryImageAltTitleForm').find('#album_id').val(album_id);
                $('#galleryImageAltTitleForm').find('#image_id').val(image_id);
                $('#galleryImageAltTitleForm').find('#image_alt').val(data.image_alt);
                $('#galleryImageAltTitleForm').find('#image_title').val(data.image_title);
                $('#galleryImageAltTitleModal').modal('show');
            },
            error: function(jqXHR, textStatus, errorThrown) {}
        });
    }

    function saveGalleryImageAltTitle() {
        $.ajax({
            url: "{{ admin_url() . 'saveGalleryImageAltTitle' }}",
            type: "POST",
            dataType: "JSON",
            data: $('#galleryImageAltTitleForm').serialize(),
            success: function(data) {
                $('#galleryImageAltTitleModal').modal('hide');
            },
            error: function(jqXHR, textStatus, errorThrown) {}
        });
    }

    function bind_cropper_preview_gallery_image(album_id, image_id) {
        $('#gallery_image_crop_form').find('#album_id').val(album_id);
        $('#gallery_image_crop_form').find('#image_id').val(image_id);
        let image_name = $('#image_' + image_id).attr('data-imgname');
        let path = '{{ asset_uploads("gallery/") }}';
        $('#gallery_image_crop_form').find('#image').attr('src', path + album_id + '/' + image_name);
        $('#gallery_image_crop_form').find('#source_image').val(image_name);
        $('#gallery_image_cropper_form').modal('show');
    }
    $('#gallery_image_cropper_form').on('hidden.bs.modal', function() {
        var $image = $('#gallery_image_crop_form').find('#image');
        $image.cropper('destroy');
    });
    $('#gallery_image_cropper_form').on('shown.bs.modal', function() {
        var $image = $('#gallery_image_crop_form').find('#image');
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
                $('#gallery_image_crop_form').find('#crop_x').val(e.x);
                $('#gallery_image_crop_form').find('#crop_y').val(e.y);
                $('#gallery_image_crop_form').find('#crop_height').val(e.height);
                $('#gallery_image_crop_form').find('#crop_width').val(e.width);
                $('#gallery_image_crop_form').find('#crop_rotate').val(e.rotate);
            }
        });
    });

    function save_gallery_cropped_img() {
        let album_id = $('#gallery_image_crop_form').find('#album_id').val();
        let image_id = $('#gallery_image_crop_form').find('#image_id').val();
        $.ajax({
            url: "{{ admin_url() . 'save_gallery_image_crop_image' }}",
            type: "POST",
            dataType: "JSON",
            data: $('#gallery_image_crop_form').serialize(),
            success: function(data) {
                console.log(data.cropped_image);
                $('#image_' + image_id).attr('src', asset_uploads+'gallery/' + album_id + '/thumb/' + data.cropped_image);
                $('#image_' + image_id).attr('data-imgname', data.cropped_image);
                $('#gallery_image_crop_form').find('#image').attr('src', '');
                $('#gallery_image_crop_form').find('#source_image').val('');
                $('#gallery_image_cropper_form').modal('hide');
            },
            error: function(jqXHR, textStatus, errorThrown) {}
        });
    }
</script>
