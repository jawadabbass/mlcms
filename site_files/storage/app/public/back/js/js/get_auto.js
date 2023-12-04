function getData(casee, idd, pageText, w, h) {

    if (h == '') {

        h = '120';

    }

    if (w == '') {

        w = '500';

    }

    loadNewPopup_BS_Add(escape(pageText), '<div id="content55"><span style="color:red;">Loading...</span></div>');

    //if(confirm('OKAY DONE')){


    var datastr = "id=" + idd + "&casee=" + casee;

    $.ajax({

        type: "POST",

        url: base_url + base_url_admin + "/ajax_request/getcontent",

        data: datastr,

        success: function (html2) {

            $("#content55").html(html2);

            //loadNewPopup(escape('Page Title'),html2,'500','300','1','1','tag','body','','','absolute');

        }

    });

    //}


}


function getDataContact(casee, idd, pageText, w, h, mat, ipp) {


    loadNewPopup_BS_Add(escape(pageText), '<div id="content_add"><span style="color:red;">Loading...</span></div>');


    var datastr = "id=" + idd + "&casee=" + casee + "&mat=" + mat + "&ipp=" + ipp;

    $.ajax({

        type: "POST",

        url: base_url + base_url_admin + "/ajax_request/getcontent",

        data: datastr,

        success: function (html2) {

            $("#content_add").html(html2);

        }

    });


}


function getAddDiv(pageText, contr, idd) {
    loadNewPopup_BS_Add(escape(pageText), '<div id="content_add"><span style="color:red;">Loading...</span></div>');
    var datastr = "id=" + idd;
    $.ajax({
        type: "POST",
        url: base_url + base_url_admin + "/" + contr + "/add",
        data: datastr,
        success: function (html2) {
            $("#content_add").html(html2);
        }
    });
}


function getEditDiv(pageText, contr, idd) {
    loadNewPopup_BS_Add(escape(pageText), '<div id="content_edit"><span style="color:red;">Loading...</span></div>');
    var datastr = "id=" + idd;
    $.ajax({
        type: "POST",
        url: base_url + base_url_admin + "/" + contr + "/edit",
        data: datastr,
        success: function (html2) {
            $("#content_edit").html(html2);
        }

    });
}

function getAddDiv(pageText, contr, idd) {
    loadNewPopup_BS_Add(escape(pageText), '<div id="content_edit"><span style="color:red;">Loading...</span></div>');
    var datastr = "id=" + idd;
    $.ajax({
        type: "POST",
        url: base_url + base_url_admin + "/" + contr + "/add",
        data: datastr,
        success: function (html2) {
            $("#content_edit").html(html2);
        }

    });
}


function editForm_cat_addListing(frm, contr, idd) {
    var pageName = base_url + base_url_admin + "/" + contr + "/action_add";
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
            obj = JSON.parse(msg);
            if (obj.success == 'done') {
                $("#edit_" + idd).html(obj.errormsg);
                $('#myModal').modal('hide');
            }
            else {
                alert(obj.errormsg);

            }
        }
    });

}


function submitForm(frm, contr) {

    var pageName = base_url + base_url_admin + "/" + contr + "/action_add";

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

            obj = JSON.parse(msg);

            if (obj.success == 'done') {

                $("#content_add").html('<div class="row"><div class="col-sm-6"><h3><i class="fa fa-check" aria-hidden="true"></i> Done</h3> <a href="javascript:;" onClick="getAddDiv(\'Add New\',\'' + contr + '\',\'0\');">Click here</a> for add one more</div><div class="col-sm-6"><button type="button" class="btn btn-info" onClick="location.reload();">Close</button></div></div>');

            }

            else {

                $("#loader_div").html('');

                $("#loader_div").html('<span style="color: rgb(255, 0, 0); border: 2px dotted rgb(255, 0, 0);">ERROR::' + obj.errormsg);


            }

        }

    });


}

function submitForm_cat(frm, contr) {
    var pageName = base_url + "adminmedia/categories";
    var parameters = $('#validatethis').serialize();
    $.ajax({
        type: "POST",
        url: pageName,
        data: parameters,
        beforeSend: function () {
        },
        success: function (msg) {
            console.log(msg);
            // $('#add_page_form').modal('close');
            location.reload();
        }
    });
}


function editForm_cat() {
    var pageName = base_url + "adminmedia/categories/0";
    var parameters = $('#validatethisedit').serialize();
    $.ajax({
        type: "POST",
        url: pageName,
        data: parameters,
        beforeSend: function () {
        },
        success: function (msg) {
            console.log(msg);
            // $('#add_page_form').modal('close');
            location.reload();
        },
        error: function (jqXHR, textStatus, errorThrown) {
            alert('Error get data from ajax');
            console.log(jqXHR);
            console.log(textStatus);
            console.log(errorThrown);
        }
    });
}


function getDataCat(casee, cat, idd, pageText, w, h) {

    if (h == '') {

        h = '120';

    }

    if (w == '') {

        w = '500';

    }

    loadNewPopup_BS_Add(escape(pageText), '<div id="content55"><span style="color:red;">Loading...</span></div>');

    //if(confirm('OKAY DONE')){


    var datastr = "id=" + idd + "&casee=" + casee + "&cat=" + cat;

    $.ajax({

        type: "POST",

        url: base_url + base_url_admin + "/ajax_request/getcontent",

        data: datastr,

        success: function (html2) {

            $("#content55").html(html2);

            //loadNewPopup(escape('Page Title'),html2,'500','300','1','1','tag','body','','','absolute');

        }

    });

    //}


}


function getData2(casee, idd, pageText, ht) {


    loadNewPopup(escape(pageText), '<div id="content55"><span style="color:red;">Loading...</span></div>', '500', ht, '1', '1', 'tag', 'body', '', '', 'fixed');

    //if(confirm('OKAY DONE')){


    var datastr = "id=" + idd + "&casee=" + casee;

    $.ajax({

        type: "POST",

        url: base_url + base_url_admin + "/ajax_request/getcontent",

        data: datastr,

        success: function (html2) {

            $("#content55").html(html2);

            //loadNewPopup(escape('Page Title'),html2,'500','300','1','1','tag','body','','','absolute');

        }

    });

    //}


}