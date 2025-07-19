<x-app-layout>
    {{-- SEO para la Página --}}
    @section('title', 'Contacto - Estamos para Servirte')
    @section('description',
        'Ponte en contacto con nuestro equipo. Visítanos, llámanos o envíanos un mensaje a través de
        nuestro formulario. Estamos aquí para ayudarte.')

    {{-- 1. Cabecera con Video de Fondo --}}
    <section class="relative h-[50vh] flex items-center justify-center text-center text-white overflow-hidden">
        <div class="absolute top-0 left-0 w-full h-full z-0">
            <video class="w-full h-full object-cover object-top" autoplay loop muted playsinline>
                <source src="{{ asset('videos/banner-video-3.mp4') }}" type="video/mp4">
                Tu navegador no soporta videos HTML5.
            </video>
            <div class="absolute top-0 left-0 w-full h-full bg-black opacity-60"></div>
        </div>
        <div class="relative z-10 px-4">
            <h1 class="text-4xl md:text-5xl font-extrabold text-primary animate-fade-in-down">Hablemos</h1>
            <p class="mt-4 text-xl text-light-text max-w-3xl mx-auto animate-fade-in-up">
                Tu proyecto es importante para nosotros. Estamos listos para escuchar tus necesidades.
            </p>
        </div>
    </section>

    {{-- 2. Contenido Principal (Formulario e Información) --}}
    <section class="py-16 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-12">
                <div class="lg:col-span-1 space-y-8">
                    <div class="p-6 bg-gray-50 rounded-lg shadow-sm">
                        <h3 class="text-xl font-bold text-dark-text mb-4">Detalles de Contacto</h3>
                        <div class="space-y-4">
                            @if($settings->address)
                            <div class="flex items-start">
                                <span class="text-primary mt-1">
                                    <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z">
                                        </path>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M15 11a3 3 0 11-6 0 3 3 0 016 0z">
                                        </path>
                                    </svg>
                                </span>
                                <div class="ml-3">
                                    <p class="font-semibold text-gray-800">Dirección</p>
                                    <p class="text-gray-600">{{ $settings->address }}</p>
                                </div>
                            </div>
                            @endif

                            @if($settings->phone)
                            <div class="flex items-start">
                                <span class="text-primary mt-1">
                                    <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z">
                                        </path>
                                    </svg>
                                </span>
                                <div class="ml-3">
                                    <p class="font-semibold text-gray-800">Teléfono</p>
                                    <p class="text-gray-600">{{ $settings->phone }}</p>
                                </div>
                            </div>
                            @endif

                            @if($settings->whatsapp_number)
                            <div class="flex items-start">
                                <span class="text-primary mt-1">
                                    <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z">
                                        </path>
                                    </svg>
                                </span>
                                <div class="ml-3">
                                    <p class="font-semibold text-gray-800">WhatsApp</p>
                                    <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $settings->whatsapp_number) }}" 
                                       class="text-blue-600 hover:underline"
                                       target="_blank">
                                        {{ $settings->whatsapp_number }}
                                    </a>
                                </div>
                            </div>
                            @endif

                            @if($settings->customer_service_email)
                            <div class="flex items-start">
                                <span class="text-primary mt-1">
                                    <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z">
                                        </path>
                                    </svg>
                                </span>
                                <div class="ml-3">
                                    <p class="font-semibold text-gray-800">Correo Electrónico</p>
                                    <a href="mailto:{{ $settings->customer_service_email }}" class="text-blue-600 hover:underline">
                                        {{ $settings->customer_service_email }}
                                    </a>
                                </div>
                            </div>
                            @endif

                            @if($settings->business_hours)
                            <div class="flex items-start">
                                <span class="text-primary mt-1">
                                    <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                </span>
                                <div class="ml-3">
                                    <p class="font-semibold text-gray-800">Horario de Atención</p>
                                    <p class="text-gray-600">{{ $settings->business_hours }}</p>
                                </div>
                            </div>
                            @endif
                        </div>
                    </div>
                </div>

                <div class="lg:col-span-2">
                    <div class="bg-white p-8 rounded-lg shadow-lg">
                        <h2 class="text-2xl font-bold text-dark-text mb-6">Envíanos un Mensaje</h2>
                        @if(session('success'))
                            <div class="mb-4 p-4 bg-green-100 text-green-700 rounded">
                                {{ session('success') }}
                            </div>
                        @endif
                        @if(session('error'))
                            <div class="mb-4 p-4 bg-red-100 text-red-700 rounded">
                                {{ session('error') }}
                            </div>
                        @endif
                        <form action="{{ route('contact.submit') }}" method="POST" class="space-y-6">
                            @csrf
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div>
                                    <label for="name" class="block text-sm font-medium text-gray-700 mb-1">Nombre completo *</label>
                                    <input type="text" name="name" id="name" required
                                        class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-primary focus:border-transparent @error('name') border-red-500 @enderror"
                                        value="{{ old('name', $user->name ?? '') }}">
                                    @error('name')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>
                                <div>
                                    <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Correo electrónico *</label>
                                    <input type="email" name="email" id="email" required
                                        class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-primary focus:border-transparent @error('email') border-red-500 @enderror"
                                        value="{{ old('email', $user->email ?? '') }}">
                                    @error('email')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                            <div>
                                <label for="message" class="block text-sm font-medium text-gray-700 mb-1">Mensaje *</label>
                                <textarea name="message" id="message" rows="5" required
                                    class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-primary focus:border-transparent @error('message') border-red-500 @enderror">{{ old('message') }}</textarea>
                                @error('message')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                            <div class="flex items-center justify-end">
                                <button type="submit"
                                    class="px-6 py-3 bg-primary text-white font-medium rounded-md hover:bg-primary-dark transition duration-200 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary">
                                    Enviar Mensaje
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="w-full h-[400px] bg-gray-200">
        <iframe
            src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3959.4246000000003!2d-73.1193889250194!3d7.119608592920983!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x8e683f9f8bbb1b6b%3A0x5f41a1e9a4a3d6d7!2sCra.%2017%20%2342-05%2C%20Bucaramanga%2C%20Santander!5e0!3m2!1ses!2sco!4v1623456789012!5m2!1ses!2sco"
            width="100%" height="100%" style="border:0;" allowfullscreen="" loading="lazy"></iframe>
    </section>
</x-app-layout>
