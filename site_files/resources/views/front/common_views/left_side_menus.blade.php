<div data-role="panel" id="left-panel" data-theme="b" style="background:#cc3333">
    <div class="sidebar-header">
        <a href="#"><i class="fa fa-phone"></i></a>
        <a href="#"><i class="fa fa-comment"></i></a>
        <a href="#"><i class="fa fa-facebook"></i></a>
        <a href="#"><i class="fa fa-twitter"></i></a>
        <div class="clear"></div>
    </div>
    <div class="sidebar-logo"></div>
    <div class="sidebar-divider">
        Navigation
    </div>
    <!-- Main Menu Starts -->
    <div id="accordion">
        <ul id="items">
            <li>
                <a href="<?php echo base_url(); ?>" rel="external">Home</a>
                <!--                            <ul class="sub-items">
                                <li>
                                    <a href="#" rel="external" class="ui-link">- PHOTO GALLERY</a>
                                </li>
                                <li>
                                    <a href="#" rel="external" class="ui-link">- VIDEO GALLERY</a>
                                </li>
                                <li>
                                    <a href="#" rel="external" class="ui-link">- PORTFOLIO GALLERY</a>
                                </li>
                            </ul>-->
            </li>
            <?php echo front_menu_display(); ?>
            <li><a href="<?php echo base_url(); ?>about_us" rel="external">About Us</a></li>
            <!--                        <li><a href="#" rel="external">Stains &amp; Dyes</a></li>
                        <li><a href="#" rel="external">Integral Colors</a></li>
                        <li><a href="#" rel="external">Patterns &amp; Textures</a></li>
                        <li><a href="#" rel="external">Polished Concrete</a></li>
                        <li><a href="#" rel="external">Color Hardener</a></li>
                        <li><a href="#" rel="external">Sealers</a></li>
                        <li><a href="#" rel="external">Contact Us</a></li>-->
        </ul>
    </div>
    <!-- Main Menu Ends -->
    <div class="sidebar-divider">
        Copyright 2015. All rights reserved.
    </div>
    <!-- Main Menu Ends -->
</div>
