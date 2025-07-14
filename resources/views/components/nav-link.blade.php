@props(['active'])

@php
    // CAMBIO: Estilo "glow" para el enlace activo y transiciones suaves
    $classes =
        $active ?? false
            ? 'inline-flex items-center px-1 pt-1 border-b-2 border-primary text-white font-semibold leading-5 transition-all duration-300'
            : 'inline-flex items-center px-1 pt-1 border-b-2 border-transparent text-gray-400 hover:text-white hover:border-primary/50 focus:outline-none focus:text-white focus:border-primary/50 transition-all duration-300';
@endphp

<a {{ $attributes->merge(['class' => $classes]) }}>
    {{ $slot }}
</a>
