<div class="row">
    <div class="col-md-12">
        <hr />
        <input type="hidden" name="session_id" value="{{ session()->getId() }}" />
        <input type="hidden" name="service_id" value="{{ $serviceObj->id }}" />

        <div class="row service_extra_images m-2">
            <div class="col-md-12 mb-3 before_after_not_have_two_images">
                <input class="form-control" id="uploadFile" multiple="" name="uploadFile[]" type="file"
                    onchange="uploadServiceExtraImages();" />
                <div class="text-danger"><em>Max :</em> {{ getMaxUploadSize() }} MB</div>
                <div id="image_preview" class="row"></div>
            </div>
            <div class="col-md-12 mb-3">
                <input type="checkbox" name="isBeforeAfter" id="isBeforeAfter" value="1"
                    style="width: 15px; height:15px;"
                    onclick="toggle_service_extra_image_before_after_have_two_images();"
                    {{ old('isBeforeAfter', 0) == 1 ? 'checked' : '' }} /> <b>Is Before After?</b>
            </div>
            <div class="col-md-12 mb-3" id="is_before_after_have_two_images" style="display: none;">
                <label>Is Before After Have Two Images?</label>
                <input type="radio" name="isBeforeAfterHaveTwoImages" value="1" style="width: 15px; height:15px;"
                    onclick="show_service_extra_image_before_after_have_two_images();"
                    {{ old('isBeforeAfterHaveTwoImages', 0) == 1 ? 'checked' : '' }} />
                <b>Yes</b>
                <input type="radio" name="isBeforeAfterHaveTwoImages" value="0"
                    {{ old('isBeforeAfterHaveTwoImages', 0) == 0 ? 'checked' : '' }} style="width: 15px; height:15px;"
                    onclick="hide_service_extra_image_before_after_have_two_images();" />
                <b>No</b>
            </div>
            <div class="col-md-12 mb-3 before_after_have_two_images" style="display: none;">
                <label>Before Image</label>
                <input class="form-control" id="image_name" name="image_name" type="file"
                    onchange="uploadServiceExtraImages();" />
                <div class="text-danger"><em>Max :</em> {{ getMaxUploadSize() }} MB</div>
                <div id="before_image_preview" class="row"></div>
            </div>
            <div class="col-md-12 mb-3 before_after_have_two_images" style="display: none;">
                <label>After Image</label>
                <input class="form-control" id="image_name2" name="image_name2" type="file"
                    onchange="uploadServiceExtraImages();" />
                <div class="text-danger"><em>Max :</em> {{ getMaxUploadSize() }} MB</div>
                <div id="after_image_preview" class="row"></div>
            </div>
            <div class="col-md-12">
                <div class="spinner-border text-primary" role="status" id="service_extraImageLoader"
                    style="display:none;">
                    <span class="visually-hidden">Loading...</span>
                </div>
            </div>
        </div>
        <div class="row service_extra_images_sortable_row service_extra_images m-2" id="service_extraImages">
            @if ($serviceExtraImages->count())
                @foreach ($serviceExtraImages as $image)
                    @include('back.services.services_extra_images.services_extra_images_html_sub', [
                        'folder' => 'services',
                        'image' => $image,
                    ])
                @endforeach
            @endif
        </div>
        <hr />

    </div>
</div>
