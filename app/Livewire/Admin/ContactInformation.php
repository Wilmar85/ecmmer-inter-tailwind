<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Rule;

class ContactInformation extends Component
{
    public $customer_service_email;
    public $whatsapp_number;
    public $sales_email;
    public $support_email;
    public $business_hours;
    public $whatsapp_float_button = false;

    public function mount()
    {
        $user = Auth::user();
        $this->customer_service_email = $user->customer_service_email;
        $this->whatsapp_number = $user->whatsapp_number;
        $this->sales_email = $user->sales_email;
        $this->support_email = $user->support_email;
        $this->business_hours = $user->business_hours;
        $this->whatsapp_float_button = $user->whatsapp_float_button ?? false;
    }

    public function rules()
    {
        return [
            'customer_service_email' => ['nullable', 'email', 'max:255'],
            'whatsapp_number' => ['nullable', 'string', 'max:20'],
            'sales_email' => ['nullable', 'email', 'max:255'],
            'support_email' => ['nullable', 'email', 'max:255'],
            'business_hours' => ['nullable', 'string', 'max:255'],
            'whatsapp_float_button' => ['boolean'],
        ];
    }

    public function save()
    {
        $this->validate();

        $user = Auth::user();
        $user->update([
            'customer_service_email' => $this->customer_service_email,
            'whatsapp_number' => $this->whatsapp_number,
            'sales_email' => $this->sales_email,
            'support_email' => $this->support_email,
            'business_hours' => $this->business_hours,
            'whatsapp_float_button' => $this->whatsapp_float_button,
        ]);

        $this->dispatch('saved');
        
        // Clear the cache for contact information
        cache()->forget('contact_information');
    }

    public function render()
    {
        return view('livewire.admin.contact-information');
    }
}
