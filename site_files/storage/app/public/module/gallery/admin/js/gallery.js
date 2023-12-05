/*
Author: sadiq noor
Date: 28/01/16
Version: 2.0
*/
//=======Starts Gallery Module=======



function update_gallery_status(id){



    var current_status = $("#sts_"+id+" span").html();



    var myurl = base_url +'gallery/status/'+id+'/'+current_status;



    $.get(myurl, function (sts) {



        var class_label = 'success';



        if(sts!='active')



            var class_label = 'danger';



        $("#sts_"+id).html('<span class="label label-'+class_label+'">'+sts+'</span>');



    });



}

function load_gallery_add_form (){

       // tinyMCE.get('editor1').setContent('');

	$('#add_page_form').modal('show');

}

function load_gallery_edit_form(id){

    $('#edit_footer_menu').prop('checked', false);

    $('#edit_top_menu').prop('checked', false);

    $.getJSON(base_url +'gallery/get_gallery_by_id/'+id, function(data) {

       // $('#edit_gallery_title').val(data.gallery_title);

        $('#edit_gallery_title').val(data.gallery_title);
        $('#edit_pro_cat').val(data.cate_id);
        $('#edit_alt_tag').val(data.alt_tag);

        $("#galleryimages").attr('src', asset_uploads+'gallery/thumb/'+data.gallery_images);

        //alert(data.gallery_desc);

       // tinyMCE.activeEditor.execCommand('mceCleanup', false);

//        tinyMCE.get('edit_editor1').setContent('');
//
//        tinyMCE.get('edit_editor1').setContent(data.gallery_desc);

        //tinymce.activeEditor.execCommand('mceInsertContent', false, data.gallery_desc);

        //tinyMCE.get('edit_editor1').setContent(data.gallery_desc);

        $('#gallery_id').val(data.ID);

        $('#edit_page_form').modal('show');

    });

}

function delete_gallery(id){

    var myurl = base_url +'gallery/delete/'+id;

    var is_confirm = confirm("Are you sure you want to delete this gallery Image?");

    if(is_confirm){

        $.get(myurl, function (sts) {

            if(sts=='done')

                $("#row_"+id).fadeOut();

            else

                alert('OOps! Something went wrong.');

        });

    }

}



function validate_edit_gallery_form(the_form){

    if(the_form.edit_gallery_title.value==''){

        alert("Please provide gallery Title.");

        return false;

    }

    if(the_form.edit_alt_tag.value==''){

        alert("Please provide gallery Alt Tag.");

        return false;

    }

    if(tinyMCE.get('edit_editor1').getContent()==''){

        alert("Please provide Gallery content.");

        return false;

    }

}

//=======Ends Gallery Module=======