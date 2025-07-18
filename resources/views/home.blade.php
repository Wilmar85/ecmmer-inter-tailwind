@php
    $metaTitle = 'Inicio | InterEleticosf&A';
    $metaDescription =
        'Bienvenido a InterEleticosf&A, tu tienda online de confianza para productos de calidad, ofertas exclusivas y envío gratis en compras mayores a $500.';
    $metaKeywords = 'inicio, ecommerce, ofertas, productos, tienda online, InterEleticosfA';
    $ogTitle = 'Bienvenido a InterEleticosf&A';
    $ogDescription = 'Explora nuestra tienda online y encuentra productos increíbles a precios bajos.';
    $ogImage = asset('images/default-og.png');
    $canonical = url('/');
@endphp

@push('jsonld')
    <script type="application/ld+json">
{
    "@context": "https://schema.org",
    "@type": "WebSite",
    "name": "E-commerce Web",
    "url": "{{ url('/') }}"
}
</script>
@endpush

<x-app-layout>

    <!-- Slider Hero -->
    @if(isset($sliders) && $sliders->count() > 0)
        <x-hero-slider :slides="$sliders->map(function($slider) {
            return [
                'type' => $slider->type,
                'src' => $slider->media_url,
                'title' => $slider->title,
                'description' => $slider->description,
                'button_text' => $slider->button_text ?? 'Ver más',
                'button_url' => $slider->button_url ?? '#',
                'thumbnail' => $slider->thumbnail_url
            ];
        })" />
    @else
        <!-- Slider por defecto si no hay sliders configurados -->
        <x-hero-slider :slides="[
            [
                'type' => 'image',
                'src' => 'https://images.unsplash.com/photo-1604594842169-1ec43edfad1b?ixlib=rb-1.2.1&auto=format&fit=crop&w=1950&q=80',
                'title' => 'Materiales Eléctricos',
                'description' => 'Todo lo que necesitas para tus instalaciones eléctricas',
                'button_text' => 'Ver Catálogo',
                'button_url' => route('products.index')
            ],
            [
                'type' => 'image',
                'src' => 'https://images.unsplash.com/photo-1556740734-7c084a70051f?ixlib=rb-1.2.1&auto=format&fit=crop&w=1950&q=80',
                'title' => 'Lámparas y Luminarias',
                'description' => 'Iluminación eficiente para cada espacio',
                'button_text' => 'Ver Luminarias',
                'button_url' => route('products.index', ['category' => 'iluminacion'])
            ]
        ]" />
    @endif

    <section class="py-16 bg-white">
        <div class="max-w-7xl mx-auto">
            <h2 class="text-3xl font-bold text-center text-gray-800 mb-10 px-4">Explora Nuestras Categorías</h2>
            <div x-data="{
                autoplay: null,
                startAutoplay(delay = 3000) {
                    this.autoplay = setInterval(() => {
                        let container = this.$refs.container;
                        if (container.scrollLeft + container.clientWidth >= container.scrollWidth - 1) {
                            container.scrollTo({ left: 0, behavior: 'smooth' });
                        } else {
                            container.scrollBy({ left: 300, behavior: 'smooth' });
                        }
                    }, delay);
                },
                stopAutoplay() {
                    clearInterval(this.autoplay);
                }
            }" x-init="startAutoplay()" @mouseenter="stopAutoplay()"
                @mouseleave="startAutoplay()" class="relative group">

                <button @click="$refs.container.scrollBy({ left: -300, behavior: 'smooth' })"
                    class="absolute top-1/2 left-0 -translate-y-1/2 z-20 bg-white/70 hover:bg-white rounded-full p-2 shadow-md transition-all opacity-0 group-hover:opacity-100 group-hover:left-4 disabled:opacity-30">
                    <svg class="w-6 h-6 text-gray-800" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7">
                        </path>
                    </svg>
                </button>

                <div x-ref="container"
                    class="flex space-x-6 overflow-x-auto pb-6 -mx-4 px-4 sm:px-6 lg:px-8 scrollbar-hide">
                    @foreach ($categories as $category)
                        <a href="{{ route('categories.show', $category) }}" class="group flex-shrink-0">
                            <div
                                class="w-64 h-40 rounded-lg flex flex-col items-center justify-center text-center p-4 bg-gray-100 shadow-lg transform transition-all duration-300 hover:bg-primary hover:scale-105">
                                <h3
                                    class="text-xl font-bold text-gray-700 group-hover:text-dark-text transition-colors">
                                    {{ $category->name }}
                                </h3>
                                <p class="text-sm text-gray-500 mt-2 group-hover:text-dark-text/70 transition-colors">
                                    {{ $category->products_count }} productos
                                </p>
                            </div>
                        </a>
                    @endforeach
                </div>

                <button @click="$refs.container.scrollBy({ left: 300, behavior: 'smooth' })"
                    class="absolute top-1/2 right-0 -translate-y-1/2 z-20 bg-white/70 hover:bg-white rounded-full p-2 shadow-md transition-all opacity-0 group-hover:opacity-100 group-hover:right-4 disabled:opacity-30">
                    <svg class="w-6 h-6 text-gray-800" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                    </svg>
                </button>
            </div>
        </div>
    </section>

    <div class="py-12 bg-gray-50">
        <div class="max-w-7xl mx-auto">
            <h2 class="text-3xl font-bold text-center text-gray-900 mb-10">Productos Destacados</h2>
            <div class="flex space-x-8 overflow-x-auto pb-6 -mx-4 px-4 sm:px-6 lg:px-8 scrollbar-hide">
                @foreach ($products as $product)
                    <div class="flex-shrink-0 w-72">
                        <x-product-card :product="$product" />
                    </div>
                @endforeach
            </div>
        </div>
    </div>

    <!-- Sección de marcas modernas -->
    <div class="bg-gradient-to-b from-white to-gray-50 py-16 overflow-hidden">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <x-modern-brands :brands="[
                'MERCURY',
                'TITANIUM',
                'ZAFIRO',
                'ILUMAX',
                'ECOLITE',
                'EXCELITE',
                'INTERLED',
                'DEXON',
                'BRIOLIGH',
                'ROYAL',
                'LUMEK',
                'DIXTON',
                'BAYTER',
                'SPARKLED',
                'KARLUX',
                'FELGOLUX',
                'NEW LIGHT',
                'DIGITAL LIGHT',
                'SICOLUX',
                'ACRILED',
                'MARWA',
            ]" />
        </div>
    </div>

    {{-- El código del banner de cookies fue movido a resources/views/layouts/app.blade.php para que funcione en todo el sitio. --}}

</x-app-layout>
