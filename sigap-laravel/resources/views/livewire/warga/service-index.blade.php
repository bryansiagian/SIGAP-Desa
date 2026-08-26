<div class="max-w-3xl mx-auto px-6 py-10">
    <h1 class="font-display text-2xl font-semibold mb-1">Layanan Tersedia</h1>
    <p class="text-soil/60 text-sm mb-6">Pilih layanan yang ingin diajukan</p>

    <div class="grid gap-3">
        @forelse ($serviceTypes as $type)
            <a href="{{ route('service.submit', $type->key) }}" wire:navigate
                class="group bg-surface border border-soil/10 rounded-xl p-5 flex items-center justify-between hover:border-clay/40 hover:shadow-sm transition">
                <div>
                    <p class="font-medium">{{ $type->nama_layanan }}</p>
                    @if ($type->kategori)
                        <p class="text-sm text-soil/50 mt-0.5">{{ $type->kategori }}</p>
                    @endif
                </div>
                <svg class="w-5 h-5 text-soil/30 group-hover:text-clay group-hover:translate-x-0.5 transition" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                </svg>
            </a>
        @empty
            <div class="text-center py-16 bg-surface border border-dashed border-soil/20 rounded-xl">
                <p class="text-soil/50">Belum ada layanan tersedia saat ini.</p>
            </div>
        @endforelse
    </div>
</div>
