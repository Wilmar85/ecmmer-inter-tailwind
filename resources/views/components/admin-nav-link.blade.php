@props(['active' => false, 'href' => '#'])

@php
$classes = ($active ?? false)
            ? 'bg-gray-900 text-white px-3 py-2 rounded-md text-sm font-medium flex items-center transition-colors duration-200'
            : 'text-gray-300 hover:bg-gray-700 hover:text-white px-3 py-2 rounded-md text-sm font-medium flex items-center transition-colors duration-200';
@endphp

<a href="{{ $href }}" {{ $attributes->merge(['class' => $classes]) }}>
    {{ $slot }}
</a>
