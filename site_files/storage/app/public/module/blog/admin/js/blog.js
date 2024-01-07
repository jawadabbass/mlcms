/*
Author: sadiq noor
Date: 28/01/16
Version: 2.0
*/

function load_categories_add_form() {
    $("#blog_category").trigger('reset');
    $('#add_blog_category_form').modal('show');

}

function load_category_edit_form(id) {
    $('#edit_footer_menu').prop('checked', false);
    $('#edit_top_menu').prop('checked', false);
    $("#edit_form_blog_cate").trigger('reset');
    url = base_url + 'adminmedia/blog_categories/' + id + '/edit';
    console.log(url);
    $.getJSON(url, function (data) {
        $('#edit_title').val(data.cate_title);
        $('#edit_cate_slug').val(data.cate_slug);
        tinyMCE.get('editor1').setContent(data.cate_description);
        $('#category_id').val(data.ID);
        $('#edit_frm_blog_cat').modal('show');
    });
}

function update_category_status(id) {
    var current_status = 'notset';
    var myurl = base_url + 'adminmedia/blog_categories/' + id + '?status=' + current_status;
    $.get(myurl, function(sts) {
        alertme('<i class="fas fa-check" aria-hidden="true"></i> Done Successfully ',
            'success', true, 1500);
    });
}

function update_unrevised_comment_status(id) {
    var current_status = $("#sts_" + id + " span").html();
    var myurl = base_url + 'adminmedia/blog/create?id=' + id + '&&status=' + current_status;
    console.log(myurl);
    $.get(myurl, function (sts) {
        var class_label = 'success';
        if (sts != 'reviewed')
            var class_label = 'danger';
        $("#sts_" + id).html('<span class="label label-' + class_label + '">' + sts + '</span>');
    });
}

function delete_blog_comments(id) {
    var myurl = base_url + 'adminmedia/blog_comments?id=' + id;
    var is_confirm = confirm("Are you sure you want to delete this Comment?");
    if (is_confirm) {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $.post(myurl, function (sts) {
            console.log(sts);
            if (sts == 'done')
                $("#row_" + id).fadeOut();
            else
                alert('OOps! Something went wrong.');
        });
    }

}

function delete_category(id) {
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

//=======End blog categories Module=======


//=======Start blog post Module=======
function reset_model() {
    $('#blog_post_form').trigger("reset");
    $('.err').html('');
    $('#blog_post_form_modal').modal('show');
    set_seo_limit_suggestions();
}

function add_blog_post() {
    reset_model();
    save_method = 'POST';
    $('#blog_post_form').attr('action', base_url + 'adminmedia/blog');
    console.log("Inside Fucntion");
    $('#methodPut').remove();
    $('.modal-title').text('Add Blog Post');
}

function delete_blog_post(id) {
    var is_confirm = confirm("Are you sure you want to delete this post?");
    if (is_confirm) {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $.ajax({
            url: base_url + "adminmedia/blog/" + id,
            type: "DELETE",
            success: function (sts) {
                if (sts == 'done')
                    $("#row_" + id).fadeOut();
                else
                    alert('OOps! Something went wrong.');
            },
            error: function (jqXHR, textStatus, errorThrown) {
                alert('Error adding / update data');
                console.log(jqXHR);
                console.log(textStatus);
                console.log(errorThrown);
            }
        });

    }
}

function update_blog_post_status(id) {
    var current_status = 'notset';
    var myurl = base_url + 'adminmedia/blog/' + id + '/edit?status=' + current_status;
    $.get(myurl, function(sts) {
        alertme('<i class="fas fa-check" aria-hidden="true"></i> Done Successfully ',
            'success', true, 1500);
    });
}


function load_blog_post_edit_form(id) {
    reset_model();
    $('.modal-title').text('Edit Blog Post');
    save_method = 'update';
    var my_editor_id = 'editor1';
    // set the content empty
    tinyMCE.get('editor1').setContent('');
    $('#edit_footer_menu').prop('checked', false);
    $('#edit_top_menu').prop('checked', false);
    $.getJSON(base_url + 'adminmedia/blog/' + id, function (data) {
        save_method = "PUT";
        $('#heading').val(data.title);
        $('#post_slug').val(data.post_slug);
        $('#date').val(data.dated);
        var abc = data.cate_ids;
        //abc=""+abc+"";
        abc = abc.split(',');
        abc.forEach(function (item) {
            $('#blog_cat_'+item).prop('checked', true);
        });

        if (data.featured_img == null || data.featured_img == '' || data.featured_img == 0) {
            $("#featured_img").fadeOut();
        } else {
            $("#featured_img").fadeIn();
            var img = '<div class="featured-images-main" id="products_img_' + data.ID + '">' +
                '<img style="width:150px" src="' + asset_uploads + '/blog/' + data.featured_img + '">' +
                '<i onClick="remove_blog_post_featured_image(' + data.ID + ');" class="deleteIcon"></i></div>';
            $('#featured_img').html('');
            $('#featured_img').append(img);

        }
        fillSeoFields(data);

        tinyMCE.get('editor1').setContent(data.description);
        $('#cms_id').val(data.ID);
        $('#blog_post_form').attr('action', base_url + 'adminmedia/blog/' + data.ID);
        if (!$('#methodPut').length) {
            $('<input>').attr({
                type: 'hidden',
                value: 'PUT',
                id: 'methodPut',
                name: '_method'
            }).appendTo('#blog_post_form');
        }
    });
}

function remove_blog_post_featured_image(id) {
    var deleteUrl = base_url + 'adminmedia/blog/remove_img';
    var is_confirm = confirm("Are you sure you want to delete this Post featured image?");
    if (is_confirm) {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $.post(deleteUrl, {
            id: id,
            folder: "blog"
        },function (sts) {
            if (sts === 'done')
                $("#products_img_" + id).fadeOut();
            else
                alert('OOps! Something went wrong.');
        });
    }
}

function save_blog_post() {
    var url = $('#blog_post_form').attr('action');;
    console.log(url);
    var content = tinyMCE.get('editor1').getContent();
    $('#editor1').val(content);
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    $.ajax({
        url: url,
        type: save_method,
        data: $("#blog_post_form").serialize(),
        success: function (data, status) {
            console.log(data);
            if ($.isEmptyObject(data.error)) {
                $('#blog_post_form_modal').modal('hide');
                $('#action_container').css('display','block');
                $('#post_action').text(data.success);
                location.reload();
                //setTimeout(location.reload.bind(url), 2000);
            }
            else {
                errorsHtml = '<div class="alert alert-danger"><ul>';
                $.each(data, function (key, value) {
                    errorsHtml += '<li>' + value[0] + '</li>'; //showing only the first error.
                });
                errorsHtml += '</ul></di>';
                $('#form-errors').html(errorsHtml);
            }
            $('#loading').hide();
        },
        error: function (jqXHR, textStatus, errorThrown) {
            if( jqXHR.status === 422 ) {
                var errors = jqXHR.responseJSON.errors; //this will get the errors response data.
                errorsHtml = '<div class="alert alert-danger"><ul>';
                $.each(errors, function (key, value) {
                    errorsHtml += '<li>' + value + '</li>';
                });
                errorsHtml += '</ul></di>';
                $('#form-errors').html(errorsHtml);
            }else {
                $('#loading').hide();
                console.log(jqXHR);
                console.log(textStatus);
                console.log(errorThrown);
                alert('Error adding / update data');
            }
        }
    });
}

//=======end blog post Module=======


