@extends('front.layout.app')
@section('content')
    @php $settingArr = settingArr(); @endphp
    @php echo cms_edit_page('cms',$about->id); @endphp
    {!! cms_page_heading('About Us') !!}
    <div class="about-wrap cms-content default-padding-20">
        <div class="container">
            <div class="row">
                <div class="col-md-{{ !empty($about->featured_img) ? 9 : 12 }}">
                    @php echo $about->content @endphp
                </div>
                @if (!empty($about->featured_img))
                    <div class="col-md-3">
                        <div class="about-pic">
                            <img src="{{ asset_uploads('') . 'module/cms/' . $about->featured_img }}" class="thumbnail"
                                title="{{ $about->featured_img_title }}" alt="{{ $about->featured_img_alt }}">
                        </div>
                    </div>
                @endif
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
