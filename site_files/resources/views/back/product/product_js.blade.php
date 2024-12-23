<script type="text/javascript">
    var save_method; //for save method string
    var table;

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
        set_seo_limit_suggestions();
    }

    function edit_product(id) {
        $('.spinner').show();
        reset_model();
        save_method = 'update';
        $.ajax({
            url: " {{ admin_url() }}products/" + id + "/edit/",
            type: "GET",
            success: function(data) {
                data = JSON.parse(data);
                $('[name="id"]').val(data.id);
                $('[name="product_name"]').val(data.product_name);
                $('[name="product_slug"]').val(data.product_slug);
                $('[name="product_description"]').val(data.product_description);
                $('[name="price"]').val(data.price);
                fillSeoFields(data);
                if (data.product_img != '') {
                    $('#product_img_div').show();
                    $('#product_img_div').html('<img style="width:100px" src="' + asset_uploads +
                        '/products/' + data.product_img +
                        '"><i onclick="remove_products_image(0);" class="deleteIcon"></i>');
                } else {
                    $('#product_img_div').hide();
                }
                $('[name="product_img_title"]').val(data.product_img_title);
                $('[name="product_img_alt"]').val(data.product_img_alt);

                $('.spinner').hide();
                $('#modal_form').modal('show'); // show bootstrap modal when complete loaded
                $('.modal-title').text('Edit Product'); // Set title to Bootstrap modal title
            },
            error: function(jqXHR, textStatus, errorThrown) {
                alert('Error get data from ajax');
                console.log(jqXHR);
                console.log(textStatus);
                console.log(errorThrown);
            }
        });
    }

    function save() {
        let url;
        if (save_method === 'add') {
            url = "{{ base_url() . 'adminmedia/products' }}";
            method = 'POST';
            header = '';
        } else {
            id = $('[name="id"]').val();
            url = "{{ base_url() . 'adminmedia/products/' }}" + id;
            console.log(id);
            console.log(url);
            method = 'POST';
            header = {
                "X-HTTP-Method-Override": "PUT"
            };
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
            success: function(data) {
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
            error: function(jqXHR, textStatus, errorThrown) {
                alert('Error adding / update data ' + ' ' + textStatus + ' ' + errorThrown);
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
                url: "{{ admin_url() . 'products/' }}" + id,
                type: "DELETE",
                success: function(data) {
                    //if success reload ajax table
                    location.reload();
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    alert('Error adding / update data ' + ' ' + textStatus + ' ' + errorThrown);
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
                success: function(data) {
                    $('#product_img_div').hide();
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    alert('Error adding / update data ' + ' ' + textStatus + ' ' + errorThrown);
                }
            });
        }
    }
    $(function() {
        $('#sortable').sortable({
            axis: 'y',
            opacity: 0.7,
            handle: 'span',
            update: function(event, ui) {
                var list_sortable = $(this).sortable('toArray').toString();
                // change order in the database using Ajax
                console.log(list_sortable);
                $.ajax({
                    url: base_url + 'adminmedia/products/create',
                    type: 'GET',
                    data: {
                        list_order: list_sortable
                    },
                    success: function(data) {
                        //finished
                        console.log(data);
                    },
                    error: function(jqXHR, textStatus, errorThrown) {
                        alert('Error adding / update data ' + ' ' + textStatus + ' ' +
                            errorThrown);
                        console.log(jqXHR);
                        console.log(textStatus);
                        console.log(errorThrown);
                    }
                });
            }
        }); // fin sortable
    });

    function update_product_sts_toggle(id) {
        var current_status = 'notset';
        var myurl = base_url + 'adminmedia/products/' + id + '?status=' + current_status;
        $.get(myurl, function(sts) {
            alertme('<i class="fas fa-check" aria-hidden="true"></i> Done Successfully ',
                'success', true, 1500);
        });
    }

    function showProductRecordUpdateHistory() {
        let id = $('#product_id').val();
        window.location.href = base_url + 'adminmedia/record-update-history/Product/' + id;
    }
    $(document).ready(function() {
        @if (request()->input('id', 0) > 0)
            edit_product({{ request()->input('id', 0) }});
        @endif
    });
</script>
