<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Crear Usuario') }}
        </h2>
    </x-slot>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <form method="POST" action="{{ route('admin.users.store') }}">
                        @csrf
                        <div class="mb-4">
                            <label class="block">Nombre</label>
                            <input type="text" name="name" class="border rounded w-full px-3 py-2" required>
                        </div>
                        <div class="mb-4">
                            <label class="block">Email</label>
                            <input type="email" name="email" class="border rounded w-full px-3 py-2" required>
                        </div>
                        <div class="mb-4">
                            <label class="block">Contraseña</label>
                            <input type="password" name="password" class="border rounded w-full px-3 py-2" required>
                        </div>
                        <div class="mb-4">
                            <label class="block">Confirmar Contraseña</label>
                            <input type="password" name="password_confirmation" class="border rounded w-full px-3 py-2" required>
                        </div>
                        <button type="submit" class="bg-green-600 text-white px-4 py-2 rounded">Guardar</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
