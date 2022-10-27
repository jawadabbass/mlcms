<script src="{{ base_url() . 'back/js/jquery.min.js' }}"></script>
<script src="{{ base_url() . 'back/jquery-ui/jquery-ui.min.js' }}"></script>
<script src="{{ base_url() . 'back/bootstrap/js/bootstrap.bundle.min.js' }}"></script>

<script type="text/javascript" src="{{ base_url() . 'back/js/js/effects.js' }}"></script>
<script type="text/javascript" src="{{ base_url() . 'back/js/js/popupjs.js' }}"></script>
<script type="text/javascript" src="{{ base_url() . 'back/js/js/get_auto.js' }}"></script>

<script src="{{ base_url() . 'back/fontawesome-iconpicker/dist/js/fontawesome-iconpicker.min.js' }}"></script>
<script src="{{ base_url() . 'back/js/plugins/timepicker/bootstrap-timepicker.min.js' }}" type="text/javascript">
</script>

<script src="{{ base_url() . 'back/js/functions.js' }}" type="text/javascript"></script>
<script type="text/javascript" src="{{ base_url() . 'back/js/plugins/datatables/jquery.dataTables.js' }}"></script>
<script src="{{ base_url() . 'module/module/admin/filer/js/jquery.filer.min.js' }}"></script>
<script src="{{ asset('back/js/plugins/editor/ckeditor/ckeditor.js') }}" type="text/javascript"></script>
<script src="{{ base_url() . 'back/js/admin_functions.js?v=22' }}" type="text/javascript"></script>

<script src="{{ asset('select2/js/select2.full.min.js') }}" type="text/javascript"></script>
<script src="{{ asset('back/datetimepicker/build/jquery.datetimepicker.full.min.js') }}" type="text/javascript"></script>
@include('back.common_views.common_state_county_city_functions')


<script>
    $('#selected_image').on('change', function(event) {
        var selected_image_preview = document.getElementById('selected_image_preview');
        selected_image_preview.src = URL.createObjectURL(event.target.files[0]);
    });

    $('#selected_layout_image').on('change', function(event) {
        var selected_layout_image_preview = document.getElementById('selected_layout_image_preview');
        selected_layout_image_preview.src = URL.createObjectURL(event.target.files[0]);
    });

    $('#selected_images').on('change', function(event) {
        $('#selected_images_preview').html('');
        for (let index = 0; index < event.target.files.length; index++) {
            const src = URL.createObjectURL(event.target.files[index]);
            $('#selected_images_preview').append('<div class="col-2 m-1"><img style="border-radius: 0px;" src="' + src +
                '" /></div>');
        }
    });

    function loadStorage() {
        console.log("Load Getting Executed");
        var preference = localStorage.getItem('collapsed');
        if (1 == preference) {
            $('.left-side').toggleClass("collapse-left");
            $(".right-side").toggleClass("strech");
        }
    }
</script>
<script>
    $(function() {
        $('.icp-auto').on('click', function() {
            $('.icp-auto').iconpicker();
        }).trigger('click');
    });

    $(function() {
        $('.iconpicker-item').on('click', function() {
            //alert("test" );
            $('.iconpicker-popover').hide();
        });
    });
</script>
<script>
    $(document).on('focusin', function(e) {
        if ($(e.target).closest(".mce-window").length) {
            e.stopImmediatePropagation();
        }
    });
    /* 
        $(document).ready(function() {
            // this code is for CKEditor which is open in model and some fields are disabled so it will allow to fields enabled.
            $.fn.modal.Constructor.prototype.enforceFocus = function() {
                modal_this = this
                $(document).on('focusin.modal', function(e) {
                    if (modal_this.$element[0] !== e.target && !modal_this.$element.has(e.target).length
                        // add whatever conditions you need here:
                        &&
                        !$(e.target.parentNode).hasClass('cke_dialog_ui_input_select') && !$(e.target
                            .parentNode).hasClass('cke_dialog_ui_input_text')) {
                        modal_this.$element.focus()
                    }
                })
            };
        });
         */
    $(document).ready(function() {
        $('.img_alt_title_label').on('click', function(e) {
            $(this).siblings('div').toggle();
        });
    });
</script>
<script type="text/javascript">
    $(function() {

        if ($('#edit_editor1').length) {
            CKEDITOR.replace('edit_editor1');
        }

        if ($('#editor1').length) {
            CKEDITOR.replace('editor1');
            CKEDITOR.config.allowedContent = true;
            CKEDITOR.config.autoParagraph = false;
        }

        if ($('#user_body').length) {
            CKEDITOR.replace('user_body');
        }

        if ($('#details').length) {
            CKEDITOR.replace('details');
        }

        if ($('#web_down_msg').length) {
            CKEDITOR.replace('web_down_msg');
            CKEDITOR.config.allowedContent = true;
            CKEDITOR.config.autoParagraph = false;
            CKEDITOR.config.width = '100%';
            CKEDITOR.config.height = 500;
        }

    });
</script>
