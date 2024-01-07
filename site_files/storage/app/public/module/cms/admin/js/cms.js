/*
Author: sadiq noor
Date: 28/01/16
Version: 2.0
*/
function load_cms_add_form() {
    $('#frm_cms').trigger("reset");
    $('#add_page_form').modal('show');
}

function delete_cms(id) {
    var myurl = base_url + 'cms/delete/' + id;
    var is_confirm = confirm("Are you sure you want to delete this page?");
    if (is_confirm) {
        $.get(myurl, function (sts) {
            if (sts == 'done')
                $("#row_" + id).fadeOut();
            else
                alert('OOps! Something went wrong.');
        });
    }
}

function update_cms_status(id) {
    var current_status = $("#sts_" + id + " span").html();
    var myurl = base_url + 'cms/status/' + id + '/' + current_status;
    $.get(myurl, function (sts) {
        var class_label = 'success';
        if (sts != 'active')
            var class_label = 'danger';
        $("#sts_" + id).html('<span class="label label-' + class_label + '">' + sts + '</span>');
    });
}

function load_cms_edit_form(id) {
    var my_editor_id = 'editor1';
    $('#edit_frm_cms').trigger("reset");
    // set the content empty
    tinymce.get(my_editor_id).setContent('');
    $('#edit_footer_menu').prop('checked', false);
    $('#edit_top_menu').prop('checked', false);
    $.getJSON(base_url + 'cms/get_cms_by_id/' + id, function (data) {
        // alert(data.permanent_page);
        if (data.data_type == 'module') {
            $("#edit_page_slug").prop("readonly", true);
            $('#page-content-details').hide();
            $('#content-featured-img').hide();
        }
        else {
            $("#edit_page_slug").prop("readonly", false);
            $('#page-content-details').show();
            $('#content-featured-img').show();
        }
        $('#edit_heading').val(data.heading);
        $('#edit_page_slug').val(data.page_slug);


        if (data.parent != 0) {
            $("#edit_parent_page option[value=" + data.parent + "]").prop("selected", true);
        }
        // menu select options
        if (data.menu_location != '') {
            var menuLocation = data.menu_location.split(',');
            if (menuLocation[0] != 'undefined' && menuLocation[0] == 0) {
                $("#edit_header_menu").prop("checked", true);
            }
            if (menuLocation[0] != 'undefined' && menuLocation[0] == 1) {
                $("#edit_footer_menu").prop("checked", true);
            }
            if (menuLocation[1] != 'undefined' && menuLocation[1] == 1) {
                $("#edit_footer_menu").prop("checked", true);
            }
        }

        if (data.featured_img == null || data.featured_img == '' || data.featured_img == 0) {
            //  $("#featured-no-images").fadeIn();
            $("#featured_img").fadeOut();
        } else {
            $("#featured_img").fadeIn();
            var img = '<div class="featured-images-main" id="products_img_' + data.ID + '"><img style="width:150px" src="' + asset_uploads + 'cms/thumb/' + data.featured_img + '"><i onClick="remove_cms_featured_image(' + data.ID + ');" class="deleteIcon"></i></div>';
            $('#featured_img').html('');
            $('#featured_img').append(img);

        }
        fillSeoFields(data);
        tinymce.activeEditor.execCommand('mceInsertContent', false, data.content);
        $('#cms_id').val(data.ID);
        $('#edit_page_form').modal('show');
    });
}
function remove_cms_featured_image(id) {

    var myurl = base_url + 'cms/remove_cms_feature_image/' + id;
    var is_confirm = confirm("Are you sure you want to delete this CMS featured image?");
    if (is_confirm) {
        $.get(myurl, function (sts) {
            if (sts == 'done')
                $("#products_img_" + id).fadeOut();
            else
                alert('OOps! Something went wrong.');
        });
    }
}