@extends('front.layout.app')
@section('beforeHeadClose')
    <link href="{{ asset_storage('') . 'module/blog/front/css/blog.css' }}" rel="stylesheet" type="text/css" />
@endsection
@section('content')
    {!! cms_page_heading('Services') !!}
    <div class="about-wrap">
        <!-- Start Blog
        ============================================= -->
        <div class="services-inc-area full-blog right-sidebar full-blog default-padding-20">
            <div class="container">
                <div class="row">
                    <div class="col-md-12">
                        <div class="services-items row">
                            @if (count($allServices) > 0)
                                @foreach ($allServices as $serviceObj)  
                                    <!-- Single Item -->
                                    <div class="col-md-4 item">
                                        <div class="thumb">
                                            <img src="{{ asset_uploads('services/' . $serviceObj->featured_image) }}"
                                            title="{{ $serviceObj->featured_image_title }}" alt="{{ $serviceObj->featured_image_alt }}">
                                            <div class="overlay">
                                                <a href="{{ url('services/'.$serviceObj->slug) }}">
                                                    <i class="flaticon-report"></i>
                                                    <h4>{{ $serviceObj->title }}</h4>
                                                </a>
                                            </div>
                                        </div>
                                        <div class="info">
                                            <p>{{ Str::limit($serviceObj->excerpt, 100, '...') }}</p>
                                            <a href="{{ url('services/'.$serviceObj->slug) }}">Read More <i
                                                    class="fas fa-angle-double-right"></i></a>
                                        </div>
                                    </div>
                                    <!-- End Single Item -->
                                @endforeach
                            @else
                                <p style="text-align: center;">No Record Found</p>
                            @endif

                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- End Blog -->
    </div>
@endsection
