<div class="max-w-5xl mx-auto px-6 py-10">
    <h1 class="font-display text-2xl font-semibold mb-1">Dashboard</h1>
    <p class="text-soil/60 text-sm mb-8">Ringkasan aktivitas layanan SIGAP Desa</p>

    {{-- Kartu ringkasan --}}
    <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-8">
        <x-ui.card>
            <p class="text-xs text-soil/50 mb-1">Total Pengajuan</p>
            <p class="font-display text-2xl font-semibold">{{ $totalKeseluruhan }}</p>
        </x-ui.card>
        <x-ui.card>
            <p class="text-xs text-soil/50 mb-1">Bulan Ini</p>
            <p class="font-display text-2xl font-semibold text-clay">{{ $totalBulanIni }}</p>
        </x-ui.card>
        <x-ui.card>
            <p class="text-xs text-soil/50 mb-1">Diproses</p>
            <p class="font-display text-2xl font-semibold text-panen">{{ $perStatus['diajukan'] ?? 0 + ($perStatus['diproses'] ?? 0) }}</p>
        </x-ui.card>
        <x-ui.card>
            <p class="text-xs text-soil/50 mb-1">Selesai</p>
            <p class="font-display text-2xl font-semibold text-padi">{{ $perStatus['selesai'] ?? 0 }}</p>
        </x-ui.card>
    </div>

    <div class="grid md:grid-cols-2 gap-5">
        {{-- Breakdown status --}}
        <x-ui.card>
            <h2 class="font-medium mb-4">Berdasarkan Status</h2>
            <div class="space-y-3">
                @foreach (['diajukan', 'diproses', 'selesai', 'ditolak'] as $status)
                    @php
                        $count = $perStatus[$status] ?? 0;
                        $percent = $totalKeseluruhan > 0 ? round($count / $totalKeseluruhan * 100) : 0;
                    @endphp
                    <div>
                        <div class="flex justify-between text-sm mb-1">
                            <x-ui.badge :status="$status" />
                            <span class="text-soil/50">{{ $count }}</span>
                        </div>
                        <div class="h-1.5 bg-soil/10 rounded-full overflow-hidden">
                            <div class="h-full rounded-full
                                {{ match($status) {
                                    'selesai' => 'bg-padi',
                                    'ditolak' => 'bg-red-700',
                                    default => 'bg-panen',
                                } }}"
                                style="width: {{ $percent }}%"></div>
                        </div>
                    </div>
                @endforeach
            </div>
        </x-ui.card>

        {{-- Layanan terpopuler --}}
        <x-ui.card>
            <h2 class="font-medium mb-4">Layanan Terbanyak Diajukan</h2>
            <div class="space-y-2">
                @forelse ($topLayanan as $i => $type)
                    <div class="flex justify-between items-center text-sm">
                        <div class="flex items-center gap-2">
                            <span class="text-soil/30 font-display text-xs">{{ $i + 1 }}</span>
                            <span>{{ $type->nama_layanan }}</span>
                        </div>
                        <span class="text-soil/50">{{ $type->submissions_count }}</span>
                    </div>
                @empty
                    <p class="text-soil/40 text-sm">Belum ada data.</p>
                @endforelse
            </div>
        </x-ui.card>
    </div>

    {{-- Pengajuan terbaru --}}
    <x-ui.card :padded="false" class="mt-5">
        <div class="p-5 pb-0 flex justify-between items-center">
            <h2 class="font-medium">Pengajuan Terbaru</h2>
            <a href="{{ route('admin.submissions') }}" wire:navigate class="text-sm text-clay font-medium">Lihat semua &rarr;</a>
        </div>
        <div class="divide-y divide-soil/10 mt-3">
            @forelse ($recentSubmissions as $submission)
                <div class="flex justify-between items-center px-5 py-3">
                    <div>
                        <p class="text-sm font-medium">{{ $submission->serviceType->nama_layanan }}</p>
                        <p class="text-xs text-soil/50">{{ $submission->submitter->name }} · {{ $submission->created_at->diffForHumans() }}</p>
                    </div>
                    <x-ui.badge :status="$submission->status" />
                </div>
            @empty
                <p class="text-soil/40 text-sm px-5 py-4">Belum ada pengajuan.</p>
            @endforelse
        </div>
    </x-ui.card>
</div>
