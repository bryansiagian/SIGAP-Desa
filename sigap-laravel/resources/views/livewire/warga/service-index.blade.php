<div class="max-w-2xl mx-auto p-6">
    <h1 class="text-xl font-medium mb-4">Layanan Tersedia</h1>

    <div class="grid gap-3">
        @forelse ($serviceTypes as $type)
            <a href="{{ route('service.submit', $type->key) }}" wire:navigate
                class="border rounded-lg p-4 hover:border-blue-500 hover:bg-blue-50 transition">
                <p class="font-medium">{{ $type->nama_layanan }}</p>
                @if ($type->kategori)
                    <p class="text-sm text-gray-500">{{ $type->kategori }}</p>
                @endif
            </a>
        @empty
            <p class="text-gray-500">Belum ada layanan tersedia.</p>
        @endforelse
    </div>
</div>
