<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class WhatsAppController extends Controller
{
    /**
     * Obtener el número de WhatsApp para el botón flotante
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function getFloatButtonNumber()
    {
        $user = Auth::user();
        $whatsappNumber = '573203030595'; // Valor por defecto
        
        if ($user) {
            if (!empty($user->whatsapp_float_button)) {
                $whatsappNumber = $user->whatsapp_float_button;
            } elseif (!empty($user->whatsapp_number)) {
                $whatsappNumber = $user->whatsapp_number;
            }
        }
        
        // Asegurarse de que el número solo contenga dígitos
        $cleanNumber = preg_replace('/[^0-9]/', '', $whatsappNumber);
        
        return response()->json([
            'success' => true,
            'whatsapp_float_button' => $cleanNumber,
            'whatsapp_url' => 'https://wa.me/' . $cleanNumber . '?text=' . urlencode('Hola, estoy interesado en sus productos.')
        ]);
    }
}
