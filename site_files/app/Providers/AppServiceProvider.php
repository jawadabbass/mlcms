<?php

namespace App\Providers;

use Livewire\Livewire;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Artisan;
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
        Paginator::useBootstrap();
        Validator::extend('recaptcha', 'App\\Validators\\ReCaptcha@validate');

        /*************************************/
        /*************************************/
        /******** Dont Delete OR Change*******/
        @unlink(public_path('storage'));
        Artisan::call('storage:link');
        /*************************************/
        /*************************************/

        Livewire::setUpdateRoute(function ($handle) {
            $url = env('LIVEWIRE_UPDATE_ENDPOINT');
            return Route::post($url . 'livewire/update', $handle);
        });
    }
}
