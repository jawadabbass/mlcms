<?php

namespace App\Http\Middleware;

use App\Models\Back\Metadata;
use Closure;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class IPMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Closure $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $metaDatas = Metadata::where('data_key', 'restrict_traffic')
            ->orWhere('data_key', 'block_list_active')
            ->orWhere('data_key', 'blocked_countries')
            ->orWhere('data_key', 'allowed_countries')
            ->orWhere('data_key', 'blocked_area')
            ->orWhere('data_key', 'blocked_ips')
            ->get();
        $metaArray = array();
        foreach ($metaDatas as $metaData) {
            $metaArray[$metaData->data_key] = $metaData->val1;
        }
        if ($metaArray['restrict_traffic'] == 1) {
            $ip = $request->ip();
            $blockIps = explode(',', $metaArray['blocked_ips']);
            $path = $request->path();
            if ($ip != '::1') {
                $arrIP = explode('.', $ip);
                $ip3 = $arrIP[0] . '.' . $arrIP[1] . '.' . $arrIP[2] . '.*';
                $ip2 = $arrIP[0] . '.' . $arrIP[1] . '.*.*';
                if (in_array($ip, $blockIps) || in_array($ip3, $blockIps) || in_array($ip2, $blockIps)) {
                    if (!strcmp($metaArray['blocked_area'], 'website')) {
                        return redirect('/block');
                    } elseif (!strcmp($path, 'contact-us')) {
                        return redirect('/block');
                    } else {
                        return $next($request);
                    }
                }
            }
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, 'http://iplocation.managemultiplewebsites.com/api/ip/find?ip=' . $ip);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 3);
            curl_setopt($ch, CURLOPT_TIMEOUT, 3);
            $data = curl_exec($ch);
            if (curl_errno($ch)) {
                return $next($request);
            }
            curl_close($ch);
            $countryCode = str_replace('"', "", $data);
            if ($metaArray['block_list_active'] == 1) {
                if (strpos($metaArray['blocked_countries'], $countryCode) !== false) {
                    if (!strcmp($metaArray['blocked_area'], 'website')) {
                        return redirect('/block');
                    } elseif (!strcmp($path, 'contact-us')) {
                        return redirect('/block');
                    } else {
                        return $next($request);
                    }
                }
            } else {
                if (strpos($metaArray['allowed_countries'], $countryCode) !== false) {
                    return $next($request);
                } else {
                    if (!strcmp($metaArray['blocked_area'], 'website')) {
                        return redirect('/block');
                    } elseif (!strcmp($path, 'contact-us')) {
                        return redirect('/block');
                    } else {
                        return $next($request);
                    }
                }
            }
        }
        return $next($request);
    }
}
