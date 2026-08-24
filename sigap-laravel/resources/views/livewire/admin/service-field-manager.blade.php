<div class="max-w-2xl mx-auto p-6">
    <a href="{{ route('admin.services') }}" class="text-sm text-gray-500">&larr; Kembali ke daftar layanan</a>
    <h1 class="text-xl font-medium mt-2 mb-1">Kelola Field: {{ $serviceType->nama_layanan }}</h1>
    <p class="text-sm text-amber-600 mb-4">
        Perubahan di sini hanya berlaku untuk pengajuan baru. Data pengajuan yang sudah masuk sebelumnya tidak akan berubah.
    </p>

    @if (session('success'))
        <div class="bg-green-100 text-green-800 p-3 rounded mb-4">{{ session('success') }}</div>
    @endif

    @foreach ($fields as $i => $field)
        @if (! ($field['is_deleted'] ?? false))
            <div wire:key="field-{{ $i }}" class="border rounded p-3 mb-2 space-y-2">
                <div class="grid grid-cols-2 gap-2">
                    <input type="text" wire:model="fields.{{ $i }}.label" placeholder="Nama field" class="border rounded p-2">
                    <select wire:model="fields.{{ $i }}.field_type" class="border rounded p-2">
                        @foreach ($fieldTypes as $type)
                            <option value="{{ $type }}">{{ ucfirst($type) }}</option>
                        @endforeach
                    </select>
                </div>

                @if ($field['field_type'] === 'select')
                    <input type="text" wire:model="fields.{{ $i }}.options" placeholder="Pilihan, pisahkan dengan koma" class="w-full border rounded p-2">
                @endif

                <div class="flex gap-4 text-sm items-center">
                    <label><input type="checkbox" wire:model="fields.{{ $i }}.is_required"> Wajib diisi</label>
                    <label><input type="checkbox" wire:model="fields.{{ $i }}.is_sensitive"> Data sensitif</label>
                    @if (! $field['is_new'])
                        <span class="text-xs text-gray-400">key: {{ $field['field_key'] }}</span>
                    @endif
                </div>

                <button type="button" wire:click="removeField({{ $i }})" class="text-red-500 text-sm">Hapus field</button>
            </div>
        @endif
    @endforeach

    <button type="button" wire:click="addField" class="text-blue-600 text-sm mb-4 block">+ Tambah field baru</button>

    <button wire:click="save" class="bg-blue-600 text-white px-4 py-2 rounded">Simpan Perubahan</button>
</div>
