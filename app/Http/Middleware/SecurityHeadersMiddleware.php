<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class SecurityHeadersMiddleware
{
    private array $headers = [
        'X-Frame-Options' => 'SAMEORIGIN',
        'X-Content-Type-Options' => 'nosniff',
        'X-XSS-Protection' => '1; mode=block',
        'Referrer-Policy' => 'strict-origin-when-cross-origin',
        'Permissions-Policy' => 'geolocation=(), microphone=(), camera=()',
        'X-Permitted-Cross-Domain-Policies' => 'none',
        'Expect-CT' => 'enforce, max-age=30',
    ];

    public function handle(Request $request, Closure $next)
    {
        $response = $next($request);
        
        // Solo aplicar a respuestas HTTP
        if (!method_exists($response, 'header')) {
            return $response;
        }

        // Configuración de HSTS solo en producción con SSL
        if (app()->environment('production') && $request->secure()) {
            $this->headers['Strict-Transport-Security'] = 'max-age=31536000; includeSubDomains; preload';
        }

        // Aplicar todos los headers
        foreach ($this->headers as $key => $value) {
            try {
                $response->headers->set($key, $value);
            } catch (\Exception $e) {
                Log::error("Error al configurar el header {$key}", [
                    'error' => $e->getMessage(),
                    'value' => $value
                ]);
            }
        }

        // Prevenir que se cargue el sitio en iframes de otros orígenes
        $response->headers->set('Content-Security-Policy', "frame-ancestors 'self'");
        
        return $response;
    }
}
