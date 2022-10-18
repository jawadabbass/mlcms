<!-- /.SEO module add here ... -->
<div style="clear:both"></div>
<div class="mb-2">
    <input type="button" onclick="showme_seo('#seo-edit-modul',this);" value="Manage SEO" class="btn btn-primary">
</div>
<div id='seo-edit-modul' class="seo-edit-modul-hide">
    <div class="mb-2">
        <label class="form-label">Meta Title (<i>Max:</i> <span id="edit_char_countdown">55 characters</span>)@php echo helptooltip('seo_title') @endphp</label>
        <input type="text" class="form-control" id="edit_meta_title"
            onKeyUp="limit_text('edit_meta_title',55 ,'edit_char_countdown');" name="edit_meta_title"
            placeholder="Meta Title">
    </div>
    <div class="mb-2">
        <label class="form-label">Meta Keywords @php echo helptooltip('seo_keywords')@endphp</label>
        <textarea name="edit_meta_keywords" class="form-control" id="edit_meta_keywords" rows="3" cols="70"></textarea>
    </div>
    <div class="mb-2">
        <label class="form-label">Meta Description @php echo helptooltip('seo_descp')@endphp</label>
        <textarea id="edit_meta_description" class="form-control" name="edit_meta_description" rows="3" cols="70"></textarea>
    </div>
    <div class="mb-2">
        <label class="form-label">Canonical URL @php echo helptooltip('canonical_url')@endphp</label>
        <textarea name="edit_canonical_url" id="edit_canonical_url" class="form-control" rows="3" cols="70"></textarea>
    </div>
</div>
<!-- /.SEO module end here ... -->
