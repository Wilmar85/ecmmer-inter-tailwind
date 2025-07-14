<x-guest-layout>
    <div x-data="{ isRegistering: {{ $errors->any() ? 'true' : 'false' }} }" class="w-full max-w-4xl mx-auto bg-white shadow-2xl rounded-lg overflow-hidden">

        <div class="flex flex-col sm:flex-row min-h-[620px]">

            <div class="w-full sm:w-1/2 p-6 sm:p-8 flex flex-col justify-center transition-all duration-300 ease-in-out"
                :class="{ 'sm:order-last': isRegistering }">

                <div x-show="!isRegistering" x-transition.opacity.duration.500ms>
                    <div class="text-center mb-10">
                        <a href="/"><x-application-logo-login class="w-64 sm:w-32 h-auto mx-auto" /></a>
                        <h2 class="text-3xl font-bold mt-4 text-dark-text">Iniciar Sesión</h2>
                    </div>
                    <form method="POST" action="{{ route('login') }}" class="w-full max-w-sm mx-auto">
                        @csrf
                        <div>
                            <x-text-input id="email" type="email" name="email" :value="old('email')" required
                                autofocus autocomplete="username" placeholder="Correo Electrónico"
                                class="w-full bg-gray-100 border-none py-3" />
                            <x-input-error :messages="$errors->get('email')" class="mt-2" />
                        </div>
                        <div class="mt-4">
                            <x-text-input id="password" type="password" name="password" required
                                autocomplete="current-password" placeholder="Contraseña"
                                class="w-full bg-gray-100 border-none py-3" />
                            <x-input-error :messages="$errors->get('password')" class="mt-2" />
                        </div>
                        <div class="text-right mt-4">
                            @if (Route::has('password.request'))
                                <a class="underline text-sm text-gray-600 hover:text-primary"
                                    href="{{ route('password.request') }}">¿Olvidaste tu contraseña?</a>
                            @endif
                        </div>
                        <div class="mt-6">
                            <button type="submit"
                                class="w-full text-center px-5 py-3 bg-primary border-2 border-primary rounded-full font-semibold text-xs text-dark-text uppercase tracking-widest hover:bg-gray-800 hover:border-gray-800 hover:text-white transition-all duration-300">Iniciar
                                Sesión</button>
                        </div>

                        {{-- CAMBIO AQUÍ: Enlace a Registro solo para móvil --}}
                        <div class="mt-6 text-center sm:hidden">
                            <a href="#" @click.prevent="isRegistering = true"
                                class="text-sm text-gray-600 underline hover:text-primary">
                                ¿No tienes una cuenta? Regístrate
                            </a>
                        </div>
                    </form>
                </div>

                <div x-show="isRegistering" style="display: none;" x-transition.opacity.duration.500ms>
                    <div class="text-center mb-8">
                        <a href="/"><x-application-logo-login class="w-64 sm:w-32 h-auto mx-auto" /></a>
                        <h2 class="text-3xl font-bold mt-4 text-dark-text">Crear Cuenta</h2>
                    </div>
                    <form method="POST" action="{{ route('register') }}" class="w-full max-w-sm mx-auto">
                        @csrf
                        <div>
                            <x-text-input id="name" type="text" name="name" :value="old('name')" required
                                placeholder="Nombre" class="w-full bg-gray-100 border-none py-3" />
                            <x-input-error :messages="$errors->get('name')" class="mt-2" />
                        </div>
                        <div class="mt-4">
                            <x-text-input id="register_email" type="email" name="email" :value="old('email')" required
                                placeholder="Correo Electrónico" class="w-full bg-gray-100 border-none py-3" />
                            <x-input-error :messages="$errors->get('email')" class="mt-2" />
                        </div>
                        <div class="mt-4">
                            <x-text-input id="register_password" type="password" name="password" required
                                autocomplete="new-password" placeholder="Contraseña"
                                class="w-full bg-gray-100 border-none py-3" />
                            <x-input-error :messages="$errors->get('password')" class="mt-2" />
                        </div>
                        <div class="mt-4">
                            <x-text-input id="password_confirmation" type="password" name="password_confirmation"
                                required placeholder="Confirmar Contraseña"
                                class="w-full bg-gray-100 border-none py-3" />
                            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
                        </div>
                        <div class="mt-4">
                            <label for="terms" class="flex items-center">
                                <input type="checkbox" name="terms" id="terms" required
                                    class="rounded border-gray-300 text-primary shadow-sm focus:ring-primary" />
                                <span class="ms-2 text-sm text-gray-600">Acepto los <a href="{{ url('/terminos') }}"
                                        target="_blank" class="underline hover:text-primary">Términos y
                                        Condiciones</a></span>
                            </label>
                            <x-input-error :messages="$errors->get('terms')" class="mt-2" />
                        </div>
                        <div class="mt-6">
                            <button type="submit"
                                class="w-full text-center px-5 py-3 bg-primary border-2 border-primary rounded-full font-semibold text-xs text-dark-text uppercase tracking-widest hover:bg-gray-800 hover:border-gray-800 hover:text-white transition-all duration-300">Registrarse</button>
                        </div>

                        {{-- CAMBIO AQUÍ: Enlace a Login solo para móvil --}}
                        <div class="mt-6 text-center sm:hidden">
                            <a href="#" @click.prevent="isRegistering = false"
                                class="text-sm text-gray-600 underline hover:text-primary">
                                ¿Ya tienes una cuenta? Inicia Sesión
                            </a>
                        </div>
                    </form>
                </div>
            </div>

            <div class="w-full sm:w-1/2 p-8 flex-col justify-center items-center text-center bg-secondary text-white rounded-lg transition-all duration-300 ease-in-out hidden sm:flex"
                :class="{ 'sm:order-first': isRegistering }">
                <div x-show="!isRegistering" x-transition.opacity.delay.200ms>
                    <h2 class="text-4xl font-bold mb-4">¡Hola, Amigo!</h2>
                    <p class="mb-8">Ingresa tus datos y comienza tu aventura</p>
                    <button @click="isRegistering = true"
                        class="px-8 py-3 bg-transparent border-2 border-white rounded-full font-semibold text-xs text-white uppercase tracking-widest hover:bg-white hover:text-secondary transition-all duration-300">
                        Registrarse
                    </button>
                </div>
                <div x-show="isRegistering" style="display: none;" x-transition.opacity.delay.200ms>
                    <h2 class="text-4xl font-bold mb-4">¡Bienvenido de Vuelta!</h2>
                    <p class="mb-8">Para mantenerte conectado, por favor inicia sesión</p>
                    <button @click="isRegistering = false"
                        class="px-8 py-3 bg-transparent border-2 border-white rounded-full font-semibold text-xs text-white uppercase tracking-widest hover:bg-white hover:text-secondary transition-all duration-300">
                        Iniciar Sesión
                    </button>
                </div>
            </div>
        </div>
    </div>
</x-guest-layout>
