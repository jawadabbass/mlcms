/*
Author: sadiq noor
Date: 15/03/16
Version: 1.0
*/
//=======Starts sponsors Module=======
function update_sponsors_status(id){
    var current_status = $("#sts_"+id+" span").html();
    var myurl = baseUrl+'sponsors/status/'+id+'/'+current_status;
    $.get(myurl, function (sts) {
        var class_label = 'success';
        if(sts!='active')
            var class_label = 'danger';
        $("#sts_"+id).html('<span class="label label-'+class_label+'">'+sts+'</span>');
    });
}
function load_sponsors_add_form (){
       // tinyMCE.get('editor1').setContent('');
	$('#add_page_form').modal('show');
}
function load_sponsors_edit_form(id){
    $('#edit_footer_menu').prop('checked', false);
    $('#edit_top_menu').prop('checked', false);
    $.getJSON(baseUrl+'sponsors/get_sponsors_by_id/'+id, function(data) {
       // $('#edit_gallery_title').val(data.gallery_title);
        $('#edit_alt_tag').val(data.alt_tag);
        $("#sponsorimages").attr('src', front_uploads+'sponsors/thumb/'+data.sponsor_logo);
        //alert(data.gallery_desc);
       // tinyMCE.activeEditor.execCommand('mceCleanup', false);
//        tinyMCE.get('edit_editor1').setContent('');
//
//        tinyMCE.get('edit_editor1').setContent(data.gallery_desc);
        //tinymce.activeEditor.execCommand('mceInsertContent', false, data.gallery_desc);
        //CKEDITOR.instances['edit_editor1'].setData(data.gallery_desc);
        $('#sponsors_id').val(data.ID);
        $('#edit_page_form').modal('show');
    });
}

function delete_sponsors(id){
    var myurl = baseUrl+'sponsors/delete/'+id;
    var is_confirm = confirm("Are you sure you want to delete this sponsors?");
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
        alert("Please provide sponsors Title.");
        return false;
    }
    if(the_form.edit_alt_tag.value==''){
        alert("Please provide sponsors Alt Tag.");
        return false;
    }
    if(CKEDITOR.instances['edit_editor1'].getData()==''){
        alert("Please provide sponsors content.");
        return false;
    }
}
//=======Ends sponsors Module=======