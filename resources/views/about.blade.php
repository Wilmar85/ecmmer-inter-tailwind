<x-app-layout>
    {{-- SEO para la Página --}}
    @section('title', 'Sobre Nosotros')
    @section('description',
        'Conoce más sobre nuestra historia, misión y los valores que nos impulsan a ofrecerte lo
        mejor.')

        {{-- 1. Cabecera con Video de Fondo --}}
        <section class="relative h-[60vh] flex items-center justify-center text-center text-white overflow-hidden">
            {{-- Contenedor del Video --}}
            <div class="absolute top-0 left-0 w-full h-full z-0">
                <video class="w-full h-full object-cover object-top" autoplay loop muted playsinline>
                    {{-- Puedes usar el mismo video o uno diferente aquí --}}
                    <source src="{{ asset('videos/banner-video-2.mp4') }}" type="video/mp4">
                    Tu navegador no soporta videos HTML5.
                </video>
                {{-- Capa oscura para legibilidad --}}
                <div class="absolute top-0 left-0 w-full h-full bg-black opacity-60"></div>
            </div>

            {{-- Contenido del Banner --}}
            <div class="relative z-10 px-4">
                <h1 class="text-4xl md:text-5xl font-extrabold text-primary animate-fade-in-down">Sobre Nosotros</h1>
                <p class="mt-4 text-xl text-light-text max-w-3xl mx-auto animate-fade-in-up">
                    Somos más que una tienda; somos tu socio de confianza en materiales eléctricos y de iluminación.
                </p>
            </div>
        </section>

        {{-- 2. Sección de Nuestra Historia --}}
        <section class="py-16 bg-white">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 grid grid-cols-1 md:grid-cols-2 gap-12 items-center">
                <div class="space-y-4">
                    <h2 class="text-3xl font-bold text-dark-text">Nuestra Historia</h2>
                    <p class="text-gray-600">
                        Nacimos de la pasión por la calidad y el servicio. Desde nuestros inicios, hemos trabajado
                        incansablemente para convertirnos en un referente en el sector, ofreciendo no solo productos, sino
                        soluciones completas para cada uno de nuestros clientes.
                    </p>
                    <p class="text-gray-600">
                        A lo largo de los años, hemos construido una reputación basada en la confianza y la excelencia,
                        adaptándonos a las nuevas tecnologías y a las necesidades cambiantes del mercado para estar siempre
                        un paso adelante.
                    </p>
                </div>
                <div class="h-80 bg-gray-100 rounded-lg flex items-center justify-center">
                    <svg class="w-24 h-24 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M4 5a1 1 0 011-1h14a1 1 0 011 1v2a1 1 0 01-1 1H5a1 1 0 01-1-1V5zM4 13a1 1 0 011-1h6a1 1 0 011 1v6a1 1 0 01-1 1H5a1 1 0 01-1-1v-6zM16 13a1 1 0 011-1h2a1 1 0 011 1v6a1 1 0 01-1 1h-2a1 1 0 01-1-1v-6z">
                        </path>
                    </svg>
                </div>
            </div>
        </section>

        {{-- 3. Sección de Valores con Iconos --}}
        <section class="py-16 bg-gray-50">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="text-center">
                    <h2 class="text-3xl font-bold text-dark-text">Nuestros Valores</h2>
                    <p class="mt-2 text-lg text-gray-600">Los pilares que guían cada una de nuestras acciones.</p>
                </div>
                <div class="mt-12 grid grid-cols-1 md:grid-cols-3 gap-10">
                    <div class="text-center p-6 bg-white rounded-lg shadow-md hover:shadow-xl transition-shadow">
                        <div
                            class="flex items-center justify-center h-16 w-16 rounded-full bg-primary text-dark-text mx-auto mb-4">
                            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7">
                                </path>
                            </svg>
                        </div>
                        <h3 class="text-xl font-semibold text-dark-text">Calidad Garantizada</h3>
                        <p class="mt-2 text-gray-600">Solo ofrecemos productos que cumplen con los más altos estándares de
                            calidad y durabilidad.</p>
                    </div>
                    <div class="text-center p-6 bg-white rounded-lg shadow-md hover:shadow-xl transition-shadow">
                        <div
                            class="flex items-center justify-center h-16 w-16 rounded-full bg-primary text-dark-text mx-auto mb-4">
                            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                            </svg>
                        </div>
                        <h3 class="text-xl font-semibold text-dark-text">Compromiso con el Cliente</h3>
                        <p class="mt-2 text-gray-600">Tu satisfacción es nuestra máxima prioridad. Estamos aquí para
                            asesorarte y apoyarte en cada paso.</p>
                    </div>
                    <div class="text-center p-6 bg-white rounded-lg shadow-md hover:shadow-xl transition-shadow">
                        <div
                            class="flex items-center justify-center h-16 w-16 rounded-full bg-primary text-dark-text mx-auto mb-4">
                            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z">
                                </path>
                            </svg>
                        </div>
                        <h3 class="text-xl font-semibold text-dark-text">Innovación Constante</h3>
                        <p class="mt-2 text-gray-600">Buscamos continuamente las últimas tendencias y tecnologías para
                            ofrecerte soluciones modernas y eficientes.</p>
                    </div>
                </div>
            </div>
        </section>

        {{-- 4. Llamada a la Acción (CTA) --}}
        <section class="bg-secondary">
            <div class="max-w-4xl mx-auto text-center py-16 px-4 sm:px-6 lg:px-8">
                <h2 class="text-3xl font-extrabold text-white sm:text-4xl">
                    ¿Listo para empezar tu próximo proyecto?
                </h2>
                <p class="mt-4 text-lg leading-6 text-light-text">
                    Explora nuestro catálogo y descubre por qué somos la mejor opción para ti.
                </p>
                <a href="{{ route('shop.index') }}"
                    class="mt-8 w-full inline-flex items-center justify-center px-5 py-3 border border-transparent text-base font-medium rounded-full text-dark-text bg-primary hover:bg-yellow-500 sm:w-auto">
                    Ver Productos
                </a>
            </div>
        </section>

    </x-app-layout>
