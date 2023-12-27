<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
<link href="{{ asset_storage('back/jquery-ui/jquery-ui.min.css') }}" rel="stylesheet" type="text/css" />
<link href="{{ asset_storage('back/datetimepicker/build/jquery.datetimepicker.min.css') }}" rel="stylesheet" type="text/css" />
<link href="{{ asset_storage('module/videos/admin/css/videos.css') }}" rel="stylesheet" type="text/css" />
<link href="{{ asset_storage('module/products/admin/css/products.css') }}" rel="stylesheet" type="text/css" />
<link href="{{ asset_storage('module/menu/admin/css/menu.css') }}" rel="stylesheet" type="text/css" />
<link href="{{ asset_storage('module/module/admin/css/module.css') }}" rel="stylesheet" type="text/css" />
<link href="{{ asset_storage('back/bootstrap/css/bootstrap-reboot.min.css') }}" rel="stylesheet" type="text/css" />
<link href="{{ asset_storage('back/bootstrap/css/bootstrap-grid.min.css') }}" rel="stylesheet" type="text/css" />
<link href="{{ asset_storage('back/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet" type="text/css" />
<link href="{{ asset_storage('fontawesome/css/all.min.css') }}" rel="stylesheet" type="text/css" />
<link href="{{ asset_storage('back/css/ionicons.min.css') }}" rel="stylesheet" type="text/css" />
<link href="{{ asset_storage('back/css/datatables/dataTables.bootstrap.css') }}" rel="stylesheet" type="text/css" />
<link href="{{ asset_storage('back/css/datatables/jquery.dataTables.css') }}" rel="stylesheet" type="text/css" />
<link rel="stylesheet" href="{{ asset_storage('module/module/admin/filer/css/jquery.filer.css') }}">
<link href="{{ asset_storage('select2/css/select2.min.css') }}" rel="stylesheet" type="text/css" />
<link href="{{ asset_storage('back/js/AdminLTE/dist/css/adminlte.min.css') }}" rel="stylesheet" type="text/css" />
<link href="{{ asset_storage('back/fontawesome-iconpicker/dist/css/fontawesome-iconpicker.min.css') }}" rel="stylesheet"
    type="text/css" />
<link href="{{ asset_storage('before-effect-slider/before-effect-slider.css') }}" rel="stylesheet" type="text/css" />
<link href="{{ asset_storage('lib/sweetalert/sweetalert2.min.css') }}" rel="stylesheet" />
<link href="{{ asset_storage('back/css/admin_dev_style.css') }}" rel="stylesheet" type="text/css" />
<script>
    var base_url = '{{ base_url() }}';
    var base_url_admin = '{{ config('Constants.base_url_admin') }}';
    var base_admin_image = '{{ asset_storage('') . 'back/images/' }}';
    var asset_uploads = '{{ asset_uploads('') }}';
    var uploadTinyMceImage = '{{ route('uploadTinyMceImage') }}';
    var csrf_token = '{{ csrf_token() }}';
    var tinymce_front_css_file = ['{{ config('livewire_update_endpoint') }}mlstorage/front/css/style.css', '{{ config('livewire_update_endpoint') }}mlstorage/front/css/custom_style.css'];
</script>