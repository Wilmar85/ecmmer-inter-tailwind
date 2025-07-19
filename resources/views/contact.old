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
                                <div class="flex items-start">
                                    <span class="text-primary mt-1"><svg class="h-6 w-6" fill="none"
                                            stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z">
                                            </path>
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                        </svg></span>
                                    <div class="ml-3">
                                        <p class="font-semibold text-gray-800">Dirección</p>
                                        <p class="text-gray-600">Cra 17 No. 42-05 Centro, Bucaramanga, Santander</p>
                                    </div>
                                </div>
                                <div class="flex items-start">
                                    <span class="text-primary mt-1"><svg class="h-6 w-6" fill="none"
                                            stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z">
                                            </path>
                                        </svg></span>
                                    <div class="ml-3">
                                        <p class="font-semibold text-gray-800">Teléfono / WhatsApp</p>
                                        @php
                                            $whatsappNumber = $user->whatsapp_number ?? '+57 123 456 7890';
                                            $cleanNumber = preg_replace('/[^0-9+]/', '', $whatsappNumber);
                                        @endphp
                                        <a href="https://wa.me/{{ $cleanNumber }}" target="_blank" class="text-gray-600 hover:text-primary">
                                            {{ $whatsappNumber }}
                                        </a>
                                    </div>
                                </div>
                                <div class="flex items-start">
                                    <span class="text-primary mt-1"><svg class="h-6 w-6" fill="none"
                                            stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z">
                                            </path>
                                        </svg></span>
                                    <div class="ml-3">
                                        <p class="font-semibold text-gray-800">Email de Contacto</p>
                                        @php
                                            $email = $user->customer_service_email ?? 'interelectricosaf@gmail.com';
                                        @endphp
                                        <a href="mailto:{{ $email }}" class="text-gray-600 hover:text-primary">{{ $email }}</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="lg:col-span-2">
                        <div class="bg-white p-8 rounded-lg shadow-lg">
                            <h2 class="text-2xl font-bold text-dark-text mb-6">Envíanos un Mensaje</h2>
                            <form action="#" method="POST" class="space-y-6">
                                @csrf
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                    <div>
                                        <label for="name" class="block text-sm font-medium text-gray-700">Nombre</label>
                                        <input type="text" name="name" id="name" required
                                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-primary focus:ring-primary">
                                    </div>
                                    <div>
                                        <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
                                        <input id="email" name="email" type="email" required
                                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-primary focus:ring-primary">
                                    </div>
                                </div>
                                <div>
                                    <label for="subject" class="block text-sm font-medium text-gray-700">Asunto</label>
                                    <input type="text" name="subject" id="subject" required
                                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-primary focus:ring-primary">
                                </div>
                                <div>
                                    <label for="message" class="block text-sm font-medium text-gray-700">Tu Mensaje</label>
                                    <textarea id="message" name="message" rows="5" required
                                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-primary focus:ring-primary"></textarea>
                                </div>
                                <div class="text-right">
                                    <button type="submit"
                                        class="w-full sm:w-auto text-center px-8 py-3 bg-primary border-2 border-primary rounded-full font-semibold text-base text-dark-text uppercase tracking-widest hover:bg-yellow-500 transition-all duration-300">
                                        Enviar
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <section class="w-full h-[400px] bg-gray-200">
            {{-- CAMBIO AQUÍ: Se ha insertado tu iframe --}}
            <iframe
                src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3541.5277702145113!2d-73.12586299002444!3d7.1158221159684!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x8e683fd0a9c11f07%3A0x6af4c8e3954f91ca!2sCra%2017%20%2342-5%2C%20Bucaramanga%2C%20Santander!5e1!3m2!1ses-419!2sco!4v1752470427166!5m2!1ses-419!2sco"
                width="100%" height="100%" style="border:0;" allowfullscreen="" loading="lazy"
                referrerpolicy="no-referrer-when-downgrade"></iframe>
        </section>

    </x-app-layout>
