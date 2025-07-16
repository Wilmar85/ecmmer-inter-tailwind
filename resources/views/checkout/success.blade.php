<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('¡Pago Exitoso!') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <!-- Resumen del Pedido -->
                <div class="md:col-span-2">
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                        <div class="text-center mb-6">
                            <div class="mx-auto flex items-center justify-center h-12 w-12 rounded-full bg-primary">
                                <svg class="h-6 w-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                </svg>
                            </div>
                            <h3 class="mt-3 text-xl font-bold text-dark-text">¡Gracias por tu compra!</h3>
                            <p class="mt-1 text-base text-light-text">Tu orden #{{ $order->id }} ha sido procesada exitosamente.</p>
                        </div>

                        <!-- Información del Pedido -->
                        <div class="bg-gray-50 p-4 rounded-lg mb-6">
                            <h4 class="text-lg font-semibold text-dark-text mb-3">Resumen del Pedido</h4>
                            
                            <div class="space-y-4">
                                <div class="flex justify-between text-sm">
                                    <span class="text-gray-600">Número de Orden</span>
                                    <span class="font-medium">#{{ $order->id }}</span>
                                </div>

                                @if($order->shipping_method === 'delivery')
                                <div class="border-t border-gray-200 pt-3">
                                    <h5 class="text-base font-semibold text-dark-text mb-2">Dirección de Envío</h5>
                                    <p class="text-sm text-gray-600">{{ $order->shipping_address }}</p>
                                    <p class="text-sm text-gray-600">{{ $order->shipping_city }}, {{ $order->shipping_state }}</p>
                                    <p class="text-sm text-gray-600">CP: {{ $order->shipping_postal_code }}</p>
                                </div>
                                @else
                                <div class="border-t border-gray-200 pt-3">
                                    <h5 class="text-base font-semibold text-dark-text mb-1">Método de Entrega</h5>
                                    <p class="text-sm text-gray-600">Recoger en tienda</p>
                                </div>
                                @endif
                            </div>
                        </div>

                        <!-- Productos -->
                        <div class="mb-6">
                            <h4 class="text-md font-medium text-gray-900 mb-3">Productos</h4>
                            <div class="space-y-4">
                                @foreach($order->items as $item)
                                <div class="flex justify-between items-center py-2 border-b border-gray-100">
                                    <div>
                                        <p class="text-sm font-medium text-gray-900">{{ $item->product_name }}</p>
                                        <p class="text-xs text-gray-500">Cantidad: {{ $item->quantity }}</p>
                                    </div>
                                    <span class="text-sm font-medium text-gray-900">${{ number_format($item->price * $item->quantity, 2) }}</span>
                                </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Resumen de Pago -->
                <div class="md:col-span-1">
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6 sticky top-6">
                            <h3 class="text-xl font-bold text-dark-text mb-4 border-b pb-2">Resumen del Pago</h3>
                        
                        <div class="space-y-3">
                            @php
                                // Calcular el subtotal de los productos (sin IVA)
                                $subtotal = $order->items->sum(function($item) {
                                    return $item->quantity * $item->price;
                                });
                                
                                // Calcular el IVA (19% del subtotal)
                                $iva = $subtotal * 0.19;
                                
                                // Calcular el costo de envío
                                $shipping = 0;
                                if($order->shipping_method === 'delivery') {
                                    $shipping = $order->shipping_cost ?? 0;
                                }
                                
                                // Calcular el total (subtotal + IVA + envío)
                                $total = $subtotal + $iva + $shipping;
                            @endphp

                            <div class="flex justify-between text-sm">
                                <span class="text-gray-600">Subtotal</span>
                                <span class="font-medium">${{ number_format($subtotal, 2) }}</span>
                            </div>

                            <div class="flex justify-between text-sm">
                                <span class="text-gray-600">IVA (19%)</span>
                                <span class="font-medium">${{ number_format($iva, 2) }}</span>
                            </div>

                            @if($shipping > 0)
                            <div class="flex justify-between text-sm">
                                <span class="text-gray-600">Envío</span>
                                <span class="font-medium">${{ number_format($shipping, 2) }}</span>
                            </div>
                            @endif

                            <div class="border-t border-gray-200 pt-3 mt-3">
                                <div class="flex justify-between text-base font-medium text-gray-900">
                                    <span>Total</span>
                                    <span>${{ number_format($total, 2) }}</span>
                                </div>
                            </div>

                            <div class="mt-6">
                                <a href="{{ route('orders.index') }}" class="w-full flex justify-center py-2 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-dark-text bg-primary hover:bg-primary/90 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary">
                                    Ver Mis Pedidos
                                </a>
                            </div>

                            <div class="mt-4 text-center">
                                <p class="text-sm text-light-text">¿Necesitas ayuda? <a href="{{ route('contact') }}" class="text-dark-text hover:text-primary/80">Contáctanos</a></p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
