<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Error en el Pago') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                <div class="text-center">
                    <div class="mb-4">
                        <svg class="mx-auto h-12 w-12 text-red-500" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </div>
                    <h3 class="text-lg leading-6 font-medium text-gray-900 mb-2">
                        Lo sentimos, hubo un problema con tu pago
                    </h3>
                    <p class="text-sm text-gray-500 mb-4">
                        Tu orden #{{ $order->id }} no pudo ser procesada.
                    </p>
                    <div class="border-t border-gray-200 pt-4">
                        <p class="text-sm text-gray-600 mb-4">
                            Por favor, intenta realizar el pago nuevamente o contacta con nuestro servicio de atención
                            al cliente si el problema persiste.
                        </p>
                    </div>
                    <div class="mt-6 space-y-3 sm:space-y-0 sm:space-x-3">
                        <a href="{{ route('checkout.index') }}"
                            class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                            Intentar Nuevamente
                        </a>
                        <a href="{{ route('cart.index') }}"
                            class="inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                            Volver al Carrito
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
