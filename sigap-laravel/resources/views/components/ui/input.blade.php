@props(['label' => null, 'error' => null])

<div>
    @if ($label)
        <label class="block text-sm font-medium text-soil mb-1.5">{{ $label }}</label>
    @endif

    <input {{ $attributes->merge(['class' => 'w-full rounded-lg border border-soil/20 bg-white px-3 py-2.5 text-sm text-soil placeholder:text-soil/40 focus:border-clay focus:ring-1 focus:ring-clay outline-none transition']) }}>

    @if ($error)
        <p class="text-sm text-red-700 mt-1.5">{{ $error }}</p>
    @endif
</div>
