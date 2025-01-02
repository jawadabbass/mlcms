<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
<link href="{{ asset_storage('back/jquery-ui/jquery-ui.min.css') }}" rel="stylesheet" type="text/css" />
<link href="{{ asset_storage('back/datetimepicker/build/jquery.datetimepicker.min.css') }}" rel="stylesheet"
    type="text/css" />
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
<link href="{{ asset_storage('back/fontawesome-iconpicker/dist/css/fontawesome-iconpicker.min.css') }}"
    rel="stylesheet" type="text/css" />
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/img-comparison-slider@8/dist/styles.css" />
<link href="{{ asset_storage('lib/sweetalert/sweetalert2.min.css') }}" rel="stylesheet" />
<link href="{{ asset_storage('back/toggle_switch/bootstrap5-toggle.min.css') }}" rel="stylesheet" />
<link href="{{ asset_storage('back/css/icheck-bootstrap.min.css') }}" rel="stylesheet" />
<link href="{{ asset_storage('module/settings/admin/css/settings.css') }}" rel="stylesheet" type="text/css" />
<link href="{{ asset_storage('back/css/magicsuggest.css') }}" rel="stylesheet" type="text/css" />
<link href="{{ asset_storage('module/settings/admin/css/setting.css') }}" rel="stylesheet" type="text/css" />
<link href="{{ asset_storage('back/css/admin_dev_style.css') }}" rel="stylesheet" type="text/css" />
<style>
    #sortable tr td span {
        background-color: unset;
        background-image: url({{ asset_storage('back/images/drag.png') }});
        background-repeat: no-repeat;
        background-position: center;
        width: 30px;
        height: 38px;
        display: inline-block;
        float: none;
        cursor: move;
    }
</style>
<style>
    .before,
    .after {
        margin: 0;
    }

    .before figcaption,
    .after figcaption {
        background: #fff;
        border: 1px solid #c0c0c0;
        border-radius: 12px;
        color: #2e3452;
        opacity: 0.8;
        padding: 12px;
        position: absolute;
        top: 50%;
        transform: translateY(-50%);
        line-height: 100%;
    }

    .before figcaption {
        left: 12px;
    }

    .after figcaption {
        right: 12px;
    }

    img-comparison-slider {
        --divider-width: 4px;
        --divider-color: #ffffff;
        --default-handle-opacity: 1;
        --default-handle-width: 150px;
        --default-handle-shadow: 2px 4px 6px #000;
    }
</style>
<script>
    var base_url = '{{ base_url() }}';
    var base_url_admin = '{{ config('Constants.base_url_admin') }}';
    var base_admin_image = '{{ asset_storage('') . 'back/images/' }}';
    var asset_uploads = '{{ asset_uploads('') }}';
    var uploadTinyMceImage = '{{ route('uploadTinyMceImage') }}';
    var csrf_token = '{{ csrf_token() }}';
    var tinymce_front_css_file = ["{{ asset_storage('front/css/style.css') }}",
        "{{ asset_storage('front/css/custom_style.css') }}"
    ];
</script>
