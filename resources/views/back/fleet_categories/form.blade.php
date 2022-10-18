<input type="hidden" value="{{$fleetCategoryObj->id}}" name="id">
<div class="col-md-12 mb-3">
    <label class="form-label">Title:*</label>
    <input id="title" name="title" value="{{ old('title', $fleetCategoryObj->title) }}"
        type="text" class="form-control {{ hasError($errors, 'title') }}" placeholder="Title">
    {!! showErrors($errors, 'title') !!}
</div>
<div class="col-md-12 mb-3">
    <label class="form-label">Description:*</label>
    <textarea name="description" id="description" class="form-control {{ hasError($errors, 'description') }}" placeholder="Description">{{ old('description', $fleetCategoryObj->description) }}</textarea>
    {!! showErrors($errors, 'description') !!}
</div>
<div class="col-md-12 mb-4">
    <img src="{!! App\Helpers\ImageUploader::print_image_src($fleetCategoryObj->image, 'fleet_categories/thumb') !!}" id="selected_image_preview" style="max-width:165px !important; max-height:165px !important;"/>
</div>
<div class="col-md-12 mb-4">
    <label for="image">Image:*</label>
    <div class="input-group form-control {{ hasError($errors, 'image') }}">
        <div class="custom-file">
            <input type="file" class="custom-file-input" id="selected_image" name="image">
            <label class="custom-file-label"
                for="image">{{ 'Maximum allowed image size: ' . getMaxUploadSize() . 'MB' }}</label>
        </div>
    </div>
    {!! showErrors($errors, 'image') !!}
</div>
<div class="col-md-12 mb-3">
    <label>Status</label>
    <select class="form-control" name="status" id="status">
        {!! generateFleetCategoriesStatusDropDown($fleetCategoryObj->status, false) !!}
    </select>
</div>

@section('beforeBodyClose')
    <script>
        $(document).ready(function() {
            CKEDITOR.replace('description');
            CKEDITOR.config.allowedContent = true;
            CKEDITOR.config.autoParagraph = false;
        });
    </script>
@endsection