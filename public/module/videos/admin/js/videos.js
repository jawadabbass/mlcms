/*
Author: sadiq noor
Date: 28/01/16
Version: 2.0
*/

//=======Starts video Module=======

function load_video_add_form() {
    $('#frm_block').trigger("reset");
    $('#add_page_form').modal('show');
}

function load_videos_edit_form(id) {
    $('#edit_frm_block').trigger("reset");
    $('#edit_footer_menu').prop('checked', false);
    $('#edit_top_menu').prop('checked', false);
    $.getJSON(baseUrl + 'adminmedia/videos/' + id, function (data) {
        $('#edit_heading').val(data.heading);
        $('#edit_content').val(data.content);
        $('#video_id').val(data.ID);
        $('#edit_page_form').modal('show');
    });
}

function update_videos_sts(id) {
    var current_status = $("#sts_" + id + " span").html();
    var myurl = base_url + 'adminmedia/videos/' + id + '/edit?status=' + current_status;
    $.get(myurl, function (sts) {
        var class_label = 'success';
        if (sts != 'active')
            var class_label = 'danger';
        $("#sts_" + id).html('<span class="label label-' + class_label + '">' + sts + '</span>');
    });
}


function delete_videos(id) {
    var myurl = baseUrl + 'adminmedia/videos/' + id;
    var is_confirm = confirm("Are you sure you want to delete this videos?");
    if (is_confirm) {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $.ajax({
            type: "DELETE",
            url: myurl,
            data: {'_token': $('meta[name="csrf-token"]').attr('content')},
            success: function (data) {
                data = JSON.parse(data);
                if (data.status) {
                    $("#row_" + id).fadeOut();
                }
                else {
                    alert('OOps! Something went wrong.');
                    console.log(data.status);
                }
            },
        });
    }
}

function validate_edit_videos_form(the_form) {
    if (the_form.edit_heading.value == '') {
        alert("Please provide videos heading.");
        return false;
    }
    if (the_form.edit_page_slug.value == '') {
        alert("Please provide videos slug.");
        return false;
    }
    if (the_form.edit_video_content.value == '') {
        alert("Please provide videos slug.");
        return false;
    }
}


//=======Ends video Module=======