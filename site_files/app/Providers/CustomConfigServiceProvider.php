<?php
namespace App\Providers;
use App\Models\Back\Metadata;
use App\Models\Back\Setting;
use Illuminate\Support\ServiceProvider;
class CustomConfigServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        $settings = Setting::first();
        $paypal_live_client_id = Metadata::where('data_key', 'paypal_live_client_id')->first()->val1;
        $paypal_sandbox_client_id = Metadata::where('data_key', 'paypal_sandbox_client_id')->first()->val1;
        $paypal_live_secret = Metadata::where('data_key', 'paypal_live_secret')->first()->val1;
        $paypal_sandbox_secret = Metadata::where('data_key', 'paypal_sandbox_secret')->first()->val1;
        $paypal_mode = Metadata::where('data_key', 'paypal_mode')->first()->val1;
        $paypal_client_id = ($paypal_mode == 'live') ? $paypal_live_client_id : $paypal_sandbox_client_id;
        $paypal_secret = ($paypal_mode == 'live') ? $paypal_live_secret : $paypal_sandbox_secret;
        $paypal = [
            'client_id' => $paypal_client_id,
            'secret' => $paypal_secret,
            'settings' => [
                'mode' => $paypal_mode,
                'http.ConnectionTimeOut' => 1000,
                'log.LogEnabled' => true,
                'log.FileName' => storage_path() . '/logs/paypal.log',
                'log.LogLevel' => 'FINE',
            ],
        ];
        $this->app['config']['paypal'] = $paypal;
        /*********************** */
        /*********************** */
        $recaptcha_site_key = Metadata::where('data_key', 'recaptcha_site_key')->first()->val1;
        $recaptcha_secret_key = Metadata::where('data_key', 'recaptcha_secret_key')->first()->val1;
        $recaptcha = [
            'siteKey' => $recaptcha_site_key,
            'secretKey' => $recaptcha_secret_key,
        ];
        $this->app['config']['recaptcha'] = $recaptcha;
        /*********************** */
        /*********************** */
        $siteMailSettings = [
            'from_address' => $settings->email_from_address,
            'from_name' => $settings->email_from_name,
            'to_address' => $settings->email_to_address,
            'to_name' => $settings->email_to_name,
        ];
        $this->app['config']['site_email'] = $siteMailSettings;
        /*********************** */
        /*********************** */
        $siteContactSettings = [
            'business_name' => $settings->business_name,
            'working_days' => $settings->working_days,
            'working_hours' => $settings->working_hours,
            'telephone' => $settings->telephone,
            'address' => $settings->address,
            'email' => $settings->email,
            'mobile' => $settings->mobile,
            'fax' => $settings->fax,
            'google_map_status' => $settings->google_map_status,
        ];
        $this->app['config']['contact'] = $siteContactSettings;
        /*********************** */
        /*********************** */
        $adminLogoFaviconSettings = [
            'admin_login_page_logo' => $settings->admin_login_page_logo,
            'admin_header_logo' => $settings->admin_header_logo,
            'admin_favicon' => $settings->admin_favicon,
        ];
        $this->app['config']['admin_logo_favicon'] = $adminLogoFaviconSettings;
        /*********************** */
        /*********************** */
        $is_show_analytics = Metadata::where('data_key', 'is_show_analytics')->first()->val1;
        $analytics_property_id = Metadata::where('data_key', 'analytics_property_id')->first()->val1;
        $service_account_credentials_json = Metadata::where('data_key', 'service_account_credentials_json')->first()->val1;
        $analytics = [
            'is_show_analytics' => (bool)$is_show_analytics,
            'property_id' => $analytics_property_id,
            'service_account_credentials_json' => storage_path('app/analytics/' . $service_account_credentials_json),
            'cache_lifetime_in_minutes' => 60 * 24,
            'cache' => [
                'store' => 'file',
            ],
        ];
        $this->app['config']['analytics'] = $analytics;
        /*********************** */
        /*********************** */
        $google_analytics_front = [
            'google_analytics_front' => $settings->google_analytics
        ];
        $this->app['config']['google_analytics_front'] = $google_analytics_front;
        /*********************** */
        /*********************** */
    }
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
    }
}
