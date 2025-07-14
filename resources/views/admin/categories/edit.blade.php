<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Editar Categoría') }}
        </h2>
    </x-slot>
    <div class="py-12">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <form method="POST" action="{{ route('admin.categories.update', $category) }}">
                        @csrf
                        @method('PUT')
                        <div class="mb-4">
                            <label class="block text-gray-700">Nombre</label>
                            <input type="text" name="name" value="{{ old('name', $category->name) }}" class="form-input mt-1 block w-full" required />
                        </div>
                        <div class="mb-4">
                            <label class="block text-gray-700">Descripción</label>
                            <textarea name="description" class="form-input mt-1 block w-full">{{ old('description', $category->description) }}</textarea>
                        </div>
                        <div class="flex justify-end">
                            <a href="{{ route('admin.categories.index') }}" class="btn btn-secondary mr-2">Cancelar</a>
                            <button type="submit" class="btn btn-primary">Actualizar</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
