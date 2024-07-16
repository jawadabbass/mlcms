@extends('front.layout.app')
@section('content')
    @php $settingArr = settingArr(); @endphp
    {!! cms_page_heading($videoObj->heading) !!}
    <!-- Page Title End -->
    <!-- Page Content Start -->
    <div class="innercontent">
        <div class="container">
            <div class="row">
                <div class="col-md-12 text-center">
                    {!! link2iframe($videoObj->content, $videoObj->video_type, '100%', '100%', '', 'uploads/videos/video/') !!}
                </div>
            </div>
        </div>
    </div>
@endsection
