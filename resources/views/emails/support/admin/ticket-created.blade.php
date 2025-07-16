@component('mail::layout')
{{-- Header --}}
@slot('header')
@component('mail::header', ['url' => config('app.url')])
{{ config('app.name') }} - Soporte
@endcomponent
@endslot

# Nuevo Ticket de Soporte Creado

Se ha creado un nuevo ticket de soporte con los siguientes detalles:

- **Número de Referencia:** {{ $ticket->reference_number }}
- **Asunto:** {{ $ticket->subject }}
- **Prioridad:** {{ ucfirst($ticket->priority) }}
- **Estado:** {{ ucfirst(str_replace('_', ' ', $ticket->status)) }}
- **Creado por:** {{ $ticket->user->name }} ({{ $ticket->user->email }})
- **Fecha de creación:** {{ $ticket->created_at->format('d/m/Y H:i') }}

## Descripción del problema:
{{ $ticket->description }}

@component('mail::button', ['url' => $url])
Ver Ticket
@endcomponent

Gracias,  
{{ config('app.name') }}

{{-- Footer --}}
@slot('footer')
@component('mail::footer')
© {{ date('Y') }} {{ config('app.name') }}. Todos los derechos reservados.
@endcomponent
@endslot
@endcomponent
