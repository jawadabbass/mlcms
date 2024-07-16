<div data-role="panel" id="right-panel" data-display="push" data-position="right" data-theme="c">
    <!-- Phone Number -->
    <?php $settingInformation = settingInfo(); ?>
    <div class="r-phone"><a href="tel:<?php echo str_replace('-', '', $settingInformation['telephone']); ?>"><i class="fa fa-phone-square fa-2x"></i> <?php echo $settingInformation['telephone']; ?></a>
    </div>
    <!-- Contact Info Starts -->
    <div class="r-contact-info">
        <i class="fa fa-envelope fa-2x"></i><span class="heading">CONTACT US</span><br><br>
        <i class="fa fa-location-arrow"></i>&nbsp;&nbsp;<strong>Scofield</strong><br>
        <?php echo preg_replace('/<p[^>]*>(.*)<\/p[^>]*>/i', '$1', $settingInformation['address']); ?>
        <i class="fa fa-envelope-o"></i>&nbsp;&nbsp;<a href="sms:<?php echo str_replace('-', '', $settingInformation['telephone']); ?>">SMS Message</a> <br>
        <i class="fa fa-phone"></i>&nbsp;&nbsp;<a href="tel:<?php echo str_replace('-', '', $settingInformation['telephone']); ?>"><?php echo $settingInformation['telephone']; ?></a> <br>
        <i class="fa fa-envelope"></i>&nbsp;&nbsp;<a href="mailto:<?php echo $settingInformation['email']; ?>"
            target="_blank"><?php echo $settingInformation['email']; ?></a>
    </div>
    <!-- Contact Info Ends -->
    <!-- Social Icons Starts -->
    <div class="r-social-icons">
        <ul>
            <?php echo social_media(); ?>
            <!--                        <li><img src="<?php echo front_sources(); ?>images/icons/social-icons/fb.png" width="36" height="36"></li>
                        <li><img src="<?php echo front_sources(); ?>images/icons/social-icons/twitter.png" width="36" height="36"></li>-->
        </ul>
    </div>
    <!-- Social Icons Ends -->
    <!-- Social Like Buttons-->
    <div class="ui-grid-b social-like">
        <!-- Facebook Like Button -->
        <!-- /Facebook Like Button -->
        <!--Google Plus Button-->
        <!--/Google Plus Button-->
        <!-- Twitter Like Button -->
        <!-- /Twitter Like Button -->
    </div>
    <!-- /Social Like Buttons-->
</div>
