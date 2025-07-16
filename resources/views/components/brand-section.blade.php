@props(['brands'])
<div class="w-full max-w-7xl mx-auto py-8 px-4">
    <div x-data="{
        scroll: null,
        interval: null,
        startScrolling() {
            this.interval = setInterval(() => {
                if (this.scroll) {
                    this.scroll.scrollLeft += 1;
                    // Reinicia el scroll para efecto infinito
                    if (this.scroll.scrollLeft >= this.scroll.scrollWidth / 2) {
                        this.scroll.scrollLeft = 0;
                    }
                }
            }, 15);
        },
        stopScrolling() {
            clearInterval(this.interval);
        }
    }" x-init="scroll = $refs.slider; startScrolling()" 
    @mouseenter="stopScrolling()" 
    @mouseleave="startScrolling()"
    class="relative overflow-hidden w-full">
        <div x-ref="slider" 
            class="flex gap-6 md:gap-8 items-center py-4 whitespace-nowrap overflow-x-auto scrollbar-hide w-full"
            style="scroll-behavior: smooth; scrollbar-width: none; -ms-overflow-style: none;">
            <style>
                [x-ref=slider]::-webkit-scrollbar {
                    display: none;
                }
            </style>
            @foreach (array_merge($brands, $brands) as $brand)
                <div class="flex-shrink-0 flex flex-col items-center w-20 md:w-24">
                    <div class="w-16 h-16 md:w-20 md:h-20 flex items-center justify-center rounded-full bg-white shadow-md overflow-hidden mb-2 p-1">
                        <img 
                            src="{{ asset('images/brands/' . strtolower(str_replace(' ', '', $brand)) . '.png') }}"
                            alt="Logo {{ $brand }}"
                            class="w-full h-full object-contain rounded-full grayscale hover:grayscale-0 transition-all duration-300 transform hover:scale-105"
                            loading="lazy"
                            onerror="this.onerror=null; this.src='{{ asset('images/placeholder-brand.png') }}'"
                        >
                    </div>
                    <span class="text-xs md:text-sm font-medium text-gray-700 text-center truncate w-full px-1">{{ $brand }}</span>
                </div>
            @endforeach
        </div>
        <!-- Flechas de navegación para móviles -->
        <button @click="if(scroll) scroll.scrollLeft -= 150" class="md:hidden absolute left-2 top-1/2 -translate-y-1/2 bg-white/80 hover:bg-white text-gray-800 rounded-full p-2 shadow-md z-10 transition-all">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
            </svg>
        </button>
        <button @click="if(scroll) scroll.scrollLeft += 150" class="md:hidden absolute right-2 top-1/2 -translate-y-1/2 bg-white/80 hover:bg-white text-gray-800 rounded-full p-2 shadow-md z-10 transition-all">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
            </svg>
        </button>
    </div>
</div>
