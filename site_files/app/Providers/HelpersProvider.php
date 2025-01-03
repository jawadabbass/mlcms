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
        require_once app_path() . '/Helpers/service_helper.php';
        require_once app_path() . '/Helpers/site_map_helper.php';
        require_once app_path() . '/Helpers/city_state_country_helper.php';
        require_once app_path() . '/Helpers/metadata_helper.php';
        require_once app_path() . '/Helpers/image_uploader_helper.php';
        require_once app_path() . '/Helpers/module_helper.php';
        require_once app_path() . '/Helpers/dropdown_helper.php';
        require_once app_path() . '/Helpers/news_helper.php';
        require_once app_path() . '/Helpers/error_helper.php';
        require_once app_path() . '/Helpers/seo_helper.php';
        require_once app_path() . '/Helpers/lead_stat_helper.php';
        require_once app_path() . '/Helpers/blog_helper.php';
        require_once app_path() . '/Helpers/blog_categories_helper.php';
    }
}
