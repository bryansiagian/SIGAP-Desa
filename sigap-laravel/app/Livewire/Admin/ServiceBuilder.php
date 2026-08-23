<?php

namespace App\Livewire\Admin;

use App\Models\ServiceType;
use App\Models\ServiceField;
use App\Models\ServiceApprovalStep;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class ServiceBuilder extends Component
{
    public $serviceTypes;

    // form state
    public string $nama_layanan = '';
    public string $kategori = '';
    public array $fields = [];
    public array $approvalSteps = [];

    public bool $showForm = false;

    protected array $fieldTypes = ['text', 'number', 'date', 'select', 'file', 'textarea'];

    public function mount()
    {
        $this->loadServiceTypes();
        $this->addField();
        $this->addApprovalStep();
    }

    public function loadServiceTypes()
    {
        $this->serviceTypes = ServiceType::withCount('submissions')->latest()->get();
    }

    public function addField()
    {
        $this->fields[] = [
            'field_key' => '',
            'label' => '',
            'field_type' => 'text',
            'options' => '',
            'is_required' => true,
            'is_sensitive' => false,
        ];
    }

    public function removeField($index)
    {
        unset($this->fields[$index]);
        $this->fields = array_values($this->fields);
    }

    public function addApprovalStep()
    {
        $this->approvalSteps[] = ['nama_tahap' => '', 'role_id' => ''];
    }

    public function removeApprovalStep($index)
    {
        unset($this->approvalSteps[$index]);
        $this->approvalSteps = array_values($this->approvalSteps);
    }

    protected function rules(): array
    {
        return [
            'nama_layanan' => 'required|string|max:150',
            'kategori' => 'nullable|string|max:100',
            'fields.*.label' => 'required|string|max:150',
            'fields.*.field_type' => 'required|in:' . implode(',', $this->fieldTypes),
            'approvalSteps.*.nama_tahap' => 'required|string|max:100',
            'approvalSteps.*.role_id' => 'required|exists:roles,id',
        ];
    }

    public function save()
    {
        $this->validate();

        $serviceType = ServiceType::create([
            'key' => \Str::slug($this->nama_layanan, '_'),
            'nama_layanan' => $this->nama_layanan,
            'kategori' => $this->kategori,
            'is_builtin' => false,
            'status' => 'aktif',
            'dibuat_oleh' => Auth::id(),
        ]);

        foreach ($this->fields as $i => $field) {
            ServiceField::create([
                'service_type_id' => $serviceType->id,
                'field_key' => \Str::slug($field['label'], '_'),
                'label' => $field['label'],
                'field_type' => $field['field_type'],
                'options' => $field['field_type'] === 'select'
                    ? array_map('trim', explode(',', $field['options']))
                    : null,
                'is_required' => $field['is_required'],
                'is_sensitive' => $field['is_sensitive'],
                'urutan' => $i + 1,
            ]);
        }

        foreach ($this->approvalSteps as $i => $step) {
            ServiceApprovalStep::create([
                'service_type_id' => $serviceType->id,
                'urutan' => $i + 1,
                'nama_tahap' => $step['nama_tahap'],
                'role_id' => $step['role_id'],
            ]);
        }

        session()->flash('success', "Layanan \"{$this->nama_layanan}\" berhasil dibuat.");
        $this->reset(['nama_layanan', 'kategori', 'fields', 'approvalSteps', 'showForm']);
        $this->addField();
        $this->addApprovalStep();
        $this->loadServiceTypes();
    }

    public function toggleStatus(ServiceType $serviceType)
    {
        $serviceType->update([
            'status' => $serviceType->status === 'aktif' ? 'nonaktif' : 'aktif',
        ]);
        $this->loadServiceTypes();
    }

    public function render()
    {
        return view('livewire.admin.service-builder', [
            'roles' => \Spatie\Permission\Models\Role::all(),
            'fieldTypes' => $this->fieldTypes,
        ]);
    }
}
