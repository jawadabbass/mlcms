function delete_this_record(id, contr) {
    $('.message-container').fadeOut(3000);
    if (confirm('Are you sure delete this?')) {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $.ajax({
            url: base_url + base_url_admin + "/" + contr + "/" + id,
            type: "DELETE",
            success: function (data) {
                $('#modal_form').modal('hide');
                $('#delete_action').show();
                $("#row_" + id).hide();
                alertme('Your record has been deleted successfully.', 'success')
            },
            error: function (jqXHR, textStatus, errorThrown) {
                alert('Error adding / update data');
            }
        });
    }
}
function getEditDiv_page(pageText, contr, idd) {
    loadNewPopup_BS_Add(escape(pageText), '<div id="content_edit"><span style="color:red;"><h2><i class="fa fa-refresh fa-spin" aria-hidden="true"></i> Loading...</span></h2></div>');
    var datastr = "id=" + idd;
    $.ajax({
        type: "GET",
        url: base_url + base_url_admin + "/" + contr + "/" + idd + "/edit",
        data: datastr,
        success: function (html2) {
            $("#content_edit").html(html2);
            $('[data-bs-toggle="popover"]').popover();
            $('[data-bs-toggle="tooltip"]').tooltip();
            $('[data-bs-toggle="toggle_ajax"]').bootstrapToggle();
        }
    });
}
function mod_edit_page(frm, contr, idd, rf) {
    var pageName = base_url + base_url_admin + "/" + contr + "/" + idd;
    $("#spinner").show();
    var parameters = $(frm).serialize();
    $.ajax({
        type: "PUT",
        timeout: 200000,
        url: pageName,
        data: parameters,
        beforeSend: function () { },
        success: function (msg) {
            $("#spinner").hide();
            if (isJson_page(msg) == false) {
                alert('ERROR::' + msg);

                return false;
            }
            obj = JSON.parse(msg);
            if (obj.success == 'done') {
                $('#myModal').modal('hide');
                alertme('Updated Successfully');
                if (rf == true) {
                    //location.reload();
                }
            } else {
                //alert(obj.errormsg);
                var errMsg = "ERROR:Please fill all fields correctly.\n--------------------------------------------------\n";
                $.each(obj, function (k, v) {
                    // $("#edit_"+k).css('background-color','#edc9c9');
                    errMsg = errMsg + "* " + v + "\n";
                });
                alert(errMsg);
            }
        },
        error: function (jqXHR, textStatus, errorThrown) {
            $("#spinner").hide();
            if (textStatus === "timeout") {
                alert("ERROR: Connection problem"); //Handle the timeout
            } else {
                alert("ERROR: There is something wrong.");
            }
        }
    });
}

function mod_add_page(frm, contr, idd, rf) {
    var pageName = base_url + base_url_admin + "/" + contr;
    $("#loader_div").show();
    $("#loader_div").html('<img src="' + base_admin_image + 'loader_gif.gif" />');
    var parameters = $(frm).serialize();
    $.ajax({
        type: "POST",
        timeout: 200000,
        url: pageName,
        data: parameters,
        beforeSend: function () { },
        success: function (msg) {
            if (isJson_page(msg) == false) {
                alert('ERROR::' + msg);
                $("#loader_div").hide();
                return false;
            }
            obj = JSON.parse(msg);
            if (obj.success == 'done') {
                $('#myModal').modal('hide');
                alertme('Added Successfully');
                if (rf == true) {
                    location.reload();
                }
            } else {
                //alert(obj.errormsg);
                var errMsg = "ERROR:Please fill all fields correctly.\n--------------------------------------------------\n";
                $.each(obj, function (k, v) {
                    // $("#edit_"+k).css('background-color','#edc9c9');
                    errMsg = errMsg + "* " + v + "\n";
                });
                alert(errMsg);
            }
        },
        error: function (jqXHR, textStatus, errorThrown) {
            if (textStatus === "timeout") {
                alert("ERROR: Connection problem"); //Handle the timeout
            } else {
                alert("ERROR: There is something wrong.");
            }
        }
    });
}
function getPop(pageText, contr, idd, pop) {
    loadNewPopup_BS_Add(escape(pageText), '<div id="content_edit"><h3><span style="color:red;"><i class="fa fa-spinner fa-spin"></i> Loading...</span></h3></div>');
    $.ajax({
        type: "GET",
        timeout: 200000,
        url: base_url + base_url_admin + "/" + contr + "/pop?typ=" + pop,
        data: {},
        success: function (html2) {
            if (html2 != '') {
                $("#content_edit").html(html2);
                $('[data-bs-toggle="popover"]').popover();
                $('[data-bs-toggle="tooltip"]').tooltip();
                $('[data-bs-toggle="toggle_ajax"]').bootstrapToggle();
            }
        },
        error: function (jqXHR, textStatus, errorThrown) {
            if (textStatus === "timeout") {
                alert("ERROR: Connection problem"); //Handle the timeout
            } else {
                alert("ERROR: There is something wrong.");
            }
        }
    });
}
function isJson_page(str) {
    try {
        JSON.parse(str);
    } catch (e) {
        return false;
    }
    return true;
}
function alertme(text, type, autoClose, closeAfterSec) {
    var type = type || 'success';
    var autoClose = autoClose || true;
    var closeAfterSec = closeAfterSec || 3000;
    $(".alertme").hide();
    var mhtml = '<div class="alertme" id="div_alert" style="margin:5px;top:3%;position:fixed;z-index:9999;width:100%">' +
        '<div style="max-width: 700px;margin: 0 auto;" class="alert alert-' + type + ' alert-dismissible"> <button type="button" class="btn-close" data-bs-dismiss="alert"></button> ' + text + '</div></div>';
    $("body").append(mhtml);
    if (autoClose) {
        setTimeout(function () { $(".alertme").hide(); }, closeAfterSec);
    }
}
function updatePageStatus(checkval, idd, fld) {
    var sts = '';
    if (checkval == true) {
        sts = 'Yes';
    }
    else {
        sts = 'No';
    }
    $.ajax({
        type: "POST",
        timeout: 5000,
        url: base_url + base_url_admin + "/" + contr + "/update_status",
        data: {
            sts: sts,
            fld: fld,
            _token: $('meta[name="csrf-token"]').attr('content'),
            idd: idd
        },
        success: function (data) {

        },
        error: function (jqXHR, textStatus, errorThrown) {
            if (textStatus === "timeout") {
                alert("ERROR: Connection problem"); //Handle the timeout
            } else {
                alert("ERROR: There is something wrong.");
            }
        }
    });
}
$(document).ready(function () {
    $(function () {
        $(".sorta").sortable({
            opacity: 0.6, cursor: 'move', update: function () {
                var order = $(this).sortable("serialize") + '&action=updateRecordsListings&_token=' + $('meta[name="csrf-token"]').attr('content');
                $.post(base_url + base_url_admin + "/" + contr + "/update_order", order, function (theResponse) {
                });
            }
        });
    });
});
//Form POST
function submitMyForm_v2(postURL, cbfunc) {
    var pageName = postURL;
    $("#loader_div").show();

    $(".subm").attr('disabled', true);
    var btnText = $(".subm").html();
    $(".subm").html('<i class="fa fa-refresh fa-spin" aria-hidden="true"></i> Processing');
    $.ajax({
        type: "POST",
        timeout: 200000,
        url: pageName,
        //data: parameters,
        data: new FormData($("#frm")[0]),
        contentType: false,
        cache: false,             // To unable request pages to be cached
        processData: false,
        beforeSend: function () { },
        success: function (msg) {
            $(".subm").attr('disabled', false);
            $(".subm").html(btnText);
            if (isJson(msg) == false) { alert('ERROR::' + msg); $("#loader_div").hide(); return false; }
            obj = JSON.parse(msg);
            if (obj.success == 'done') {
                cbfunc();
            }
            else {
                $("#loader_div").hide();
                $(".subm").attr('disabled', false);
                alert(obj.errormsg);

            }
        },
        error: function (jqXHR, textStatus, errorThrown) {
            $(".subm").html(btnText);
            $("#loader_div").hide();
            $(".subm").attr('disabled', false);
            if (textStatus === "timeout") {
                alert("ERROR: Connection problem"); //Handle the timeout
            } else {
                alert("ERROR: There is something wrong.");
            }
        }
    });

}
//Form Post With Data
function postMyForm(postURL, dataObj, cbfunc, errCbFunc) {
    var pageName = postURL;
    $.ajax({
        type: "POST",
        timeout: 200000,
        url: pageName,
        //data: parameters,
        data: dataObj,
        beforeSend: function () { },
        success: function (msg) {
            if ($(".subm").length > 0) {
                if (typeof (btnText) !== 'undefined') {
                    $(".subm").html(btnText);
                } else {
                    $(".subm").html('Submit');
                }

                $("#loader_div").hide();
                $(".subm").attr('disabled', false);
            }
            if (isJson_page(msg) == false) {
                alert('ERROR::' + msg); $("#loader_div").hide(); return false;
            }
            obj = JSON.parse(msg);
            if (obj.success == 'done') {
                cbfunc();
            }
            else {
                alert(obj.errormsg);
                errCbFunc();
                //RR location.reload();

            }
        },
        error: function (jqXHR, textStatus, errorThrown) {
            if ($(".subm").length > 0) {
                if (typeof (btnText) !== 'undefined') {
                    $(".subm").html(btnText);
                } else {
                    $(".subm").html('Submit');
                }

                $("#loader_div").hide();
                $(".subm").attr('disabled', false);
            }
            if (errorThrown == 'Unauthorized') {
                Swal.fire({
                    icon: 'error',
                    title: 'ERROR!',
                    text: 'You are not logged in!',
                    footer: '<a href="' + base_url + 'login">Click here</a> to login'
                });
                return false;
            }
            if (textStatus === "timeout") {
                alert("ERROR: Connection problem"); //Handle the timeout
            } else {
                alert("ERROR: There is something wrong.");
            }
            //RR location.reload();
        }
    });

}