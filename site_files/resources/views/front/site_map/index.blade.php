@extends('front.layout.app')
@section('content')
    {!! cms_page_heading('Site Map') !!}

    <div class="container">
        {!! $siteMapHtml !!}
    </div>
@endsection
