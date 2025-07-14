<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Mis Pedidos') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    @if ($orders->isEmpty())
                        <div class="text-center py-8">
                            <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                            </svg>
                            <h3 class="mt-2 text-sm font-medium text-gray-900">No hay pedidos</h3>
                            <p class="mt-1 text-sm text-gray-500">Aún no has realizado ningún pedido.</p>
                            <div class="mt-6">
                                <a href="{{ route('products.index') }}"
                                    class="inline-flex items-center px-4 py-2 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                                    <svg class="-ml-1 mr-2 h-5 w-5" xmlns="http://www.w3.org/2000/svg"
                                        viewBox="0 0 20 20" fill="currentColor">
                                        <path fill-rule="evenodd"
                                            d="M10 3a1 1 0 00-1 1v5H4a1 1 0 100 2h5v5a1 1 0 102 0v-5h5a1 1 0 100-2h-5V4a1 1 0 00-1-1z"
                                            clip-rule="evenodd" />
                                    </svg>
                                    Comenzar a comprar
                                </a>
                            </div>
                        </div>
                    @else
                        <div class="space-y-8">
                            @foreach ($orders as $order)
                                <div class="bg-gray-50 rounded-lg overflow-hidden shadow">
                                    <div class="px-6 py-4">
                                        <div class="flex items-center justify-between">
                                            <div>
                                                <h3 class="text-lg font-medium text-gray-900">Pedido
                                                    #{{ $order->id }}</h3>
                                                <p class="text-sm text-gray-500">Realizado el
                                                    {{ $order->created_at->format('d/m/Y H:i') }}</p>
                                            </div>
                                            <span
                                                class="px-3 py-1 text-xs font-semibold rounded-full
                                                {{ $order->status === 'pending' ? 'bg-yellow-100 text-yellow-800' : '' }}
                                                {{ $order->status === 'processing' ? 'bg-blue-100 text-blue-800' : '' }}
                                                {{ $order->status === 'completed' ? 'bg-green-100 text-green-800' : '' }}
                                                {{ $order->status === 'cancelled' ? 'bg-red-100 text-red-800' : '' }}">
                                                {{ ucfirst($order->status) }}
                                            </span>
                                        </div>

                                        <div class="mt-4 border-t border-gray-200 pt-4">
                                            <div class="flow-root">
                                                <ul role="list" class="-my-6 divide-y divide-gray-200">
                                                    @foreach ($order->items as $item)
                                                        <li class="py-6 flex">
                                                            <div
                                                                class="flex-shrink-0 w-24 h-24 border border-gray-200 rounded-md overflow-hidden">
                                                                @if ($item->product->images->isNotEmpty())
                                                                    <img src="{{ asset('storage/' . $item->product->images->first()->path) }}"
                                                                        alt="{{ $item->product->name }}"
                                                                        class="w-full h-full object-center object-cover">
                                                                @else
                                                                    <div
                                                                        class="w-full h-full bg-gray-200 flex items-center justify-center">
                                                                        <span class="text-gray-500 text-xs">Sin
                                                                            imagen</span>
                                                                    </div>
                                                                @endif
                                                            </div>

                                                            <div class="ml-4 flex-1 flex flex-col">
                                                                <div>
                                                                    <div
                                                                        class="flex justify-between text-base font-medium text-gray-900">
                                                                        <h4>{{ $item->product->name }}</h4>
                                                                        <p class="ml-4">
                                                                            ${{ number_format($item->subtotal, 2) }}
                                                                        </p>
                                                                    </div>
                                                                    <p class="mt-1 text-sm text-gray-500">Cantidad:
                                                                        {{ $item->quantity }}</p>
                                                                </div>
                                                            </div>
                                                        </li>
                                                    @endforeach
                                                </ul>
                                            </div>
                                        </div>

                                        <div class="mt-4 border-t border-gray-200 pt-4">
                                            <div class="flex justify-between text-base font-medium text-gray-900">
                                                <p>Total</p>
                                                <p>${{ number_format($order->total, 2) }}</p>
                                            </div>
                                            <div class="mt-4">
                                                <a href="{{ route('orders.show', $order) }}"
                                                    class="text-blue-600 hover:text-blue-500 font-medium text-sm">
                                                    Ver detalles del pedido
                                                    <span aria-hidden="true"> &rarr;</span>
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach

                            <div class="mt-8">
                                {{ $orders->links() }}
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
