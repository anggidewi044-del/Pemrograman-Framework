<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use App\Models\Event;
use App\Models\Registration;
use App\Models\EventFeedback;

class ParticipantController extends Controller
{
    protected function requireParticipant()
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        if (Auth::user()->isOrganizer()) {
            return redirect()->route('organizer.dashboard');
        }

        return null;
    }

    public function dashboard()
    {
        if ($redirect = $this->requireParticipant()) {
            return $redirect;
        }

        $events = Event::where('status', 'aktif')
            ->orderBy('date', 'asc')
            ->get();

        return view('participant.dashboard', compact('events'));
    }

    public function events(Request $request)
    {
        if ($redirect = $this->requireParticipant()) {
            return $redirect;
        }

        $query = Event::where('status', 'aktif');

        $category = $request->get('category', 'Semua');
        if ($category && $category !== 'Semua') {
            $query->where('category', $category);
        }

        $search = $request->get('search');
        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('speaker', 'like', "%{$search}%")
                  ->orWhere('location', 'like', "%{$search}%");
            });
        }

        $sort = $request->get('sort', 'Terbaru');
        if ($sort === 'Terbaru') {
            $query->orderBy('date', 'asc');
        } elseif ($sort === 'Terlama') {
            $query->orderBy('date', 'desc');
        } elseif ($sort === 'Harga Terendah') {
            $query->orderBy('price', 'asc');
        } elseif ($sort === 'Harga Tertinggi') {
            $query->orderBy('price', 'desc');
        } else {
            $query->orderBy('date', 'asc');
        }

        $events = $query->get();
        $categories = ['Semua', 'Workshop', 'Seminar', 'Webinar'];

        return view('participant.events', compact('events', 'categories', 'category', 'sort', 'search'));
    }

    public function eventDetail(int $id)
    {
        if ($redirect = $this->requireParticipant()) {
            return $redirect;
        }

        $event = Event::where('status', 'aktif')->findOrFail($id);
        $registration = Registration::where('event_id', $event->id)
            ->where('user_id', Auth::id())
            ->first();

        return view('participant.event-detail', compact('event', 'registration'));
    }

    public function registerEvent(Request $request, int $id)
    {
        if ($redirect = $this->requireParticipant()) {
            return $redirect;
        }

        $event = Event::findOrFail($id);

        if ($event->status !== 'aktif') {
            return back()->with('error', 'Event ini tidak tersedia untuk pendaftaran.');
        }

        $existing = Registration::where('event_id', $event->id)
            ->where('user_id', Auth::id())
            ->first();

        $isPaid = $event->price > 0;

        if ($isPaid) {
            $request->validate([
                'payment_proof' => 'required|image|max:2048',
            ], [
                'payment_proof.required' => 'Bukti pembayaran wajib diunggah untuk event berbayar.',
                'payment_proof.image' => 'Bukti pembayaran harus berupa gambar.',
            ]);
        }

        if ($existing) {
            if (!in_array($existing->status, ['menunggu_verifikasi_pembayaran', 'ditolak'])) {
                return back()->with('error', 'Anda sudah mendaftar di event ini.');
            }

            if ($isPaid && $request->hasFile('payment_proof')) {
                if ($existing->payment_proof_path) {
                    Storage::disk('public')->delete($existing->payment_proof_path);
                }
                $existing->payment_proof_path = $request->file('payment_proof')->store('payment_proofs', 'public');
                $existing->payment_amount = $event->price;
                $existing->status = 'menunggu_verifikasi_pembayaran';
                $existing->rejection_reason = null;
                $existing->save();
            }

            return redirect()->route('participant.tickets')->with('success', 'Bukti pembayaran berhasil diunggah ulang. Mohon tunggu verifikasi.');
        }

        if ($event->registrations()->pending()->count() + $event->registrations()->confirmed()->count() >= $event->quota_max) {
            return back()->with('error', 'Kuota event ini sudah penuh.');
        }

        $registrationData = [
            'event_id' => $event->id,
            'user_id' => Auth::id(),
            'name' => Auth::user()->name,
            'email' => Auth::user()->email,
            'status' => $isPaid ? 'menunggu_verifikasi_pembayaran' : 'menunggu_konfirmasi',
            'qr_code' => $event->isOffline ? (string) Str::uuid() : null,
        ];

        if ($isPaid && $request->hasFile('payment_proof')) {
            $registrationData['payment_proof_path'] = $request->file('payment_proof')->store('payment_proofs', 'public');
            $registrationData['payment_amount'] = $event->price;
        }

        Registration::create($registrationData);

        $message = $isPaid
            ? 'Pendaftaran berhasil. Mohon tunggu verifikasi pembayaran dari penyelenggara.'
            : 'Pendaftaran berhasil. Mohon tunggu konfirmasi dari penyelenggara.';

        return redirect()->route('participant.tickets')->with('success', $message);
    }

    public function myTickets(Request $request)
    {
        if ($redirect = $this->requireParticipant()) {
            return $redirect;
        }

        $tab = $request->get('tab', 'Semua');

        $query = Registration::with('event')
            ->where('user_id', Auth::id())
            ->whereHas('event');

        $search = trim((string) $request->get('search', ''));
        if ($search !== '') {
            $query->whereHas('event', function ($eventQuery) use ($search) {
                $eventQuery->where(function ($q) use ($search) {
                    $q->where('title', 'like', "%{$search}%")
                        ->orWhere('speaker', 'like', "%{$search}%")
                        ->orWhere('location', 'like', "%{$search}%");
                });
            });
        }

        if ($tab === 'Akan Datang') {
            $query->whereHas('event', function ($q) {
                $q->where('status', 'aktif');
            });
        } elseif ($tab === 'Selesai') {
            $query->whereHas('event', function ($q) {
                $q->where('status', 'selesai');
            });
        } elseif ($tab === 'Dibatalkan') {
            $query->where('status', 'ditolak');
        }

        $registrations = $query->get()->sortByDesc(function ($registration) {
            return $registration->event->date;
        });

        $tabs = ['Semua', 'Akan Datang', 'Selesai', 'Dibatalkan'];

        return view('participant.tickets', compact('registrations', 'tabs', 'tab', 'search'));
    }

    public function ticketDetail(int $registrationId)
    {
        if ($redirect = $this->requireParticipant()) {
            return $redirect;
        }

        $registration = Registration::with('event')
            ->where('user_id', Auth::id())
            ->whereHas('event')
            ->findOrFail($registrationId);

        if (!$registration->ticket_access_granted || !in_array($registration->status, ['terdaftar', 'hadir'])) {
            return redirect()->route('participant.tickets')->with('error', 'Tiket belum tersedia karena pendaftaran belum disetujui.');
        }

        // Menjamin tiket offline lama yang dibuat sebelum fitur QR tetap dapat dipindai.
        if ($registration->event->isOffline && blank($registration->qr_code)) {
            $registration->update(['qr_code' => (string) Str::uuid()]);
        }

        try {
            $eventDate = \Illuminate\Support\Carbon::parse($registration->event->date)->format('dM');
        } catch (\Throwable $e) {
            $eventDate = strtoupper(substr((string) $registration->event->date, 0, 5));
        }

        $ticketCode = 'TCKT - ' . strtoupper($eventDate) . ' - ' . str_pad($registration->id, 3, '0', STR_PAD_LEFT);

        $feedback = EventFeedback::where('registration_id', $registration->id)->first();

        return view('participant.ticket-detail', compact('registration', 'ticketCode', 'feedback'));
    }

    public function storeFeedback(Request $request, int $registrationId)
    {
        if ($redirect = $this->requireParticipant()) return $redirect;

        $registration = Registration::with('event')
            ->where('user_id', Auth::id())
            ->whereHas('event')
            ->findOrFail($registrationId);

        if (!$registration->ticket_access_granted
            || !in_array($registration->status, ['terdaftar', 'hadir'], true)) {
            return back()->with('error', 'Ulasan tersedia setelah pendaftaran Anda dikonfirmasi oleh penyelenggara.');
        }

        $data = $request->validate([
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'required|string|min:5|max:1000',
        ]);

        EventFeedback::updateOrCreate(
            ['event_id' => $registration->event_id, 'user_id' => Auth::id()],
            ['registration_id' => $registration->id, 'rating' => $data['rating'], 'comment' => $data['comment']]
        );

        return back()->with('success', 'Terima kasih. Ulasan Anda berhasil disimpan.');
    }

    public function onlineCheckIn(int $registrationId)
    {
        if ($redirect = $this->requireParticipant()) {
            return $redirect;
        }

        $registration = Registration::with('event')
            ->where('user_id', Auth::id())
            ->whereHas('event')
            ->findOrFail($registrationId);

        if (!$registration->event->isOnline) {
            return back()->with('error', 'Event offline hanya dapat check-in melalui pemindaian QR oleh penyelenggara.');
        }

        if ($registration->status === 'hadir') {
            return back()->with('info', 'Anda sudah melakukan check-in.');
        }

        if ($registration->status !== 'terdaftar' || !$registration->ticket_access_granted) {
            return back()->with('error', 'Pendaftaran Anda belum berstatus Terdaftar.');
        }

        if ($registration->event->status !== 'aktif' || !$registration->event->attendance_open) {
            return back()->with('error', 'Sesi presensi online belum dibuka oleh penyelenggara.');
        }

        $registration->update([
            'status' => 'hadir',
            'check_in_time' => now()->format('H:i'),
        ]);

        return back()->with('success', 'Check-in online berhasil. Kehadiran Anda telah tercatat.');
    }

    public function certificates(Request $request)
    {
        if ($redirect = $this->requireParticipant()) {
            return $redirect;
        }

        $tab = $request->get('tab', 'Semua');

        $query = Registration::with('event')
            ->where('user_id', Auth::id())
            ->whereHas('event');

        $search = trim((string) $request->get('search', ''));
        if ($search !== '') {
            $query->whereHas('event', function ($eventQuery) use ($search) {
                $eventQuery->where(function ($q) use ($search) {
                    $q->where('title', 'like', "%{$search}%")
                        ->orWhere('speaker', 'like', "%{$search}%")
                        ->orWhere('location', 'like', "%{$search}%");
                });
            });
        }

        if ($tab === 'Akan Datang') {
            $query->whereHas('event', function ($q) {
                $q->where('status', 'aktif');
            });
        } elseif ($tab === 'Selesai') {
            $query->whereHas('event', function ($q) {
                $q->where('status', 'selesai');
            });
        } elseif ($tab === 'Dibatalkan') {
            $query->where('status', 'ditolak');
        }

        $registrations = $query->get()->sortByDesc(function ($registration) {
            return $registration->event->date;
        });

        $tabs = ['Semua', 'Akan Datang', 'Selesai', 'Dibatalkan'];

        return view('participant.certificates', compact('registrations', 'tabs', 'tab', 'search'));
    }

    public function certificateDetail(int $registrationId)
    {
        if ($redirect = $this->requireParticipant()) {
            return $redirect;
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

        return view('participant.certificate-modal', compact('registration'));
    }
}
