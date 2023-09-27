<!-- /.SEO module add here ... -->
<div style="clear:both"></div>
<div class="mb-2">
    <input type="button" onclick="seoModulToggle();" value="Manage SEO" class="btn btn-primary">
</div>
<div id='seo-modul' class="seo-modul-hide">
    <div class="mb-2">
        <label class="form-label">Meta Title (<i>Max:</i> <span id="char_countdown">55 characters</span>)@php echo helptooltip('seo_title')@endphp</label>
        <input type="text" class="form-control" id="meta_title"
            onKeyUp="limit_text('meta_title',55 ,'char_countdown');" name="meta_title" placeholder="Meta Title">
    </div>
    <div class="mb-2">
        <label class="form-label">Meta Keywords @php echo helptooltip('seo_keywords')@endphp</label>
        <textarea name="meta_keywords" id="meta_keywords" class="form-control" rows="3" cols="70"></textarea>
    </div>
    <div class="mb-2">
        <label class="form-label">Meta Description @php echo helptooltip('seo_descp')@endphp</label>
        <textarea name="meta_description" id="meta_description" class="form-control" rows="3" cols="70"></textarea>
    </div>
    <div class="mb-2">
        <label class="form-label">Canonical URL @php echo helptooltip('canonical_url')@endphp</label>
        <textarea name="canonical_url" id="canonical_url" class="form-control" rows="3" cols="70"></textarea>
    </div>
</div>
<!-- /.SEO module end here ... -->
