<?php

namespace App\Http\Middleware;

use Closure;

class SecurityHeaders
{
    private $unwantedHeaders = ['X-Powered-By', 'server', 'Server'];
    /**
     * @param $request
     * @param  Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $response = $next($request);
        if (!app()->environment('testing')) {
            $response->headers->set('Referrer-Policy', 'no-referrer-when-downgrade');
            $response->headers->set('X-XSS-Protection', '1; mode=block');
            $response->headers->set('Strict-Transport-Security', 'max-age=31536000; includeSubDomains');
            $response->headers->set('Content-Security-Policy', "default-src 'self'; script-src 'self' *.google.com *.googletagmanager.com *.gstatic.com *.google-analytics.com *.ckeditor.com platform.twitter.com plausible.io utteranc.es *.cloudflare.com 'unsafe-inline' 'unsafe-eval' plausible.io/js/plausible.js utteranc.es/client.js; style-src 'self' *.cloudflare.com *.googleapis.com 'unsafe-inline'; img-src 'self' * data:; font-src 'self' fonts.gstatic.com data: ; connect-src 'self' *.google.com *.google-analytics.com plausible.io/api/event; media-src 'self'; frame-src 'self' *.google.com platform.twitter.com plausible.io utteranc.es github.com *.youtube.com *.vimeo.com; object-src 'none'; base-uri 'self';");
            $response->headers->set('Expect-CT', 'enforce, max-age=30');
            $response->headers->set('Permissions-Policy', 'autoplay=(self), camera=(), encrypted-media=(self), fullscreen=(), geolocation=(self), gyroscope=(self), magnetometer=(), microphone=(), midi=(), payment=(), sync-xhr=(self), usb=()');
            $response->headers->set('Access-Control-Allow-Origin', '*');
            $response->headers->set('Access-Control-Allow-Methods', 'GET,POST,PUT,PATCH,DELETE,OPTIONS');
            $response->headers->set('Access-Control-Allow-Headers', 'Content-Type,Authorization,X-Requested-With,X-CSRF-Token');
            $this->removeUnwantedHeaders($this->unwantedHeaders);
        }
        return $response;
    }
    /**
     * @param $headers
     */
    private function removeUnwantedHeaders($headers): void
    {
        foreach ($headers as $header) {
            header_remove($header);
        }
    }
}
