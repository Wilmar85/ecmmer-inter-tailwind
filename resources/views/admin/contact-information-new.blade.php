@extends('layouts.admin')

@section('title', 'Información de Contacto')

@section('header', 'Información de Contacto')

@section('content')
<div class="bg-white shadow overflow-hidden sm:rounded-lg">
    <div class="px-4 py-5 sm:px-6 border-b border-gray-200">
        <h3 class="text-lg leading-6 font-medium text-gray-900">
            Configuración de Información de Contacto
        </h3>
        <p class="mt-1 max-w-2xl text-sm text-gray-500">
            Actualiza la información de contacto que se muestra en el sitio web.
        </p>
    </div>
    
    <div class="bg-white px-4 py-5 sm:p-6">
        @livewire('admin.contact-information-new')
    </div>
    
    <div class="px-4 py-3 bg-gray-50 text-right sm:px-6">
        <a href="{{ route('admin.dashboard') }}" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-gray-600 hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500">
            <svg class="-ml-1 mr-2 h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                <path fill-rule="evenodd" d="M12.707 5.293a1 1 0 010 1.414L9.414 10l3.293 3.293a1 1 0 01-1.414 1.414l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 0z" clip-rule="evenodd" />
            </svg>
            Volver al panel
        </a>
    </div>
</div>

@push('styles')
<style>
    [x-cloak] { display: none !important; }
</style>
@endpush

@push('scripts')
<script>
    document.addEventListener('livewire:load', function () {
        Livewire.on('saved', () => {
            // Scroll to top to show the success message
            window.scrollTo({ top: 0, behavior: 'smooth' });
            
            // Hide the success message after 5 seconds
            setTimeout(() => {
                const alerts = document.querySelectorAll('[x-data]');
                alerts.forEach(alert => {
                    if (alert.textContent.includes('exitosamente')) {
                        alert.style.transition = 'opacity 1s ease-out';
                        alert.style.opacity = '0';
                        setTimeout(() => alert.remove(), 1000);
                    }
                });
            }, 5000);
        });
    });
</script>
@endpush
@endsection
