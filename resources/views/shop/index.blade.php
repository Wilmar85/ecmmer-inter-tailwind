<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Tienda') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="flex flex-col md:flex-row gap-8">
                <!-- Sidebar de Filtros -->
                <aside class="md:w-1/4 w-full bg-white rounded-lg shadow-md p-6 mb-8 md:mb-0 md:sticky md:top-8">
                    <h2 class="text-xl font-bold text-gray-700 mb-4">Filtrar productos</h2>
                    <form action="{{ route('shop.index') }}" method="GET" class="space-y-6">
                        <!-- Búsqueda por nombre -->
                        <div>
                            <label for="search" class="block text-sm font-medium text-gray-700 mb-1">Buscar por nombre</label>
                            <input type="text" name="search" id="search" value="{{ request('search') }}"
                                class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50"
                                placeholder="Nombre del producto...">
                        </div>
                        <!-- Filtro por categoría -->
                        <div>
                            <label for="category" class="block text-sm font-medium text-gray-700 mb-1">Categoría</label>
                            <select name="category" id="category"
                                class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50">
                                <option value="">Todas las categorías</option>
                                @foreach ($categories as $category)
                                    <option value="{{ $category->id }}" {{ request('category') == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <!-- Filtro por marca -->
                        <div>
                            <label for="brand" class="block text-sm font-medium text-gray-700 mb-1">Marca</label>
                            <select name="brand" id="brand" class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50">
                                <option value="">Todas las marcas</option>
                                @if(isset($brands))
                                    @foreach ($brands as $brand)
                                        <option value="{{ $brand->id }}" {{ request('brand') == $brand->id ? 'selected' : '' }}>{{ $brand->name }}</option>
                                    @endforeach
                                @endif
                            </select>
                        </div>
                        <!-- Rango de precio predefinido -->
                        <div>
                            <label for="price_range" class="block text-sm font-medium text-gray-700 mb-1">Rango de precio rápido</label>
                            <select name="price_range" id="price_range" class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50">
                                <option value="">Todos</option>
                                <option value="0-100" {{ request('price_range') == '0-100' ? 'selected' : '' }}>$0 - $100</option>
                                <option value="100-250" {{ request('price_range') == '100-250' ? 'selected' : '' }}>$100 - $250</option>
                                <option value="250-500" {{ request('price_range') == '250-500' ? 'selected' : '' }}>$250 - $500</option>
                                <option value="500-1000" {{ request('price_range') == '500-1000' ? 'selected' : '' }}>$500 - $1000</option>
                                <option value="1000-999999" {{ request('price_range') == '1000-999999' ? 'selected' : '' }}>$1000+</option>
                            </select>
                        </div>
                        <!-- Rango de precio personalizado -->
                        <div class="flex gap-2 mt-2">
                            <div class="flex-1">
                                <label for="price_min" class="block text-sm font-medium text-gray-700 mb-1">Precio mínimo</label>
                                <input type="number" name="price_min" id="price_min" value="{{ request('price_min') }}"
                                    class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50"
                                    placeholder="0">
                            </div>
                            <div class="flex-1">
                                <label for="price_max" class="block text-sm font-medium text-gray-700 mb-1">Precio máximo</label>
                                <input type="number" name="price_max" id="price_max" value="{{ request('price_max') }}"
                                    class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50"
                                    placeholder="1000">
                            </div>
                        </div>
                        <!-- Botón de filtrar -->
                        <button type="submit"
                            class="w-full bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline transition">Filtrar</button>
                    </form>
                </aside>
                <!-- Main: productos -->
                <main class="md:w-3/4 flex-1 md:pl-6 border-t md:border-t-0 md:border-l border-gray-200">
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-3 gap-6">
                        @forelse ($products as $product)
    <x-product-card :product="$product" />
@empty
                            <div class="col-span-full text-center py-12">
                                <p class="text-gray-500 text-lg">No se encontraron productos que coincidan con los filtros seleccionados.</p>
                            </div>
                        @endforelse
                    </div>
                    <!-- Paginación -->
                    @if ($products->hasPages())
                        <div class="mt-6">
                            {{ $products->links() }}
                        </div>
                    @endif
                </main>
            </div>
        </div>
    </div>
@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    const priceRange = document.getElementById('price_range');
    const priceMin = document.getElementById('price_min');
    const priceMax = document.getElementById('price_max');
    if (priceRange && priceMin && priceMax) {
        priceRange.addEventListener('change', function () {
            if (this.value) {
                const [min, max] = this.value.split('-');
                priceMin.value = min;
                priceMax.value = max;
            } else {
                priceMin.value = '';
                priceMax.value = '';
            }
        });
    }
});
</script>
@endpush

</x-app-layout>
