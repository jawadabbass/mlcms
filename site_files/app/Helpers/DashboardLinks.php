<?php

namespace App\Helpers;

use App\Models\User;
use App\Models\Back\CmsModule;
use App\Models\Back\Permission;
use App\Models\Back\CmsModuleData;
use App\Models\Back\PermissionRole;
use App\Models\Back\PermissionGroup;
use Illuminate\Support\Facades\Auth;

class DashboardLinks
{
    /****************************************************** */
    /****************************************************** */
    /* Dashboard Links: appears before dynamic module links */
    public static $beforeModuleLinks = [
        'cmsmodules' => [
            'CMS Modules',
            'fas fa-file', 'modules',
            'permission' => 'Can Manage CMS Modules',
            ''
        ],
        'menu' => [
            'Positioning Navigation',
            'fas fa-tasks', 'menus?position=top',
            'permission' => 'Can Manage Positioning Navigation',
            ''
        ],
        'contact_request' => [
            'Manage Leads',
            'fas fa-share', 'contact_request',
            'permission' => 'Can Manage Leads',
            ''
        ],
        'manage_clients' => [
            'Manage Clients',
            'fas fa-share', 'manage_clients',
            'permission' => 'Can Manage Clients',
            ''
        ],
    ];
    /****************************************************** */
    /****************************************************** */
    /* Dashboard Links: appears after dynamic module links */
    public static $afterModuleLinks = [
        'email_templates' => [
            'Manage Email Templates',
            'fas fa-envelope', 'email_templates',
            'permission' => 'Can Manage Email Templates',
            ''
        ],
        'message' => [
            'Manage Message Templates',
            'fas fa-comment', 'message',
            'permission' => 'Can Manage Message Templates',
            ''
        ],
        'gallery' => [
            'Manage Gallery',
            'fas fa-file-image', 'gallery',
            'permission' => 'Can Manage Gallery',
            ''
        ],
        'news' => [
            'Manage News',
            'fas fa-newspaper', 'news',
            'permission' => 'Can Manage News',
            ''
        ],
        'settings' => [
            'Manage Contact Page',
            'fas fa-share', 'manage_contact',
            'permission' => 'Can Manage Contact Page',
            ''
        ],
        'blog' => [
            'Manage blog',
            'fas fa-rss', 'blog',
            'permission' => 'Can Manage Blog',
            ''
        ],
        'products' => [
            'Products',
            'fas fa-shopping-cart', 'products',
            'permission' => 'Can Manage Products',
            ''
        ],
        'videos' => [
            'Videos',
            'fas fa-film', 'videos',
            'permission' => 'Can Manage Videos',
            ''
        ],
        'widgets' => [
            'Widgets',
            'fas fa-building', 'widgets',
            'permission' => 'Can Manage Widgets',
            ''
        ],
        'social_media' => [
            'Manage Social Media',
            'fas fa-share-alt-square', 'social_media',
            'permission' => 'Can Manage Social Media',
            ''
        ],
        'userlog' => [
            'Admin User Logs',
            'fas fa-history', 'user/admin_log',
            'permission' => 'Can Manage Admin User Logs',
            ''
        ],
        'adminusers' => [
            'Manage Admin Users',
            'fas fa-lock', 'admin-users',
            'permission' => 'Can Manage Admin Users',
            ''
        ],
        'load_users' => [
            'Manage Frontend Users',
            'fas fa-users', 'user/front',
            'permission' => 'Can Manage Frontend Users',
            ''
        ],
        'main_settings' => [
            'Settings',
            'fas  fa-cog', 'settings',
            'permission' => 'Can Manage Admin Logo/Favicon<|>Can Manage Basic Settings<|>Can Manage Google Analytics<|>Can Manage Google Adsense<|>Can Manage Paypal<|>Can Manage Javascript Code<|>Can Manage Cach<|>Can Manage Google Captcha<|>Can Manage Disable Website<|>Can Manage Block Traffic',
            ''
        ],
        'media' => [
            'File Manager',
            'fas fa-folder-open', 'media',
            'permission' => 'Can Use File Manager',
            'newtab'
        ],
        'categories_reg' => [
            'Categories',
            'fas fa-bars', 'categories',
            'permission' => 'Can Manage Categories',
            ''
        ],
        'states' => [
            'Manage States',
            'fas fa-map', 'states',
            'permission' => 'Can Manage States',
            ''
        ],
        'counties' => [
            'Manage Counties',
            'fas fa-map', 'counties',
            'permission' => 'Can Manage Counties',
            ''
        ],
        'cities' => [
            'Manage Cities',
            'fas fa-map', 'cities',
            'permission' => 'Can Manage Cities',
            ''
        ],
        'cache' => [
            'Cache',
            'fas fa-sync', 'cache',
            'permission' => 'Can Manage Cache',
            ''
        ],
    ];
    /****************************************************** */
    /****************************************************** */
    /* Left Side Links: appears before dynamic module links */
    public static $beforeLeftModuleLinks = [
        'CMS - Content Management System' => [
            'icon' => ['fas fa-edit'],
            'pages' => [
                'Manage Pages',
                'fas fa-file', 'module/cms/',
                'permission' => 'Can Manage CMS Pages',
                ''
            ],
            'menu' => [
                'Positioning Navigation',
                'fas fa-tasks', 'menus?position=top',
                'permission' => 'Can Manage Positioning Navigation',
                ''
            ],
            'manage_contact' => [
                'Manage Contact Page',
                'fas fa-share', 'manage_contact',
                'permission' => 'Can Manage Contact Page',
                ''
            ],
            'permission' => 'Can Manage CMS Pages<|>Can Manage Positioning Navigation<|>Can Manage Contact Page',
        ],
        'widgets' => [
            'Widgets',
            'fas fa-puzzle-piece', 'widgets',
            'permission' => 'Can Manage Widgets',
            ''
        ],
        'cmsmodules' => [
            'CMS Modules',
            'fas fa-file', 'modules',
            'permission' => 'Can Manage CMS Modules',
            ''
        ],
        'CRM' => [
            'icon' => ['fas fa-user'],
            'contact_request' => [
                'Manage Leads',
                'fas fa-share', 'contact_request',
                'permission' => 'Can Manage Leads',
                ''
            ],
            'manage_clients' => [
                'Manage Clients',
                'fas fa-share', 'manage_clients',
                'permission' => 'Can Manage Clients',
                ''
            ],
            'email_templates' => [
                'Manage Email Templates',
                'fas fa-envelope', 'email_templates',
                'permission' => 'Can Manage Email Templates',
                ''
            ],
            'message' => [
                'Manage Message Templates',
                'fas fa-comment', 'message',
                'permission' => 'Can Manage Message Templates',
                ''
            ],
            'permission' => 'Can Manage Leads<|>Can Manage Clients<|>Can Manage Email Templates<|>Can Manage Message Templates',
        ],
        'Manage Invoices' => [
            'icon' => ['fas fa-ticket-alt'],
            'Invoices' => [
                'Manage Invoice',
                'fas fa-share', 'invoice',
                'permission' => 'Can Manage Invoice',
                ''
            ],
            'payment_options' => [
                'Payment Options',
                'fas fa-money-bill', 'payment_options',
                'permission' => 'Can Manage Payment Options',
                ''
            ],
            'permission' => 'Can Manage Invoice<|>Can Manage Payment Options',
        ],
    ];
    /****************************************************** */
    /****************************************************** */
    /* Left Side Links: appears after dynamic module links */
    public static $afterLeftModuleLinks = [
        'videos' => [
            'Videos',
            'fas fa-film', 'videos',
            'permission' => 'Can Manage Videos',
            ''
        ],
        'gallery' => [
            'Gallery',
            'fas fa-image', 'gallery',
            'permission' => 'Can Manage Gallery',
            ''
        ],
        'news' => [
            'Manage News',
            'fas fa-newspaper', 'news',
            'permission' => 'Can Manage News',
            ''
        ],
        'social_media' => [
            'Manage Social Media',
            'fas fa-share-alt-square', 'social_media',
            'permission' => 'Can Manage Social Media',
            ''
        ],
        'blog' => [
            'Manage blog',
            'fas fa-rss', 'blog',
            'permission' => 'Can Manage Blog',
            ''
        ],
        'products' => [
            'Products',
            'fas fa-shopping-cart', 'products',
            'permission' => 'Can Manage Products',
            ''
        ],
        'categories_reg' => [
            'Categories',
            'fas fa-bars', 'categories',
            'permission' => 'Can Manage Categories',
            ''
        ],
        'media' => [
            'File Manager',
            'fas fa-folder-open', 'media',
            'permission' => 'Can Use File Manager',
            'newtab'
        ],
        'states' => [
            'Manage States',
            'fas fa-map', 'states',
            'permission' => 'Can Manage States',
            ''
        ],
        'counties' => [
            'Manage Counties',
            'fas fa-map', 'counties',
            'permission' => 'Can Manage Counties',
            ''
        ],
        'cities' => [
            'Manage Cities',
            'fas fa-map', 'cities',
            'permission' => 'Can Manage Cities',
            ''
        ],
        'General Settings' => [
            'icon' => ['fas  fa-cog'],
            'admin_logo_favicon' => [
                'Admin Logo/Favicon',
                'fas  fa-cog', 'settings/admin_logo_favicon',
                'permission' => 'Can Manage Admin Logo/Favicon',
                ''
            ],
            'general_settings' => [
                'Basic Settings',
                'fas  fa-cog', 'settings/basic',
                'permission' => 'Can Manage Basic Settings',
                ''
            ],
            'google_analytics' => [
                'Google Analytics',
                'fas fa-chart-bar', 'settings/analytics',
                'permission' => 'Can Manage Google Analytics',
                ''
            ],
            'google_adsense' => [
                'Google Adsense',
                'fas  fa-chart-bar', 'settings/adsense',
                'permission' => 'Can Manage Google Adsense',
                ''
            ],
            'paypal' => [
                'Paypal',
                'fab fa-paypal', 'settings/paypal',
                'permission' => 'Can Manage Paypal',
                ''
            ],
            'js_settings' => [
                'Javascript Code',
                'fas fa-code', 'settings/js',
                'permission' => 'Can Manage Javascript Code',
                ''
            ],
            'cache' => [
                'Cache',
                'fas fa-sync', 'cache',
                'permission' => 'Can Manage Cache',
                ''
            ],
            'permission' => 'Can Manage Admin Logo/Favicon<|>Can Manage Basic Settings<|>Can Manage Google Analytics<|>Can Manage Google Adsense<|>Can Manage Paypal<|>Can Manage Javascript Code<|>Can Manage Cache',
        ],
        'Security Settings' => [
            'icon' => ['fas fa-lock'],
            'security_settings' => [
                'Block Traffic',
                'fas  fa-cog', 'settings/restriction',
                'permission' => 'Can Manage Block Traffic',
                ''
            ],
            'captcha' => [
                'Google Captcha',
                'fas  fa-exclamation-circle', 'settings/captcha',
                'permission' => 'Can Manage Google Captcha',
                ''
            ],
            'disable_website' => [
                'Disable Website',
                'fas  fa-ban', 'settings/disable-website',
                'permission' => 'Can Manage Disable Website',
                ''
            ],
            'userlog' => [
                'Admin User Logs',
                'fas fa-history', 'user/admin_log',
                'permission' => 'Can Manage Admin User Logs',
                ''
            ],
            'adminusers' => [
                'Manage Admin Users',
                'fas fa-lock', 'admin-users',
                'permission' => 'Can Manage Admin Users',
                ''
            ],
            'load_users' => [
                'Manage Frontend Users',
                'fas fa-users', 'user/front',
                'permission' => 'Can Manage Frontend Users',
                ''
            ],
            'permission' => 'Can Manage Block Traffic<|>Can Manage Google Captcha<|>Can Manage Disable Website<|>Can Manage Admin User Logs<|>Can Manage Admin Users<|>Can Manage Frontend Users',
        ],
    ];
    public static function get_cms_modules($left_or_dashboard)
    {
        $data = CmsModule::where('show_in_admin_menu', 1)->where('show_icon_in', 'like', '%show_icon_in_' . $left_or_dashboard . '%')->get();
        $arr = [];
        if (count($data) > 0) {
            foreach ($data as $moduleObj) {
                $arr[$moduleObj->type] = [
                    $moduleObj->title, $moduleObj->module_fontawesome_icon, 'module/' . $moduleObj->type,
                    'permission' => implode('<|>', self::getPermissionTitlesArray($moduleObj)), ''
                ];
            }
        }
        return $arr;
    }

    public static function getPermissionTitlesArray($moduleObj)
    {
        $permissionTitlesArray = [];
        $permissionsGroupObj = PermissionGroup::where('module_id', $moduleObj->id)->first();
        /***************************** */
        $permissionTitlesArray = Permission::where('permission_group_id', $permissionsGroupObj->id)->pluck('title')->toArray();
        return $permissionTitlesArray;
    }
}
