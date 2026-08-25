<?php

namespace App\Livewire\Warga;

use App\Models\ServiceType;
use App\Models\ServiceSubmission;
use App\Models\SubmissionFile;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Livewire\WithFileUploads;

#[Layout('layouts.app')]
class ServiceSubmissionForm extends Component
{
    use WithFileUploads;

    public ServiceType $serviceType;
    public array $formData = [];
    public array $formFiles = [];
    public bool $isAvailable = true;
    public string $unavailableReason = '';

    public function mount(ServiceType $serviceType)
    {
        $this->serviceType = $serviceType->load(['fields', 'approvalSteps']);

        // Guard 1: layanan harus berstatus aktif
        if ($this->serviceType->status !== 'aktif') {
            $this->isAvailable = false;
            $this->unavailableReason = 'Layanan ini sedang tidak tersedia.';
            return;
        }

        // Guard 2: layanan harus punya minimal 1 tahap persetujuan
        if ($this->serviceType->approvalSteps->isEmpty()) {
            $this->isAvailable = false;
            $this->unavailableReason = 'Layanan ini belum bisa diajukan saat ini. Silakan hubungi admin desa.';
            return;
        }

        foreach ($this->serviceType->fields as $field) {
            if ($field->field_type !== 'file') {
                $this->formData[$field->field_key] = '';
            }
        }
    }

    protected function rules(): array
    {
        $rules = [];

        foreach ($this->serviceType->fields as $field) {
            $key = $field->field_type === 'file'
                ? "formFiles.{$field->field_key}"
                : "formData.{$field->field_key}";

            $rules[$key] = $field->validation_rule ?? ($field->is_required ? 'required' : 'nullable');
        }

        return $rules;
    }

    protected function validationAttributes(): array
    {
        return $this->serviceType->fields
            ->pluck('label', 'field_key')
            ->flatMap(fn ($label, $key) => [
                "formData.{$key}" => $label,
                "formFiles.{$key}" => $label,
            ])->toArray();
    }

    public function submit()
    {
        // Guard tambahan di submit() — jaga-jaga kalau ada yang akal-akalan
        // kirim request langsung tanpa lewat mount() (misal replay request lama)
        if (! $this->isAvailable) {
            abort(403, 'Layanan ini tidak tersedia untuk diajukan.');
        }

        if (! Auth::check()) {
            session()->put('url.intended', request()->fullUrl());
            return redirect()->route('login');
        }

        $this->validate();

        $submission = ServiceSubmission::create([
            'service_type_id' => $this->serviceType->id,
            'submitted_by' => Auth::id(),
            'data' => $this->formData,
            'fields_snapshot' => $this->serviceType->fields->toArray(),
            'current_step' => 1,
            'status' => 'diajukan',
        ]);

        foreach ($this->formFiles as $fieldKey => $file) {
            if (! $file) {
                continue;
            }

            $field = $this->serviceType->fields->firstWhere('field_key', $fieldKey);
            $disk = ($field?->is_sensitive ?? false) ? 'local' : 'public';

            $path = $file->store("submissions/{$this->serviceType->key}", $disk);

            SubmissionFile::create([
                'submission_id' => $submission->id,
                'field_key' => $fieldKey,
                'original_filename' => $file->getClientOriginalName(),
                'stored_path' => $path,
                'mime_type' => $file->getMimeType(),
                'size_kb' => round($file->getSize() / 1024),
            ]);

            $submission->update(['data' => array_merge($submission->data, [$fieldKey => $path])]);
        }

        session()->flash('success', 'Pengajuan berhasil dikirim.');

        return redirect()->route('submissions.mine');
    }

    public function render()
    {
        return view('livewire.warga.service-submission-form');
    }
}
