@if ($image->isBeforeAfterHaveTwoImages == 0)
    <div class="col-md-4" id="more_image_{{ $image->id }}">
        <div class="mb-3 card">
            <div class="text-center card-body">
                <a href="javascript:void(0);" title="{{ $image->image_title }}"
                    onclick="openModuleDataImageZoomModal('{{ asset_uploads($folder . '/' . $image->image_name . '?' . time()) }}');">
                    <img id="image_1_{{ $image->id }}" data-imgname="{{ $image->image_name }}"
                        src="{{ asset_uploads($folder . '/thumb/' . $image->image_name . '?' . time()) }}"
                        style="width:100%" alt="{{ $image->image_alt }}" title="{{ $image->image_title }}">
                </a>
            </div>
            <div class="text-center card-footer">
                <div class="caption myadelbtn">
                </div>
                <div class="mt-2 image_btn">
                    <div class="drag sortable_div" title="Drag and Drop to sort"><i class="fas fa-arrows"
                            aria-hidden="true"></i></div>
                    <a title="Delete Image"
                        onclick="deleteModuleDataImage({{ $image->id }}, {{ '\'' . $image->image_name . '\'' }}, this);"
                        class="mb-1 btn btn-sm btn-danger" data-bs-toggle="tooltip" data-placement="left"
                        title="Delete this image" href="javascript:;"> <i class="fas fa-trash"></i></a>
                    @if ((bool) $image->isBeforeAfter == false)
                        <a onClick="markBeforeAfter({{ $image->id }}, this)" href="javascript:void(0)"
                            class="mb-1 btn btn-sm btn-warning">Mark Before
                            After</a>
                    @endif
                    <a title="Crop Image" onClick="bind_cropper_preview_module_data_image({{ $image->id }}, 1);"
                        href="javascript:void(0)" class="mb-1 btn btn-sm btn-warning"><i class="fas fa-crop"
                            aria-hidden="true"></i></a>
                    <a title="Image Alt/Title" onClick="openModuleDataImageAltTitleModal({{ $image->id }});"
                        href="javascript:void(0)" class="mb-1 btn btn-sm btn-success"><i class="fas fa-bars"
                            aria-hidden="true"></i></a>
                </div>
            </div>
        </div>
    </div>
@else
    <div class="col-md-12" id="more_image_{{ $image->id }}">
        <div class="card">
            <div class="text-center card-body">
                <div class="row">
                    <div class="text-center col-md-4">
                        <a href="javascript:void(0);" title="{{ $image->image_title }}"
                            onclick="openModuleDataImageZoomModal('{{ asset_uploads($folder . '/' . $image->image_name . '?' . time()) }}');">
                            <img id="image_1_{{ $image->id }}" data-imgname="{{ $image->image_name }}"
                                src="{{ asset_uploads($folder . '/thumb/' . $image->image_name . '?' . time()) }}"
                                style="width:100%" alt="{{ $image->image_alt }}" title="{{ $image->image_title }}">
                        </a>
                    </div>
                    <div class="text-center col-md-4">
                        <a href="javascript:void(0);" title="{{ $image->image_title }}"
                            onclick="openModuleDataImageZoomModal('{{ asset_uploads($folder . '/' . $image->image_name2 . '?' . time()) }}');">
                            <img id="image_2_{{ $image->id }}" data-imgname="{{ $image->image_name2 }}"
                                src="{{ asset_uploads($folder . '/thumb/' . $image->image_name2 . '?' . time()) }}"
                                style="width:100%" alt="{{ $image->image_alt }}" title="{{ $image->image_title }}">
                        </a>
                    </div>
                    <div class="text-center col-md-4">
                        <img-comparison-slider>
                            <figure slot="first" class="before">
                                <img width="100%"
                                    src="{{ asset_uploads($folder . '/thumb/' . $image->image_name . '?' . time()) }}">
                                <figcaption>Before</figcaption>
                            </figure>
                            <figure slot="second" class="after">
                                <img width="100%"
                                    src="{{ asset_uploads($folder . '/thumb/' . $image->image_name2 . '?' . time()) }}">
                                <figcaption>After</figcaption>
                            </figure>
                        </img-comparison-slider>
                    </div>
                </div>
            </div>
            <div class="text-center card-footer">
                <div class="row">
                    <div class="text-center col-md-12">
                        <div class="caption myadelbtn">
                        </div>
                        <div class="mt-2 image_btn">
                            <div class="drag sortable_div" title="Drag and Drop to sort"><i class="fas fa-arrows"
                                    aria-hidden="true"></i></div>
                            <a title="Delete Image"
                                onclick="deleteModuleDataImage({{ $image->id }}, {{ '\'' . $image->image_name . '\'' }}, this);"
                                class="mb-1 btn btn-sm btn-danger" data-bs-toggle="tooltip" data-placement="left"
                                title="Delete this image" href="javascript:;">
                                <i class="fas fa-trash"></i></a>
                            @if ((bool) $image->isBeforeAfter == false)
                                <a onClick="markBeforeAfter({{ $image->id }}, this)" href="javascript:void(0)"
                                    class="mb-1 btn btn-sm btn-warning">Mark Before
                                    After</a>
                            @endif
                            <a title="Crop Image"
                                onClick="bind_cropper_preview_module_data_image({{ $image->id }}, 1);"
                                href="javascript:void(0)" class="mb-1 btn btn-sm btn-warning"><i class="fas fa-crop"
                                    aria-hidden="true"></i></a>
                            <a title="Crop Image"
                                onClick="bind_cropper_preview_module_data_image({{ $image->id }}, 2);"
                                href="javascript:void(0)" class="mb-1 btn btn-sm btn-warning"><i class="fas fa-crop"
                                    aria-hidden="true"></i></a>
                            <a title="Image Alt/Title"
                                onClick="openModuleDataImageAltTitleModal({{ $image->id }});"
                                href="javascript:void(0)" class="mb-1 btn btn-sm btn-success"><i class="fas fa-bars"
                                    aria-hidden="true"></i></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endif
