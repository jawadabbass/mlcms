@extends('front.layout.app')
@section('content')
    @php $settingArr = settingArr(); @endphp
    {!! cms_page_heading('Videos') !!}
    <!-- Page Title End -->
    <!-- Page Content Start -->
    <div class="innercontent">
        <div class="container">
            <div class="row">
                @foreach ($videos as $video)
                    <div class="col-md-6">
                        <div class="videoImg">
                            <img src="{{ url('/uploads/videos/thumb/' . $video->video_img) }}" alt="{{ $video->heading }}"
                                title="{{ $video->heading }}">
                            <div class="playbtn">
                                <a class="popup-link123" href="{{ url('videos/' . $video->slug) }}">
                                    <span><i class="fas fa-play"></i></span>
                                </a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
    @include('front.common_views.get_started_form_html')
@endsection
