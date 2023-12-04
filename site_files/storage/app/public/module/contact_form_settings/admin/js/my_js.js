function update_my_status(id) {
    var current_status = $("#sts_" + id + " span").html();
    var myurl = baseUrl + 'adminmedia/contact_form_settings/' + id + '/edit?status=' + current_status;
    $.get(myurl, function (sts) {
        var class_label = 'success';
        if (sts != 'active')
            var class_label = 'danger';
        $("#sts_" + id).html('<span class="label label-' + class_label + '">' + sts + '</span>');
    });
}

function load_my_add_form() {
    $('#frm_faq').trigger("reset");
    $('#add_page_form').modal('show');
}

function load_my_edit_form(id) {
    $('#edit_frm_faq').trigger("reset");
    $.getJSON(baseUrl + 'adminmedia/contact_form_settings/' + id, function (data) {
        $('#edit_question').val(data.ip_list);
        $('#faq_id').val(data.ID);
        $('#edit_page_form').modal('show');
    });
}

function load_spam_words() {
    $('#edit_frm_faq').trigger("reset");
    $.getJSON(baseUrl + 'adminmedia/contact_form_settings/create', function (data) {
        $('#spam_words').val(data);
        $('#edit_spam_area').modal('show');
    });
}

function delete_my(id) {
    var myurl = baseUrl + 'contact_form_settings/delete/' + id;
    var is_confirm = confirm("Are you sure you want to delete this IP?");
    if (is_confirm) {

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $.ajax({
            type: "DELETE",
            url: baseUrl + 'adminmedia/contact_form_settings/' + id,
            data: {'_token': $('meta[name="csrf-token"]').attr('content')},
            success: function (data) {
                data = JSON.parse(data);
                if (data.status) {
                    $("#row_" + id).fadeOut();
                }
                else {
                    alert('OOps! Something went wrong.');
                    console.log(data);
                }
            },
        });
    }
}