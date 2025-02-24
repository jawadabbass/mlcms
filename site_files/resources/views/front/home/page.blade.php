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
                            <img src="{{ asset_uploads('') . 'module/cms/' . $data->featured_img }}" class="thumbnail"
                                title="{{ $data->featured_img_title }}" alt="{{ $data->featured_img_alt }}">
                        </div>
                    </div>
                @endif
                <div class="col-md-{{ !empty($data->featured_img) ? 9 : 12 }}">
                    @php echo adjustUrl($data->content) @endphp
                </div>
            </div>
            @if (isset($cmsModuleDataImages) && count($cmsModuleDataImages) > 0)
                <div class="row">
                    @foreach ($cmsModuleDataImages as $image)
                        @if ($image->isBeforeAfterHaveTwoImages == 0)
                            <!-- Single Item -->
                            <div class="col-md-3 mb-3px">
                                <div class="effect-left-swipe">
                                    <div class="imagebox">
                                        <img src="{{ $image->thumb }}" alt="{{ $image->image_alt }}"
                                            title="{{ $image->image_title }}">
                                    </div>
                                    <a href="{{ $image->main }}" class="item popup-link"
                                        title="{{ $image->image_title }}"><i class="fa fa-plus"></i></a>
                                    <div class="icons">
                                        <div class="cat">
                                            <span>{{ $image->image_title }}</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- End Single Item -->
                        @else
                            <!-- Single Item -->
                            <div class="col-md-3 mb-3px">
                                <a href="javascript:void(0);"
                                    onclick="showBeforeAfterModal('{{ $image->id }}', '{{ $image->main }}', '{{ $image->main2 }}')"
                                    class="image-link beforeafter" title="{{ $image->image_title }}">
                                    <img-comparison-slider>
                                        <figure slot="first" class="before">
                                            <img width="100%" src="{{ $image->thumb }}">
                                            <figcaption>Before</figcaption>
                                        </figure>
                                        <figure slot="second" class="after">
                                            <img width="100%" src="{{ $image->thumb2 }}">
                                            <figcaption>After</figcaption>
                                        </figure>
                                    </img-comparison-slider>
                                </a>
                            </div>
                            <!-- End Single Item -->
                        @endif
                    @endforeach
                </div>
            @endif

            @if (isset($cmsModuleVideos) && count($cmsModuleVideos) > 0)
                <div class="row">
                    @foreach ($cmsModuleVideos as $videoObj)
                        <div class="col-xs-6 col-md-3">
                            <div class="thumbnail-item">
                                <a href="javascript:void(0);" onclick="showModuleVideoModal('{{ $videoObj->video }}');"
                                    class="ctimgbox" title="">
                                    <img src="{{ $videoObj->thumb }}">
                                </a>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>
    </div>
@endsection
@section('beforeHeadClose')
    <style>
        .mb-3px {
            margin-bottom: 3px;
        }
    </style>
@endsection
@section('beforeBodyClose')
    <div class="modal fade" id="beforeAfterImageModal" tabindex="-1" aria-labelledby="beforeAfterImageModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-scrollable modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-body">
                    <div class="row text-center" id="beforeAfterImageModalContainer"></div>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="videoModal" tabindex="-1" aria-labelledby="videoModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-scrollable modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="text-center row" id="videoContainer"></div>
                </div>
            </div>
        </div>
    </div>
    <script>
        function showBeforeAfterModal(image_id, before_image, after_image) {
            var htmlStr = `<img-comparison-slider>
                                <figure slot="first" class="before">
                                    <img width="100%" src="${before_image}">
                                    <figcaption>Before</figcaption>
                                </figure>
                                <figure slot="second" class="after">
                                    <img width="100%" src="${after_image}">
                                    <figcaption>After</figcaption>
                                </figure>
                            </img-comparison-slider>`;
            $('#beforeAfterImageModalContainer').html(htmlStr);
            $('#beforeAfterImageModal').modal('show');
        }
    </script>
    <script>
        $("#videoModal").on('hidden.bs.modal', function(e) {
            $("#videoModal iframe").attr("src", '');
            $("#videoModal video").attr("src", '');
            $("#videoContainer").html('');
        });

        function showModuleVideoModal(video) {
            var htmlStr = `${video}`;
            $('#videoContainer').html(htmlStr);
            $('#videoModal').modal('show');
        }
    </script>
@endsection
