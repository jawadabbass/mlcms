@extends('front.layout.app')
@section('content')
    @php echo front_dashboard_links(); @endphp
    <!-- Start Banner
                                            ============================================= -->
    <div class="banner-area">
        <div id="bootcarousel" class="carousel inc-top-heading slide carousel-fade animate_text" data-ride="carousel">
            <!-- Wrapper for slides -->
            <div class="carousel-inner text-light carousel-zoom">
                @php $b_count=0; @endphp
                @foreach ($get_all_banner as $banner)
                    @php $b_class=($b_count==0)?'active':''; @endphp
                    <div class="item {{ $b_class }}">
                        <div class="slider-thumb bg-fixed"
                            style="background-image: url({{ asset_uploads('module/banner/' . $banner->featured_img) }});">
                        </div>
                        <div class="box-table shadow dark">
                            <div class="box-cell">
                                <div class="container">
                                    <div class="row">
                                        <div class="col-md-8">
                                            <div class="content">
                                                <h3 data-animation="animated slideInRight">{{ $banner->heading }}</h3>
                                                <h1 data-animation="animated slideInLeft">@php echo adjustUrl($banner->content) @endphp</h1>
                                                <a data-animation="animated slideInUp" class="btn btn-light effect btn-md"
                                                    href="{{ $banner->additional_field_2 }}">{{ $banner->additional_field_1 }}</a>
                                                <a data-animation="animated slideInUp" class="btn btn-theme effect btn-md"
                                                    href="{{ $banner->additional_field_4 }}">{{ $banner->additional_field_3 }}</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    @php $b_count++; @endphp
                @endforeach
            </div>
            <!-- End Wrapper for slides -->

            <!-- Left and right controls -->
            <a class="left carousel-control shadow" href="#bootcarousel" data-slide="prev"> <i class="fa fa-angle-left"></i>
                <span class="sr-only">Previous</span> </a> <a class="right carousel-control shadow" href="#bootcarousel"
                data-slide="next"> <i class="fa fa-angle-right"></i> <span class="sr-only">Next</span> </a>
        </div>
    </div>
    <!-- End Banner -->
    <!-- Start Our About
                                            ============================================= -->
    <div class="about-area full-width inc-shadow mt default-padding bottom-less">
        <div class="container">
            <div class="row">
                <!-- Start About -->
                <div class="about-content content-left">
                    <div class="col-md-6 info">
                        <h4>About Us</h4>
                        @php $about_us_page=get_page(104);@endphp
                        @php echo get_excerpt(adjustUrl($about_us_page->content),786); @endphp
                        @php
                            //echo $about_us_page->content;
                        @endphp
                        <div>
                            <a href="@php echo base_url().$about_us_page->post_slug; @endphp"
                                class="btn btn-theme effect btn-md" data-animation="animated slideInUp">Read More</a> <a
                                class="btn btn-md btn-contact"
                                href="tel: @php echo FindInsettingArr('telephone'); @endphp"><i class="fas fa-phone"></i>
                                @php echo FindInsettingArr('telephone'); @endphp </a>
                        </div>
                    </div>
                    <div class="col-md-6 thumb"> <img
                            src="{{ asset_uploads('module/cms/' . $about_us_page->featured_img) }}"
                            title="{{ $about_us_page->featured_img_title }}" alt="{{ $about_us_page->featured_img_alt }}">
                    </div>
                </div>
                <!-- End About -->

                <!-- Start Our Features -->
                <div class="col-md-12 text-center about-items">
                    <div class="row">

                        @foreach ($get_all_features as $feature)
                            <!-- Single Item -->
                            <div class="col-md-3 col-sm-6 single-item">
                                <div class="item"> <a href="#">
                                        <i class="{{ $feature->additional_field_1 }}"></i>
                                        <h5>{{ $feature->heading }}</h5>
                                    </a> </div>
                            </div>
                            <!-- End Single Item -->
                        @endforeach
                    </div>
                </div>
                <!-- End Our Features -->
            </div>
        </div>
    </div>
    <!-- End Our About -->
    <!-- Start Services
                                            ============================================= -->
    <div class="services-inc-area half-bg default-padding-20 bg-gray">
        <div class="container">
            <div class="row">
                <div class="col-md-8 col-md-offset-2">
                    <div class="site-heading text-light text-center">
                        <h2>Our Services</h2>
                        <p> While mirth large of on front. Ye he greater related adapted proceed entered an. Through it
                            examine express promise no. Past add size game cold girl off how old </p>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="services-items services-carousel owl-carousel owl-theme">
                        @foreach ($get_all_services as $service)
                            <!-- Single Item -->
                            <div class="item">
                                <div class="thumb"> <img
                                        src="{{ asset_uploads('module/services/' . $service->featured_img) }}"
                                        title="{{ $service->featured_img_title }}" alt="{{ $service->featured_img_alt }}">
                                    <div class="overlay"> <a href="#"> <i class="flaticon-report"></i>
                                            <h4>{{ $service->heading }}</h4>
                                        </a> </div>
                                </div>
                                <div class="info">
                                    <p> @php echo get_excerpt(adjustUrl($service->content),100) @endphp </p>
                                    <a href="{{ url($service->post_slug) }}">Read More <i
                                            class="fas fa-angle-double-right"></i></a>
                                </div>
                            </div>
                            <!-- End Single Item -->
                        @endforeach

                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- End Services -->
    <!-- Start Portfolio
                                            ============================================= -->
    <div class="portfolio-area inc-colum default-padding-20 bg-gray">
        <div class="container">
            <div class="row">
                <div class="col-md-8 col-md-offset-2">
                    <div class="site-heading text-center">
                        <h2> Gallery </h2>
                        <p> Lorem ipsum dolor sit amet, consectetur adipisicing elit. Vero recusandae perferendis, eius odit
                            quod! Modi cum illum odio ullam commodi, earum hic est repudiandae ex sit sunt doloremque, ipsum
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
                                <button data-filter=".album_{{ $album->id }}">{{ $album->title }}</button>
                            @endforeach
                        </div>
                        <!-- End Mixitup Nav-->

                        <div class="row magnific-mix-gallery text-center masonary">
                            <div id="portfolio-grid" class="portfolio-items col-3">
                                @foreach ($images as $image)
                                    <!-- Single Item -->
                                    <div class="pf-item album_{{ $image->album_id }}">
                                        @php
                                            $thumb_img_url = asset_uploads('gallery/' . $image->album_id . '/thumb/' . $image->imageUrl);
                                            $img_url = asset_uploads('gallery/' . $image->album_id . '/' . $image->imageUrl);
                                        @endphp
                                        <div class="effect-left-swipe">
                                            <div class="imagebox">
                                                <img src="{{ $thumb_img_url }}" alt="{{ $image->image_alt }}"
                                                    title="{{ $image->image_title }}">
                                            </div>
                                            <a href="{{ $img_url }}" class="item popup-link"
                                                title="{{ $image->image_title }}"><i class="fa fa-plus"></i></a>
                                            <div class="icons">
                                                <div class="cat"> <span>{{ $album->title }}</span>
                                                    <span>{{ $image->image_title }}</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- End Single Item -->
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- End Portfolio -->
    <!-- Start Testimonial & Faq
                                            ============================================= -->
    <div class="testimonials-faq about-area default-padding">
        <div class="container">
            <div class="row">
                <!-- Start Testimonials -->
                <div class="col-md-6 management-quote">
                    <h2>What Clients say</h2>
                    <div class="management-items management-carousel owl-carousel owl-theme">
                        @foreach ($get_all_testimonials as $testimonial)
                            <!-- Single Item -->
                            <div class="item">
                                <p> {{ adjustUrl($testimonial->content) }} </p>
                                <div class="author">
                                    <div class="thumb"> <img
                                            src="{{ asset_uploads('module/testimonials/' . $testimonial->featured_img) }}"
                                            title="{{ $testimonial->featured_img_title }}"
                                            alt="{{ $testimonial->featured_img_alt }}"> </div>
                                    <div class="info"> <span>- {{ $testimonial->additional_field_1 }}</span>
                                        <b>{{ $testimonial->additional_field_2 }}</b>
                                    </div>
                                </div>
                            </div>
                            <!-- End Single Item -->
                        @endforeach
                    </div>
                </div>
                <!-- End Testimonials -->

                <!-- Start Faq -->
                <div class="col-md-6 faq-area">
                    <div class="heading">
                        <h2>Answer & Questions</h2>
                    </div>
                    <div class="acd-items acd-arrow">
                        <div class="panel-group symb" id="accordion">

                            @php $faq_count=0; @endphp
                            @foreach ($get_all_faqs as $faq)
                                @php $classin=($faq_count==0)?'in':''; @endphp
                                <!-- Single Item -->
                                <div class="panel panel-default">
                                    <div class="panel-heading">
                                        <h4 class="panel-title"> <a data-bs-toggle="collapse" data-parent="#accordion"
                                                href="#ac{{ $faq_count }}"> {{ $faq->heading }} </a> </h4>
                                    </div>
                                    <div id="ac{{ $faq_count }}" class="panel-collapse collapse {{ $classin }}">
                                        <div class="panel-body">
                                            @php echo adjustUrl($faq->content) @endphp
                                        </div>
                                    </div>
                                </div>
                                <!-- End Single Item -->
                                @php $faq_count++; @endphp
                            @endforeach


                        </div>
                    </div>
                </div>
                <!-- End Faq -->
            </div>
        </div>
    </div>
    <!-- End Testimonial & Faq -->
    <!-- Start Achivement
                                            ============================================= -->
    <div class="achivement-area bg-fixed shadow dark text-light default-padding"
        style="background-image: url(img/banner/9.jpg')}});">
        <div class="container">
            <div class="row">
                <div class="col-md-6 info">
                    @php $achh_page=get_page(181);@endphp
                    <h2>@php echo $achh_page->heading; @endphp </h2>
                    @php echo adjustUrl($achh_page->content); @endphp
                    <a href="{{ url($achh_page->post_slug) }}" class="btn btn-theme effect btn-md">Start Now</a>
                </div>
                <div class="col-md-6 achivement-items">
                    @php
                        $scwidget = get_widgets(81);
                        $af_data = json_decode($scwidget->additional_field_data);
                    @endphp
                    <div class="panel panel-primary">
                        <div class="panel-heading">
                            <h3 class="panel-title">{{ $scwidget->heading }}</h3>
                        </div>
                        <div class="panel-body">
                            <a href="#" class="thumbnail">
                            <img class="card-img-top" src="{{ asset_uploads('widgets/' . $scwidget->featured_image) }}"
                                alt="{{ $scwidget->featured_image_alt }}" title="{{ $scwidget->featured_image_title }}">
                            </a>
                            {!! adjustUrl($scwidget->content) !!}
                        </div>
                        <div class="panel-footer"><a href="{{ $af_data->additional_field_2 }}"
                                class="btn btn-primary">{{ $af_data->additional_field_1 }}</a></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- End Achivement Area -->
    <!-- Start Blog Area
                                            ============================================= -->
    <div class="blog-area default-padding bottom-less">
        <div class="container">
            <div class="row">
                <div class="col-md-8 col-md-offset-2">
                    <div class="site-heading text-center">
                        <h2>Latest Blog</h2>
                        <p> While mirth large of on front. Ye he greater related adapted proceed entered an. Through it
                            examine express promise no. Past add size game cold girl off how old </p>
                    </div>
                </div>
            </div>
            <div class="row">
                @if (count($blogData) > 0)
                    @foreach ($blogData as $blogsValues)
                        <!-- Single Item -->
                        <div class="col-md-4 single-item">
                            <div class="item">
                                <div class="thumb">
                                    <a href="{{ base_url() . 'blog/' . $blogsValues['post_slug'] }}">
                                        @if (!empty($blogsValues['featured_img']) && file_exists(storage_uploads('blog/' . $blogsValues['featured_img'])))
                                            <img src="{{ asset_uploads('blog/' . $blogsValues['featured_img']) }}"
                                                title="{{ $blogsValues['featured_img_title'] }}"
                                                alt="{{ $blogsValues['featured_img_alt'] }}">
                                        @else
                                            <img src="{{ asset_uploads('back/images/no_image.jpg') }}"
                                                title="{{ $blogsValues['featured_img_title'] }}"
                                                alt="{{ $blogsValues['featured_img_alt'] }}">
                                        @endif
                                    </a>
                                    <span class="post-formats"><i class="fas fa-image"></i></span>
                                </div>
                                <div class="info">
                                    <!--<div class="cats"> <a href="#">Business</a> <a href="#">Assets</a> </div>-->
                                    <h4> <a href="{{ base_url() . 'blog/' . $blogsValues['post_slug'] }}">
                                            @php echo $blogsValues['title']; @endphp</a> </h4>
                                    <p> @php echo get_excerpt($blogsValues['description'],40); @endphp </p>
                                    <div class="meta">
                                        <ul>
                                            <li><i class="fas fa-calendar-alt"></i>
                                                {{ date('M d, Y ', strtotime($blogsValues['dated'])) }} </li>
                                        </ul>
                                        <a href="{{ base_url() . 'blog/' . $blogsValues['post_slug'] }}">Read More</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- End Single Item -->
                    @endforeach
                    <div class="clearfix"></div>
                @else
                    <p style="text-align: center;">No Record Found</p>
                @endif
            </div>
        </div>
    </div>
    <!-- End Blog Area -->
    <!-- Start Clients Area
                                            ============================================= -->
    <div class="clients-area bg-dark default-padding">
        <div class="container">
            <div class="row">
                <div class="col-md-5 left-info text-light">
                    <h4>Our Partners</h4>
                    <p> Forming two comfort invited. Yet she income effect edward. Entire desire way design few. Mrs
                        sentiments led solicitude estimating friendship fat. Meant those event </p>
                </div>
                <div class="col-md-7 clients-box">
                    <div class="clients-items owl-carousel owl-theme text-center">
                        @foreach ($get_all_partners as $partner)
                            <div class="single-item">
                                <a href="#">
                                    <img src="{{ asset_uploads('module/partners/' . $partner->featured_img) }}"
                                        title="{{ $partner->featured_img_title }}"
                                        alt="{{ $partner->featured_img_alt }}">
                                </a>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
<!-- End Clients Area --> @endsection
