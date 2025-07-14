@props(['brands'])
<div class="max-w-7xl mx-auto py-12 px-4">
    <div x-data="{
        scroll: null,
        interval: null,
        startScrolling() {
            this.interval = setInterval(() => {
                this.scroll.scrollLeft += 1;
                // Reinicia el scroll para efecto infinito
                if (this.scroll.scrollLeft >= this.scroll.scrollWidth / 2) {
                    this.scroll.scrollLeft = 0;
                }
            }, 15);
        },
        stopScrolling() {
            clearInterval(this.interval);
        }
    }" x-init="scroll = $refs.slider;
    startScrolling()" @mouseenter="stopScrolling()" @mouseleave="startScrolling()"
        class="relative overflow-hidden">
        <div x-ref="slider" class="flex gap-8 items-center py-4 whitespace-nowrap overflow-x-auto scrollbar-hide"
            style="scroll-behavior: auto; scrollbar-width: none; -ms-overflow-style: none;">
            <style>
                [x-ref=slider]::-webkit-scrollbar {
                    display: none;
                }
            </style>
            @foreach (array_merge($brands, $brands) as $brand)
                <div class="flex flex-col items-center min-w-[96px]">
                    <div
                        class="w-20 h-20 flex items-center justify-center rounded-full bg-white shadow-md overflow-hidden mb-2">
                        <img src="{{ asset('images/brands/' . strtolower(str_replace(' ', '', $brand)) . '.png') }}"
                            alt="Logo {{ $brand }}"
                            class="w-full h-full object-cover rounded-full aspect-square grayscale hover:grayscale-0 transition duration-300">
                    </div>
                    <span class="text-sm font-semibold text-gray-700 text-center">{{ $brand }}</span>
                </div>
            @endforeach
        </div>
    </div>
</div>
