@props(['product'])

<div
    class="group bg-white rounded-lg shadow-md overflow-hidden transition-transform duration-200 transform hover:scale-105 flex flex-col justify-between min-h-[340px]">
    @if ($product->images->isNotEmpty())
        @php
            // Obtener la imagen primaria o la primera imagen disponible
            $image = $product->primaryImage ?? $product->images->first();
            // Usar el accesor image_url del modelo ProductImage
            $imgUrl = $image->image_url;
        @endphp

        <a href="{{ route('products.show', $product) }}">
            <div class="h-48 w-full bg-gray-50 flex items-center justify-center overflow-hidden">
                <img src="{{ $imgUrl }}" 
                     alt="{{ $product->name }}"
                     class="h-full w-full object-contain group-hover:scale-110 transition-transform duration-300 ease-in-out"
                     onerror="this.onerror=null; this.src='{{ asset('images/placeholder-product.png') }}'"
                     loading="lazy">
            </div>
        </a>

        <button x-data="{ open: false }" @click="open = true"
            class="absolute top-2 right-2 bg-white rounded-full shadow p-1 hover:bg-gray-100">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-700" fill="none" viewBox="0 0 24 24"
                stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round"
                    d="M15 12a3 3 0 11-6 0 3 3 0 016 0zm6 0c0 5-7 9-7 9s-7-4-7-9a7 7 0 0114 0z" />
            </svg>
        </button>
        <div x-data="{ open: false }" x-show="open" @click.away="open = false"
            class="fixed inset-0 flex items-center justify-center z-50 bg-black bg-opacity-40" style="display:none;">
            <div class="bg-white rounded-lg shadow-lg p-6 w-96">
                <h2 class="font-bold text-lg mb-2">{{ $product->name }}</h2>
                <p class="mb-2">{{ $product->description }}</p>
                <button @click="open = false" class="mt-4 px-4 py-2 bg-blue-600 text-white rounded">Cerrar</button>
            </div>
        </div>
    @endif

    <div class="p-4 flex flex-col flex-1 justify-between">
        <div>
            <a href="{{ route('products.show', $product) }}"
                class="block font-semibold text-gray-900 hover:text-blue-600 mb-2 truncate text-lg">{{ $product->name }}</a>
            <p class="text-gray-600 text-sm mb-2 line-clamp-2">{{ Str::limit($product->description, 100) }}</p>
        </div>
        <div class="flex items-center justify-between pt-2 mb-2">
            <span class="text-xl font-bold text-gray-900">${{ number_format($product->price, 2) }}</span>
        </div>
        <div class="flex gap-1 justify-center">
            <a href="{{ route('products.show', $product) }}"
                class="w-10 h-10 flex justify-center items-center text-center bg-blue-600 border border-transparent rounded-full text-white hover:bg-blue-700 focus:bg-blue-700 active:bg-blue-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M15 12a3 3 0 11-6 0 3 3 0 016 0zm6 0c0 5-7 9-7 9s-7-4-7-9a7 7 0 0114 0z" />
                </svg>
            </a>
            @auth
                <form action="{{ route('cart.add') }}" method="POST" class="w-10 h-10" x-data="{}"
                    @submit.prevent="
                    let form = $el;
                    let data = new FormData(form);
                    fetch(form.action, {
                        method: 'POST',
                        headers: { 'X-Requested-With': 'XMLHttpRequest', 'X-CSRF-TOKEN': data.get('_token') },
                        body: data
                    }).then(res => {
                        if(res.redirected) { window.location.href = res.url; return; }
                        if(res.ok) {
                            res.clone().json().then(data => {
                                if(typeof data.count !== 'undefined') {
                                    window.dispatchEvent(new CustomEvent('cart-updated', { detail: { count: data.count } }));
                                    if(window.Laravel && window.Laravel.updateCartCount) window.Laravel.updateCartCount(data.count);
                                } else {
                                    window.dispatchEvent(new CustomEvent('cart-updated'));
                                }
                            });
                        }
                        return res.json();
                    }).catch(() => {});
                ">
                    @csrf
                    <input type="hidden" name="product_id" value="{{ $product->id }}">
                    <input type="hidden" name="quantity" value="1">
                    <button type="submit"
                        class="w-10 h-10 flex justify-center items-center text-center bg-green-600 border border-transparent rounded-full text-white hover:bg-green-700 focus:bg-green-700 active:bg-green-900 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2 transition ease-in-out duration-150">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13l-1.35 2.7A2 2 0 007.48 19h8.94a2 2 0 001.83-1.23L21 13M7 13V6a1 1 0 011-1h9a1 1 0 011 1v7" />
                        </svg>
                    </button>
                </form>
            @else
                <a href="{{ route('login') }}"
                    class="w-10 h-10 flex justify-center items-center text-center bg-green-600 border border-transparent rounded-full text-white hover:bg-green-700 focus:bg-green-700 active:bg-green-900 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2 transition ease-in-out duration-150">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13l-1.35 2.7A2 2 0 007.48 19h8.94a2 2 0 001.83-1.23L21 13M7 13V6a1 1 0 011-1h9a1 1 0 011 1v7" />
                    </svg>
                </a>
            @endauth
        </div>
    </div>
</div>
