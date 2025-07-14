<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Detalles del Pedido #') . $order->id }}
            </h2>
            <a href="{{ route('orders.history') }}"
                class="bg-gray-200 hover:bg-gray-300 text-gray-700 font-bold py-2 px-4 rounded">
                Volver a Mis Pedidos
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <!-- Mensajes de feedback de pago -->
                    @if (session('success'))
                        <div class="mb-4 rounded-lg bg-green-100 px-4 py-3 text-green-800 border border-green-300">
                            <strong>¡Éxito!</strong> {{ session('success') }}
                        </div>
                    @endif
                    @if (session('error'))
                        <div class="mb-4 rounded-lg bg-red-100 px-4 py-3 text-red-800 border border-red-300">
                            <strong>Error:</strong> {{ session('error') }}
                        </div>
                    @endif
                    <!-- Estado del Pedido -->
                    <div class="mb-8">
                        <div class="flex items-center justify-between bg-gray-50 p-4 rounded-lg">
                            <div>
                                <p class="text-sm text-gray-500">Estado del pedido</p>
                                <span
                                    class="mt-1 px-2 inline-flex text-sm leading-5 font-semibold rounded-full
                                    {{ $order->status === 'pending' ? 'bg-yellow-100 text-yellow-800' : '' }}
                                    {{ $order->status === 'processing' ? 'bg-blue-100 text-blue-800' : '' }}
                                    {{ $order->status === 'completed' ? 'bg-green-100 text-green-800' : '' }}
                                    {{ $order->status === 'cancelled' ? 'bg-red-100 text-red-800' : '' }}">
                                    {{ ucfirst($order->status) }}
                                </span>
                            </div>
                            <div class="text-right">
                                <p class="text-sm text-gray-500">Fecha del pedido</p>
                                <p class="mt-1 text-sm font-medium text-gray-900">
                                    {{ $order->created_at->format('d/m/Y H:i') }}</p>
                            </div>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Comprobante de Pago -->
                        @if($order->payment_proof)
                        <div class="bg-gray-50 p-6 rounded-lg">
                            <h3 class="text-lg font-medium text-gray-900 mb-4">Comprobante de Pago</h3>
                            <img src="{{ asset('storage/' . $order->payment_proof) }}" alt="Comprobante de pago" class="w-full max-w-xs rounded shadow border">
                            <a href="{{ asset('storage/' . $order->payment_proof) }}" target="_blank" class="block mt-2 text-indigo-600 hover:underline text-sm">Ver tamaño completo</a>
                        </div>
                        @endif
                        <!-- Información de Envío -->
                        <div class="bg-gray-50 p-6 rounded-lg">
                            <h3 class="text-lg font-medium text-gray-900 mb-4">Información de Envío</h3>
                            <dl class="grid grid-cols-1 gap-4">
                                <div>
                                    <dt class="text-sm font-medium text-gray-500">Nombre</dt>
                                    <dd class="mt-1 text-sm text-gray-900">{{ $order->name }}</dd>
                                </div>
                                <div>
                                    <dt class="text-sm font-medium text-gray-500">Email</dt>
                                    <dd class="mt-1 text-sm text-gray-900">{{ $order->email }}</dd>
                                </div>
                                <div>
                                    <dt class="text-sm font-medium text-gray-500">Teléfono</dt>
                                    <dd class="mt-1 text-sm text-gray-900">{{ $order->phone }}</dd>
                                </div>
                                <div>
                                    <dt class="text-sm font-medium text-gray-500">Dirección</dt>
                                    <dd class="mt-1 text-sm text-gray-900">{{ $order->shipping_address }}</dd>
                                </div>
                                <div>
                                    <dt class="text-sm font-medium text-gray-500">Ciudad</dt>
                                    <dd class="mt-1 text-sm text-gray-900">{{ $order->shipping_city }}</dd>
                                </div>
                                <div>
                                    <dt class="text-sm font-medium text-gray-500">Código Postal</dt>
                                    <dd class="mt-1 text-sm text-gray-900">{{ $order->shipping_zip }}</dd>
                                </div>
                            </dl>
                        </div>

                        <!-- Información del Pago -->
                        <div class="bg-gray-50 p-6 rounded-lg">
                            <h3 class="text-lg font-medium text-gray-900 mb-4">Información del Pago</h3>
                            <dl class="grid grid-cols-1 gap-4">
                                <div>
                                    <dt class="text-sm font-medium text-gray-500">Método de Pago</dt>
                                    <dd class="mt-1 text-sm text-gray-900">{{ ucfirst($order->payment_method) }}</dd>
                                </div>
                                <div>
                                    <dt class="text-sm font-medium text-gray-500">Estado del Pago</dt>
                                    <dd class="mt-1">
                                        <span
                                            class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                            Pagado
                                        </span>
                                    </dd>
                                </div>
                                <div>
                                    <dt class="text-sm font-medium text-gray-500">Total</dt>
                                    <dd class="mt-1 text-lg font-medium text-gray-900">
                                        ${{ number_format($order->total, 2) }}</dd>
                                </div>
                            </dl>
                        </div>
                    </div>

                    <!-- Productos del Pedido -->
                    <div class="mt-8">
                        <h3 class="text-lg font-medium text-gray-900 mb-4">Productos del Pedido</h3>
                        <div class="bg-gray-50 rounded-lg overflow-hidden">
                            <div class="flow-root">
                                <ul role="list" class="divide-y divide-gray-200">
                                    @foreach ($order->items as $item)
                                        <li class="p-6">
                                            <div class="flex items-center">
                                                <div
                                                    class="flex-shrink-0 w-24 h-24 border border-gray-200 rounded-md overflow-hidden">
                                                    @if ($item->product->images->isNotEmpty())
                                                        <img src="{{ asset('storage/' . $item->product->images->first()->path) }}"
                                                            alt="{{ $item->product->name }}"
                                                            class="w-full h-full object-center object-cover">
                                                    @else
                                                        <div
                                                            class="w-full h-full bg-gray-200 flex items-center justify-center">
                                                            <span class="text-gray-500 text-xs">Sin imagen</span>
                                                        </div>
                                                    @endif
                                                </div>

                                                <div class="ml-6 flex-1">
                                                    <div class="flex items-center justify-between">
                                                        <div>
                                                            <h4 class="text-sm font-medium text-gray-900">
                                                                {{ $item->product->name }}</h4>
                                                            <p class="mt-1 text-sm text-gray-500">Cantidad:
                                                                {{ $item->quantity }}</p>
                                                        </div>
                                                        <div class="ml-4">
                                                            <p class="text-sm font-medium text-gray-900">
                                                                ${{ number_format($item->price, 2) }} c/u</p>
                                                            <p class="mt-1 text-sm text-gray-500">Subtotal:
                                                                ${{ number_format($item->subtotal, 2) }}</p>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                            <div class="border-t border-gray-200 px-6 py-4">
                                <div class="flex justify-between text-base font-medium text-gray-900">
                                    <p>Total</p>
                                    <p>${{ number_format($order->total, 2) }}</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    @if ($order->status === 'pending' || $order->status === 'processing')
                        <div class="mt-8 text-center">
                            <p class="text-sm text-gray-500">¿Tienes alguna pregunta sobre tu pedido?</p>
                            <a href="#"
                                class="mt-2 inline-flex items-center text-sm font-medium text-blue-600 hover:text-blue-500">
                                Contactar con soporte
                                <span aria-hidden="true"> &rarr;</span>
                            </a>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
