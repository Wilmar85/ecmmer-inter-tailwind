<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Editar Usuario') }}
        </h2>
    </x-slot>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <form method="POST" action="{{ route('admin.users.update', $user) }}">
                        @csrf
                        @method('PUT')
                        <div class="mb-4">
                            <label class="block">Nombre</label>
                            <input type="text" name="name" value="{{ old('name', $user->name) }}" class="border rounded w-full px-3 py-2" required>
                        </div>
                        <div class="mb-4">
                            <label class="block">Email</label>
                            <input type="email" name="email" value="{{ old('email', $user->email) }}" class="border rounded w-full px-3 py-2" required>
                        </div>
                        <div class="mb-4">
                            <label class="block">Contraseña (dejar en blanco para no cambiar)</label>
                            <input type="password" name="password" class="border rounded w-full px-3 py-2">
                        </div>
                        <div class="mb-4">
                            <label class="block">Confirmar Contraseña</label>
                            <input type="password" name="password_confirmation" class="border rounded w-full px-3 py-2">
                        </div>
                        <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded">Actualizar</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
