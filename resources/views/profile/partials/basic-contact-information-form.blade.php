<section class="mt-10">
    <header>
        <h2 class="text-lg font-medium text-gray-900">
            {{ __('Información de Contacto') }}
        </h2>

        <p class="mt-1 text-sm text-gray-600">
            {{ __('Tu información de contacto personal.') }}
        </p>
    </header>

    <form method="post" action="{{ route('profile.contact.update') }}" class="mt-6 space-y-6">
        @csrf
        @method('patch')

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <!-- Teléfono de contacto -->
            <div>
                <x-input-label for="phone" :value="__('Teléfono de Contacto')" />
                <x-text-input id="phone" name="phone" type="text" class="mt-1 block w-full" 
                    :value="old('phone', $user->phone)" autocomplete="tel" />
                <x-input-error class="mt-2" :messages="$errors->get('phone')" />
            </div>

            <!-- Dirección -->
            <div class="md:col-span-2">
                <x-input-label for="address" :value="__('Dirección')" />
                <x-text-input id="address" name="address" type="text" class="mt-1 block w-full" 
                    :value="old('address', $user->address)" />
                <x-input-error class="mt-2" :messages="$errors->get('address')" />
            </div>
        </div>

        <div class="flex items-center gap-4">
            <x-primary-button>{{ __('Guardar Cambios') }}</x-primary-button>

            @if (session('status') === 'contact-information-updated')
                <div
                    x-data="{ show: true }"
                    x-show="show"
                    x-transition
                    x-init="setTimeout(() => show = false, 3000)"
                    class="p-3 bg-green-100 border border-green-400 text-green-700 rounded relative"
                    role="alert"
                >
                    <strong class="font-bold">{{ __('¡Guardado!') }}</strong>
                    <span class="block sm:inline">{{ __('Tu información de contacto ha sido actualizada.') }}</span>
                </div>
            @endif
        </div>
    </form>
</section>
