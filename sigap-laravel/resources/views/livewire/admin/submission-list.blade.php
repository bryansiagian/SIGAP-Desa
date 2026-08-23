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
        <div class="fixed inset-0 bg-black/40 flex items-center justify-center" wire:click.self="$set('selectedSubmissionId', null)">
            <div class="bg-white rounded p-6 max-w-lg w-full max-h-[80vh] overflow-y-auto">
                <h2 class="font-medium mb-3">{{ $selected->serviceType->nama_layanan }}</h2>

                @foreach ($selected->fields_snapshot as $field)
                    <div class="mb-2 text-sm">
                        <span class="text-gray-500">{{ $field['label'] }}:</span>
                        <span>{{ $selected->data[$field['field_key']] ?? '-' }}</span>
                    </div>
                @endforeach

                @if ($selected->files->count())
                    <div class="mt-3">
                        <p class="text-sm font-medium mb-1">Lampiran</p>
                        @foreach ($selected->files as $file)
                            <p class="text-sm text-blue-600">{{ $file->original_filename }}</p>
                        @endforeach
                    </div>
                @endif

                <textarea wire:model="catatan" placeholder="Catatan (opsional)" class="w-full border rounded p-2 mt-3 text-sm"></textarea>

                <div class="flex gap-2 mt-3">
                    <button wire:click="approve({{ $selected->id }})" class="bg-green-600 text-white px-4 py-2 rounded text-sm">Setujui</button>
                    <button wire:click="reject({{ $selected->id }})" class="bg-red-600 text-white px-4 py-2 rounded text-sm">Tolak</button>
                    <button wire:click="$set('selectedSubmissionId', null)" class="text-gray-600 px-4 py-2 text-sm">Tutup</button>
                </div>
            </div>
        </div>
    @endif
</div>
