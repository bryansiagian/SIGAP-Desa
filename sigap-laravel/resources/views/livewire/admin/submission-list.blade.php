<div class="max-w-4xl mx-auto p-6">
    <h1 class="text-xl font-medium mb-4">Daftar Pengajuan</h1>

    <select wire:model.live="filterStatus" class="border rounded p-2 mb-4">
        <option value="">Semua status</option>
        <option value="diajukan">Diajukan</option>
        <option value="diproses">Diproses</option>
        <option value="selesai">Selesai</option>
        <option value="ditolak">Ditolak</option>
    </select>

    <div class="space-y-2">
        @foreach ($submissions as $submission)
            <div wire:key="sub-{{ $submission->id }}" class="border rounded p-3 flex justify-between items-center">
                <div>
                    <p class="font-medium">{{ $submission->serviceType->nama_layanan }}</p>
                    <p class="text-sm text-gray-500">{{ $submission->submitter->name }} · {{ $submission->status }} · tahap {{ $submission->current_step }}</p>
                </div>
                <button wire:click="selectSubmission({{ $submission->id }})" class="text-blue-600 text-sm">Lihat detail</button>
            </div>
        @endforeach
    </div>

    {{ $submissions->links() }}

    {{-- Panel detail --}}
    @if ($selected)
        @php $isFinal = in_array($selected->status, ['selesai', 'ditolak']); @endphp

        <div wire:key="modal-{{ $selected->id }}" class="fixed inset-0 bg-black/40 flex items-center justify-center" wire:click.self="$set('selectedSubmissionId', null)">
            <div class="bg-white rounded p-6 max-w-lg w-full max-h-[80vh] overflow-y-auto">
                <div class="flex justify-between items-start mb-3">
                    <h2 class="font-medium">{{ $selected->serviceType->nama_layanan }}</h2>
                    <span class="text-sm px-2 py-1 rounded
                        {{ match($selected->status) {
                            'selesai' => 'bg-green-100 text-green-700',
                            'ditolak' => 'bg-red-100 text-red-700',
                            default => 'bg-amber-100 text-amber-700',
                        } }}">
                        {{ $selected->status }}
                    </span>
                </div>

                @foreach ($selected->fields_snapshot as $field)
                    <div wire:key="field-{{ $field['field_key'] }}" class="mb-2 text-sm">
                        <span class="text-gray-500">{{ $field['label'] }}:</span>

                        @if ($field['field_type'] === 'file')
                            @php
                                $file = $selected->files->firstWhere('field_key', $field['field_key']);
                            @endphp

                            @if ($file)
                                @if (str_starts_with($file->mime_type, 'image/'))
                                    <a href="{{ route('admin.files.show', $file) }}" target="_blank">
                                        <img src="{{ route('admin.files.show', $file) }}" class="mt-1 max-w-xs rounded border" alt="{{ $field['label'] }}">
                                    </a>
                                @else
                                    <a href="{{ route('admin.files.show', $file) }}" target="_blank" class="text-blue-600">
                                        {{ $file->original_filename }}
                                    </a>
                                @endif
                            @else
                                <span class="text-gray-400">-</span>
                            @endif
                        @else
                            <span>{{ $selected->data[$field['field_key']] ?? '-' }}</span>
                        @endif
                    </div>
                @endforeach

                @if ($selected->files->count())
                    <div class="mt-3">
                        <p class="text-sm font-medium mb-1">Lampiran</p>
                        @foreach ($selected->files as $file)
                            <p wire:key="file-{{ $file->id }}" class="text-sm text-blue-600">{{ $file->original_filename }}</p>
                        @endforeach
                    </div>
                @endif

                {{-- Riwayat approval --}}
                @if ($selected->approvals->count())
                    <div class="mt-4 border-t pt-3">
                        <p class="text-sm font-medium mb-2">Riwayat Persetujuan</p>
                        @foreach ($selected->approvals as $approval)
                            <div wire:key="approval-{{ $approval->id }}" class="text-sm mb-2 flex justify-between items-start">
                                <div>
                                    <span class="{{ $approval->status === 'disetujui' ? 'text-green-700' : 'text-red-700' }} font-medium">
                                        {{ ucfirst($approval->status) }}
                                    </span>
                                    oleh {{ $approval->approver->name ?? 'Pengguna terhapus' }}
                                    <span class="text-gray-400">({{ $approval->step->nama_tahap ?? '-' }})</span>
                                    @if ($approval->catatan)
                                        <p class="text-gray-500 italic">"{{ $approval->catatan }}"</p>
                                    @endif
                                </div>
                                <span class="text-gray-400 text-xs whitespace-nowrap ms-2">
                                    {{ $approval->waktu?->diffForHumans() }}
                                </span>
                            </div>
                        @endforeach
                    </div>
                @endif

                {{-- Tombol aksi hanya muncul kalau belum final --}}
                @if ($canAct)
                    <textarea wire:model="catatan" placeholder="Catatan (opsional)" class="w-full border rounded p-2 mt-3 text-sm"></textarea>

                    <div class="flex gap-2 mt-3">
                        <button wire:click="approve({{ $selected->id }})" class="bg-green-600 text-white px-4 py-2 rounded text-sm">Setujui</button>
                        <button wire:click="reject({{ $selected->id }})" class="bg-red-600 text-white px-4 py-2 rounded text-sm">Tolak</button>
                        <button wire:click="$set('selectedSubmissionId', null)" class="text-gray-600 px-4 py-2 text-sm">Tutup</button>
                    </div>
                @else
                    @if (! in_array($selected->status, ['selesai', 'ditolak']))
                        <p class="text-sm text-gray-500 mt-3 italic">Menunggu tindakan dari pihak lain di tahap ini.</p>
                    @endif
                    <div class="mt-4">
                        <button wire:click="$set('selectedSubmissionId', null)" class="text-gray-600 px-4 py-2 text-sm border rounded">Tutup</button>
                    </div>
                @endif
            </div>
        </div>
    @endif
</div>
