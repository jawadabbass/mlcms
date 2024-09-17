<script type="text/javascript">
    var save_method; //for save method string
    var table;
    $(document).ready(function() {
        $('#is_external_link').on('click', function(index) {
            if ($(this).is(':checked') == true) {
                $('#base_url_id').hide();
                $('#base_url_id').parent().removeClass('mb-2');
            } else {
                $('#base_url_id').show();
                $('#base_url_id').parent().addClass('mb-2');
            }
        });
    });

    function reset_model(save_method) {
        // alert('fdsfs');
        $('#form')[0].reset(); // reset form on modals
        $('.err').html('');
        $('.message-container').fadeOut(3000);
        if (save_method == 'add') {
            $('#hide_fileds').show();
            $('#hide_types').show();
        }
        if (save_method == 'update') {
            $('#hide_fileds').hide();
        }
        $('#modal_form').modal('show'); // show bootstrap modal
        $('#seo-edit-modul').removeClass('seo-edit-modul-sow').addClass('seo-edit-modul-hide');
    }

    function add_menu() {
        save_method = 'add';
        reset_model(save_method);
        $('.modal-title').text('Add Menu');
        positions = "{{ $position }}";
        if (positions === "top") {
            $('#header_menu').prop('checked', true);
        }
        if (positions === "footer") {
            $('#footer_menu').prop('checked', true);
        }
    }

    function edit_menu(menu_id, id) {
        save_method = 'update';
        $("#hide_types").hide();
        // reset_model(save_method);
        //$('#header_menu').prop('checked', false);
        //$('#footer_menu').prop('checked', false);
        //Ajax Load data from ajax
        $.ajax({
            url: "{{ base_url() }}adminmedia/menus/" + id + "/edit",
            type: "GET",
            dataType: "JSON",
            success: function(data) {
                if (data.menu_id != 0) {
                    $("#hide_fileds").hide();
                } else {
                    $("#hide_fileds").show();
                }
                $('[name="id"]').val(data.menu_id);
                $('[name="menu_actual_id"]').val(data.id);
                $('[name="menu_label"]').val(data.menu_label);
                $('[name="menu_url"]').val(data.menu_url);
                if (data.open_in_new_window == 'yes') {
                    $('#open_in_new_window').prop('checked', true);
                } else {
                    $('#open_in_new_window').prop('checked', false);
                }
                if (data.show_no_follow == '1') {
                    $('#show_no_follow').prop('checked', true);
                } else {
                    $('#show_no_follow').prop('checked', false);
                }
                if (data.is_external_link == 'Y') {
                    $('#is_external_link').prop('checked', true);
                    $('#base_url_id').hide();
                } else {
                    $('#is_external_link').prop('checked', false);
                    $('#base_url_id').show();
                }
                $('#modal_form').modal('show'); // show bootstrap modal when complete loaded
                $('.modal-title').text('Edit Menu'); // Set title to Bootstrap modal title
            },
            error: function(jqXHR, textStatus, errorThrown) {
                alert('Error get data from ajax');
            }
        });
    }

    function save() {
        var url;
        if (save_method == 'add') {
            url = "{{ base_url() . 'adminmedia/menus' }}";
            method = 'POST';
            header = '';
        } else {
            id = $('[name="menu_actual_id"]').val();
            url = "{{ base_url() . 'adminmedia/menus/' }}" + id;
            console.log(id);
            console.log(url);
            method = 'POST';
            header = {
                "X-HTTP-Method-Override": "PUT"
            };
        }
        var formData = new FormData($('#form')[0]);
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
            dataType: "JSON",
            headers: header,
            async: true,
            cache: false,
            contentType: false,
            processData: false,
            success: function(data) {
                console.log(data);
                if (data.status == true) {
                    //if success close modal and reload ajax table
                    $('#modal_form').modal('hide');
                    location.reload();
                } else // validation errors
                {
                    $('.err').html('');
                    $.each(data.errors, function(key, value) {
                        key = key.replace("[]", "");
                        $('#' + key).html(value);
                    });
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

    function delete_menu(id) {
        $('.message-container').fadeOut(3000);
        var top_foot = "{{ $position }}";
        var mess_alert = '';
        mess_alert = 'Are you sure you want to remove link from ' + top_foot + ' Section?';
        if (confirm(mess_alert)) {
            // ajax delete data to database
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                url: "{{ admin_url() . 'menus' }}/" + id,
                type: "DELETE",
                dataType: "JSON",
                success: function(data) {
                    //if success reload ajax table
                    $('#modal_form').modal('hide');
                    $('#item_' + id).hide();
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
                url: "{{ base_url() }}menu/ajax_remove_feature_image/" + id,
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
</script>
