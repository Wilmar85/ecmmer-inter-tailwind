<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SiteSetting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class SiteSettingController extends Controller
{
    /**
     * Display the site settings form.
     */
    public function edit()
    {
        $settings = SiteSetting::getSettings();
        return view('admin.settings.edit', compact('settings'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, SiteSetting $setting)
    {
        $validated = $request->validate([
            'site_name' => 'required|string|max:255',
            'customer_service_email' => 'required|email|max:255',
            'whatsapp_number' => 'required|string|max:20',
            'whatsapp_float_button' => 'nullable|string|max:20',
            'sales_email' => 'required|email|max:255',
            'support_email' => 'required|email|max:255',
            'business_hours' => 'required|string|max:255',
            'address' => 'nullable|string|max:500',
            'phone' => 'nullable|string|max:20',
        ]);

        $setting->update($validated);

        // Actualizar la caché de configuración si es necesario
        // Cache::forget('site_settings');

        // Actualizar la sesión con el número de WhatsApp para el botón flotante
        $whatsappNumber = $request->whatsapp_float_button ?: $request->whatsapp_number;
        $cleanNumber = preg_replace('/[^0-9]/', '', $whatsappNumber);
        
        Session::put('whatsapp_float_number', $cleanNumber);
        
        // Forzar la escritura de la sesión inmediatamente
        Session::save();

        return redirect()->route('admin.settings.edit')
            ->with('status', 'La configuración se ha actualizado correctamente.');
    }
}
