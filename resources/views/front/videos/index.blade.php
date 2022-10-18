@extends('front.layout.app')
@section('beforeHeadClose')
    <link href="{{ base_url() }}module/faqs/main/css/faqs.css" rel="stylesheet">
@endsection
@section('content')
    {!! cms_page_heading('VIDEO LIBRARY') !!}
    <div class="content-wrap">
        <div class="container">
            <div class="content-bg">
                <div class="content-inner">
                    <div class="inner-wrap">
                        <div class="about-wrap">
                            <div class="row">
                                @foreach ($videos as $video)
                                    <div class="col-md-3 col-sm-6">
                                        <div class="video-pic">
                                            {!! link2iframe($video['content'], $video['video_type'], '100%', '200', 'uploads/videos/video/') !!}
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                        <div class="clearfix"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
