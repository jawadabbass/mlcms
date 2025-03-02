<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1,user-scalable=no">
    <title>File Manager</title>
    <style type="text/css">
        .ui-title {
            display: none !important;
        }

        .ui-icon-ckf-file-delete {
            display: none !important;
        }
    </style>
</head>

<body>
    <script src="{{ asset_storage('') }}back/js/plugins/editor/ckfinder/ckfinder.js"></script>
    <script>
        CKFinder.start();
    </script>
    <script src="https://code.jquery.com/jquery-1.12.4.min.js"></script>
    <script>
        setInterval(function() {
            hide_demo();
        }, 5000);

        function hide_demo() {
            $('.ui-popup').find('span').each(function(index) {
                if ($(this).text() == 'This is a demo version of CKFinder 3') {
                    $('.ui-popup').find("[data-ckf-button='okClose']").trigger('click');
                }
            });
        }
    </script>
</body>

</html>
