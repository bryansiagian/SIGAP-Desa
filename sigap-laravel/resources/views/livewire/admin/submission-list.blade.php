<div class="max-w-4xl mx-auto px-6 py-10">
    <h1 class="font-display text-2xl font-semibold mb-1">Daftar Pengajuan</h1>
    <p class="text-soil/60 text-sm mb-6">Proses dan pantau pengajuan layanan dari warga</p>

    <select wire:model.live="filterStatus" class="rounded-lg border border-soil/20 bg-white px-3 py-2 text-sm mb-5 focus:border-clay focus:ring-1 focus:ring-clay outline-none">
        <option value="">Semua status</option>
        <option value="diajukan">Diajukan</option>
        <option value="diproses">Diproses</option>
        <option value="selesai">Selesai</option>
        <option value="ditolak">Ditolak</option>
    </select>

    <div class="space-y-2">
        @forelse ($submissions as $submission)
            <x-ui.card wire:key="sub-{{ $submission->id }}" class="flex justify-between items-center">
                <div>
                    <p class="font-medium">{{ $submission->serviceType->nama_layanan }}</p>
                    <p class="text-sm text-soil/50 mt-0.5">{{ $submission->submitter->name }} · tahap {{ $submission->current_step }}</p>
                </div>
                <div class="flex items-center gap-4">
                    <x-ui.badge :status="$submission->status" />
                    <button wire:click="selectSubmission({{ $submission->id }})" class="text-clay text-sm font-medium">
                        Detail
                    </button>
                </div>
            </x-ui.card>
        @empty
            <div class="text-center py-16 bg-surface border border-dashed border-soil/20 rounded-xl">
                <p class="text-soil/50">Tidak ada pengajuan.</p>
            </div>
        @endforelse
    </div>

    <div class="mt-5">
        {{ $submissions->links() }}
    </div>

    {{-- Panel detail --}}
    @if ($selected)
        <div wire:key="modal-{{ $selected->id }}" class="fixed inset-0 bg-soil/40 flex items-center justify-center p-4 z-50" wire:click.self="$set('selectedSubmissionId', null)">
            <div class="bg-surface rounded-xl p-6 max-w-lg w-full max-h-[85vh] overflow-y-auto shadow-lg">
                <div class="flex justify-between items-start mb-4">
                    <h2 class="font-display font-semibold text-lg">{{ $selected->serviceType->nama_layanan }}</h2>
                    <x-ui.badge :status="$selected->status" />
                </div>

                <div class="space-y-3">
                    @foreach ($selected->fields_snapshot as $field)
                        <div wire:key="field-{{ $field['field_key'] }}" class="text-sm">
                            <span class="text-soil/50">{{ $field['label'] }}</span>

                            @if ($field['field_type'] === 'file')
                                @php
                                    $file = $selected->files->firstWhere('field_key', $field['field_key']);
                                @endphp

                                @if ($file)
                                    @if (str_starts_with($file->mime_type, 'image/'))
                                        <a href="{{ route('admin.files.show', $file) }}" target="_blank">
                                            <img src="{{ route('admin.files.show', $file) }}" class="mt-1 max-w-xs rounded-lg border border-soil/10" alt="{{ $field['label'] }}">
                                        </a>
                                    @else
                                        <a href="{{ route('admin.files.show', $file) }}" target="_blank" class="block text-clay">
                                            {{ $file->original_filename }}
                                        </a>
                                    @endif
                                @else
                                    <span class="block text-soil/30">-</span>
                                @endif
                            @else
                                <p class="text-soil">{{ $selected->data[$field['field_key']] ?? '-' }}</p>
                            @endif
                        </div>
                    @endforeach
                </div>

                {{-- Riwayat approval --}}
                @if ($selected->approvals->count())
                    <div class="mt-5 border-t border-soil/10 pt-4">
                        <p class="text-sm font-medium mb-3">Riwayat Persetujuan</p>
                        <div class="space-y-3">
                            @foreach ($selected->approvals as $approval)
                                <div wire:key="approval-{{ $approval->id }}" class="text-sm flex justify-between items-start">
                                    <div>
                                        <span class="{{ $approval->status === 'disetujui' ? 'text-padi' : 'text-red-700' }} font-medium">
                                            {{ ucfirst($approval->status) }}
                                        </span>
                                        <span class="text-soil/60">
                                            oleh {{ $approval->approver->name ?? 'Pengguna terhapus' }}
                                            ({{ $approval->step->nama_tahap ?? '-' }})
                                        </span>
                                        @if ($approval->catatan)
                                            <p class="text-soil/50 italic mt-0.5">"{{ $approval->catatan }}"</p>
                                        @endif
                                    </div>
                                    <span class="text-soil/40 text-xs whitespace-nowrap ms-2">
                                        {{ $approval->waktu?->diffForHumans() }}
                                    </span>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endif

                {{-- Tombol aksi --}}
                @if ($canAct)
                    <div class="mt-5 border-t border-soil/10 pt-4">
                        <textarea wire:model="catatan" placeholder="Catatan (opsional)"
                            class="w-full rounded-lg border border-soil/20 bg-white px-3 py-2 text-sm focus:border-clay focus:ring-1 focus:ring-clay outline-none"></textarea>

                        <div class="flex gap-2 mt-3">
                            <x-ui.button variant="secondary" wire:click="approve({{ $selected->id }})">Setujui</x-ui.button>
                            <x-ui.button variant="danger" wire:click="reject({{ $selected->id }})">Tolak</x-ui.button>
                            <x-ui.button variant="ghost" wire:click="$set('selectedSubmissionId', null)">Tutup</x-ui.button>
                        </div>
                    </div>
                @else
                    <div class="mt-5 border-t border-soil/10 pt-4">
                        @if (! in_array($selected->status, ['selesai', 'ditolak']))
                            <p class="text-sm text-soil/50 italic mb-3">Menunggu tindakan dari pihak lain di tahap ini.</p>
                        @endif
                        <x-ui.button variant="ghost" wire:click="$set('selectedSubmissionId', null)">Tutup</x-ui.button>
                    </div>
                @endif
            </div>
        </div>
    @endif
</div>
