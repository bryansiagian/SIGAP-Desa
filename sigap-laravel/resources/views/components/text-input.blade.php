@props(['disabled' => false])

<input @disabled($disabled) {{ $attributes->merge(['class' => 'w-full rounded-lg border border-soil/20 bg-white px-3 py-2.5 text-sm text-soil placeholder:text-soil/40 focus:border-clay focus:ring-1 focus:ring-clay outline-none transition']) }}>
