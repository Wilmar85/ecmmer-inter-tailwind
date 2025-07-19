<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class ContactInfoCard extends Component
{
    public function render()
    {
        $admin = User::role('admin')->first();
        
        if (!$admin) {
            $admin = (object)[
                'whatsapp_number' => '+57 300 123 4567',
                'customer_service_email' => 'servicioalcliente@ejemplo.com',
                'sales_email' => 'ventas@ejemplo.com',
                'support_email' => 'soporte@ejemplo.com',
                'business_hours' => 'Lunes a Viernes: 8:00 AM - 6:00 PM, Sábados: 8:00 AM - 2:00 PM'
            ];
        }

        return view('livewire.admin.contact-info-card', [
            'contactInfo' => [
                'whatsapp_number' => $admin->whatsapp_number ?? '+57 300 123 4567',
                'customer_service_email' => $admin->customer_service_email ?? 'servicioalcliente@ejemplo.com',
                'sales_email' => $admin->sales_email ?? 'ventas@ejemplo.com',
                'support_email' => $admin->support_email ?? 'soporte@ejemplo.com',
                'business_hours' => $admin->business_hours ?? 'Lunes a Viernes: 8:00 AM - 6:00 PM, Sábados: 8:00 AM - 2:00 PM'
            ]
        ]);
    }
}
