@extends('front.layout.app')
@section('content')
    @php echo cms_edit_page("module/testimonials");@endphp
    {!! cms_page_heading('TESTIMONIALS') !!}
    <div class="about-wrap">
        <div class="container">
            <ul class="row testimonial-wrap">
                @foreach ($testimonials as $testimonial)
                    <li class="col-md-6">
                        <div class="testimonial">
                            <p><?php echo $testimonial['content']; ?></p>
                            <div class="name">- <?php echo $testimonial['additional_field_1']; ?></div>
                        </div>
                    </li>
                @endforeach
            </ul>
        </div>
    </div>
@endsection
