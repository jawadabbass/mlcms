<script type="text/javascript" src="<?php echo base_url('../public/js/admin/plugins/tinymce/js/tinymce/tinymce.min.js'); ?>"></script>
<script>
    $(function() {
        tinyMCE.init({
                selector: '#editor1',
                plugins: ["advlist autolink lists link image charmap print preview anchor",
                    "searchreplace visualblocks code fullscreen",
                    "insertdatetime media table contextmenu paste jbimages", "link image"
                ],
                toolbar: "insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link | image",
                file_browser_callback: RoxyFileBrowser
            }

        );
        tinyMCE.init({
                selector: '#edit_editor1',
                plugins: ["advlist autolink lists link image charmap print preview anchor",
                    "searchreplace visualblocks code fullscreen",
                    "insertdatetime media table contextmenu paste jbimages", "link image"
                ],
                toolbar: "insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link | image",
                file_browser_callback: RoxyFileBrowser
            }

        );
    });

    function RoxyFileBrowser(field_name, url, type, win) {
        var roxyFileman = '<?php echo str_replace(base_url_admin . '/', '', base_url()); ?>public/userfile/index.html';
        if (roxyFileman.indexOf("?") < 0) {
            roxyFileman += "?type=" + type;
        } else {
            roxyFileman += "&type=" + type;
        }
        roxyFileman += '&input=' + field_name + '&value=' + win.document.getElementById(field_name).value;
        if (tinyMCE.activeEditor.settings.language) {
            roxyFileman += '&langCode=' + tinyMCE.activeEditor.settings.language;
        }
        tinyMCE.activeEditor.windowManager.open({
            file: roxyFileman,
            title: 'File Manager',
            width: 850,
            height: 650,
            resizable: "yes",
            plugins: "media",
            inline: "no",
            close_previous: "no"
        }, {
            window: win,
            input: field_name
        });
        return false;
    }
</script>
