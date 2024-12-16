/*
Author: sadiq noor
Date: 28/01/16
Version: 2.0
*/
function load_services_add_form() {
  $("#frm_services").trigger("reset");
  $("#add_services_form").modal("show");
}

function delete_services(id) {
  var myurl = base_url + "services/delete/" + id;
  var is_confirm = confirm("Are you sure you want to delete this Service?");
  if (is_confirm) {
    $.get(myurl, function (sts) {
      if (sts == "done") $("#row_" + id).fadeOut();
      else alert("OOps! Something went wrong.");
    });
  }
}

function update_services_status(id) {
  var current_status = $("#sts_" + id + " span").html();
  var myurl = base_url + "services/status/" + id + "/" + current_status;
  $.get(myurl, function (sts) {
    var class_label = "success";
    if (sts != "active") var class_label = "danger";
    $("#sts_" + id).html(
      '<span class="label label-' + class_label + '">' + sts + "</span>"
    );
  });
}

function load_services_edit_form(id) {
  $("#edit_frm_services").trigger("reset");
  // set the content empty
  //tinymce.get(my_editor_id).setContent('');
  tinyMCE.get("editor1").setContent("");
  $("#edit_footer_menu").prop("checked", false);
  $("#edit_top_menu").prop("checked", false);
  $.getJSON(base_url + "services/get_cms_by_id/" + id, function (data) {
    $("#edi_name").val(data.name);
    $("#edit_slug").val(data.slug);
    //$('#edit_page_slug').val(data.page_slug);
    if (data.image == null || data.image == "" || data.image == 0) {
      //  $("#featured-no-images").fadeIn();
      $("#module_featured_img").fadeOut();
    } else {
      $("#module_featured_img").fadeIn();
      var img = `
        <div class="card-header">Featured Image</div>
        <div class="card-body">
            <img style="width:100px" src="${asset_uploads}services/thumb/${data.image}">
        </div>
        <div class="card-footer">
            <button type="button" class="btn btn-sm btn-danger"
                onclick="remove_featured_img(${data.ID});"><i
                    class="fas fa-trash"></i></button>
        </div>`;
      $("#module_featured_img").html("");
      $("#module_featured_img").append(img);
    }

    $("#service_id").val(data.ID);
    //tinymce.activeEditor.execCommand('mceInsertContent', false, data.details);
    tinyMCE.get("editor1").setContent(data.details);
    $("#edit_services_form").modal("show");
  });
}
function remove_services_featured_image(id) {
  var myurl = base_url + "services/remove_services_feature_image/" + id;
  var is_confirm = confirm(
    "Are you sure you want to delete this image featured image?"
  );
  if (is_confirm) {
    $.get(myurl, function (sts) {
      if (sts == "done") $("#products_img_" + id).fadeOut();
      else alert("OOps! Something went wrong.");
    });
  }
}
