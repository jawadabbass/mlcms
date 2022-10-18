$('#add_to_contact_email').click(function () {
    var to_email = $('#to_email_tb').val();
    emailAddRequest(to_email, 1);
});

$('#add_cc_email').click(function () {
    var cc_email = $('#cc_email').val();
    emailAddRequest(cc_email, 2);
});

$('#add_bcc_email').click(function () {
    var bcc_email = $('#bcc_email').val();
    emailAddRequest(bcc_email, 3);
});


function emailAddRequest(email, type) {

    var bcc_id = $('#cc_id').val();
    var myurl = baseUrl + 'adminmedia/manage_job/emails';
    if (email != '' && email_validation(email) == true) {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $.post(myurl, {type: type, email: email, id: bcc_id})
            .done(function (sts) {
                if (sts !== "alread_avalibale") {
                    if (type === 1) {
                        $('#to_email').val('');
                        $('.to_email_err').html('');
                        $('#append_to_email').append('<span class="cc_email_display"> ' + email + ' <i onclick="remove_cc_bcc_emails(this, \'email\');" class="deleteIcons"></i></span>');
                    }
                    else if (type === 2) {
                        $('#cc_email').val('');
                        $('.cc_email_err').html('');
                        $('#append_cc_email').append('<span class="cc_email_display"> ' + email + ' <i onclick="remove_cc_bcc_emails(this, \'email\');" class="deleteIcons"></i></span>');
                    }
                    else if (type === 3) {
                        $('#bcc_email').val('');
                        $('.bcc_email_err').html('');
                        $('#append_bcc_email').append('<span class="cc_email_display"> ' + email + ' <i onclick="remove_cc_bcc_emails(this, \'email\');" class="deleteIcons"></i></span>');
                    }
                    window.location.reload()
                } else {
                    if (type === 1)
                        $('.to_email_err').html(email + ' this email already available');
                    if (type === 1)
                        $('.cc_email_err').html(email + ' this email already available');
                    else if (type === 3)
                        $('.bcc_email_err').html(email + ' this email already available');
                }
            })
            .error(function (jqXHR, textStatus, errorThrown) {
                console.log(jqXHR);
                console.log(textStatus);
                console.log(errorThrown);
            });
    } else {
        if (type === 1)
            $('.to_email_err').html('please enterr email');
        if (type === 2)
            $('.cc_email_err').html('please enterr email');
        if (type === 3)
            $('.bcc_email_err').html('please enterr email');
    }
}

// Email validation here........
function email_validation(email) {
    filter = /^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;
    if (filter.test(email)) {
        // Yay! valid
        return true;
    }
    else {
        return false;
    }
}

function remove_to_emails(dataPost, postField) {
        
       
    var bcc_id = $('#cc_id').val();
    var email_removed = $(dataPost).parent().text();
    var myurl = baseUrl + 'adminmedia/manage_job/email_delete';
    var is_confirm = confirm("Are you sure you want to delete this Email?");
    if (is_confirm) {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $.post(myurl, {type: 1, email: email_removed, id: bcc_id, post_field: postField})
            .done(function (sts) {

                $(dataPost).parent().remove();
                console.log(sts);
            });
    }
}

function remove_cc_emails(dataPost, postField) {
    var bcc_id = $('#cc_id').val();
    
    var email_removed = $(dataPost).parent().text();
    var myurl = baseUrl + 'adminmedia/manage_job/email_delete';
    var is_confirm = confirm("Are you sure you want to delete this Email?");
    if (is_confirm) {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $.post(myurl, {type: 2, email: email_removed, id: bcc_id, post_field: postField})
            .done(function (sts) {
                $(dataPost).parent().remove();
                console.log(sts);
            });
    }
}

function remove_bcc_emails(dataPost, postField) {
    var bcc_id = $('#cc_id').val();
    var email_removed = $(dataPost).parent().text();
    var myurl = baseUrl + 'adminmedia/manage_job/email_delete';
    var is_confirm = confirm("Are you sure you want to delete this Email?");
    if (is_confirm) {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $.post(myurl, {type: 3, email: email_removed, id: bcc_id, post_field: postField})
            .done(function (sts) {
                $(dataPost).parent().remove();
                console.log(sts);
            });
    }
}

// function deleteAddress(id) {
//     if (confirmDel()) {
//         $.ajaxSetup({
//             headers: {
//                 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
//             }
//         });
//         url = base_url + 'adminmedia/manage_contact/' +id;
//         console.log(url);
//         $.ajax({
//             type: "DELETE",
//             url: url,
//             data: {'_token' : $('meta[name="csrf-token"]').attr('content')},
//             success: function (data) {
//                 if (data.status) {
//                     $("#trr" + id).fadeOut(1000);
//                     var tolrec = $("#total_rec").html();
//                     var tolrec = $("#total_rec").html(parseInt(tolrec) - 1);
//                     location.reload();
//                 }
//                 else {
//                     alert('ERROR: Deleting');
//                     console.log(data);
//                 }
//             },
//         });
//     }
// }