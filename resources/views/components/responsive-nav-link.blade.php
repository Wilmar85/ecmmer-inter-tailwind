@props(['active'])

@php
    // CAMBIO: Nuevos colores para el tema oscuro y mejor hover
    $classes =
        $active ?? false
            ? 'block w-full ps-3 pe-4 py-3 border-l-4 border-primary text-base font-medium text-white bg-primary/10 focus:outline-none'
            : 'block w-full ps-3 pe-4 py-3 border-l-4 border-transparent text-base font-medium text-gray-400 hover:text-white hover:bg-gray-800 focus:outline-none';
@endphp

<a {{ $attributes->merge(['class' => $classes . ' flex items-center transition-all duration-200']) }}>
    {{ $slot }}
</a>
