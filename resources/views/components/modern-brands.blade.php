@props(['brands'])

<style>
    @keyframes gradient-shift {
        0% { background-position: 0% 50%; }
        50% { background-position: 100% 50%; }
        100% { background-position: 0% 50%; }
    }
    
    .brand-text {
        display: inline-block;
        background-clip: text;
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-size: 200% 200%;
        animation: gradient-shift 8s ease infinite;
        color: #000; /* Color de respaldo */
    }
    
    /* Asegurar que el texto sea visible en todos los navegadores */
    @supports not (-webkit-background-clip: text) {
        .brand-text {
            background: none;
            color: #3B82F6; /* Color sólido si no hay soporte para gradiente */
            -webkit-text-fill-color: initial;
        }
    }
</style>

<div class="w-full max-w-7xl mx-auto py-12 px-4">
    <div class="text-center mb-8">
        <h2 class="text-3xl font-bold text-gray-900 sm:text-4xl">Nuestras Marcas</h2>
        <p class="mt-3 text-xl text-gray-500">Descubre la calidad de nuestras marcas seleccionadas</p>
    </div>
    
    <div class="relative overflow-hidden">
        <!-- Efecto de gradiente en los bordes -->
        <div class="absolute inset-y-0 left-0 w-24 bg-gradient-to-r from-white to-transparent z-10"></div>
        <div class="absolute inset-y-0 right-0 w-24 bg-gradient-to-l from-white to-transparent z-10"></div>
        
        <div x-data="{
            brands: @js($brands),
            scrollSpeed: 0.3,
            animationId: null,
            scrollPosition: 0,
            container: null,
            content: null,
            
            getGradient(brand) {
                const gradients = {
                    'MERCURY': 'linear-gradient(90deg, #3B82F6 0%, #06B6D4 100%)',
                    'TITANIUM': 'linear-gradient(90deg, #8B5CF6 0%, #EC4899 100%)',
                    'ZAFIRO': 'linear-gradient(90deg, #2563EB 0%, #6366F1 100%)',
                    'ILUMAX': 'linear-gradient(90deg, #F59E0B 0%, #FCD34D 100%)',
                    'ECOLITE': 'linear-gradient(90deg, #10B981 0%, #6EE7B7 100%)',
                    'EXCELITE': 'linear-gradient(90deg, #F43F5E 0%, #F9A8D4 100%)',
                    'INTERLED': 'linear-gradient(90deg, #4F46E5 0%, #60A5FA 100%)',
                    'DEXON': 'linear-gradient(90deg, #EF4444 0%, #F97316 100%)',
                    'BRIOLIGH': 'linear-gradient(90deg, #EC4899 0%, #F43F5E 100%)',
                    'ROYAL': 'linear-gradient(90deg, #7C3AED 0%, #4F46E5 100%)',
                    'LUMEK': 'linear-gradient(90deg, #06B6D4 0%, #3B82F6 100%)',
                    'DIXTON': 'linear-gradient(90deg, #D97706 0%, #F59E0B 100%)',
                    'BAYTER': 'linear-gradient(90deg, #10B981 0%, #2DD4BF 100%)',
                    'SPARKLED': 'linear-gradient(90deg, #D946EF 0%, #EC4899 100%)',
                    'KARLUX': 'linear-gradient(90deg, #7C3AED 0%, #8B5CF6 100%)',
                    'FELGOLUX': 'linear-gradient(90deg, #EC4899 0%, #F43F5E 100%)',
                    'NEW LIGHT': 'linear-gradient(90deg, #0EA5E9 0%, #3B82F6 100%)',
                    'DIGITAL LIGHT': 'linear-gradient(90deg, #3B82F6 0%, #4F46E5 100%)',
                    'SICOLUX': 'linear-gradient(90deg, #10B981 0%, #2DD4BF 100%)',
                    'ACRILED': 'linear-gradient(90deg, #06B6D4 0%, #3B82F6 100%)',
                    'MARWA': 'linear-gradient(90deg, #F43F5E 0%, #F59E0B 100%)',
                };
                return gradients[brand] || 'linear-gradient(90deg, #3B82F6 0%, #8B5CF6 100%)';
            },
            
            init() {
                this.container = this.$refs.container;
                this.content = this.$refs.content;
                this.startScrolling();
                
                // Pausar al hacer hover
                this.$refs.content.addEventListener('mouseenter', () => {
                    cancelAnimationFrame(this.animationId);
                });
                
                // Reanudar al salir
                this.$refs.content.addEventListener('mouseleave', () => {
                    this.startScrolling();
                });
            },
            
            startScrolling() {
                const scroll = () => {
                    this.scrollPosition += this.scrollSpeed;
                    
                    // Reiniciar la posición cuando se desplace completamente
                    if (this.scrollPosition >= this.content.offsetWidth / 2) {
                        this.scrollPosition = 0;
                    }
                    
                    this.content.style.transform = `translateX(-${this.scrollPosition}px)`;
                    this.animationId = requestAnimationFrame(scroll);
                };
                
                this.animationId = requestAnimationFrame(scroll);
            },
            
            // Limpiar al desmontar
            destroy() {
                if (this.animationId) {
                    cancelAnimationFrame(this.animationId);
                }
            }
        }" x-init="init()" x-on:destroy.window="destroy()" class="relative">
            <div class="relative overflow-hidden">
                <div x-ref="container" class="overflow-hidden">
                    <div x-ref="content" class="flex items-center space-x-12 py-4" style="width: max-content;">
                        <template x-for="(brandGroup, index) in [brands, brands]" :key="'group-' + index">
                            <div class="flex items-center space-x-12">
                                <template x-for="brand in brandGroup" :key="brand">
                                    <div class="relative group">
                                        <div class="relative
                                            text-3xl md:text-4xl font-bold 
                                            transform transition-all duration-700
                                            group-hover:scale-110 group-hover:rotate-1
                                            filter group-hover:brightness-110
                                            whitespace-nowrap
                                            px-4 py-2 rounded-lg
                                            [text-shadow:_0_2px_8px_rgba(0,0,0,0.15)]
                                            group-hover:[text-shadow:_0_4px_12px_rgba(0,0,0,0.25)]
                                            transition-all duration-500 ease-out"
                                            "
                                        >
                                            <div class="flex space-x-8">
                                                <template x-for="(brand, index) in brands" :key="index">
                                                    <div class="relative group">
                                                        <span class="brand-text text-3xl md:text-4xl font-bold px-4 py-2"
                                                            :style="'background-image: ' + getGradient(brand)">
                                                            <span x-text="brand"></span>
                                                        </span>
                                                    </div>
                                                </template>
                                            </div>
                                            <div class="absolute inset-0 bg-white/10 rounded-lg -z-10 
                                                    group-hover:bg-white/20 transition-all duration-300"></div>
                                        </div>
                                    </div>
                                </template>
                            </div>
                        </template>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Efecto de partículas decorativas -->
    <!-- <div class="mt-12 grid grid-cols-2 gap-8 md:grid-cols-4 lg:grid-cols-8">
        <div class="h-1 bg-gradient-to-r from-blue-400 to-blue-200 rounded-full opacity-30"></div>
        <div class="h-1 bg-gradient-to-r from-purple-400 to-purple-200 rounded-full opacity-30"></div>
        <div class="h-1 bg-gradient-to-r from-pink-400 to-pink-200 rounded-full opacity-30"></div>
        <div class="h-1 bg-gradient-to-r from-blue-400 to-blue-200 rounded-full opacity-30 md:col-start-2"></div>
        <div class="h-1 bg-gradient-to-r from-purple-400 to-purple-200 rounded-full opacity-30"></div>
        <div class="h-1 bg-gradient-to-r from-pink-400 to-pink-200 rounded-full opacity-30"></div>
    </div>
</div> -->
