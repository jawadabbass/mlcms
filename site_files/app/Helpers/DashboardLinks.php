<?php

namespace App\Helpers;

use App\Models\Back\CmsModule;
use App\Models\Back\CmsModuleData;

class DashboardLinks
{
    public static $beforeModuleLinks = [
        'cmsmodules' => ['CMS Modules', 'fas fa-file', 'modules', 'user_type' => ['super-admin', 'normal-admin'], ''],
        'menu' => ['Positioning Navigations', 'fas fa-tasks', 'menus?position=top', 'user_type' => ['super-admin', 'normal-admin'], ''],
        'mass-mail' => ['Mass Mail', 'fa fa-envelope', 'mass-mail?clients=yes&leads=yes&subscribers=yes&lead_id=0&client_id=0', 'user_type' => ['super-admin', 'normal-admin'], ''],
        'contact_request' => ['Manage Leads', 'fas fa-share', 'contact_request', 'user_type' => ['super-admin', 'normal-admin', 'reps'], ''],
        'manage_clients' => ['Manage Clients', 'fas fa-share', 'manage_clients', 'user_type' => ['super-admin', 'normal-admin', 'reps'], ''],
    ];

    public static $afterModuleLinks = [
        'services' => ['Manage Services', 'fas fa-align-justify', 'services', 'user_type' => ['super-admin', 'normal-admin'], ''],
        'careers' => ['Careers', 'fas fa-tasks', 'careers', 'user_type' => ['super-admin', 'normal-admin', 'reps'], ''],
        'job_applications' => ['Job Applications', 'fas fa-tasks', 'job-applications', 'user_type' => ['super-admin', 'normal-admin', 'reps'], ''],
        'email_templates' => ['Manage Email Templates', 'fas fa-envelope', 'generalEmailTemplates', 'user_type' => ['super-admin', 'normal-admin', 'reps'], ''],
        'message' => ['Manage Message Templates', 'fas fa-comment', 'message', 'user_type' => ['super-admin', 'normal-admin', 'reps'], ''],
        'gallery' => ['Manage Gallery', 'fas fa-file-image', 'gallery', 'user_type' => ['super-admin', 'normal-admin'], ''],
        'news' => ['Manage News', 'fas fa-newspaper', 'news', 'user_type' => ['super-admin', 'normal-admin'], ''],
        'settings' => ['Manage Contact Page', 'fas fa-share', 'manage_contact', 'user_type' => ['super-admin'], ''],
        'blog' => ['Manage blog', 'fas fa-rss', 'blog', 'user_type' => ['super-admin', 'normal-admin'], ''],
        'products' => ['Products', 'fas fa-shopping-cart', 'products', 'user_type' => ['super-admin', 'normal-admin'], ''],
        'videos' => ['Videos', 'fas fa-film', 'videos', 'user_type' => ['super-admin', 'normal-admin'], ''],
        'widgets' => ['Widgets', 'fas fa-building', 'widgets', 'user_type' => ['super-admin', 'normal-admin'], ''],
        'social_media' => ['Manage Social Media ', 'fas fa-share-alt-square', 'social_media', 'user_type' => ['super-admin', 'normal-admin'], ''],        
        'userlog' => ['Admin User Logs', 'fas fa-history', 'user/admin_log', 'user_type' => ['super-admin'], ''],
        'adminusers' => ['Manage Admin Users ', 'fas fa-lock', 'user/admin', 'user_type' => ['super-admin'], ''],
        'load_users' => ['Manage Frontend Users ', 'fas fa-users', 'user/front', 'user_type' => ['super-admin'], ''],
        'main_settings' => ['Settings', 'fas  fa-cog', 'settings', 'user_type' => ['super-admin'], ''],
        'media' => ['File Manager', 'fas fa-folder-open', 'media', 'user_type' => ['super-admin'], 'newtab'],
        'categories_reg' => ['Categories', 'fas fa-bars', 'categories', 'user_type' => ['super-admin', 'normal-admin'], ''],
        /*
        'states' => ['Manage States', 'fas fa-map', 'states', 'user_type' => ['super-admin'], ''],
        'counties' => ['Manage Counties', 'fas fa-map', 'counties', 'user_type' => ['super-admin'], ''],
        'cities' => ['Manage Cities', 'fas fa-map', 'cities', 'user_type' => ['super-admin'], ''],
        */
        'cache' => ['Cache', 'fas fa-sync', 'cache', 'user_type' => ['super-admin', 'normal-admin'], ''],
    ];
    public static $beforeLeftModuleLinks = [
        'CMS - Content Management System' => [
            'icon' => ['fas fa-edit'],
            'pages' => ['Manage Pages', 'fas fa-file', 'module/cms/', 'user_type' => ['super-admin', 'normal-admin'], ''],
            'menu' => ['Positioning Navigations', 'fas fa-tasks', 'menus?position=top', 'user_type' => ['super-admin', 'normal-admin'], ''],
            'manage_contact' => ['Manage Contact Page', 'fas fa-share', 'manage_contact', 'user_type' => ['super-admin'], ''],
            'user_type' => ['super-admin', 'normal-admin'],
        ],
        'widgets' => ['Widgets', 'fas fa-puzzle-piece', 'widgets', 'user_type' => ['super-admin', 'normal-admin'], ''],
        'cmsmodules' => ['CMS Modules', 'fas fa-file', 'modules', 'user_type' => ['super-admin', 'normal-admin'], ''],
        'CRM' => [
            'icon' => ['fas fa-user'],
            'mass-mail' => ['Mass Mail', 'fa fa-envelope', 'mass-mail?clients=yes&leads=yes&subscribers=yes&lead_id=0&client_id=0', 'user_type' => ['super-admin', 'normal-admin'], ''],
            'contact_request' => ['Manage Leads', 'fas fa-share', 'contact_request', 'user_type' => ['super-admin', 'normal-admin', 'reps'], ''],
            'manage_clients' => ['Manage Clients', 'fas fa-share', 'manage_clients', 'user_type' => ['super-admin', 'normal-admin', 'reps'], ''],
            'email_templates' => ['Manage Email Templates', 'fas fa-envelope', 'generalEmailTemplates', 'user_type' => ['super-admin', 'normal-admin', 'reps'], ''],
            'message' => ['Manage Message Templates', 'fas fa-comment', 'message', 'user_type' => ['super-admin', 'normal-admin', 'reps'], ''],
            'user_type' => ['super-admin', 'normal-admin', 'reps'],
        ],
        'Manage Invoices' => [
            'icon' => ['fas fa-ticket-alt'],
            'Invoices' => ['Manage Invoice', 'fas fa-share', 'invoice', 'user_type' => ['super-admin'], ''],
            'payment_options' => ['Payment Options', 'fas fa-money-bill', 'payment_options', 'user_type' => ['super-admin'], ''],
            'user_type' => ['super-admin'],
        ],
    ];

    public static $afterLeftModuleLinks = [
        'services' => ['Manage Services', 'fas fa-align-justify', 'services', 'user_type' => ['super-admin', 'normal-admin'], ''],
        'careers' => ['Careers', 'fas fa-tasks', 'careers', 'user_type' => ['super-admin', 'normal-admin', 'reps'], ''],
        'job_applications' => ['Job Applications', 'fas fa-tasks', 'job-applications', 'user_type' => ['super-admin', 'normal-admin', 'reps'], ''],
        'videos' => ['Videos', 'fas fa-film', 'videos', 'user_type' => ['super-admin', 'normal-admin'], ''],
        'gallery' => ['Gallery', 'fas fa-image', 'gallery', 'user_type' => ['super-admin', 'normal-admin'], ''],
        'news' => ['Manage News', 'fas fa-newspaper', 'news', 'user_type' => ['super-admin', 'normal-admin'], ''],        
        'social_media' => ['Manage Social Media ', 'fas fa-share-alt-square', 'social_media', 'user_type' => ['super-admin', 'normal-admin'], ''],
        'blog' => ['Manage blog', 'fas fa-rss', 'blog', 'user_type' => ['super-admin', 'normal-admin'], ''],
        'products' => ['Products', 'fas fa-shopping-cart', 'products', 'user_type' => ['super-admin', 'normal-admin'], ''],
        'categories_reg' => ['Categories', 'fas fa-bars', 'categories', 'user_type' => ['super-admin', 'normal-admin'], ''],
        'media' => ['File Manager', 'fas fa-folder-open', 'media', 'user_type' => ['super-admin'], 'newtab'],
        /*
        'states' => ['Manage States', 'fas fa-map', 'states', 'user_type' => ['super-admin'], ''],
        'counties' => ['Manage Counties', 'fas fa-map', 'counties', 'user_type' => ['super-admin'], ''],
        'cities' => ['Manage Cities', 'fas fa-map', 'cities', 'user_type' => ['super-admin'], ''],
        */
        'General Settings' => [
            'icon' => ['fas  fa-cog'],
            'admin_logo_favicon' => ['Admin Logo/Favicon', 'fas  fa-cog', 'settings/admin_logo_favicon', 'user_type' => ['super-admin', 'normal-admin'], ''],
            'banner_popup' => array('Banner Popup', 'fas fa-bars', 'settings/banner_popup', 'user_type' => ['super-admin', 'normal-admin'], ''),
            'general_settings' => ['Basic Settings', 'fas  fa-cog', 'settings/basic', 'user_type' => ['super-admin', 'normal-admin'], ''],
            'js_settings' => ['Javascript Code', 'fas fa-code', 'settings/js', 'user_type' => ['super-admin', 'normal-admin'], ''],
            'email_templates' => ['Email Management System', 'fas fa-envelope', 'email_templates', 'user_type' => ['super-admin', 'normal-admin'], ''],
            'cache' => ['Cache', 'fas fa-sync', 'cache', 'user_type' => ['super-admin', 'normal-admin'], ''],    
            'user_type' => ['super-admin', 'normal-admin'],
        ],
        'Security Settings' => [
            'icon' => ['fas fa-lock'],
            'security_settings' => ['Block Traffic', 'fas  fa-cog', 'settings/restriction', 'user_type' => ['super-admin'], ''],
            'captcha' => ['Google Captcha', 'fas  fa-exclamation-circle', 'settings/captcha', 'user_type' => ['super-admin'], ''],
            'disable_website' => ['Disable Website', 'fas fa-ban', 'settings/disable-website', 'user_type' => ['super-admin'], ''],
            'google_analytics' => ['Google Analytics', 'fas fa-chart-bar', 'settings/analytics', 'user_type' => ['super-admin'], ''],
            'analytics_property_id_and_json_file' => ['Google Analytics Prop Id/json', 'fas fa-chart-bar', 'settings/analytics_property_id_and_json_file', 'user_type' => ['super-admin'], ''],
            'google_adsense' => ['Google Adsense', 'fas  fa-chart-bar', 'settings/adsense', 'user_type' => ['super-admin'], ''],
            'paypal' => ['Paypal', 'fab fa-paypal', 'settings/paypal', 'user_type' => ['super-admin'], ''],
            'userlog' => ['Admin User Logs', 'fas fa-history', 'user/admin_log', 'user_type' => ['super-admin'], ''],
            'adminusers' => ['Manage Admin Users ', 'fas fa-lock', 'user/admin', 'user_type' => ['super-admin'], ''],
            'load_users' => ['Manage Frontend Users ', 'fas fa-users', 'user/front', 'user_type' => ['super-admin'], ''],
            'user_type' => ['super-admin'],
        ],
    ];

    public static function get_cms_modules($left_or_dashboard)
    {
        $data = CmsModule::where('show_in_admin_menu', 1)->where('show_icon_in', 'like', '%show_icon_in_' . $left_or_dashboard . '%')->get();
        $arr = [];
        if (count($data) > 0) {
            foreach ($data as $moduleObj) {
                $arr[$moduleObj->type] = [$moduleObj->title, $moduleObj->module_fontawesome_icon, 'module/' . $moduleObj->type, 'user_type' => explode(',', $moduleObj->access_level), ''];
            }
        }
        return $arr;
    }
}
