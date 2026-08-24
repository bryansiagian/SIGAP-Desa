<?php

namespace App\Livewire\Admin;

use App\Models\ServiceSubmission;
use App\Models\SubmissionApproval;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\Attributes\Layout;

#[Layout('layouts.app')]
class SubmissionList extends Component
{
    use WithPagination;

    public string $filterStatus = '';
    public ?int $selectedSubmissionId = null;
    public string $catatan = '';

    public function selectSubmission($id)
    {
        $this->selectedSubmissionId = $id;
        $this->catatan = '';
    }

    public function approve($id)
    {
        $this->processApproval($id, 'disetujui');
    }

    public function reject($id)
    {
        $this->processApproval($id, 'ditolak');
    }

    protected function processApproval($id, string $decision)
    {
        $submission = ServiceSubmission::with('serviceType.approvalSteps')->findOrFail($id);
        $currentStep = $submission->serviceType->approvalSteps
            ->firstWhere('urutan', $submission->current_step);

        if (! $currentStep) {
            return;
        }

        SubmissionApproval::create([
            'submission_id' => $submission->id,
            'step_id' => $currentStep->id,
            'approver_id' => Auth::id(),
            'status' => $decision,
            'catatan' => $this->catatan,
            'waktu' => now(),
        ]);

        if ($decision === 'ditolak') {
            $submission->update(['status' => 'ditolak']);
        } else {
            $totalSteps = $submission->serviceType->approvalSteps->count();

            if ($submission->current_step >= $totalSteps) {
                $submission->update(['status' => 'selesai']);
            } else {
                $submission->update([
                    'current_step' => $submission->current_step + 1,
                    'status' => 'diproses',
                ]);
            }
        }

        $this->selectedSubmissionId = null;
        $this->catatan = '';
    }

    public function render()
    {
        $submissions = ServiceSubmission::with('serviceType', 'submitter')
            ->when($this->filterStatus, fn ($q) => $q->where('status', $this->filterStatus))
            ->latest()
            ->paginate(10);

        $selected = $this->selectedSubmissionId
            ? ServiceSubmission::with('serviceType.approvalSteps.role', 'files')->find($this->selectedSubmissionId)
            : null;

        return view('livewire.admin.submission-list', compact('submissions', 'selected'));
    }
}
