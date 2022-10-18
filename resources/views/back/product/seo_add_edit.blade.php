<!-- /.SEO module add here ... -->
<div>
    <a onclick="seoEditModulToggle();" href="javascript:void(0)">Manage SEO</a>
</div>
<div id="seo-edit-modul" class="seo-edit-modul-hide">
    <div>
        <label class="form-label">Meta Title (<i>Max:</i>
            <span id="edit_char_countdown">55 characters</span>)
            <?php echo helptooltip('seo_title'); ?>
        </label>
        <input type="text" name="meta_title" class="form-control"
            onKeyUp="limit_text('meta_title', 55, 'edit_char_countdown');" placeholder="Meta Title">
        <span id="meta_title" style="padding-left:2px;" class="err"></span>
    </div>
    <div>
        <label class="form-label">Meta Keywords <?php echo helptooltip('seo_keywords'); ?></label>
        <textarea name="meta_keywords" rows="3" cols="70"></textarea>
        <span id="meta_keywords" style="padding-left:2px;" class="err"></span>
    </div>
    <div>
        <label class="form-label">Meta Description <?php echo helptooltip('seo_descp'); ?></label>
        <textarea name="meta_description" rows="3" cols="70"></textarea>
        <span id="meta_description" style="padding-left:2px;" class="err"></span>
    </div>
    <div>
        <label class="form-label">Canonical URL <?php echo helptooltip('canonical_url'); ?></label>
        <textarea name="canonical_url" rows="3" cols="70"></textarea>
        <span id="canonical_url" style="padding-left:2px;" class="err"></span>
    </div>
</div>
