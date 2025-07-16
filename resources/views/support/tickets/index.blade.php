<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ $isAdminView ? __('Todos los Tickets de Soporte') : __('Mis Tickets de Soporte') }}
            </h2>
            <div class="flex space-x-2">
                @if($isAdminView)
                    <a href="{{ route('dashboard') }}" class="inline-flex items-center px-4 py-2 bg-gray-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-500 active:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2 transition ease-in-out duration-150">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                        </svg>
                        {{ __('Volver al Dashboard') }}
                    </a>
                @endif
                <a href="{{ route('support.tickets.create') }}" class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-500 active:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition ease-in-out duration-150">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                    </svg>
                    {{ $isAdminView ? __('Nuevo Ticket para Cliente') : __('Nuevo Ticket') }}
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                
                <!-- Información del usuario -->
                <div class="bg-gray-50 p-6 rounded-lg mb-8 border border-gray-200">
                    <h2 class="text-lg font-semibold text-gray-900 mb-4">{{ __('Información del Usuario') }}</h2>
                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
                        <div class="bg-white p-3 rounded-md shadow-sm">
                            <p class="text-sm font-medium text-gray-500">{{ __('Nombre') }}</p>
                            <p class="mt-1 text-gray-900">{{ Auth::user()->name }}</p>
                        </div>
                        <div class="bg-white p-3 rounded-md shadow-sm">
                            <p class="text-sm font-medium text-gray-500">{{ __('Email') }}</p>
                            <p class="mt-1 text-gray-900">{{ Auth::user()->email }}</p>
                        </div>
                        <div class="bg-white p-3 rounded-md shadow-sm">
                            <p class="text-sm font-medium text-gray-500">{{ __('ID') }}</p>
                            <p class="mt-1 font-mono text-gray-900">#{{ Auth::user()->id }}</p>
                        </div>
                        <div class="bg-white p-3 rounded-md shadow-sm">
                            <p class="text-sm font-medium text-gray-500">{{ __('Rol') }}</p>
                            <p class="mt-1">
                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-blue-100 text-blue-800">
                                    {{ ucfirst(Auth::user()->role) }}
                                </span>
                            </p>
                        </div>
                    </div>
                </div>

                <!-- Lista de tickets -->
                <div>
                    <div class="flex justify-between items-center mb-6">
                        <h2 class="text-xl font-semibold text-gray-900">
                            {{ $isAdminView ? __('Todos los Tickets') : __('Mis Tickets') }}
                        </h2>
                        <div class="text-sm text-gray-500">
                            {{ $tickets->total() }} {{ __('tickets en total') }}
                        </div>
                    </div>
                    
                    @if($tickets->count() > 0)
                        <div class="bg-white shadow overflow-hidden sm:rounded-lg">
                            <div class="overflow-x-auto">
                                <table class="min-w-full divide-y divide-gray-200">
                                    <thead class="bg-gray-50">
                                        <tr>
                                            @if($isAdminView)
                                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                {{ __('Cliente') }}
                                            </th>
                                            @endif
                                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                {{ __('Asunto') }}
                                            </th>
                                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                {{ __('Estado') }}
                                            </th>
                                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                {{ __('Prioridad') }}
                                            </th>
                                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                {{ __('Última actualización') }}
                                            </th>
                                            <th scope="col" class="relative px-6 py-3">
                                                <span class="sr-only">{{ __('Acciones') }}</span>
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody class="bg-white divide-y divide-gray-200">
                                        @foreach($tickets as $ticket)
                                            <tr class="hover:bg-gray-50">
                                                @if($isAdminView)
                                                <td class="px-6 py-4 whitespace-nowrap">
                                                    <div class="flex items-center">
                                                        <div class="flex-shrink-0 h-10 w-10">
                                                            <img class="h-10 w-10 rounded-full" src="{{ $ticket->user->profile_photo_url ?? 'https://ui-avatars.com/api/?name='.urlencode($ticket->user->name).'&color=7F9CF5&background=EBF4FF' }}" alt="{{ $ticket->user->name }}">
                                                        </div>
                                                        <div class="ml-4">
                                                            <div class="text-sm font-medium text-gray-900">
                                                                {{ $ticket->user->name }}
                                                            </div>
                                                            <div class="text-sm text-gray-500">
                                                                {{ $ticket->user->email }}
                                                            </div>
                                                        </div>
                                                    </div>
                                                </td>
                                                @endif
                                                <td class="px-6 py-4">
                                                    <div class="text-sm font-medium text-gray-900">
                                                        <a href="{{ route('support.tickets.show', $ticket) }}" class="text-blue-600 hover:text-blue-800 hover:underline">
                                                            {{ $ticket->subject }}
                                                        </a>
                                                    </div>
                                                    <div class="text-sm text-gray-500">
                                                        #{{ $ticket->reference_number }}
                                                    </div>
                                                </td>
                                                <td class="px-6 py-4 whitespace-nowrap">
                                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                                        {{ 
                                                            $ticket->status === 'open' ? 'bg-green-100 text-green-800' : 
                                                            ($ticket->status === 'in_progress' ? 'bg-blue-100 text-blue-800' : 
                                                            ($ticket->status === 'resolved' ? 'bg-purple-100 text-purple-800' : 
                                                            ($ticket->status === 'closed' ? 'bg-gray-100 text-gray-800' : 'bg-yellow-100 text-yellow-800'))) 
                                                        }}">
                                                        {{ __('support.status.' . $ticket->status) }}
                                                    </span>
                                                </td>
                                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                                    {{ $ticket->priority ? __('support.priority.' . $ticket->priority) : __('Ninguna') }}
                                                </td>
                                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                                    {{ $ticket->updated_at->format('d/m/Y H:i') }}
                                                </td>
                                                <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                                    <a href="{{ route('support.tickets.show', $ticket) }}" class="text-blue-600 hover:text-blue-800 hover:underline">
                                                        {{ __('Ver') }}
                                                    </a>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                            
                            <!-- Paginación -->
                            @if($tickets->hasPages())
                                <div class="bg-white px-4 py-3 border-t border-gray-200 sm:px-6">
                                    {{ $tickets->links() }}
                                </div>
                            @endif
                        </div>
                    @else
                        <div class="text-center py-12 px-4 bg-gray-50 rounded-lg border-2 border-dashed border-gray-300">
                            <svg class="mx-auto h-16 w-16 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                            </svg>
                            <h3 class="mt-3 text-lg font-medium text-gray-900">{{ __('No hay tickets') }}</h3>
                            <p class="mt-1 text-sm text-gray-500">
                                {{ $isAdminView ? __('No hay tickets de soporte en el sistema.') : __('Aún no has creado ningún ticket de soporte.') }}
                            </p>
                            <div class="mt-6">
                                <a href="{{ route('support.tickets.create') }}" class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-500 active:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition ease-in-out duration-150">
                                    <svg class="-ml-1 mr-2 h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                        <path fill-rule="evenodd" d="M10 5a1 1 0 011 1v3h3a1 1 0 110 2h-3v3a1 1 0 11-2 0v-3H6a1 1 0 110-2h3V6a1 1 0 011-1z" clip-rule="evenodd" />
                                    </svg>
                                    {{ $isAdminView ? __('Crear un nuevo ticket') : __('Crear mi primer ticket') }}
                                </a>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
