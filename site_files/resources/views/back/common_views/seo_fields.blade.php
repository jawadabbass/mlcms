@php
    $meta_title = $meta_title ?? '';
    $meta_keywords = $meta_keywords ?? '';
    $meta_description = $meta_description ?? '';
    $canonical_url = $canonical_url ?? '';

    $strlen_meta_title = strlen($meta_title);
    $strlen_meta_keywords = strlen($meta_keywords);
    $strlen_meta_description = strlen($meta_description);
    $strlen_canonical_url = strlen($canonical_url);
@endphp
<!-- /.SEO module add here ... -->
<div style="clear:both"></div>
<div>
    <label onclick="show_hide_seo_fields('#seo_fields_div',this);" class="text text-info">Manage SEO <i
            class="fas fa-angle-double-down" aria-hidden="true"></i></label>
</div>
<div id="seo_fields_div"
    style="display: none;">
    <div>
        <label class="mt-2 form-label">Meta Title (<i class="text-primary">Recommended: 60 characters</i>)
            <?php echo helptooltip('meta_title'); ?>
        </label>
        <input type="text" name="meta_title" id="meta_title" value="{{ $meta_title }}" class="form-control"
            onKeyUp="seo_limit_suggestion('meta_title', 60, 'meta_title_char_countdown');" placeholder="Meta Title">
        <span id="meta_title_char_countdown"
            class="{{ $strlen_meta_title > 60 ? 'text-danger' : 'text-success' }}">{{ $strlen_meta_title }}
            characters</span>
        <span id="meta_title_error" style="padding-left:2px;" class="err"></span>
    </div>
    <div>
        <label class="mt-2 form-label">Meta Keywords (<i class="text-primary">Recommended: 160 characters</i>)
            <?php echo helptooltip('meta_keywords'); ?></label>
        <textarea class="form-control" name="meta_keywords" id="meta_keywords" rows="3"
            onKeyUp="seo_limit_suggestion('meta_keywords', 160, 'meta_keywords_char_countdown');">{{ $meta_keywords }}</textarea>
        <span id="meta_keywords_char_countdown"
            class="{{ $strlen_meta_keywords > 160 ? 'text-danger' : 'text-success' }}">{{ $strlen_meta_keywords }}
            characters</span>
        <span id="meta_keywords_err" style="padding-left:2px;" class="err"></span>
    </div>
    <div>
        <label class="mt-2 form-label">Meta Description (<i class="text-primary">Recommended: 160 characters</i>)
            <?php echo helptooltip('meta_description'); ?></label>
        <textarea name="meta_description" id="meta_description" class="form-control" rows="3"
            onKeyUp="seo_limit_suggestion('meta_description', 160, 'meta_description_char_countdown');">{{ $meta_description }}</textarea>
        <span id="meta_description_char_countdown"
            class="{{ $strlen_meta_description > 160 ? 'text-danger' : 'text-success' }}">{{ $strlen_meta_description }}
            characters</span>
        <span id="meta_description_err" style="padding-left:2px;" class="err"></span>
    </div>
    <div>
        <label class="mt-2 form-label">Canonical URL @php echo helptooltip('canonical_url')@endphp</label>
        <textarea name="canonical_url" id="canonical_url" class="form-control" rows="3" cols="70">{{ $canonical_url }}</textarea>
        <span id="canonical_url_err" style="padding-left:2px;" class="err"></span>
        <code>If Canonical URL is same as Page URL then Leave this field empty, in this case Canonical URL will be handled programmatically</code>
    </div>
</div>
<div style="clear:both"></div>
<!-- /.SEO module end here ... -->
