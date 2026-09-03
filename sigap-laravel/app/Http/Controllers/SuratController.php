<?php

namespace App\Http\Controllers;

use App\Models\ServiceSubmission;
use Illuminate\Support\Facades\Auth;
use Barryvdh\DomPDF\Facade\Pdf;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class SuratController extends Controller
{
    public function download(ServiceSubmission $submission)
    {
        $this->authorizeAccess($submission);

        abort_unless($submission->status === 'selesai', 404, 'Surat belum tersedia — pengajuan belum selesai diproses.');

        // Fallback: data lama yang selesai sebelum fitur nomor surat ditambahkan
        if (! $submission->nomor_surat) {
            $submission->update(['nomor_surat' => $this->generateNomorSurat($submission)]);
        }

        $verifyUrl = route('submissions.verify', [
            'submission' => $submission->id,
            'hash' => $this->hash($submission),
        ]);

        $qrSvg = QrCode::format('svg')->size(150)->margin(0)->generate($verifyUrl);

        $pdf = Pdf::loadView('pdf.surat', [
            'submission' => $submission,
            'qrSvg' => $qrSvg,
        ]);

        return $pdf->download("surat-{$submission->serviceType->key}-{$submission->nomor_surat}.pdf");
    }

    public function verify(ServiceSubmission $submission, string $hash)
    {
        abort_unless(hash_equals($this->hash($submission), $hash), 404);

        return view('pdf.verify', ['submission' => $submission]);
    }

    protected function authorizeAccess(ServiceSubmission $submission): void
    {
        $user = Auth::user();

        abort_unless(
            $submission->submitted_by === $user->id || $user->hasAnyRole(['admin', 'staf', 'verifikator']),
            403
        );
    }

    protected function generateNomorSurat(ServiceSubmission $submission): string
    {
        return sprintf(
            '%03d/%s/%s',
            $submission->id,
            strtoupper(substr($submission->serviceType->key, 0, 3)),
            $submission->updated_at->format('m/Y')
        );
    }

    protected function hash(ServiceSubmission $submission): string
    {
        return substr(hash_hmac('sha256', $submission->id . $submission->nomor_surat, config('app.key')), 0, 16);
    }
}
