@php
    // Sanitizar datos para metadatos
    $metaTitle = e($product->name) . ' | E-commerce Web';
    $metaDescription = e($product->short_description ?? Str::limit(strip_tags($product->description), 150));
    $metaKeywords = e($product->name . ', ' . ($product->category->name ?? '') . ', comprar, ecommerce');
    $ogTitle = e($product->name);
    $ogDescription = e($product->short_description ?? Str::limit(strip_tags($product->description), 150));
    $ogImage = $product->images->isNotEmpty()
        ? asset('storage/' . $product->images->first()->path)
        : asset('images/default-og.png');
    $canonical = url()->current();
    
    // Preparar datos para JSON-LD de forma segura
    $jsonLdData = [
        '@context' => 'https://schema.org',
        '@type' => 'Product',
        'name' => $product->name,
        'image' => $product->images->isNotEmpty() 
            ? $product->images->map(fn($img) => asset('storage/' . $img->path))->all()
            : [asset('images/default-og.png')],
        'description' => $product->short_description ?? Str::limit(strip_tags($product->description), 150),
        'sku' => $product->sku ?? (string)$product->id,
        'brand' => [
            '@type' => 'Brand',
            'name' => $product->brand->name ?? 'Marca genérica'
        ],
        'offers' => [
            '@type' => 'Offer',
            'priceCurrency' => 'MXN',
            'price' => (float)$product->price,
            'availability' => 'https://schema.org/' . ($product->stock > 0 ? 'InStock' : 'OutOfStock')
        ]
    ];
@endphp

@push('jsonld')
    <script type="application/ld+json">
        {!! json_encode($jsonLdData, JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP | JSON_UNESCAPED_UNICODE) !!}
    </script>
@endpush

<x-app-layout>
    @push('scripts')
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                const token = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');
                
                if (token) {
                    fetch("{{ route('preferences.visited', ['productId' => $product->id]) }}", {
                        method: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': token,
                            'Content-Type': 'application/json',
                            'Accept': 'application/json',
                            'X-Requested-With': 'XMLHttpRequest'
                        },
                        credentials: 'same-origin'
                    }).catch(error => console.error('Error al registrar visita:', error));
                }
            });
        </script>
    @endpush

    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight truncate pr-4">
                {{ $product->name }}
            </h2>
            <div class="flex-shrink-0 flex items-center gap-4">
                @can('update', $product)
                    <a href="{{ route('admin.products.edit', $product) }}"
                        class="px-4 py-2 bg-blue-600 text-white text-sm font-medium rounded-md hover:bg-blue-700">Editar</a>
                @endcan
                <a href="{{ route('shop.index') }}"
                    class="inline-flex items-center px-4 py-2 bg-gray-200 border border-transparent rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest hover:bg-gray-300 transition ease-in-out duration-150">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                    </svg>
                    {{ __('Volver a la Tienda') }}
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-12 bg-gray-50">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                <div class="p-6 md:p-8 grid grid-cols-1 lg:grid-cols-2 gap-12">

                    <!-- Sección de imágenes -->
                    <div class="w-full">
                        @if ($product->images->isNotEmpty())
                            @php
                                $firstImage = $product->images->first();
                                $firstImageUrl = $firstImage->image_url;
                            @endphp
                            
                            @if ($product->images->count() > 1)
                                <!-- Vista con múltiples imágenes -->
                                <div x-data="{ selectedImage: '{{ e($firstImageUrl) }}' }" class="flex flex-row-reverse gap-4">
                                    <!-- Imagen principal -->
                                    <div class="w-4/5">
                                        <div class="relative h-full w-full aspect-w-1 aspect-h-1 overflow-hidden rounded-lg bg-gray-100 flex items-center justify-center group">
                                            <img 
                                                :src="selectedImage" 
                                                alt="{{ e($product->name) }}"
                                                class="max-w-full max-h-full object-contain"
                                                onerror="this.onerror=null; this.src='{{ e(asset('images/placeholder.jpg')) }}'"
                                            >
                                        </div>
                                    </div>
                                    
                                    <!-- Miniaturas -->
                                    <div class="w-1/5 pr-2">
                                        <div class="flex flex-col space-y-3 max-h-[500px] overflow-y-auto pr-1 custom-scrollbar">
                                            <!-- Scroll personalizado para navegadores WebKit -->
                                            <style>
                                                .custom-scrollbar::-webkit-scrollbar {
                                                    width: 4px;
                                                }
                                                .custom-scrollbar::-webkit-scrollbar-track {
                                                    background: #f1f1f1;
                                                    border-radius: 4px;
                                                }
                                                .custom-scrollbar::-webkit-scrollbar-thumb {
                                                    background: #d1d5db;
                                                    border-radius: 4px;
                                                }
                                                .custom-scrollbar::-webkit-scrollbar-thumb:hover {
                                                    background: #9ca3af;
                                                }
                                            </style>
                                        @foreach ($product->images as $image)
                                            @php
                                                // Obtener la ruta completa de la imagen
                                                $imagePath = $image->path ?? $image->image_path ?? '';
                                                
                                                // Generar URLs para la miniatura y la imagen completa
                                                $thumbnailUrl = $imagePath ? asset('storage/' . dirname($imagePath) . '/thumb/' . basename($imagePath)) : '';
                                                $fullImageUrl = $imagePath ? asset('storage/' . $imagePath) : '';
                                                
                                                // Verificar si la miniatura existe, si no, usar la imagen original
                                                $thumbnailPath = $imagePath ? 'storage/' . dirname($imagePath) . '/thumb/' . basename($imagePath) : '';
                                                $useOriginalThumbnail = $imagePath && !file_exists(public_path($thumbnailPath));
                                                
                                                if ($useOriginalThumbnail) {
                                                    $thumbnailUrl = asset('storage/' . $imagePath);
                                                }
                                                
                                                // Crear el HTML para las miniaturas con tamaño fijo
                                                $thumbnail = '<div class="relative w-full h-full">
                                                    <img src="' . e($thumbnailUrl) . '" 
                                                        alt="Miniatura ' . e($loop->iteration) . '" 
                                                        class="w-full h-full object-cover rounded-sm hover:opacity-90 transition-opacity duration-200"
                                                        onerror="this.onerror=null; this.src=\'' . e(asset('images/placeholder-thumb.jpg')) . '\'"
                                                    >
                                                </div>';
                                                
                                                $fullImage = $fullImageUrl;
                                            @endphp
                                            <button 
                                                type="button"
                                                class="w-full rounded-md bg-gray-100 overflow-hidden cursor-pointer border-2 transition-all hover:shadow-md focus:outline-none focus:ring-2 focus:ring-primary focus:ring-opacity-50"
                                                :class="{ 'border-primary ring-2 ring-primary ring-opacity-50': selectedImage === '{{ e($fullImage) }}', 'border-gray-200': selectedImage !== '{{ e($fullImage) }}' }"
                                                @click="selectedImage = '{{ e($fullImage) }}'"
                                                aria-label="Ver imagen de {{ e($product->name) }} - {{ $loop->iteration }} de {{ $loop->count }}"
                                                style="height: 80px;"
                                            >
                                                {!! $thumbnail !!}
                                            </button>
                                        @endforeach
                                        </div>
                                    </div>
                                </div>
                            @else
                                <!-- Vista para un solo producto -->
                                <div class="relative h-96 w-full overflow-hidden rounded-lg bg-gray-100 flex items-center justify-center group">
                                    @php
                                        $imgAttrs = [
                                            'class' => 'max-w-full max-h-full object-contain transition-transform duration-300 group-hover:scale-105',
                                            'style' => 'aspect-ratio: 1/1;',
                                            'alt' => e($product->name),
                                            'loading' => 'lazy',
                                            'onerror' => "this.onerror=null; this.src='" . e(asset('images/placeholder.jpg')) . "'"
                                        ];
                                        $imgTag = optimized_image($firstImage->image_path, 'large', $product->name, $imgAttrs);
                                    @endphp
                                    {!! $imgTag !!}
                                </div>
                            @endif
                        @else
                            <!-- Vista cuando no hay imágenes -->
                            <div class="h-96 bg-gray-200 flex items-center justify-center rounded-lg">
                                <span class="text-gray-500">Sin imagen</span>
                            </div>
                        @endif
                    </div>

                    <!-- Sección de detalles del producto -->
                    <div class="flex flex-col space-y-6">
                        <div>
                            <p class="text-sm font-medium text-primary">{{ $product->category->name ?? 'Sin categoría' }}</p>
                            <h1 class="text-4xl font-extrabold text-gray-900 mt-1">{{ $product->name }}</h1>
                        </div>
                        
                        <div class="text-3xl font-bold text-gray-900">
                            ${{ number_format($product->price, 2) }}
                        </div>
                        
                        <div class="prose max-w-none text-gray-600">
                            {!! $product->description !!}
                        </div>
                        
                        @php
                            $businessHours = auth()->user()?->business_hours ?? 'Lunes a Viernes: 8:00 AM - 6:00 PM, Sábados: 8:00 AM - 2:00 PM';
                        @endphp
                        
                        <div class="flex items-start text-sm text-gray-600 mt-2">
                            <svg class="w-5 h-5 mr-2 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            <div>
                                <span class="font-semibold">Horario de atención:</span>
                                <span class="ml-1">{{ $businessHours }}</span>
                            </div>
                        </div>
                        
                        <div class="text-sm text-gray-600">
                            <span class="font-semibold">Disponibilidad:</span>
                            @if ($product->stock > 0)
                                <span class="text-green-600">En Stock ({{ $product->stock }} disponibles)</span>
                            @else
                                <span class="text-red-600">Agotado</span>
                            @endif
                        </div>

                        <!-- Formulario de carrito -->
                        @auth
                            <form action="{{ route('cart.add') }}" method="POST" class="space-y-4 pt-4 border-t border-gray-200">
                                @csrf
                                <input type="hidden" name="product_id" value="{{ $product->id }}">
                                <div>
                                    <label for="quantity" class="block text-sm font-medium text-gray-700 mb-2">
                                        {{ __('Cantidad') }}
                                    </label>
                                    <input 
                                        type="number" 
                                        name="quantity" 
                                        id="quantity" 
                                        min="1"
                                        max="{{ (int)$product->stock }}" 
                                        value="1"
                                        aria-label="{{ __('Cantidad') }}"
                                        class="mt-1 block w-24 rounded-md border-gray-300 shadow-sm focus:border-primary focus:ring-primary"
                                    >
                                    @error('quantity')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>
                                <button 
                                    type="submit"
                                    class="w-full text-center px-6 py-4 bg-primary border-2 border-primary rounded-full font-semibold text-base text-dark-text uppercase tracking-widest hover:bg-gray-800 hover:border-gray-800 hover:text-white transition-all duration-300 disabled:opacity-50 disabled:cursor-not-allowed"
                                    {{ $product->stock < 1 ? 'disabled' : '' }}
                                >
                                    {{ $product->stock < 1 ? 'Sin stock' : 'Agregar al carrito' }}
                                </button>
                            </form>
                        @else
                            <div class="pt-4 border-t border-gray-200">
                                <a 
                                    href="{{ route('login') }}"
                                    class="w-full inline-block text-center px-6 py-4 bg-primary border-2 border-primary rounded-full font-semibold text-base text-dark-text uppercase tracking-widest hover:bg-gray-800 hover:border-gray-800 hover:text-white transition-all duration-300"
                                >
                                    Inicia sesión para comprar
                                </a>
                            </div>
                        @endauth
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
