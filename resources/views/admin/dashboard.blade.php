<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Panel de Administración') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <!-- Gestión de Productos -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <h3 class="text-lg font-medium text-gray-900 mb-4">Productos</h3>
                        <p class="text-gray-600 mb-4">Gestiona el catálogo de productos de la tienda.</p>
                        <a href="{{ route('admin.products.index') }}"
                            class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700 focus:bg-blue-700 active:bg-blue-900 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition ease-in-out duration-150">
                            Administrar Productos
                        </a>
                    </div>
                </div>

                <!-- Gestión de Categorías -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <h3 class="text-lg font-medium text-gray-900 mb-4">Categorías</h3>
                        <p class="text-gray-600 mb-4">Organiza tus productos en categorías.</p>
                        <a href="{{ route('admin.categories.index') }}"
                            class="inline-flex items-center px-4 py-2 bg-green-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-green-700 focus:bg-green-700 active:bg-green-900 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2 transition ease-in-out duration-150">
                            Administrar Categorías
                        </a>
                    </div>
                </div>

                <!-- Gestión de Subcategorías -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <h3 class="text-lg font-medium text-gray-900 mb-4">Subcategorías</h3>
                        <p class="text-gray-600 mb-4">Gestiona las subcategorías asociadas a cada categoría.</p>
                        <a href="{{ route('admin.subcategories.index') }}"
                            class="inline-flex items-center px-4 py-2 bg-yellow-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-yellow-700 focus:bg-yellow-700 active:bg-yellow-900 focus:outline-none focus:ring-2 focus:ring-yellow-500 focus:ring-offset-2 transition ease-in-out duration-150">
                            Administrar Subcategorías
                        </a>
                    </div>
                </div>

                <!-- Gestión de Pedidos -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <h3 class="text-lg font-medium text-gray-900 mb-4">Pedidos</h3>
                        <p class="text-gray-600 mb-4">Gestiona los pedidos de tus clientes.</p>
                        <a href="{{ route('admin.orders.index') }}"
                            class="inline-flex items-center px-4 py-2 bg-purple-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-purple-700 focus:bg-purple-700 active:bg-purple-900 focus:outline-none focus:ring-2 focus:ring-purple-500 focus:ring-offset-2 transition ease-in-out duration-150">
                            Administrar Pedidos
                        </a>
                    </div>
                </div>
            </div>

            <!-- Estadísticas Rápidas -->
            <div class="mt-8 grid grid-cols-1 md:grid-cols-3 gap-6">
                <div class="bg-white overflow-hidden shadow-md hover:shadow-xl sm:rounded-lg transition-shadow border border-gray-100">
                    <div class="p-6 group flex items-center gap-4">
                        <div class="flex-shrink-0 bg-blue-100 rounded-full p-3 group-hover:bg-blue-200 transition-colors">
                            <svg class="h-7 w-7 text-blue-600 group-hover:text-blue-800" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4" />
                            </svg>
                        </div>
                        <div class="flex-1">
                            <dl>
                                <dt class="text-sm font-medium text-gray-500 truncate flex items-center gap-1">
                                    Ingresos Totales
                                    <span class="ml-1 cursor-pointer" title="Suma total de ventas en el periodo seleccionado">
                                        <svg class="w-4 h-4 text-gray-400 inline" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><path stroke-linecap="round" stroke-linejoin="round" d="M12 16v-4m0-4h.01"/></svg>
                                    </span>
                                </dt>
                                <dd class="flex items-baseline mt-1">
                                    <div class="text-2xl font-semibold text-gray-900">${{ number_format($totalRevenue ?? 0, 2) }}
                                        <span class="ml-2 text-xs px-2 py-1 rounded bg-green-100 text-green-700 align-middle" title="Tendencia respecto al mes anterior">↑ 8%</span>
                                    </div>
                                </dd>
                            </dl>
                        </div>
            </svg>
        </div>
        <div class="flex-1">
            <dl>
                <dt class="text-sm font-medium text-gray-500 truncate flex items-center gap-1">
                    Valor Promedio Pedido (AOV)
                    <span class="ml-1 cursor-pointer" title="Promedio gastado por pedido en el periodo seleccionado">
                        <svg class="w-4 h-4 text-gray-400 inline" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><path stroke-linecap="round" stroke-linejoin="round" d="M12 16v-4m0-4h.01"/></svg>
                    </span>
                </dt>
                <dd class="flex items-baseline mt-1">
                    <div class="text-2xl font-semibold text-gray-900">${{ number_format($averageOrderValue ?? 0, 2) }}
                        <span class="ml-2 text-xs px-2 py-1 rounded bg-yellow-100 text-yellow-700 align-middle" title="Tendencia respecto al mes anterior">↓ 2%</span>
                    </div>
                </dd>
            </dl>
        </div>
    </div>
</div>
                <div class="bg-white overflow-hidden shadow-md hover:shadow-xl sm:rounded-lg transition-shadow border border-gray-100">
    <div class="p-6 group flex items-center gap-4">
        <div class="flex-shrink-0 bg-green-100 rounded-full p-3 group-hover:bg-green-200 transition-colors">
            <svg class="h-7 w-7 text-green-600 group-hover:text-green-800" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138z" />
            </svg>
        </div>
        <div class="flex-1">
            <dl>
                <dt class="text-sm font-medium text-gray-500 truncate flex items-center gap-1">
                    Tasa de Conversión
                    <span class="ml-1 cursor-pointer" title="Porcentaje de visitantes que realizaron una compra">
                        <svg class="w-4 h-4 text-gray-400 inline" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><path stroke-linecap="round" stroke-linejoin="round" d="M12 16v-4m0-4h.01"/></svg>
                    </span>
                </dt>
                <dd class="flex items-baseline mt-1">
                    <div class="text-2xl font-semibold text-gray-900">{{ $conversionRate !== null ? $conversionRate . '%' : 'N/D' }}
                        <span class="ml-2 text-xs px-2 py-1 rounded bg-green-100 text-green-700 align-middle" title="Tendencia respecto al mes anterior">↑ 1.4%</span>
                    </div>
                </dd>
            </dl>
        </div>
    </div>
</div>
                <div class="bg-white overflow-hidden shadow-md hover:shadow-xl sm:rounded-lg transition-shadow border border-gray-100">
    <div class="p-6 group flex items-center gap-4">
        <div class="flex-shrink-0 bg-red-100 rounded-full p-3 group-hover:bg-red-200 transition-colors">
            <svg class="h-7 w-7 text-red-600 group-hover:text-red-800" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6 6 0 10-12 0v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
            </svg>
        </div>
        <div class="flex-1">
            <dl>
                <dt class="text-sm font-medium text-gray-500 truncate flex items-center gap-1">
                    Tasa de Abandono Carrito
                    <span class="ml-1 cursor-pointer" title="Porcentaje de usuarios que abandonan el carrito sin comprar">
                        <svg class="w-4 h-4 text-gray-400 inline" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><path stroke-linecap="round" stroke-linejoin="round" d="M12 16v-4m0-4h.01"/></svg>
                    </span>
                </dt>
                <dd class="flex items-baseline mt-1">
                    <div class="text-2xl font-semibold text-gray-900">{{ $cartAbandonmentRate !== null ? $cartAbandonmentRate . '%' : 'N/D' }}
                        <span class="ml-2 text-xs px-2 py-1 rounded bg-red-100 text-red-700 align-middle" title="Tendencia respecto al mes anterior">↓ 0.7%</span>
                    </div>
                </dd>
            </dl>
        </div>
    </div>
</div>
            </div>

            <!-- Ventas por producto (top 10) -->
            <div class="mt-8 bg-white overflow-hidden shadow-md sm:rounded-lg border border-gray-100">
    <div class="p-6">
        <h3 class="text-lg font-medium text-gray-900 mb-4 flex items-center gap-2">Ventas por Producto
            <span class="bg-blue-100 text-blue-700 text-xs px-2 py-1 rounded" title="Top 10 productos más vendidos">TOP</span>
        </h3>
        <ul>
            @forelse($salesByProduct as $item)
                <li class="flex justify-between border-b py-1">
                    <span>{{ $item->product ? $item->product->name : 'Producto #' . $item->product_id }}</span>
                    <span class="font-semibold bg-blue-50 text-blue-700 px-2 rounded">{{ $item->total }}</span>
                </li>
            @empty
                <li>No hay datos.</li>
            @endforelse
        </ul>
        <div class="mt-8">
            <canvas id="chartSalesByProduct" height="110"></canvas>
        </div>
    </div>
</div>

            <!-- Ventas por Región -->
            <div class="mt-8 bg-white overflow-hidden shadow-md sm:rounded-lg border border-gray-100">
    <div class="p-6">
        <h3 class="text-lg font-medium text-gray-900 mb-4 flex items-center gap-2">Ventas por Región
            <span class="bg-purple-100 text-purple-700 text-xs px-2 py-1 rounded" title="Distribución de ventas por ubicación">MAPA</span>
        </h3>
        <ul>
            @forelse($salesByRegion as $region)
                <li class="flex justify-between border-b py-1">
                    <span>{{ $region->region ?? 'Sin región' }}</span>
                    <span class="font-semibold bg-purple-50 text-purple-700 px-2 rounded">{{ $region->total }}</span>
                </li>
            @empty
                <li>No hay datos.</li>
            @endforelse
        </ul>
        <div class="mt-8">
            <canvas id="chartSalesStacked" height="90"></canvas>
        </div>
    </div>
</div>
        </div>

        <!-- MÉTRICAS DE MARKETING (GOOGLE ANALYTICS) -->
        <div class="mt-12">
            <h2 class="text-xl font-bold mb-6">Métricas de Marketing</h2>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <div class="font-semibold text-gray-700">Tráfico del sitio web (últimos 30 días)</div>
                        <div class="text-3xl">
                            @if($trafficSummary !== null)
                                {{ number_format($trafficSummary) }} sesiones
                            @else
                                <span class="text-red-500">Conecta Google Analytics para ver esta métrica</span>
                            @endif
                        </div>
                    </div>
                </div>
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <div class="font-semibold text-gray-700 mb-2">Fuentes de tráfico (últimos 30 días)</div>
                        @if($trafficSources !== null)
                            <ul>
                                @foreach($trafficSources as $source => $count)
                                    <li class="flex justify-between border-b py-1">
                                        <span>{{ $source }}</span>
                                        <span class="font-semibold">{{ number_format($count) }}</span>
                                    </li>
                                @endforeach
                            </ul>
                        @else
                            <span class="text-red-500">Conecta Google Analytics para ver esta métrica</span>
                        @endif
                    </div>
                </div>
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <div class="font-semibold text-gray-700">Tasa de Clics (CTR)</div>
                        <div class="text-3xl">
                            @if($ctr !== null)
                                {{ $ctr }}%
                            @else
                                <span class="text-red-500">No disponible o sin datos</span>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- FILTROS Y PERSONALIZACIÓN -->
        <div class="flex flex-wrap gap-4 items-center mt-10 mb-6 bg-gradient-to-r from-blue-50 via-white to-purple-50 px-4 py-3 rounded shadow-sm border border-gray-100">
    <button id="toggleDarkMode" type="button" class="mr-4 px-3 py-1 bg-gray-800 text-white rounded hover:bg-gray-900 transition">🌙 Modo Oscuro</button>
    <form class="flex flex-col md:flex-row gap-2 items-center w-full md:w-auto" method="GET" action="">
        <label for="dateRange" class="font-semibold">Rango de fechas:</label>
        <select id="dateRange" name="dateRange" class="rounded border-gray-300 focus:ring-blue-500 focus:border-blue-500">
            <option value="7">Últimos 7 días</option>
            <option value="30" selected>Últimos 30 días</option>
            <option value="90">Últimos 90 días</option>
        </select>
        <label for="deviceFilter" class="font-semibold ml-0 md:ml-4">Dispositivo:</label>
        <select id="deviceFilter" name="deviceFilter" class="rounded border-gray-300 focus:ring-purple-500 focus:border-purple-500">
            <option value="all">Todos</option>
            @if($devices)
                @foreach(array_keys($devices) as $device)
                    <option value="{{ $device }}">{{ ucfirst($device) }}</option>
                @endforeach
            @endif
        </select>
        <button type="submit" class="md:ml-4 px-4 py-2 bg-blue-600 text-white rounded shadow hover:bg-blue-700 transition">Aplicar</button>
    </form>
</div>

        <!-- MÉTRICAS DE RENDIMIENTO DEL SITIO WEB -->
        <div class="mt-12" data-metric-section="performance">
            <h2 class="text-xl font-bold mb-6">Métricas de Rendimiento del Sitio Web</h2>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <div class="font-semibold text-gray-700 mb-2">Velocidad de carga promedio</div>
                        <canvas id="chartPageLoad" height="80" data-chart-pageload="{{ $averagePageLoadTime ?? 0 }}"></canvas>
<canvas id="trendPageLoad" height="60" class="mt-4"></canvas>
                        <div class="text-2xl mt-2">{{ $averagePageLoadTime ? number_format($averagePageLoadTime, 2) . ' s' : 'N/D' }}</div>
                        <table class="w-full text-sm mt-2">
                            <tr><td class="font-semibold">Valor actual</td><td>{{ $averagePageLoadTime ? number_format($averagePageLoadTime, 2).' s' : 'N/D' }}</td></tr>
                        </table>
                    </div>
                </div>
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <div class="font-semibold text-gray-700 mb-2">Tasa de rebote</div>
                        <canvas id="chartBounceRate" height="80" data-chart-bouncerate="{{ $bounceRate ?? 0 }}"></canvas>
<canvas id="trendBounceRate" height="60" class="mt-4"></canvas>
                        <div class="text-2xl mt-2">{{ $bounceRate ? number_format($bounceRate, 2) . ' %' : 'N/D' }}</div>
                        <table class="w-full text-sm mt-2">
                            <tr><td class="font-semibold">Valor actual</td><td>{{ $bounceRate ? number_format($bounceRate, 2).' %' : 'N/D' }}</td></tr>
                        </table>
                    </div>
                </div>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <div class="font-semibold text-gray-700 mb-2">Tiempo promedio en el sitio</div>
                        <div class="text-2xl">
                            @if($averageSessionDuration)
                                @php
                                    $minutes = floor($averageSessionDuration / 60);
                                    $seconds = $averageSessionDuration % 60;
                                @endphp
                                {{ $minutes }}m {{ $seconds }}s
                            @else
                                N/D
                            @endif
                        </div>
                    </div>
                </div>
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <div class="font-semibold text-gray-700 mb-2">Dispositivos</div>
                        <script>
window.devicesData = @json($devices);
</script>
<canvas id="pieDevices" height="120" class="mb-4"></canvas>
<!-- Aquí puedes guardar preferencias de usuario y actualizar los gráficos con AJAX -->
                        <ul>
                            @if($devices)
                                @foreach($devices as $device => $count)
                                    <li class="flex justify-between border-b py-1">
                                        <span>{{ ucfirst($device) }}</span>
                                        <span class="font-semibold">{{ $count }}</span>
                                    </li>
                                @endforeach
                            @else
                                <li>No hay datos.</li>
                            @endif
                        </ul>
                    </div>
                </div>
            </div>
        </div>

        <!-- MÉTRICAS DE INVENTARIO -->
        <div class="mt-12" data-metric-section="inventory">
            <h2 class="text-xl font-bold mb-6">Métricas de Inventario</h2>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <div class="font-semibold text-gray-700 mb-2">Niveles de Stock</div>
                        <ul>
                            @forelse($stockLevels as $product)
                                <li class="flex justify-between border-b py-1">
                                    <span>{{ $product->name }}</span>
                                    <span class="font-semibold">{{ $product->stock }}</span>
                                </li>
                            @empty
                                <li>No hay productos.</li>
                            @endforelse
                        </ul>
                    </div>
                </div>
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <div class="font-semibold text-gray-700 mb-2">Unidades Vendidas</div>
                        <ul>
                            @forelse($unitsSold as $item)
                                <li class="flex justify-between border-b py-1">
                                    <span>{{ $item->product->name ?? 'Producto #' . $item->product_id }}</span>
                                    <span class="font-semibold">{{ $item->total_sold }}</span>
                                </li>
                            @empty
                                <li>No hay ventas.</li>
                            @endforelse
                        </ul>
                    </div>
                </div>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <div class="font-semibold text-gray-700 mb-2">Productos Más Vendidos (Top 10)</div>
                        <ul>
                            @forelse($topSellingProducts as $item)
                                <li class="flex justify-between border-b py-1">
                                    <span>{{ $item->product->name ?? 'Producto #' . $item->product_id }}</span>
                                    <span class="font-semibold">{{ $item->total_sold }}</span>
                                </li>
                            @empty
                                <li>No hay datos.</li>
                            @endforelse
                        </ul>
                    </div>
                </div>
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <div class="font-semibold text-gray-700 mb-2">Productos de Bajo Stock (≤ 5 unidades)</div>
                        <ul>
                            @forelse($lowStockProducts as $product)
                                <li class="flex justify-between border-b py-1">
                                    <span>{{ $product->name }}</span>
                                    <span class="font-semibold text-red-600">{{ $product->stock }}</span>
                                </li>
                            @empty
                                <li>No hay productos en bajo stock.</li>
                            @endforelse
                        </ul>
                    </div>
                </div>
            </div>
        </div>

        <!-- MÉTRICAS DE CLIENTES -->
        <div class="mt-12" data-metric-section="clients">
            <h2 class="text-xl font-bold mb-6">Métricas de Clientes</h2>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <div class="font-semibold text-gray-700">Total de Clientes</div>
                        <div class="text-3xl">{{ $totalCustomers }}</div>
                    </div>
                </div>
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <div class="font-semibold text-gray-700">Nuevos Clientes (últimos 30 días)</div>
                        <div class="text-3xl">{{ $newCustomers }}</div>
                    </div>
                </div>
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <div class="font-semibold text-gray-700">Clientes Recurrentes</div>
                        <div class="text-3xl">{{ $recurrentCustomers }}</div>
                    </div>
                </div>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <div class="font-semibold text-gray-700 mb-2">Demografía por Ciudad (Top 5)</div>
                        <ul>
                            @forelse($demographicsByCity as $city)
                                <li class="flex justify-between border-b py-1">
                                    <span>{{ $city->city ?? 'Sin ciudad' }}</span>
                                    <span class="font-semibold">{{ $city->total }}</span>
                                </li>
                            @empty
                                <li>No hay datos.</li>
                            @endforelse
                        </ul>
                    </div>
                </div>
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <div class="font-semibold text-gray-700 mb-2">Demografía por Estado (Top 5)</div>
                        <ul>
                            @forelse($demographicsByState as $state)
                                <li class="flex justify-between border-b py-1">
                                    <span>{{ $state->state ?? 'Sin estado' }}</span>
                                    <span class="font-semibold">{{ $state->total }}</span>
                                </li>
                            @empty
                                <li>No hay datos.</li>
                            @endforelse
                        </ul>
                    </div>
                </div>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <div class="font-semibold text-gray-700">Valor de Vida del Cliente (CLTV)</div>
                        <div class="text-3xl">${{ number_format($customerLifetimeValue, 2) }}</div>
                    </div>
                </div>
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <div class="font-semibold text-gray-700">Tasa de Retención</div>
                        <div class="text-3xl">{{ $retentionRate !== null ? $retentionRate.'%' : 'N/D' }}</div>
                    </div>
                </div>
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <div class="font-semibold text-gray-700">Tasa de Adquisición</div>
                        <div class="text-3xl">{{ $acquisitionRate !== null ? $acquisitionRate.'%' : 'N/D' }}</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
<script>
    document.getElementById('toggleDarkMode').onclick = function() {
        document.documentElement.classList.toggle('dark');
        // For Chart.js, update colors
        if(document.documentElement.classList.contains('dark')) {
            document.documentElement.style.setProperty('--chart-text', '#f3f4f6');
        } else {
            document.documentElement.style.setProperty('--chart-text', '#1e293b');
        }
    };
</script>
</x-app-layout>
