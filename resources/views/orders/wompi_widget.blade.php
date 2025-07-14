<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Completa tu pago con Wompi') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-lg sm:rounded-lg">
                <div class="p-8 text-gray-900 flex flex-col items-center">
                    <h3 class="text-lg font-medium mb-4">Pedido #{{ $order->id }}</h3>
                    <div class="w-full bg-gray-50 rounded-lg p-4 mb-6">
                        <div class="flex flex-col sm:flex-row sm:justify-between mb-2">
                            <span class="font-medium">Referencia de pago:</span>
                            <span>{{ $order->order_number ?? '-' }}</span>
                        </div>
                        <div class="flex flex-col sm:flex-row sm:justify-between mb-2">
                            <span class="font-medium">Estado:</span>
                            <span class="capitalize">{{ $order->status }}</span>
                        </div>
                        <div class="flex flex-col sm:flex-row sm:justify-between">
                            <span class="font-medium">Total a pagar:</span>
                            <span class="font-bold text-gray-900">${{ number_format($order->total, 2) }}</span>
                        </div>
                    </div>

                    <!-- Wompi Widget -->
                    <div id="wompi-widget"></div>

                    <script src="https://checkout.wompi.co/widget.js"></script>
                    <script>
                        new WidgetCheckout({
                            currency: 'COP',
                            amountInCents: {{ intval($order->total * 100) }},
                            reference: '{{ $order->id }}',
                            publicKey: '{{ config('services.wompi.public_key') }}',
                            redirectUrl: '{{ route('wompi.callback', $order) }}',
                            signature: '', // Opcional: si tienes firma de seguridad
                            // customerData: {}, // Puedes agregar datos del cliente aquí
                        });
                    </script>

                    <div class="mt-8 w-full flex flex-col sm:flex-row gap-3">
                        <a href="{{ route('orders.show', $order) }}" class="flex-1 inline-block text-center bg-blue-600 hover:bg-blue-700 text-white font-bold py-3 px-6 rounded-lg shadow transition">Ver detalles del pedido</a>
                        <a href="{{ route('shop.index') }}" class="flex-1 inline-block text-center bg-gray-200 hover:bg-gray-300 text-gray-800 font-semibold py-3 px-6 rounded-lg shadow transition">Volver a la tienda</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
