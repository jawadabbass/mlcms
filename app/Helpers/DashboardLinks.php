<?php

namespace App\Helpers;

use App\Models\Back\CmsModule;
use App\Models\Back\CmsModuleData;

class DashboardLinks
{
    public static $beforeModuleLinks = [
        'cmsmodules' => ['CMS Modules', 'fa-solid fa-file', 'modules', 'user_type' => ['super-admin', 'normal-admin'], ''],
        'menu' => ['Positioning Navigations', 'fa-solid fa-tasks', 'menus?position=top', 'user_type' => ['super-admin', 'normal-admin'], ''],
        'contact_request' => ['Manage Leads', 'fa-solid fa-share', 'contact_request', 'user_type' => ['super-admin', 'normal-admin', 'reps'], ''],
        'manage_clients' => ['Manage Clients', 'fa-solid fa-share', 'manage_clients', 'user_type' => ['super-admin', 'normal-admin', 'reps'], ''],
    ];

    public static $afterModuleLinks = [
        'email_templates' => ['Manage Email Templates', 'fa-solid fa-envelope', 'email_templates', 'user_type' => ['super-admin', 'normal-admin', 'reps'], ''],
        'message' => ['Manage Message Templates', 'fa-solid fa-comment', 'message', 'user_type' => ['super-admin', 'normal-admin', 'reps'], ''],
        'gallery' => ['Manage Gallery', 'fa-solid fa-file-image', 'gallery', 'user_type' => ['super-admin', 'normal-admin'], ''],
        'news' => ['Manage News', 'fa-solid fa-newspaper', 'news', 'user_type' => ['super-admin', 'normal-admin'], ''],
        'settings' => ['Manage Contact Page', 'fa-solid fa-share', 'manage_contact', 'user_type' => ['super-admin'], ''],
        'blog' => ['Manage blog', 'fa-solid fa-rss', 'blog', 'user_type' => ['super-admin', 'normal-admin'], ''],
        'products' => ['Products', 'fa-solid fa-shopping-cart', 'products', 'user_type' => ['super-admin', 'normal-admin'], ''],
        'videos' => ['Videos', 'fa-solid fa-film', 'videos', 'user_type' => ['super-admin', 'normal-admin'], ''],
        'widgets' => ['Widgets', 'fa-solid fa-building', 'widgets', 'user_type' => ['super-admin', 'normal-admin'], ''],
        'social_media' => ['Manage Social Media ', 'fa-solid fa-share-alt-square', 'social_media', 'user_type' => ['super-admin', 'normal-admin'], ''],
        'userlog' => ['Admin User Logs', 'fa-solid fa-history', 'user/admin_log', 'user_type' => ['super-admin'], ''],
        'adminusers' => ['Manage Admin Users ', 'fa-solid fa-lock', 'user/admin', 'user_type' => ['super-admin'], ''],
        'load_users' => ['Manage Frontend Users ', 'fa-solid fa-users', 'user/front', 'user_type' => ['super-admin'], ''],
        'main_settings' => ['Settings', 'fa-solid awesome_style  fa-cog', 'settings', 'user_type' => ['super-admin'], ''],
        'media' => ['File Manager', 'fa-solid fa-folder-open', 'media', 'user_type' => ['super-admin'], 'newtab'],
        'categories_reg' => ['Categories', 'fa-solid fa-bars', 'categories', 'user_type' => ['super-admin', 'normal-admin'], ''],
        'states' => ['Manage States', 'fa-solid fa-map', 'states', 'user_type' => ['super-admin'], ''],
        'counties' => ['Manage Counties', 'fa-solid fa-map', 'counties', 'user_type' => ['super-admin'], ''],
        'cities' => ['Manage Cities', 'fa-solid fa-map', 'cities', 'user_type' => ['super-admin'], ''],
        'fleetPlanes' => ['Manage Fleet Planes', 'fa-solid fa-plane', 'fleetPlanes', 'user_type' => ['super-admin', 'normal-admin'], ''],
        'fleetCategories' => ['Manage Fleet Categories', 'fa-solid fa-list', 'fleetCategories', 'user_type' => ['super-admin', 'normal-admin'], ''],
        'passengerCapacities' => ['Manage Passenger Capacities', 'fa-solid fa-users', 'passengerCapacities', 'user_type' => ['super-admin', 'normal-admin'], ''],
        'cabinDimensions' => ['Manage Cabin Dimensions', 'fa-solid fa-plane', 'cabinDimensions', 'user_type' => ['super-admin', 'normal-admin'], ''],
        'baggageCapacities' => ['Manage Baggage Capacities', 'fa-solid fa-briefcase', 'baggageCapacities', 'user_type' => ['super-admin', 'normal-admin'], ''],
        'performances' => ['Manage Performances', 'fa-solid fa-person-running', 'performances', 'user_type' => ['super-admin', 'normal-admin'], ''],
        'cabinAmenities' => ['Manage Cabin Amenities', 'fa-solid fa-palette', 'cabinAmenities', 'user_type' => ['super-admin', 'normal-admin'], ''],
        'safeties' => ['Manage Safeties', 'fa-solid fa-hand', 'safeties', 'user_type' => ['super-admin', 'normal-admin'], ''],
        'cache' => ['Cache', 'fa-solid fa-refresh', 'cache', 'user_type' => ['super-admin', 'normal-admin'], ''],
    ];
    public static $beforeLeftModuleLinks = [
        'CMS - Content Management System' => [
            'icon' => ['fa-solid fa-pencil'],
            'pages' => ['Manage Pages', 'fa-solid fa-file-text', 'module/cms/', 'user_type' => ['super-admin', 'normal-admin'], ''],
            'menu' => ['Positioning Navigations', 'fa-solid fa-tasks', 'menus?position=top', 'user_type' => ['super-admin', 'normal-admin'], ''],
            'manage_contact' => ['Manage Contact Page', 'fa-solid fa-share', 'manage_contact', 'user_type' => ['super-admin'], ''],
            'user_type' => ['super-admin', 'normal-admin'],
        ],
        'widgets' => ['Widgets', 'fa-solid fa-puzzle-piece', 'widgets', 'user_type' => ['super-admin', 'normal-admin'], ''],
        'cmsmodules' => ['CMS Modules', 'fa-solid fa-file', 'modules', 'user_type' => ['super-admin', 'normal-admin'], ''],
        'CRM' => [
            'icon' => ['fa-solid fa-user'],
            'contact_request' => ['Manage Leads', 'fa-solid fa-share', 'contact_request', 'user_type' => ['super-admin', 'normal-admin', 'reps'], ''],
            'manage_clients' => ['Manage Clients', 'fa-solid fa-share', 'manage_clients', 'user_type' => ['super-admin', 'normal-admin', 'reps'], ''],
            'email_templates' => ['Manage Email Templates', 'fa-solid fa-envelope', 'email_templates', 'user_type' => ['super-admin', 'normal-admin', 'reps'], ''],
            'message' => ['Manage Message Templates', 'fa-solid fa-comment', 'message', 'user_type' => ['super-admin', 'normal-admin', 'reps'], ''],
            'user_type' => ['super-admin', 'normal-admin', 'reps'],
        ],
        'Manage Invoices' => [
            'icon' => ['fa-solid fa-ticket'],
            'Invoices' => ['Manage Invoice', 'fa-solid fa-share', 'invoice', 'user_type' => ['super-admin'], ''],
            'payment_options' => ['Payment Options', 'fa-solid fa-money-bill', 'payment_options', 'user_type' => ['super-admin'], ''],
            'user_type' => ['super-admin'],
        ],
    ];

    public static $afterLeftModuleLinks = [
        'videos' => ['Videos', 'fa-solid fa-film', 'videos', 'user_type' => ['super-admin', 'normal-admin'], ''],
        'gallery' => ['Gallery', 'fa-solid fa-image', 'gallery', 'user_type' => ['super-admin', 'normal-admin'], ''],
        'news' => ['Manage News', 'fa-solid fa-newspaper', 'news', 'user_type' => ['super-admin', 'normal-admin'], ''],
        'social_media' => ['Manage Social Media ', 'fa-solid fa-share-alt-square', 'social_media', 'user_type' => ['super-admin', 'normal-admin'], ''],
        'blog' => ['Manage blog', 'fa-solid fa-rss', 'blog', 'user_type' => ['super-admin', 'normal-admin'], ''],
        'products' => ['Products', 'fa-solid fa-shopping-cart', 'products', 'user_type' => ['super-admin', 'normal-admin'], ''],
        'categories_reg' => ['Categories', 'fa-solid fa-bars', 'categories', 'user_type' => ['super-admin', 'normal-admin'], ''],
        'media' => ['File Manager', 'fa-solid fa-folder-open', 'media', 'user_type' => ['super-admin'], 'newtab'],
        'states' => ['Manage States', 'fa-solid fa-map', 'states', 'user_type' => ['super-admin'], ''],
        'counties' => ['Manage Counties', 'fa-solid fa-map', 'counties', 'user_type' => ['super-admin'], ''],
        'cities' => ['Manage Cities', 'fa-solid fa-map', 'cities', 'user_type' => ['super-admin'], ''],
        'fleetPlanes' => ['Manage Fleet Planes', 'fa-solid fa-plane', 'fleetPlanes', 'user_type' => ['super-admin', 'normal-admin'], ''],
        'fleetCategories' => ['Manage Fleet Categories', 'fa-solid fa-list', 'fleetCategories', 'user_type' => ['super-admin', 'normal-admin'], ''],
        'passengerCapacities' => ['Manage Passenger Capacities', 'fa-solid fa-users', 'passengerCapacities', 'user_type' => ['super-admin', 'normal-admin'], ''],
        'cabinDimensions' => ['Manage Cabin Dimensions', 'fa-solid fa-plane', 'cabinDimensions', 'user_type' => ['super-admin', 'normal-admin'], ''],
        'baggageCapacities' => ['Manage Baggage Capacities', 'fa-solid fa-briefcase', 'baggageCapacities', 'user_type' => ['super-admin', 'normal-admin'], ''],
        'performances' => ['Manage Performances', 'fa-solid fa-person-running', 'performances', 'user_type' => ['super-admin', 'normal-admin'], ''],
        'cabinAmenities' => ['Manage Cabin Amenities', 'fa-solid fa-palette', 'cabinAmenities', 'user_type' => ['super-admin', 'normal-admin'], ''],
        'safeties' => ['Manage Safeties', 'fa-solid fa-hand', 'safeties', 'user_type' => ['super-admin', 'normal-admin'], ''],
        'General Settings' => [
            'icon' => ['fa-solid awesome_style  fa-cog'],
            'admin_logo_favicon' => ['Admin Logo/Favicon', 'fa-solid awesome_style  fa-cog', 'settings/admin_logo_favicon', 'user_type' => ['super-admin'], ''],
            'general_settings' => ['Basic Settings', 'fa-solid awesome_style  fa-cog', 'settings/basic', 'user_type' => ['super-admin'], ''],
            'google_analytics' => ['Google Analytics', 'fa-solid awesome_style fa-bar-chart', 'settings/analytics', 'user_type' => ['super-admin'], ''],
            'google_adsense' => ['Google Adsense', 'fa-solid awesome_style  fa-adn', 'settings/adsense', 'user_type' => ['super-admin'], ''],
            'captcha' => ['Google Captcha', 'fa-solid awesome_style  fa-exclamation-circle', 'settings/captcha', 'user_type' => ['super-admin'], ''],
            'paypal' => ['Paypal', 'awesome_style fa-brands fa-paypal', 'settings/paypal', 'user_type' => ['super-admin'], ''],
            'disable_website' => ['Disable Website', 'fa-solid awesome_style  fa-ban', 'settings/disable-website', 'user_type' => ['super-admin'], ''],
            'js_settings' => ['Javascript Code', 'fa-solid fa-code', 'settings/js', 'user_type' => ['super-admin'], ''],
            'email_templates' => ['Email Management System', 'fa-solid fa-envelope', 'email_templates', 'user_type' => ['super-admin', 'normal-admin'], ''],
            'cache' => ['Cache', 'fa-solid fa-refresh', 'cache', 'user_type' => ['super-admin', 'normal-admin'], ''],
            'user_type' => ['super-admin', 'normal-admin'],
        ],
        'Security Settings' => [
            'icon' => ['fa-solid fa-lock'],
            'security_settings' => ['Block Traffic', 'fa-solid awesome_style  fa-cog', 'settings/restriction', 'user_type' => ['super-admin'], ''],
            'captcha' => ['Google Captcha', 'fa-solid awesome_style  fa-exclamation-circle', 'settings/captcha', 'user_type' => ['super-admin'], ''],
            'disable_website' => ['Disable Website', 'fa-solid awesome_style fa-ban', 'settings/disable-website', 'user_type' => ['super-admin'], ''],
            'userlog' => ['Admin User Logs', 'fa-solid fa-history', 'user/admin_log', 'user_type' => ['super-admin'], ''],
            'adminusers' => ['Manage Admin Users ', 'fa-solid fa-lock', 'user/admin', 'user_type' => ['super-admin'], ''],
            'load_users' => ['Manage Frontend Users ', 'fa-solid fa-users', 'user/front', 'user_type' => ['super-admin'], ''],
            'user_type' => ['super-admin'],
        ],
    ];

    public static function get_cms_modules()
    {
        $data = CmsModule::where('show_in_admin_menu', 1)->get();
        $arr = [];
        if (count($data) > 0) {
            foreach($data as $moduleObj){
                $arr[$moduleObj->type] = [$moduleObj->title, $moduleObj->module_fontawesome_icon, 'module/'.$moduleObj->type, 'user_type' => explode(',', $moduleObj->access_level), ''];
            }
        }
        return $arr;
    }
}
