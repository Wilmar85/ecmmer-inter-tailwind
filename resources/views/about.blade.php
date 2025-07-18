<x-app-layout>
    {{-- SEO para la Página --}}
    @section('title', 'Sobre Nosotros - Intereléctricos A&F')
    @section('description', 'Conoce nuestra historia, misión, visión y valores como empresa líder en materiales eléctricos e iluminación en Bucaramanga.')
    
    @push('styles')
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    <style>
        /* Custom Scrollbar */
        ::-webkit-scrollbar {
            width: 8px;
        }
        ::-webkit-scrollbar-track {
            background: #f1f1f1;
            border-radius: 10px;
        }
        ::-webkit-scrollbar-thumb {
            background: #3b82f6;
            border-radius: 10px;
            transition: all 0.3s ease;
        }
        ::-webkit-scrollbar-thumb:hover {
            background: #2563eb;
        }
        
        /* Smooth Scrolling */
        html {
            scroll-behavior: smooth;
        }
        
        /* Custom Animations */
        @keyframes float {
            0% { transform: translateY(0px); }
            50% { transform: translateY(-10px); }
            100% { transform: translateY(0px); }
        }
        
        .floating {
            animation: float 6s ease-in-out infinite;
        }
        
        .hover-scale {
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }
        
        .hover-scale:hover {
            transform: translateY(-5px);
            box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
        }
        
        /* Gradient text */
        .gradient-text {
            background: linear-gradient(90deg, var(--color-primary), var(--color-secondary));
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            text-fill-color: transparent;
        }
        
        /* Wave divider */
        .wave-divider {
            position: relative;
            width: 100%;
            overflow: hidden;
            line-height: 0;
            z-index: 1;
        }
        
        .wave-divider svg {
            position: relative;
            display: block;
            width: calc(100% + 1.3px);
            height: 80px;
        }
        
        /* Animation for elements that should fade in on scroll */
        [data-aos] {
            opacity: 0;
            transition-property: opacity, transform;
        }
        
        [data-aos].aos-animate {
            opacity: 1;
        }
        
        /* Gradient Text */
        .gradient-text {
            background: linear-gradient(90deg, #3b82f6, #8b5cf6);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            display: inline-block;
        }
        
        /* Section Dividers */
        .wave-divider {
            position: relative;
            height: 100px;
            overflow: hidden;
        }
        
        .wave-divider svg {
            position: absolute;
            bottom: 0;
            width: 100%;
            height: 100%;
        }
    </style>
    @endpush

    {{-- 1. Cabecera con Video de Fondo --}}
    <section class="relative h-[50vh] min-h-[400px] flex items-center justify-center text-center text-white overflow-hidden">
        {{-- Contenedor del Video --}}
        <div class="absolute top-0 left-0 w-full h-full z-0">
            <video class="w-full h-full object-cover object-top" autoplay loop muted playsinline style="object-position: center top;">
                <source src="{{ asset('videos/banner-video-2.mp4') }}" type="video/mp4">
                Tu navegador no soporta videos HTML5.
            </video>
            <div class="absolute top-0 left-0 w-full h-full bg-black/60"></div>
        </div>

        {{-- Hero Content --}}
        <div class="relative z-10 px-4 sm:px-6 lg:px-8 max-w-7xl mx-auto w-full mt-16">
            <div class="text-center">
                <h1 class="text-4xl md:text-5xl font-extrabold tracking-tight mb-4 md:mb-6 animate-fade-in-down">
                    <span class="block">Conoce Nuestra</span>
                    <span class="block text-primary mt-1 md:mt-2">Historia</span>
                </h1>
                <p class="text-lg sm:text-xl text-gray-200 max-w-3xl mx-auto animate-fade-in-up px-2">
                    Más de 10 años de experiencia ofreciendo soluciones eléctricas de calidad
                </p>
                <div class="mt-6 sm:mt-8 flex flex-col sm:flex-row justify-center gap-3 sm:gap-4">
                    <a href="#nuestra-historia" class="inline-flex items-center justify-center px-5 sm:px-6 py-2.5 sm:py-3 border border-transparent text-sm sm:text-base font-medium rounded-md text-white bg-primary hover:bg-primary-dark transition-colors duration-300">
                        Conócenos más
                    </a>
                    <a href="{{ route('contact') }}" class="inline-flex items-center justify-center px-5 sm:px-6 py-2.5 sm:py-3 border border-transparent text-sm sm:text-base font-medium rounded-md text-primary bg-white hover:bg-gray-100 transition-colors duration-300">
                        Contáctanos
                    </a>
                </div>
            </div>
            
            {{-- Scroll indicator --}}
            <div class="absolute bottom-8 left-1/2 transform -translate-x-1/2 animate-bounce">
                <a href="#nuestra-historia" class="text-white hover:text-primary transition-colors duration-300">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 14l-7 7m0 0l-7-7m7 7V3"></path>
                    </svg>
                </a>
            </div>
        </div>
        
        {{-- Floating elements --}}
        <div class="absolute top-20 left-10 w-8 h-8 bg-primary/20 rounded-full floating" style="animation-delay: 0s;"></div>
        <div class="absolute top-1/4 right-20 w-12 h-12 bg-secondary/20 rounded-full floating" style="animation-delay: 1s;"></div>
        <div class="absolute bottom-1/3 left-1/4 w-6 h-6 bg-accent/20 rounded-full floating" style="animation-delay: 1.5s;"></div>
    </section>

    {{-- 2. Sección de Nuestra Historia --}}
    <section id="nuestra-historia" class="py-16 bg-white overflow-hidden">
        <!-- Wave divider -->
        <!-- <div class="wave-divider rotate-180">
            <svg viewBox="0 0 1200 120" preserveAspectRatio="none" class="fill-current text-white">
                <path d="M321.39,56.44c58-10.79,114.16-30.13,172-41.86,82.39-16.72,168.19-17.73,250.45-.39C823.78,31,906.67,72,985.66,92.83c70.05,18.48,146.53,26.09,214.34,3V0H0V27.35A600.21,600.21,0,0,0,321.39,56.44Z"></path>
            </svg>
        </div> -->

        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-16 relative">
            <!-- Floating decorative elements -->
            <div class="absolute -top-20 -right-20 w-40 h-40 bg-primary/5 rounded-full blur-3xl"></div>
            <div class="absolute bottom-20 -left-20 w-60 h-60 bg-secondary/5 rounded-full blur-3xl"></div>
            
            <!-- Title with animation -->
            <div data-aos="fade-up" data-aos-duration="800">
                <div class="text-center max-w-4xl mx-auto">
                    <span class="inline-block mb-4 text-sm font-semibold text-primary tracking-wider uppercase">Nuestra Historia</span>
                    <h2 class="text-4xl md:text-5xl font-bold text-dark-text mb-6">¿Quiénes Somos?</h2>
                    <div class="w-24 h-1.5 bg-gradient-to-r from-primary to-secondary mx-auto mb-8"></div>
                    <p class="text-gray-600 text-lg leading-relaxed">
                        Somos una empresa comercializadora de materiales eléctricos e iluminación 100% santandereana, ubicados en Bucaramanga. 
                        Nuestra compañía es una empresa joven fundada en marzo del 2019 con el ideal de ofrecer a nuestros clientes 
                        artículos que se destacan por sus excelentes precios y calidad.
                    </p>
                </div>
            </div>

            <!-- Main content with image -->
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-center mt-16">
                <div class="space-y-6" data-aos="fade-right" data-aos-duration="800">
                    <div class="relative">
                        <h3 class="text-3xl font-bold text-dark-text relative z-10">Nuestros Inicios</h3>
                        <div class="absolute -left-4 -top-2 w-12 h-12 bg-primary/10 rounded-full z-0"></div>
                    </div>
                    
                    <div class="space-y-6 relative z-10">
                        <p class="text-gray-600 leading-relaxed transition-all duration-300 hover:bg-gray-50 p-4 rounded-lg">
                            <span class="text-primary font-medium">Intereléctricos A&F</span> nace del espíritu emprendedor de una pareja de novios que, ante la liquidación de un almacén eléctrico, 
                            vieron una oportunidad de iniciar una nueva etapa como empresarios independientes. El sueño de ser sus propios jefes, 
                            junto con su experiencia de 12 años en el sector de ventas y administración, les dio la fuerza para iniciar esta nueva aventura 
                            juntos como un equipo sinérgico.
                        </p>
                        <p class="text-gray-600 leading-relaxed transition-all duration-300 hover:bg-gray-50 p-4 rounded-lg">
                            A través de un acuerdo de pago a futuro, préstamos con bancos y familiares, reunieron el capital inicial para crear la sociedad 
                            legalmente constituida cumpliendo todos los requisitos de ley, llamándose <span class="font-medium text-dark-text">Intereléctricos A&F</span>, siendo las iniciales de 
                            <span class="font-medium">Alejandro</span> y <span class="font-medium">Felipe</span>, hijos del socio mayoritario de la empresa.
                        </p>
                    </div>
                    
                    <!-- Stats -->
                    <div class="grid grid-cols-2 gap-4 mt-8">
                        <div class="bg-gray-50 p-4 rounded-lg text-center hover:shadow-md transition-shadow">
                            <div class="text-3xl font-bold text-primary">12+</div>
                            <div class="text-sm text-gray-600">Años de experiencia</div>
                        </div>
                        <div class="bg-gray-50 p-4 rounded-lg text-center hover:shadow-md transition-shadow">
                            <div class="text-3xl font-bold text-secondary">2019</div>
                            <div class="text-sm text-gray-600">Fundación</div>
                        </div>
                    </div>
                </div>
                
                <!-- Image with hover effect -->
                <div class="relative" data-aos="fade-left" data-aos-duration="800" data-aos-delay="200">
                    <div class="relative overflow-hidden rounded-xl shadow-2xl hover:shadow-xl transition-all duration-500 transform hover:-translate-y-2">
                        <img src="{{ asset('images/about/team.jpg') }}" 
                             alt="Equipo Intereléctricos A&F" 
                             class="w-full h-auto object-cover transition-transform duration-700 hover:scale-105"
                             onerror="this.src='{{ asset('images/placeholder-about.png') }}'"
                        >
                        <div class="absolute inset-0 bg-gradient-to-t from-black/60 to-transparent opacity-0 hover:opacity-100 transition-opacity duration-500 flex items-end p-6">
                            <div class="text-white">
                                <h4 class="text-xl font-semibold">Nuestro Equipo</h4>
                                <p class="text-sm opacity-90">Trabajando juntos por su satisfacción</p>
                            </div>
                        </div>
                    </div>
                    <!-- Decorative element -->
                    <div class="absolute -bottom-6 -right-6 w-24 h-24 bg-primary/10 rounded-full -z-10"></div>
                </div>
            </div>

            <!-- Purpose card with animation -->
            <div class="mt-16 bg-gradient-to-r from-primary/5 to-secondary/5 p-8 rounded-2xl border border-gray-100 shadow-sm hover:shadow-md transition-all duration-500 transform hover:-translate-y-1" 
                 data-aos="zoom-in" 
                 data-aos-delay="200">
                <div class="max-w-4xl mx-auto text-center">
                    <div class="w-16 h-16 bg-gradient-to-r from-primary to-secondary rounded-2xl flex items-center justify-center mx-auto mb-6 shadow-lg">
                        <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                        </svg>
                    </div>
                    <h3 class="text-2xl font-bold text-dark-text mb-4">Nuestro Propósito</h3>
                    <p class="text-gray-700 leading-relaxed text-lg">
                        <span class="font-medium text-dark-text">Intereléctricos A&F</span> nace para ser un almacén que se destaque con productos innovadores, excelente servicio, 
                        y que cree confianza en los clientes por su honestidad, garantía y sus instalaciones agradables.
                    </p>
                </div>
            </div>
        </div>
        
        <!-- Bottom wave divider -->
        <div class="wave-divider -mt-1">
            <svg viewBox="0 0 1200 120" preserveAspectRatio="none" class="fill-current text-gray-50">
                <path d="M321.39,56.44c58-10.79,114.16-30.13,172-41.86,82.39-16.72,168.19-17.73,250.45-.39C823.78,31,906.67,72,985.66,92.83c70.05,18.48,146.53,26.09,214.34,3V0H0V27.35A600.21,600.21,0,0,0,321.39,56.44Z"></path>
            </svg>
        </div>
                    </svg>
                </div>
            </div>
        </section>

        {{-- 3. Sección de Misión y Visión --}}
        <section id="mision-vision" class="relative py-16 bg-gray-50 overflow-hidden">
            <!-- Background pattern -->
            <div class="absolute inset-0 opacity-5">
                <div class="absolute inset-0 bg-[url('data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iNDAiIGhlaWdodD0iNDAiIHZpZXdCb3g9IjAgMCA0MCA0MCIgeG1sbnM9Imh0dHA6Ly93d3cudzMub3JnLzIwMDAvc3ZnIj48ZyBmaWxsPSJub25lIiBmaWxsLXJ1bGU9ImV2ZW5vZGQiPjxnIGZpbGw9IiMxMjEyMTIiIGZpbGwtb3BhY2l0eT0iMC4xIj48Y2lyY2xlIGN4PSIyMCIgY3k9IjIwIiByPSIxIi8+PC9nPjwvZz48L3N2Zz4=')]"></div>
            </div>
            
            <!-- Floating elements -->
            <div class="absolute -top-20 left-1/4 w-40 h-40 bg-primary/5 rounded-full blur-3xl"></div>
            <div class="absolute bottom-0 right-20 w-60 h-60 bg-secondary/5 rounded-full blur-3xl"></div>
            
            <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <!-- Section header -->
                <div class="text-center max-w-3xl mx-auto mb-16" data-aos="fade-up">
                    <h2 class="text-4xl md:text-5xl font-bold text-dark-text mb-4">Nuestro <span class="gradient-text">Propósito</span></h2>
                    <div class="w-24 h-1.5 bg-gradient-to-r from-primary to-secondary mx-auto mb-6"></div>
                    <p class="text-gray-600 text-lg">Guiados por nuestra misión y visión, trabajamos cada día para superar las expectativas de nuestros clientes.</p>
                </div>
                
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-12">
                    <!-- Misión -->
                    <div class="relative group" data-aos="fade-right" data-aos-delay="100">
                        <div class="absolute -inset-0.5 bg-gradient-to-r from-primary to-secondary rounded-2xl opacity-0 group-hover:opacity-75 blur transition duration-500 group-hover:duration-200"></div>
                        <div class="relative bg-white p-8 rounded-2xl h-full border border-gray-100 shadow-sm hover:shadow-lg transition-all duration-500 transform hover:-translate-y-2">
                            <div class="text-center mb-6">
                                <div class="inline-flex items-center justify-center h-16 w-16 rounded-2xl bg-gradient-to-br from-primary/10 to-primary/5 text-primary mb-6 transition-transform duration-500 group-hover:scale-110">
                                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                                    </svg>
                                </div>
                                <h3 class="text-2xl font-bold text-dark-text mb-4">Misión</h3>
                            </div>
                            <div class="relative">
                                <div class="absolute -left-4 top-0 h-full w-1 bg-gradient-to-b from-primary to-secondary rounded-full opacity-0 group-hover:opacity-100 transition-opacity duration-500"></div>
                                <p class="text-gray-600 leading-relaxed pl-6">
                                    Proporcionar y desarrollar soluciones a las necesidades de iluminación del sector residencial proveyéndoles productos de calidad e innovadores, que nos permitan crecer para ayudar en el desarrollo económico de la ciudad y de la comunidad.
                                </p>
                            </div>
                            <div class="mt-6 flex justify-center">
                                <span class="inline-flex items-center text-sm font-medium text-primary">
                                    Nuestro compromiso
                                    <svg class="ml-1 w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path>
                                    </svg>
                                </span>
                            </div>
                        </div>
                    </div>

                    <!-- Visión -->
                    <div class="relative group" data-aos="fade-left" data-aos-delay="200">
                        <div class="absolute -inset-0.5 bg-gradient-to-r from-secondary to-accent rounded-2xl opacity-0 group-hover:opacity-75 blur transition duration-500 group-hover:duration-200"></div>
                        <div class="relative bg-white p-8 rounded-2xl h-full border border-gray-100 shadow-sm hover:shadow-lg transition-all duration-500 transform hover:-translate-y-2">
                            <div class="text-center mb-6">
                                <div class="inline-flex items-center justify-center h-16 w-16 rounded-2xl bg-gradient-to-br from-secondary/10 to-secondary/5 text-secondary mb-6 transition-transform duration-500 group-hover:scale-110">
                                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                    </svg>
                                </div>
                                <h3 class="text-2xl font-bold text-dark-text mb-4">Visión</h3>
                            </div>
                            <div class="relative">
                                <div class="absolute -left-4 top-0 h-full w-1 bg-gradient-to-b from-secondary to-accent rounded-full opacity-0 group-hover:opacity-100 transition-opacity duration-500"></div>
                                <p class="text-gray-600 leading-relaxed pl-6">
                                    Para el 2027 seremos la empresa líder en innovación de iluminación para el sector residencial, reconocida a nivel metropolitano por un servicio de calidad, competencia de talento humano, solidez y desarrollo.
                                </p>
                            </div>
                            <div class="mt-6 flex justify-center">
                                <span class="inline-flex items-center text-sm font-medium text-secondary">
                                    Nuestro horizonte
                                    <svg class="ml-1 w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path>
                                    </svg>
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Stats -->
                <div class="mt-16 grid grid-cols-1 md:grid-cols-3 gap-6" data-aos="fade-up" data-aos-delay="100">
                    <div class="bg-white p-6 rounded-2xl border border-gray-100 shadow-sm hover:shadow-md transition-all duration-300 transform hover:-translate-y-1">
                        <div class="text-4xl font-bold text-primary mb-2">+500</div>
                        <div class="text-gray-600">Clientes satisfechos</div>
                    </div>
                    <div class="bg-white p-6 rounded-2xl border border-gray-100 shadow-sm hover:shadow-md transition-all duration-300 transform hover:-translate-y-1">
                        <div class="text-4xl font-bold text-secondary mb-2">+1000</div>
                        <div class="text-gray-600">Productos en catálogo</div>
                    </div>
                    <div class="bg-white p-6 rounded-2xl border border-gray-100 shadow-sm hover:shadow-md transition-all duration-300 transform hover:-translate-y-1">
                        <div class="text-4xl font-bold text-accent mb-2">12+</div>
                        <div class="text-gray-600">Años de experiencia</div>
                    </div>
                </div>
            </div>
        </section>

        {{-- 4. Sección de Valores Corporativos --}}
        <section id="valores" class="relative py-16 bg-gradient-to-b from-gray-50 to-white overflow-hidden">
            <!-- Background elements -->
            <div class="absolute top-0 left-0 w-full h-full opacity-10">
                <div class="absolute inset-0 bg-[url('data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iNDAiIGhlaWdodD0iNDAiIHZpZXdCb3g9IjAgMCA0MCA0MCIgeG1sbnM9Imh0dHA6Ly93d3cudzMub3JnLzIwMDAvc3ZnIj48ZyBmaWxsPSJub25lIiBmaWxsLXJ1bGU9ImV2ZW5vZGQiPjxnIGZpbGw9IiMxMjEyMTIiIGZpbGwtb3BhY2l0eT0iMC4xIj48Y2lyY2xlIGN4PSIyMCIgY3k9IjIwIiByPSIxIi8+PC9nPjwvZz48L3N2Zz4=')]"></div>
            </div>
            <div class="absolute -top-20 -right-20 w-64 h-64 bg-primary/5 rounded-full blur-3xl"></div>
            <div class="absolute bottom-0 left-0 w-full h-32 bg-gradient-to-t from-white to-transparent z-10"></div>
            
            <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <!-- Section header -->
                <div class="text-center max-w-4xl mx-auto mb-20" data-aos="fade-up">
                    <span class="inline-block mb-4 text-sm font-semibold text-primary tracking-wider uppercase">Nuestra Esencia</span>
                    <h2 class="text-4xl md:text-5xl font-bold text-dark-text mb-6">Valores <span class="gradient-text">Corporativos</span></h2>
                    <div class="w-24 h-1.5 bg-gradient-to-r from-primary to-secondary mx-auto mb-8"></div>
                    <p class="text-gray-600 text-lg">
                        En Intereléctricos A&F nos guiamos por principios inquebrantables que definen nuestra identidad y forma de relacionarnos con nuestros clientes y colaboradores.
                    </p>
                </div>

                <!-- Values grid -->
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                    <!-- Respeto -->
                    <div class="group relative" data-aos="fade-up" data-aos-delay="100">
                        <div class="absolute -inset-0.5 bg-gradient-to-r from-primary to-secondary rounded-2xl opacity-0 group-hover:opacity-75 blur transition duration-500 group-hover:duration-200"></div>
                        <div class="relative h-full bg-white p-8 rounded-2xl border border-gray-100 shadow-sm hover:shadow-lg transition-all duration-300 hover:-translate-y-2">
                            <div class="flex items-center mb-6">
                                <div class="flex items-center justify-center h-14 w-14 rounded-2xl bg-gradient-to-br from-primary/10 to-primary/5 text-primary mr-5 transition-transform duration-500 group-hover:scale-110">
                                    <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.828 14.828a4 4 0 01-5.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                </div>
                                <h3 class="text-2xl font-bold text-dark-text">Respeto</h3>
                            </div>
                            <p class="text-gray-600 leading-relaxed">
                                Valoramos las diferencias individuales y fomentamos un ambiente de trabajo en equipo, donde cada miembro se siente valorado y respetado. Creemos en la igualdad de oportunidades y en el trato justo para todos.
                            </p>
                            <div class="mt-6 pt-4 border-t border-gray-100">
                                <span class="inline-flex items-center text-sm font-medium text-primary">
                                    Más sobre respeto
                                    <svg class="ml-1 w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                                    </svg>
                                </span>
                            </div>
                        </div>
                    </div>

                    <!-- Honestidad -->
                    <div class="group relative" data-aos="fade-up" data-aos-delay="150">
                        <div class="absolute -inset-0.5 bg-gradient-to-r from-secondary to-accent rounded-2xl opacity-0 group-hover:opacity-75 blur transition duration-500 group-hover:duration-200"></div>
                        <div class="relative h-full bg-white p-8 rounded-2xl border border-gray-100 shadow-sm hover:shadow-lg transition-all duration-300 hover:-translate-y-2">
                            <div class="flex items-center mb-6">
                                <div class="flex items-center justify-center h-14 w-14 rounded-2xl bg-gradient-to-br from-secondary/10 to-secondary/5 text-secondary mr-5 transition-transform duration-500 group-hover:scale-110">
                                    <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path>
                                    </svg>
                                </div>
                                <h3 class="text-2xl font-bold text-dark-text">Honestidad</h3>
                            </div>
                            <p class="text-gray-600 leading-relaxed">
                                Actuamos con integridad en todas nuestras relaciones comerciales, siendo transparentes en nuestras acciones y decisiones. Mantenemos nuestras promesas y asumimos la responsabilidad de nuestros actos.
                            </p>
                            <div class="mt-6 pt-4 border-t border-gray-100">
                                <span class="inline-flex items-center text-sm font-medium text-secondary">
                                    Nuestro compromiso
                                    <svg class="ml-1 w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                                    </svg>
                                </span>
                            </div>
                        </div>
                    </div>

                    <!-- Servicio -->
                    <div class="group relative" data-aos="fade-up" data-aos-delay="200">
                        <div class="absolute -inset-0.5 bg-gradient-to-r from-accent to-primary rounded-2xl opacity-0 group-hover:opacity-75 blur transition duration-500 group-hover:duration-200"></div>
                        <div class="relative h-full bg-white p-8 rounded-2xl border border-gray-100 shadow-sm hover:shadow-lg transition-all duration-300 hover:-translate-y-2">
                            <div class="flex items-center mb-6">
                                <div class="flex items-center justify-center h-14 w-14 rounded-2xl bg-gradient-to-br from-accent/10 to-accent/5 text-accent mr-5 transition-transform duration-500 group-hover:scale-110">
                                    <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"></path>
                                    </svg>
                                </div>
                                <h3 class="text-2xl font-bold text-dark-text">Servicio</h3>
                            </div>
                            <p class="text-gray-600 leading-relaxed">
                                Nos esforzamos por superar las expectativas de nuestros clientes, ofreciendo soluciones personalizadas y un soporte excepcional. Estamos comprometidos con la satisfacción total del cliente en cada interacción.
                            </p>
                            <div class="mt-6 pt-4 border-t border-gray-100">
                                <span class="inline-flex items-center text-sm font-medium text-accent">
                                    Nuestro enfoque
                                    <svg class="ml-1 w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                                    </svg>
                                </span>
                            </div>
                        </div>
                    </div>

                    <!-- Transparencia -->
                    <div class="group relative" data-aos="fade-up" data-aos-delay="100">
                        <div class="absolute -inset-0.5 bg-gradient-to-r from-primary/80 to-secondary/80 rounded-2xl opacity-0 group-hover:opacity-75 blur transition duration-500 group-hover:duration-200"></div>
                        <div class="relative h-full bg-white p-8 rounded-2xl border border-gray-100 shadow-sm hover:shadow-lg transition-all duration-300 hover:-translate-y-2">
                            <div class="flex items-center mb-6">
                                <div class="flex items-center justify-center h-14 w-14 rounded-2xl bg-gradient-to-br from-primary/10 to-primary/5 text-primary mr-5 transition-transform duration-500 group-hover:scale-110">
                                    <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                                    </svg>
                                </div>
                                <h3 class="text-2xl font-bold text-dark-text">Transparencia</h3>
                            </div>
                            <p class="text-gray-600 leading-relaxed">
                                Mantenemos una comunicación clara y abierta con todos nuestros grupos de interés, compartiendo información relevante de manera oportuna y veraz. Fomentamos la confianza a través de nuestras acciones.
                            </p>
                            <div class="mt-6 pt-4 border-t border-gray-100">
                                <span class="inline-flex items-center text-sm font-medium text-primary">
                                    Nuestro compromiso
                                    <svg class="ml-1 w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                                    </svg>
                                </span>
                            </div>
                        </div>
                    </div>

                    <!-- Calidad -->
                    <div class="group relative md:col-span-2 lg:col-span-1" data-aos="fade-up" data-aos-delay="150">
                        <div class="absolute -inset-0.5 bg-gradient-to-r from-secondary to-accent rounded-2xl opacity-0 group-hover:opacity-75 blur transition duration-500 group-hover:duration-200"></div>
                        <div class="relative h-full bg-white p-8 rounded-2xl border border-gray-100 shadow-sm hover:shadow-lg transition-all duration-300 hover:-translate-y-2">
                            <div class="flex items-center mb-6">
                                <div class="flex items-center justify-center h-14 w-14 rounded-2xl bg-gradient-to-br from-secondary/10 to-secondary/5 text-secondary mr-5 transition-transform duration-500 group-hover:scale-110">
                                    <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z"></path>
                                    </svg>
                                </div>
                                <h3 class="text-2xl font-bold text-dark-text">Calidad</h3>
                            </div>
                            <p class="text-gray-600 leading-relaxed">
                                Nos esforzamos por ofrecer productos y servicios de la más alta calidad, cumpliendo con los más altos estándares del sector. La mejora continua es parte fundamental de nuestra cultura organizacional.
                            </p>
                            <div class="mt-6 pt-4 border-t border-gray-100">
                                <span class="inline-flex items-center text-sm font-medium text-secondary">
                                    Nuestro estándar
                                    <svg class="ml-1 w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                                    </svg>
                                </span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- CTA -->
                <div class="mt-12 sm:mt-16 text-center px-4" data-aos="fade-up" data-aos-delay="100">
                    <h3 class="text-xl sm:text-2xl font-bold text-dark-text mb-4 sm:mb-6">¿Listo para experimentar la diferencia Intereléctricos A&F?</h3>
                    <a href="{{ route('contact') }}" class="inline-flex items-center px-6 sm:px-8 py-3 sm:py-4 bg-gradient-to-r from-primary to-secondary text-white text-sm sm:text-base font-semibold rounded-full hover:shadow-lg hover:shadow-primary/30 transition-all duration-300 transform hover:-translate-y-1">
                        Contáctanos hoy
                        <svg class="w-4 h-4 sm:w-5 sm:h-5 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path>
                        </svg>
                    </a>
                </div>
            </div>
        </section>

        {{-- 4. Llamada a la Acción (CTA) --}}
        <section class="bg-secondary -mt-2">
            <div class="max-w-4xl mx-auto text-center py-12 sm:py-16 px-4 sm:px-6 lg:px-8">
                <h2 class="text-2xl sm:text-3xl font-extrabold text-white">
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

    @push('scripts')
    <!-- AOS Animation Library -->
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <script>
        // Initialize AOS
        document.addEventListener('DOMContentLoaded', function() {
            AOS.init({
                duration: 800,
                easing: 'ease-in-out',
                once: true,
                mirror: false,
                offset: 20
            });
            
            // Smooth scrolling for anchor links
            document.querySelectorAll('a[href^="#"]').forEach(anchor => {
                anchor.addEventListener('click', function (e) {
                    e.preventDefault();
                    const target = document.querySelector(this.getAttribute('href'));
                    if (target) {
                        target.scrollIntoView({
                            behavior: 'smooth',
                            block: 'start'
                        });
                    }
                });
            });
        });
    </script>
    @endpush
