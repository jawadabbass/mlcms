@extends('front.layout.app')
@section('content')
    {!! cms_page_heading($serviceObj->title) !!}
    <div class="about-wrap">
        <!-- Start Blog
            ============================================= -->
        <div class="services-single-area single full-blog right-sidebar full-blog default-padding-20">
            <div class="container">
                <div class="row">
                    <div class="blog-items">
                        <div class="services-content col-md-8">
                            <img src="{{ asset_uploads('services/' . $serviceObj->featured_image) }}"
                                title="{{ $serviceObj->featured_image_title }}" alt="{{ $serviceObj->featured_image_alt }}">
                            <div class="info">
                                <h2>{{ $serviceObj->title }}</h2>
                                <div class="content"> {!! adjustUrl($serviceObj->description) !!} </div>
                            </div>
                        </div>
                        <div class="sidebar col-md-4">
                            <!-- Single Item -->
                            <div class="sidebar-item link" id="services_side_bar">
                                <div class="title">
                                    <h4>Other Services</h4>
                                </div>
                                {!! $servicesHtml !!}
                            </div>
                            <!-- End Single Item -->

                        </div>
                    </div>
                </div>
                @if (isset($serviceExtraImages) && count($serviceExtraImages) > 0)
                    <div class="row">
                        @foreach ($serviceExtraImages as $image)
                            @if ($image->isBeforeAfterHaveTwoImages == 0)
                                <!-- Single Item -->
                                <div class="col-md-3 mb-3px">
                                    <div class="effect-left-swipe">
                                        <div class="imagebox">
                                            <img src="{{ $image->thumb }}" alt="{{ $image->image_alt }}"
                                                title="{{ $image->image_title }}">
                                        </div>
                                        <a href="{{ $image->main }}" class="item popup-link"
                                            title="{{ $image->image_title }}"><i class="fa fa-plus"></i></a>
                                        <div class="icons">
                                            <div class="cat">
                                                <span>{{ $image->image_title }}</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- End Single Item -->
                            @else
                                <!-- Single Item -->
                                <div class="col-md-3 mb-3px">
                                    <a href="javascript:void(0);"
                                        onclick="showBeforeAfterModal('{{ $image->id }}', '{{ $image->main }}', '{{ $image->main2 }}')"
                                        class="image-link beforeafter" title="{{ $image->image_title }}">
                                        <img-comparison-slider>
                                            <figure slot="first" class="before">
                                                <img width="100%" src="{{ $image->thumb }}">
                                                <figcaption>Before</figcaption>
                                            </figure>
                                            <figure slot="second" class="after">
                                                <img width="100%" src="{{ $image->thumb2 }}">
                                                <figcaption>After</figcaption>
                                            </figure>
                                        </img-comparison-slider>
                                    </a>
                                </div>
                                <!-- End Single Item -->
                            @endif
                        @endforeach
                    </div>
                @endif
            </div>
            <!-- End Blog -->
        </div>
    @endsection
    @section('beforeHeadClose')
        <style>
            .mb-3px {
                margin-bottom: 3px;
            }
        </style>
    @endsection
    @section('beforeBodyClose')
        <div class="modal fade" id="beforeAfterImageModal" tabindex="-1" aria-labelledby="beforeAfterImageModalLabel"
            aria-hidden="true">
            <div class="modal-dialog modal-lg modal-dialog-scrollable modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-body">
                        <div class="row text-center" id="beforeAfterImageModalContainer"></div>
                    </div>
                </div>
            </div>
        </div>
        <script>
            function showBeforeAfterModal(image_id, before_image, after_image) {
                var htmlStr = `<img-comparison-slider>
                                    <figure slot="first" class="before">
                                        <img width="100%" src="${before_image}">
                                        <figcaption>Before</figcaption>
                                    </figure>
                                    <figure slot="second" class="after">
                                        <img width="100%" src="${after_image}">
                                        <figcaption>After</figcaption>
                                    </figure>
                                </img-comparison-slider>`;
                $('#beforeAfterImageModalContainer').html(htmlStr);
                $('#beforeAfterImageModal').modal('show');
            }
        </script>
    @endsection
