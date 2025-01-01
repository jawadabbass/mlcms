@php
    $strlen_meta_title = strlen($blogPostObj->meta_title);
    $strlen_meta_keywords = strlen($blogPostObj->meta_keywords);
    $strlen_meta_description = strlen($blogPostObj->meta_description);
    $strlen_canonical_url = strlen($blogPostObj->canonical_url);
@endphp
<input type="hidden" value="{{ $blogPostObj->id }}" name="id">
<div class="mb-3 col-md-12">
    <label class="form-label">Title:*</label>
    <input id="title" name="title" value="{{ old('title', $blogPostObj->title) }}" type="text"
        class="form-control {{ hasError($errors, 'title') }}" placeholder="Title">
    {!! showErrors($errors, 'title') !!}
</div>
<div class="mb-3 col-md-12">
    <label class="form-label">Slug:*</label>
    <input id="post_slug" name="post_slug" value="{{ old('post_slug', $blogPostObj->post_slug) }}" type="text"
        class="form-control {{ hasError($errors, 'post_slug') }}" placeholder="Slug">
    {!! showErrors($errors, 'post_slug') !!}
</div>
<div class="mb-3 col-md-12">
    <label class="form-label">Description:*</label>
    <textarea name="description" id="description" class="form-control {{ hasError($errors, 'description') }}"
        placeholder="Description">{{ old('description', $blogPostObj->description) }}</textarea>
    {!! showErrors($errors, 'description') !!}
</div>
<div class="mb-3 col-md-12">
    <label class="form-label">Date:*</label>
    <input id="dated" name="dated" value="{{ old('dated', $blogPostObj->dated) }}" type="text"
        class="form-control {{ hasError($errors, 'dated') }}" placeholder="Date">
    {!! showErrors($errors, 'dated') !!}
</div>
<div class="mb-4 col-md-12">
    <img src="{!! App\Helpers\ImageUploader::print_image_src($blogPostObj->featured_img, 'blog/thumb') !!}" id="selected_image_preview"
        style="max-width:165px !important; max-height:165px !important;" />
</div>
<div class="mb-4 col-md-12">
    <label for="image">Featured Image:*</label>
    <div class="input-group form-control {{ hasError($errors, 'featured_img') }}">
        <div class="custom-file">
            <input type="file" class="custom-file-input" id="selected_image" name="featured_img">
            <label class="custom-file-label"
                for="featured_img">{{ 'Maximum allowed image size: ' . getMaxUploadSize() . 'MB' }}</label>
        </div>
    </div>
    {!! showErrors($errors, 'featured_img') !!}
</div>
<div class="mb-3 col-md-12">
    <label class="form-label">Image Title:*</label>
    <input id="image_title" name="image_title" value="{{ old('image_title', $blogPostObj->image_title) }}"
        type="text" class="form-control {{ hasError($errors, 'image_title') }}" placeholder="Image Title">
    {!! showErrors($errors, 'image_title') !!}
</div>
<div class="mb-3 col-md-12">
    <label class="form-label">Image Alt:*</label>
    <input id="image_alt" name="image_alt" value="{{ old('image_alt', $blogPostObj->image_alt) }}" type="text"
        class="form-control {{ hasError($errors, 'image_alt') }}" placeholder="Image Alt">
    {!! showErrors($errors, 'image_alt') !!}
</div>
<div class="mb-3 form-group">
    <label class="form-label">Make Follow</label>
    <input id="show_follow_rel_1" value="1" type="radio" name="show_follow"
        value="{{ $blogPostObj->show_follow }}" {{ $blogPostObj->show_follow == 1 ? 'checked' : '' }} />
    @php echo helptooltip('follow') @endphp <br />
    <label class="form-label">Make No Follow</label>
    <input id="show_follow_rel_0" value="0" type="radio" name="show_follow"
        value="{{ $blogPostObj->show_follow }}" {{ $blogPostObj->show_follow == 0 ? 'checked' : '' }} />
</div>
<div class="mb-3 form-group">
    <label class="form-label">Indexing</label>
    <input id="show_index_rel_1" value="1" type="radio" name="show_index" value="{{ $blogPostObj->show_index }}"
        {{ $blogPostObj->show_index == 1 ? 'checked' : '' }} />
    @php echo helptooltip('indexing') @endphp <br />
    <label class="form-label">No Indexing</label>
    <input id="show_index_rel_0" value="0" type="radio" name="show_index" value="{{ $blogPostObj->show_index }}"
        {{ $blogPostObj->show_index == 0 ? 'checked' : '' }} />
</div>
<div class="mb-3 form-group">
    <label class="form-label">Meta Title (<i class="text-primary">Recommended: 60 characters</i>)
        @php echo helptooltip('seo_title')@endphp </label>
    <input type="text" name="meta_title" id="meta_title" value="{{ $blogPostObj->meta_title }}" class="form-control"
        placeholder="Meta Title" onKeyUp="seo_limit_suggestion('meta_title', 60, 'meta_title_char_countdown');">
    <span id="meta_title_char_countdown"
        class="{{ $strlen_meta_title > 60 ? 'text-danger' : 'text-success' }}">{{ $strlen_meta_title }}
        characters</span>
</div>
<div class="mb-3 form-group">
    <label class="form-label">Meta Keywords (<i class="text-primary">Recommended: 160 characters</i>)
        @php echo helptooltip('seo_keywords')@endphp</label>
    <textarea style="height: 100px !important;" class="form-control" rows="3" cols="70" name="meta_keywords"
        id="meta_keywords" onKeyUp="seo_limit_suggestion('meta_keywords', 160, 'meta_keywords_char_countdown');">{{ $blogPostObj->meta_keywords }}</textarea>
    <span id="meta_keywords_char_countdown"
        class="{{ $strlen_meta_keywords > 160 ? 'text-danger' : 'text-success' }}">{{ $strlen_meta_keywords }}
        characters</span>
</div>
<div class="mb-3 form-group">
    <label class="form-label">Meta Description(<i class="text-primary">Recommended: 160
            characters</i>) @php echo helptooltip('seo_descp')@endphp</label>
    <textarea style="height: 100px !important;" class="form-control" rows="3" cols="70"
        name="meta_description" id="meta_description"
        onKeyUp="seo_limit_suggestion('meta_description', 160, 'meta_description_char_countdown');">{{ $blogPostObj->meta_description }}</textarea>
    <span id="meta_description_char_countdown"
        class="{{ $strlen_meta_description > 160 ? 'text-danger' : 'text-success' }}">{{ $strlen_meta_description }}
        characters</span>
</div>
<div class="mb-3 form-group">
    <label class="form-label">Canonical URL @php echo helptooltip('canonical_url')@endphp</label>
    <textarea style="height: 100px !important;" class="form-control" rows="3" cols="70" name="canonical_url"
        id="canonical_url">{{ $blogPostObj->canonical_url }}</textarea> <code>If Canonical URL is same as Page URL then Leave this field empty,
        in this case Canonical URL will be handled programmatically</code>
</div>
<div class="mb-3 col-md-12">
    <label>Status:*</label>
    <select class="form-control" name="sts" id="sts">
        {!! generateBlogPostStatusDropDown($blogPostObj->sts, false) !!}
    </select>
</div>

@section('beforeBodyClose')
    <script>
        $(document).ready(function() {
            $("#dated").datetimepicker({
                format: 'Y-m-d H:i:s'
            });
        });
        $(document).ready(function(e) {
            $("#title").change(function() {
                string_to_slug('title', 'post_slug');
            });
            $("#post_slug").change(function() {
                check_slug('post_slug');
            });
        });
    </script>
@endsection
