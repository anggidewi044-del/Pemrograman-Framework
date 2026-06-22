<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Models\Registration;

class CertificateController extends Controller
{
    public function download(int $registrationId)
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        $registration = Registration::with('event')
            ->where('user_id', Auth::id())
            ->whereHas('event')
            ->findOrFail($registrationId);

        if ($registration->event->status !== 'selesai' || $registration->status !== 'hadir'
            || !$registration->certificate_token || !$registration->event->certificate_template_path
            || !$registration->event->certificate_generated_at) {
            return redirect()->route('participant.certificates')
                ->with('error', 'Sertifikat belum tersedia. Pastikan Anda hadir pada event.');
        }

        $pdf = Pdf::loadView('certificates.template', compact('registration'))
            ->setPaper('a4', 'landscape');

        $filename = 'Sertifikat_' . preg_replace('/[^A-Za-z0-9]/', '_', $registration->event->title) . '.pdf';

        return $pdf->download($filename);
    }
}
