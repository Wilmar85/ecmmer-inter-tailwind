<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class ContactController extends Controller
{
    // Muestra el formulario de contacto
    public function show()
    {
        return view('contact');
    }

    // Procesa el envío del formulario de contacto
    public function submit(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required',
            'email' => 'required|email',
            'message' => 'required',
        ], [
            'name.required' => 'El nombre es obligatorio.',
            'email.required' => 'El correo es obligatorio.',
            'email.email' => 'El correo debe ser válido.',
            'message.required' => 'El mensaje es obligatorio.',
        ]);

        try {
            \Mail::to(env('MAIL_TO_ADDRESS', config('mail.from.address')))
                ->send(new \App\Mail\ContactMail(
                    $validated['name'],
                    $validated['email'],
                    $validated['message']
                ));
            return redirect()->route('contact')
                ->with('success', '¡Mensaje enviado correctamente!');
        } catch (\Exception $e) {
            \Log::error('Contact form error: ' . $e->getMessage());
            return redirect()->route('contact')
                ->withInput()
                ->with('error', 'Tu mensaje no fue enviado. Intenta nuevamente más tarde.');
        }
    }
}
