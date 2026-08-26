<button {{ $attributes->merge(['type' => 'submit', 'class' => 'inline-flex items-center justify-center gap-2 rounded-lg bg-clay px-4 py-2.5 text-sm font-medium text-white hover:bg-clay/90 transition disabled:opacity-50']) }}>
    {{ $slot }}
</button>
