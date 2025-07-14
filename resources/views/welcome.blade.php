<x-app-layout>
    <div class="py-12">
        <!-- Banner Informativo -->
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 mb-12">
            <div class="bg-gradient-to-r from-blue-600 to-indigo-700 rounded-lg shadow-xl overflow-hidden">
                <div class="px-6 py-12 md:px-12 text-center md:text-left">
                    <div class="md:flex md:items-center md:justify-between">
                        <div class="md:w-2/3">
                            <h1 class="text-3xl font-extrabold text-white sm:text-4xl">
                                Bienvenido a nuestra tienda en línea
                            </h1>
                            <p class="mt-4 text-lg text-blue-100">
                                Descubre nuestra selección de productos de alta calidad a los mejores precios.
                                ¡Envío gratis en compras mayores a $500!
                            </p>
                            <div class="mt-8">
                                <a href="{{ route('shop.index') }}"
                                    class="inline-flex items-center px-6 py-3 border border-transparent text-base font-medium rounded-md text-blue-700 bg-white hover:bg-blue-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                                    Ir a la Tienda
                                </a>
                            </div>
                        </div>
                        <div class="hidden md:block md:w-1/3">
                            <svg class="w-full h-48 text-white opacity-20" fill="currentColor" viewBox="0 0 24 24">
                                <path
                                    d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm0 18c-4.41 0-8-3.59-8-8s3.59-8 8-8 8 3.59 8 8-3.59 8-8 8zm-1-13h2v6h-2zm0 8h2v2h-2z" />
                            </svg>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <!-- Sección de Categorías -->
        <div class="mb-12">
            <h2 class="text-2xl font-bold text-gray-800 mb-6">Categorías</h2>
            <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
                @foreach ($categories as $category)
                    <a href="{{ route('categories.show', $category) }}" class="block group">
                        <div class="bg-white rounded-lg shadow-md p-6 transition-transform transform hover:scale-105">
                            <h3 class="text-lg font-semibold text-gray-800 group-hover:text-blue-600">
                                {{ $category->name }}</h3>
                            <p class="text-sm text-gray-600 mt-2">{{ $category->products_count }} productos</p>
                        </div>
                    </a>
                @endforeach
            </div>
        </div>

        <!-- Sección de Productos Destacados -->
        <div>
            <h2 class="text-2xl font-bold text-gray-800 mb-6">Productos Destacados</h2>
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                @foreach ($products as $product)
                    <div class="bg-white rounded-lg shadow-md overflow-hidden group">
                        @if ($product->images->isNotEmpty())
                            <div class="aspect-w-3 aspect-h-2">
                                <img src="{{ asset('storage/' . $product->images->first()->path) }}"
                                    alt="{{ $product->name }}"
                                    class="w-full h-48 object-cover object-center group-hover:opacity-75">
                            </div>
                        @endif
                        <div class="p-4">
                            <h3 class="text-lg font-semibold text-gray-800 mb-2">{{ $product->name }}</h3>
                            <p class="text-gray-600 text-sm mb-4">{{ Str::limit($product->description, 100) }}</p>
                            <div class="flex items-center justify-between">
                                <span
                                    class="text-xl font-bold text-gray-900">${{ number_format($product->price, 2) }}</span>
                                <a href="{{ route('products.show', $product) }}"
                                    class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700 focus:bg-blue-700 active:bg-blue-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                                    Ver Detalles
                                </a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</x-app-layout>
