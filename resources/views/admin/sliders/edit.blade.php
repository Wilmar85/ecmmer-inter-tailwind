@extends('layouts.admin')

@section('title', 'Editar Slider')

@section('content')
    <div class="container mx-auto px-4 py-8">
        <div class="mb-6">
            <h1 class="text-2xl font-bold text-gray-900">Editar Slider</h1>
            <p class="text-sm text-gray-500">Actualiza la información del slider seleccionado.</p>
        </div>

        <div class="bg-white shadow rounded-lg p-6">
            <form action="{{ route('admin.sliders.update', $slider) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                
                @include('admin.sliders._form')

                <div class="mt-8 flex justify-end space-x-3">
                    <a href="{{ route('admin.sliders.index') }}" class="inline-flex items-center px-4 py-2 border border-gray-300 shadow-sm text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary">
                        Cancelar
                    </a>
                    <button type="submit" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-primary hover:bg-primary/90 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary">
                        Actualizar Slider
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection
