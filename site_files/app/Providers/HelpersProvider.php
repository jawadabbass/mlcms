<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class HelpersProvider extends ServiceProvider
{
    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        require_once app_path() . '/Helpers/admin_only_helper.php';
        require_once app_path() . '/Helpers/design_helper.php';
        require_once app_path() . '/Helpers/my_captcha_helper.php';
        require_once app_path() . '/Helpers/mysite_helper.php';
        require_once app_path() . '/Helpers/system_helper.php';
        require_once app_path() . '/Helpers/DashboardLinks.php';
        require_once app_path() . '/Helpers/mod_builder_helper.php';
        require_once app_path() . '/Helpers/common_functions.php';
        require_once app_path() . '/Helpers/my_helper.php';
    }
}
