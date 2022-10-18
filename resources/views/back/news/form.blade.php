<input type="hidden" value="{{ $newsObj->id }}" name="id">
<div class="col-md-12 mb-3">
    <label class="form-label">Title:*</label>
    <input id="title" name="title" value="{{ old('title', $newsObj->title) }}" type="text"
        class="form-control {{ hasError($errors, 'title') }}" placeholder="Title">
    {!! showErrors($errors, 'title') !!}
</div>
<div class="col-md-12 mb-3">
    <label class="form-label">Description:*</label>
    <textarea name="description" id="description" class="form-control {{ hasError($errors, 'description') }}"
        placeholder="Description">{{ old('description', $newsObj->description) }}</textarea>
    {!! showErrors($errors, 'description') !!}
</div>
<div class="col-md-12 mb-3">
    <label class="form-label">Date-Time:*</label>
    <input id="news_date_time" name="news_date_time" value="{{ old('news_date_time', $newsObj->news_date_time) }}" type="text"
        class="form-control {{ hasError($errors, 'news_date_time') }}" placeholder="Date-Time">
    {!! showErrors($errors, 'news_date_time') !!}
</div>
<div class="col-md-12 mb-3">
    <label class="form-label">Location:*</label>
    <input id="location" name="location" value="{{ old('location', $newsObj->location) }}" type="text"
        class="form-control {{ hasError($errors, 'location') }}" placeholder="Location">
    {!! showErrors($errors, 'location') !!}
</div>
<div class="col-md-12 mb-3">
    <label>Has Registration Link:*</label>
    <select class="form-control" name="has_registration_link" id="has_registration_link">
        {!! generateNewsHasRegistrationLinkDropDown($newsObj->has_registration_link, false) !!}
    </select>
</div>
<div class="col-md-12 mb-3">
    <label class="form-label">Registration Link:</label>
    <input id="registration_link" name="registration_link"
        value="{{ old('registration_link', $newsObj->registration_link) }}" type="text"
        class="form-control {{ hasError($errors, 'registration_link') }}" placeholder="Registration Link">
    {!! showErrors($errors, 'registration_link') !!}
</div>
<div class="col-md-12 mb-3">
    <label class="form-label">News Link:</label>
    <input id="news_link" name="news_link" value="{{ old('news_link', $newsObj->news_link) }}" type="text"
        class="form-control {{ hasError($errors, 'news_link') }}" placeholder="News Link">
    {!! showErrors($errors, 'news_link') !!}
</div>
<div class="col-md-12 mb-3">
    <label>Is Third Party Link?*</label>
    <select class="form-control" name="is_third_party_link" id="is_third_party_link">
        {!! generateNewsIsThirdPartyLinkDropDown($newsObj->is_third_party_link, false) !!}
    </select>
</div>
<div class="col-md-12 mb-4">
    <img src="{!! App\Helpers\ImageUploader::print_image_src($newsObj->image, 'news/thumb') !!}" id="selected_image_preview"
        style="max-width:165px !important; max-height:165px !important;" />
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
    <label class="form-label">Image Title:*</label>
    <input id="image_title" name="image_title" value="{{ old('image_title', $newsObj->image_title) }}" type="text"
        class="form-control {{ hasError($errors, 'image_title') }}" placeholder="Image Title">
    {!! showErrors($errors, 'image_title') !!}
</div>
<div class="col-md-12 mb-3">
    <label class="form-label">Image Alt:*</label>
    <input id="image_alt" name="image_alt" value="{{ old('image_alt', $newsObj->image_alt) }}" type="text"
        class="form-control {{ hasError($errors, 'image_alt') }}" placeholder="Image Alt">
    {!! showErrors($errors, 'image_alt') !!}
</div>
<div class="col-md-12 mb-3">
    <label>Is hide event after date?*</label>
    <select class="form-control" name="is_hide_event_after_date" id="is_hide_event_after_date">
        {!! generateIsHideEventAfterDateDropDown($newsObj->is_hide_event_after_date, false) !!}
    </select>
</div>
<div class="col-md-12 mb-3">
    <label>Is Featured?*</label>
    <select class="form-control" name="is_featured" id="is_featured">
        {!! generateNewsIsFeaturedDropDown($newsObj->is_featured, false) !!}
    </select>
</div>
<div class="col-md-12 mb-3">
    <label>Status:*</label>
    <select class="form-control" name="status" id="status">
        {!! generateNewsStatusDropDown($newsObj->status, false) !!}
    </select>
</div>

@section('beforeBodyClose')
    <script>
        $(document).ready(function() {
            CKEDITOR.replace('description');
            CKEDITOR.config.allowedContent = true;
            CKEDITOR.config.autoParagraph = false;
        });
        $(document).ready(function() {
            $("#news_date_time").datetimepicker({
                format:'Y-m-d H:i:s'
            });
        });
    </script>
@endsection
