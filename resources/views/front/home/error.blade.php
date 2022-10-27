    <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        @php echo seo_print($seoArr) @endphp
        @php $settingArr = settingArr(); @endphp
        @include('front.common_views.before_head_close')
        @yield('beforeHeadClose')
    </head>

    <body>
        <div class="main-header">
            {!! cms_page_heading('<i class="fa fa-ban" aria-hidden="true"></i> Error! while processing your request') !!}
            <div class="about-wrap cms-content">
                <div class="container">
                    <div class="row">
                        <div class="col-md-8 col-md-offset-2">
                            <div class="alert alert-danger">@php echo $data->val1 @endphp</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </body>

    </html>
