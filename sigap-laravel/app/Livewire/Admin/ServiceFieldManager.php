<?php

namespace App\Livewire\Admin;

use App\Models\ServiceType;
use App\Models\ServiceField;
use Livewire\Component;
use Livewire\Attributes\Layout;

#[Layout('layouts.app')]
class ServiceFieldManager extends Component
{
    public ServiceType $serviceType;
    public array $fields = [];

    protected array $fieldTypes = ['text', 'number', 'date', 'select', 'file', 'textarea'];

    public function mount(ServiceType $serviceType)
    {
        $this->serviceType = $serviceType;
        $this->loadFields();
    }

    public function loadFields()
    {
        $this->fields = $this->serviceType->fields()
            ->orderBy('urutan')
            ->get()
            ->map(fn ($f) => [
                'id' => $f->id,
                'field_key' => $f->field_key,
                'label' => $f->label,
                'field_type' => $f->field_type,
                'options' => is_array($f->options) ? implode(', ', $f->options) : '',
                'is_required' => $f->is_required,
                'is_sensitive' => $f->is_sensitive,
                'is_new' => false,
            ])->toArray();
    }

    public function addField()
    {
        $this->fields[] = [
            'id' => null,
            'field_key' => '',
            'label' => '',
            'field_type' => 'text',
            'options' => '',
            'is_required' => true,
            'is_sensitive' => false,
            'is_new' => true,
        ];
    }

    public function removeField($index)
    {
        $field = $this->fields[$index];

        // Field lama yang sudah pernah dipakai warga tidak dihapus fisik,
        // cukup ditandai untuk dihapus saat save() — supaya data submission lama tetap aman
        // karena fields_snapshot sudah menyimpan salinannya sendiri.
        if (! $field['is_new'] && $field['id']) {
            $this->fields[$index]['is_deleted'] = true;
            return;
        }

        unset($this->fields[$index]);
        $this->fields = array_values($this->fields);
    }

    protected function rules(): array
    {
        return [
            'fields.*.label' => 'required|string|max:150',
            'fields.*.field_type' => 'required|in:' . implode(',', $this->fieldTypes),
        ];
    }

    public function save()
    {
        $this->validate();

        foreach ($this->fields as $i => $field) {
            if ($field['is_deleted'] ?? false) {
                ServiceField::find($field['id'])?->delete();
                continue;
            }

            $payload = [
                'label' => $field['label'],
                'field_type' => $field['field_type'],
                'options' => $field['field_type'] === 'select'
                    ? array_map('trim', explode(',', $field['options']))
                    : null,
                'is_required' => $field['is_required'],
                'is_sensitive' => $field['is_sensitive'],
                'urutan' => $i + 1,
            ];

            if ($field['is_new']) {
                ServiceField::create(array_merge($payload, [
                    'service_type_id' => $this->serviceType->id,
                    'field_key' => \Str::slug($field['label'], '_'),
                ]));
            } else {
                ServiceField::find($field['id'])?->update($payload);
            }
        }

        $this->dispatch('toast', message: 'Perubahan field berhasil disimpan.', type: 'success');
        $this->loadFields();
    }

    public function render()
    {
        return view('livewire.admin.service-field-manager', [
            'fieldTypes' => $this->fieldTypes,
        ]);
    }
}
