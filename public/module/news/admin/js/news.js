//=======Starts news Module=======
function update_news_status(id){

	var current_status = $("#sts_"+id+" span").html();

	var myurl = baseUrl+'news/status/'+id+'/'+current_status;

	$.get(myurl, function (sts) {

		var class_label = 'success';

		if(sts!='active')

			var class_label = 'danger';

   $("#sts_"+id).html('<span class="label label-'+class_label+'">'+sts+'</span>');

 });

}
$(function () {

	$('.mldate').datepicker({

		format: 'mm-dd-yyyy'

	});

});
function load_news_add_form (){

         $('#frm_news').trigger("reset");

	$('#add_page_form').modal('show');

}



function load_news_edit_form(id){

	var my_editor_id = 'editor1';

         $('#edit_frm_news').trigger("reset");

        // set the content empty

       // tinymce.get(my_editor_id).setContent('');

	$.getJSON(baseUrl+'news/get_news_by_id/'+id, function(data) {

                $('#edit_news_title').val(data.news_title);

                $('#edit_news_slug').val(data.news_slug);
				 $('#edit_news_date_timed').val(data.dated);

                var  seoClass  = document.getElementById('seo-edit-modul');

                if(data.meta_title.length  > 0 || data.meta_keywords.length  > 0 || data.meta_description.length  > 0 || data.canonical_url.length > 0 ){
                        $('#edit_meta_title').val(data.meta_title);
                        $('#edit_meta_keywords').val(data.meta_keywords);
                        $('#edit_meta_description').val(data.meta_description);
                        $('#edit_canonical_url').val(data.canonical_url);
                        seoClass.className = 'seo-edit-modul-sow';
                }else{
                    seoClass.className = 'seo-edit-modul-hide';
                }
                tinymce.get(my_editor_id).setContent(data.news_description);
                tinymce.activeEditor.execCommand('mceInsertContent', false, data.news_description);

                $('#news_id').val(data.ID);

                $('#edit_page_form').modal('show');

        });	

}

function delete_news(id){

	var myurl = baseUrl+'news/delete/'+id;

	var is_confirm = confirm("Are you sure you want to delete this news?");

	if(is_confirm){

            $.get(myurl, function (sts) {

                if(sts=='done')

                    $("#row_"+id).fadeOut();

		 else

                    alert('OOps! Something went wrong.');

            });

	}

}

