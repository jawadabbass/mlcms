@extends('front.layout.app')
@section('content')
    @php $settingArr = settingArr(); @endphp
    @php echo cms_edit_page('cms',$data->id);@endphp

    {!! cms_page_heading($data->heading) !!}
    <div class="about-wrap cms-content default-padding-20">
        <div class="container">
            <div class="row">
                @if (!empty($data->featured_img))
                <div class="col-md-3">
                    <div class="about-pic">
                        <img src="{{ base_url() . 'uploads/module/cms/' . $data->featured_img }}" class="thumbnail"
                            title="{{ $data->featured_img_title }}" alt="{{ $data->featured_img_alt }}">
                    </div>
                </div>
                @endif
                <div class="col-md-{{ (!empty($data->featured_img))? 9:12 }}">
                    @php echo $data->content @endphp
                </div>
            </div>
            @if (isset($cmsModuleDataImages) && count($cmsModuleDataImages) > 0)
                <div class="row">
                    @foreach ($cmsModuleDataImages as $image)
                        <div class="col-xs-6 col-md-3">
                            <a href="{{ $image->main }}" target="_blank" class="thumbnail">
                                <img src="{{ $image->thumb }}" title="{{ $image->image_title }}"
                                    alt="{{ $image->image_alt }}">
                            </a>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>
    </div>
@endsection
