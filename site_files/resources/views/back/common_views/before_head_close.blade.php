<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
<link href="{{ public_path_to_storage('back/jquery-ui/jquery-ui.min.css') }}" rel="stylesheet" type="text/css" />
<link href="{{ public_path_to_storage('back/datetimepicker/build/jquery.datetimepicker.min.css') }}" rel="stylesheet" type="text/css" />
<link href="{{ public_path_to_storage('module/videos/admin/css/videos.css') }}" rel="stylesheet" type="text/css" />
<link href="{{ public_path_to_storage('module/products/admin/css/products.css') }}" rel="stylesheet" type="text/css" />
<link href="{{ public_path_to_storage('module/menu/admin/css/menu.css') }}" rel="stylesheet" type="text/css" />
<link href="{{ public_path_to_storage('module/module/admin/css/module.css') }}" rel="stylesheet" type="text/css" />
<link href="{{ public_path_to_storage('back/bootstrap/css/bootstrap-reboot.min.css') }}" rel="stylesheet" type="text/css" />
<link href="{{ public_path_to_storage('back/bootstrap/css/bootstrap-grid.min.css') }}" rel="stylesheet" type="text/css" />
<link href="{{ public_path_to_storage('back/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet" type="text/css" />
<link href="{{ public_path_to_storage('back/fontawesome/css/all.min.css') }}" rel="stylesheet" type="text/css" />
<link href="{{ public_path_to_storage('back/css/ionicons.min.css') }}" rel="stylesheet" type="text/css" />
<link href="{{ public_path_to_storage('back/css/datatables/dataTables.bootstrap.css') }}" rel="stylesheet" type="text/css" />
<link href="{{ public_path_to_storage('back/css/datatables/jquery.dataTables.css') }}" rel="stylesheet" type="text/css" />
<link rel="stylesheet" href="{{ public_path_to_storage('module/module/admin/filer/css/jquery.filer.css') }}">
<link href="{{ public_path_to_storage('select2/css/select2.min.css') }}" rel="stylesheet" type="text/css" />
<link href="{{ public_path_to_storage('back/js/AdminLTE/dist/css/adminlte.min.css') }}" rel="stylesheet" type="text/css" />
<link href="{{ public_path_to_storage('back/fontawesome-iconpicker/dist/css/fontawesome-iconpicker.min.css') }}" rel="stylesheet"
    type="text/css" />
<link href="{{ public_path_to_storage('back/css/admin_dev_style.css') }}" rel="stylesheet" type="text/css" />
<script>
    var base_url = '{{ base_url() }}';
    var base_url_main = '{{ base_url() }}';
    var base_url_admin = '{{ config('Constants.base_url_admin') }}';
    var base_admin_image = '{{ public_path_to_storage('') . 'back/images/' }}';
    var baseUrl = '{{ base_url() }}';
    var public_path_to_uploads = '{{ public_path_to_uploads('') }}';
</script>
<style>
    .ck-editor__editable[role="textbox"] {
        min-height: 200px;
    }

    .ck-content .image {
        max-width: 80%;
        margin: 20px auto;
    }
</style>
