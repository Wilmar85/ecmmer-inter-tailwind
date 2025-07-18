<section class="mt-10">
    <header>
        <h2 class="text-lg font-medium text-gray-900">
            {{ __('Información de Contacto') }}
        </h2>

        <p class="mt-1 text-sm text-gray-600">
            {{ __('Actualiza la información de contacto para atención al cliente.') }}
        </p>
    </header>

    <form method="post" action="{{ route('profile.contact.update') }}" class="mt-6 space-y-6">
        @csrf
        @method('patch')

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <!-- Correo de atención al cliente -->
            <div>
                <x-input-label for="customer_service_email" :value="__('Correo de Atención al Cliente')" />
                <x-text-input id="customer_service_email" name="customer_service_email" type="email" class="mt-1 block w-full" 
                    :value="old('customer_service_email', $user->customer_service_email)" autocomplete="email" />
                <x-input-error class="mt-2" :messages="$errors->get('customer_service_email')" />
            </div>

            <!-- Número de WhatsApp -->
            <div>
                <x-input-label for="whatsapp_number" :value="__('Número de WhatsApp')" />
                <x-text-input id="whatsapp_number" name="whatsapp_number" type="text" class="mt-1 block w-full" 
                    :value="old('whatsapp_number', $user->whatsapp_number)" placeholder="Ej: +1234567890" />
                <x-input-error class="mt-2" :messages="$errors->get('whatsapp_number')" />
                <p class="mt-1 text-xs text-gray-500">Este número se mostrará en la sección de contacto.</p>
            </div>

            <!-- Número para Botón Flotante de WhatsApp -->
            <div>
                <x-input-label for="whatsapp_float_button" :value="__('Número para Botón Flotante de WhatsApp')" />
                <x-text-input id="whatsapp_float_button" name="whatsapp_float_button" type="text" class="mt-1 block w-full" 
                    :value="old('whatsapp_float_button', $user->whatsapp_float_button)" placeholder="Ej: +573001234567" />
                <x-input-error class="mt-2" :messages="$errors->get('whatsapp_float_button')" />
                <p class="mt-1 text-xs text-gray-500">Este número se usará para el botón flotante de WhatsApp.</p>
            </div>

            <!-- Correo de Ventas -->
            <div>
                <x-input-label for="sales_email" :value="__('Correo de Ventas')" />
                <x-text-input id="sales_email" name="sales_email" type="email" class="mt-1 block w-full" 
                    :value="old('sales_email', $user->sales_email)" autocomplete="email" />
                <x-input-error class="mt-2" :messages="$errors->get('sales_email')" />
            </div>

            <!-- Correo de Soporte -->
            <div>
                <x-input-label for="support_email" :value="__('Correo de Soporte Técnico')" />
                <x-text-input id="support_email" name="support_email" type="email" class="mt-1 block w-full" 
                    :value="old('support_email', $user->support_email)" autocomplete="email" />
                <x-input-error class="mt-2" :messages="$errors->get('support_email')" />
            </div>

            <!-- Horario de Atención -->
            <div class="md:col-span-2">
                <x-input-label for="business_hours" :value="__('Horario de Atención')" />
                <x-text-input id="business_hours" name="business_hours" type="text" class="mt-1 block w-full" 
                    :value="old('business_hours', $user->business_hours)" 
                    placeholder="Ej: Lunes a Viernes: 9:00 AM - 6:00 PM" />
                <x-input-error class="mt-2" :messages="$errors->get('business_hours')" />
            </div>
        </div>

        <div class="flex items-center gap-4">
            <x-primary-button>{{ __('Guardar Cambios') }}</x-primary-button>

            @if (session('status') === 'contact-information-updated')
                <div
                    x-data="{ show: true }"
                    x-show="show"
                    x-transition
                    x-init="setTimeout(() => show = false, 3000)"
                    class="p-3 bg-green-100 border border-green-400 text-green-700 rounded relative"
                    role="alert"
                >
                    <strong class="font-bold">{{ __('¡Guardado!') }}</strong>
                    <span class="block sm:inline">{{ __('La información de contacto ha sido actualizada correctamente.') }}</span>
                </div>
            @endif
        </div>
    </form>
</section>
