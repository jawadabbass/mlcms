@extends('front.layout.app')
@section('content')
    @php echo cms_edit_page("services",$result->id);@endphp
    {!! cms_page_heading($result->heading) !!}
    <div class="about-wrap">
        <!-- Start Blog
        ============================================= -->
        <div class="services-single-area single full-blog right-sidebar full-blog default-padding-20">
            <div class="container">
                <div class="row">
                    <div class="blog-items">
                        <div class="services-content col-md-8">
                            <img src="{{ asset('uploads/module/services/' . $result->featured_img) }}" title="{{ $result->featured_img_title }}" alt="{{ $result->featured_img_alt }}">
                            <div class="info">
                                <h2>{{ $result->heading }}</h2>
                                <div class="content"> {{ $result->content }} </div>
                            </div>
                        </div>
                        <div class="sidebar col-md-4">
                            <!-- Single Item -->
                            <div class="sidebar-item link">
                                <div class="title">
                                    <h4>Other Services</h4>
                                </div>
                                <ul>
                                    @if (count($get_all_services) > 0)
                                        @foreach ($get_all_services as $services)
                                            <li><a
                                                    href="@php echo base_url().$services->post_slug @endphp">{{ $services->heading }}</a>
                                            </li>
                                        @endforeach
                                    @endif
                                </ul>
                            </div>
                            <!-- End Single Item -->

                        </div>
                    </div>
                </div>
            </div>
            <!-- End Blog -->
        </div>
    @endsection
