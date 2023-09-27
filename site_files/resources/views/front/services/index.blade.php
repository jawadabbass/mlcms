@extends('front.layout.app')
@section('beforeHeadClose')
    <link href="{{ public_path_to_storage('') . 'module/blog/front/css/blog.css' }}" rel="stylesheet" type="text/css" />
@endsection
@section('content')
    @php echo cms_edit_page("module/services");@endphp
    {!! cms_page_heading('Services') !!}
    <div class="about-wrap">
        <!-- Start Blog
        ============================================= -->
        <div class="services-inc-area full-blog right-sidebar full-blog default-padding-20">
            <div class="container">
                <div class="row">
                    <div class="col-md-12">
                        <div class="services-items row">
                            @if (count($get_all_services) > 0)
                                @foreach ($get_all_services as $services)  
                                @php
                                    $services = (object) $services;
                                @endphp                              
                                    <!-- Single Item -->
                                    <div class="col-md-4 item">
                                        <div class="thumb">
                                            <img src="{{ $services->featured_img }}"
                                            title="{{ $services->featured_img_title }}" alt="{{ $services->featured_img_alt }}">
                                            <div class="overlay">
                                                <a href="@php echo base_url().$services->post_slug @endphp">
                                                    <i class="flaticon-report"></i>
                                                    <h4>{{ $services->heading }}</h4>
                                                </a>
                                            </div>
                                        </div>
                                        <div class="info">
                                            <p> @php echo get_excerpt($services->content,100) @endphp </p>
                                            <a href="@php echo $services->post_slug @endphp">Read More <i
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
