<script type="text/javascript">
    function add_album() {
        if ($("#title").val() == '') {
            alert('Please Add Album Title');
            return false;
        }

        $(".spinner").show();
        var myurl = baseUrl + 'adminmedia/files/add_album';

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
                    alert("Error: Please select valid file.\n Max Size: {{ getMaxUploadSize() }}MB");

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
    function delete_image(imgpath, img_id) {
        var myurl = baseUrl + 'adminmedia/files/0';
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
                    'album_id': '',
                    'imgpath': imgpath
                },
                success: function(data) {
                    data = JSON.parse(data);
                    if (data.status) {
                        $("#id_" + img_id).fadeOut();

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
    function delete_album(imgPath, id) {
        if (confirm("Are you sure you want to delete this folder and file(s) under this folder?") == false) {
            return false;
        }
        var myurl = baseUrl + 'adminmedia/files/delete_album/0';

        $.ajax({
            type: "POST",
            url: myurl,
            data: {
                '_token': $('meta[name="csrf-token"]').attr('content'),
                'imgpath': imgPath
            },
            success: function(data) {
                data = JSON.parse(data);
                if (data.status) {
                    $(".section_" + id).hide();
                    $(".section_" + id).parent('.mediaup').hide();
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
        var myurl = baseUrl + 'adminmedia/files/update_album';

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
                    alert("Error: Please select valid file.\n Max Size: {{ getMaxUploadSize() }}MB");
                    console.log(data.status);
                }
            },
        });

    }

    function copyMyTxt(txt) {

        $("#txt_copy22").show();
        $("#txt_copy22").val('{{ base_url() }}' + '' + txt);
        var copyText = document.getElementById("txt_copy22");
        copyText.select();
        copyText.setSelectionRange(0, 99999)
        document.execCommand("copy");
        $("#txt_copy22").hide();
        alert("Copied");
    }

    function show_section(idd, objj) {
        $(".fldbtns").removeClass('active');
        $(objj).addClass('active');
        $(".mystr").parent('.mediaup').hide();
        $(".section_" + idd).parent('.mediaup').show();
    }
</script>
