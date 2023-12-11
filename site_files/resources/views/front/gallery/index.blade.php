@extends('front.layout.app')
@section('content')
    {!! cms_page_heading('Images Gallery') !!}

    <div class="content-wrap">
        <div class="container">
            <div class="content-bg">
                <div class="content-inner">
                    <div class="inner-wrap">
                        <div class="about-wrap">
                            <!-- Start Portfolio
                                                                ============================================= -->
                            <div class="portfolio-area inc-colum default-padding-20">
                                <div class="container">
                                    <div class="row">
                                        <div class="col-md-8 col-md-offset-2">
                                            <div class="site-heading text-center">
                                                <!--<h2>Complete Cases</h2>-->
                                                <p> Lorem ipsum dolor sit amet, consectetur adipisicing elit. Vero
                                                    recusandae perferendis, eius odit quod! Modi cum illum odio ullam
                                                    commodi, earum hic est repudiandae ex sit sunt doloremque, ipsum
                                                    quibusdam. </p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="portfolio-items-area text-center">
                                        <div class="row">
                                            <div class="col-md-12 portfolio-content">
                                                <div class="mix-item-menu text-center">
                                                    <button class="active" data-filter="*">All</button>
                                                    @foreach ($albums as $album)
                                                        <button
                                                            data-filter=".album_{{ $album->id }}">{{ $album->title }}</button>
                                                    @endforeach
                                                </div>
                                                <!-- End Mixitup Nav-->

                                                <div class="row magnific-mix-gallery text-center masonary">
                                                    <div id="portfolio-grid" class="portfolio-items col-3">
                                                        @foreach ($images as $image)
                                                            @php
                                                                $thumb_img_url = asset_uploads('') . 'gallery/' . $image->album_id . '/thumb/' . $image->imageUrl . '?' . time();
                                                                $img_url = asset_uploads('') . 'gallery/' . $image->album_id . '/' . $image->imageUrl . '?' . time();

                                                                $thumb_img2_url = asset_uploads('') . 'gallery/' . $image->album_id . '/thumb/' . $image->imageUrl2 . '?' . time();
                                                                $img2_url = asset_uploads('') . 'gallery/' . $image->album_id . '/' . $image->imageUrl2 . '?' . time();
                                                            @endphp
                                                            @if ($image->isBeforeAfterHaveTwoImages == 0)
                                                                <!-- Single Item -->
                                                                <div class="pf-item album_{{ $image->album_id }}">
                                                                    <div class="effect-left-swipe">
                                                                        <div class="imagebox">
                                                                            <img src="{{ $thumb_img_url }}"
                                                                                alt="{{ $image->image_alt }}"
                                                                                title="{{ $image->image_title }}">
                                                                        </div>
                                                                        <a href="{{ $img_url }}"
                                                                            class="item popup-link"
                                                                            title="{{ $image->image_title }}"><i
                                                                                class="fa fa-plus"></i></a>
                                                                        <div class="icons">
                                                                            <div class="cat">
                                                                                <span>{{ $album->title }}</span>
                                                                                <span>{{ $image->image_title }}</span>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <!-- End Single Item -->
                                                            @else
                                                                <!-- Single Item -->
                                                                <div class="pf-item album_{{ $image->album_id }}"
                                                                    id="image_before_after_preview_{{ $image->id }}">
                                                                </div>
                                                                <!-- End Single Item -->
                                                            @endif
                                                        @endforeach
                                                    </div>
                                                </div>                                        
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- End Portfolio -->
                        </div>
                        <div class="clearfix"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('beforeBodyClose')
    <script>
        @if ($images->count())
            @foreach ($images as $image)
                @if ($image->isBeforeAfterHaveTwoImages == 1)
                    beforeEffectslider({
                        Selector: "#image_before_after_preview_{{ $image->id }}",
                        BeforeImage: "{{ asset_uploads('') }}gallery/{{ $image->album_id }}/{{ $image->imageUrl . '?' . time() }}",
                        BeforeAlt: "Before",
                        AfterImage: "{{ asset_uploads('') }}gallery/{{ $image->album_id }}/{{ $image->imageUrl2 . '?' . time() }}",
                        AftereAlt: "After",
                        Buttons: true,
                        ButtonsText: {
                            after: 'After',
                            before: 'Before'
                        }
                    });
                @endif
            @endforeach
        @endif
    </script>
@endsection
