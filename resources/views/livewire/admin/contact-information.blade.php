<div>
    <form wire:submit="save" class="space-y-6">
        <div class="bg-white shadow sm:rounded-lg">
            <div class="px-4 py-5 sm:p-6">
                <h3 class="text-lg font-medium leading-6 text-gray-900">Información de Contacto</h3>
                <p class="mt-1 text-sm text-gray-500">Esta información se mostrará en el sitio web.</p>
                
                <div class="mt-6 grid grid-cols-1 gap-y-6 gap-x-4 sm:grid-cols-6">
                    <!-- WhatsApp Number -->
                    <div class="sm:col-span-3">
                        <label for="whatsapp_number" class="block text-sm font-medium text-gray-700">
                            Número de WhatsApp
                        </label>
                        <div class="mt-1">
                            <input
                                type="text"
                                wire:model="whatsapp_number"
                                id="whatsapp_number"
                                class="block w-full rounded-md border-gray-300 shadow-sm focus:border-primary-500 focus:ring-primary-500 sm:text-sm"
                                placeholder="+57 123 456 7890"
                            >
                        </div>
                        <p class="mt-2 text-sm text-gray-500">
                            Número de contacto para WhatsApp (incluye código de país)
                        </p>
                    </div>

                    <!-- WhatsApp Float Button -->
                    <div class="sm:col-span-3">
                        <div class="flex items-start">
                            <div class="flex h-5 items-center">
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
                            Email de Servicio al Cliente
                        </label>
                        <div class="mt-1">
                            <input
                                type="email"
                                wire:model="customer_service_email"
                                id="customer_service_email"
                                class="block w-full rounded-md border-gray-300 shadow-sm focus:border-primary-500 focus:ring-primary-500 sm:text-sm"
                                placeholder="servicio@ejemplo.com"
                            >
                        </div>
                    </div>

                    <!-- Sales Email -->
                    <div class="sm:col-span-3">
                        <label for="sales_email" class="block text-sm font-medium text-gray-700">
                            Email de Ventas
                        </label>
                        <div class="mt-1">
                            <input
                                type="email"
                                wire:model="sales_email"
                                id="sales_email"
                                class="block w-full rounded-md border-gray-300 shadow-sm focus:border-primary-500 focus:ring-primary-500 sm:text-sm"
                                placeholder="ventas@ejemplo.com"
                            >
                        </div>
                    </div>

                    <!-- Support Email -->
                    <div class="sm:col-span-3">
                        <label for="support_email" class="block text-sm font-medium text-gray-700">
                            Email de Soporte
                        </label>
                        <div class="mt-1">
                            <input
                                type="email"
                                wire:model="support_email"
                                id="support_email"
                                class="block w-full rounded-md border-gray-300 shadow-sm focus:border-primary-500 focus:ring-primary-500 sm:text-sm"
                                placeholder="soporte@ejemplo.com"
                            >
                        </div>
                    </div>

                    <!-- Business Hours -->
                    <div class="sm:col-span-3">
                        <label for="business_hours" class="block text-sm font-medium text-gray-700">
                            Horario de Atención
                        </label>
                        <div class="mt-1">
                            <input
                                type="text"
                                wire:model="business_hours"
                                id="business_hours"
                                class="block w-full rounded-md border-gray-300 shadow-sm focus:border-primary-500 focus:ring-primary-500 sm:text-sm"
                                placeholder="Lunes a Viernes: 8:00 AM - 6:00 PM"
                            >
                        </div>
                    </div>
                </div>

                <div class="mt-8 flex justify-end">
                    <button
                        type="submit"
                        class="ml-3 inline-flex justify-center rounded-md border border-transparent bg-primary-600 py-2 px-4 text-sm font-medium text-white shadow-sm hover:bg-primary-700 focus:outline-none focus:ring-2 focus:ring-primary-500 focus:ring-offset-2"
                    >
                        Guardar Cambios
                    </button>
                </div>
            </div>
        </div>
    </form>

    @if (session()->has('saved'))
        <div class="fixed bottom-4 right-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded" role="alert">
            <span class="block sm:inline">¡La información de contacto ha sido actualizada exitosamente!</span>
        </div>
    @endif
</div>
