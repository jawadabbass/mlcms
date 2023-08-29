<div>
    <div class="view-more-icon"><a href="#" rel="external"><img
                src="<?php echo front_sources(); ?>images/icons/detail-icon.png"></a></div>
    <h1 class="icon-heading">TESTIMONIALS</h1>
    <div id="testimonials" class="owl-carousel">
        <?php if(count($home_testimonials) > 0):?>
        <?php foreach ($home_testimonials as $testimonialsValues):?>
        <div class="item">
            <?php echo $testimonialsValues->details; ?>
            <strong style="clear: both;"><?php echo $testimonialsValues->name; ?>,<?php echo $testimonialsValues->company_name; ?>, <?php echo $testimonialsValues->designation; ?></strong>
        </div>
        <?php endforeach;?>
        <?php endif;?>
    </div>
</div>
