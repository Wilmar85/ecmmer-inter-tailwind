<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use App\Http\Requests\ContactInformationRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;
use App\Models\Order;

class ProfileController extends Controller
{
    /**
     * Display the user's profile form.
     */
    public function edit(Request $request): View
    {
        $user = $request->user();
        
        // Obtener pedidos pendientes (pending y processing)
        $pendingOrders = Order::where('user_id', $user->id)
            ->whereIn('status', ['pending', 'processing'])
            ->orderBy('created_at', 'desc')
            ->get();

        // Obtener pedidos completados
        $completedOrders = Order::where('user_id', $user->id)
            ->where('status', 'completed')
            ->orderBy('created_at', 'desc')
            ->get();

        return view('profile.edit', [
            'user' => $user,
            'pendingOrders' => $pendingOrders,
            'completedOrders' => $completedOrders,
        ]);
    }

    /**
     * Update the user's profile information.
     */
    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        $user = $request->user();
        
        // Actualizar solo los campos básicos del perfil
        $user->name = $request->name;
        $user->email = $request->email;
        
        if ($user->isDirty('email')) {
            $user->email_verified_at = null;
        }

        $user->save();

        return Redirect::route('profile.edit')->with('status', 'profile-updated');
    }
    
    /**
     * Update the user's contact information.
     */
    public function updateContact(ContactInformationRequest $request): RedirectResponse
    {
        $user = $request->user();
        
        // Actualizar solo los campos de contacto del usuario
        $user->customer_service_email = $request->customer_service_email;
        $user->whatsapp_number = $request->whatsapp_number;
        $user->whatsapp_float_button = $request->whatsapp_float_button;
        $user->sales_email = $request->sales_email;
        $user->support_email = $request->support_email;
        $user->business_hours = $request->business_hours;
        
        $user->save();
        
        // Si el usuario es administrador, actualizar también la configuración del sitio
        if ($user->isAdmin()) {
            $settings = \App\Models\SiteSetting::first();
            
            if (!$settings) {
                $settings = new \App\Models\SiteSetting();
            }
            
            $settings->customer_service_email = $request->customer_service_email;
            $settings->whatsapp_number = $request->whatsapp_number;
            $settings->whatsapp_float_button = $request->whatsapp_float_button;
            $settings->sales_email = $request->sales_email;
            $settings->support_email = $request->support_email;
            $settings->business_hours = $request->business_hours;
            
            // Asegurarse de que el nombre del sitio no sea nulo
            if (empty($settings->site_name)) {
                $settings->site_name = config('app.name');
            }
            
            $settings->save();
        }
        
        // Determinar qué número de WhatsApp usar para el botón flotante
        $whatsappNumber = $request->whatsapp_float_button ?: $request->whatsapp_number;
        
        // Limpiar el número (solo dígitos)
        $cleanNumber = preg_replace('/[^0-9]/', '', $whatsappNumber);
        
        // Actualizar la sesión con el número limpio
        session(['whatsapp_float_number' => $cleanNumber]);
        
        // Forzar la escritura de la sesión inmediatamente
        $request->session()->save();
        
        // También actualizar el localStorage vía JavaScript
        $script = "<script>
            if (typeof localStorage !== 'undefined') {
                localStorage.setItem('whatsapp_float_number', '" . $cleanNumber . "');
                console.log('Número de WhatsApp actualizado en localStorage:', '" . $cleanNumber . "');
                
                // Actualizar el botón si está en la página
                const whatsappButton = document.getElementById('whatsapp-float-button');
                if (whatsappButton) {
                    const cleanNumber = '" . $cleanNumber . "';
                    const whatsappUrl = 'https://wa.me/' + cleanNumber + '?text=' + encodeURIComponent('Hola, estoy interesado en sus productos.');
                    whatsappButton.href = whatsappUrl;
                    whatsappButton.setAttribute('data-whatsapp-number', cleanNumber);
                    console.log('Botón de WhatsApp actualizado con el número:', cleanNumber);
                }
            }
        </script>";

        return Redirect::route('profile.edit')
            ->with('status', 'contact-information-updated')
            ->with('success', '¡La información de contacto ha sido actualizada correctamente!')
            ->with('update_whatsapp_script', $script);
    }

    /**
     * Delete the user's account.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }
}
