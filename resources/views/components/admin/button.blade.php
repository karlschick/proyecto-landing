@props([
    'variant' => 'primary', // primary, secondary, danger
    'type' => 'button',
    'size' => 'md' // sm, md, lg
])

@php
$baseClasses = 'inline-flex items-center justify-center font-semibold rounded-lg transition focus:outline-none focus:ring-2 focus:ring-offset-2';

$variants = [
    'primary' => 'bg-blue-600 hover:bg-blue-700 text-white focus:ring-blue-500',
    'secondary' => 'bg-gray-600 hover:bg-gray-700 text-white focus:ring-gray-500',
    'danger' => 'bg-red-600 hover:bg-red-700 text-white focus:ring-red-500',
];

$sizes = [
    'sm' => 'px-3 py-1.5 text-sm',
    'md' => 'px-6 py-3 text-base',
    'lg' => 'px-8 py-4 text-lg',
];

$classes = $baseClasses . ' ' . $variants[$variant] . ' ' . $sizes[$size];
@endphp

<button
    type="{{ $type }}"
    {{ $attributes->merge(['class' => $classes]) }}
>
    {{ $slot }}
</button>
