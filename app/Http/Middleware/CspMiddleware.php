<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class CspMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        $response = $next($request);

        if ($response instanceof Response) {
            $csp = [
                "default-src 'self';",
                "script-src 'self' 'unsafe-inline' 'unsafe-eval' https://*.google-analytics.com https://*.googletagmanager.com https://*.google.com https://*.gstatic.com;",
                "style-src 'self' 'unsafe-inline' https://fonts.googleapis.com;",
                "img-src 'self' data: https: http:;",
                "font-src 'self' data: https://fonts.gstatic.com;",
                "connect-src 'self' https://*.google-analytics.com https://*.googleapis.com https://*.gstatic.com;",
                "frame-src 'self' https://www.google.com https://www.youtube.com;",
                "object-src 'none';",
                "media-src 'self';",
                "form-action 'self';",
                "upgrade-insecure-requests;",
                "block-all-mixed-content;"
            ];

            $response->headers->set('Content-Security-Policy', implode(' ', $csp));
        }

        return $response;
    }
}
