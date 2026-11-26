@props(['type' => 'success'])

@php
    $colors = [
        'success' => 'bg-green-100 text-green-800',
        'warning' => 'bg-yellow-100 text-yellow-800',
        'danger' => 'bg-red-100 text-red-800',
    ];

    $color = $colors[$type] ?? $colors['success'];
@endphp

<span {{ $attributes->merge([
    'class' => "px-3 py-1 rounded-full text-sm font-semibold $color"
]) }}>
    {{ $slot }}
</span>