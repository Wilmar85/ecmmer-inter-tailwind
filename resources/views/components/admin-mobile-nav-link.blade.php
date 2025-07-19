@props(['active' => false, 'href' => '#'])

@php
$classes = ($active ?? false)
            ? 'bg-gray-900 text-white block px-3 py-2 rounded-md text-base font-medium flex items-center'
            : 'text-gray-300 hover:bg-gray-700 hover:text-white block px-3 py-2 rounded-md text-base font-medium flex items-center';
@endphp

<a href="{{ $href }}" {{ $attributes->merge(['class' => $classes]) }}>
    {{ $slot }}
</a>
