<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    @include('layouts.partials.seo')

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Jost:ital,wght@0,100..900;1,100..900&family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&display=swap" rel="stylesheet">
    <link rel="icon" href="{{ asset('favicon.ico') }}" type="image/x-icon">

    @vite(['resources/sass/main.scss', 'resources/js/app.js'])

    @stack('jsonld')
</head>

<body class="font-sans antialiased">

    <div class="min-h-screen flex flex-col">

        @include('components.top-banner')

        @include('layouts.navigation')

        @isset($header)
            <header class="bg-white shadow">
                <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                    {{ $header }}
                </div>
            </header>
        @endisset

        <main class="flex-grow">
            {{ $slot ?? '' }}
        </main>

        <x-footer />

    </div>

    <div x-data="{ showBtn: false }" x-init="window.addEventListener('scroll', () => { showBtn = window.scrollY > 100; })" style="display: contents;">
        <div x-show="showBtn" x-transition style="display: none;" class="fixed right-6 bottom-28 z-50">
            <button @click="window.scrollTo({top: 0, behavior: 'smooth'})"
                class="bg-secondary hover:bg-gray-800 text-white rounded-full shadow-lg flex items-center justify-center w-12 h-12 transition duration-300 focus:outline-none">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M5 15l7-7 7 7" />
                </svg>
            </button>
        </div>
    </div>

    <a href="https://wa.me/573203030595?text=Hola%2C%20estoy%20interesado%20en%20sus%20productos." target="_blank"
        rel="noopener noreferrer"
        class="fixed bottom-6 right-6 z-50 bg-green-500 text-white p-4 rounded-full shadow-lg hover:bg-green-600 transition-transform transform hover:scale-110"
        aria-label="Contactar por WhatsApp">
        <svg class="w-8 h-8" fill="currentColor" viewBox="0 0 16 16" xmlns="http://www.w3.org/2000/svg">
            <path
                d="M13.601 2.326A7.85 7.85 0 0 0 7.994 0C3.627 0 .068 3.558.064 7.926c0 1.399.366 2.76 1.057 3.965L0 16l4.204-1.102a7.93 7.93 0 0 0 3.79.965h.004c4.358 0 7.92-3.558 7.924-7.926a7.92-7.92 0 0 0-2.323-5.606zm-5.607 12.195a6.57 6.57 0 0 1-3.356-.92l-.24-.144-2.494.654.666-2.433-.156-.251a6.56 6.56 0 0 1-1.007-3.505c0-3.626 2.957-6.584 6.591-6.584a6.56 6.56 0 0 1 4.66 1.931 6.56 6.56 0 0 1 1.928 4.66c-.004 3.639-2.961 6.592-6.592 6.592zm3.615-4.934c-.197-.099-1.17-.578-1.353-.646-.182-.065-.315-.099-.445.099-.133.197-.513.646-.627.775-.114.133-.232.148-.43.05-.197-.1-.836-.308-1.592-.985-.59-.525-.985-1.175-1.103-1.372-.114-.198-.011-.304.088-.403.087-.088.197-.232.296-.346.1-.114.133-.198.198-.33.065-.134.034-.248-.015-.347-.05-.099-.445-1.076-.612-1.47-.16-.389-.323-.335-.445-.34-.114-.007-.247-.007-.38-.007a.73.73 0 0 0-.529.247c-.182.198-.691.677-.691 1.654 0 .977.71 1.916.81 2.049.098.133 1.394 2.132 3.383 2.992.47.205.84.326 1.129.418.475.152.904.129 1.246.08.38-.058 1.171-.48 1.338-.943.164-.464.164-.86.114-.943-.049-.084-.182-.133-.38-.232z" />
        </svg>
    </a>

    {{-- CAMBIO AQUÍ: Se eliminó style="display: none;" --}}
    <div x-data="{ showCookieBanner: localStorage.getItem('cookieAccepted') === null }" x-show="showCookieBanner" x-transition:enter="transition ease-out duration-300"
        x-transition:enter-start="opacity-0 transform translate-y-full"
        x-transition:enter-end="opacity-100 transform translate-y-0"
        x-transition:leave="transition ease-in duration-200"
        x-transition:leave-start="opacity-100 transform translate-y-0"
        x-transition:leave-end="opacity-0 transform translate-y-full"
        class="fixed bottom-0 left-0 w-full bg-gray-900 text-white p-4 z-50 flex flex-col md:flex-row items-center justify-between gap-4 shadow-lg">
        <p class="text-sm text-center md:text-left">
            Usamos cookies para mejorar tu experiencia y cumplir la <b>Ley 1581 de 2012</b> y <b>Decreto 1377 de
                2013</b> de Colombia. Consulta nuestra <a href="{{ url('/terminos') }}"
                class="underline hover:text-primary">Política de Cookies</a>.
        </p>
        <div class="flex-shrink-0 flex gap-3">
            <button @click="localStorage.setItem('cookieAccepted', '1'); showCookieBanner = false"
                class="bg-primary hover:bg-yellow-500 text-dark-text font-bold py-2 px-4 rounded-full transition-colors">
                Aceptar
            </button>
            <button @click="localStorage.setItem('cookieAccepted', '0'); showCookieBanner = false"
                class="bg-gray-700 hover:bg-gray-600 text-white font-bold py-2 px-4 rounded-full transition-colors">
                Rechazar
            </button>
        </div>
    </div>

    {{-- Script para inicializar la store de Alpine, si se necesita globalmente --}}
    <script>
        document.addEventListener('alpine:init', () => {
            if (!Alpine.store('scrollBtn')) {
                Alpine.store('scrollBtn', {
                    visible: false
                });
            }
        });
    </script>
    @stack('scripts')

</body>

</html>