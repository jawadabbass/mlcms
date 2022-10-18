@extends('front.layout.app')
@section('content')
    @php $settingArr = settingArr(); @endphp
    @php echo cms_edit_page('cms',$data->id);@endphp

    {!! cms_page_heading($data->heading) !!}
    <div class="about-wrap cms-content default-padding-20">
        <div class="container">
            <div class="row">
                <div class="col-md-7">
                    @php echo $data->content @endphp
                </div>
                <div class="col-md-5">
                    <div class="about-pic">
                        <img src="{{ base_url() . 'uploads/module/cms/' . $data->featured_img }}" title="{{ $data->featured_img_title }}" alt="{{ $data->featured_img_alt }}">
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
