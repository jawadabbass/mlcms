/*
Author: sadiq noor
Date: 28/01/16
Version: 2.0
*/
//=======Starts product Module=======
$(function () {
    $('#sortable').sortable({
        axis: 'y',
        opacity: 0.7,
        handle: 'span',
        update: function (event, tr) {
            var list_sortable = $(this).sortable('toArray').toString();
            // change order in the database using Ajax
            $.ajax({
                url: base_url + 'products/update_orders',
                type: 'POST',
                data: { list_order: list_sortable },
                success: function (data) {
                    //finished
                    //console.log(data);
                }
            });
        }
    }); // fin sortable
});
function load_products_add_form() {
    $('#frm_products').trigger("reset");
    $('#add_page_form').modal('show');
    set_seo_limit_suggestions();
}
function load_products_edit_form(id) {
    //alert(id);
    $('#edit_frm_products').trigger("reset");
    $.getJSON(base_url + 'products/get_products_by_id/' + id, function (data) {
        if (data.product_img == null || data.product_img == '' || data.product_img == 0) {
            //    alert('empty');
            $("#product_img").fadeOut();
        } else {
            //   alert('image');
            $("#product_img").fadeIn();
            var img = '<div class="featured-images-main" id="products_img_' + data.ID + '"><img style="width:150px" src="' + asset_uploads + 'products/thumb/' + data.product_img + '"><i onClick="remove_products_image(' + data.ID + ');" class="deleteIcon"></i></div>';
            $('#product_imgg').html('');
            $('#product_imgg').append(img);
            // alert(img);
        }
        $('#edit_pname').val(data.product_name);
        $('#products_id').val(data.ID);
        //$('#edit_product_category').val(data.cate_id);
        $('.edit_product_category select').val(data.cate_id);
        fillSeoFields(data);
        // $('#edit_pdesc').val(data.product_description);
        tinymce.activeEditor.execCommand('mceInsertContent', false, data.product_description);
        $('#edit_price').val(data.price);
        $('#edit_page_form').modal('show');
    });
}
function delete_products(id) {
    var myurl = base_url + 'products/delete/' + id;
    var is_confirm = confirm("Are you sure you want to delete this products?");
    if (is_confirm) {
        $.get(myurl, function (sts) {
            if (sts == 'done')
                $("#row_" + id).fadeOut();
            else
                alert('OOps! Something went wrong.');
        });
    }
}
function remove_products_image(id) {
    var myurl = base_url + 'products/remove_products_feature_image/' + id;
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
//=======Ends products Module=======