<script>
    $("#send_to_client_id").change(function() {

        var ischecked = $(this).is(':checked');
        if (ischecked) {
            $("#client_packages_id").show();

        } else {
            $("#client_packages_id").hide();

        }

    });



    function send_template_email(id, type, value) {
        var tempalte_id = $("#template_id").val();

        if (value == 'combine') {

            $("#combine_send").show();
        } else {

            $("#combine_send").hide();
        }

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $.ajax({
            type: "get",

            url: "{{ route('client_email_templates', '') }}" + "/" + tempalte_id,
            data: {
                '_token': $('meta[name="csrf-token"]').attr('content')
            },
            success: function(data) {

                var result = JSON.parse(data);
                $("#receiver_user_id").val(id);
                $("#receiver_type").val(type);
                $("#value_send").val(value);
                $("#sendEmailTemplate").modal('show');
                $("#subject").val(result.Subject);
                tinyMCE.get('user_body').setContent(result.user_body);

            },
        });

    }

    $("#template_id").on('change', function() {
        var tempalte_id = $("#template_id").val();
        $("#subject").val('');
        tinyMCE.get('user_body').setContent('');

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $.ajax({
            type: "get",
            url: "{{ route('client_email_templates', '') }}" + "/" + tempalte_id,
            data: {
                '_token': $('meta[name="csrf-token"]').attr('content')
            },
            success: function(data) {

                var result = JSON.parse(data);

                $("#subject").val(result.Subject);
                tinyMCE.get('user_body').setContent(result.user_body);

            },
        });


    });

    function save_email_record_send() {
        var content = tinyMCE.get('user_body').getContent();
        $('#user_body').val(content);
        $('#btnSave').css('display', 'none');
        $('#loader').css('display', 'block');
        url = "{{ route('send_email_template_client') }}";
        method = 'POST';
        header = '';
        let formData = new FormData($('#emailTemplateForm')[0]);
        // console.log(formData);


        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $.ajax({
            url: url,
            type: method,
            data: formData,
            headers: header,
            async: true,
            cache: false,
            contentType: false,
            processData: false,
            success: function(data) {
                console.log(data);
                data = JSON.parse(data);
                $('#btnSave').css('display', 'block');
                $('#loader').css('display', 'none');
                if (data.status) {
                    $("#emailTemplateForm").trigger('reset');
                    $("#sendEmailTemplate").modal('hide');

                    swal(
                        'Thank you!',
                        'Your Email Has Been Sent.',
                        'success'
                    );
                    location.reload();

                } else if (data.val_error) {
                    swal(
                        'Sorry!',
                        'Please Check Package For Clients',
                        'error'
                    );


                } else {
                    swal(
                        'Sorry!',
                        'Please Check Clients Or Leads Option',
                        'error'
                    );
                    // $('#msgSuccess').text(data.error);
                }
            },
            error: function(jqXHR, textStatus, errorThrown) {
                alert('Error sending your request');
                console.log(jqXHR);
                console.log(textStatus);
                console.log(errorThrown);
            }
        });

    }
</script>
