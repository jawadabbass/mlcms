<link rel="shortcut icon" href="{{ asset_storage('front/img/favicon.ico') }}" type="image/x-icon">
<!-- ========== Start Stylesheet ========== -->
<link href="{{ asset_storage('front/css/bootstrap.min.css') }}" rel="stylesheet" />
<link href="{{ asset_storage('front/css/bootstrap-theme.min.css') }}" rel="stylesheet" />
<link href="{{ asset_storage('fontawesome/css/all.min.css') }}" rel="stylesheet" />
<link href="{{ asset_storage('front/css/flaticon-set.css') }}" rel="stylesheet" />
<link href="{{ asset_storage('front/css/magnific-popup.css') }}" rel="stylesheet" />
<link href="{{ asset_storage('front/css/owl.carousel.min.css') }}" rel="stylesheet" />
<link href="{{ asset_storage('front/css/owl.theme.default.min.css') }}" rel="stylesheet" />
<link href="{{ asset_storage('front/css/animate.css') }}" rel="stylesheet" />
<link href="{{ asset_storage('front/css/bootsnav.css') }}" rel="stylesheet" />
<link href="{{ asset_storage('cms/cms_default.css') }}" rel="stylesheet">
<link href="{{ asset_storage('front/css/style.css') }}" rel="stylesheet">
<link href="{{ asset_storage('front/css/custom_style.css') }}" rel="stylesheet">
<link href="{{ asset_storage('front/css/responsive.css') }}" rel="stylesheet" />
<link href="{{ asset_storage('lib/sweetalert/sweetalert2.min.css') }}" rel="stylesheet" />
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/img-comparison-slider@8/dist/styles.css" />
<!-- ========== End Stylesheet ========== -->
<!-- HTML5 shim and Respond.js')}} for IE8 support of HTML5 elements and media queries -->
<!-- WARNING: Respond.js')}} doesn't work if you view the page via file:// -->
<!--[if lt IE 9]>
      <script src="{{ asset_storage('front/js/html5/html5shiv.min.js') }}"></script>
      <script src="{{ asset_storage('front/js/html5/respond.min.js') }}"></script>
    <![endif]-->
<!-- ========== Google Fonts ========== -->
<link href="https://fonts.googleapis.com/css?family=Open+Sans" rel="stylesheet">
<link href="https://fonts.googleapis.com/css?family=Poppins:400,500,600,700,800" rel="stylesheet">
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
var base_url = "{{ base_url() }}";
</script>