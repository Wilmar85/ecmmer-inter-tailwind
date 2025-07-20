<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class CspMiddleware
{
    /**
     * Lista de dominios permitidos para diferentes tipos de recursos
     */
    private array $allowedDomains = [
        'default' => [
            "'self'"
        ],
        'script' => [
            "'self'",
            "'unsafe-inline'",
            "'unsafe-eval'",
            "https://www.google-analytics.com",
            "https://*.googletagmanager.com",
            "https://*.google.com",
            "https://*.gstatic.com",
            "https://js.stripe.com"
        ],
        'style' => [
            "'self'",
            "'unsafe-inline'",
            "https://fonts.googleapis.com"
        ],
        'img' => [
            "'self'",
            "data:",
            "https:",
            "http:",
            "https://*.stripe.com"
        ],
        'font' => [
            "'self'",
            "data:",
            "https://fonts.gstatic.com"
        ],
        'connect' => [
            "'self'",
            "https://*.google-analytics.com",
            "https://*.googleapis.com",
            "https://*.gstatic.com",
            "https://api.stripe.com"
        ],
        'frame' => [
            "'self'",
            "https://www.google.com",
            "https://www.youtube.com",
            "https://js.stripe.com",
            "https://hooks.stripe.com"
        ]
    ];

    public function handle(Request $request, Closure $next)
    {
        // Si es una ruta de la API, no aplicar CSP
        if ($this->isApiRequest($request)) {
            return $next($request);
        }

        $response = $next($request);

        if ($response instanceof Response) {
            try {
                $csp = [
                    "default-src " . implode(' ', $this->allowedDomains['default']) . ";",
                    "script-src " . implode(' ', $this->allowedDomains['script']) . ";",
                    "style-src " . implode(' ', $this->allowedDomains['style']) . ";",
                    "img-src " . implode(' ', $this->allowedDomains['img']) . ";",
                    "font-src " . implode(' ', $this->allowedDomains['font']) . ";",
                    "connect-src " . implode(' ', $this->allowedDomains['connect']) . ";",
                    "frame-src " . implode(' ', $this->allowedDomains['frame']) . ";",
                    "object-src 'none';",
                    "media-src 'self';",
                    "form-action 'self' https://*.stripe.com;",
                    "upgrade-insecure-requests;",
                    "block-all-mixed-content;"
                ];

                // Solo en producción, agregar report-uri para recibir informes de violaciones
                if (app()->environment('production')) {
                    $csp[] = "report-uri https://example.com/csp-report-endpoint;";
                    $csp[] = "report-to csp-endpoint;";
                }

                $cspHeader = implode(' ', $csp);
                $response->headers->set('Content-Security-Policy', $cspHeader);
                
                // Para navegadores que no soportan CSP 3
                $response->headers->set('X-Content-Security-Policy', $cspHeader);
                $response->headers->set('X-WebKit-CSP', $cspHeader);

            } catch (\Exception $e) {
                Log::error('Error al configurar CSP', [
                    'error' => $e->getMessage(),
                    'trace' => $e->getTraceAsString()
                ]);
            }
        }

        return $response;
    }

    /**
     * Determina si la petición es una API request
     */
    private function isApiRequest(Request $request): bool
    {
        return $request->is('api/*') || $request->is('sanctum/*');
    }
}
