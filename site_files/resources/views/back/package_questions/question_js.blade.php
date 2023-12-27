<script type="text/javascript">
    var save_method; //for save method string
    var table;

    function string_to_product_slug(titleId, slugId) {
        var str = $('[name="' + titleId + '"]').val();
        var eventSlug = $('[name="' + slugId + '"]').val();
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
            $('[name="' + slugId + '"]').val(str);
        }
    }

    function reset_model() {
        $('#form')[0].reset(); // reset form on modals
        $('.err').html('');
        $('.message-container').fadeOut(3000);
        $('#product_img_div').hide();
        // $('#modal_form').modal('show'); // show bootstrap modal
        $('#seo-edit-modul').removeClass('seo-edit-modul-sow').addClass('seo-edit-modul-hide');
    }
    function add_product() {
        reset_model();
        save_method = 'add';
        $('#modal_form').modal('show'); // show bootstrap modal
        $('.modal-title').text('Add Product'); // Set Title to Bootstrap modal title
    }
    function edit_product(id) {
        $('.spinner').show();
        reset_model();
        save_method = 'update';
        $.ajax({
            url: " {{admin_url()}}products/" + id + "/edit/",
            type: "GET",
            success: function (data) {
                data = JSON.parse(data);
                $('[name="id"]').val(data.ID);
                $('[name="product_name"]').val(data.product_name);
                $('[name="product_slug"]').val(data.product_slug);
                $('[name="product_description"]').val(data.product_description);
                $('[name="price"]').val(data.price);
                $('[name="meta_title"]').val(data.meta_title);
                $('[name="meta_keywords"]').val(data.meta_keywords);
                $('[name="meta_description"]').val(data.meta_description);
                if (data.product_img != '') {
                    $('#product_img_div').show();
                    $('#product_img_div').html('<img style="width:100px" src="'+asset_uploads + '/products/' + data.product_img+'"><i onclick="remove_products_image(0);" class="deleteIcon"></i>');
                }
                else {
                    $('#product_img_div').hide();
                }
                $('.spinner').hide();
                $('#modal_form').modal('show'); // show bootstrap modal when complete loaded
                $('.modal-title').text('Edit Product'); // Set title to Bootstrap modal title
            },
            error: function (jqXHR, textStatus, errorThrown) {
                alert('Error get data from ajax');
                console.log(jqXHR);
                console.log(textStatus);
                console.log(errorThrown);
            }
        });
    }
    function reload_table() {
        table.ajax.reload(null, false); //reload datatable ajax
    }
    function save() {
        let url;
        if (save_method === 'add') {
            url = "{{ env("APP_URL") . 'adminmedia/products' }}";
            method = 'POST';
            header = '';
        }
        else {
            id = $('[name="id"]').val();
            url = "{{env("APP_URL") . 'adminmedia/products/'}}" + id;
            console.log(id);
            console.log(url);
            method = 'POST';
            header = {"X-HTTP-Method-Override": "PUT"};
        }
        let formData = new FormData($('#form')[0]);
        console.log(formData);
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $.ajax({
            url: url,
            type: method,
            data: formData,
            // dataType: "JSON",
            headers: header,
            async: true,
            cache: false,
            contentType: false,
            processData: false,
            success: function (data) {
                console.log(data);
                data = JSON.parse(data);
                if (data.status) {
                    $('#modal_form').modal('hide');
                    location.reload();
                } else {
                    $('.error-div').html('');
                    $('.error-div').show();
                    $('.error-div').html(data.errors);
                    // $('#product_name').html('Validation Error, ' + data.errors)[0];
                }
            },
            error: function (jqXHR, textStatus, errorThrown) {
                alert('Error adding / update data');
                console.log(jqXHR);
                console.log(textStatus);
                console.log(errorThrown);
            }
        });
    }
    function delete_product(id) {
        $('.message-container').fadeOut(3000);
        if (confirm('Are you sure delete this data?')) {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                url: "{{base_url() . 'adminmedia/question/'}}" + id,
                type: "DELETE",
                success: function (data) {
                    //if success reload ajax table
                    location.reload();
                },
                error: function (jqXHR, textStatus, errorThrown) {
                    alert('Error adding / update data');
                }
            });
        }
    }
    function remove_products_image(id) {
        if (confirm("Are you sure you want to delete this Product Image?")) {
            // ajax delete data to database
            $.ajax({
                url: "products/ajax_remove_feature_image/" + id,
                type: "POST",
                dataType: "JSON",
                success: function (data) {
                    $('#product_img_div').hide();
                },
                error: function (jqXHR, textStatus, errorThrown) {
                    alert('Error adding / update data');
                }
            });
        }
    }
    $(function () {
        $('#sortable').sortable({
            axis: 'y',
            opacity: 0.7,
            handle: 'span',
            update: function (event, ui) {
                var list_sortable = $(this).sortable('toArray').toString();
                // change order in the database using Ajax
                console.log(list_sortable);
                $.ajax({
                    url: base_url + 'adminmedia/question/create',
                    type: 'GET',
                    data: {list_order: list_sortable},
                    success: function (data) {
                        //finished
                        console.log(data);
                    },
                    error: function (jqXHR, textStatus, errorThrown) {
                        alert('Error adding / update data');
                        console.log(jqXHR);
                        console.log(textStatus);
                        console.log(errorThrown);
                    }
                });
            }
        }); // fin sortable
    });
    function update_package_question_sts_toggle(id) {
        var current_status = 'notset';
        console.log(current_status);
        var myurl = base_url + 'adminmedia/question/' + id + '?status=' + current_status;
        $.get(myurl, function (sts) {
            alertme('<i class="fas fa-check" aria-hidden="true"></i> Done Successfully ',
                        'success', true, 1500);
        });
    }
</script>