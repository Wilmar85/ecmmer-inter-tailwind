<div>
    @if (session()->has('message'))
        <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 5000)" 
             class="mb-6 rounded-md bg-green-50 p-4">
            <div class="flex">
                <div class="flex-shrink-0">
                    <svg class="h-5 w-5 text-green-400" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                    </svg>
                </div>
                <div class="ml-3">
                    <p class="text-sm font-medium text-green-800">{{ session('message') }}</p>
                </div>
            </div>
        </div>
    @endif

    <form wire:submit.prevent="save" class="space-y-8">
        <div class="bg-white shadow overflow-hidden sm:rounded-lg">
            <div class="px-4 py-5 sm:px-6 bg-gray-50">
                <h3 class="text-lg leading-6 font-medium text-gray-900">Información de Contacto</h3>
                <p class="mt-1 max-w-2xl text-sm text-gray-500">Administra la información de contacto que se muestra en el sitio web.</p>
            </div>
            
            <div class="border-t border-gray-200 px-4 py-5 sm:p-6">
                <div class="grid grid-cols-1 gap-y-6 gap-x-4 sm:grid-cols-6">
                    <!-- WhatsApp Number -->
                    <div class="sm:col-span-3">
                        <label for="whatsapp_number" class="block text-sm font-medium text-gray-700">
                            Número de WhatsApp <span class="text-red-500">*</span>
                        </label>
                        <div class="mt-1 relative rounded-md shadow-sm">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <svg class="h-5 w-5 text-gray-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                    <path d="M2 3a1 1 0 011-1h2.153a1 1 0 01.986.836l.74 4.435a1 1 0 01-.54 1.06l-1.548.773a11.037 11.037 0 006.105 6.105l.774-1.548a1 1 0 011.059-.54l4.435.74a1 1 0 01.836.986V17a1 1 0 01-1 1h-2C7.82 18 2 12.18 2 5V3z" />
                                </svg>
                            </div>
                            <input
                                type="text"
                                wire:model.lazy="whatsapp_number"
                                id="whatsapp_number"
                                class="block w-full pl-10 rounded-md border-gray-300 shadow-sm focus:border-primary-500 focus:ring-primary-500 sm:text-sm @error('whatsapp_number') border-red-300 text-red-900 placeholder-red-300 focus:border-red-500 focus:outline-none focus:ring-red-500 @enderror"
                                placeholder="+57 123 456 7890"
                                required
                            >
                        </div>
                        @error('whatsapp_number')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @else
                            <p class="mt-2 text-sm text-gray-500">
                                Número de contacto para WhatsApp (incluye código de país)
                            </p>
                        @enderror
                    </div>

                    <!-- WhatsApp Float Button -->
                    <div class="sm:col-span-3">
                        <div class="flex items-start">
                            <div class="flex items-center h-5">
                                <input
                                    id="whatsapp_float_button"
                                    wire:model.live="whatsapp_float_button"
                                    type="checkbox"
                                    class="h-4 w-4 rounded border-gray-300 text-primary-600 focus:ring-primary-500"
                                >
                            </div>
                            <div class="ml-3 text-sm">
                                <label for="whatsapp_float_button" class="font-medium text-gray-700">Mostrar botón flotante de WhatsApp</label>
                                <p class="text-gray-500">Activa o desactiva el botón flotante de WhatsApp en el sitio.</p>
                            </div>
                        </div>
                    </div>

                    <!-- Customer Service Email -->
                    <div class="sm:col-span-3">
                        <label for="customer_service_email" class="block text-sm font-medium text-gray-700">
                            Email de Servicio al Cliente <span class="text-red-500">*</span>
                        </label>
                        <div class="mt-1 relative rounded-md shadow-sm">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <svg class="h-5 w-5 text-gray-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                    <path d="M2.003 5.884L10 9.882l7.997-3.998A2 2 0 0016 4H4a2 2 0 00-1.997 1.884z" />
                                    <path d="M18 8.118l-8 4-8-4V14a2 2 0 002 2h12a2 2 0 002-2V8.118z" />
                                </svg>
                            </div>
                            <input
                                type="email"
                                wire:model.lazy="customer_service_email"
                                id="customer_service_email"
                                class="block w-full pl-10 rounded-md border-gray-300 shadow-sm focus:border-primary-500 focus:ring-primary-500 sm:text-sm @error('customer_service_email') border-red-300 text-red-900 placeholder-red-300 focus:border-red-500 focus:outline-none focus:ring-red-500 @enderror"
                                placeholder="servicio@ejemplo.com"
                                required
                            >
                        </div>
                        @error('customer_service_email')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Sales Email -->
                    <div class="sm:col-span-3">
                        <label for="sales_email" class="block text-sm font-medium text-gray-700">
                            Email de Ventas <span class="text-red-500">*</span>
                        </label>
                        <div class="mt-1 relative rounded-md shadow-sm">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <svg class="h-5 w-5 text-gray-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                    <path d="M2.003 5.884L10 9.882l7.997-3.998A2 2 0 0016 4H4a2 2 0 00-1.997 1.884z" />
                                    <path d="M18 8.118l-8 4-8-4V14a2 2 0 002 2h12a2 2 0 002-2V8.118z" />
                                </svg>
                            </div>
                            <input
                                type="email"
                                wire:model.lazy="sales_email"
                                id="sales_email"
                                class="block w-full pl-10 rounded-md border-gray-300 shadow-sm focus:border-primary-500 focus:ring-primary-500 sm:text-sm @error('sales_email') border-red-300 text-red-900 placeholder-red-300 focus:border-red-500 focus:outline-none focus:ring-red-500 @enderror"
                                placeholder="ventas@ejemplo.com"
                                required
                            >
                        </div>
                        @error('sales_email')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Support Email -->
                    <div class="sm:col-span-3">
                        <label for="support_email" class="block text-sm font-medium text-gray-700">
                            Email de Soporte <span class="text-red-500">*</span>
                        </label>
                        <div class="mt-1 relative rounded-md shadow-sm">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <svg class="h-5 w-5 text-gray-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h2a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd" />
                                </svg>
                            </div>
                            <input
                                type="email"
                                wire:model.lazy="support_email"
                                id="support_email"
                                class="block w-full pl-10 rounded-md border-gray-300 shadow-sm focus:border-primary-500 focus:ring-primary-500 sm:text-sm @error('support_email') border-red-300 text-red-900 placeholder-red-300 focus:border-red-500 focus:outline-none focus:ring-red-500 @enderror"
                                placeholder="soporte@ejemplo.com"
                                required
                            >
                        </div>
                        @error('support_email')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Business Hours -->
                    <div class="sm:col-span-3">
                        <label for="business_hours" class="block text-sm font-medium text-gray-700">
                            Horario de Atención <span class="text-red-500">*</span>
                        </label>
                        <div class="mt-1 relative rounded-md shadow-sm">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <svg class="h-5 w-5 text-gray-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z" clip-rule="evenodd" />
                                </svg>
                            </div>
                            <input
                                type="text"
                                wire:model.lazy="business_hours"
                                id="business_hours"
                                class="block w-full pl-10 rounded-md border-gray-300 shadow-sm focus:border-primary-500 focus:ring-primary-500 sm:text-sm @error('business_hours') border-red-300 text-red-900 placeholder-red-300 focus:border-red-500 focus:outline-none focus:ring-red-500 @enderror"
                                placeholder="Lunes a Viernes: 8:00 AM - 6:00 PM"
                                required
                            >
                        </div>
                        @error('business_hours')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div class="mt-8 flex justify-end space-x-3">
                    <a href="{{ route('admin.dashboard') }}" class="inline-flex items-center px-4 py-2 border border-gray-300 shadow-sm text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500">
                        Cancelar
                    </a>
                    <button
                        type="submit"
                        wire:loading.attr="disabled"
                        class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-primary-600 hover:bg-primary-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500"
                    >
                        <svg wire:loading wire:target="save" class="animate-spin -ml-1 mr-2 h-4 w-4 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                        </svg>
                        <span>Guardar Cambios</span>
                    </button>
                </div>
            </div>
        </div>
    </form>

    @push('scripts')
        <script>
            document.addEventListener('livewire:initialized', () => {
                @this.on('saved', () => {
                    const notification = document.createElement('div');
                    notification.className = 'fixed bottom-4 right-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded';
                    notification.role = 'alert';
                    notification.innerHTML = `
                        <div class="flex items-center">
                            <svg class="h-5 w-5 text-green-500 mr-2" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                            </svg>
                            <span>¡La información de contacto ha sido actualizada exitosamente!</span>
                        </div>
                    `;
                    document.body.appendChild(notification);
                    
                    // Remove notification after 5 seconds
                    setTimeout(() => {
                        notification.classList.add('opacity-0', 'transition-opacity', 'duration-300');
                        setTimeout(() => notification.remove(), 300);
                    }, 5000);
                });
            });
        </script>
    @endpush
</div>
