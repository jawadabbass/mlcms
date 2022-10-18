<?php

namespace App\Http\Middleware;

use Closure;
use App\Models\Back\Setting;

class WebsiteStatus
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $settingsArr = Setting::find(1);
        if ($settingsArr->web_down_status == 1) {
            return redirect('/maintenance');
        }
        return $next($request);
    }
}