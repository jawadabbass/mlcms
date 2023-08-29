    <div class="fm-banner">
        <div id="main" role="main" class="slider">
            <div class="flexslider">
                <ul class="slides">
                    <?php if(count($banners) > 0):
                        foreach($banners as $bannerValue): ?>
                    <li><img style='max-height: 225px;' src="<?php echo upload_url() . 'public/uploads/banners/' . $bannerValue->banner_name; ?>" alt="<?php echo $bannerValue->alt_tag; ?>"></li>
                    <?php endforeach; endif; ?>
                    <div style="clear:both;"></div>
                </ul>
            </div>
        </div>
    </div>
