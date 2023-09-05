function load_email_add_form() {
    $('#frm_blog_post').trigger("reset");
    $('#add_blog_post').modal('show');
}

function load_email_edit_form(id) {
    $('#edit_frm_cms').trigger("reset");
    $.getJSON(base_url + 'adminmedia/email_templates/' + id + '/edit', function (data) {
        console.log(data);
        $('#edit_heading').val(data.Title);
        $('#edit_subject').val(data.Subject);
        $('#edit_sender_name').val(data.SenderName);
        $('#edit_sender_email').val(data.Sender);
        $('#edit_editor1').val(data.Body);

        // $('#cms_id').val(data.ID);
        $('#edit_page_form').modal('show');
    });
}

function update_email_status(id) {
    var current_status = $("#sts_" + id + " span").html();
    var myurl = base_url + 'adminmedia/blog/' + id + '/edit?status=' + current_status;
    $.get(myurl, function (sts) {
        var class_label = 'success';
        if (sts != 'active')
            var class_label = 'danger';
        $("#sts_" + id).html('<span class="label label-' + class_label + '">' + sts + '</span>');
    });
}

function delete_email_template(id) {
    var myurl = base_url + 'adminmedia/blog_categories/' + id;
    var is_confirm = confirm("Are you sure you want to delete this Category?");
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
