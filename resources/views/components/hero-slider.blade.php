@props(['slides' => [
    [
        'type' => 'image',
        'src' => 'https://images.unsplash.com/photo-1604594842169-1ec43edfad1b?ixlib=rb-1.2.1&auto=format&fit=crop&w=1950&q=80',
        'title' => 'Materiales Eléctricos',
        'description' => 'Todo lo que necesitas para tus instalaciones eléctricas',
        'button_text' => 'Ver Catálogo',
        'button_url' => route('shop.index')
    ],
    [
        'type' => 'image',
        'src' => 'https://images.unsplash.com/photo-1556740734-7c084a70051f?ixlib=rb-1.2.1&auto=format&fit=crop&w=1950&q=80',
        'title' => 'Lámparas y Luminarias',
        'description' => 'Iluminación eficiente para cada espacio',
        'button_text' => 'Ver Luminarias',
        'button_url' => route('shop.index', ['category' => 'iluminacion'])
    ],
    [
        'type' => 'image',
        'src' => 'https://images.unsplash.com/photo-1600880292203-757bb62b4baf?ixlib=rb-1.2.1&auto=format&fit=crop&w=1950&q=80',
        'title' => 'Herramientas Profesionales',
        'description' => 'Equipos de medición y herramientas de calidad',
        'button_text' => 'Ver Herramientas',
        'button_url' => route('shop.index', ['category' => 'herramientas'])
    ]
]])

<div x-data="{
    currentSlide: 0,
    slides: @js($slides),
    autoplay: true,
    autoplayInterval: 7000,
    interval: null,

    init() {
        this.startAutoplay();
        // Pausar autoplay cuando la pestaña no está visible
        document.addEventListener('visibilitychange', () => {
            if (document.hidden) {
                this.stopAutoplay();
            } else {
                this.startAutoplay();
            }
        });
    },
    
    nextSlide() {
        this.currentSlide = (this.currentSlide + 1) % this.slides.length;
    },
    
    prevSlide() {
        this.currentSlide = (this.currentSlide - 1 + this.slides.length) % this.slides.length;
    },
    
    goToSlide(index) {
        this.currentSlide = index;
    },
    
    startAutoplay() {
        if (this.autoplay) {
            this.interval = setInterval(() => {
                this.nextSlide();
            }, this.autoplayInterval);
        }
    },
    
    stopAutoplay() {
        clearInterval(this.interval);
    },
    
    toggleAutoplay() {
        this.autoplay = !this.autoplay;
        if (this.autoplay) {
            this.startAutoplay();
        } else {
            this.stopAutoplay();
        }
    }
}" 
@mouseenter="stopAutoplay()" 
@mouseleave="if(autoplay) startAutoplay()"
class="relative h-[70vh] w-full overflow-hidden">
    <!-- Slides -->
    <div class="relative h-full w-full">
        <template x-for="(slide, index) in slides" :key="index">
            <div 
                x-show="currentSlide === index"
                x-transition:enter="transition ease-out duration-1000"
                x-transition:enter-start="opacity-0"
                x-transition:enter-end="opacity-100"
                x-transition:leave="transition ease-in duration-1000"
                x-transition:leave-start="opacity-100"
                x-transition:leave-end="opacity-0"
                class="absolute inset-0 w-full h-full"
            >
                <!-- Contenido del slide (imagen o video) -->
                <div class="absolute inset-0 w-full h-full">
                    <template x-if="slide.type === 'video'">
                        <video 
                            class="w-full h-full object-cover"
                            :poster="slide.poster || ''"
                            autoplay
                            muted
                            loop
                            playsinline
                            x-ref="video"
                        >
                            <source :src="slide.src" type="video/mp4">
                            Tu navegador no soporta videos HTML5.
                        </video>
                    </template>
                    
                    <template x-if="slide.type === 'image'">
                        <img 
                            :src="slide.src" 
                            :alt="slide.title"
                            class="w-full h-full object-cover"
                            loading="lazy"
                        >
                    </template>
                    
                    <!-- Overlay oscuro -->
                    <div class="absolute inset-0 bg-white/5 rounded-lg -z-10 group-hover:bg-white/10 transition-all duration-300"></div>
                </div>
                
                <!-- Contenido del texto -->
                <div class="relative z-10 h-full flex items-end pb-12">
                    <div class="w-full px-4 sm:px-6 lg:px-12 text-white">
                        <div class="max-w-2xl bg-black/50 p-8 rounded-lg backdrop-blur-sm border border-white/10 shadow-xl">
                            <h1 
                                x-text="slide.title"
                                class="text-2xl md:text-4xl font-bold mb-2 text-white"
                            ></h1>
                            <p 
                                x-text="slide.description"
                                class="text-sm md:text-base text-gray-200 mb-4"
                            ></p>
                            <div>
                                <a 
                                    :href="slide.button_url"
                                    class="inline-flex items-center px-5 py-2 bg-primary border-2 border-primary rounded-full font-semibold text-xs text-dark-text uppercase tracking-widest hover:bg-gray-800 hover:border-gray-800 hover:text-white transition-all duration-300"
                                >
                                    <span x-text="slide.button_text"></span>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </template>
    </div>
    
    <!-- Controles de navegación -->
    <button 
        @click="prevSlide()"
        class="absolute left-4 top-1/2 -translate-y-1/2 bg-black/50 hover:bg-black/70 text-white rounded-full p-3 focus:outline-none transition-all duration-300 z-20 backdrop-blur-sm"
        aria-label="Anterior"
    >
        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
        </svg>
    </button>
    
    <button 
        @click="nextSlide()"
        class="absolute right-4 top-1/2 -translate-y-1/2 bg-black/50 hover:bg-black/70 text-white rounded-full p-3 focus:outline-none transition-all duration-300 z-20 backdrop-blur-sm"
        aria-label="Siguiente"
    >
        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
        </svg>
    </button>
    
    <!-- Indicadores de paginación -->
    <div class="absolute bottom-6 left-1/2 -translate-x-1/2 flex space-x-2 z-20">
        <template x-for="(slide, index) in slides" :key="index">
            <button 
                @click="goToSlide(index)"
                :class="{'bg-primary': currentSlide === index, 'bg-white/50': currentSlide !== index}"
                class="w-2.5 h-2.5 rounded-full focus:outline-none transition-all duration-300 hover:bg-primary/80"
                :aria-label="'Ir a la diapositiva ' + (index + 1)"
            ></button>
        </template>
    </div>
    
    <!-- Botón de autoplay -->
    <button 
        @click="toggleAutoplay()"
        class="absolute bottom-6 right-8 bg-black/50 hover:bg-black/70 text-white rounded-full p-2 focus:outline-none transition-all duration-300 z-20 backdrop-blur-sm"
        :aria-label="autoplay ? 'Pausar presentación' : 'Reanudar presentación'"
    >
        <svg x-show="!autoplay" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.752 11.168l-3.197-2.132A1 1 0 0010 9.87v4.263a1 1 0 001.555.832l3.197-2.132a1 1 0 000-1.664z" />
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
        </svg>
        <svg x-show="autoplay" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 9v6m4-6v6m7-3a9 9 0 11-18 0 9 9 0 0118 0z" />
        </svg>
    </button>
</div>
