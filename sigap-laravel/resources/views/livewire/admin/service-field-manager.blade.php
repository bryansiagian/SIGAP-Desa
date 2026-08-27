<div class="max-w-2xl mx-auto px-6 py-10">
    <a href="{{ route('admin.services') }}" wire:navigate class="text-sm text-soil/50 hover:text-soil mb-3 inline-block">
        &larr; Kembali ke daftar layanan
    </a>
    <h1 class="font-display text-2xl font-semibold mb-1">Kelola Field: {{ $serviceType->nama_layanan }}</h1>
    <p class="text-sm text-panen bg-panen/10 border border-panen/20 rounded-lg px-3 py-2 mt-3 mb-6">
        Perubahan di sini hanya berlaku untuk pengajuan baru. Data pengajuan yang sudah masuk sebelumnya tidak akan berubah.
    </p>

    @if (session('success'))
        <div class="bg-padi/10 text-padi border border-padi/20 p-3 rounded-lg mb-5 text-sm">{{ session('success') }}</div>
    @endif

    <div class="space-y-2 mb-4">
        @foreach ($fields as $i => $field)
            @if (! ($field['is_deleted'] ?? false))
                <x-ui.card wire:key="field-{{ $i }}" class="space-y-2">
                    <div class="grid grid-cols-2 gap-2">
                        <input type="text" wire:model="fields.{{ $i }}.label" placeholder="Nama field"
                            class="rounded-lg border border-soil/20 bg-white px-3 py-2 text-sm focus:border-clay focus:ring-1 focus:ring-clay outline-none">
                        <select wire:model="fields.{{ $i }}.field_type"
                            class="rounded-lg border border-soil/20 bg-white px-3 py-2 text-sm focus:border-clay focus:ring-1 focus:ring-clay outline-none">
                            @foreach ($fieldTypes as $type)
                                <option value="{{ $type }}">{{ ucfirst($type) }}</option>
                            @endforeach
                        </select>
                    </div>

                    @if ($field['field_type'] === 'select')
                        <input type="text" wire:model="fields.{{ $i }}.options" placeholder="Pilihan, pisahkan dengan koma"
                            class="w-full rounded-lg border border-soil/20 bg-white px-3 py-2 text-sm focus:border-clay focus:ring-1 focus:ring-clay outline-none">
                    @endif

                    <div class="flex gap-4 text-sm text-soil/70 items-center">
                        <label class="flex items-center gap-1.5"><input type="checkbox" wire:model="fields.{{ $i }}.is_required" class="rounded border-soil/30 text-clay focus:ring-clay"> Wajib diisi</label>
                        <label class="flex items-center gap-1.5"><input type="checkbox" wire:model="fields.{{ $i }}.is_sensitive" class="rounded border-soil/30 text-clay focus:ring-clay"> Data sensitif</label>
                        @if (! $field['is_new'])
                            <span class="text-xs text-soil/30 ms-auto">key: {{ $field['field_key'] }}</span>
                        @endif
                    </div>

                    <button type="button" wire:click="removeField({{ $i }})" class="text-red-700 text-xs font-medium">Hapus field</button>
                </x-ui.card>
            @endif
        @endforeach
    </div>

    <button type="button" wire:click="addField" class="text-clay text-sm font-medium mb-6 block">+ Tambah field baru</button>

    <x-ui.button variant="primary" wire:click="save">Simpan Perubahan</x-ui.button>
</div>
