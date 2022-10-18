<ul class="nav nav-pills nav-stacked user_menu">
    <li class="<?= $menu == 'profile' ? 'active' : '' ?>"><a href="<?php echo base_url('profile'); ?>">Profile</a></li>
    <li class="<?= $menu == 'password' ? 'active' : '' ?>"><a href="<?php echo base_url('profile/password'); ?>">Change Password</a></li>
    <li class="<?= $menu == 'payment' ? 'active' : '' ?>"><a href="<?php echo base_url('profile/payment/1'); ?>">Payment Settings</a></li>
    <li><a href="<?php echo base_url('profile/logout'); ?>">Logout</a></li>
</ul>
