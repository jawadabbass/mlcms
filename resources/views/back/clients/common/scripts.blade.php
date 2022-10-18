<script>


    $("#send_to_client_id").change(function() {
        
    var ischecked= $(this).is(':checked');
    if(ischecked)
    {
    $("#client_packages_id").show();    
        
    }
    else{
        $("#client_packages_id").hide();
        
    }
   
    }); 



    function send_template_email(id, type, value) {
        var tempalte_id = $("#template_id").val();

        if (value == 'combine') {

            $("#combine_send").show();
        }
        else{

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
                CKEDITOR.instances['user_body'].setData(result.user_body);

            },
        });

    }

    $("#template_id").on('change', function() {
        var tempalte_id = $("#template_id").val();
        $("#subject").val('');
        CKEDITOR.instances['user_body'].setData('');

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
                CKEDITOR.instances['user_body'].setData(result.user_body);

            },
        });


    });

    function save_email_record_send() {
        var my_editor_id = 'user_body';
        var content = CKEDITOR.instances[my_editor_id].getData();
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

                } 
                else if(data.val_error)
                {
              swal(
                        'Sorry!',
                        'Please Check Package For Clients',
                        'error'
                    );        
                    
                    
                }else {
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
<script type="text/javascript">
    CKEDITOR.replace('user_body');

    function insertIntoCkeditor(str) {
        CKEDITOR.instances['user_body'].insertText(str);
    }

    function insertIntoTextArea(str) {
        // $("#Body").val($("#Body").val()+str);
        insertAtCaret('Body', str);
    }

    function insertAtCaret(areaId, text) {
        var txtarea = document.getElementById(areaId);
        var scrollPos = txtarea.scrollTop;
        var strPos = 0;
        var br = ((txtarea.selectionStart || txtarea.selectionStart == '0') ?
            "ff" : (document.selection ? "ie" : false));
        if (br == "ie") {
            txtarea.focus();
            var range = document.selection.createRange();
            range.moveStart('character', -txtarea.value.length);
            strPos = range.text.length;
        } else if (br == "ff") strPos = txtarea.selectionStart;

        var front = (txtarea.value).substring(0, strPos);
        var back = (txtarea.value).substring(strPos, txtarea.value.length);
        txtarea.value = front + text + back;
        strPos = strPos + text.length;
        if (br == "ie") {
            txtarea.focus();
            var range = document.selection.createRange();
            range.moveStart('character', -txtarea.value.length);
            range.moveStart('character', strPos);
            range.moveEnd('character', 0);
            range.select();
        } else if (br == "ff") {
            txtarea.selectionStart = strPos;
            txtarea.selectionEnd = strPos;
            txtarea.focus();
        }
        txtarea.scrollTop = scrollPos;
    }
</script>
