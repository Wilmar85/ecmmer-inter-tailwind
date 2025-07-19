<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Mi Perfil') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            @if(auth()->user()->isAdmin())
            <div class="text-right mb-4">
                <a href="{{ route('orders.index') }}"
                    class="inline-flex items-center px-5 py-2 bg-primary border-2 border-primary rounded-full font-semibold text-xs text-dark-text uppercase tracking-widest hover:bg-gray-800 hover:border-gray-800 hover:text-white transition-all duration-300">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                        xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2">
                        </path>
                    </svg>
                    {{ __('Ver Pedidos') }}
                </a>
            </div>
            @endif

            <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                <div class="max-w-4xl">
                    @include('profile.partials.update-profile-information-form')
                </div>
            </div>

            @if(auth()->user()->isAdmin())
            <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                <div class="max-w-4xl">
                    @include('profile.partials.update-contact-information-form')
                </div>
            </div>
            @endif

            <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                <div class="max-w-xl">
                    @include('profile.partials.update-password-form')
                </div>
            </div>

            <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                <div class="max-w-full">
                    @include('profile.partials.orders-history')
                </div>
            </div>
            
            {{-- Script para actualizar el botón de WhatsApp --}}
            @if(session('update_whatsapp_script'))
                {!! session('update_whatsapp_script') !!}
            @endif
        </div>
    </div>
</x-app-layout>
