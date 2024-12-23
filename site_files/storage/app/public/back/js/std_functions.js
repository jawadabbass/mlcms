function OnlyNumber(evt, error_div) {
  if (error_div != "") {
    document.getElementById(error_div).innerHTML = "";
  }
  var ctrl = document.all ? event.ctrlKey : evt.ctrlKey;
  var charCode = evt.which ? evt.which : event.keyCode;
  //For Paste
  if (ctrl && (charCode == 86 || charCode == 118)) {
    if (error_div != "") {
      document.getElementById(error_div).innerHTML = "Only Interger Allowed";
    }
    return false;
  }
  //For Numerics
  if (charCode == 8 || (charCode < 58 && charCode > 47)) return true;
  if (error_div != "") {
    document.getElementById(error_div).innerHTML = "Only Interger Allowed";
  }
  return false;
}
function loadprocess(thisobj) {
  $(thisobj).hide();
  $(thisobj).after(
    '<span><img alt="Processing..." src="' +
      asset_storage +
      'images/common/loader.gif"></span>'
  );
}
/*   New Functions from Module JS */
function additional_fields(field_value) {
  for (var count = 1; count <= 8; count++) {
    $("#field" + count).hide();
  }
  for (var count = 1; count <= field_value; count++) {
    $("#field" + count).show();
  }
}
function string_to_slug(titleId, slugId) {
  if ($('[name="' + titleId + '"]').length > 0) {
    var str = $('[name="' + titleId + '"]').val();
  } else if ($("#" + titleId).length > 0) {
    var str = $("#" + titleId).val();
  }
  if ($('[name="' + slugId + '"]').length > 0) {
    var eventSlug = $('[name="' + slugId + '"]').val();
  } else if ($("#" + slugId).length > 0) {
    var eventSlug = $("#" + slugId).val();
  }
  if (str.length > 0 && eventSlug.length == 0) {
    str = str.replace(/^\s+|\s+$/g, "");
    str = str.toLowerCase();
    var from = "àáäâèéëêìíïîòóöôùúüûñç·/_,:;";
    var to = "aaaaeeeeiiiioooouuuunc------";
    for (var i = 0, l = from.length; i < l; i++) {
      str = str.replace(new RegExp(from.charAt(i), "g"), to.charAt(i));
    }
    str = str
      .replace(/[^a-z0-9 -]/g, "")
      .replace(/\s+/g, "-")
      .replace(/-+/g, "-");
    $('[name="' + slugId + '"]').val(str);
    checkRoute(str);
  }
}
function check_slug(slugId) {
  if ($('[name="' + slugId + '"]').length > 0) {
    var str = $('[name="' + slugId + '"]').val();
  } else if ($("#" + slugId).length > 0) {
    var str = $("#" + slugId).val();
  }
  if (str.length > 0) {
    str = str.replace(/^\s+|\s+$/g, "");
    str = str.toLowerCase();
    var from = "àáäâèéëêìíïîòóöôùúüûñç·/_,:;";
    var to = "aaaaeeeeiiiioooouuuunc------";
    for (var i = 0, l = from.length; i < l; i++) {
      str = str.replace(new RegExp(from.charAt(i), "g"), to.charAt(i));
    }
    str = str
      .replace(/[^a-z0-9 -]/g, "")
      .replace(/\s+/g, "-")
      .replace(/-+/g, "-");
    $('[name="' + slugId + '"]').val(str);
    checkRoute(str);
  }
}
function checkRoute(slug) {
  var moduleType = $("#moduleType").val();
  var url = base_url + "adminmedia/checkRoute";
  var request = $.ajax({
    url: url,
    method: "POST",
    data: {
      slug: slug,
      moduleType: moduleType,
      _token: csrf_token,
    },
    dataType: "json",
  });
  request.done(function (response) {
    if (response.status == false) {
      Swal.fire({
        title: '<span style="font-size:18px;">Page with this URL already exists.</span>',
        html: `<span style="font-size:16px;">To Edit the existing Page Click Here :</span><br/>
        <span style="font-size:14px;"><a href="${response.urlToEdit}">${response.urlToEdit}</a></span>`,
        icon: "info",
      });
    }
  });
  request.fail(function (jqXHR, textStatus) {
    Swal.fire({
      title: 'Request failed',
      html: textStatus,
      icon: "error",
    });
  });
}
function reset_model() {
  $("#form")[0].reset(); // reset form on modals
  $(".err").html("");
  $(".message-container").fadeOut(3000);
  $("#product_img_div").hide();
  $("#modal_form").modal("show"); // show bootstrap modal
  $("#seo-edit-modul")
    .removeClass("seo-edit-modul-sow")
    .addClass("seo-edit-modul-hide");
  bind_filer();
}
function reload_table() {
  table.ajax.reload(null, false); //reload datatable ajax
}
function putTextInCursorPlace(class_or_id, text_data) {
  var element = $(class_or_id);
  var cursorPos = element.prop("selectionStart");
  var v = element.val();
  var textBefore = v.substring(0, cursorPos);
  var textAfter = v.substring(cursorPos, v.length);
  element.val(textBefore + text_data + textAfter);
}
