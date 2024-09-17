<div class="row" style="display:{{ $module->show_feature_img_field == 1 ? 'block' : 'none' }}">
    <div class="col-md-12">
        <hr/>
        <input type="hidden" name="session_id" value="{{ session()->getId() }}" />
        <input type="hidden" name="module_data_id" value="{{ isset($moduleData)? $moduleData->id:0 }}" />

        <label class="btn btn-primary more_images_label">More Images (<em>Max :</em> {{ getMaxUploadSize() }} MB)</label>
        <div class="row more_images m-2" style="display:none;">
            <div class="col-md-10">
                <input class="form-control" id="uploadFile" multiple="" name="uploadFile[]" type="file"
                    onchange="uploadModuleDataImages();" />
            </div>
            <div class="col-md-2">
                <div class="spinner-border text-primary" role="status" id="moreImageLoader" style="display:none;">
                    <span class="visually-hidden">Loading...</span>
                </div>
            </div>
        </div>
        <div class="row sortable_row more_images m-2" id="moreImages" style="display:none;">
            @if(isset($moduleDataImages))
            @foreach ($moduleDataImages as $image)
                {!! generateModuleDataImageHtml('module/'.$module->type, $image) !!}
            @endforeach
            @endif
        </div>
        <hr/>
    </div>
</div>
