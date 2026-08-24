<?php

namespace App\Livewire\Warga;

use App\Models\ServiceType;
use App\Models\ServiceSubmission;
use App\Models\SubmissionFile;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\Attributes\Layout;

#[Layout('layouts.app')]
class ServiceSubmissionForm extends Component
{
    use WithFileUploads;

    public ServiceType $serviceType;
    public array $formData = [];
    public array $formFiles = [];

    public function mount(ServiceType $serviceType)
    {
        $this->serviceType = $serviceType->load('fields');

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
