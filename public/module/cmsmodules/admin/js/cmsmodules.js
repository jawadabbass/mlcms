/*
Author: sadiq noor
Date: 28/01/16
Version: 2.0
*/

//=======Starts cmsmodule Module=======

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
    $.getJSON(baseUrl + 'adminmedia/modules/' + id, function(data) {

        $('#edit_title').val(data.title);
        $('#edit_term').val(data.term);
        $('#edit_type').val(data.type);
        $('#edit_additional_fields').val(data.additional_fields);
        var field_value = data.additional_fields;
        if (field_value == "1") {
            $("#edit_field1").show();
            $("#edit_field2").hide();
            $("#edit_field3").hide();
            $("#edit_field3").hide();
            $("#edit_field5").hide();
            $("#edit_field6").hide();
            $("#edit_field7").hide();
            $("#edit_field8").hide();
        } else if (field_value == "2") {
            $("#edit_field1").show();
            $("#edit_field2").show();
            $("#edit_field3").hide();
            $("#edit_field4").hide();
            $("#edit_field5").hide();
            $("#edit_field6").hide();
            $("#edit_field7").hide();
            $("#edit_field8").hide();
        } else if (field_value == "3") {
            $("#edit_field1").show();
            $("#edit_field2").show();
            $("#edit_field3").show();
            $("#edit_field4").hide();
            $("#edit_field5").hide();
            $("#edit_field6").hide();
            $("#edit_field7").hide();
            $("#edit_field8").hide();
        } else if (field_value == "4") {
            $("#edit_field1").show();
            $("#edit_field2").show();
            $("#edit_field3").show();
            $("#edit_field4").show();
            $("#edit_field5").hide();
            $("#edit_field6").hide();
            $("#edit_field7").hide();
            $("#edit_field8").hide();
        } else if (field_value == "5") {
            $("#edit_field1").show();
            $("#edit_field2").show();
            $("#edit_field3").show();
            $("#edit_field4").show();
            $("#edit_field5").show();

            $("#edit_field6").hide();
            $("#edit_field7").hide();
            $("#edit_field8").hide();
        } else if (field_value == "6") {
            $("#edit_field1").show();
            $("#edit_field2").show();
            $("#edit_field3").show();
            $("#edit_field4").show();
            $("#edit_field5").show();
            $("#edit_field6").show();

            $("#edit_field7").hide();
            $("#edit_field8").hide();
        } else if (field_value == "7") {
            $("#edit_field1").show();
            $("#edit_field2").show();
            $("#edit_field3").show();
            $("#edit_field4").show();
            $("#edit_field5").show();
            $("#edit_field6").show();
            $("#edit_field7").show();

            $("#edit_field8").hide();
        } else if (field_value == "8") {
            $("#edit_field1").show();
            $("#edit_field2").show();
            $("#edit_field3").show();
            $("#edit_field4").show();
            $("#edit_field5").show();
            $("#edit_field6").show();
            $("#edit_field7").show();
            $("#edit_field8").show();

        } else {
            $("#edit_field1").hide();
            $("#edit_field2").hide();
            $("#edit_field3").hide();
            $("#edit_field4").hide();
            $("#edit_field5").hide();
            $("#edit_field6").hide();
            $("#edit_field7").hide();
            $("#edit_field8").hide();
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
        $('#edit_show_no_follow').val(data.show_no_follow);
        $('#edit_show_index').val(data.show_index);
        $('#edit_show_no_index').val(data.show_no_index);
        $('#edit_show_descp').val(data.show_descp);
        $('#edit_show_featured_image').val(data.show_featured_image);
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
    if (field_value == "1") {
        $("#edit_field1").show();
        $("#edit_field2").hide();
        $("#edit_field3").hide();
        $("#edit_field4").hide();
        $("#edit_field5").hide();
        $("#edit_field6").hide();
        $("#edit_field7").hide();
        $("#edit_field8").hide();
    } else if (field_value == "2") {
        $("#edit_field1").show();
        $("#edit_field2").show();
        $("#edit_field3").hide();
        $("#edit_field4").hide();
        $("#edit_field5").hide();
        $("#edit_field6").hide();
        $("#edit_field7").hide();
        $("#edit_field8").hide();
    } else if (field_value == "3") {
        $("#edit_field1").show();
        $("#edit_field2").show();
        $("#edit_field3").show();
        $("#edit_field4").hide();
        $("#edit_field5").hide();
        $("#edit_field6").hide();
        $("#edit_field7").hide();
        $("#edit_field8").hide();
    } else if (field_value == "4") {
        $("#edit_field1").show();
        $("#edit_field2").show();
        $("#edit_field3").show();
        $("#edit_field4").show();
        $("#edit_field5").hide();
        $("#edit_field6").hide();
        $("#edit_field7").hide();
        $("#edit_field8").hide();
    } else if (field_value == "5") {
        $("#edit_field1").show();
        $("#edit_field2").show();
        $("#edit_field3").show();
        $("#edit_field4").show();
        $("#edit_field5").show();
        $("#edit_field6").hide();
        $("#edit_field7").hide();
        $("#edit_field8").hide();
    } else if (field_value == "6") {
        $("#edit_field1").show();
        $("#edit_field2").show();
        $("#edit_field3").show();
        $("#edit_field4").show();
        $("#edit_field5").show();
        $("#edit_field6").show();
        $("#edit_field7").hide();
        $("#edit_field8").hide();
    } else if (field_value == "7") {
        $("#edit_field1").show();
        $("#edit_field2").show();
        $("#edit_field3").show();
        $("#edit_field4").show();
        $("#edit_field5").show();
        $("#edit_field6").show();
        $("#edit_field7").show();
        $("#edit_field8").hide();
    } else if (field_value == "8") {
        $("#edit_field1").show();
        $("#edit_field2").show();
        $("#edit_field3").show();
        $("#edit_field4").show();
        $("#edit_field5").show();
        $("#edit_field6").show();
        $("#edit_field7").show();
        $("#edit_field8").show();
    } else {
        $("#edit_field1").hide();
        $("#edit_field2").hide();
        $("#edit_field3").hide();
        $("#edit_field4").hide();
        $("#edit_field5").hide();
        $("#edit_field6").hide();
        $("#edit_field7").hide();
        $("#edit_field8").hide();
    }
}


function update_cmsmodule_status(id) {
    var current_status = $("#sts_" + id + " span").html();
    current_status = current_status.trim(current_status);
    var myurl = baseUrl + 'adminmedia/modules/' + id + '/edit?status=' + current_status;
    $.get(myurl, function(sts) {
        var class_label = 'success';
        if (sts != 'Yes')
            var class_label = 'danger';
        $("#sts_" + id).html('<span class="label label-' + class_label + '">' + sts + '</span>');
    });

}

function delete_cmsmodule(id, type) {
    var myurl = baseUrl + 'adminmedia/modules/' + id;
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


//=======Ends cmsmodule Module=======