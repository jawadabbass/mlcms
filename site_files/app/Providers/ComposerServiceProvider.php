<?php

namespace App\Providers;

use App\Models\Back\BannerPopup;
use App\Models\Back\ContactUs;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class ComposerServiceProvider extends ServiceProvider
{

    public function boot()
    {
        $frontPageBannerPopup = BannerPopup::find(1);
        $numNewContactLeads = ContactUs::where('read_lead', 0)->count();
        View::share(
            [
                'frontPageBannerPopup' => $frontPageBannerPopup,
                'numNewContactLeads' => $numNewContactLeads,
            ]
        );
    }

    public function register()
    {
        //
    }
}
