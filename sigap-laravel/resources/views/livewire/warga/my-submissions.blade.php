<div class="max-w-2xl mx-auto px-6 py-10">
    <h1 class="font-display text-2xl font-semibold mb-1">Pengajuan Saya</h1>
    <p class="text-soil/60 text-sm mb-6">Riwayat dan status pengajuan layanan kamu</p>

    @if (session('success'))
        <div class="bg-padi/10 text-padi border border-padi/20 p-3 rounded-lg mb-5 text-sm">{{ session('success') }}</div>
    @endif

    <div class="space-y-3">
        @forelse ($submissions as $submission)
            <x-ui.card wire:key="mysub-{{ $submission->id }}" class="flex justify-between items-center">
                <div>
                    <p class="font-medium">{{ $submission->serviceType->nama_layanan }}</p>
                    <p class="text-sm text-soil/50 mt-0.5">Diajukan {{ $submission->created_at->diffForHumans() }}</p>
                </div>
<<<<<<< HEAD
                <div class="flex items-center gap-3">
                    @if ($submission->status === 'selesai')
                        <a href="{{ route('submissions.surat', $submission) }}" class="text-clay text-sm font-medium">
                            Unduh Surat
                        </a>
                    @endif
                    <x-ui.badge :status="$submission->status" />
                </div>
=======
                <x-ui.badge :status="$submission->status" />
>>>>>>> 3a4fc538fd139f03e6dcde301c8d0a5f5809f818
            </x-ui.card>
        @empty
            <div class="text-center py-16 bg-surface border border-dashed border-soil/20 rounded-xl">
                <p class="text-soil/50 mb-3">Belum ada pengajuan.</p>
                <a href="{{ route('service.index') }}" wire:navigate class="text-clay text-sm font-medium">
                    Ajukan layanan pertama &rarr;
                </a>
            </div>
        @endforelse
    </div>
</div>
