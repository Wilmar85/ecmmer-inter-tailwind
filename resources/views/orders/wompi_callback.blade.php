<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Estado del Pago - Wompi') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-lg sm:rounded-lg">
                <div class="p-8 text-gray-900 flex flex-col items-center">
                    @php
                        $status = $order->status;
                        $statusColor = [
                            'processing' => 'green',
                            'completed' => 'green',
                            'paid' => 'green',
                            'pending' => 'yellow',
                            'pending_pickup' => 'yellow',
                            'failed' => 'red',
                            'cancelled' => 'red',
                        ][$status] ?? 'yellow';
                        $icon = [
                            'green' => '<svg class="w-16 h-16 mx-auto mb-4 text-green-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10" stroke="currentColor" stroke-width="2" fill="none"/><path stroke-linecap="round" stroke-linejoin="round" d="M8 12l2.5 2.5L16 9"/></svg>',
                            'yellow' => '<svg class="w-16 h-16 mx-auto mb-4 text-yellow-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10" stroke="currentColor" stroke-width="2" fill="none"/><path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4m0 4h.01"/></svg>',
                            'red' => '<svg class="w-16 h-16 mx-auto mb-4 text-red-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10" stroke="currentColor" stroke-width="2" fill="none"/><path stroke-linecap="round" stroke-linejoin="round" d="M15 9l-6 6m0-6l6 6"/></svg>',
                        ][$statusColor];
                        $mainMsg = [
                            'green' => '¡Pago exitoso!',
                            'yellow' => 'Pago pendiente de confirmación',
                            'red' => 'Pago fallido o cancelado',
                        ][$statusColor];
                        $descMsg = [
                            'green' => 'Tu pedido ha sido procesado correctamente. Recibirás confirmación en tu correo.',
                            'yellow' => 'Estamos procesando tu pago. Te notificaremos cuando se confirme.',
                            'red' => 'El pago no se completó. Si crees que es un error, comunícate con soporte.',
                        ][$statusColor];
                    @endphp

                    {!! $icon !!}
                    <h3 class="text-2xl font-semibold mb-2 text-{{ $statusColor }}-600">{{ $mainMsg }}</h3>
                    <p class="mb-6 text-gray-700">{{ $descMsg }}</p>

                    <div class="w-full bg-gray-50 rounded-lg p-4 mb-6">
                        <div class="flex flex-col sm:flex-row sm:justify-between mb-2">
                            <span class="font-medium">Pedido:</span>
                            <span>#{{ $order->id }}</span>
                        </div>
                        <div class="flex flex-col sm:flex-row sm:justify-between mb-2">
                            <span class="font-medium">Referencia de pago:</span>
                            <span>{{ $order->order_number ?? '-' }}</span>
                        </div>
                        <div class="flex flex-col sm:flex-row sm:justify-between mb-2">
                            <span class="font-medium">Estado:</span>
                            <span class="capitalize">{{ $order->status }}</span>
                        </div>
                        <div class="flex flex-col sm:flex-row sm:justify-between">
                            <span class="font-medium">Total pagado:</span>
                            <span class="font-bold text-gray-900">${{ number_format($order->total, 2) }}</span>
                        </div>
                    </div>

                    <div class="flex flex-col sm:flex-row gap-3 w-full">
                        <a href="{{ route('orders.show', $order) }}" class="flex-1 inline-block text-center bg-blue-600 hover:bg-blue-700 text-white font-bold py-3 px-6 rounded-lg shadow transition">Ver detalles del pedido</a>
                        <a href="{{ route('shop.index') }}" class="flex-1 inline-block text-center bg-gray-200 hover:bg-gray-300 text-gray-800 font-semibold py-3 px-6 rounded-lg shadow transition">Volver a la tienda</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
