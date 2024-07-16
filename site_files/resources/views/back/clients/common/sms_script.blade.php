<script>


    $("#sms_send_to_client_id").change(function() {
        
    var ischecked= $(this).is(':checked');
    if(ischecked)
    {
    $("#sms_client_packages_id").show();    
        
    }
    else{
        $("#sms_client_packages_id").hide();
        
    }
   
    }); 
    function send_template_sms(id, type, value) {


        var tempalte_id = $("#sms_template_id").val();

        if (value == 'combine') {

            $("#sms_combine_send").show();
        }
        else{

            $("#sms_combine_send").hide();
        }

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $.ajax({
            type: "get",

            url: "{{ route('client_sms_templates', '') }}" + "/" + tempalte_id,
            data: {
                '_token': $('meta[name="csrf-token"]').attr('content')
            },
            success: function(data) {

                var result = JSON.parse(data);
                $("#sms_receiver_user_id").val(id);
                $("#sms_receiver_type").val(type);
                $("#sms_value_send").val(value);
                $("#SMS_Template_model").modal('show');
                $("#sms_subject").val(result.title);
                $("#sms_user_body").val(result.body);

            },
        });

    }

    $("#sms_template_id").on('change', function() {
        var tempalte_id = $("#sms_template_id").val();

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $.ajax({
            type: "get",
            url: "{{ route('client_sms_templates', '') }}" + "/" + tempalte_id,
            data: {
                '_token': $('meta[name="csrf-token"]').attr('content')
            },
            success: function(data) {

                var result = JSON.parse(data);

                $("#sms_subject").val(result.title);
                $("#sms_user_body").val(result.body);

            },
        });
    });

    function save_sms_record_send() {

        $('#btnSave').css('display', 'none');
        $('#loader').css('display', 'block');
        url = "{{ route('send_sms_template_client') }}";
        method = 'POST';
        header = '';
        let formData = new FormData($('#smsTemplateForm')[0]);
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
                if (data.status == 200) {
                    $("#smsTemplateForm").trigger('reset');
                    $("#SMS_Template_model").modal('hide');

                    swal(
                        'Thank you!',
                        data.message,
                        'success'
                    );
                    location.reload();
                } else {
                    swal(
                        'Sorry!',
                        data.message,
                        'error'
                    );
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
