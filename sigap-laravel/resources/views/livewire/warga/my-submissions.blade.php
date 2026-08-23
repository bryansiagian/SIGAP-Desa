<div class="max-w-2xl mx-auto p-6">
    <h1 class="text-xl font-medium mb-4">Pengajuan Saya</h1>

    @forelse ($submissions as $submission)
        <div wire:key="mysub-{{ $submission->id }}" class="border rounded p-3 mb-2">
            <div class="flex justify-between items-center">
                <p class="font-medium">{{ $submission->serviceType->nama_layanan }}</p>
                <span class="text-sm px-2 py-1 rounded
                    {{ match($submission->status) {
                        'selesai' => 'bg-green-100 text-green-700',
                        'ditolak' => 'bg-red-100 text-red-700',
                        default => 'bg-amber-100 text-amber-700',
                    } }}">
                    {{ $submission->status }}
                </span>
            </div>
            <p class="text-sm text-gray-500">Diajukan {{ $submission->created_at->diffForHumans() }}</p>
        </div>
    @empty
        <p class="text-gray-500">Belum ada pengajuan.</p>
    @endforelse
</div>
