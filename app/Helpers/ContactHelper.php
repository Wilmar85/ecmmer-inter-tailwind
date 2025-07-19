<?php

namespace App\Helpers;

use App\Models\User;
use Illuminate\Support\Facades\Cache;

class ContactHelper
{
    public static function getContactInfo()
    {
        return Cache::remember('contact_information', now()->addDay(), function () {
            $admin = User::where('role', User::ROLE_ADMIN)->first();
            
            if (!$admin) {
                return [
                    'whatsapp_number' => '+57 123 456 7890',
                    'customer_service_email' => 'servicio@interelectricosaf.com',
                    'sales_email' => 'ventas@interelectricosaf.com',
                    'support_email' => 'soporte@interelectricosaf.com',
                    'business_hours' => 'Lunes a Viernes: 8:00 AM - 6:00 PM',
                    'whatsapp_float_button' => true,
                ];
            }

            return [
                'whatsapp_number' => $admin->whatsapp_number ?? '+57 123 456 7890',
                'customer_service_email' => $admin->customer_service_email ?? 'servicio@interelectricosaf.com',
                'sales_email' => $admin->sales_email ?? 'ventas@interelectricosaf.com',
                'support_email' => $admin->support_email ?? 'soporte@interelectricosaf.com',
                'business_hours' => $admin->business_hours ?? 'Lunes a Viernes: 8:00 AM - 6:00 PM',
                'whatsapp_float_button' => $admin->whatsapp_float_button ?? true,
            ];
        });
    }

    public static function getWhatsAppUrl($number = null)
    {
        $contact = self::getContactInfo();
        $number = $number ?? $contact['whatsapp_number'];
        $cleanNumber = preg_replace('/[^0-9+]/', '', $number);
        return "https://wa.me/{$cleanNumber}";
    }
}
