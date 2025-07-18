<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Validation\Rule;

class ContactInformationController extends Controller
{
    /**
     * Update the user's contact information.
     */
    public function update(Request $request)
    {
        $validated = $request->validate([
            'customer_service_email' => ['nullable', 'email', 'max:255'],
            'whatsapp_number' => ['nullable', 'string', 'max:20'],
            'sales_email' => ['nullable', 'email', 'max:255'],
            'support_email' => ['nullable', 'email', 'max:255'],
            'business_hours' => ['nullable', 'string', 'max:255'],
        ]);

        $user = $request->user();
        $user->fill($validated);
        $user->save();

        return back()->with('status', 'contact-information-updated');
    }
}
