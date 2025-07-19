<div class="bg-white overflow-hidden shadow-sm sm:rounded-lg border border-gray-100">
    <div class="p-6">
        <h3 class="text-lg font-medium text-gray-900 mb-4 flex items-center">
            <svg class="w-5 h-5 mr-2 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path>
            </svg>
            Información de Contacto
        </h3>
        
        <div class="space-y-4">
            <div class="flex items-start">
                <svg class="h-5 w-5 text-gray-500 mt-0.5 mr-3 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                </svg>
                <div>
                    <p class="text-sm font-medium text-gray-700">WhatsApp</p>
                    <a href="https://wa.me/{{ preg_replace('/[^0-9+]/', '', $contactInfo['whatsapp_number']) }}" target="_blank" class="text-sm text-gray-600 hover:text-blue-600">
                        {{ $contactInfo['whatsapp_number'] }}
                    </a>
                </div>
            </div>

            <div class="flex items-start">
                <svg class="h-5 w-5 text-gray-500 mt-0.5 mr-3 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                </svg>
                <div>
                    <p class="text-sm font-medium text-gray-700">Servicio al Cliente</p>
                    <a href="mailto:{{ $contactInfo['customer_service_email'] }}" class="text-sm text-gray-600 hover:text-blue-600">
                        {{ $contactInfo['customer_service_email'] }}
                    </a>
                </div>
            </div>

            @if(!empty($contactInfo['sales_email']))
            <div class="flex items-start">
                <svg class="h-5 w-5 text-gray-500 mt-0.5 mr-3 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                </svg>
                <div>
                    <p class="text-sm font-medium text-gray-700">Ventas</p>
                    <a href="mailto:{{ $contactInfo['sales_email'] }}" class="text-sm text-gray-600 hover:text-blue-600">
                        {{ $contactInfo['sales_email'] }}
                    </a>
                </div>
            </div>
            @endif

            @if(!empty($contactInfo['support_email']))
            <div class="flex items-start">
                <svg class="h-5 w-5 text-gray-500 mt-0.5 mr-3 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 5.636l-3.536 3.536m0 5.656l3.536 3.536M9.172 9.172L5.636 5.636m3.536 9.192l-3.536 3.536M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                <div>
                    <p class="text-sm font-medium text-gray-700">Soporte Técnico</p>
                    <a href="mailto:{{ $contactInfo['support_email'] }}" class="text-sm text-gray-600 hover:text-blue-600">
                        {{ $contactInfo['support_email'] }}
                    </a>
                </div>
            </div>
            @endif

            <div class="flex items-start">
                <svg class="h-5 w-5 text-gray-500 mt-0.5 mr-3 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                <div>
                    <p class="text-sm font-medium text-gray-700">Horario de Atención</p>
                    <p class="text-sm text-gray-600">{{ $contactInfo['business_hours'] }}</p>
                </div>
            </div>
        </div>

        <div class="mt-6">
            <a href="{{ route('admin.contact-information') }}" class="inline-flex items-center text-sm font-medium text-blue-600 hover:text-blue-800">
                Editar información de contacto
                <svg class="ml-1 w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                </svg>
            </a>
        </div>
    </div>
</div>
