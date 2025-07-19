<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Configuración del Sitio') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    @if (session('status'))
                        <div class="mb-4 font-medium text-sm text-green-600">
                            {{ session('status') }}
                        </div>
                    @endif

                    <form method="POST" action="{{ route('admin.settings.update', $settings->id) }}" class="space-y-6">
                        @csrf
                        @method('PUT')

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- Nombre del Sitio -->
                            <div>
                                <x-label for="site_name" :value="__('Nombre del Sitio')" />
                                <x-input id="site_name" class="block mt-1 w-full" type="text" name="site_name" :value="old('site_name', $settings->site_name)" required autofocus />
                                <x-input-error :messages="$errors->get('site_name')" class="mt-2" />
                            </div>

                            <!-- Correo de Atención al Cliente -->
                            <div>
                                <x-label for="customer_service_email" :value="__('Correo de Atención al Cliente')" />
                                <x-input id="customer_service_email" class="block mt-1 w-full" type="email" name="customer_service_email" :value="old('customer_service_email', $settings->customer_service_email)" required />
                                <x-input-error :messages="$errors->get('customer_service_email')" class="mt-2" />
                            </div>

                            <!-- Número de WhatsApp -->
                            <div>
                                <x-label for="whatsapp_number" :value="__('Número de WhatsApp')" />
                                <x-input id="whatsapp_number" class="block mt-1 w-full" type="text" name="whatsapp_number" :value="old('whatsapp_number', $settings->whatsapp_number)" required />
                                <x-input-error :messages="$errors->get('whatsapp_number')" class="mt-2" />
                                <p class="mt-1 text-sm text-gray-500">Formato: +1234567890</p>
                            </div>

                            <!-- Número para Botón Flotante de WhatsApp -->
                            <div>
                                <x-label for="whatsapp_float_button" :value="__('Número para Botón Flotante de WhatsApp (opcional)')" />
                                <x-input id="whatsapp_float_button" class="block mt-1 w-full" type="text" name="whatsapp_float_button" :value="old('whatsapp_float_button', $settings->whatsapp_float_button)" />
                                <x-input-error :messages="$errors->get('whatsapp_float_button')" class="mt-2" />
                                <p class="mt-1 text-sm text-gray-500">Si se deja vacío, se usará el número principal de WhatsApp</p>
                            </div>

                            <!-- Correo de Ventas -->
                            <div>
                                <x-label for="sales_email" :value="__('Correo de Ventas')" />
                                <x-input id="sales_email" class="block mt-1 w-full" type="email" name="sales_email" :value="old('sales_email', $settings->sales_email)" required />
                                <x-input-error :messages="$errors->get('sales_email')" class="mt-2" />
                            </div>

                            <!-- Correo de Soporte -->
                            <div>
                                <x-label for="support_email" :value="__('Correo de Soporte Técnico')" />
                                <x-input id="support_email" class="block mt-1 w-full" type="email" name="support_email" :value="old('support_email', $settings->support_email)" required />
                                <x-input-error :messages="$errors->get('support_email')" class="mt-2" />
                            </div>

                            <!-- Horario de Atención -->
                            <div class="md:col-span-2">
                                <x-label for="business_hours" :value="__('Horario de Atención')" />
                                <x-input id="business_hours" class="block mt-1 w-full" type="text" name="business_hours" :value="old('business_hours', $settings->business_hours)" required />
                                <x-input-error :messages="$errors->get('business_hours')" class="mt-2" />
                                <p class="mt-1 text-sm text-gray-500">Ej: Lunes a Viernes: 9:00 AM - 6:00 PM</p>
                            </div>

                            <!-- Dirección -->
                            <div class="md:col-span-2">
                                <x-label for="address" :value="__('Dirección')" />
                                <x-textarea id="address" class="block mt-1 w-full" name="address" rows="2">{{ old('address', $settings->address) }}</x-textarea>
                                <x-input-error :messages="$errors->get('address')" class="mt-2" />
                            </div>

                            <!-- Teléfono -->
                            <div>
                                <x-label for="phone" :value="__('Teléfono')" />
                                <x-input id="phone" class="block mt-1 w-full" type="text" name="phone" :value="old('phone', $settings->phone)" />
                                <x-input-error :messages="$errors->get('phone')" class="mt-2" />
                            </div>
                        </div>

                        <div class="flex items-center justify-end mt-6">
                            <x-button class="ml-4">
                                {{ __('Guardar Cambios') }}
                            </x-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
