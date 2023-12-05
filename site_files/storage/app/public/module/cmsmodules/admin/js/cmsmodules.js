function toggle_crop_height(obj) {
    if ($(obj).is(':checked')) {
        $('#feature_img_thmb_height_div').show();
    } else {
        $('#feature_img_thmb_height_div').hide();
    }
}

function toggle_crop_edit_height(obj) {
    if ($(obj).is(':checked')) {
        $('#edit_feature_img_thmb_height_div').show();
    } else {
        $('#edit_feature_img_thmb_height_div').hide();
    }
}

function load_cmsmodule_add_form() {
    $('#frm_block').trigger("reset");
    $('#add_page_form').modal('show');

}

function load_cmsmodule_edit_form(id) {
    $('#edit_frm_block').trigger("reset");
    $('#edit_footer_menu').prop('checked', false);

    $('#edit_top_menu').prop('checked', false);
    var my_editor_id = 'editor1';
    $.getJSON(base_url + 'adminmedia/modules/' + id, function(data) {

        $('#edit_title').val(data.title);
        $('#edit_term').val(data.term);
        $('#edit_type').val(data.type);
        $('#edit_additional_fields').val(data.additional_fields);
        var field_value = data.additional_fields;
        for (var count = 1; count <= 8; count++) {
            $("#edit_field" + count).hide();
        }
        for (var count = 1; count <= field_value; count++) {
            $("#edit_field" + count).show();
        }
        $('#edit_additional_field_title_1').val(data.additional_field_title_1);
        $('#edit_additional_field_title_2').val(data.additional_field_title_2);
        $('#edit_additional_field_title_3').val(data.additional_field_title_3);
        $('#edit_additional_field_title_4').val(data.additional_field_title_4);
        $('#edit_additional_field_title_5').val(data.additional_field_title_5);
        $('#edit_additional_field_title_6').val(data.additional_field_title_6);
        $('#edit_additional_field_title_7').val(data.additional_field_title_7);
        $('#edit_additional_field_title_8').val(data.additional_field_title_8);
        $('#edit_have_category').val(data.have_category);
        $('#edit_show_page_slug_field').val(data.show_page_slug_field);
        $('#edit_ordering_field').val(data.show_ordering_options);
        $('#edit_show_menu_field').val(data.show_menu_field);
        $('#edit_show_feature_img_field').val(data.show_feature_img_field);
        $('#edit_show_seo_field').val(data.show_seo_field);
        $('#edit_show_preview_link_on_listing_page').val(data.show_preview_link_on_listing_page);
        $('#edit_feature_img_thmb_width').val(data.feature_img_thmb_width);
        $('#edit_feature_img_thmb_height').val(data.feature_img_thmb_height);
        $('#edit_show_follow').val(data.show_follow);
        $('#edit_show_index').val(data.show_index);
        $('#edit_show_descp').val(data.show_descp);
        $('#edit_show_featured_image').val(data.show_featured_image);
        $('#edit_module_fontawesome_icon').val(data.module_fontawesome_icon);

        let access_level = data.access_level;
        const accessLevelArray = access_level.split(",");
        if (accessLevelArray[0] != '') {
            $('#' + accessLevelArray[0]).prop('checked', true);
        }
        if (accessLevelArray[1] != '') {
            $('#' + accessLevelArray[1]).prop('checked', true);
        }
        if (accessLevelArray[2] != '') {
            $('#' + accessLevelArray[2]).prop('checked', true);
        }

        /******************* */
        let show_icon_in = data.show_icon_in;
        const show_icon_in_array = show_icon_in.split(",");
        console.log(show_icon_in);
        console.log(show_icon_in_array);
        if (show_icon_in_array[0] != '') {
            $('#' + show_icon_in_array[0]).prop('checked', true);
        }
        if (show_icon_in_array[1] != '') {
            $('#' + show_icon_in_array[1]).prop('checked', true);
        }
        /******************* */
        
        if (data.crop_image == 'Yes') {
            $('#edit_crop_image').prop('checked', true);
            $('#edit_feature_img_thmb_height_div').show();
        }

        $('#cmsmodule_id').val(data.id);
        $('#edit_page_form').modal('show');

        var replace = base_url + 'adminmedia/modules/' + id;
        document.getElementById('edit_frm_cmsmodule').action = replace;
    });

}

function additional_fields_show_hide() {

    var field_value = $("#edit_additional_fields").val();
    for (var count = 1; count <= 8; count++) {
        $("#edit_field" + count).hide();
    }
    for (var count = 1; count <= field_value; count++) {
        $("#edit_field" + count).show();
    }
}

function update_cmsmodule_status_toggle(id) {
    var current_status = 'notset';
    var myurl = base_url + 'adminmedia/modules/' + id + '/edit?status=' + current_status;
    $.get(myurl, function(sts) {
        console.log(sts);
        alertme('<i class="fas fa-check" aria-hidden="true"></i> Done Successfully ',
            'success', true, 1500);
    });
}


function delete_cmsmodule(id, type) {
    var myurl = base_url + 'adminmedia/modules/' + id;
    var is_confirm = confirm("Are you sure you want to delete this cmsmodules?");
    if (is_confirm) {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $.ajax({
            url: myurl,
            type: 'DELETE',
            success: function(response) {
                console.log(response);
                if (response == 'done')
                    $("#row_" + id).fadeOut();
                else
                    alert('OOps! Something went wrong.');
            }
        });
    }
}


function validate_edit_cmsmodules_form(the_form) {
    if (the_form.edit_heading.value == '') {
        alert("Please provide cmsmodules heading.");
        return false;
    }
    if (the_form.edit_page_slug.value == '') {
        alert("Please provide cmsmodules slug.");
        return false;
    }
    if (the_form.edit_cmsmodule_content.value == '') {
        alert("Please provide cmsmodules slug.");
        return false;
    }
}