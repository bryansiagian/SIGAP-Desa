@props(['on' => false])

<button {{ $attributes }} type="button"
    class="relative inline-flex h-7 w-12 items-center rounded-full transition-colors duration-200 {{ $on ? 'bg-padi' : 'bg-soil/20' }}">
    <span class="inline-block h-5 w-5 transform rounded-full bg-white shadow transition-transform duration-200 {{ $on ? 'translate-x-6' : 'translate-x-1' }}"></span>
</button>
