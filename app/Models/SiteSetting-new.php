<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SiteSetting extends Model
{
    protected $fillable = [
        'site_name',
        'customer_service_email',
        'whatsapp_number',
        'whatsapp_float_button',
        'sales_email',
        'support_email',
        'business_hours',
        'address',
        'phone'
    ];

    /**
     * Obtener la configuración del sitio
     * Si no existe, crea un registro por defecto
     *
     * @return SiteSetting
     */
    public static function getSettings()
    {
        $settings = self::first();
        
        if (!$settings) {
            $settings = self::create([
                'site_name' => 'Mi Tienda',
                'customer_service_email' => 'contacto@midominio.com',
                'whatsapp_number' => '+1234567890',
                'business_hours' => 'Lunes a Viernes: 9:00 AM - 6:00 PM',
            ]);
        }
        
        return $settings;
    }
}
