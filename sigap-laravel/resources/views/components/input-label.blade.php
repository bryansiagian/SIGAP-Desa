@props(['value'])

<label {{ $attributes->merge(['class' => 'block text-sm font-medium text-soil mb-1.5']) }}>
    {{ $value ?? $slot }}
</label>
