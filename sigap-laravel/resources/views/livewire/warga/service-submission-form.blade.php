<div class="max-w-2xl mx-auto px-6 py-10">
    @if (! $isAvailable)
        <div class="text-center py-16">
            <h1 class="font-display text-xl font-semibold mb-2">{{ $serviceType->nama_layanan }}</h1>
            <p class="text-soil/60">{{ $unavailableReason }}</p>
            <a href="{{ route('service.index') }}" wire:navigate class="inline-block mt-4 text-clay text-sm font-medium">
                &larr; Lihat layanan lain
            </a>
        </div>
    @else
        <a href="{{ route('service.index') }}" wire:navigate class="text-sm text-soil/50 hover:text-soil mb-3 inline-block">
            &larr; Kembali ke daftar layanan
        </a>
        <h1 class="font-display text-2xl font-semibold mb-6">{{ $serviceType->nama_layanan }}</h1>

        @if (session('success'))
            <div class="bg-padi/10 text-padi border border-padi/20 p-3 rounded-lg mb-5 text-sm">{{ session('success') }}</div>
        @endif

        <x-ui.card>
            <form wire:submit="submit" class="space-y-5">
                @foreach ($serviceType->fields as $field)
                    <div wire:key="field-{{ $field->id }}">
                        <label class="block text-sm font-medium text-soil mb-1.5">
                            {{ $field->label }} @if ($field->is_required) <span class="text-clay">*</span> @endif
                        </label>

                        @switch($field->field_type)
                            @case('text')
                                <input type="text" wire:model="formData.{{ $field->field_key }}" class="w-full rounded-lg border border-soil/20 bg-white px-3 py-2.5 text-sm focus:border-clay focus:ring-1 focus:ring-clay outline-none transition">
                                @break
                            @case('number')
                                <input type="number" wire:model="formData.{{ $field->field_key }}" class="w-full rounded-lg border border-soil/20 bg-white px-3 py-2.5 text-sm focus:border-clay focus:ring-1 focus:ring-clay outline-none transition">
                                @break
                            @case('date')
                                <input type="date" wire:model="formData.{{ $field->field_key }}" class="w-full rounded-lg border border-soil/20 bg-white px-3 py-2.5 text-sm focus:border-clay focus:ring-1 focus:ring-clay outline-none transition">
                                @break
                            @case('textarea')
                                <textarea wire:model="formData.{{ $field->field_key }}" rows="3" class="w-full rounded-lg border border-soil/20 bg-white px-3 py-2.5 text-sm focus:border-clay focus:ring-1 focus:ring-clay outline-none transition"></textarea>
                                @break
                            @case('select')
                                <select wire:model="formData.{{ $field->field_key }}" class="w-full rounded-lg border border-soil/20 bg-white px-3 py-2.5 text-sm focus:border-clay focus:ring-1 focus:ring-clay outline-none transition">
                                    <option value="">-- Pilih --</option>
                                    @foreach (($field->options ?? []) as $option)
                                        <option value="{{ $option }}">{{ $option }}</option>
                                    @endforeach
                                </select>
                                @break
                            @case('file')
                                <label class="flex items-center justify-center gap-2 border border-dashed border-soil/25 rounded-lg px-3 py-4 text-sm text-soil/50 hover:border-clay/40 cursor-pointer transition">
                                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12" />
                                    </svg>
                                    <span>{{ ($formFiles[$field->field_key] ?? null) ? $formFiles[$field->field_key]->getClientOriginalName() : 'Pilih file' }}</span>
                                    <input type="file" wire:model="formFiles.{{ $field->field_key }}" class="hidden">
                                </label>
                                <div wire:loading wire:target="formFiles.{{ $field->field_key }}" class="text-xs text-soil/40 mt-1">Mengunggah...</div>
                                @break
                        @endswitch

                        @error('formData.' . $field->field_key) <p class="text-sm text-red-700 mt-1.5">{{ $message }}</p> @enderror
                        @error('formFiles.' . $field->field_key) <p class="text-sm text-red-700 mt-1.5">{{ $message }}</p> @enderror
                    </div>
                @endforeach

                <x-ui.button variant="primary" type="submit" class="w-full">
                    Ajukan
                </x-ui.button>
            </form>
        </x-ui.card>
    @endif
</div>
