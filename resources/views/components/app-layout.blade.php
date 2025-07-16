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

        @if(isset($header))
            <header class="bg-white shadow">
                <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                    {{ $header }}
                </div>
            </header>
        @endif

        <main class="flex-grow">
            {{ $slot }}
        </main>

        <x-footer />
    </div>

    <div x-data="{ showBtn: false }" x-init="window.addEventListener('scroll', () => { showBtn = window.scrollY > 100; })" style="display: contents;">
        <div x-show="showBtn" x-transition style="display: none;" class="fixed right-6 bottom-28 z-50">
            <button @click="window.scrollTo({top: 0, behavior: 'smooth'})"
                class="bg-secondary hover:bg-gray-800 text-white rounded-full shadow-lg flex items-center justify-center w-12 h-12 transition duration-300 focus:outline-none">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M5 15l7-7 7 7" />
                </svg>
            </button>
        </div>
    </div>

    @stack('modals')
    @stack('scripts')

    <!-- Cookie Consent Banner -->
    <div x-data="{ 
        showCookieBanner: true,
        init() {
            const accepted = localStorage.getItem('cookieAccepted');
            this.showCookieBanner = accepted !== 'true';
        },
        acceptCookies() {
            localStorage.setItem('cookieAccepted', 'true');
            this.showCookieBanner = false;
        }
    }" x-show="showCookieBanner" x-cloak class="fixed bottom-0 left-0 right-0 bg-gray-800 text-white p-4 z-50">
        <div class="container mx-auto flex flex-col md:flex-row items-center justify-between">
            <p class="text-sm mb-4 md:mb-0 md:mr-4">
                Utilizamos cookies propias y de terceros para mejorar nuestros servicios y mostrarle publicidad relacionada con sus preferencias mediante el análisis de sus hábitos de navegación.
            </p>
            <div class="flex space-x-4">
                <button @click="acceptCookies" class="px-4 py-2 bg-blue-600 hover:bg-blue-700 rounded text-sm font-medium transition-colors">
                    Aceptar
                </button>
                <a href="{{ route('privacy') }}" class="px-4 py-2 border border-gray-600 hover:bg-gray-700 rounded text-sm font-medium transition-colors">
                    Política de privacidad
                </a>
            </div>
        </div>
    </div>
</body>

</html>
