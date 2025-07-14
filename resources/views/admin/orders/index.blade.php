<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Gestión de Pedidos') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    @if (session('success'))
                        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4"
                            role="alert">
                            <span class="block sm:inline">{{ session('success') }}</span>
                        </div>
                    @endif

                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    @php
    $sort = request('sort', 'id');
    $direction = request('direction', 'desc');
    function sort_link($label, $column, $sort, $direction) {
        $icon = '';
        if ($sort === $column) {
            $icon = $direction === 'asc' ? '↑' : '↓';
        }
        $newDirection = ($sort === $column && $direction === 'asc') ? 'desc' : 'asc';
        $query = array_merge(request()->except(['page', 'sort', 'direction']), ['sort' => $column, 'direction' => $newDirection]);
        $url = request()->url() . '?' . http_build_query($query);
        return '<a href="' . $url . '" class="hover:underline ' . ($sort === $column ? 'font-bold text-indigo-700' : '') . '">' . $label . ' ' . $icon . '</a>';
    }
@endphp
<th scope="col"
    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
    {!! sort_link('Número de Pedido', 'id', $sort, $direction) !!}
</th>
<th scope="col"
    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
    {!! sort_link('Cliente', 'name', $sort, $direction) !!}
</th>
<th scope="col"
    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
    {!! sort_link('Total', 'total', $sort, $direction) !!}
</th>
<th scope="col"
    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
    {!! sort_link('Estado', 'status', $sort, $direction) !!}
</th>
<th scope="col"
    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
    {!! sort_link('Fecha', 'created_at', $sort, $direction) !!}
</th>
<th scope="col"
    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
    Acciones
</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @foreach ($orders as $order)
                                    <tr>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="text-sm font-medium text-gray-900">
                                                #{{ $order->id }}
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="text-sm text-gray-900">
                                                {{ $order->name }}
                                            </div>
                                            <div class="text-sm text-gray-500">
                                                {{ $order->email }}
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="text-sm text-gray-900">
                                                ${{ number_format($order->total, 2) }}
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <span
                                                class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full
                                                {{ $order->status === 'pending' ? 'bg-yellow-100 text-yellow-800' : '' }}
                                                {{ $order->status === 'processing' ? 'bg-blue-100 text-blue-800' : '' }}
                                                {{ $order->status === 'completed' ? 'bg-green-100 text-green-800' : '' }}
                                                {{ $order->status === 'cancelled' ? 'bg-red-100 text-red-800' : '' }}">
                                                {{ ucfirst($order->status) }}
                                            </span>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                            {{ $order->created_at->format('d/m/Y H:i') }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                            <a href="{{ route('admin.orders.show', $order) }}"
                                                class="text-blue-600 hover:text-blue-900 mr-3">Ver detalles</a>
                                            <form action="{{ route('admin.orders.update-status', $order) }}"
                                                method="POST" class="inline">
                                                @csrf
                                                <select name="status" onchange="this.form.submit()"
                                                    class="text-sm rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                                                    <option value="pending"
                                                        {{ $order->status === 'pending' ? 'selected' : '' }}>Pendiente
                                                    </option>
                                                    <option value="processing"
                                                        {{ $order->status === 'processing' ? 'selected' : '' }}>En
                                                        proceso</option>
                                                    <option value="completed"
                                                        {{ $order->status === 'completed' ? 'selected' : '' }}>
                                                        Completado</option>
                                                    <option value="cancelled"
                                                        {{ $order->status === 'cancelled' ? 'selected' : '' }}>
                                                        Cancelado</option>
                                                </select>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>

                        <div class="mt-4">
                            {{ $orders->links() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
