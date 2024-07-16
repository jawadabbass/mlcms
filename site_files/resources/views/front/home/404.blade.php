@extends('front.layout.app')
@section('content')
    @php $settingArr = settingArr(); @endphp
    {!! cms_page_heading('404 Not Found') !!}
    <div class="about-wrap cms-content">
        <div class="container">
            <div class="row">
                <div class="col-md-12 default-padding-20">                    
                    <img src="{{ asset_storage('images/404-error-page.png') }}" alt="">
                    <div class="alert alert-danger">
                        <i class="fa fa-exclamation-triangle" aria-hidden="true"></i> OOPS! What you are looking for is no
                        longer available or have been removed
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
