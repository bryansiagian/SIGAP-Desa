@props(['padded' => true])

<div {{ $attributes->merge(['class' => 'bg-surface border border-soil/10 rounded-xl shadow-sm ' . ($padded ? 'p-5' : '')]) }}>
    {{ $slot }}
</div>
