<script type="text/javascript">
    function media_insert_img(url) {
        CKEDITOR.instances["editor1"].insertHtml('<img src="/' + url + '" alt="">');
        $("#media_image").modal('hide');
    }

    function media_insert_portfolio(url) {
        $("#edit_portfolio_img").show();
        $("#edit_portfolio_img").attr("src", '/' + url);
        $("#additional_field_2").val('/' + url);
        $("#media_image_addition").modal('hide');
    }

    function media_insert_file(url) {
        // CKEDITOR.instances["editor1"].insertHtml('<a target="_blank" href="{{ base_url() }}'+url+'">File</a>');
        $("#file_c_url").val(url);
        $("#media_files").modal('hide');
        $("#modal_file_link_text").modal('show');
    }

    function insert_media_file_html() {
        var url = $("#file_c_url").val();
        var linktxt = $("#link_on_text").val();
        CKEDITOR.instances["editor1"].insertHtml('<a target="_blank" href="{{ base_url() }}' + url + '">' + linktxt +
            '</a>');
        $("#modal_file_link_text").modal('hide');
    }

    function show_section(idd, objj) {
        $(".fldbtns").removeClass('active');
        $(objj).addClass('active');
        $(".mystr").parent('.mediaup').hide();
        $(".section_" + idd).parent('.mediaup').show();
    }
</script>
