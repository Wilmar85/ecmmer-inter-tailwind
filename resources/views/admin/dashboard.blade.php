<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Panel de Administración') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-6xl mx-auto sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
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

            <div class="mt-8 grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                {{-- Bloque de Ingresos Totales --}}
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
                                    <div class="text-2xl font-semibold text-gray-900" id="totalRevenueDisplay">${{ number_format($totalRevenue ?? 0, 2) }}
                                        <span class="ml-2 text-xs px-2 py-1 rounded bg-green-100 text-green-700 align-middle" title="Tendencia respecto al mes anterior">↑ 8%</span>
                                    </div>
                                </dd>
                            </dl>
                        </div>
                    </div>
                </div>

                {{-- Bloque de Valor Promedio Pedido (AOV) --}}
                <div class="bg-white overflow-hidden shadow-md hover:shadow-xl sm:rounded-lg transition-shadow border border-gray-100">
                    <div class="p-6 group flex items-center gap-4">
                        <div class="flex-shrink-0 bg-blue-100 rounded-full p-3 group-hover:bg-blue-200 transition-colors">
                            <svg class="h-7 w-7 text-blue-600 group-hover:text-blue-800" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 1.343-3 3v3m0 0h3m-3 0h3m-3 0v3m0 0h3m-3 0h3c1.657 0 3-1.343 3-3V8c0-1.657-1.343-3-3-3H9c-1.657 0-3 1.343-3 3v3m0 0H9m-3 0h3c1.657 0 3-1.343 3-3v-3m0 0H9" />
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
                                    <div class="text-2xl font-semibold text-gray-900" id="averageOrderValueDisplay">${{ number_format($averageOrderValue ?? 0, 2) }}
                                        <span class="ml-2 text-xs px-2 py-1 rounded bg-yellow-100 text-yellow-700 align-middle" title="Tendencia respecto al mes anterior">↓ 2%</span>
                                    </div>
                                </dd>
                            </dl>
                        </div>
                    </div>
                </div>

                {{-- Bloque de Tasa de Conversión --}}
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
                                    <div class="text-2xl font-semibold text-gray-900" id="conversionRateDisplay">{{ $conversionRate !== null ? $conversionRate . '%' : 'N/D' }}
                                        <span class="ml-2 text-xs px-2 py-1 rounded bg-green-100 text-green-700 align-middle" title="Tendencia respecto al mes anterior">↑ 1.4%</span>
                                    </div>
                                </dd>
                            </dl>
                        </div>
                    </div>
                </div>

                {{-- Bloque de Tasa de Abandono Carrito --}}
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
                                    <div class="text-2xl font-semibold text-gray-900" id="cartAbandonmentRateDisplay">{{ $cartAbandonmentRate !== null ? $cartAbandonmentRate . '%' : 'N/D' }}
                                        <span class="ml-2 text-xs px-2 py-1 rounded bg-red-100 text-red-700 align-middle" title="Tendencia respecto al mes anterior">↓ 0.7%</span>
                                    </div>
                                </dd>
                            </dl>
                        </div>
                    </div>
                </div>
            </div>

            <div class="mt-8 bg-white overflow-hidden shadow-md sm:rounded-lg border border-gray-100">
    <div class="p-6">
        <h3 class="text-lg font-medium text-gray-900 mb-4 flex items-center gap-2">Ventas por Producto
            <span class="bg-blue-100 text-blue-700 text-xs px-2 py-1 rounded" title="Top 10 productos más vendidos">TOP</span>
        </h3>
        <ul id="salesByProductList">
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

            <div class="mt-8 bg-white overflow-hidden shadow-md sm:rounded-lg border border-gray-100">
    <div class="p-6">
        <h3 class="text-lg font-medium text-gray-900 mb-4 flex items-center gap-2">Ventas por Región
            <span class="bg-purple-100 text-purple-700 text-xs px-2 py-1 rounded" title="Distribución de ventas por ubicación">MAPA</span>
        </h3>
        <ul id="salesByRegionList">
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

        {{-- CAMBIO AQUÍ: Se eliminó el botón "Modo Oscuro" y su lógica JS --}}
        <div class="flex flex-wrap gap-4 items-center mt-10 mb-6 max-w-6xl mx-auto sm:px-6 lg:px-8">
            {{-- <button id="toggleDarkMode" type="button" class="mr-4 px-3 py-1 bg-gray-800 text-white rounded shadow hover:bg-gray-900 transition">🌙 Modo Oscuro</button> --}}
            <form id="dashboard-filters-form" class="flex flex-col md:flex-row gap-2 items-center w-full md:w-auto" method="GET" action="">
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
            {{-- Botón para abrir el panel de personalización, si lo deseas en el dashboard --}}
            <button @click="$store.personalizationPanel.togglePanel()" type="button" title="Personalizar secciones del dashboard" class="md:ml-4 px-4 py-2 bg-gray-600 text-white rounded shadow hover:bg-gray-700 transition">⚙️ Personalizar</button>
        </div>

        <div x-data="{ open: true }" class="mt-12 max-w-6xl mx-auto sm:px-6 lg:px-8" data-metric-section="marketing">
            <h2 class="text-xl font-bold mb-6 flex items-center justify-between cursor-pointer" @click="open = !open">
                <span>Métricas de Marketing</span>
                <svg :class="{'rotate-180': open, 'rotate-0': !open}" class="w-5 h-5 transition-transform duration-200" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
            </h2>
            <div x-show="open" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 scale-90" x-transition:enter-end="opacity-100 scale-100" x-transition:leave="transition ease-in duration-200" x-transition:leave-start="opacity-100 scale-100" x-transition:leave-end="opacity-0 scale-90">
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="p-6">
                            <div class="font-semibold text-gray-700">Tráfico del sitio web (últimos 30 días)</div>
                            <div class="text-3xl" id="trafficSummaryDisplay">
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
                            <ul id="trafficSourcesList">
                                @if($trafficSources !== null)
                                    @foreach($trafficSources as $source => $count)
                                        <li class="flex justify-between border-b py-1">
                                            <span>{{ $source }}</span>
                                            <span class="font-semibold">{{ number_format($count) }}</span>
                                        </li>
                                    @endforeach
                                @else
                                    <span class="text-red-500">Conecta Google Analytics para ver esta métrica</span>
                                @endif
                            </ul>
                        </div>
                    </div>
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="p-6">
                            <div class="font-semibold text-gray-700">Tasa de Clics (CTR)</div>
                            <div class="text-3xl" id="ctrDisplay">
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
        </div>

        <div x-data="{ open: true }" class="mt-12 max-w-6xl mx-auto sm:px-6 lg:px-8" data-metric-section="performance">
            <h2 class="text-xl font-bold mb-6 flex items-center justify-between cursor-pointer" @click="open = !open">
                <span>Métricas de Rendimiento del Sitio Web</span>
                <svg :class="{'rotate-180': open, 'rotate-0': !open}" class="w-5 h-5 transition-transform duration-200" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
            </h2>
            <div x-show="open" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 scale-90" x-transition:enter-end="opacity-100 scale-100" x-transition:leave="transition ease-in duration-200" x-transition:leave-start="opacity-100 scale-100" x-transition:leave-end="opacity-0 scale-90">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="p-6">
                            <div class="font-semibold text-gray-700 mb-2">Velocidad de carga promedio</div>
                            <canvas id="chartPageLoad" height="80" data-chart-pageload="{{ $averagePageLoadTime ?? 0 }}"></canvas>
                            <canvas id="trendPageLoad" height="60" class="mt-4"></canvas>
                            <div class="text-2xl mt-2" id="averagePageLoadTimeDisplay">{{ $averagePageLoadTime ? number_format($averagePageLoadTime, 2) . ' s' : 'N/D' }}</div>
                            <table class="w-full text-sm mt-2">
                                <tr><td class="font-semibold">Valor actual</td><td id="averagePageLoadTimeTableDisplay">{{ $averagePageLoadTime ? number_format($averagePageLoadTime, 2).' s' : 'N/D' }}</td></tr>
                            </table>
                        </div>
                    </div>
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="p-6">
                            <div class="font-semibold text-gray-700 mb-2">Tasa de rebote</div>
                            <canvas id="chartBounceRate" height="80" data-chart-bouncerate="{{ $bounceRate ?? 0 }}"></canvas>
                            <canvas id="trendBounceRate" height="60" class="mt-4"></canvas>
                            <div class="text-2xl mt-2" id="bounceRateDisplay">{{ $bounceRate ? number_format($bounceRate, 2) . ' %' : 'N/D' }}</div>
                            <table class="w-full text-sm mt-2">
                                <tr><td class="font-semibold">Valor actual</td><td id="bounceRateTableDisplay">{{ $bounceRate ? number_format($bounceRate, 2).' %' : 'N/D' }}</td></tr>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="p-6">
                            <div class="font-semibold text-gray-700 mb-2">Tiempo promedio en el sitio</div>
                            <div class="text-2xl" id="averageSessionDurationDisplay">
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
                            <ul id="devicesList">
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
        </div>

        <div x-data="{ open: true }" class="mt-12 max-w-6xl mx-auto sm:px-6 lg:px-8" data-metric-section="inventory">
            <h2 class="text-xl font-bold mb-6 flex items-center justify-between cursor-pointer" @click="open = !open">
                <span>Métricas de Inventario</span>
                <svg :class="{'rotate-180': open, 'rotate-0': !open}" class="w-5 h-5 transition-transform duration-200" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
            </h2>
            <div x-show="open" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 scale-90" x-transition:enter-end="opacity-100 scale-100" x-transition:leave="transition ease-in duration-200" x-transition:leave-start="opacity-100 scale-100" x-transition:leave-end="opacity-0 scale-90">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="p-6">
                            <div class="font-semibold text-gray-700 mb-2">Niveles de Stock</div>
                            <ul id="stockLevelsList">
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
                            <ul id="unitsSoldList">
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
                            <ul id="topSellingProductsList">
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
                            <ul id="lowStockProductsList">
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
        </div>

        <div x-data="{ open: true }" class="mt-12 max-w-6xl mx-auto sm:px-6 lg:px-8" data-metric-section="clients">
            <h2 class="text-xl font-bold mb-6 flex items-center justify-between cursor-pointer" @click="open = !open">
                <span>Métricas de Clientes</span>
                <svg :class="{'rotate-180': open, 'rotate-0': !open}" class="w-5 h-5 transition-transform duration-200" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
            </h2>
            <div x-show="open" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 scale-90" x-transition:enter-end="opacity-100 scale-100" x-transition:leave="transition ease-in duration-200" x-transition:leave-start="opacity-100 scale-100" x-transition:leave-end="opacity-0 scale-90">
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="p-6">
                            <div class="font-semibold text-gray-700">Total de Clientes</div>
                            <div class="text-3xl" id="totalCustomersDisplay">{{ $totalCustomers }}</div>
                        </div>
                    </div>
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="p-6">
                            <div class="font-semibold text-gray-700">Nuevos Clientes (últimos 30 días)</div>
                            <div class="text-3xl" id="newCustomersDisplay">{{ $newCustomers }}</div>
                        </div>
                    </div>
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="p-6">
                            <div class="font-semibold text-gray-700">Clientes Recurrentes</div>
                            <div class="text-3xl" id="recurrentCustomersDisplay">{{ $recurrentCustomers }}</div>
                        </div>
                    </div>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="p-6">
                            <div class="font-semibold text-gray-700 mb-2">Demografía por Ciudad (Top 5)</div>
                            <ul id="demographicsByCityList">
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
                            <ul id="demographicsByStateList">
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
                            <div class="text-3xl" id="customerLifetimeValueDisplay">${{ number_format($customerLifetimeValue, 2) }}</div>
                        </div>
                    </div>
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="p-6">
                            <div class="font-semibold text-gray-700">Tasa de Retención</div>
                            <div class="text-3xl" id="retentionRateDisplay">{{ $retentionRate !== null ? $retentionRate.'%' : 'N/D' }}</div>
                        </div>
                    </div>
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="p-6">
                            <div class="font-semibold text-gray-700">Tasa de Adquisición</div>
                            <div class="text-3xl" id="acquisitionRateDisplay">{{ $acquisitionRate !== null ? $acquisitionRate.'%' : 'N/D' }}</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
        {{-- Asegúrate de que Chart.js esté cargado antes de dashboard-charts.js --}}
        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
        {{-- Tu script de dashboard con la lógica de los gráficos y AJAX --}}
        <script src="{{ asset('js/dashboard-charts.js') }}"></script>
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                // Función para aplicar/actualizar el tema de los gráficos cuando el modo oscuro cambia
                window.updateChartColors = function() {
                    const chartTextColor = getComputedStyle(document.documentElement).getPropertyValue('--chart-text') || '#1e293b';
                    Chart.defaults.color = chartTextColor;
                    Chart.defaults.plugins.legend.labels.color = chartTextColor;
                    Chart.defaults.plugins.tooltip.titleColor = chartTextColor;
                    Chart.defaults.plugins.tooltip.bodyColor = chartTextColor;

                    if (window.dashboardCharts) {
                        for (const chartKey in window.dashboardCharts) {
                            if (window.dashboardCharts[chartKey] && typeof window.dashboardCharts[chartKey].update === 'function') {
                                window.dashboardCharts[chartKey].update();
                            }
                        }
                    }
                };

                // El botón de Modo Oscuro fue eliminado, por lo que su lógica de JS también se remueve.
                /*
                const toggleDarkModeButton = document.getElementById('toggleDarkMode');
                if (toggleDarkModeButton) {
                    toggleDarkModeButton.onclick = function() {
                        document.documentElement.classList.toggle('dark');
                        if(document.documentElement.classList.contains('dark')) {
                            document.documentElement.style.setProperty('--chart-text', '#f3f4f6');
                            document.documentElement.style.setProperty('--chart-bg', '#1e293b');
                        } else {
                            document.documentElement.style.setProperty('--chart-text', '#1e293b');
                            document.documentElement.style.setProperty('--chart-bg', '#ffffff');
                        }
                        window.updateChartColors();
                    };
                }
                */

                // Manejo de la lógica de filtros del dashboard
                const filterForm = document.getElementById('dashboard-filters-form');
                if (filterForm) {
                    filterForm.addEventListener('submit', function(e) {
                        e.preventDefault();
                        const filters = {
                            dateRange: document.getElementById('dateRange').value,
                            deviceFilter: document.getElementById('deviceFilter').value
                        };
                        if (typeof window.updateDashboardData === 'function') {
                            window.updateDashboardData(filters);
                        } else {
                            console.error("updateDashboardData function not found or not global.");
                        }
                    });

                    document.getElementById('dateRange').addEventListener('change', function() {
                        filterForm.dispatchEvent(new Event('submit'));
                    });
                    document.getElementById('deviceFilter').addEventListener('change', function() {
                        filterForm.dispatchEvent(new Event('submit'));
                    });
                }

                // Aplicar las preferencias de visibilidad de las secciones al cargar la página
                if (typeof window.applyDashboardPreferences === 'function') {
                    window.applyDashboardPreferences();
                } else {
                    console.error("applyDashboardPreferences function not found or not global.");
                }

                // Disparar una actualización inicial de los datos del dashboard cuando el DOM esté listo
                if (typeof window.updateDashboardData === 'function') {
                    const initialFilters = {
                        dateRange: document.getElementById('dateRange') ? document.getElementById('dateRange').value : '30',
                        deviceFilter: document.getElementById('deviceFilter') ? document.getElementById('deviceFilter').value : 'all'
                    };
                    window.updateDashboardData(initialFilters);
                }
            });
        </script>
    @endpush
</x-app-layout>