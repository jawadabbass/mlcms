function confirmDel() {
    if (confirm("Are you sure you want to delete?")) {
        return true;
    }
    else {
        return false;
    }
}

function confirmMsg(msg) {
    if (confirm(msg)) {
        return true;
    }
    else {
        return false;
    }
}

function DelMatchIp(act, ipp) {

    if (act == 'match2') {
        if (confirm('Are you sure you want to Delete Matching \"' + ipp + '\" IP Address Records ?')) {
            window.location.href = base_url + base_url_admin + '/ajax_request/srch_ip_2_remove/?find_in=ipmatch2&srch=' + ipp;
        }
    }
    else if (act == 'match') {
        if (confirm('Are you sure you want to Delete Exact Matching IP(' + ipp + ') Address Records')) {
            window.location.href = base_url + base_url_admin + '/ajax_request/srch_ip_2_remove/?find_in=ipmatch&srch=' + ipp;
        }
    }
    else
        alert('ERROR');

}

function del_this_rec(idd, keyy) {

    if (confirmDel()) {
        var datastr = "id=" + idd + "&tbl=123";
        $.ajax({
            type: "POST",
            url: base_url + base_url_admin + "/" + keyy + "/delthis/" + idd,
            data: datastr,
            success: function (html2) {
                $("#trr" + idd).fadeOut(1000);
                var tolrec = $("#total_rec").html();
                var tolrec = $("#total_rec").html(parseInt(tolrec) - 1);

            }
        });

    }

}


function delete_category_ajax(id) {
    if (confirm('Are you sure delete this data?')) {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $.ajax({
            url: base_url + 'adminmedia/categories/' + id,
            type: "DELETE",
            success: function (data) {
                //if success reload ajax table
                $("#recordsArray_" + id).fadeOut(1000);
                var tolrec = $("#total_rec").html();
                var tolrec = $("#total_rec").html(parseInt(tolrec) - 1);
                // $('#modal_form').modal('hide');
                // $('#delete_action').show();
                // location.reload();
            },
            error: function (jqXHR, textStatus, errorThrown) {
                alert('Error Deleting data');
            }
        });

    }
}


function del_rec(idd, tbl) {
    if (confirmDel()) {
        var datastr = "id=" + idd + "&tbl=" + tbl;
        $.ajax({
            type: "POST",
            url: base_url + base_url_admin + "/ajax_request/del_page",
            data: datastr,
            success: function (html2) {
                if (html2 == 'ok') {
                    if (tbl == 'categories') {
                        $("#recordsArray_" + idd).fadeOut(1000);
                        var tolrec = $("#total_rec").html();
                        var tolrec = $("#total_rec").html(parseInt(tolrec) - 1);
                    }
                    else {
                        $("#trr" + idd).fadeOut(1000);
                        var tolrec = $("#total_rec").html();
                        var tolrec = $("#total_rec").html(parseInt(tolrec) - 1);
                    }
                }
                else {
                    //$('#frm2').submit();
                    alert('ERROR:' + html2);

                }
            }
        });

    }

}


function removeCache() {

    if (confirmDel()) {
        var datastr = "";
        $.ajax({
            type: "POST",
            url: base_url + base_url_admin + "/remove_cache/index/ajax",
            data: datastr,
            success: function (html2) {
                if (html2 == 'ok') {
                }
                else {
                }
            }
        });

    }

}


function updateCaste(curCaste, updID, act) {
    var updateCaste = document.getElementById('cast_dd' + updID).value;
    if (updID == '') {
        alert('Please Select Caste');
        return true;
    }

    //loadingDiv();
    var datastr = "cval=" + curCaste + "&uval=" + updateCaste + "&act=" + act;
    $.ajax({
        type: "POST",
        url: base_url + base_url_admin + "/caste_manager/caste_frequency",
        data: datastr,
        success: function (retdata) {
            html2 = JSON.parse(retdata);
            //closePopup();
            $('#myModal').modal('hide');
            if (html2[0] == 'ok') {
                if (act == 'add') {
                    var val = capitaliseFirstLetter(curCaste);
                    var newOption = $('<option value="' + val + '">' + val + '</option>');
                    $('.dp_vals').append(newOption);
                    $('#contentLeft ul.sorta').append('<li id="recordsArray_' + html2[2] + '"><span id="drp_' + html2[2] + '">' + val + '(<span id="ccaste_' + html2[2] + '">' + html2[1] + '</span>)</span>&nbsp;&nbsp;<span class="btn btn-info" style="cursor:pointer;" onclick="getData(\'edit_Profession\',\'' + html2[2] + '\',\'Edit Caste\',500,70);">Edit</span>&nbsp;&nbsp;<a title="Delete" onclick="del_recNew(\'' + html2[2] + '\',\'categories\');" href="javascript:;" class="btn btn-danger">Delete</a> | <a style="font-size:13px; color:green;" href="javascript:;" onclick="getDataCat(\'add_slug\',\'8\',\'' + html2[2] + '\',\'Add Slug\',500,180);">Add Slug</a></li>');

                }
                else if (act == 'upd') {
                    $("#drp_" + html2[2]).html(updateCaste + ' (' + html2[1] + ')');
                }

                $("#frq_" + updID).fadeOut(1000);
            }
            else {
                alert('ERROR:' + html2[1]);

            }
        }
    });


}

function loadingDiv() {
    var h = '50';
    var w = '144';
    loadNewPopup_Loading(escape('Processing...'), '<div id="content_aa_22"><img src="' + base_admin_image + 'loader.gif" ></div>', w, h, '1', '1', 'tag', 'body', '', '', 'fixed');
}

function capitaliseFirstLetter(string) {
    return string.charAt(0).toUpperCase() + string.slice(1);
}

function del_recNew(idd, tbl) {
    if (confirmDel()) {
        //loadingDiv();
        var datastr = "id=" + idd + "&tbl=" + tbl;
        $.ajax({
            type: "POST",
            url: base_url + base_url_admin + "/ajax_request/del_page",
            data: datastr,
            success: function (html2) {
                //closePopup();
                $('#myModal').modal('hide');
                if (html2 == 'ok') {

                    //alert('Deleted Successfully');
                    $("#recordsArray_" + idd).fadeOut(1000);
                    var tolrec = $("#total_rec").html();
                    var tolrec = $("#total_rec").html(parseInt(tolrec) - 1);
                }
                else {
                    //$('#frm2').submit();
                    alert('ERROR:' + html2);

                }
            }
        });

    }

}


function change_status(idd) {
    if (confirmDel()) {
        loadingDiv();
        var datastr = "id=" + idd;
        $.ajax({
            type: "POST",
            url: "change_status.php",
            data: datastr,
            success: function (html2) {
                //closePopup();
                $('#myModal').modal('hide');
                if (html2 == 'ok') {

                    alert('Status Updated Successfully');
                    $("#trr" + idd).fadeOut(1000);
                }
                else {
                    //$('#frm2').submit();
                    alert('ERROR:' + html2);

                }
            }
        });

    }

}

function ChangeFeatured(idd, sts) {

    var datastr = "id=" + idd;
    $.ajax({
        type: "POST",
        url: "change_f.php",
        data: datastr,
        success: function (html2) {
            if (html2 == 'ok') {
                var csts = $("#spn" + idd).html();
                if (csts == 'No') {

                    $("#spn" + idd).html('Yes');
                }
                else {
                    $("#spn" + idd).html('No');
                }

                //alert('Status Updated Successfully');
                //$("#trr"+idd).fadeOut(1000);
            }
            else {
                //$('#frm2').submit();
                alert('ERROR:' + html2);

            }
        }
    });


}


function ChangeEmailVerification(idd, sts) {

    var datastr = "id=" + idd;
    $.ajax({
        type: "POST",
        url: "change_email_verification.php",
        data: datastr,
        success: function (html2) {
            if (html2 == 'ok') {
                var csts = $("#spn_emlv_" + idd).html();
                if (csts == 'No') {

                    $("#spn_emlv_" + idd).html('Yes');
                }
                else {
                    $("#spn_emlv_" + idd).html('No');
                }

                //alert('Status Updated Successfully');
                //$("#trr"+idd).fadeOut(1000);
            }
            else {
                //$('#frm2').submit();
                alert('ERROR:' + html2);

            }
        }
    });


}

function ChangeStatusPending(idd, sts) {
    var datastr = "id=" + idd;
    $.ajax({
        type: "POST",
        url: base_url + base_url_admin + "/ajax_request/updatestatus",
        data: datastr,
        success: function (html2) {
            if (html2 == 'ok') {
                var csts = $("#sts" + idd).html();

                $("#sts" + idd).css('color', 'green');
                $("#sts" + idd).html('Active');


                //alert('Status Updated Successfully');
                //$("#trr"+idd).fadeOut(1000);
            }
            else {
                //$('#frm2').submit();
                alert('ERROR:' + html2);

            }
        }
    });


}

function getTotalResults(frm) {

    var pageName = base_url + base_url_admin + "/ajax_request/ajax_func";
    $("#loader_div").show();
    $("#loader_div").html('<img src="' + base_admin_image + 'loader_gif.gif" />');
    var parameters = $(frm).serialize();
    $.ajax({
        type: "POST",
        url: pageName,
        data: parameters,
        beforeSend: function () {
        },
        success: function (msg) {
            //$("#rest").html(msg);

            obj = JSON.parse(msg);
            if (obj.success == 'done') {
                $("#loader_div").html('');
                $("#loader_div").html('Total Records:<strong>' + obj.total + "</strong>");

            }
            else {
                $("#loader_div").html('');

                $("#loader_div").html('<span style="color: rgb(255, 0, 0); border: 2px dotted rgb(255, 0, 0);">ERROR::');

                if (typeof obj.errormsg !== 'undefined') {
                    $("#loader_div").html('<span style="color: rgb(255, 0, 0); border: 2px dotted rgb(255, 0, 0);">ERROR:: ' + obj.errormsg + "</span>");
                }

                //$("#loader_div").html('<span style="color: rgb(255, 0, 0);">ERROR: </span>');
            }
        }
    });

}


function ChangeStatus(idd, csts, tbl) {

    var datastr = "id=" + idd + "&csts=" + csts + "&tbl=" + tbl;
    $.ajax({
        type: "POST",
        url: "change_status_now.php",
        data: datastr,
        success: function (html2) {
            if (html2 == 'ok') {
                var csts = $("#sts" + idd).html();

                $("#sts" + idd).css('color', 'green');
                $("#sts" + idd).html('Active');
            }
            else if (html2 == 'ok2') {
                var csts = $("#sts" + idd).html();

                $("#sts" + idd).css('color', 'red');
                $("#sts" + idd).html('in active');
            }
            else {
                //$('#frm2').submit();
                alert('ERROR:' + html2);

            }
        }
    });


}

function ChangeStatusUser(idd, csts, tbl) {

    var datastr = "id=" + idd + "&csts=" + csts + "&tbl=" + tbl;
    $.ajax({
        type: "POST",
        url: "change_status_now_user.php",
        data: datastr,
        success: function (html2) {
            if (html2 == 'ok') {
                var csts = $("#sts" + idd).html();

                $("#sts" + idd).css('color', 'green');
                $("#sts" + idd).html('Active');
            }
            else if (html2 == 'ok2') {
                var csts = $("#sts" + idd).html();

                $("#sts" + idd).css('color', 'red');
                $("#sts" + idd).html('in active');
            }
            else {
                //$('#frm2').submit();
                alert('ERROR:' + html2);

            }
        }
    });


}

function ChangeBlocked(idd, sts) {

    var datastr = "id=" + idd;
    $.ajax({
        type: "POST",
        url: base_url + base_url_admin + "/ajax_request/change_b",
        data: datastr,
        success: function (html2) {
            if (html2 == 'ok') {
                var csts = $("#bspn" + idd).html();
                if (csts == 'block' || csts == 'Blocked') {
                    $("#bspn" + idd).css('color', 'green');
                    $("#bspn" + idd).html('Un Blocked');
                }
                else {
                    $("#bspn" + idd).css('color', 'red');
                    $("#bspn" + idd).html('Blocked');
                }

                //alert('Status Updated Successfully');
                //$("#trr"+idd).fadeOut(1000);
            }
            else {
                //$('#frm2').submit();
                alert('ERROR:' + html2);

            }
        }
    });


}

function BlockIP(idd, ipp, objj, act, ipcls) {

    var pageName = base_url + base_url_admin + "/ajax_request/ajax_func";
    var parameters = '';
    if (act == 'block')
        parameters = "id=" + idd + "&ip=" + ipp + "&act=block_ip";
    if (act == 'unblock')
        parameters = "id=" + idd + "&ip=" + ipp + "&act=un_block_ip";


    $.ajax({
        type: "POST",
        url: pageName,
        data: parameters,
        beforeSend: function () {
        },
        success: function (msg) {
            //$("#rest").html(msg);

            obj = JSON.parse(msg);
            if (obj.success == 'done') {
                $('.' + ipcls).hide();
                if (act == 'block') {

                    /*$(objj).css('color','red');
                    $(objj).attr("onclick", 'BlockIP(\''+idd+'\',\''+ipp+'\',this,\'unblock\');');
                    $(objj).html('Un Block Visit');*/


                }
                if (act == 'unblock') {
                    //$(objj).hide();

                    /*$(objj).css('color','black');
                    $(objj).attr("onclick", 'BlockIP(\''+idd+'\',\''+ipp+'\',this,\'block\');');
                    $(objj).html('Block Visit');*/


                }


            }
            else {


                //$("#loader_div").html('<span style="color: rgb(255, 0, 0);">ERROR: </span>');
            }
        }
    });


}

function AjaxFunc(idd, objj, act, cval) {

    /*if(!confirm('Are you sure you want to do ?')){
        return false;
    }*/

    var pageName = base_url + base_url_admin + "/ajax_request/ajax_func";
    parameters = "id=" + idd + "&cval=" + cval + "&act=" + act;


    $.ajax({
        type: "POST",
        url: pageName,
        data: parameters,
        beforeSend: function () {
        },
        success: function (msg) {
            //$("#rest").html(msg);

            obj = JSON.parse(msg);
            if (obj.success == 'done') {

                if (act == 'email_verified') {
                    if (cval == '1' || cval == 'yes') {
                        $(objj).html('No')
                        $(objj).parent(objj).find('span').attr('onclick', 'AjaxFunc(\'' + idd + '\',this,\'' + act + '\',\'0\');');
                        $(objj).parent(objj).find('span').attr('class', 'label label-danger');
                    }

                    else {
                        $(objj).html('Yes');
                        $(objj).parent(objj).find('span').attr('onclick', 'AjaxFunc(\'' + idd + '\',this,\'' + act + '\',\'1\');');
                        $(objj).parent(objj).find('span').attr('class', 'label label-success');
                    }
                }
                else if (act == 'featured') {
                    if (cval == '1' || cval == 'yes') {
                        $(objj).html('No')
                        $(objj).parent(objj).find('span').attr('onclick', 'AjaxFunc(\'' + idd + '\',this,\'' + act + '\',\'0\');');
                        $(objj).parent(objj).find('span').attr('class', 'label label-danger');
                    }

                    else {
                        $(objj).html('Yes');
                        $(objj).parent(objj).find('span').attr('onclick', 'AjaxFunc(\'' + idd + '\',this,\'' + act + '\',\'1\');');
                        $(objj).parent(objj).find('span').attr('class', 'label label-success');
                    }
                }
                else if (act == 'updatestatus') {
                    if (cval == 'Pending') {
                        $(objj).html('Active')
                        $(objj).parent(objj).find('span').attr('onclick', 'AjaxFunc(\'' + idd + '\',this,\'' + act + '\',\'pending\');');
                    }

                    else {
                        $(objj).html('Pending');
                        $(objj).parent(objj).find('span').attr('onclick', 'AjaxFunc(\'' + idd + '\',this,\'' + act + '\',\'active\');');
                    }
                }
                else if (act == 'remove_img') {
                    $(objj).hide();
                    $(objj).parent(objj).find("a img").attr('src', base_url + '/user-picture/home/no_image.jpg');
                }
                else {
                    alert('Function Performed successfully');
                }


            }
            else {
                alert('ERROR:' + msg);
            }
        }
    });


}


function UpdateAjax(idd, descp_id) {
    var descp = document.getElementById(descp_id).value;
    var id_id = document.getElementById(idd).value;

    //loader_gif
    $("#btn_submit_div").hide();
    $("#loader_div").show();

    var datastr = "act=updSlug&descp=" + descp + "&id=" + id_id;
    $.ajax({
        type: "POST",
        url: base_url + base_url_admin + "/ajax_request/action",
        data: datastr,
        success: function (html2) {
            if (html2 == 'ok') {
                //closePopup();
                $('#myModal').modal('hide');
            }
            else {
                $("#btn_submit_div").show();
                $("#loader_div").hide();

                $("#popup_err").html(html2);

            }
        }
    });
}

function UpdateAjax_child(idd, descp_id) {
    var descp = document.getElementById(descp_id).value;
    var id_id = document.getElementById(idd).value;


    //$(".non_exist_cat").each(function(){this.html('Something Different')});
    $(".non_exist_cat span").each(function (index, elem) {

        var descpVal = $(this).html();
        var curObj = $(this);

        var arr44 = descp.split(",");
        $.each(arr44, function (key, value) {
            if (descpVal == value) {
                //curObj.html('OKKK');
                curObj.parent('span').parent('li').hide(1000);
            }

        });

    });


    //loader_gif
    $("#btn_submit_div").hide();
    $("#loader_div").show();

    var datastr = "act=updSlugChild&descp=" + descp + "&id=" + id_id;
    $.ajax({
        type: "POST",
        url: base_url + base_url_admin + "/ajax_request/action",
        data: datastr,
        success: function (html2) {
            if (html2 == 'ok') {
                //closePopup();
                $('#myModal').modal('hide');
            }
            else {
                $("#btn_submit_div").show();
                $("#loader_div").hide();

                $("#popup_err").html(html2);

            }
        }
    });
}

function showcities_ajax(country) {
    $("#citi").html('<span class="loading">loading...</span>');
    var datastr = "country=" + country;
    $.ajax({
        type: "POST",
        url: base_url + base_url_admin + "/ajax_request/findcity",
        data: datastr,
        success: function (html2) {
            $("#citi").html(html2);
        }

    });
}

function ViewBox(idd, email) {

    var pos = $("#trr" + idd).position();
    var Left = (pos.left);
    var Top = pos.top;
    //$("#mid").val(idd);
    $("#comments_text").html(email);
    $('#comments_text').css({'left': Left, 'top': Top + 200, 'position': 'absolute'});
    $("#comments_text").show();


}

function showDv(g_analy) {
    $(g_analy).toggle(800);
}

function UpdateSettings(keyy) {
    loadingDiv();
    var datastr = "key=" + keyy + "&val=" + document.getElementById(keyy).value;
    $.ajax({
        type: "POST",
        url: base_url + base_url_admin + "/ajax_request/updatesettings",
        data: datastr,
        success: function (html2) {
            closePopup();
            if (html2 != 'ok') {
                alert(html2);
            }

        }

    });
}
	