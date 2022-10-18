//For admin panel left bar (hiding/showing)
function seoModulToggle() {
    var seoClass = document.getElementById('seo-modul');
    if (seoClass.className == 'seo-modul-hide') {
        seoClass.className = 'seo-modul-sow';
    } else {
        seoClass.className = 'seo-modul-hide';
    }
}
function seoEditModulToggle() {
    var seoClass = document.getElementById('seo-edit-modul');
    if (seoClass.className == 'seo-edit-modul-hide') {
        seoClass.className = 'seo-edit-modul-sow';
    } else {
        seoClass.className = 'seo-edit-modul-hide';
    }
}
function showme_page(val,arrowObj){
  if($(val+':visible').length == 0)
  {
    $(val).slideDown(100);
    $(arrowObj).html('<i class="fa fa-angle-double-up" aria-hidden="true"></i>');
    $(arrowObj).attr('data-original-title','Show less');
  }
  else{
    $(val).slideUp(100);
    $(arrowObj).html('<i class="fa fa-angle-double-down" aria-hidden="true"></i>');
    $(arrowObj).attr('data-original-title','Show more');
  }
}
function showme_seo(val,arrowObj){
  if($(val+':visible').length == 0)
  {
    $(val).slideDown(1000);
    $(arrowObj).html('Manage SEO <i class="fa fa-angle-double-up" aria-hidden="true"></i>');
    $(arrowObj).attr('data-original-title','Show less');
  }
  else{
    $(val).slideUp(700);
    $(arrowObj).html('Manage SEO <i class="fa fa-angle-double-down" aria-hidden="true"></i>');
    $(arrowObj).attr('data-original-title','Show more');
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
//For admin panel left bar (hiding/showing)
$(function () {
    "use strict";
    //Enable sidebar toggle
    $("[data-toggle='offcanvas']").click(function (e) {
        e.preventDefault();
        //If window is small enough, enable sidebar push menu
        if ($(window).width() <= 992) {
            $('.row-offcanvas').toggleClass('active');
            $('.left-side').removeClass("collapse-left");
            $(".right-side").removeClass("strech");
            $('.row-offcanvas').toggleClass("relative");
        } else {
            //Else, enable content streching
            var leftSideBar;
            if ($('.collapse-left').length)
                leftSideBar = 0;
            else
                leftSideBar = 1;
            $('.left-side').toggleClass("collapse-left");
            $(".right-side").toggleClass("strech");
            console.log(leftSideBar);
            var myurl = baseUrl + 'adminmedia/leftsidebar/session?preference=' + leftSideBar;
            $.get(myurl, function (sts) {
            });
        }
    });
    //Add hover support for touch devices
    $('.btn').bind('touchstart', function () {
        $(this).addClass('hover');
    }).bind('touchend', function () {
        $(this).removeClass('hover');
    });
    //Activate tooltips
    $("[data-toggle='tooltip']").tooltip();
    /*
     * Add collapse and remove events to boxes
     */
    $("[data-widget='collapse']").click(function () {
        //Find the box parent
        var box = $(this).parents(".box").first();
        //Find the body and the footer
        var bf = box.find(".box-body, .box-footer");
        if (!box.hasClass("collapsed-box")) {
            box.addClass("collapsed-box");
            bf.slideUp();
        } else {
            box.removeClass("collapsed-box");
            bf.slideDown();
        }
    });
    /*
     * ADD SLIMSCROLL TO THE TOP NAV DROPDOWNS
     * ---------------------------------------
     */
    /*$(".navbar .menu").slimscroll({
        height: "200px",
        alwaysVisible: false,
        size: "3px"
    }).css("width", "100%");*/
    /*
     * INITIALIZE BUTTON TOGGLE
     * ------------------------
     */
    $('.btn-group[data-bs-toggle="btn-toggle"]').each(function () {
        var group = $(this);
        $(this).find(".btn").click(function (e) {
            group.find(".btn.active").removeClass("active");
            $(this).addClass("active");
            e.preventDefault();
        });
    });
    $("[data-widget='remove']").click(function () {
        //Find the box parent
        var box = $(this).parents(".box").first();
        box.slideUp();
    });
    /* Sidebar tree view */
    /* $(".sidebar .treeview").tree();*/
    /*
     * Make sure that the sidebar is streched full height
     * ---------------------------------------------
     * We are gonna assign a min-height value every time the
     * wrapper gets resized and upon page load. We will use
     * Ben Alman's method for detecting the resize event.
     *
     **/
    function _fix() {
        //Get window height and the wrapper height
        var height = $(window).height() - $("body > .header").height();
        $(".wrapper").css("min-height", height + "px");
        var content = $(".wrapper").height();
        //If the wrapper height is greater than the window
        if (content > height)
        //then set sidebar height to the wrapper
            $(".left-side, html, body").css("min-height", content + "px");
        else {
            //Otherwise, set the sidebar to the height of the window
            $(".left-side, html, body").css("min-height", height + "px");
        }
    }
    //Fire upon load
    _fix();
    //Fire when wrapper is resized
    /*
     * We are gonna initialize all checkbox and radio inputs to
     * iCheck plugin in.
     * You can find the documentation at http://fronteed.com/iCheck/
     */
    /* For demo purposes */
});
//=======Starts Employer Module=======
function update_status(id) {
    var current_status = $("#sts_" + id + " span").html();
    var myurl = baseUrl + 'employers/status/' + id + '/' + current_status;
    $.get(myurl, function (sts) {
        var class_label = 'success';
        if (sts != 'active')
            var class_label = 'danger';
        $("#sts_" + id).html('<span class="label label-' + class_label + '">' + sts + '</span>');
    });
}
function update_top_employer_status(id) {
    var current_status = $("#te_" + id + " span").html();
    var myurl = baseUrl + 'employers/top_employer_status/' + id + '/' + current_status;
    $.get(myurl, function (sts) {
        var class_label = 'success';
        if (sts != 'yes')
            var class_label = 'warning';
        $("#te_" + id).html('<span class="label label-' + class_label + '">' + sts + '</span>');
    });
}
function update_top_industry_status(id) {
    var current_status = $("#ti_" + id + " span").html();
    var myurl = baseUrl + 'industries/top_industry_status/' + id + '/' + current_status;
    $.get(myurl, function (sts) {
        var class_label = 'success';
        if (sts != 'yes')
            var class_label = 'warning';
        $("#ti_" + id).html('<span class="label label-' + class_label + '">' + sts + '</span>');
    });
}
function delete_employer(id) {
    var myurl = baseUrl + 'employers/delete_employer/' + id;
    var is_confirm = confirm("Are you sure you want to delete this employer and associated company and jobs with it?");
    if (is_confirm) {
        $.get(myurl, function (sts) {
            if (sts == 'done')
                $("#row_" + id).fadeOut();
            else
                alert('OOps! Something went wrong.');
        });
    }
}
//=======Ends Employer Module=======
//=======Starts Client Module=======
function update_client_status(id) {
    var current_status = $("#sts_" + id + " span").html();
    var myurl = baseUrl + 'clients/status/' + id + '/' + current_status;
    $.get(myurl, function (sts) {
        var class_label = 'success';
        if (sts != 'Active')
            var class_label = 'danger';
        if (sts != 'Active' && sts != 'Inactive')
            alert(sts);
        else
            $("#sts_" + id).html('<span class="label label-' + class_label + '">' + sts + '</span>');
    });
}
function delete_client(id) {
    var myurl = baseUrl + 'clients/delete/' + id;
    var is_confirm = confirm("Are you sure you want to delete this client?");
    if (is_confirm) {
        $.get(myurl, function (sts) {
            if (sts == 'done')
                $("#row_" + id).fadeOut();
            else
                alert('OOps! Something went wrong.');
        });
    }
}
//=======Ends Client Module=======
//=======Starts Social Media Module=======
// function update_social_media_status(id) {
//     var current_status = $("#sts_" + id + " span").html();
//     var myurl = baseUrl + 'social_media/status/' + id + '/' + current_status;
//     $.get(myurl, function (sts) {
//         var class_label = 'success';
//         if (sts != 'active')
//             var class_label = 'danger';
//         $("#sts_" + id).html('<span class="label label-' + class_label + '">' + sts + '</span>');
//     });
// }
// function delete_social_media(id) {
//     var myurl = baseUrl + 'social_media/delete/' + id;
//     var is_confirm = confirm("Are you sure you want to delete this ?");
//     if (is_confirm) {
//         $.get(myurl, function (sts) {
//             if (sts == 'done')
//                 $("#row_" + id).fadeOut();
//             else
//                 alert('OOps! Something went wrong.');
//         });
//     }
// }
//=======services Module=======
function update_services_status(id) {
    var current_status = $("#sts_" + id + " span").html();
    var myurl = baseUrl + 'services/status/' + id + '/' + current_status;
    $.get(myurl, function (sts) {
        var class_label = 'success';
        if (sts != 'active')
            var class_label = 'danger';
        $("#sts_" + id).html('<span class="label label-' + class_label + '">' + sts + '</span>');
    });
}
function delete_services(id) {
    var myurl = baseUrl + 'services/delete/' + id;
    var is_confirm = confirm("Are you sure you want to delete this ?");
    if (is_confirm) {
        $.get(myurl, function (sts) {
            if (sts == 'done')
                $("#row_" + id).fadeOut();
            else
                alert('OOps! Something went wrong.');
        });
    }
}
//=======services Module=======
function update_widgets_status(id) {
    var current_status = $("#sts_" + id + " span").html();
    var myurl = baseUrl + 'widgets/status/' + id + '/' + current_status;
    $.get(myurl, function (sts) {
        var class_label = 'success';
        if (sts != 'active')
            var class_label = 'danger';
        $("#sts_" + id).html('<span class="label label-' + class_label + '">' + sts + '</span>');
    });
}
function delete_widgets(id) {
    var myurl = baseUrl + 'widgets/delete/' + id;
    var is_confirm = confirm("Are you sure you want to delete this ?");
    if (is_confirm) {
        $.get(myurl, function (sts) {
            if (sts == 'done')
                $("#row_" + id).fadeOut();
            else
                alert('OOps! Something went wrong.');
        });
    }
}
//=======Starts CMS Module=======
function update_cms_status(id) {
    var current_status = $("#sts_" + id + " span").html();
    var myurl = baseUrl + 'cms/status/' + id + '/' + current_status;
    $.get(myurl, function (sts) {
        var class_label = 'success';
        if (sts != 'active')
            var class_label = 'danger';
        $("#sts_" + id).html('<span class="label label-' + class_label + '">' + sts + '</span>');
    });
}
function delete_cms(id) {
    var myurl = baseUrl + 'cms/delete/' + id;
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
//=======Starts Plugin Module=======
function load_plugin_add_form() {
    $('#add_page_form').modal('show');
}
function load_plugin_edit_form(id) {
    $('#edit_show_on_dashbord').prop('checked', false);
    $.getJSON(baseUrl + 'plugin/get_plugin_by_id/' + id, function (data) {
        $('#edit_title').val(data.title);
        $('#edit_slug').val(data.slug);
        $('#edit_url').val(data.url);
        $('#edit_class_name').val(data.class_name);
        if (data.show_on_dashbord == 1)
            $('#edit_show_on_dashbord').prop('checked', true);
        $('#plugin_id').val(data.id);
        $('#edit_page_form').modal('show');
    });
}
function update_plugin_status(id) {
    var current_status = $("#sts_" + id + " span").html();
    var myurl = baseUrl + 'plugin/status/' + id + '/' + current_status;
    $.get(myurl, function (sts) {
        var class_label = 'success';
        if (sts != 'active')
            var class_label = 'danger';
        $("#sts_" + id).html('<span class="label label-' + class_label + '">' + sts + '</span>');
    });
}
function delete_plugin(id) {
    var myurl = baseUrl + 'plugin/delete/' + id;
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
function validate_edit_plugin_form(the_form) {
    if (the_form.edit_heading.value == '') {
        alert("Please provide page heading.");
        return false;
    }
    if (the_form.edit_page_slug.value == '') {
        alert("Please provide page slug.");
        return false;
    }
    if (CKEDITOR.instances['edit_editor1'].getData() == '') {
        alert("Please provide page content.");
        return false;
    }
}
//=======Ends Plugin Module=======
function load_block_add_form() {
    $('#add_page_form').modal('show');
}
function load_widgets_edit_form(id) {
    $('#edit_footer_menu').prop('checked', false);
    $('#edit_top_menu').prop('checked', false);
    $.getJSON(baseUrl + 'widgets/get_widgets_by_id/' + id, function (data) {
        $('#edit_heading').val(data.heading);
        CKEDITOR.instances['edit_editor1'].setData(data.content);
        $('#widgets_id').val(data.ID);
        
        $('#edit_page_form').modal('show');
    });
}
function update_block_status(id) {
    var current_status = $("#sts_" + id + " span").html();
    var myurl = baseUrl + 'widgets/status/' + id + '/' + current_status;
    $.get(myurl, function (sts) {
        var class_label = 'success';
        if (sts != 'active')
            var class_label = 'danger';
        $("#sts_" + id).html('<span class="label label-' + class_label + '">' + sts + '</span>');
    });
}
function delete_block(id) {
    var myurl = baseUrl + 'widgets/delete/' + id;
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
function validate_edit_block_form(the_form) {
//	  if(the_form.edit_heading.value==''){
//		alert("Please provide page heading.");
//		return false;
//	  }
    if (CKEDITOR.instances['edit_editor1'].getData() == '') {
        alert("Please provide page content.");
        return false;
    }
}
//=======Ends Block Module=======
//=======Starts City Module=======
function grab_cities_by_country(country_name) {
    if (country_name == 'Pakistan') {
        $("#city_dropdown").css('display', 'block');
        $("#city_text").css('display', 'none');
    }
    else {
        $("#city_dropdown").css('display', 'none');
        $("#city_text").css('display', 'block');
        $("#city_text").val('');
    }
}
//=======Ends City Module=======
$(document).ready(function () {
    $('#client_employee_ssn_number').bind('keyup blur', function () {
            $(this).val($(this).val().replace(/[^0-9]/g, ''));
        }
    );
    $('#client_employee_phone').bind('keyup blur', function () {
            $(this).val($(this).val().replace(/[^0-9]/g, ''));
        }
    );
    setTimeout(function () {
        $(".message-container").fadeOut();
        $(".text-green").fadeOut();
    }, 10000);
});
function load_cms_add_form() {
    $('#frm_cms').trigger("reset");
    $('#add_page_form').modal('show');
}
function load_cms_edit_form(id) {
    var my_editor_id = 'editor1';
    $('#edit_frm_cms').trigger("reset");
    // set the content empty
    tinymce.get(my_editor_id).setContent('');
    $('#edit_footer_menu').prop('checked', false);
    $('#edit_top_menu').prop('checked', false);
    $.getJSON(baseUrl + 'cms/get_cms_by_id/' + id, function (data) {
        $('#edit_heading').val(data.heading);
        $('#edit_page_slug').val(data.page_slug);
        if (data.featured_img == null || data.featured_img == '' || data.featured_img == 0) {
            //  $("#featured-no-images").fadeIn();
            $("#featured_img").fadeOut();
        } else {
            $("#featured_img").fadeIn();
            // $("#featured-no-images").fadeOut();
            // alert(front_uploads);
            // $("#cmsimages").attr('src', '../public/uploads/cms/thumb/'+data.featured_img);
            var img = '<div class="featured-images-main" id="products_img_' + data.ID + '"><img style="width:150px" src="' + front_uploads + 'cms/thumb/' + data.featured_img + '"><i onClick="remove_cms_featured_image(' + data.ID + ');" class="deleteIcon"></i></div>';
            $('#featured_img').html('');
            $('#featured_img').append(img);
        }
        var seoClass = document.getElementById('seo-edit-modul');
        if (data.meta_title.length > 0 || data.meta_keywords.length > 0 || data.meta_description.length > 0 || data.canonical_url.length > 0) {
            $('#edit_meta_title').val(data.meta_title);
            $('#edit_meta_keywords').val(data.meta_keywords);
            $('#edit_meta_description').val(data.meta_description);
            $('#edit_canonical_url').val(data.canonical_url);
            seoClass.className = 'seo-edit-modul-sow';
        } else {
            seoClass.className = 'seo-edit-modul-hide';
        }
        tinymce.activeEditor.execCommand('mceInsertContent', false, data.content);
        $('#cms_id').val(data.ID);
        $('#edit_page_form').modal('show');
    });
}
function remove_cms_featured_image(id) {
    var myurl = baseUrl + 'cms/remove_cms_feature_image/' + id;
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
//=======Sallary Module=======
function validate_edit_salary_form(the_form) {
    if (the_form.edit_salary_value.value == '') {
        alert("Please provide salary value.");
        return false;
    }
    if (the_form.edit_sallary_text.value == '') {
        alert("Please provide salary text.");
        return false;
    }
}
function delete_salary(id) {
    var myurl = baseUrl + 'salary/delete/' + id;
    var is_confirm = confirm("Are you sure you want to delete this salary?");
    if (is_confirm) {
        $.get(myurl, function (sts) {
            if (sts == 'done')
                $("#row_" + id).fadeOut();
            else
                alert('OOps! Something went wrong.');
        });
    }
}
$(document).ready(function () {
    setTimeout(function () {
        $(".message-container").fadeOut();
    }, 10000);
});
function load_salary_add_form() {
    $('#add_page_form').modal('show');
}
function load_salary_edit_form(id) {
    $.getJSON(baseUrl + 'salary/get_salary_by_id/' + id, function (data) {
        $('#edit_salary_value').val(data.val);
        $('#edit_salary_text').val(data.text);
        $('#salary_id').val(data.ID);
        $('#edit_page_form').modal('show');
    });
}
//=======End Sallary Module=======
//=======Qualification Module=======
function validate_edit_qualification_form(the_form) {
    if (the_form.edit_qualification_value.value == '') {
        alert("Please provide qualification.");
        return false;
    }
    if (the_form.edit_qualification_text.value == '') {
        alert("Please provide salary text.");
        return false;
    }
}
function delete_qualification(id) {
    var myurl = baseUrl + 'qualification/delete/' + id;
    var is_confirm = confirm("Are you sure you want to delete this qualification?");
    if (is_confirm) {
        $.get(myurl, function (sts) {
            if (sts == 'done')
                $("#row_" + id).fadeOut();
            else
                alert('OOps! Something went wrong.');
        });
    }
}
$(document).ready(function () {
    setTimeout(function () {
        $(".message-container").fadeOut();
    }, 10000);
});
function load_qualification_add_form() {
    $('#add_page_form').modal('show');
}
function load_qualification_edit_form(id) {
    $.getJSON(baseUrl + 'qualification/get_qualification_by_id/' + id, function (data) {
        $('#edit_qualification').val(data.val);
        $('#edit_text').val(data.text);
        $('#qualification_id').val(data.ID);
        $('#edit_page_form').modal('show');
    });
}
//=======End CMS Module=======
//=======Starts Industries Module=======
function update_industries_status(id) {
    var current_status = $("#sts_" + id + " span").html();
    var myurl = baseUrl + 'industries/status/' + id + '/' + current_status;
    $.get(myurl, function (sts) {
        var class_label = 'success';
        if (sts != 'active')
            var class_label = 'danger';
        $("#sts_" + id).html('<span class="label label-' + class_label + '">' + sts + '</span>');
    });
}
function delete_industries(id) {
    var myurl = baseUrl + 'industries/delete/' + id;
    var is_confirm = confirm("Are you sure you want to delete this industry?");
    if (is_confirm) {
        $.get(myurl, function (sts) {
            if (sts == 'done')
                $("#row_" + id).fadeOut();
            else
                alert('OOps! Something went wrong.');
        });
    }
}
function validate_edit_industries_form(the_form) {
    if (the_form.edit_industries.value == '') {
        alert("Please provide industry name.");
        return false;
    }
}
$(document).ready(function () {
    setTimeout(function () {
        $(".message-container").fadeOut();
    }, 10000);
});
function load_industries_add_form() {
    $('#add_page_form').modal('show');
}
function load_industries_edit_form(id) {
    $.getJSON(baseUrl + 'industries/get_industries_by_id/' + id, function (data) {
        $('#edit_industries').val(data.industry_name);
        $('#industries_id').val(data.ID);
        $('#edit_page_form').modal('show');
    });
}
//=======Ends Industries Module=======
//=======Starts Institute Module=======
function update_institute_status(id) {
    var current_status = $("#sts_" + id + " span").html();
    var myurl = baseUrl + 'institute/status/' + id + '/' + current_status;
    $.get(myurl, function (sts) {
        var class_label = 'success';
        if (sts != 'active')
            var class_label = 'danger';
        $("#sts_" + id).html('<span class="label label-' + class_label + '">' + sts + '</span>');
    });
}
function delete_institute(id) {
    var myurl = baseUrl + 'institute/delete/' + id;
    var is_confirm = confirm("Are you sure you want to delete this institute?");
    if (is_confirm) {
        $.get(myurl, function (sts) {
            if (sts == 'done')
                $("#row_" + id).fadeOut();
            else
                alert('OOps! Something went wrong.');
        });
    }
}
function validate_edit_institute_form(the_form) {
    if (the_form.edit_institute.value == '') {
        alert("Please provide institute name.");
        return false;
    }
}
$(document).ready(function () {
    setTimeout(function () {
        $(".message-container").fadeOut();
    }, 10000);
});
function load_institute_add_form() {
    $('#add_page_form').modal('show');
}
function load_institute_edit_form(id) {
    $.getJSON(baseUrl + 'institute/get_institute_by_id/' + id, function (data) {
        $('#edit_institute').val(data.name);
        $('#institute_id').val(data.ID);
        $('#edit_page_form').modal('show');
    });
}
//=======Ends Institute Module=======
//=======Starts Stories Module=======
function update_stories_status(id) {
    var current_status = $("#sts_" + id + " span").html();
    var myurl = baseUrl + 'stories/status/' + id + '/' + current_status;
    $.get(myurl, function (sts) {
        var class_label = 'success';
        if (sts != 'active')
            var class_label = 'danger';
        $("#sts_" + id).html('<span class="label label-' + class_label + '">' + sts + '</span>');
    });
}
function delete_stories(id) {
    var myurl = baseUrl + 'stories/delete/' + id;
    var is_confirm = confirm("Are you sure you want to delete this institute?");
    if (is_confirm) {
        $.get(myurl, function (sts) {
            if (sts == 'done')
                $("#row_" + id).fadeOut();
            else
                alert('OOps! Something went wrong.');
        });
    }
}
function validate_edit_stories_form(the_form) {
    if (the_form.edit_title.value == '') {
        alert("Please provide story title.");
        return false;
    }
    if (the_form.edit_storyg.value == '') {
        alert("Please provide story.");
        return false;
    }
}
$(document).ready(function () {
    setTimeout(function () {
        $(".message-container").fadeOut();
    }, 10000);
});
function load_stories_add_form() {
    $('#add_page_form').modal('show');
}
function load_stories_edit_form(id) {
    $.getJSON(baseUrl + 'stories/get_stories_by_id/' + id, function (data) {
        $('#edit_title').val(data.title);
        $('#edit_story').val(data.story);
        $('#stories_id').val(data.ID);
        $('#edit_page_form').modal('show');
    });
}
//=======Ends Stories Module=======
//=======Starts Cities Module=======
function update_cities_status(id) {
    var current_status = $("#show_" + id + " span").html();
    var myurl = baseUrl + 'cities/status/' + id + '/' + current_status;
    $.get(myurl, function (show) {
        var class_label = 'success';
        if (show != '1')
            var class_label = 'danger';
        $("#show_" + id).html('<span class="label label-' + class_label + '">' + show + '</span>');
    });
}
function delete_cities(id) {
    var myurl = baseUrl + 'cities/delete/' + id;
    var is_confirm = confirm("Are you sure you want to delete this city?");
    if (is_confirm) {
        $.get(myurl, function (show) {
            if (show == 'done')
                $("#row_" + id).fadeOut();
            else
                alert('OOps! Something went wrong.');
        });
    }
}
function validate_edit_cities_form(the_form) {
    if (the_form.edit_city_name.value == '') {
        alert("Please provide city name.");
        return false;
    }
}
$(document).ready(function () {
    setTimeout(function () {
        $(".message-container").fadeOut();
    }, 10000);
});
function load_cities_add_form() {
    $('#add_page_form').modal('show');
}
function load_cities_edit_form(id) {
    $.getJSON(baseUrl + 'cities/get_city_by_id/' + id, function (data) {
        $('#edit_city_name').val(data.city_name);
        $('#cities_id').val(data.ID);
        $('#edit_page_form').modal('show');
    });
}
//=======Ends Cities Module=======
//=======Starts Countries Module=======
function delete_countries(id) {
    var myurl = baseUrl + 'countries/delete/' + id;
    var is_confirm = confirm("Are you sure you want to delete this country?");
    if (is_confirm) {
        $.get(myurl, function (show) {
            if (show == 'done')
                $("#row_" + id).fadeOut();
            else
                alert('OOps! Something went wrong.');
        });
    }
}
function validate_edit_countries_form(the_form) {
    if (the_form.edit_country_name.value == '') {
        alert("Please provide country name.");
        return false;
    }
}
$(document).ready(function () {
    setTimeout(function () {
        $(".message-container").fadeOut();
    }, 10000);
});
function load_countries_add_form() {
    $('#add_page_form').modal('show');
}
function load_countries_edit_form(id) {
    $.getJSON(baseUrl + 'countries/get_country_by_id/' + id, function (data) {
        $('#edit_country_name').val(data.country_name);
        $('#countries_id').val(data.ID);
        $('#edit_page_form').modal('show');
    });
}
//=======Ends Countries Module=======
//====== Load Employer Quick Views
function load_quick_profile_view(arr, total_jobs) {
    $('#quick_profile').modal('show');
    arr = arr.replace(/(\r\n|\n|\r)/gm, " ");
    var json_encoded_double = arr.replace(/dquote/g, '"');
    var json_encoded = json_encoded_double.replace(/squote/g, "'");
    var obj = jQuery.parseJSON(json_encoded);
    $("#emailllll").html(obj.email);
    $("#comp_name").html(obj.company_name);
    $("#address").html(obj.company_location);
    $("#phone").html(obj.company_phone);
    $("#city_country").html(obj.city + ' / ' + obj.country);
    $("#no_of_jobs").html(total_jobs);
}
//====== Load Employer Quick Job Views
function load_quick_job_view(emp_id, comp_name) {
    $('#quick_job').modal('show');
    $("#j_comp_name").html(comp_name);
    $.getJSON(baseUrl + 'posted_jobs/latest_job_by_company/' + emp_id, function (data) {
        if (data.err) {
            $("#j_box").css('display', 'none');
            $("#errbox").css('display', 'block');
            $("#errbox").html(data.err);
        } else {
            $("#j_box").css('display', 'block');
            $("#errbox").css('display', 'none');
            $("#job_title").html(data.job_title);
            $("#job_cat").html(data.industry_name);
            $("#job_desc").html(data.job_description.substr(1, 150) + '...');
            $("#contact_name").html(data.contact_person);
            $("#contact_phone").html(data.contact_phone);
            $("#contact_email").html(data.contact_email);
        }
    });
}
//======== Edit employer
function validate_frm_employer(theForm) {
    if (admin_is_empty($("#full_name"), 'full_name', 'full name')) return false;
    if (admin_is_empty($("#email"), 'email', 'email')) return false;
    if (admin_is_empty($("#password"), 'password', 'password')) return false;
    if (admin_is_empty($("#mobile_phone"), 'mobile_phone', 'mobile_phone')) return false;
    if (admin_is_empty($("#country"), 'country', 'country')) return false;
    if (admin_is_empty($("#city_text"), 'city_text', 'city')) return false;
    if ($("#err_fld").val() == '1') {
        alert("This email address is already taken. Please try again.");
        $("#email").focus();
        return false;
    }
}
$(document).ready(function () {
    $("#frm_employer #email").blur(function () {
        $.ajax({
            type: "POST",
            url: baseUrl + "employers/check_email_address",
            data: {id: $("#eid").val(), email: $("#email").val()}
        })
            .done(function (msg) {
                if (msg == '0') {
                    $("#err_fld").val('');
                }
                else {
                    $("#err_fld").val('1');
                    //alert("This email address is already taken. Please try again.");
                }
            });
    });
});
//======= Validate Company
function validate_frm_company(theForm) {
    if (admin_is_empty($("#company_name"), 'company_name', 'company name')) return false;
    if (admin_is_empty($("#industry_ID"), 'industry_ID', 'industry')) return false;
    if (admin_is_empty($("#company_phone"), 'company_phone', 'phone')) return false;
    if (admin_is_empty($("#company_location"), 'company_location', 'company address')) return false;
    if (admin_is_empty($("#company_website"), 'company_website', 'company website')) return false;
    if ($('#company_logo').val() != '') {
        ext_array = ['png', 'jpg', 'jpeg'];
        var ext = $('#company_logo').val().split('.').pop().toLowerCase();
        if ($.inArray(ext, ext_array) == -1) {
            alert('Invalid file provided.');
            $('#err_cfld').val('1');
            return false;
        }
    }
    if ($("#err_cfld").val() == '1') {
        alert("Invalid image file provided.");
        $("#company_logo").focus();
        return false;
    }
}
//=======Starts Prohibited Keywords Module=======
function load_prohibited_add_form() {
    $('#add_key_form').modal('show');
}
function load_prohibited_edit_form(id) {
    $.getJSON(baseUrl + 'prohibited_keyword/get_prohibited_keyword_by_id/' + id, function (data) {
        $('#edit_keyword').val(data.keyword);
        $('#key_id').val(data.ID);
        $('#edit_key_form').modal('show');
    });
}
function delete_prohibited(id) {
    var myurl = baseUrl + 'prohibited_keyword/delete/' + id;
    var is_confirm = confirm("Are you sure you want to delete this keyword?");
    if (is_confirm) {
        $.get(myurl, function (sts) {
            if (sts == 'done')
                $("#row_" + id).fadeOut();
            else
                alert('OOps! Something went wrong.');
        });
    }
}
function validate_edit_prohibited_form(the_form) {
    if (the_form.edit_keyword.value == '') {
        alert("Please provide keyword.");
        return false;
    }
}
//=======Ends Prohibited Keywords Module=======
//===== Email Template Section
function validate_edit_cms_form(the_form) {
    if (the_form.from_email.value == '') {
        alert('Please provide "From Email" address.');
        return false;
    }
    if (the_form.subject.value == '') {
        alert("Please provide email subject.");
        return false;
    }
    if (CKEDITOR.instances['editor1'].getData() == '') {
        alert("Please provide email content.");
        return false;
    }
}
function load_email_template_edit_form(id) {
    $.getJSON(baseUrl + 'email_template/get_email_template_by_id/' + id, function (data) {
        $('#from_name').val(data.from_name);
        $('#from_email').val(data.from_email);
        $('#subject').val(data.subject);
        $('#eid').val(data.ID);
        CKEDITOR.instances['editor1'].setData(data.content);
        $('#edit_email_form').modal('show');
    });
}
//Ends Email template section
//===== Skill Section
function validate_edit_skill_form(the_form) {
    if (the_form.skill_name.value == '') {
        alert('Please provide skill name.');
        return false;
    }
    if ($('#skill_name').val() == $('#blend_to').val()) {
        alert('You have selected same skill to blend into. Please select different skill.');
        return false;
    }
    if (the_form.blend_to.value != '') {
        var cc = confirm('Are you sure you want to blend "' + $('#skill_name').val() + '" into "' + $('#blend_to').val() + '"?');
        if (!cc)
            return false;
    }
}
function load_skill_edit_form(id) {
    $.getJSON(baseUrl + 'skills/get_skill_by_id/' + id, function (data) {
        $('#skill_name').val(data.skill_name);
        $('#sid').val(data.ID);
        //$("#blend_to option[value='"+data.skill_name+"']").remove();
        $('#edit_skill_form').modal('show');
    });
    select_option_value('blend_to', '');
}
function load_skill_add_form(id) {
    $('#add_skill_form').modal('show');
}
function update_skill_frequency(id, keyword) {
    var new_skill = $("#main_skills_" + id).val();
    if (new_skill == '') {
        alert('Please select new skill first.');
        return false;
    }
    if (new_skill == keyword) {
        alert('Sorry, both skills are same.');
        return false;
    }
    $("#r_" + id).fadeOut();
    $.ajax({
        type: "POST",
        url: baseUrl + "skills/update_skill_frequency",
        data: {original_skill: keyword, new_skill: new_skill}
    })
        .done(function (msg) {
            /*if(msg=='0'){
						//$("#err_fld").val('');
					}
					else{
						//$("#err_fld").val('1');
						//alert("This email address is already taken. Please try again.");
					}*/
        });
}
function validate_add_skill_form() {
    if ($('#add_skill_name').val() == '') {
        alert('Please provide skill first.');
        return false;
    }
}
function add_skill_frequency(id, keyword) {
    $("#r_" + id).fadeOut();
    $.ajax({
        type: "POST",
        url: baseUrl + "skills/add_skill_frequency",
        data: {new_skill: keyword}
    })
        .done(function (msg) {
            /*if(msg=='0'){
						//$("#err_fld").val('');
					}
					else{
						//$("#err_fld").val('1');
						//alert("This email address is already taken. Please try again.");
					}*/
        });
}
function delete_skill(id) {
    var myurl = baseUrl + 'skills/delete/' + id;
    var is_confirm = confirm("Are you sure you want to delete this skill?");
    if (is_confirm) {
        $.get(myurl, function (sts) {
            $("#row_" + id).fadeOut();
            /* if(sts=='done')
				  $("#row_"+id).fadeOut();
			  else
				  alert('OOps! Something went wrong.');*/
        });
    }
}
//Ends Skill section
//====== Load Job Quick Previews
function load_quick_job_preview(job_id, comp_name) {
    $('#quick_job').modal('show');
    $("#j_comp_name").html(comp_name);
    $.getJSON(baseUrl + 'posted_jobs/job_by_id/' + job_id, function (data) {
        if (data.err) {
            $("#j_box").css('display', 'none');
            $("#errbox").css('display', 'block');
            $("#errbox").html(data.err);
        } else {
            $("#j_box").css('display', 'block');
            $("#errbox").css('display', 'none');
            $("#job_title").html(data.job_title);
            $("#job_cat").html(data.industry_name);
            $("#job_desc").html(data.job_description.substr(1, 150) + '...');
            $("#contact_name").html(data.contact_person);
            $("#contact_phone").html(data.contact_phone);
            $("#contact_email").html(data.contact_email);
        }
    });
}
function select_option_value(field_id, val) {
    $("#" + field_id).val('');
}
//=======Starts Newsletter Module=======
function load_newsletter_add_form() {
    $('#add_newsletter_form').modal('show');
}
function load_newsletter_edit_form(id) {
    $.getJSON(baseUrl + 'manage_newsletters/get_record_by_id/' + id, function (data) {
        $('#edit_from_name').val(data.from_name);
        $('#edit_from_email').val(data.from_email);
        $('#edit_email_subject').val(data.email_subject);
        $('#edit_email_interval').val(data.email_interval);
        CKEDITOR.instances['edit_editor1'].setData(data.email_body)
        $('#n_id').val(data.ID);
        $('#edit_newsletter_form').modal('show');
    });
}
function update_newsletter_status(id) {
    var current_status = $("#sts_" + id + " span").html();
    var myurl = baseUrl + 'manage_newsletters/status/' + id + '/' + current_status;
    $.get(myurl, function (sts) {
        var class_label = 'success';
        if (sts != 'active')
            var class_label = 'danger';
        $("#sts_" + id).html('<span class="label label-' + class_label + '">' + sts + '</span>');
    });
}
function delete_newsletter(id) {
    var myurl = baseUrl + 'manage_newsletters/delete/' + id;
    var is_confirm = confirm("Are you sure you want to delete this newsletter?");
    if (is_confirm) {
        $.get(myurl, function (sts) {
            if (sts == 'done')
                $("#row_" + id).fadeOut();
            else
                alert('OOps! Something went wrong.');
        });
    }
}
function validate_edit_newsletter_form(the_form) {
    if (the_form.edit_heading.value == '') {
        alert("Please provide page heading.");
        return false;
    }
    if (the_form.edit_page_slug.value == '') {
        alert("Please provide page slug.");
        return false;
    }
    if (CKEDITOR.instances['edit_editor1'].getData() == '') {
        alert("Please provide page content.");
        return false;
    }
}
function load_newsletter_force_form(id) {
    $.getJSON(baseUrl + 'manage_newsletters/get_record_by_id/' + id, function (data) {
        $('#n_force_id').val(data.ID);
        $('#force_send_newsletter_form').modal('show');
    });
}
//=======Ends Newsletter Module=======
//=======Admin User Module=======
function delete_admin_user(id) {
    var myurl = baseUrl + 'admin_user/delete/' + id;
    var is_confirm = confirm("Are you sure you want to delete this admin user?");
    if (is_confirm) {
        $.get(myurl, function (show) {
            if (show == 'done')
                $("#row_" + id).fadeOut();
            else
                alert('OOps! Something went wrong.');
        });
    }
}
function check_admin_username() {
    var username = document.getElementById('username').value;
    $.ajax({
        type: "POST",
        url: "admin_user/check_username",
        data: {username: username}
    })
        .done(function (msg) {
            if (msg != "") {
                $('#username_check').html(msg);
            }
            else {
                var p = "";
                $('#username_check').html(p);
            }
        });
}
//=======Admin Client Notes Module=======
function submit_note() {
    var note = $('#note').val();
    var id = $('#id').val();
    if (note == '') {
        $("#note").effect("shake", "slow");
        //alert('Please provide note first.');
        return false;
    }
    var myurl = baseUrl + 'clients/add_note/';
    $('#s_note').attr('disabled', 'disabled');
    $.ajax({
        type: "POST",
        url: baseUrl + "clients/add_note",
        data: {note: $("#note").val(), id: id}
    })
        .done(function (msg) {
            var obj = jQuery.parseJSON(msg);
            if (obj.msg == 'done') {
                $(obj.data).prependTo($("#comments"));
                $('#s_note').attr('disabled', false);
                $('#note').val('');
                $('#note_msg').html('<span class="text-green"> Note added successfully!</span>');
                // $('#comments').effect( "highlight", {color:"#FFFF66"}, 1000 );
            }
            else {
                alert(msg);
                $('#s_note').attr('disabled', false);
            }
        });
}
function delete_banner(id, name) {
    var myurl = baseUrl + 'banner/delete/' + id + '/' + name;
    var is_confirm = confirm("Are you sure you want to delete this Banner?");
    if (is_confirm) {
        $.get(myurl, function (show) {
            if (show == 'done')
                $("#row_" + id).fadeOut();
            else
                alert('OOps! Something went wrong.');
        });
    }
}
$(document).ready(function () {
    $('.short_code').click(function (e) {
        $('#message').val($('#message').val() + $(this).text());
        $('#message').focus();
    });
    $('.add_to_textbox').click(function (e) {
        $('#message').val($('#message').val() + $(this).prev().text());
        $('#message').focus();
    });
    //For Client Detaisl Page
    $('.add_to_textarea').click(function (e) {
        $('#ticket_content').val($('#ticket_content').val() + $('#canned_response').text());
        $('#ticket_content').focus();
    });
    $('.client_details_short_code').click(function (e) {
        $('#ticket_content').val($('#ticket_content').val() + $(this).text());
        $('#ticket_content').focus();
    });
    $('.add_to_textarea_msg').click(function (e) {
        $('#email_content').val($('#email_content').val() + $('#canned_response_msg').text());
        $('#email_content').focus();
    });
    $('.client_msg_short_code').click(function (e) {
        $('#email_content').val($('#email_content').val() + $(this).text());
        $('#email_content').focus();
    });
    $('.client_upload_short_code').click(function (e) {
        $('#document_description').val($('#document_description').val() + $(this).text());
        $('#document_description').focus();
    });
});
function select_admin_value(field_id, val) {
    $("#" + field_id + " option[value='" + val + "']").attr('selected', 'selected');
}
//delete banner from the db
function delete_banner(id, name) {
    var myurl = baseUrl + 'banner/delete/' + id + '/' + name;
    var is_confirm = confirm("Are you sure you want to delete this Banner?");
    if (is_confirm) {
        $.get(myurl, function (show) {
            if (show == 'done')
                $("#row_" + id).fadeOut();
            else
                alert('OOps! Something went wrong.');
        });
    }
}
//delete ticked and the sub comments related to the that tickets
function delete_ticket(id, fname) {
    var myurl = baseUrl + 'tickets/delete/' + id + '/' + fname;
    var is_confirm = confirm("Are you sure you want to delete this ticket and all associated attachments / comments?");
    if (is_confirm) {
        $.get(myurl, function (show) {
            if (show == 'done')
                $("#row_" + id).fadeOut();
            else
                alert('OOps! Something went wrong.');
        });
    }
}
//Update Ticket status for the ticket_view
function update_ticket_status(id) {
    var current_status = $("#sts_" + id + " span").html();
    var myurl = baseUrl + 'tickets/ticket_view_status_update/' + id + '/' + current_status;
    $.get(myurl, function (sts) {
        var class_label = 'success';
        var display_comment = 'block';
        if (sts != 'Open') {
            var class_label = 'danger';
            var display_comment = 'none';
        }
        $("#sts_" + id).html('<span class="label label-' + class_label + '">' + sts + '</span>');
        if ($("#adm_comments").length != 0) {
            $('#adm_comments').css('display', display_comment);
        }
    });
}
//delete can record from db
function delete_can(id) {
    var myurl = baseUrl + 'canned/delete/' + id;
    var is_confirm = confirm("Are you sure you want to delete this canned response?");
    if (is_confirm) {
        $.get(myurl, function (show) {
            if (show == 'done')
                $("#row_" + id).fadeOut();
            else
                alert('OOps! Something went wrong.');
        });
    }
}
//Canned Messages loading
function load_canned_data(response) {
    if (response == '') {
        $('#canned_response_container').css('display', 'none');
        return false;
    }
    $('#canned_response_container').css('display', 'block');
    $("#canned_response").html(response);
}
function load_canned_data_msg(response) {
    if (response == '') {
        $('#canned_response_container_msg').css('display', 'none');
        return false;
    }
    $('#canned_response_container_msg').css('display', 'block');
    $("#canned_response_msg").html(response);
}
//show pervious comments OF TICKET
function show_previous_comments(id) {
    var myurl = baseUrl + 'tickets/view_previous_comments/' + id;
    $.get(myurl, function (show) {
        $('#pev_result').html(show);
    });
}
function show_all_notes() {
    $('.note_h_cls').slideToggle();
    //$('#show_all').remove();
    if ($('#show_all').html() == 'Show All')
        $('#show_all').html('Hide Old Notes');
    else
        $('#show_all').html('Show All');
}
//=======Client's Profile Popups =======
$(document).ready(function () {
    $('#new_ticket_link').click(function () {
        $('#open_ticket').modal('show');
    });
    $('#send_message_link').click(function () {
        $('#send_message').modal('show');
    });
    $('#upload_file_link').click(function () {
        $('#admin_upload_file').modal('show');
    });
});
//=======Client Open Ticket=======
$(document).ready(function (e) {
    $("#admin_new_ticket_form").on('submit', (function (e) {
        e.preventDefault();
        $('#spinner_ticket').show();
        $('#ticket_submit').attr('disabled', 'disabled');
        $.ajax({
            url: baseUrl + "tickets/open_admin_new_ticket",
            type: "POST",
            data: new FormData(this),
            contentType: false,
            cache: false,
            processData: false,
            success: function (msg) {
                if (msg == 'done') {
                    $('#msg').html('<div class="message-container"> <div class="callout callout-success"><h4>New ticket has been generated successfully.</h4></div> </div>').show();
                    $('#open_ticket').modal('toggle');
                    $('#ticket_content').val('');
                    $('#ticket_attachment').val('');
                    $('#emsg_ticket').html('');
                    $('#ticket_submit').removeAttr('disabled');
                    $('#spinner_ticket').hide();
                    return;
                }
                else {
                    $('#ticket_submit').removeAttr('disabled');
                    $('#spinner_ticket').hide();
                    $('#emsg_ticket').html('<span class="label label-danger">' + msg + '</span>');
                    return;
                }
            }
        });
        return;
    }));
});
//=======Client Send Message=======
$(document).ready(function (e) {
    $("#admin_new_message_form").on('submit', (function (e) {
        e.preventDefault();
        $('#spinner_msg').show();
        $('#email_submit').attr('disabled', 'disabled');
        $.ajax({
            url: baseUrl + "clients/send_message",
            type: "POST",
            data: new FormData(this),
            contentType: false,
            cache: false,
            processData: false,
            success: function (msg) {
                if (msg == 'done') {
                    $('#msg').html('<div class="message-container"> <div class="callout callout-success"><h4>Message has been sent.</h4></div> </div>').show();
                    $('#send_message').modal('toggle');
                    $('#email_content').val('');
                    $('#message_attachment').val('');
                    $('#emsg_msg').html('');
                    $('#email_submit').removeAttr('disabled');
                    $('#spinner_msg').hide();
                    return;
                }
                else {
                    $('#email_submit').removeAttr('disabled');
                    $('#spinner_msg').hide();
                    $('#emsg_msg').html('<span class="label label-danger">' + msg + '</span>');
                    return;
                }
            }
        });
        return;
    }));
});
function load_message_view(msg_id) {
    var myurl = baseUrl + 'clients/view_message/' + msg_id;
    $.get(myurl, function (data) {
        $("#sent_message_text").html(data);
    });
    $('#sent_message_box').modal('show');
}
//=======Upload File Client Section=======
$(document).ready(function (e) {
    $("#admin_upload_file_form").on('submit', (function (e) {
        e.preventDefault();
        $('#spinner_upload').show();
        $('#upload_file_submit').attr('disabled', 'disabled');
        $.ajax({
            url: baseUrl + "clients/upload_file",
            type: "POST",
            data: new FormData(this),
            contentType: false,
            cache: false,
            processData: false,
            success: function (msg) {
                if (msg == 'done') {
                    $('#msg').html('<div class="message-container"> <div class="callout callout-success"><h4>File has been uploaded.</h4></div> </div>').show();
                    $('#admin_upload_file').modal('toggle');
                    $('#document_description').val('');
                    $('#attachment').val('');
                    $('#emsg_upload').html('');
                    $('#upload_file_submit').removeAttr('disabled');
                    $('#spinner_upload').hide();
                    return;
                }
                else {
                    $('#upload_file_submit').removeAttr('disabled');
                    $('#spinner_upload').hide();
                    $('#emsg_upload').html('<span class="label label-danger">' + msg + '</span>');
                    return;
                }
            }
        });
        return;
    }));
});
//=======Edit Client's Profile Section=======
function load_edit_popup(method, id) {
    $('#edit_profile_box').modal('show');
    // Make a ajax call
    var myurl = baseUrl + 'edit_client/' + method + '/' + id;
    $.getJSON(myurl, function (obj_data) {
        $("#msg_edit").html(obj_data.msg);
        $("#load_form").html(obj_data.form_data);
    });
}
$(document).ready(function (e) {
    $("#admn_update_profile").on('submit', (function (e) {
        e.preventDefault();
        var method = $('#method').val();
        var cid = $('#cid').val();
        $('#spinner_profile').show();
        $('#update_profile').attr('disabled', 'disabled');
        $.ajax({
            url: baseUrl + "edit_client/" + method + '/' + cid,
            type: "POST",
            data: new FormData(this),
            contentType: false,
            cache: false,
            processData: false,
            success: function (data) {
                var obj = jQuery.parseJSON(data);
                if (obj.msg == 'done') {
                    /*$('#msg').html('<div class="message-container"> <div class="callout callout-success"><h4>Password updated Successfully.</h4></div></div>').show();*/
                    $('#edit_profile_box').modal('toggle');
                    $('#update_profile').removeAttr('disabled');
                    if (method == 'edit_password')
                        $('#edit_password').html($('#pass').val());
                    else if (method == 'edit_employer') {
                        $('#edit_employer').html($('#employer_network_name').val());
                        $('#e_duns').html($('#employer_duns').val());
                        $('#e_email').html($('#employer_email').val());
                        $('#e_phone').html($('#employer_phone').val());
                        $('#e_address').html($('#employer_street_address').val());
                    }
                    else if (method == 'edit_personal_info') {
                        $('#edit_personal_info').html($('#employee_name').val());
                        $('#c_ssn').html($('#employee_ssn_number').val());
                        $('#c_email').html($('#employee_email').val());
                        $('#c_phone').html($('#employee_phone').val());
                        $('#c_address').html($('#employee_address').val());
                        $('#c_city').html($('#employee_city').val());
                        $('#c_state').html($('#employee_state').val());
                    }
                    else if (method == 'edit_vocational_goal') {
                        $('#edit_vocational_goal').html($('#short_term_vocational_goal').val());
                        $('#short_earning').html($('#short_term_expected_monthly_earning').val());
                        $('#long_goal').html($('#long_term_vocational_goal').val());
                        $('#long_earning').html($('#long_term_expected_monthly_earning').val());
                    }
                    closest_div = $('#' + method).closest('.invoice-info');
                    closest_div.effect("highlight", {color: "#FFFF66"}, 1000);
                    $('#spinner_profile').hide();
                    return;
                }
                else {
                    $('#update_profile').removeAttr('disabled');
                    $('#spinner_profile').hide();
                    $('#msg_edit').html(obj.msg);
                    return;
                }
            }
        });
        return;
    }));
});
//delete email Campaign record from db
function delete_email_compain(id) {
    var myurl = baseUrl + 'manage_newsletters/delete_email_campaign/' + id;
    var is_confirm = confirm("Are you sure you want to delete this Email Campaign?");
    if (is_confirm) {
        $.get(myurl, function (show) {
            if (show == 'done')
                $("#row_" + id).fadeOut();
            else
                alert('OOps! Something went wrong.');
        });
    }
}
//=======Starts ministries Module=======
function load_ministries_add_form() {
    $('#add_ministries_form').modal('show');
}
function load_ministries_edit_form(id) {
    $('#edit_footer_menu').prop('checked', false);
    $('#edit_top_menu').prop('checked', false);
    $.getJSON(baseUrl + 'ministries/get_ministries_by_id/' + id, function (data) {
        $('#edit_name').val(data.name);
        $('#edit_email').val(data.email);
        $('#edit_designation').val(data.designation);
        $('#edit_phone_no').val(data.phone_no);
        $('#edit_slug').val(data.slug);
        $('#edit_title').val(data.title);
        CKEDITOR.instances['edit_editor1'].setData(data.content);
        $('#ministries_id').val(data.ID);
        $("#bannerimages").attr('src', '../public/uploads/ministers/thump/' + data.banner_name);
        $('#edit_ministries_form').modal('show');
    });
}
function update_ministries_status(id) {
    //alert(baseUrl);
    var current_status = $("#sts_" + id + " span").html();
    var myurl = baseUrl + 'ministries/status/' + id + '/' + current_status;
    $.get(myurl, function (sts) {
        var class_label = 'success';
        if (sts != 'active')
            var class_label = 'danger';
        $("#sts_" + id).html('<span class="label label-' + class_label + '">' + sts + '</span>');
    });
}
function delete_ministries(id) {
    var myurl = baseUrl + 'ministries/delete/' + id;
    var is_confirm = confirm("Are you sure you want to delete this minister?");
    if (is_confirm) {
        $.get(myurl, function (sts) {
            if (sts == 'done')
                $("#row_" + id).fadeOut();
            else
                alert('OOps! Something went wrong.');
        });
    }
}
function validate_edit__ministries_form(the_form) {
    if (the_form.edit_name.value == '') {
        alert("Please provide minister Name.");
        return false;
    }
    if (the_form.edit_email.value == '') {
        alert("Please provide minister email.");
        return false;
    }
    if (the_form.edit_phone_no.value == '') {
        alert("Please provide minister  Phone NO.");
        return false;
    }
}
//=======Ends ministries Module=======
//=======Starts games Module=======
function load_games_add_form() {
    $('#frm_games').trigger("reset");
    $('#add_games_form').modal('show');
}
function load_games_edit_form(id) {
    var my_editor_id = 'editor1';
    $('#edit_footer_menu').prop('checked', false);
    $('#edit_top_menu').prop('checked', false);
    $.getJSON(baseUrl + 'games/get_games_by_id/' + id, function (data) {
        $('#edit_heading').val(data.heading);
        $('#edit_games_slug').val(data.games_slug);
        $('#edit_price').val(data.price);
        $('#edit_meta_title').val(data.meta_title);
        $('#edit_meta_keywords').val(data.meta_keywords);
        $('#edit_meta_description').val(data.meta_description);
        $('#edit_canonical_url').val(data.canonical_url);
        if (data.games_img == null || data.games_img == '' || data.games_img == 0) {
            // $("#featured-no-images").fadeIn();
            $("#featured_img").fadeOut();
        } else {
            $("#featured_img").fadeIn();
            // $("#featured-no-images").fadeOut();
            // alert(front_uploads);
            // $("#cmsimages").attr('src', '../public/uploads/cms/thumb/'+data.featured_img);
            var img = '<div class="featured-images-main" id="games_img_' + data.ID + '"><img style="width:150px" src="' + front_uploads + 'games/thumb/' + data.games_img + '"><i onClick="remove_games_featured_image(' + data.ID + ');" class="deleteIcon"></i></div>';
            $('#featured_img').html('');
            $('#featured_img').append(img);
        }
        //  $("#gamesimages").attr('src', '../public/uploads/games/thumb/'+data.games_img);
        //alert(data.banner_desc);
        // tinyMCE.activeEditor.execCommand('mceCleanup', false);
        tinyMCE.get('editor1').setContent('');
        tinyMCE.get('editor1').setContent(data.content);
        //tinymce.activeEditor.execCommand('mceInsertContent', false, data.banner_desc);
        $('#games_id').val(data.ID);
        $('#edit_games_form').modal('show');
        var seoClass = document.getElementById('seo-edit-modul');
        if (data.meta_title.length > 0 || data.meta_keywords.length > 0 || data.meta_description.length > 0 || data.canonical_url.length > 0) {
            seoClass.className = 'seo-edit-modul-sow';
        } else {
            seoClass.className = 'seo-edit-modul-hide';
        }
    });
}
function remove_games_featured_image(id) {
    var myurl = baseUrl + 'games/remove_games_feature_image/' + id;
    var is_confirm = confirm("Are you sure you want to delete this Games image?");
    if (is_confirm) {
        $.get(myurl, function (sts) {
            if (sts == 'done')
                $("#games_img_" + id).fadeOut();
            else
                alert('OOps! Something went wrong.');
        });
    }
}
function update_games_status(id) {
    var current_status = $("#sts_" + id + " span").html();
    var myurl = baseUrl + 'games/status/' + id + '/' + current_status;
    $.get(myurl, function (sts) {
        var class_label = 'success';
        if (sts != 'active')
            var class_label = 'danger';
        $("#sts_" + id).html('<span class="label label-' + class_label + '">' + sts + '</span>');
    });
}
function delete_games(id) {
    var myurl = baseUrl + 'games/delete/' + id;
    var is_confirm = confirm("Are you sure you want to delete this Game?");
    if (is_confirm) {
        $.get(myurl, function (sts) {
            if (sts == 'done')
                $("#row_" + id).fadeOut();
            else
                alert('OOps! Something went wrong.');
        });
    }
}
function validate_edit_games_form(the_form) {
    if (the_form.edit_heading.value == '') {
        alert("Please provide games title.");
        return false;
    }
    if (the_form.edit_games_slug.value == '') {
        alert("Please provide games slug.");
        return false;
    }
}
//=======Ends games Module=======
//=======Starts User Module=======
function update_user_status(id) {
//alert(id);
    var current_status = $("#sts_" + id + " span").html();
    var current_status_val = $("#sts_" + id).attr('data-status');
    var myurl = baseUrl + 'users/update_status/' + id + '/' + current_status_val;
    $.get(myurl, function (sts) {
        var class_label = 'success';
        var data = 'Active';
        if (current_status != 'Active')
            var class_label = 'danger';
        var data = 'Inactive';
        $("#sts_" + id).html('<span class="label label-' + class_label + '">' + data + '</span>');
    });
}
//=======Starts Banners Module=======
function update_banners_status(id) {
    var current_status = $("#sts_" + id + " span").html();
    var myurl = baseUrl + 'banners/status/' + id + '/' + current_status;
    $.get(myurl, function (sts) {
        var class_label = 'success';
        if (sts != 'active')
            var class_label = 'danger';
        $("#sts_" + id).html('<span class="label label-' + class_label + '">' + sts + '</span>');
    });
}
function load_banner_add_form() {
    tinyMCE.get('editor1').setContent('');
    $('#add_page_form').modal('show');
}
function load_banners_edit_form(id) {
    $('#edit_footer_menu').prop('checked', false);
    $('#edit_top_menu').prop('checked', false);
    $.getJSON(baseUrl + 'banners/get_banners_by_id/' + id, function (data) {
        $('#edit_banner_title').val(data.banner_title);
        $('#edit_alt_tag').val(data.alt_tag);
        $("#bannerimages").attr('src', '../public/uploads/banners/thumb/' + data.banner_name);
        //alert(data.banner_desc);
        // tinyMCE.activeEditor.execCommand('mceCleanup', false);
        tinyMCE.get('edit_editor1').setContent('');
        tinyMCE.get('edit_editor1').setContent(data.banner_desc);
        //tinymce.activeEditor.execCommand('mceInsertContent', false, data.banner_desc);
        //CKEDITOR.instances['edit_editor1'].setData(data.banner_desc);
        $('#banner_id').val(data.ID);
        $('#edit_page_form').modal('show');
    });
}
function delete_banners(id) {
    var myurl = baseUrl + 'banners/delete/' + id;
    var is_confirm = confirm("Are you sure you want to delete this Banner?");
    if (is_confirm) {
        $.get(myurl, function (sts) {
            if (sts == 'done')
                $("#row_" + id).fadeOut();
            else
                alert('OOps! Something went wrong.');
        });
    }
}
function validate_edit_banner_form(the_form) {
    if (the_form.edit_banner_title.value == '') {
        alert("Please provide Banner Title.");
        return false;
    }
    if (the_form.edit_alt_tag.value == '') {
        alert("Please provide Banner Alt Tag.");
        return false;
    }
    if (CKEDITOR.instances['edit_editor1'].getData() == '') {
        alert("Please provide Banner content.");
        return false;
    }
}
//=======Ends Banners Module=======
//=======Start contact Module=======
function load_contact_details(id) {
    $('#edit_footer_menu').prop('checked', false);
    $('#edit_top_menu').prop('checked', false);
    $.getJSON(baseUrl + 'contact_us/contact_details_by_id/' + id, function (data) {
        $('#contact_name').text(data.name);
        $('#from_email').text(data.from_email);
        $('#contact_phone').text(data.phone);
        $('#contact_body').text(data.body);
        $('#contact_details_info').modal('show');
    });
}
function delete_contactUs(id) {
    var myurl = baseUrl + 'contact_us/delete/' + id;
    var is_confirm = confirm("Are you sure you want to delete this Post?");
    if (is_confirm) {
        $.get(myurl, function (sts) {
            if (sts == 'done')
                $("#row_" + id).fadeOut();
            else
                alert('OOps! Something went wrong.');
        });
    }
}
//=======End contact Module=======
//=======Starts Events Module=======
function load_events_add_form() {
    $('#add_events_form').modal('show');
}
function load_events_edit_form(id) {
    $('#edit_footer_menu').prop('checked', false);
    $('#edit_top_menu').prop('checked', false);
    $.getJSON(baseUrl + 'events/get_events_by_id/' + id, function (data) {
        $('#edit_title').val(data.title);
        $('#edit_start').val(data.start);
        $('#edit_event_slug').val(data.event_slug);
        $('#edit_end').val(data.end);
        CKEDITOR.instances['edit_editor1'].setData(data.contents);
        $('#event_id').val(data.ID);
        $('#edit_events_form').modal('show');
    });
}
function update_events_status(id) {
    var current_status = $("#sts_" + id + " span").html();
    var myurl = baseUrl + 'events/status/' + id + '/' + current_status;
    $.get(myurl, function (sts) {
        var class_label = 'success';
        if (sts != 'active')
            var class_label = 'danger';
        $("#sts_" + id).html('<span class="label label-' + class_label + '">' + sts + '</span>');
    });
}
function delete_events(id) {
    var myurl = baseUrl + 'events/delete/' + id;
    var is_confirm = confirm("Are you sure you want to delete this Post?");
    if (is_confirm) {
        $.get(myurl, function (sts) {
            if (sts == 'done')
                $("#row_" + id).fadeOut();
            else
                alert('OOps! Something went wrong.');
        });
    }
}
function validate_edit_events_form(the_form) {
    if (the_form.edit_heading.value == '') {
        alert("Please provide Post heading.");
        return false;
    }
    if (the_form.edit_games_slug.value == '') {
        alert("Please provide Post slug.");
        return false;
    }
    if (CKEDITOR.instances['edit_editor1'].getData() == '') {
        alert("Please provide Post content.");
        return false;
    }
}
//=======Ends Events Module=======
//=======Starts Gallery Module=======
function update_gallery_status(id) {
    var current_status = $("#sts_" + id + " span").html();
    var myurl = baseUrl + 'gallery/status/' + id + '/' + current_status;
    $.get(myurl, function (sts) {
        var class_label = 'success';
        if (sts != 'active')
            var class_label = 'danger';
        $("#sts_" + id).html('<span class="label label-' + class_label + '">' + sts + '</span>');
    });
}
function load_gallery_add_form() {
    tinyMCE.get('editor1').setContent('');
    $('#add_page_form').modal('show');
}
function load_gallery_edit_form(id) {
    $('#edit_footer_menu').prop('checked', false);
    $('#edit_top_menu').prop('checked', false);
    $.getJSON(baseUrl + 'gallery/get_gallery_by_id/' + id, function (data) {
        $('#edit_gallery_title').val(data.gallery_title);
        $('#edit_alt_tag').val(data.alt_tag);
        $("#galleryimages").attr('src', '../public/uploads/gallery/thumb/' + data.gallery_images);
        //alert(data.gallery_desc);
        // tinyMCE.activeEditor.execCommand('mceCleanup', false);
        tinyMCE.get('edit_editor1').setContent('');
        tinyMCE.get('edit_editor1').setContent(data.gallery_desc);
        //tinymce.activeEditor.execCommand('mceInsertContent', false, data.gallery_desc);
        //CKEDITOR.instances['edit_editor1'].setData(data.gallery_desc);
        $('#gallery_id').val(data.ID);
        $('#edit_page_form').modal('show');
    });
}
function delete_gallery(id) {
    var myurl = baseUrl + 'gallery/delete/' + id;
    var is_confirm = confirm("Are you sure you want to delete this gallery Image?");
    if (is_confirm) {
        $.get(myurl, function (sts) {
            if (sts == 'done')
                $("#row_" + id).fadeOut();
            else
                alert('OOps! Something went wrong.');
        });
    }
}
function validate_edit_gallery_form(the_form) {
    if (the_form.edit_gallery_title.value == '') {
        alert("Please provide gallery Title.");
        return false;
    }
    if (the_form.edit_alt_tag.value == '') {
        alert("Please provide gallery Alt Tag.");
        return false;
    }
    if (CKEDITOR.instances['edit_editor1'].getData() == '') {
        alert("Please provide Gallery content.");
        return false;
    }
}
//=======Ends Gallery Module=======
//=======Starts Module=======
function update_testimonials_status(id) {
    var current_status = $("#sts_" + id + " span").html();
    var myurl = baseUrl + 'testimonials/status/' + id + '/' + current_status;
    $.get(myurl, function (sts) {
        var class_label = 'success';
        if (sts != 'active')
            var class_label = 'danger';
        $("#sts_" + id).html('<span class="label label-' + class_label + '">' + sts + '</span>');
    });
}
function delete_testimonials(id) {
    // alert(id); return false;
    var myurl = baseUrl + 'testimonials/delete/' + id;
    var is_confirm = confirm("Are you sure you want to delete this ?");
    if (is_confirm) {
        $.get(myurl, function (sts) {
            if (sts == 'done')
                $("#row_" + id).fadeOut();
            else
                alert('OOps! Something went wrong.');
        });
    }
}
//=======Ends Gallery Module=======
//=======Starts Testimonials Module=======
function load_testimonials_add_form() {
    tinyMCE.get('editor1').setContent('');
    $('#add_page_form').modal('show');
}
function load_testimonials_edit_form(id) {
    $('#edit_footer_menu').prop('checked', false);
    $('#edit_top_menu').prop('checked', false);
    $.getJSON(baseUrl + 'testimonials/get_testimonials_by_id/' + id, function (data) {
        $('#edit_name').val(data.name);
        $('#edit_company_name').val(data.company_name);
        $('#edit_designation').val(data.designation);
        $("#testimonialsimages").attr('src', '../public/uploads/testimonials/thumb/' + data.image);
        //alert(data.gallery_desc);
        // tinyMCE.activeEditor.execCommand('mceCleanup', false);
        tinyMCE.get('edit_editor1').setContent('');
        tinyMCE.get('edit_editor1').setContent(data.details);
        //tinymce.activeEditor.execCommand('mceInsertContent', false, data.gallery_desc);
        //CKEDITOR.instances['edit_editor1'].setData(data.gallery_desc);
        $('#testimonials_id').val(data.ID);
        $('#edit_page_form').modal('show');
    });
}
function delete_gallery(id) {
    var myurl = baseUrl + 'gallery/delete/' + id;
    var is_confirm = confirm("Are you sure you want to delete this gallery Image?");
    if (is_confirm) {
        $.get(myurl, function (sts) {
            if (sts == 'done')
                $("#row_" + id).fadeOut();
            else
                alert('OOps! Something went wrong.');
        });
    }
}
function validate_edit_gallery_form(the_form) {
    if (the_form.edit_gallery_title.value == '') {
        alert("Please provide gallery Title.");
        return false;
    }
    if (the_form.edit_alt_tag.value == '') {
        alert("Please provide gallery Alt Tag.");
        return false;
    }
    if (CKEDITOR.instances['edit_editor1'].getData() == '') {
        alert("Please provide Gallery content.");
        return false;
    }
}
function update_testimonials_status(id) {
    var current_status = $("#sts_" + id + " span").html();
    var myurl = baseUrl + 'testimonials/status/' + id + '/' + current_status;
    $.get(myurl, function (sts) {
        var class_label = 'success';
        if (sts != 'active')
            var class_label = 'danger';
        $("#sts_" + id).html('<span class="label label-' + class_label + '">' + sts + '</span>');
    });
}
//function delete_testimonials(id){
//    var myurl = baseUrl+'testimonials/delete/'+id;
//    var is_confirm = confirm("Are you sure you want to delete this ?");
//    if(is_confirm){
//        $.get(myurl, function (sts) {
//           // alert(sts);
//        if(sts=='done')
//                $("#row_"+id).fadeOut();
//            else
//                alert('OOps! Something went wrong.');
//        });
//    }
//}
//=======Ends Gallery Module=======
//=======Ends widgets Module=======
function load_widgets_add_form() {
    $("#frm_block").trigger('reset');
    $('#add_page_form').modal('show');
}
function load_widgets_edit_form(id) {
    $('#edit_footer_menu').prop('checked', false);
    $('#edit_top_menu').prop('checked', false);
    $("#edit_frm_widgets").trigger('reset');
    $.getJSON(baseUrl + 'adminmedia/widgets/' + id, function (data) {
        $('#edit_heading').val(data.heading);
        CKEDITOR.instances['edit_editor1'].setData(data.content);
        CKEDITOR.instances['edit_editor1'].updateElement();
        var filename = '../public/uploads/widgets/thumb/' + data.featured_image;
        $("#widgetsimages").attr('src', filename);
        // alert('HELLO TESTING HERE');
        
        var img = '<div class="featured-images-main" id="products_img_'+data.ID+'"><img style="width:150px" src="'+baseUrl+'uploads/widgets/'+data.featured_image+'"><i onClick="remove_widget_image('+data.ID+');" class="deleteIcon"></i></div>';
        if(data.featured_image != ''){
            $("#widget_img_div").fadeIn();
            $('#widget_img_div').html('');                
            $('#widget_img_div').append(img);
        }
        
        $('#widgets_id').val(data.ID);
        $('#edit_page_form').modal('show');
    });
}
function remove_widget_image(id){
  
    var myurl = baseUrl+'adminmedia/removeWidgetImage/'+id;
     var is_confirm = confirm("Are you sure you want to delete this image?");
         if(is_confirm){
           $.get(myurl, function (sts) {
               if(sts=='done')
                   $("#widget_img_div").fadeOut();
               else
                   alert('OOps! Something went wrong.');
              });
     }
     }
function update_widgets_status(id) {
    var current_status = $("#sts_" + id + " span").html();
    var myurl = baseUrl + 'adminmedia/widgets/' + id + '/edit?status=' + current_status;
    $.get(myurl, function (sts) {
        var class_label = 'success';
        if (sts != 'active')
            var class_label = 'danger';
        $("#sts_" + id).html('<span class="label label-' + class_label + '">' + sts + '</span>');
    });
}
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
function validate_edit_widgets_form(the_form) {
    if (the_form.edit_heading.value == '') {
        alert("Please provide page heading.");
        return false;
    }
    if (CKEDITOR.instances['edit_editor1'].getData() == '') {
        alert("Please provide page contents.");
        return false;
    }
//	  if(the_form.tinyMCE.get('edit_editor1').value==''){
//
//		alert("Please provide page contents.");
//
//		return false;
//
//	  }
}
//=======Ends widgets Module=======
//=======Ends color categories Module=======
function load_color_categories_add_form() {
    $("#color_category").trigger('reset');
    $('#add_page_form').modal('show');
}
function load_color_cate_edit_form(id) {
    $('#edit_footer_menu').prop('checked', false);
    $('#edit_top_menu').prop('checked', false);
    $("#edit_frm_product_cate").trigger('reset');
    $.getJSON(baseUrl + 'color_categories/get_color_cate_by_id/' + id, function (data) {
        $('#edit_title').val(data.title);
        //var filename = '../public/uploads/color_cate/thumb/'+data.featured_image;
        //$("#featured_image").attr('src', filename);
        $('#color_category_id').val(data.ID);
        $('#edit_frm_product_cate').modal('show');
    });
}
function update_color_cate_status(id) {
    var current_status = $("#sts_" + id + " span").html();
    var myurl = baseUrl + 'color_categories/status/' + id + '/' + current_status;
    $.get(myurl, function (sts) {
        var class_label = 'success';
        if (sts != 'active')
            var class_label = 'danger';
        $("#sts_" + id).html('<span class="label label-' + class_label + '">' + sts + '</span>');
    });
}
function delete_color_cate(id) {
    var myurl = baseUrl + 'color_categories/delete/' + id;
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
//=======Ends color categories Module=======
//
//
//=======Ends products categories Module=======
function load_products_categories_add_form() {
    $("#product_category").trigger('reset');
    $('#add_page_form').modal('show');
}
function load_product_cate_edit_form(id) {
    $('#edit_footer_menu').prop('checked', false);
    $('#edit_top_menu').prop('checked', false);
    $("#edit_frm_product_cate").trigger('reset');
    $.getJSON(baseUrl + 'product_category/get_product_cate_by_id/' + id, function (data) {
        $('#edit_title').val(data.title);
        var filename = '../public/uploads/product_cate/thumb/' + data.featured_image;
        $("#featured_image").attr('src', filename);
        $('#pro_category_id').val(data.ID);
        $('#edit_frm_product_cate').modal('show');
    });
}
function update_product_cate_status(id) {
    var current_status = $("#sts_" + id + " span").html();
    var myurl = baseUrl + 'product_category/status/' + id + '/' + current_status;
    $.get(myurl, function (sts) {
        var class_label = 'success';
        if (sts != 'active')
            var class_label = 'danger';
        $("#sts_" + id).html('<span class="label label-' + class_label + '">' + sts + '</span>');
    });
}
function delete_product_cate(id) {
    var myurl = baseUrl + 'product_category/delete/' + id;
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
//=======Ends products categories Module=======
//=======Ends products Module=======
function load_products_add_form() {
    $("#add_product").trigger('reset');
    $('#add_products_form').modal('show');
}
function load_product_edit_form(id) {
    $('#edit_footer_menu').prop('checked', false);
    $('#edit_top_menu').prop('checked', false);
    $("#edit_frm_products").trigger('reset');
    $.getJSON(baseUrl + 'products/get_products_by_id/' + id, function (data) {
        $('#edit_product_category').val(data[0].cate_id);
        $('#edit_color_category').val(data[0].color_id);
        $('#edit_title').val(data[0].title);
        $('#edit_meta_title').val(data[0].meta_title);
        $('#edit_meta_keywords').val(data[0].meta_keywords);
        $('#edit_meta_description').val(data[0].meta_description);
        $('#edit_canonical_url').val(data[0].canonical_url);
        tinyMCE.get('edit_editor1').setContent(data[0].description);
        // var filename = '../public/uploads/product_cate/thumb/'+data.featured_image;
        // $("#featured_image").attr('src', filename);
        if (data[0].meta_title != '' || data[0].meta_description != '' || data[0].meta_keywords != '' || data[0].canonical_url != '') {
            // alert(data[0].meta_keywords.length);
            $('#seo-edit-modul').css('display', 'block');
        }
        $('#product_id').val(data[0].ID);
        $('#edit_frm_product').modal('show');
        $('#pro_uploaded_images').empty();
        //    alert(data[0].images.length);
        if (data[0]['images'].length > 0) {
            for (var i = 0; i < data[0]['images'].length; i++) {
                var img = '<li id="products_img_' + data[0]['images'][i].ID + '"><img src="' + front_uploads + 'products_images/thumb/' + data[0]['images'][i].image_name + '"><i onClick="delete_uploaded_images(' + data[0]['images'][i].ID + ');" class="deleteIcon"></i></li>';
                $('#pro_uploaded_images').append(img);
            }
        }
    });
}
function delete_uploaded_images(id) {
    var myurl = baseUrl + 'products/delete_uploaded_images/' + id;
    var is_confirm = confirm("Are you sure you want to delete this Products image?");
    if (is_confirm) {
        $.get(myurl, function (sts) {
            if (sts == 'done')
                $("#products_img_" + id).fadeOut();
            else
                alert('OOps! Something went wrong.');
        });
    }
}
function delete_uploaded_documents(id) {
    var myurl = baseUrl + 'products/delete_uploaded_documents/' + id;
    var is_confirm = confirm("Are you sure you want to delete this Products document?");
    if (is_confirm) {
        $.get(myurl, function (sts) {
            if (sts == 'done')
                $("#products_document" + id).fadeOut();
            else
                alert('OOps! Something went wrong.');
        });
    }
}
function update_products_status(id) {
    var current_status = $("#sts_" + id + " span").html();
    var myurl = baseUrl + 'products/status/' + id + '/' + current_status;
    $.get(myurl, function (sts) {
        var class_label = 'success';
        if (sts != 'active')
            var class_label = 'danger';
        $("#sts_" + id).html('<span class="label label-' + class_label + '">' + sts + '</span>');
    });
}
function delete_product(id) {
    var myurl = baseUrl + 'products/delete/' + id;
    var is_confirm = confirm("Are you sure you want to delete this Products?");
    if (is_confirm) {
        $.get(myurl, function (sts) {
            if (sts == 'done')
                $("#row_" + id).fadeOut();
            else
                alert('OOps! Something went wrong.');
        });
    }
}
function validate_edit_products_form(the_form) {
    if (the_form.edit_heading.value == '') {
        alert("Please provide page heading.");
        return false;
    }
    if (the_form.tinyMCE.get('edit_editor1').value == '') {
        alert("Please provide page contents.");
        return false;
    }
}
//=======Ends products Module=======
//=======Ends Stocked color Module=======
function load_stocked_color_add_form() {
    $("#add_stoked_color").trigger('reset');
    $('#add_page_form').modal('show');
}
function load_stocked_colors_edit_form(id) {
    $('#edit_footer_menu').prop('checked', false);
    $('#edit_top_menu').prop('checked', false);
    $("#edit_frm_product_cate").trigger('reset');
    $.getJSON(baseUrl + 'stocked_colors/get_color_stock_by_id/' + id, function (data) {
        $('#edit_title').val(data.title);
        $('#edit_color_category').val(data.cate_id);
        $('#edit_color_code').val(data.color_code);
        var filename = '../public/uploads/stocked_colors/thumb/' + data.featured_image;
        $("#featured_image").attr('src', filename);
        $('#stock_color_id').val(data.ID);
        $('#edit_frm_product_cate').modal('show');
    });
}
function update_stocked_colors_status(id) {
    var current_status = $("#sts_" + id + " span").html();
    var myurl = baseUrl + 'stocked_colors/status/' + id + '/' + current_status;
    $.get(myurl, function (sts) {
        var class_label = 'success';
        if (sts != 'active')
            var class_label = 'danger';
        $("#sts_" + id).html('<span class="label label-' + class_label + '">' + sts + '</span>');
    });
}
function delete_stocked_colors(id) {
    var myurl = baseUrl + 'stocked_colors/delete/' + id;
    var is_confirm = confirm("Are you sure you want to delete this color?");
    if (is_confirm) {
        $.get(myurl, function (sts) {
            if (sts == 'done')
                $("#row_" + id).fadeOut();
            else
                alert('OOps! Something went wrong.');
        });
    }
}
//=======Ends Stocked color Module=======
//=======Starts Social media Module=======
function load_social_media_add_form() {
    $('#add_page_form').modal('show');
}
function update_social_media_status(id) {
    var current_status = $("#sts_" + id + " i").html();
    var myurl = baseUrl + 'adminmedia/social_media/' + id + '/edit?status=' + current_status;
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
    $.getJSON(baseUrl + 'adminmedia/social_media/' + id, function (data) {
        console.log(data);
        $('#edit_name').val(data.name);
        $('#edit_alt_tag').val(data.alt_tag);
        $('#edit_link').val(data.link);
        $('#i_class').val(data.i_class);
        $('#i_class_addon').html('<i class="fa '+data.i_class+'"></i>');
       
        $('#edit_display_order').val(data.display_order);
        $('#edit-left-sidebar').attr('checked', false);
        if(data.open_in_new_tab=='Yes'){
            $('#edit_open_in_new_tab').prop('checked', true);
        }
        $('#edit-footer').prop('checked', false);
         $('#socail_media_id').val(data.ID);
        $('#edit_page_form').modal('show');
    });
}
function remove_social_media_icon_image(id) {
    var myurl = baseUrl + 'social_media/remove_social_media_image/' + id;
    var is_confirm = confirm("Are you sure you want to delete this social icon?");
    if (is_confirm) {
        $.get(myurl, function (sts) {
            if (sts == 'done')
                $('#featured_img').fadeOut("slow");
            else
                alert('OOps! Something went wrong.');
        });
    }
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
// function delete_social_media(id) {
//     var myurl = baseUrl + 'adminmedia/delete/' + id;
//     var is_confirm = confirm("Are you sure you want to delete this Social Media?");
//     if (is_confirm) {
//         $.get(myurl, function (sts) {
//             if (sts == 'done')
//                 $("#row_" + id).fadeOut();
//             else
//                 alert('OOps! Something went wrong.');
//         });
//     }
// }
function validate_edit_social_media_form(the_form) {
    if (the_form.edit_name.value == '') {
        alert("Please provide Social Media Name.");
        return false;
    }
    if (the_form.edit_alt_tag.value == '') {
        alert("Please provide Social media Alt Tag.");
        return false;
    }
    /*if (the_form.edit_link.value == '') {
        alert("Please provide Social Media URL.");
        return false;
    }*/
}
//=======Ends Social media Module=======
//=======Starts Other Pages Module=======
function update_pages_status(id) {
    var current_status = $("#sts_" + id + " span").html();
    var myurl = baseUrl + 'pages/status/' + id + '/' + current_status;
    $.get(myurl, function (sts) {
        var class_label = 'success';
        if (sts != 'active')
            var class_label = 'danger';
        $("#sts_" + id).html('<span class="label label-' + class_label + '">' + sts + '</span>');
    });
}
function load_page_edit_form(id) {
// set the content empty
    tinymce.get('edit_editor1').setContent('');
    $('#edit_footer_menu').prop('checked', false);
    $('#edit_top_menu').prop('checked', false);
    $.getJSON(baseUrl + 'pages/get_page_by_id/' + id, function (data) {
        $('#edit_page_title').val(data.page_title);
        $('#edit_meta_keywords').val(data.meta_keywords);
        $('#edit_meta_description').val(data.meta_description);
        $('#edit_canonical_url').val(data.canonical_url);
        if (data.featured_img == null || data.featured_img == '' || data.featured_img == 0) {
            //   $("#featured-no-images").fadeIn();
            $("#featured-images").fadeOut();
        } else {
            $("#featured-images").fadeIn();
            // $("#featured-no-images").fadeOut();
            $("#pageimages").attr('src', '../public/uploads/pages/thumb/' + data.featured_img);
        }
        //tinymce.activeEditor.execCommand('mceInsertContent', false, data.content);
        tinyMCE.get('edit_editor1').setContent(data.content);
        $('#page_id').val(data.ID);
        $('#edit_page_form').modal('show');
    });
}
function delete_pages(id) {
    var myurl = baseUrl + 'pages/delete/' + id;
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
function validate_edit_pages_form(the_form) {
    if (the_form.edit_heading.value == '') {
        alert("Please provide page heading.");
        return false;
    }
    if (the_form.edit_page_slug.value == '') {
        alert("Please provide page slug.");
        return false;
    }
    if (CKEDITOR.instances['edit_editor1'].getData() == '') {
        alert("Please provide page content.");
        return false;
    }
}
//=======Ends Pages Module=======
//=======Starts Videos Module=======
function load_videos_add_form() {
    $('#add_videos_form').modal('show');
}
function update_video_status(id) {
    var current_status = $("#sts_" + id + " span").html();
    var myurl = baseUrl + 'videos/status/' + id + '/' + current_status;
    $.get(myurl, function (sts) {
        var class_label = 'success';
        if (sts != 'active')
            var class_label = 'danger';
        $("#sts_" + id).html('<span class="label label-' + class_label + '">' + sts + '</span>');
    });
}
function load_video_edit_form(id) {
    $('#edit_footer_menu').prop('checked', false);
    $('#edit_top_menu').prop('checked', false);
    $.getJSON(baseUrl + 'videos/get_video_by_id/' + id, function (data) {
        $('#edit_title').val(data.title);
        $('#edit_video_slug').val(data.video_slug);
        $('#edit_link').val(data.link);
//		$('#edit_i_class').val(data.i_class);
//		$('#edit_display_order').val(data.display_order);
//		$('#edit-left-sidebar').attr('checked', false);
//		$('#edit-footer').prop('checked', false);
//                if(data.icon_img.length > 0){
//                    var img = '<div class="featured-images-main" id="products_img_'+data.ID+'"><img style="width:150px" src="'+front_uploads+'social-media-icons/'+data.icon_img+'"><i onClick="remove_social_media_icon_image('+data.ID+');" class="deleteIcon"></i></div>';
//                   $('#featured_img').html('');
//                    $('#featured_img').append(img);
//                }
        //       $("#icon_img").attr('src', '../public/uploads/social-media-icons/'+data.icon_img);
        //       CKEDITOR.instances['edit_editor1'].setData(data.banner_desc);
        $('#videos_id').val(data.ID);
        $('#edit_videos_form').modal('show');
    });
}
function delete_videos(id) {
    var myurl = baseUrl + 'videos/delete/' + id;
    var is_confirm = confirm("Are you sure you want to delete this Video?");
    if (is_confirm) {
        $.get(myurl, function (sts) {
            if (sts == 'done')
                $("#row_" + id).fadeOut();
            else
                alert('OOps! Something went wrong.');
        });
    }
}
function validate_edit_video_form(the_form) {
//    if(the_form.edit_title.value==''){
//        alert("Please provide videos title.");
//        return false;
//    }
    if (the_form.edit_video_slug.value == '') {
        alert("Please provide video slug.");
        return false;
    }
    if (the_form.edit_link.value == '') {
        alert("Please provide video URL.");
        return false;
    }
}
//=======Ends Videos  Module=======
//=======Starts FAQ Module=======
function update_faq_status(id) {
    var current_status = $("#sts_" + id + " span").html();
    var myurl = baseUrl + 'faq/status/' + id + '/' + current_status;
    $.get(myurl, function (sts) {
        var class_label = 'success';
        if (sts != 'active')
            var class_label = 'danger';
        $("#sts_" + id).html('<span class="label label-' + class_label + '">' + sts + '</span>');
    });
}
function load_faq_add_form() {
    $('#frm_faq').trigger("reset");
    $('#add_page_form').modal('show');
}
function load_faq_edit_form(id) {
    var my_editor_id = 'editor1';
    $('#edit_frm_faq').trigger("reset");
    // set the content empty
    tinymce.get(my_editor_id).setContent('');
    $.getJSON(baseUrl + 'faq/get_faq_by_id/' + id, function (data) {
        $('#edit_question').val(data.question);
        tinymce.activeEditor.execCommand('mceInsertContent', false, data.answers);
        $('#faq_id').val(data.ID);
        $('#edit_page_form').modal('show');
    });
}
function delete_faq(id) {
    var myurl = baseUrl + 'faq/delete/' + id;
    var is_confirm = confirm("Are you sure you want to delete this faq?");
    if (is_confirm) {
        $.get(myurl, function (sts) {
            if (sts == 'done')
                $("#row_" + id).fadeOut();
            else
                alert('OOps! Something went wrong.');
        });
    }
}
//=======end FAQ Module=======
//=======end news Module=======
//=======Ends projects Module=======
function load_projects_add_form() {
    $("#add_project").trigger('reset');
    $('#add_project_form').modal('show');
}
function load_project_edit_form(id) {
    $('#edit_footer_menu').prop('checked', false);
    $('#edit_top_menu').prop('checked', false);
    $("#edit_frm_products").trigger('reset');
    $.getJSON(baseUrl + 'projects/get_project_by_id/' + id, function (data) {
        // $('#edit_product_category').val(data[0].cate_id);
        //$('#edit_color_category').val(data[0].color_id);
        $('#edit_pro_slug').val(data[0].pro_slug);
        $('#edit_title').val(data[0].title);
        tinyMCE.get('edit_editor1').setContent(data[0].description);
        // var filename = '../public/uploads/product_cate/thumb/'+data.featured_image;
        // $("#featured_image").attr('src', filename);
        if (data[0].meta_title != '' || data[0].meta_description != '' || data[0].meta_keywords != '' || data[0].canonical_url != '') {
            // alert(data[0].meta_keywords.length);
            $('#edit_meta_title').val(data[0].meta_title);
            $('#edit_meta_keywords').val(data[0].meta_keywords);
            $('#edit_meta_description').val(data[0].meta_description);
            $('#edit_canonical_url').val(data[0].canonical_url);
            $('#seo-edit-modul').css('display', 'block');
        }
        $('#project_id').val(data[0].ID);
        $('#edit_frm_product').modal('show');
        $('#pro_uploaded_images').empty();
        //    alert(data[0].images.length);
        if (data[0]['images'].length > 0) {
            for (var i = 0; i < data[0]['images'].length; i++) {
                var img = '<li id="products_img_' + data[0]['images'][i].ID + '"><img src="' + front_uploads + 'projects_images/thumb/' + data[0]['images'][i].image_name + '"><i onClick="delete_uploaded_project_images(' + data[0]['images'][i].ID + ');" class="deleteIcon"></i></li>';
                $('#pro_uploaded_images').append(img);
            }
        }
    });
}
function delete_uploaded_project_images(id) {
    var myurl = baseUrl + 'projects/delete_uploaded_images/' + id;
    var is_confirm = confirm("Are you sure you want to delete this Products image?");
    if (is_confirm) {
        $.get(myurl, function (sts) {
            if (sts == 'done')
                $("#products_img_" + id).fadeOut();
            else
                alert('OOps! Something went wrong.');
        });
    }
}
function update_product_status(id) {
    var current_status = $("#sts_" + id + " span").html();
    var myurl = baseUrl + 'projects/status/' + id + '/' + current_status;
    $.get(myurl, function (sts) {
        var class_label = 'success';
        if (sts != 'active')
            var class_label = 'danger';
        $("#sts_" + id).html('<span class="label label-' + class_label + '">' + sts + '</span>');
    });
}
function delete_project(id) {
    var myurl = baseUrl + 'projects/delete/' + id;
    var is_confirm = confirm("Are you sure you want to delete this Products?");
    if (is_confirm) {
        $.get(myurl, function (sts) {
            if (sts == 'done')
                $("#row_" + id).fadeOut();
            else
                alert('OOps! Something went wrong.');
        });
    }
}
function validate_edit_projects_form(the_form) {
    if (the_form.edit_title.value == '') {
        alert("Please  Title.");
        return false;
    }
    if (the_form.tinyMCE.get('edit_editor1').value == '') {
        alert("Please provide page contents.");
        return false;
    }
}
//=======Ends products Module=======
//=======Starts Case_studies Module=======
function update_case_study_status(id) {
    var current_status = $("#sts_" + id + " span").html();
    var myurl = baseUrl + 'case_studies/status/' + id + '/' + current_status;
    $.get(myurl, function (sts) {
        var class_label = 'success';
        if (sts != 'active')
            var class_label = 'danger';
        $("#sts_" + id).html('<span class="label label-' + class_label + '">' + sts + '</span>');
    });
}
function load_case_studies_add_form() {
    $('#frm_news').trigger("reset");
    $('#add_page_form').modal('show');
}
function load_case_study_edit_form(id) {
    var my_editor_id = 'editor1';
    $('#edit_frm_news').trigger("reset");
    // set the content empty
    tinymce.get(my_editor_id).setContent('');
    $.getJSON(baseUrl + 'case_studies/get_news_by_id/' + id, function (data) {
        $('#edit_news_title').val(data.news_title);
        $('#edit_news_slug').val(data.news_slug);
        var seoClass = document.getElementById('seo-edit-modul');
        if (data.meta_title.length > 0 || data.meta_keywords.length > 0 || data.meta_description.length > 0 || data.canonical_url.length > 0) {
            $('#edit_meta_title').val(data.meta_title);
            $('#edit_meta_keywords').val(data.meta_keywords);
            $('#edit_meta_description').val(data.meta_description);
            $('#edit_canonical_url').val(data.canonical_url);
            seoClass.className = 'seo-edit-modul-sow';
        } else {
            seoClass.className = 'seo-edit-modul-hide';
        }
        tinymce.activeEditor.execCommand('mceInsertContent', false, data.news_description);
        $('#news_id').val(data.ID);
        $('#edit_page_form').modal('show');
    });
}
function delete_case_stud(id) {
    var myurl = baseUrl + 'case_studies/delete/' + id;
    var is_confirm = confirm("Are you sure you want to delete this Case stud?");
    if (is_confirm) {
        $.get(myurl, function (sts) {
            if (sts == 'done')
                $("#row_" + id).fadeOut();
            else
                alert('OOps! Something went wrong.');
        });
    }
}
//=======end news Module=======
//=======Starts Customers Module=======
function update_customers_status(id) {
    var current_status = $("#sts_" + id + " span").html();
    var myurl = baseUrl + 'customers/status/' + id + '/' + current_status;
    $.get(myurl, function (sts) {
        var class_label = 'success';
        if (sts != 'active')
            var class_label = 'danger';
        $("#sts_" + id).html('<span class="label label-' + class_label + '">' + sts + '</span>');
    });
}
function load_customers_add_form() {
    $('#frm_customers').trigger("reset");
    // tinyMCE.get('editor1').setContent('');
    $('#add_customer_form').modal('show');
}
function load_customers_edit_form(id) {
    $('#edit_footer_menu').prop('checked', false);
    $('#edit_top_menu').prop('checked', false);
    $.getJSON(baseUrl + 'customers/get_customers_by_id/' + id, function (data) {
        // $('#edit_banner_title').val(data.customers_title);
        $('#edit_alt_tag').val(data.alt_tag);
        $('#edit_customers_url').val(data.customers_url);
        $("#bannerimages").attr('src', '../public/uploads/customers/thumb/' + data.logo_images);
        $('#customer_id').val(data.ID);
        $('#edit_customer_form').modal('show');
    });
}
function delete_customers(id) {
    var myurl = baseUrl + 'customers/delete/' + id;
    var is_confirm = confirm("Are you sure you want to delete this Banner?");
    if (is_confirm) {
        $.get(myurl, function (sts) {
            if (sts == 'done')
                $("#row_" + id).fadeOut();
            else
                alert('OOps! Something went wrong.');
        });
    }
}
function validate_edit_customers_form(the_form) {
    if (the_form.edit_banner_title.value == '') {
        alert("Please provide Banner Title.");
        return false;
    }
    if (the_form.edit_alt_tag.value == '') {
        alert("Please provide Banner Alt Tag.");
        return false;
    }
    if (CKEDITOR.instances['edit_editor1'].getData() == '') {
        alert("Please provide Banner content.");
        return false;
    }
}
//=======Ends Customers Module=======
function searchResult() {
    var data = $('#searchText').val();
    console.log(data);
    url = base_url+"adminmedia/search?q=" + data;
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
            var obj = data['pages'];
            for (var i = 0; i < obj.length; i++) {
                var obj1 = obj[i];
                $('#result').append('<li><a href="'+base_url+'adminmedia/' + obj1.url + '"><i class="fa fa-arrow-circle-right" aria-hidden="true"> </i> ' + obj1.keyWords + '</a></li>');
            }
            var obj = data['modules'];
            for (var i = 0; i < obj.length; i++) {
                var obj1 = obj[i];
                $('#result').append('<li><a  href="'+base_url+'adminmedia/module/' + obj1.type + '"><i class="fa fa-arrow-circle-right" aria-hidden="true"> </i> ' + obj1.title + '</a></li>');
            }
            var obj = data['cms'];
            for (var i = 0; i < obj.length; i++) {
                var obj1 = obj[i];
                $('#result').append('<li><a href="'+base_url+'adminmedia/module/' + obj1.module.type + '?q='+ obj1.id +'"><i class="fa fa-arrow-circle-right" aria-hidden="true"> </i>' + obj1.heading + '</a></li>');
            }
        },
        error: function (jqXHR, textStatus, errorThrown) {
            console.log(jqXHR);
            console.log(textStatus);
            console.log(errorThrown);
        }
    });
}
$(document).ready(function () {
    $("#sitemap").click(function(){
        $("#lContainer").css("display","block");
        url = base_url+"adminmedia/site-map";
        $.ajax({
            url: url,
            type: 'GET',
            async: true,
            cache: false,
            success: function (data) {
                console.log(data);
                $("#lContainer").css("display","none");
                var win = window.open(base_url+'sitemap.xml', '_blank');
                win.focus();
            },
            error: function (jqXHR, textStatus, errorThrown) {
                console.log(jqXHR);
                console.log(textStatus);
                $("#lContainer").css("display","none");
                console.log(errorThrown);
            }
        });
    });
});