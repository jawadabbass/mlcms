@extends('front.layout.app')
@section('content')
    @php $settingArr = settingArr(); @endphp
    @php echo cms_edit_page('cms',$about->id); @endphp
    {!! cms_page_heading('About Us') !!}
    <div class="about-wrap cms-content default-padding-20">
        <div class="container">
            <div class="row">
                <div class="col-md-8">
                    @php echo $about->content @endphp
                </div>
                <div class="col-md-4">
                    <img src="@php echo base_url().'uploads/module/cms/'.$about->featured_img @endphp"  title="{{ $about->featured_img_title }}" alt="{{ $about->featured_img_alt }}">
                </div>
            </div>
        </div>
    </div>
@endsection
