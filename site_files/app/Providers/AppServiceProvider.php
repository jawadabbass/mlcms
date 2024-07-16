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
                    symlink($target, $link);
                }
            }
        }
        Paginator::useBootstrap();
        Validator::extend('recaptcha', 'App\\Validators\\ReCaptcha@validate');
    }
}
