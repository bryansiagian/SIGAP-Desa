<?php

namespace App\Livewire\Admin;

use App\Models\ServiceSubmission;
use App\Models\SubmissionApproval;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Livewire\WithPagination;

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
        $submission = ServiceSubmission::with('serviceType.approvalSteps.role')->findOrFail($id);

        if (in_array($submission->status, ['selesai', 'ditolak'])) {
            $this->selectedSubmissionId = null;
            return;
        }

        $currentStep = $submission->serviceType->approvalSteps
            ->firstWhere('urutan', $submission->current_step);

        if (! $currentStep) {
            return;
        }

        // Guard utama: user yang login HARUS punya role yang sesuai tahap ini.
        // Ini pertahanan di server, bukan cuma sembunyikan tombol di UI —
        // supaya tidak bisa diakali walau request dikirim manual.
        if (! Auth::user()->hasRole($currentStep->role->name)) {
            abort(403, 'Anda tidak berwenang memproses tahap ini.');
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
                $submission->update([
                    'status' => 'selesai',
                    'nomor_surat' => $this->generateNomorSurat($submission),
                ]);
            } else {
                $submission->update([
                    'current_step' => $submission->current_step + 1,
                    'status' => 'diproses',
                ]);
            }
        }
<<<<<<< HEAD

=======
        
>>>>>>> 3a4fc538fd139f03e6dcde301c8d0a5f5809f818
        $this->dispatch('toast',
            message: $decision === 'disetujui' ? 'Pengajuan disetujui.' : 'Pengajuan ditolak.',
            type: $decision === 'disetujui' ? 'success' : 'error'
        );
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
            ? ServiceSubmission::with([
                'serviceType.approvalSteps.role',
                'files',
                'approvals.approver',
                'approvals.step',
            ])->find($this->selectedSubmissionId)
            : null;

        // Tentukan apakah user yang login boleh bertindak di tahap SAAT INI
        $canAct = false;
        if ($selected && ! in_array($selected->status, ['selesai', 'ditolak'])) {
            $currentStep = $selected->serviceType->approvalSteps
                ->firstWhere('urutan', $selected->current_step);

            $canAct = $currentStep && Auth::user()->hasRole($currentStep->role->name);
        }

        return view('livewire.admin.submission-list', compact('submissions', 'selected', 'canAct'));
    }

    protected function generateNomorSurat(ServiceSubmission $submission): string
    {
        return sprintf(
            '%03d/%s/%s',
            $submission->id,
            strtoupper(substr($submission->serviceType->key, 0, 3)),
            now()->format('m/Y')
        );
    }
}
