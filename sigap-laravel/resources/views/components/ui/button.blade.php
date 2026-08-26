@props(['variant' => 'primary', 'type' => 'button', 'as' => 'button', 'href' => null])

@php
$base = 'inline-flex items-center justify-center gap-2 rounded-lg px-4 py-2.5 text-sm font-medium transition disabled:opacity-50 disabled:cursor-not-allowed';

$variants = [
    'primary' => 'bg-clay text-white hover:bg-clay/90',
    'secondary' => 'bg-padi text-white hover:bg-padi/90',
    'outline' => 'border border-soil/20 text-soil hover:bg-soil/5',
    'ghost' => 'text-soil hover:bg-soil/5',
    'danger' => 'bg-red-700 text-white hover:bg-red-800',
];

$classes = $base . ' ' . $variants[$variant];
@endphp

@if ($as === 'a')
    <a href="{{ $href }}" {{ $attributes->merge(['class' => $classes]) }}>
        {{ $slot }}
    </a>
@else
    <button type="{{ $type }}" {{ $attributes->merge(['class' => $classes]) }}>
        {{ $slot }}
    </button>
@endif
