<?php

namespace App\Providers;

use Illuminate\Pagination\Paginator;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Validator;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        if (!app()->runningInConsole()) {
            foreach (config('filesystems.links') as $link => $target) {
                if (is_link($link) === false) {
                    if (! windows_os()) {
                        symlink($target, $link);
                    } else {
                        $mode = is_dir($target) ? 'J' : 'H';
                        exec("mklink /{$mode} " . escapeshellarg($link) . ' ' . escapeshellarg($target));
                    }
                }
            }
        }
        Paginator::useBootstrap();
        Validator::extend('recaptcha', 'App\\Validators\\ReCaptcha@validate');
    }
}
