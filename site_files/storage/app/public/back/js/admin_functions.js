function seo_limit_suggestion(field_id, limit, notice_id) {
    var text_length = $('#' + field_id).val().length;
    $('#' + notice_id).html(text_length + ' characters');
    if (text_length > limit) {
        $('#' + notice_id).removeClass('text-success');
        $('#' + notice_id).addClass('text-danger');
    }
    else {
        $('#' + notice_id).removeClass('text-danger');
        $('#' + notice_id).addClass('text-success');
    }
}

function fillSeoFields(data) {
    if (data.meta_title && data.meta_title.length > 0) {
        $('#meta_title').val(data.meta_title);
    }
    if (data.meta_keywords && data.meta_keywords.length > 0) {
        $('#meta_keywords').val(data.meta_keywords);
    }
    if (data.meta_description && data.meta_description.length > 0) {
        $('#meta_description').val(data.meta_description);
    }
    if (data.canonical_url && data.canonical_url.length > 0) {
        $('#canonical_url').val(data.canonical_url);
    }
    set_seo_limit_suggestions();
}
function set_seo_limit_suggestions() {
    if ($('#meta_title').val().length > 0 ||
        $('#meta_keywords').val().length > 0 ||
        $('#meta_description').val().length > 0 ||
        $('#canonical_url').val().length > 0) {
        $('#seo_fields_div').show();
    } else {
        $('#seo_fields_div').hide();
    }
    seo_limit_suggestion('meta_title', 60, 'meta_title_char_countdown');
    seo_limit_suggestion('meta_keywords', 160, 'meta_keywords_char_countdown');
    seo_limit_suggestion('meta_description', 160, 'meta_description_char_countdown');
}

function confirmDel() {
    if (confirm("Are you sure you want to delete?")) {
        return true;
    }
    else {
        return false;
    }
}
//For admin panel left bar (hiding/showing)
function showme_page(val, arrowObj) {
    if ($(val + ':visible').length == 0) {
        $(val).slideDown(100);
        $(arrowObj).html('<i class="fa fa-angle-double-up" aria-hidden="true"></i>');
        $(arrowObj).attr('data-original-title', 'Show less');
    }
    else {
        $(val).slideUp(100);
        $(arrowObj).html('<i class="fa fa-angle-double-down" aria-hidden="true"></i>');
        $(arrowObj).attr('data-original-title', 'Show more');
    }
}
function show_hide_seo_fields(val, arrowObj) {
    if ($(val + ':visible').length == 0) {
        $(val).slideDown(1000);
        $(arrowObj).html('Manage SEO <i class="fa fa-angle-double-up" aria-hidden="true"></i>');
        $(arrowObj).attr('data-original-title', 'Show SEO Fields');
    }
    else {
        $(val).slideUp(700);
        $(arrowObj).html('Manage SEO <i class="fa fa-angle-double-down" aria-hidden="true"></i>');
        $(arrowObj).attr('data-original-title', 'Show SEO Fields');
    }
}
function string_to_slug(titleId, slugId) {
    var str = $("#" + titleId).val();
    var eventSlug = $("#" + slugId).val();
    if (eventSlug.length == "") {
        str = str.replace(/^\s+|\s+$/g, ''); // trim
        str = str.toLowerCase();
        // remove accents, swap ñ for n, etc
        var from = "àáäâèéëêìíïîòóöôùúüûñç·/_,:;";
        var to = "aaaaeeeeiiiioooouuuunc------";
        for (var i = 0, l = from.length; i < l; i++) {
            str = str.replace(new RegExp(from.charAt(i), 'g'), to.charAt(i));
        }
        str = str.replace(/[^a-z0-9 -]/g, '') // remove invalid chars
            .replace(/\s+/g, '-') // collapse whitespace and replace by -
            .replace(/-+/g, '-'); // collapse dashes
        //return str;
        $("#" + slugId).val(str);
    }
}
function load_social_media_add_form() {
    $('#add_page_form').modal('show');
}
function update_social_media_status(id) {
    var current_status = $("#sts_" + id + " i").html();
    var myurl = base_url + 'adminmedia/social_media/' + id + '/edit?status=' + current_status;
    $.get(myurl, function (sts) {
        var class_label = 'success';
        if (sts != 'active')
            var class_label = 'danger';
        $("#sts_" + id).html('<i class="label label-' + class_label + '">' + sts + '</i>');
    });
}
function load_social_media_edit_form(id) {
    $('#edit_footer_menu').prop('checked', false);
    $('#edit_top_menu').prop('checked', false);
    $.getJSON(base_url + 'adminmedia/social_media/' + id, function (data) {
        console.log(data);
        $('#edit_name').val(data.name);
        $('#edit_alt_tag').val(data.alt_tag);
        $('#edit_link').val(data.link);
        $('#i_class').val(data.i_class);
        $('#i_class_addon').html('<i class="fa ' + data.i_class + '"></i>');

        $('#edit_display_order').val(data.display_order);
        $('#edit-left-sidebar').attr('checked', false);
        if (data.open_in_new_tab == 'Yes') {
            $('#edit_open_in_new_tab').prop('checked', true);
        }
        $('#edit-footer').prop('checked', false);
        $('#socail_media_id').val(data.ID);
        $('#edit_page_form').modal('show');
    });
}
function delete_social_media(id) {
    var myurl = base_url + 'adminmedia/social_media/' + id;
    var is_confirm = confirm("Are you sure you want to delete this Widgets?");
    if (is_confirm) {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $.ajax({
            type: "DELETE",
            url: myurl,
            data: { '_token': $('meta[name="csrf-token"]').attr('content') },
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
function validate_edit_social_media_form(the_form) {
    if (the_form.edit_name.value == '') {
        alert("Please provide Social Media Name.");
        return false;
    }
    if (the_form.edit_alt_tag.value == '') {
        alert("Please provide Social media Alt Tag.");
        return false;
    }
}
function searchResult() {
    var data = $('#searchText').val();
    console.log(data);
    url = base_url + "adminmedia/search?q=" + data;
    $.ajax({
        url: url,
        type: 'GET',
        async: true,
        cache: false,
        contentType: 'JSON',
        processData: false,
        success: function (data) {
            console.log(data);
            data = JSON.parse(data);
            $('#result').html('');
            $('#result').hide('slow');
            var obj = data['pages'];
            for (var i = 0; i < obj.length; i++) {
                var obj1 = obj[i];
                $('#result').append('<li><a href="' + base_url + 'adminmedia/' + obj1.url + '"><i class="fa fa-arrow-circle-right" aria-hidden="true"></i>&nbsp;&nbsp;' + obj1.keyWords + '</a></li>');
            }
            var obj = data['modules'];
            for (var i = 0; i < obj.length; i++) {
                var obj1 = obj[i];
                $('#result').append('<li><a  href="' + base_url + 'adminmedia/module/' + obj1.type + '"><i class="fa fa-arrow-circle-right" aria-hidden="true"></i>&nbsp;&nbsp;' + obj1.title + '</a></li>');
            }
            var obj = data['cms'];
            for (var i = 0; i < obj.length; i++) {
                var obj1 = obj[i];
                $('#result').append('<li><a href="' + base_url + 'adminmedia/module/' + obj1.module.type + '?q=' + obj1.id + '"><i class="fa fa-arrow-circle-right" aria-hidden="true"></i>&nbsp;&nbsp;' + obj1.heading + '</a></li>');
            }
            $('#result').show('slow');
        },
        error: function (jqXHR, textStatus, errorThrown) {
            console.log(jqXHR);
            console.log(textStatus);
            console.log(errorThrown);
        }
    });
}
$(document).ready(function () {
    $("#sitemap").click(function () {
        $("#lContainer").css("display", "block");
        url = base_url + "adminmedia/site-map";
        $.ajax({
            url: url,
            type: 'GET',
            async: true,
            cache: false,
            success: function (data) {
                console.log(data);
                $("#lContainer").css("display", "none");
                var win = window.open(base_url + 'sitemap.xml', '_blank');
                win.focus();
            },
            error: function (jqXHR, textStatus, errorThrown) {
                console.log(jqXHR);
                console.log(textStatus);
                $("#lContainer").css("display", "none");
                console.log(errorThrown);
            }
        });
    });
});
function delete_widget(id) {
    var myurl = base_url + 'adminmedia/widgets/' + id;
    var is_confirm = confirm("Are you sure you want to delete this Widgets?");
    if (is_confirm) {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $.ajax({
            type: "DELETE",
            url: myurl,
            data: { '_token': $('meta[name="csrf-token"]').attr('content') },
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
$('#selected_image').on('change', function (event) {
    var selected_image_preview = document.getElementById('selected_image_preview');
    selected_image_preview.src = URL.createObjectURL(event.target.files[0]);
});
$('#selected_layout_image').on('change', function (event) {
    var selected_layout_image_preview = document.getElementById('selected_layout_image_preview');
    selected_layout_image_preview.src = URL.createObjectURL(event.target.files[0]);
});
$('#selected_images').on('change', function (event) {
    $('#selected_images_preview').html('');
    for (let index = 0; index < event.target.files.length; index++) {
        const src = URL.createObjectURL(event.target.files[index]);
        $('#selected_images_preview').append(
            '<div class="col-2 m-1"><img style="border-radius: 0px;" src="' + src +
            '" /></div>');
    }
});
$(function () {
    $('.icp-auto').on('click', function () {
        $('.icp-auto').iconpicker();
    }).trigger('click');
});
$(function () {
    $('.iconpicker-item').on('click', function () {
        //alert("test" );
        $('.iconpicker-popover').hide();
    });
});
$(document).on('focusin', function (e) {
    if ($(e.target).closest(".mce-window").length) {
        e.stopImmediatePropagation();
    }
});
$(document).ready(function () {
    $('.img_alt_title_label').on('click', function (e) {
        $(this).siblings('div').toggle();
    });
});
function alertme(text, type, autoClose, closeAfterSec) {
    var type = type || 'success';
    var autoClose = autoClose || true;
    var closeAfterSec = closeAfterSec || 3000;
    $(".alertme").hide();
    var mhtml =
        '<div class="alertme" id="div_alert" style="margin:5px;top:3%;position:fixed;z-index:9999;width:100%">' +
        '<div style="max-width: 700px;margin: 0 auto;" class="alert alert-' + type +
        ' alert-dismissible"> <button type="button" class="btn-close" data-bs-dismiss="alert"></button> ' + text +
        '</div></div>';
    $("body").append(mhtml);
    if (autoClose) {
        setTimeout(function () {
            $(".alertme").hide();
        }, closeAfterSec);
    }
}
function uploaded_files_show() {
    $('#image_preview').html("");
    var total_file = document.getElementById("uploadFile").files.length;
    for (var i = 0; i < total_file; i++) {
        $('#image_preview').append("<div class=\"col-md-1 card\"><img src='" + URL.createObjectURL(event.target
            .files[
            i]) + "'></div>");
    }
}
$('#before_image').on('change', function (event) {
    $('#before_image_preview').append("<div class=\"col-md-1 card\"><img src='" + URL.createObjectURL(event.target
        .files[0]) + "'></div>");
});
$('#after_image').on('change', function (event) {
    $('#after_image_preview').append("<div class=\"col-md-1 card\"><img src='" + URL.createObjectURL(event.target
        .files[0]) + "'></div>");
});
function showLoader() {
    $('#spinner').show();
}
$(document).ready(function () {
    $("form").on("submit", function (event) {
        showLoader();
    });
});