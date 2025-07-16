<footer class="bg-secondary text-light-text">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">

            <div class="space-y-4">
                <a href="{{ route('home') }}">
                    <x-application-logo class="w-auto h-12" />
                </a>
                <p class="text-gray-400">
                Empresa Santandereana Especializada en Distribucion de Materiales Electricos, Ferreteria y Construccion
                </p>
                <div class="flex space-x-4">
                    <a href="https://www.facebook.com/people/InterelectricosAF/100064043472917/" target="_blank" rel="noopener noreferrer" class="text-gray-400 hover:text-primary transition-colors" title="Facebook">
                        <svg class="h-7 w-7" fill="currentColor" viewBox="0 0 320 512">
                            <path d="M279.14 288l14.22-92.66h-88.91v-60.13c0-25.35 12.42-50.06 52.24-50.06h40.42V6.26S260.43 0 225.36 0c-73.22 0-121.08 44.38-121.08 124.72v70.62H22.89V288h81.39v224h100.17V288z"/>
                        </svg>
                    </a>
                    <a href="https://www.instagram.com/interelectricos/?igshid=ZDdkNTZiNTM%3D" target="_blank" rel="noopener noreferrer" class="text-gray-400 hover:text-primary transition-colors" title="Instagram">
                        <svg class="h-7 w-7" fill="currentColor" viewBox="0 0 16 16">
                            <path d="M8 0C5.829 0 5.556.01 4.703.048 3.85.088 3.269.222 2.76.42a3.9 3.9 0 0 0-1.417.923A3.9 3.9 0 0 0 .42 2.76C.222 3.268.087 3.85.048 4.7.01 5.555 0 5.827 0 8.001c0 2.172.01 2.444.048 3.297.04.852.174 1.433.372 1.942.205.526.478.972.923 1.417.444.445.89.719 1.416.923.51.198 1.09.333 1.942.372C5.555 15.99 5.827 16 8 16s2.444-.01 3.298-.048c.851-.04 1.434-.174 1.943-.372a3.9 3.9 0 0 0 1.416-.923c.445-.445.718-.891.923-1.417.197-.509.332-1.09.372-1.942C15.99 10.445 16 10.173 16 8s-.01-2.445-.048-3.299c-.04-.851-.175-1.433-.372-1.941a3.9 3.9 0 0 0-.923-1.417A3.9 3.9 0 0 0 13.24.42c-.51-.198-1.092-.333-1.943-.372C10.443.01 10.172 0 7.998 0zm-.717 1.442h.718c2.136 0 2.389.007 3.232.046.78.035 1.204.166 1.486.275.373.145.64.319.92.599s.453.546.598.92c.11.281.24.705.275 1.485.039.843.047 1.096.047 3.231s-.008 2.389-.047 3.232c-.035.78-.166 1.203-.275 1.485a2.5 2.5 0 0 1-.599.919c-.28.28-.546.453-.92.598-.28.11-.704.24-1.485.276-.843.038-1.096.047-3.232.047s-2.39-.009-3.233-.047c-.78-.036-1.203-.166-1.485-.276a2.5 2.5 0 0 1-.92-.598 2.5 2.5 0 0 1-.6-.92c-.109-.281-.24-.705-.275-1.485-.038-.843-.046-1.096-.046-3.233s.008-2.388.046-3.231c.036-.78.166-1.204.276-1.486.145-.373.319-.64.599-.92s.546-.453.92-.598c.282-.11.705-.24 1.485-.276.738-.034 1.024-.044 2.515-.045zm4.988 1.328a.96.96 0 1 0 0 1.92.96.96 0 0 0 0-1.92m-4.27 1.122a4.109 4.109 0 1 0 0 8.217 4.109 4.109 0 0 0 0-8.217m0 1.441a2.667 2.667 0 1 1 0 5.334 2.667 2.667 0 0 1 0-5.334"/>
                        </svg>
                    </a>
                </div>
            </div>

            {{-- Bloque de Información --}}
            <div x-data="{ open: window.innerWidth >= 1024 }" @resize.window="open = window.innerWidth >= 1024"
                class="space-y-4 border-t border-gray-700 pt-4 md:border-none md:pt-0">
                <div @click="open = !open" class="flex justify-between items-center cursor-pointer lg:cursor-default">
                    <h4 class="text-lg font-semibold text-white">Información</h4>
                    <svg class="w-5 h-5 lg:hidden transition-transform" :class="{ 'rotate-180': open }" fill="none"
                        stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                    </svg>
                </div>
                <ul class="space-y-2" x-show="open" x-collapse.duration.300ms>
                    <li><a href="{{ route('home') }}" class="text-gray-400 hover:text-white">Inicio</a></li>
                    <li><a href="{{ route('shop.index') }}" class="text-gray-400 hover:text-white">Tienda</a></li>
                    <li><a href="{{ route('about') }}" class="text-gray-400 hover:text-white">Nosotros</a></li>
                    
                </ul>
            </div>

            {{-- CAMBIO AQUÍ: Se modificó la lógica de x-data --}}
            <div x-data="{ open: window.innerWidth >= 1024 }" @resize.window="open = window.innerWidth >= 1024"
                class="space-y-4 border-t border-gray-700 pt-4 md:border-none md:pt-0">
                <div @click="open = !open" class="flex justify-between items-center cursor-pointer lg:cursor-default">
                    <h4 class="text-lg font-semibold text-white">Soporte</h4>
                    <svg class="w-5 h-5 lg:hidden transition-transform" :class="{ 'rotate-180': open }" fill="none"
                        stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                    </svg>
                </div>
                <ul class="space-y-2" x-show="open" x-collapse.duration.300ms>
                    <li><a href="{{ route('contact') }}" class="text-gray-400 hover:text-white">Contáctanos</a></li>
                    <li><a href="{{ route('terms') }}" class="text-gray-400 hover:text-white">Términos y Condiciones</a></li>
                    <li><a href="{{ route('privacy') }}" class="text-gray-400 hover:text-white">Política de Privacidad</a></li>
                    <li><a href="{{ route('support.tickets.create') }}" class="text-gray-400 hover:text-white">Soporte Técnico</a></li>
                    
                </ul>
            </div>

            <div class="space-y-4 border-t border-gray-700 pt-4 md:border-none md:pt-0">
                <h4 class="text-lg font-semibold text-white">Contacto Rápido</h4>
                <ul class="space-y-2">
                    <li class="flex items-start">
                        <svg class="w-5 h-5 mr-3 mt-1 flex-shrink-0" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z">
                            </path>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                        </svg>
                        <a href="https://www.google.com/maps/place/Interelectricos+A%26F/@7.1157696,-73.1280929,17z/data=!3m1!4b1!4m6!3m5!1s0x8e683fc1804c49fd:0x73cc8678d41efcb7!8m2!3d7.1157643!4d-73.1232273!16s%2Fg%2F11h0zfrp72?hl=es&entry=ttu&g_ep=EgoyMDI1MDQyMS4wIKXMDSoJLDEwMjExNDU1SAFQAw%3D%3D" class="text-gray-400 hover:text-white">
                            Cra 17 No. 42-05 Centro, Bucaramanga, Santander
                        </a>
                    </li>
                    <li class="flex items-center">
                        <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z">
                            </path>
                        </svg>
                        <a href="tel:+573012345678" class="text-gray-400 hover:text-white">+57 300 123 4567</a>
                    </li>
                    <li class="flex items-center">
                        <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z">
                            </path>
                        </svg>
                        <a href="mailto:interelectricosaf@gmail.com" class="text-gray-400 hover:text-white">interelectricosaf@gmail.com</a>
                    </li>
                </ul>
            </div>
        </div>

        <div
            class="mt-12 border-t border-gray-700 pt-8 flex flex-col md:flex-row justify-between items-center text-sm">
            <p class="text-gray-500 mb-4 md:mb-0">
                © {{ date('Y') }} w.software.creativo Todos los derechos reservados.
            </p>
            <div class="flex space-x-4">
                <a href="{{ route('privacy') }}" class="text-gray-500 hover:text-white">Política de Privacidad</a>
                <a href="{{ route('terms') }}" class="text-gray-500 hover:text-white">Términos y Condiciones</a>
            </div>
        </div>
    </div>
</footer>
