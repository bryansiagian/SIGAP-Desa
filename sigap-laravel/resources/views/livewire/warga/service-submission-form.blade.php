<div class="max-w-2xl mx-auto p-6">
    @if (! $isAvailable)
        <div class="text-center py-12">
            <h1 class="text-xl font-medium mb-2">{{ $serviceType->nama_layanan }}</h1>
            <p class="text-gray-500">{{ $unavailableReason }}</p>
            <a href="{{ route('service.index') }}" wire:navigate class="inline-block mt-4 text-blue-600 text-sm">
                &larr; Lihat layanan lain
            </a>
        </div>
    @else
        <h1 class="text-xl font-medium mb-4">{{ $serviceType->nama_layanan }}</h1>

        @if (session('success'))
            <div class="bg-green-100 text-green-800 p-3 rounded mb-4">{{ session('success') }}</div>
        @endif

        <form wire:submit="submit" class="space-y-4">
            @foreach ($serviceType->fields as $field)
                <div wire:key="field-{{ $field->id }}">
                    <label class="block text-sm font-medium mb-1">
                        {{ $field->label }} @if ($field->is_required) <span class="text-red-500">*</span> @endif
                    </label>

                    @switch($field->field_type)
                        @case('text')
                            <input type="text" wire:model="formData.{{ $field->field_key }}" class="w-full border rounded p-2">
                            @break
                        @case('number')
                            <input type="number" wire:model="formData.{{ $field->field_key }}" class="w-full border rounded p-2">
                            @break
                        @case('date')
                            <input type="date" wire:model="formData.{{ $field->field_key }}" class="w-full border rounded p-2">
                            @break
                        @case('textarea')
                            <textarea wire:model="formData.{{ $field->field_key }}" rows="3" class="w-full border rounded p-2"></textarea>
                            @break
                        @case('select')
                            <select wire:model="formData.{{ $field->field_key }}" class="w-full border rounded p-2">
                                <option value="">-- Pilih --</option>
                                @foreach (($field->options ?? []) as $option)
                                    <option value="{{ $option }}">{{ $option }}</option>
                                @endforeach
                            </select>
                            @break
                        @case('file')
                            <input type="file" wire:model="formFiles.{{ $field->field_key }}" class="w-full border rounded p-2">
                            <div wire:loading wire:target="formFiles.{{ $field->field_key }}" class="text-sm text-gray-500">Mengunggah...</div>
                            @if ($formFiles[$field->field_key] ?? false)
                                <span class="text-sm text-gray-600">{{ $formFiles[$field->field_key]->getClientOriginalName() }}</span>
                            @endif
                            @break
                    @endswitch

                    @error('formData.' . $field->field_key) <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
                    @error('formFiles.' . $field->field_key) <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
                </div>
            @endforeach

            <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded">
                Ajukan
            </button>
        </form>
    @endif
</div>
