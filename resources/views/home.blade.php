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

    <section class="relative h-[90vh] flex items-end justify-start text-white overflow-hidden">
        <div class="absolute top-0 left-0 w-full h-full z-0">
            <!-- Contenedor del video -->
            <div id="video-container" class="w-full h-full">
                <!-- Imagen de carga -->
                <div id="loading-screen" class="w-full h-full bg-gray-900 flex items-center justify-center">
                    <div class="text-white text-center">
                        <div class="animate-spin rounded-full h-32 w-32 border-b-2 border-white mb-4"></div>
                        <p class="text-xl">Cargando video...</p>
                    </div>
                </div>
                <!-- Video que se cargará dinámicamente -->
                <video id="banner-video" class="w-full h-full object-cover hidden" 
                       autoplay loop muted playsinline
                       preload="metadata"
                       poster="{{ asset('images/video-poster.jpg') }}">
                    <source src="{{ asset('videos/banner-video.mp4') }}" type="video/mp4">
                    Tu navegador no soporta videos HTML5.
                </video>
            </div>
            
            <!-- Script para manejar la carga del video -->
            <script>
                document.addEventListener('DOMContentLoaded', function() {
                    const video = document.getElementById('banner-video');
                    const loadingScreen = document.getElementById('loading-screen');
                    
                    // Configurar el video para cargar solo los metadatos inicialmente
                    video.addEventListener('loadedmetadata', function() {
                        // Mostrar el video y ocultar la pantalla de carga
                        video.classList.remove('hidden');
                        loadingScreen.classList.add('hidden');
                        
                        // Intentar reproducir el video
                        video.play().catch(error => {
                            console.error('Error al reproducir el video:', error);
                            // Si hay error, mostrar un mensaje alternativo
                            const errorDiv = document.createElement('div');
                            errorDiv.className = 'w-full h-full bg-gray-900 flex items-center justify-center text-white';
                            errorDiv.innerHTML = '<p class="text-xl">No se pudo cargar el video. Disculpa las molestias.</p>';
                            loadingScreen.parentNode.insertBefore(errorDiv, loadingScreen);
                            loadingScreen.remove();
                        });
                    });
                });
            </script>
            <div class="absolute top-0 left-0 w-full h-full bg-black opacity-50"></div>
        </div>
        <div class="relative z-10 text-left p-8 md:p-16 max-w-3xl">
            <h1 class="text-4xl md:text-6xl font-bold mb-4 animate-fade-in-down">
                Bienvenido a nuestra tienda en línea
            </h1>
            <p class="text-lg md:text-xl mb-8 animate-fade-in-up">
                Descubre nuestra selección de productos de alta calidad a los mejores precios.
                ¡Envío gratis en compras mayores a $500!
            </p>
            <a href="{{ route('shop.index') }}"
                class="inline-block bg-primary text-dark-text font-bold py-3 px-8 rounded-full hover:bg-yellow-500 transition-all duration-300 transform hover:scale-105">
                Ir a la Tienda
            </a>
        </div>
    </section>

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

    <div class="bg-white py-16">
        <div class="max-w-7xl mx-auto">
            <h2 class="text-3xl font-bold text-center text-gray-800 mb-12 px-4">Nuestras Marcas de Confianza</h2>
            <x-brand-section :brands="[
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
                'TITANIUM',
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
