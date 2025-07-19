@extends('layouts.admin')

@section('title', 'Información de Contacto')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="bg-white shadow rounded-lg p-6">
        <div class="flex justify-between items-center mb-6">
            <h2 class="text-2xl font-semibold text-gray-800">Información de Contacto</h2>
            <a href="{{ route('admin.dashboard') }}" class="text-primary-600 hover:text-primary-800 text-sm font-medium">
                ← Volver al panel
            </a>
        </div>

        <div class="bg-gray-50 p-6 rounded-lg">
            @livewire('admin.contact-information')
        </div>
    </div>
</div>
@endsection
