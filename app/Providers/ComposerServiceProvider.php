<?php

namespace App\Providers;

use App\Models\Back\ContactUs;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class ComposerServiceProvider extends ServiceProvider
{

    public function boot()
    {
        $numNewContactLeads = ContactUs::where('read_lead', 0)->count();
        View::share(
            [
                'numNewContactLeads' => $numNewContactLeads,
            ]
        );
    }

    public function register()
    {
        //
    }
}
