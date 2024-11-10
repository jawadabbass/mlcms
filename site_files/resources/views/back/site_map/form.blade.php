<input type="hidden" value="{{ $siteMapObj->id }}" name="id">
<div class="form-group">
    <label>Parent Category</label>
    <select class="form-control {{ hasError($errors, 'parent_id') }}" name="parent_id">
        {!! generateParentSiteMapsDropDown($siteMapObj->parent_id, true) !!}
    </select>
    {!! showErrors($errors, 'parent_id') !!}
</div>
<div class="form-group">
    <label for="title">Title</label>
    <input type="text" class="form-control" id="title" name="title" value="{{ $siteMapObj->title }}">
    @error('title')
        <span class="text-danger">{{ $message }}</span>
    @enderror
</div>
<div class="form-group">
    <label for="link">Link</label>
    <input type="text" class="form-control" id="link" name="link" value="{{ $siteMapObj->link }}">
    @error('link')
        <span class="text-danger">{{ $message }}</span>
    @enderror
</div>
<div class="form-group">
    <label for="is_link_internal">Is link internal?</label>
    <select class="form-control" name="is_link_internal" id="is_link_internal">
        {!! generateSiteMapIsLinkInternalDropDown($siteMapObj->is_link_internal, false) !!}
    </select> @error('is_link_internal')
        <span class="text-danger">{{ $message }}</span>
    @enderror
</div>
<div class="form-group">
    <label for="status">Status</label>
    <select class="form-control" name="status" id="status">
        {!! generateSiteMapStatusDropDown($siteMapObj->status, false) !!}
    </select> @error('status')
        <span class="text-danger">{{ $message }}</span>
    @enderror
</div>
