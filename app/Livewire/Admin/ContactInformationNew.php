<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Livewire\Attributes\Rule;

class ContactInformationNew extends Component
{
    #[Rule('required|email|max:255')]
    public $customer_service_email;
    
    #[Rule('required|string|max:20')]
    public $whatsapp_number;
    
    #[Rule('required|email|max:255')]
    public $sales_email;
    
    #[Rule('required|email|max:255')]
    public $support_email;
    
    #[Rule('required|string|max:255')]
    public $business_hours;
    
    public $whatsapp_float_button = false;

    public function mount()
    {
        // Get the admin user with contact information
        $admin = User::where('role', User::ROLE_ADMIN)->first();
        
        if ($admin) {
            $this->customer_service_email = $admin->customer_service_email;
            $this->whatsapp_number = $admin->whatsapp_number;
            $this->sales_email = $admin->sales_email;
            $this->support_email = $admin->support_email;
            $this->business_hours = $admin->business_hours;
            $this->whatsapp_float_button = (bool) $admin->whatsapp_float_button;
        }
    }

    public function save()
    {
        $this->validate();

        // Get the admin user
        $admin = User::where('role', User::ROLE_ADMIN)->firstOrFail();
        
        // Update the contact information
        $admin->update([
            'customer_service_email' => $this->customer_service_email,
            'whatsapp_number' => $this->whatsapp_number,
            'sales_email' => $this->sales_email,
            'support_email' => $this->support_email,
            'business_hours' => $this->business_hours,
            'whatsapp_float_button' => $this->whatsapp_float_button,
        ]);

        // Clear the contact information cache
        Cache::forget('contact_information');
        
        // Show success message
        session()->flash('message', '¡La información de contacto ha sido actualizada exitosamente!');
        
        // Emit event for the notification
        $this->dispatch('saved');
    }

    public function render()
    {
        return view('livewire.admin.contact-information-new');
    }
}
