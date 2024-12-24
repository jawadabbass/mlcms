@extends('front.layout.app')
@section('content')
    @php echo cms_edit_page("module/testimonials");@endphp
    {!! cms_page_heading('TESTIMONIALS') !!}
    <div class="testimonials-faq about-area default-padding">
        <div class="container">
            <div class="row">
                <!-- Start Testimonials -->
                <div class="col-md-12 management-quote">
                    <h2>What Clients say</h2>
                    <div class="management-items management-carousel owl-carousel owl-theme">
                        @foreach ($testimonials as $testimonial)
                            <!-- Single Item -->
                            <div class="item">
                                {!! adjustUrl($testimonial->content) !!}
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
            </div>
        </div>
    </div>
@endsection
