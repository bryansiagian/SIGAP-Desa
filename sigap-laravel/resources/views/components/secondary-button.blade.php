<button {{ $attributes->merge(['type' => 'button', 'class' => 'inline-flex items-center justify-center gap-2 rounded-lg border border-soil/20 px-4 py-2.5 text-sm font-medium text-soil hover:bg-soil/5 transition disabled:opacity-50']) }}>
    {{ $slot }}
</button>
