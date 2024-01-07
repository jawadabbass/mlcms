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
                            <img src="{{ asset_storage('/uploads/videos/thumb/' . $video->video_img) }}" alt="{{ $video->heading }}"
                                title="{{ $video->heading }}">
                            <div class="playbtn">
                                <a class="popup-link123" href="{{ url('videos/' . $video->slug) }}">
                                    {{ $video->heading }}
                                    <span><i class="fas fa-play"></i></span>
                                </a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
@endsection
