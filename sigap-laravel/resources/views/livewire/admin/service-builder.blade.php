<div class="max-w-3xl mx-auto p-6">
    <div class="flex justify-between items-center mb-4">
        <h1 class="text-xl font-medium">Kelola Layanan</h1>
        <button wire:click="$set('showForm', true)" class="bg-blue-600 text-white px-4 py-2 rounded">
            + Buat Layanan Baru
        </button>
    </div>

    @if (session('success'))
        <div class="bg-green-100 text-green-800 p-3 rounded mb-4">{{ session('success') }}</div>
    @endif

    {{-- Daftar layanan yang sudah ada --}}
    <div class="space-y-2 mb-8">
        @foreach ($serviceTypes as $type)
            <div class="border rounded p-3 flex justify-between items-center">
                <div>
                    <p class="font-medium">{{ $type->nama_layanan }}</p>
                    <p class="text-sm text-gray-500">{{ $type->kategori }} · {{ $type->submissions_count }} pengajuan</p>
                </div>
                <button wire:click="toggleStatus({{ $type->id }})"
                    class="text-sm px-3 py-1 rounded {{ $type->status === 'aktif' ? 'bg-green-100 text-green-700' : 'bg-gray-100 text-gray-600' }}">
                    {{ $type->status }}
                </button>
            </div>
        @endforeach
    </div>

    {{-- Wizard buat layanan baru --}}
    @if ($showForm)
        <div class="border rounded p-4 space-y-6">
            <div>
                <label class="block text-sm font-medium mb-1">Nama layanan</label>
                <input type="text" wire:model="nama_layanan" placeholder="Contoh: Surat Pengantar KTP" class="w-full border rounded p-2">
                @error('nama_layanan') <p class="text-red-500 text-sm">{{ $message }}</p> @enderror

                <label class="block text-sm font-medium mb-1 mt-3">Kategori (opsional)</label>
                <input type="text" wire:model="kategori" placeholder="Contoh: Administrasi" class="w-full border rounded p-2">
            </div>

            <div>
                <p class="font-medium mb-2">Data yang perlu diisi warga</p>
                @foreach ($fields as $i => $field)
                    <div wire:key="field-{{ $i }}" class="border rounded p-3 mb-2 space-y-2">
                        <div class="grid grid-cols-2 gap-2">
                            <input type="text" wire:model="fields.{{ $i }}.label" placeholder="Nama field (contoh: NIK)" class="border rounded p-2">
                            <select wire:model="fields.{{ $i }}.field_type" class="border rounded p-2">
                                @foreach ($fieldTypes as $type)
                                    <option value="{{ $type }}">{{ ucfirst($type) }}</option>
                                @endforeach
                            </select>
                        </div>

                        @if ($field['field_type'] === 'select')
                            <input type="text" wire:model="fields.{{ $i }}.options" placeholder="Pilihan, pisahkan dengan koma" class="w-full border rounded p-2">
                        @endif

                        <div class="flex gap-4 text-sm">
                            <label><input type="checkbox" wire:model="fields.{{ $i }}.is_required"> Wajib diisi</label>
                            <label><input type="checkbox" wire:model="fields.{{ $i }}.is_sensitive"> Data sensitif (foto KTP/KK dll)</label>
                        </div>

                        @if (count($fields) > 1)
                            <button type="button" wire:click="removeField({{ $i }})" class="text-red-500 text-sm">Hapus field</button>
                        @endif
                    </div>
                @endforeach
                <button type="button" wire:click="addField" class="text-blue-600 text-sm">+ Tambah field</button>
            </div>

            <div>
                <p class="font-medium mb-2">Tahapan persetujuan</p>
                @foreach ($approvalSteps as $i => $step)
                    <div wire:key="step-{{ $i }}" class="grid grid-cols-2 gap-2 mb-2">
                        <input type="text" wire:model="approvalSteps.{{ $i }}.nama_tahap" placeholder="Nama tahap (contoh: Verifikasi RT)" class="border rounded p-2">
                        <select wire:model="approvalSteps.{{ $i }}.role_id" class="border rounded p-2">
                            <option value="">-- Pilih peran --</option>
                            @foreach ($roles as $role)
                                <option value="{{ $role->id }}">{{ $role->name }}</option>
                            @endforeach
                        </select>
                    </div>
                @endforeach
                <button type="button" wire:click="addApprovalStep" class="text-blue-600 text-sm">+ Tambah tahap</button>
            </div>

            <div class="flex gap-2">
                <button wire:click="save" class="bg-blue-600 text-white px-4 py-2 rounded">Simpan Layanan</button>
                <button wire:click="$set('showForm', false)" class="text-gray-600 px-4 py-2">Batal</button>
            </div>
        </div>
    @endif
</div>
