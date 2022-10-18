<!-- /.SEO module add here ... -->
<div>
    <br /><a onclick="showme_seo('#seo-edit-modul',this);" href="javascript:;">Manage SEO <i
            class="fa-solid fa-angle-double-down" aria-hidden="true"></i></a>
</div>
<div id="seo-edit-modul" class="seo-edit-modul-hide">
    <div>
        <label class="form-label">Meta Title(<i>Max:</i>
            <span id="edit_char_countdown">70 characters</span>)
            @php echo helptooltip('seo_title')@endphp
        </label>
        <input type="text" name="meta_title" class="form-control" id="char_countdown"
            onKeyUp="limit_text('char_countdown',70,'edit_char_countdown');" placeholder="Meta Title">
        <span id="meta_title" style="padding-left:2px;" class="err"></span>
    </div>
    <div>
        <label class="form-label">Meta Keywords @php echo helptooltip('seo_keywords')@endphp</label>
        <textarea name="meta_keywords" class="form-control" rows="3" cols="70"></textarea>
        <span id="meta_keywords" style="padding-left:2px;" class="err"></span>
    </div>
    <div>
        <label class="form-label">Meta Description @php echo helptooltip('seo_descp')@endphp</label>
        <textarea name="meta_description" class="form-control" rows="3" cols="70"></textarea>
        <span id="meta_description" style="padding-left:2px;" class="err"></span>
    </div>
    <div>
        <label class="form-label">Canonical URL @php echo helptooltip('canonical_url')@endphp</label>
        <textarea name="canonical_url" class="form-control" rows="3" cols="70"></textarea>
        <span id="canonical_url" style="padding-left:2px;" class="err"></span>
    </div>
</div>
<!-- /.SEO module end here ... -->
