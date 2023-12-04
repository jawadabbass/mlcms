/*
Author: sadiq noor
Date: 04/04/16
Version: 2.1
*/
//=======Ends products categories Module=======
function load_categories_add_form (){
    $("#product_category").trigger('reset');
    $('#add_page_form').modal('show');
}

function load_categories_edit_form(id){
	$('#edit_footer_menu').prop('checked', false);
	$('#edit_top_menu').prop('checked', false);
        $("#edit_frm_product_cate").trigger('reset');
        
	$.getJSON(baseUrl+'categories/get_catetory_by_id/'+id, function(data) {
                	$('#edit_title').val(data.title);
                	$('#edit_cate_type').val(data.cate_type);
                	$('.edit_clild select').val(data.parent);
                	$('#edit_cate_slug').val(data.cate_slug);
                        var filename = asset_uploads+'categories/thumb/'+data.featured_image;
                        $("#featured_image").attr('src', filename);
			$('#category_id').val(data.ID);
                       // tinymce.activeEditor.execCommand('mceInsertContent', false, data.description);
                        tinymce.activeEditor.execCommand('mceInsertContent', false, data.description);
			$('#edit_frm_product_cate').modal('show');
		});	
}

function update_category_status(id) {
    var current_status = 'notset';
    var myurl = baseUrl+'categories/status/'+id+'/'+current_status;
    $.get(myurl, function(sts) {
        alertme('<i class="fas fa-check" aria-hidden="true"></i> Done Successfully ',
            'success', true, 1500);
    });
}

function delete_categories(id){
	var myurl = baseUrl+'categories/delete/'+id;
	var is_confirm = confirm("Are you sure you want to delete this categories?");
	if(is_confirm){
		  $.get(myurl, function (sts) {
			  if(sts=='done')
				  $("#row_"+id).fadeOut();
			  else
				  alert('OOps! Something went wrong.');
	   	  });
	}
}


//=======Ends products categories Module=======
