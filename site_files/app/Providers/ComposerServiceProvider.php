<?php

namespace App\Providers;

use App\Models\Back\ContactUs;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class ComposerServiceProvider extends ServiceProvider
{

    public function boot()
    {
        $settingsArr = \App\Models\Back\Setting::find(1);
        $metaDatas = \App\Models\Back\Metadata::all();
        $metaArray = array();
        foreach ($metaDatas as $metaData) {
            $metaArray[$metaData->data_key] = $metaData->val1;
        }
        $numNewContactLeads = ContactUs::where('read_lead', 0)->count();
        View::share(
            [
                'settingsArr' => $settingsArr,
                'metaArray' => $metaArray,
                'numNewContactLeads' => $numNewContactLeads,
            ]
        );
    }

    public function register()
    {
        //
    }
}
