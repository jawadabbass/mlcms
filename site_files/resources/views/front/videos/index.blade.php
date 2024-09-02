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
                    <div class="col-md-3">
                        <a href="{{ url('videos/' . $video->slug) }}">
                            <img class="card-img-top" src="{{ asset_storage('uploads/videos/thumb/' . $video->video_img) }}"
                                alt="{{ $video->heading }}" title="{{ $video->heading }}">
                            {{ $video->heading }}
                        </a>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
@endsection
