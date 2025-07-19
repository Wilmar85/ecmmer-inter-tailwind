<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class ValidateRequestData
{
    /**
     * Manejador de la solicitud entrante.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        // Solo validar métodos que envían datos
        if (!in_array($request->method(), ['POST', 'PUT', 'PATCH', 'DELETE'])) {
            return $next($request);
        }

        // Obtener la ruta actual
        $route = $request->route();
        $routeName = $route ? $route->getName() : null;
        
        // Definir reglas de validación basadas en la ruta
        $rules = $this->getValidationRules($routeName, $request);
        
        if (empty($rules)) {
            return $next($request);
        }

        try {
            // Validar los datos de la solicitud
            $validatedData = $request->validate($rules);
            
            // Reemplazar la entrada de la solicitud con los datos validados
            $request->replace($validatedData);
            
            return $next($request);
            
        } catch (ValidationException $e) {
            // Registrar intento de manipulación
            Log::warning('Intento de manipulación de datos detectado', [
                'ip' => $request->ip(),
                'url' => $request->fullUrl(),
                'method' => $request->method(),
                'input' => $request->all(),
                'errors' => $e->errors()
            ]);
            
            // Redirigir de vuelta con errores
            if ($request->expectsJson()) {
                return response()->json([
                    'message' => 'Los datos proporcionados no son válidos.',
                    'errors' => $e->errors()
                ], 422);
            }
            
            return redirect()->back()->withErrors($e->errors())->withInput();
        }
    }

    /**
     * Obtener reglas de validación basadas en la ruta.
     *
     * @param  string|null  $routeName
     * @param  Request  $request
     * @return array
     */
    private function getValidationRules(?string $routeName, Request $request): array
    {
        // Definir reglas de validación para rutas específicas
        $rules = [];
        
        // Ejemplo: Validación para actualizar cantidades en el carrito
        if ($routeName === 'cart.update' || $routeName === 'cart.add') {
            $rules = [
                'id' => 'required|exists:products,id',
                'quantity' => 'required|integer|min:1|max:100'
            ];
        }
        
        // Ejemplo: Validación para creación/actualización de pedidos
        elseif (str_contains($routeName, 'orders.')) {
            $rules = [
                'items' => 'required|array|min:1',
                'items.*.product_id' => 'required|exists:products,id',
                'items.*.quantity' => 'required|integer|min:1',
                'shipping_address' => 'required|array',
                'payment_method' => 'required|string|in:credit_card,paypal,stripe',
            ];
        }
        
        // Agregar más reglas según sea necesario para otras rutas
        
        return $rules;
    }
}
