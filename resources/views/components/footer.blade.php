<footer class="bg-secondary text-light-text">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">

            <div class="space-y-4">
                <a href="{{ route('home') }}">
                    <x-application-logo class="w-auto h-12" />
                </a>
                <p class="text-gray-400">
                    Duis ultricies libero sit amet aliquam fermentum. Nunc tincidunt mollis dui in tempor.
                </p>
                <div class="flex space-x-4">
                    <a href="#" class="text-gray-400 hover:text-primary transition-colors" title="Facebook">
                        <svg class="h-7 w-7" fill="currentColor" viewBox="0 0 24 24">
                            <path
                                d="M22 12c0-5.523-4.477-10-10-10S2 6.477 2 12c0 4.991 3.657 9.128 8.438 9.878v-6.987h-2.54V12h2.54V9.797c0-2.506 1.492-3.89 3.777-3.89 1.094 0 2.238.195 2.238.195v2.46h-1.26c-1.243 0-1.63.771-1.63 1.562V12h2.773l-.443 2.89h-2.33v6.988C18.343 21.128 22 16.991 22 12z" />
                        </svg>
                    </a>
                    <a href="#" class="text-gray-400 hover:text-primary transition-colors" title="Instagram">
                        <svg class="h-7 w-7" fill="currentColor" viewBox="0 0 24 24">
                            <path
                                d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.602.069 4.849 0 3.248-.012 3.584-.07 4.85-1.48 3.225-1.667 4.771-4.919 4.919-1.266.058-1.602.069-4.849.069-3.248 0-3.584-.012-4.85-.07-3.252-1.48-4.771-1.667-4.919-4.919-.058-1.265-.069-1.602-.069-4.849 0-3.248.012-3.584.07-4.85.148-3.225 1.667-4.771 4.919-4.919C8.416 2.175 8.752 2.163 12 2.163zm0 1.8a5.703 5.703 0 100 11.406A5.703 5.703 0 0012 3.963zM12 16.5a4.5 4.5 0 110-9 4.5 4.5 0 010 9zm6.536-8.182a1.2 1.2 0 11-2.4 0 1.2 1.2 0 012.4 0z" />
                        </svg>
                    </a>
                </div>
            </div>

            {{-- CAMBIO AQUÍ: Se modificó la lógica de x-data --}}
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
                    <li><a href="#" class="text-gray-400 hover:text-white">Request Service</a></li>
                    <li><a href="#" class="text-gray-400 hover:text-white">Commercial Plumbing</a></li>
                    <li><a href="#" class="text-gray-400 hover:text-white">Our Work</a></li>
                    <li><a href="#" class="text-gray-400 hover:text-white">What We Do</a></li>
                    <li><a href="#" class="text-gray-400 hover:text-white">Our Process</a></li>
                    <li><a href="#" class="text-gray-400 hover:text-white">Reviews</a></li>
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
                    <li><a href="#" class="text-gray-400 hover:text-white">About</a></li>
                    <li><a href="#" class="text-gray-400 hover:text-white">Careers</a></li>
                    <li><a href="#" class="text-gray-400 hover:text-white">Newsletter</a></li>
                    <li><a href="#" class="text-gray-400 hover:text-white">Privacy Policy</a></li>
                    <li><a href="#" class="text-gray-400 hover:text-white">Terms Of Use</a></li>
                    <li><a href="#" class="text-gray-400 hover:text-white">Contact</a></li>
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
                        <span class="text-gray-400">No: 58 A, East Madison Street, Baltimore, MD, USA 4508</span>
                    </li>
                    <li class="flex items-center">
                        <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z">
                            </path>
                        </svg>
                        <span class="text-gray-400">+000 123 456 789</span>
                    </li>
                    <li class="flex items-center">
                        <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z">
                            </path>
                        </svg>
                        <span class="text-gray-400">info@example.com</span>
                    </li>
                </ul>
            </div>
        </div>

        <div
            class="mt-12 border-t border-gray-700 pt-8 flex flex-col md:flex-row justify-between items-center text-sm">
            <p class="text-gray-500 mb-4 md:mb-0">
                © {{ date('Y') }} Wedesign.Tech. Todos los derechos reservados.
            </p>
            <div class="flex space-x-4">
                <a href="#" class="text-gray-500 hover:text-white">Política de Privacidad</a>
                <a href="#" class="text-gray-500 hover:text-white">Términos y Condiciones</a>
            </div>
        </div>
    </div>
</footer>
