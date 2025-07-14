@php
    $metaTitle = $product->name . ' | E-commerce Web';
    $metaDescription = $product->short_description ?? Str::limit(strip_tags($product->description), 150);
    $metaKeywords = $product->name . ', ' . ($product->category->name ?? '') . ', comprar, ecommerce';
    $ogTitle = $product->name;
    $ogDescription = $product->short_description ?? Str::limit(strip_tags($product->description), 150);
    $ogImage = $product->images->isNotEmpty()
        ? asset('storage/' . $product->images->first()->path)
        : asset('images/default-og.png');
    $canonical = url()->current();
@endphp

@push('jsonld')
    <script type="application/ld+json">
{
    "@context": "https://schema.org",
    "@type": "Product",
    "name": "{{ $product->name }}",
    "image": [
        @if($product->images->isNotEmpty())
            @foreach($product->images as $img)"{{ asset('storage/' . $img->path) }}"@if(!$loop->last),@endif @endforeach
        @else
            "{{ asset('images/default-og.png') }}"
        @endif
    ],
    "description": "{{ $product->short_description ?? Str::limit(strip_tags($product->description), 150) }}",
    "sku": "{{ $product->sku ?? $product->id }}",
    "brand": {
        "@type": "Brand",
        "name": "{{ $product->brand->name ?? 'Marca genérica' }}"
    },
    "offers": {
        "@type": "Offer",
        "priceCurrency": "MXN",
        "price": "{{ $product->price }}",
        "availability": "https://schema.org/{{ $product->stock > 0 ? 'InStock' : 'OutOfStock' }}"
    }
}
</script>
@endpush

<x-app-layout>
    @push('scripts')
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                fetch("{{ route('preferences.visited', ['productId' => $product->id]) }}", {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'Accept': 'application/json'
                    }
                });
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

                    <div class="w-full">
                        @if ($product->images->isNotEmpty())
                            @if ($product->images->count() > 1)
                                <div x-data="{ selectedImage: '{{ $product->images->first()->image_url }}' }" class="flex flex-row-reverse gap-4">
                                    <div class="w-4/5">
                                        <div
                                            class="relative h-full w-full aspect-w-1 aspect-h-1 overflow-hidden rounded-lg bg-gray-100 flex items-center justify-center group">
                                            <img :src="selectedImage" alt="{{ $product->name }}"
                                                class="max-w-full max-h-full object-contain transition-transform duration-300 group-hover:scale-105">
                                        </div>
                                    </div>
                                    <div class="w-1/5 space-y-4">
                                        @foreach ($product->images as $image)
                                            <div class="aspect-w-1 aspect-h-1 rounded-md bg-gray-100 overflow-hidden cursor-pointer border-2 transition-all"
                                                :class="{ 'border-primary': selectedImage === '{{ $image->image_url }}', 'border-transparent': selectedImage !== '{{ $image->image_url }}' }"
                                                @click="selectedImage = '{{ $image->image_url }}'">
                                                <img src="{{ $image->image_url }}"
                                                    alt="Miniatura de {{ $product->name }}"
                                                    class="w-full h-full object-contain">
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            @else
                                <div
                                    class="relative h-96 w-full overflow-hidden rounded-lg bg-gray-100 flex items-center justify-center group">
                                    <img src="{{ $product->images->first()->image_url }}" alt="{{ $product->name }}"
                                        class="max-w-full max-h-full object-contain transition-transform duration-300 group-hover:scale-105">
                                </div>
                            @endif
                        @else
                            <div class="h-96 bg-gray-200 flex items-center justify-center rounded-lg">
                                <span class="text-gray-500">Sin imagen</span>
                            </div>
                        @endif
                    </div>

                    <div class="flex flex-col space-y-6">
                        <div>
                            <p class="text-sm font-medium text-primary">{{ $product->category->name }}</p>
                            <h1 class="text-4xl font-extrabold text-gray-900 mt-1">{{ $product->name }}</h1>
                        </div>
                        <div class="text-3xl font-bold text-gray-900">
                            ${{ number_format($product->price, 2) }}
                        </div>
                        <div class="prose max-w-none text-gray-600">
                            <p>{{ $product->description }}</p>
                        </div>
                        <div class="text-sm text-gray-600">
                            <span class="font-semibold">Disponibilidad:</span>
                            @if ($product->stock > 0)
                                <span class="text-green-600">En Stock ({{ $product->stock }} disponibles)</span>
                            @else
                                <span class="text-red-600">Agotado</span>
                            @endif
                        </div>

                        {{-- INICIO DE LA CORRECCIÓN --}}
                        @auth
                            <form action="{{ route('cart.add') }}" method="POST"
                                class="space-y-4 pt-4 border-t border-gray-200">
                                @csrf
                                <input type="hidden" name="product_id" value="{{ $product->id }}">
                                <div>
                                    <label for="quantity"
                                        class="block text-sm font-medium text-gray-700 mb-2">Cantidad</label>
                                    <input type="number" name="quantity" id="quantity" min="1"
                                        max="{{ $product->stock }}" value="1"
                                        class="mt-1 block w-24 rounded-md border-gray-300 shadow-sm focus:border-primary focus:ring-primary">
                                </div>
                                <button type="submit"
                                    class="w-full text-center px-6 py-4 bg-primary border-2 border-primary rounded-full font-semibold text-base text-dark-text uppercase tracking-widest hover:bg-gray-800 hover:border-gray-800 hover:text-white transition-all duration-300 disabled:opacity-50 disabled:cursor-not-allowed"
                                    {{ $product->stock < 1 ? 'disabled' : '' }}>
                                    {{ $product->stock < 1 ? 'Sin stock' : 'Agregar al carrito' }}
                                </button>
                            </form>
                        @else
                            <div class="pt-4 border-t border-gray-200">
                                <a href="{{ route('login') }}"
                                    class="w-full inline-block text-center px-6 py-4 bg-primary border-2 border-primary rounded-full font-semibold text-base text-dark-text uppercase tracking-widest hover:bg-gray-800 hover:border-gray-800 hover:text-white transition-all duration-300">
                                    Inicia sesión para comprar
                                </a>
                            </div>
                        @endauth
                        {{-- FIN DE LA CORRECCIÓN --}}
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
