<div class="row" style="display:{{ $module->show_feature_img_field == 1 ? 'block' : 'none' }}">
    <div class="col-md-12">
        <hr />
        <input type="hidden" name="session_id" value="{{ session()->getId() }}" />
        <input type="hidden" name="module_data_id" value="{{ isset($moduleData) ? $moduleData->id : 0 }}" />

        <label class="text-sm text text-info more_images_label"><i class="fas fa-image" aria-hidden="true"></i> More Images (<em>Max :</em> {{ getMaxUploadSize() }} MB)</label>


        <div class="m-2 row more_images" style="display:none;">
            <div class="mb-3 col-md-12 before_after_not_have_two_images">
                <input class="form-control" id="uploadFile" multiple="" name="uploadFile[]" type="file" 
                    onchange="uploadModuleDataImages();" />
                <div class="text-danger"><em>Max :</em> {{ getMaxUploadSize() }} MB</div>
                <div id="image_preview" class="row"></div>
            </div>
            <div class="mb-3 col-md-12">
                <input type="checkbox" name="isBeforeAfter" id="isBeforeAfter" value="1"
                    style="width: 15px; height:15px;" onclick="toggle_before_after_have_two_images();"
                    {{ old('isBeforeAfter', 0) == 1 ? 'checked' : '' }} /> <b>Is Before After?</b>
            </div>
            <div class="mb-3 col-md-12" id="is_before_after_have_two_images" style="display: none;">
                <label>Is Before After Have Two Images?</label>
                <input type="radio" name="isBeforeAfterHaveTwoImages" value="1" style="width: 15px; height:15px;"
                    onclick="show_before_after_have_two_images();"
                    {{ old('isBeforeAfterHaveTwoImages', 0) == 1 ? 'checked' : '' }} />
                <b>Yes</b>
                <input type="radio" name="isBeforeAfterHaveTwoImages" value="0"
                    {{ old('isBeforeAfterHaveTwoImages', 0) == 0 ? 'checked' : '' }} style="width: 15px; height:15px;"
                    onclick="hide_before_after_have_two_images();" />
                <b>No</b>
            </div>
            <div class="mb-3 col-md-12 before_after_have_two_images" style="display: none;">
                <label>Before Image</label>
                <input class="form-control" id="image_name" name="image_name" type="file" onchange="uploadModuleDataImages();"/>
                <div class="text-danger"><em>Max :</em> {{ getMaxUploadSize() }} MB</div>
                <div id="before_image_preview" class="row"></div>
            </div>
            <div class="mb-3 col-md-12 before_after_have_two_images" style="display: none;">
                <label>After Image</label>
                <input class="form-control" id="image_name2" name="image_name2" type="file" onchange="uploadModuleDataImages();"/>
                <div class="text-danger"><em>Max :</em> {{ getMaxUploadSize() }} MB</div>
                <div id="after_image_preview" class="row"></div>
            </div>
            <div class="col-md-12">
                <div class="spinner-border text-primary" role="status" id="moreImageLoader" style="display:none;">
                    <span class="visually-hidden">Uploading...</span>
                </div>
            </div>
        </div>
        <div class="m-2 row sortable_row more_images" id="moreImages" style="display:none;">
            @foreach($moduleDataImages as $image)
                @include('back.module.module_data_images.module_data_images_html_sub', ['folder'=>'module/' . $module->type, 'image'=>$image])
            @endforeach
        </div>
    </div>
</div>
