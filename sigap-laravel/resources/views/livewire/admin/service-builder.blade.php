<div class="max-w-3xl mx-auto px-6 py-10">
    <div class="flex justify-between items-center mb-6">
        <div>
            <h1 class="font-display text-2xl font-semibold">Kelola Layanan</h1>
            <p class="text-soil/60 text-sm mt-0.5">Buat dan atur jenis layanan yang tersedia untuk warga</p>
        </div>
        <x-ui.button variant="primary" wire:click="openForm" wire:loading.attr="disabled" wire:target="openForm">
            <svg wire:loading wire:target="openForm" class="animate-spin h-4 w-4" fill="none" viewBox="0 0 24 24">
                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z"></path>
            </svg>
            <span wire:loading.remove wire:target="openForm">+ Layanan Baru</span>
            <span wire:loading wire:target="openForm">Membuka...</span>
        </x-ui.button>
    </div>

    {{-- Daftar layanan yang sudah ada --}}
    <div class="space-y-2 mb-8">
        @foreach ($serviceTypes as $type)
            <x-ui.card wire:key="type-{{ $type->id }}" class="flex justify-between items-center">
                <div>
                    <div class="flex items-center gap-2">
                        <p class="font-medium">{{ $type->nama_layanan }}</p>
                        @if ($type->is_builtin)
                            <span class="text-xs text-soil/40 border border-soil/15 rounded px-1.5 py-0.5">bawaan</span>
                        @endif
                    </div>
                    <p class="text-sm text-soil/50 mt-0.5">{{ $type->kategori ?? '—' }} · {{ $type->submissions_count }} pengajuan</p>
                </div>
                <div class="flex gap-4 items-center">
                    <a href="{{ route('admin.services.fields', $type->id) }}" wire:navigate class="text-sm text-clay font-medium">
                        Kelola field
                    </a>
                    <div class="flex items-center gap-2">
                        <span class="text-xs text-soil/50">{{ $type->status === 'aktif' ? 'Aktif' : 'Nonaktif' }}</span>
                        <x-ui.toggle
                            :on="$type->status === 'aktif'"
                            x-on:click="confirmAction('{{ $type->status === 'aktif' ? 'Nonaktifkan' : 'Aktifkan' }} layanan {{ addslashes($type->nama_layanan) }}?').then(ok => { if (ok) $wire.toggleStatus({{ $type->id }}) })"
                        />
                    </div>
                </div>
            </x-ui.card>
        @endforeach
    </div>

    {{-- Skeleton saat form sedang dibuka --}}
    <div wire:loading wire:target="openForm" class="animate-pulse space-y-4">
        <div class="h-6 bg-soil/10 rounded w-1/3"></div>
        <div class="h-10 bg-soil/10 rounded"></div>
        <div class="h-10 bg-soil/10 rounded w-2/3"></div>
    </div>

    {{-- Wizard buat layanan baru --}}
    @if ($showForm)
        <x-ui.card class="space-y-6" wire:loading.class="opacity-50" wire:target="save">
            <div class="flex justify-between items-start">
                <h2 class="font-display font-semibold">Layanan Baru</h2>
                <button type="button" wire:click="closeForm" class="text-soil/40 hover:text-soil text-sm">Batal</button>
            </div>

            <div>
                <label class="block text-sm font-medium text-soil mb-1.5">Nama layanan</label>
                <input type="text" wire:model="nama_layanan" placeholder="Contoh: Surat Pengantar KTP"
                    class="w-full rounded-lg border border-soil/20 bg-white px-3 py-2.5 text-sm focus:border-clay focus:ring-1 focus:ring-clay outline-none transition">
                @error('nama_layanan') <p class="text-sm text-red-700 mt-1.5">{{ $message }}</p> @enderror

                <label class="block text-sm font-medium text-soil mb-1.5 mt-4">Kategori (opsional)</label>
                <input type="text" wire:model="kategori" placeholder="Contoh: Administrasi"
                    class="w-full rounded-lg border border-soil/20 bg-white px-3 py-2.5 text-sm focus:border-clay focus:ring-1 focus:ring-clay outline-none transition">
            </div>

            <div>
                <p class="font-medium text-sm mb-3">Data yang perlu diisi warga</p>
                <div class="space-y-2">
                    @foreach ($fields as $i => $field)
                        <div wire:key="field-{{ $i }}" class="border border-soil/10 rounded-lg p-3 space-y-2 bg-paper/40">
                            <div class="grid grid-cols-2 gap-2">
                                <input type="text" wire:model="fields.{{ $i }}.label" placeholder="Nama field (contoh: NIK)"
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

                            <div class="flex gap-4 text-sm text-soil/70">
                                <label class="flex items-center gap-1.5"><input type="checkbox" wire:model="fields.{{ $i }}.is_required" class="rounded border-soil/30 text-clay focus:ring-clay"> Wajib diisi</label>
                                <label class="flex items-center gap-1.5"><input type="checkbox" wire:model="fields.{{ $i }}.is_sensitive" class="rounded border-soil/30 text-clay focus:ring-clay"> Data sensitif</label>
                            </div>

                            @if (count($fields) > 1)
                                <button type="button" wire:click="removeField({{ $i }})" class="text-red-700 text-xs font-medium">Hapus field</button>
                            @endif
                        </div>
                    @endforeach

                    {{-- Skeleton saat field baru sedang ditambahkan --}}
                    <div wire:loading wire:target="addField" class="w-full border border-soil/10 rounded-lg p-3 bg-paper/40 animate-pulse">
                        <div class="w-full grid grid-cols-2 gap-2 mb-2">
                            <div class="h-10 w-full bg-soil/10 rounded-lg"></div>
                            <div class="h-10 w-full bg-soil/10 rounded-lg"></div>
                        </div>
                        <div class="flex gap-4 mb-2">
                            <div class="h-4 w-24 bg-soil/10 rounded"></div>
                            <div class="h-4 w-24 bg-soil/10 rounded"></div>
                        </div>
                        <div class="h-3 w-16 bg-soil/10 rounded"></div>
                    </div>
                </div>
                <button type="button" wire:click="addField" wire:loading.attr="disabled" wire:target="addField" class="text-clay text-sm font-medium mt-3 disabled:opacity-50">
                    + Tambah field
                </button>
            </div>

            <div>
                <p class="font-medium text-sm mb-3">Tahapan persetujuan</p>
                <div class="space-y-2">
                    @foreach ($approvalSteps as $i => $step)
                        <div wire:key="step-{{ $i }}" class="grid grid-cols-2 gap-2">
                            <input type="text" wire:model="approvalSteps.{{ $i }}.nama_tahap" placeholder="Nama tahap (contoh: Verifikasi RT)"
                                class="rounded-lg border border-soil/20 bg-white px-3 py-2 text-sm focus:border-clay focus:ring-1 focus:ring-clay outline-none">
                            <select wire:model="approvalSteps.{{ $i }}.role_id"
                                class="rounded-lg border border-soil/20 bg-white px-3 py-2 text-sm focus:border-clay focus:ring-1 focus:ring-clay outline-none">
                                <option value="">-- Pilih peran --</option>
                                @foreach ($roles as $role)
                                    <option value="{{ $role->id }}">{{ $role->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    @endforeach

                    {{-- Skeleton saat tahap baru sedang ditambahkan --}}
                    <div wire:loading wire:target="addApprovalStep" class="w-full grid grid-cols-2 gap-2 animate-pulse">
                        <div class="h-10 w-full bg-soil/10 rounded-lg"></div>
                    </div>
                </div>
                <button type="button" wire:click="addApprovalStep" wire:loading.attr="disabled" wire:target="addApprovalStep" class="text-clay text-sm font-medium mt-3 disabled:opacity-50">
                    + Tambah tahap
                </button>
            </div>

            <div class="flex gap-2 pt-2 border-t border-soil/10">
                <button type="button"
                    x-on:click="confirmAction('Simpan layanan \'' + $wire.nama_layanan + '\' dengan ' + $wire.fields.length + ' field dan ' + $wire.approvalSteps.length + ' tahap persetujuan?', 'Ya, simpan').then(ok => { if (ok) $wire.save() })"
                    wire:loading.attr="disabled" wire:target="save"
                    class="inline-flex items-center justify-center gap-2 rounded-lg bg-clay px-4 py-2.5 text-sm font-medium text-white hover:bg-clay/90 transition disabled:opacity-50">
                    <svg wire:loading wire:target="save" class="animate-spin h-4 w-4" fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z"></path>
                    </svg>
                    <span wire:loading.remove wire:target="save">Simpan Layanan</span>
                    <span wire:loading wire:target="save">Menyimpan...</span>
                </button>
                <x-ui.button variant="ghost" wire:click="closeForm">Batal</x-ui.button>
            </div>
        </x-ui.card>
    @endif
</div>
