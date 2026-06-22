<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Event;
use App\Models\Registration;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use App\Models\User;

class OrganizerController extends Controller
{
    private function ownedEvent(int $id, array $with = []): Event
    {
        return Event::with($with)
            ->where('organizer_id', Auth::id())
            ->findOrFail($id);
    }

    public function showLogin()
    {
        if (Auth::check()) {
            return $this->redirectBasedOnRole();
        }
        return view('auth.login');
    }

    public function showRegister()
    {
        if (Auth::check()) {
            return $this->redirectBasedOnRole();
        }

        return view('auth.register');
    }

    protected function redirectBasedOnRole()
    {
        if (Auth::user()->isOrganizer()) {
            return redirect()->route('organizer.dashboard');
        }

        return redirect()->route('participant.dashboard');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            return $this->redirectBasedOnRole();
        }

        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ])->onlyInput('email');
    }

    public function register(Request $request)
    {
        if (Auth::check()) {
            return redirect()->route('organizer.dashboard');
        }

        $data = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email',
            'password' => [
                'required',
                'string',
                'min:8',
                'regex:/[A-Za-z]/',
                'regex:/[0-9]/',
                'regex:/[^A-Za-z0-9]/',
            ],
        ], [
            'password.regex' => 'Password harus berisi huruf, angka, dan simbol.',
        ]);

        $user = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            'role' => 'participant',
        ]);

        Auth::login($user);
        $request->session()->regenerate();

        return redirect()->route('participant.dashboard')->with('success', 'Akun berhasil dibuat. Selamat datang di EventRize!');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('login');
    }

    public function dashboard(Request $request)
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        $events = Event::with('registrations')->where('organizer_id', Auth::id())->orderBy('date', 'asc')->get();
        $upcomingEvents = $events
            ->where('status', 'aktif')
            ->filter(function ($event) {
                try {
                    return Carbon::parse($event->date)->endOfDay()->gte(today());
                } catch (\Throwable $exception) {
                    return true;
                }
            })
            ->sortBy('date')
            ->take(3)
            ->values();
        $certificateEvents = $events->where('status', 'selesai')->values();
        $selectedCertificateEvent = $request->filled('certificate_event')
            ? $certificateEvents->firstWhere('id', (int) $request->get('certificate_event'))
            : null;

        // Calculate statistics
        $eventActiveCount = $events->where('status', 'aktif')->count();
        $totalParticipants = $events->sum(fn ($event) => $event->registrations->whereIn('status', ['terdaftar', 'hadir'])->count());

        $totalRevenue = 0;
        foreach ($events as $event) {
            if ($event->price > 0) {
                $totalRevenue += $event->revenue();
            }
        }
        $revenue = number_format($totalRevenue, 0, ',', '.');

        $confirmedRegistrations = $totalParticipants;
        $attendedRegistrations = $events->sum(fn ($event) => $event->registrations->where('status', 'hadir')->count());
        $attendanceRate = $confirmedRegistrations > 0
            ? round(($attendedRegistrations / $confirmedRegistrations) * 100, 1)
            : 0;

        $recentActivities = collect();

        foreach ($events as $event) {
            $recentActivities->push([
                'title' => 'Event Dibuat',
                'description' => $event->title . ' ditambahkan sebagai ' . ucfirst($event->status) . '.',
                'occurred_at' => $event->created_at,
                'type' => 'info',
            ]);

            if ($event->published_at) {
                $recentActivities->push([
                    'title' => 'Event Dipublikasikan',
                    'description' => $event->title . ' sudah aktif dan dapat diikuti peserta.',
                    'occurred_at' => $event->published_at,
                    'type' => 'success',
                ]);
            }

            if ($event->completed_at) {
                $recentActivities->push([
                    'title' => 'Event Selesai',
                    'description' => $event->title . ' telah ditandai selesai.',
                    'occurred_at' => $event->completed_at,
                    'type' => 'success',
                ]);
            }

            foreach ($event->registrations as $registration) {
                $recentActivities->push([
                    'title' => 'Pendaftaran Baru',
                    'description' => $registration->name . ' mendaftar ke ' . $event->title . '.',
                    'occurred_at' => $registration->created_at,
                    'type' => 'info',
                ]);

                if ($registration->payment_verified_at) {
                    $recentActivities->push([
                        'title' => 'Pembayaran Terverifikasi',
                        'description' => 'Pembayaran ' . $registration->name . ' untuk ' . $event->title . ' dikonfirmasi.',
                        'occurred_at' => $registration->payment_verified_at,
                        'type' => 'success',
                    ]);
                }
            }
        }

        $recentActivities = $recentActivities
            ->filter(fn ($activity) => $activity['occurred_at'])
            ->sortByDesc('occurred_at')
            ->take(5)
            ->map(function ($activity) {
                $activity['time'] = Carbon::parse($activity['occurred_at'])->locale('id')->diffForHumans();
                unset($activity['occurred_at']);
                return $activity;
            })
            ->values();

        return view('organizer.dashboard', compact(
            'events',
            'upcomingEvents',
            'eventActiveCount',
            'totalParticipants',
            'revenue',
            'attendanceRate',
            'recentActivities'
            ,'certificateEvents'
            ,'selectedCertificateEvent'
        ));
    }

    public function analytics(Request $request, int $id)
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        $event = $this->ownedEvent($id, ['registrations', 'feedbacks.user']);

        if ($event->status !== 'selesai') {
            abort(404);
        }

        $totalRegistrants = $event->registrations->count();
        $approvedCount = $event->registrations->whereIn('status', ['terdaftar', 'hadir'])->count();
        $attendedCount = $event->registrations->where('status', 'hadir')->count();
        $attendanceRate = $approvedCount > 0
            ? round(($attendedCount / $approvedCount) * 100, 1)
            : 0;
        $quotaUsage = $event->quota_max > 0
            ? round((min($approvedCount, $event->quota_max) / $event->quota_max) * 100, 1)
            : 0;
        $revenue = $event->revenue();

        if ($request->ajax() || $request->wantsJson()) {
            return response()->json([
                'total_registrants' => $totalRegistrants,
                'approved_count' => $approvedCount,
                'attended_count' => $attendedCount,
                'attendance_rate' => $attendanceRate,
                'quota_usage' => $quotaUsage,
                'revenue' => $revenue,
                'feedbacks' => $event->feedbacks->map(fn ($feedback) => [
                    'name' => $feedback->user?->name ?? 'Peserta',
                    'rating' => $feedback->rating,
                    'comment' => $feedback->comment,
                    'date' => $feedback->created_at->format('d M Y'),
                ])->values(),
            ]);
        }

        return view('organizer.dashboard', compact(
            'event',
            'totalRegistrants',
            'approvedCount',
            'attendedCount',
            'attendanceRate',
            'quotaUsage',
            'revenue'
        ));
    }

    public function storeEvent(Request $request)
    {
        if (!Auth::check()) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        // Harga yang tidak diisi berarti event gratis. Normalisasi sebelum
        // validasi agar nilai 0 tetap dikirim dengan konsisten dari semua klien.
        if (!$request->filled('price')) {
            $request->merge(['price' => 0]);
        }

        $data = $request->validate([
            'id' => 'nullable|integer',
            'title' => 'required|string|max:255',
            'speaker' => 'required|string|max:255',
            'category' => 'required|string|in:Workshop,Seminar,Webinar',
            'date' => 'required',
            'time' => 'required|string|max:50',
            'event_type' => 'required|string|in:offline,online',
            'location' => 'required_if:event_type,offline|nullable|string|max:255',
            'zoom_link' => 'required_if:event_type,online|nullable|url|max:500',
            'zoom_info' => 'nullable|string|max:500',
            'description' => 'nullable|string',
            'materi' => 'nullable|string',
            'quota_max' => 'required|integer|min:1',
            'quota_used' => 'nullable|integer',
            'price' => 'required|integer|min:0',
            'contact_phone' => 'nullable|string|max:20',
            'flyer' => 'nullable|image|max:2048',
        ], [
            'location.required_if' => 'Lokasi wajib diisi untuk event offline.',
            'zoom_link.required_if' => 'Link Zoom wajib diisi untuk event online.',
        ]);

        if ($request->hasFile('flyer')) {
            $data['flyer_path'] = $request->file('flyer')->store('flyers', 'public');
        }
        unset($data['flyer']);

        if (empty($data['quota_used'])) {
            $data['quota_used'] = 0;
        }

        if (!empty($data['id'])) {
            $event = $this->ownedEvent((int) $data['id']);
            if ($event->status !== 'draft') {
                return back()->with('error', 'Hanya event berstatus Draft yang dapat diedit.');
            }
            if (!empty($data['flyer_path']) && $event->flyer_path) {
                Storage::disk('public')->delete($event->flyer_path);
            }
            $data['status'] = 'draft';
            $event->update($data);
        } else {
            $data['organizer_id'] = Auth::id();
            $data['status'] = 'draft';
            Event::create($data);
        }

        return redirect()->to(route('organizer.dashboard') . '#events')->with('success', 'Event saved successfully.');
    }

    public function attendance(int $id)
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        $event = $this->ownedEvent($id, ['registrations' => function ($query) {
            $query->orderBy('name');
        }]);

        $registrations = $event->registrations;
        $participantCount = max($event->quota_max, $registrations->count());
        $presentCount = $registrations->where('status', 'hadir')->count();
        $absentCount = max(0, $participantCount - $presentCount);
        $formattedDate = Carbon::parse($event->date)->translatedFormat('d M, Y');

        return view('organizer.presensi', compact('event', 'registrations', 'participantCount', 'presentCount', 'absentCount', 'formattedDate'));
    }

    public function manualCheckin(Request $request, int $id)
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        $event = $this->ownedEvent($id);

        if ($event->status !== 'aktif' || !$event->attendance_open) {
            return back()->with('error', 'Sesi presensi belum dibuka atau event tidak aktif.');
        }

        if (!$event->isOffline) {
            return back()->with('error', 'Peserta event online melakukan check-in melalui akun masing-masing.');
        }

        $data = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'check_in_date' => 'nullable|date',
            'check_in_time' => 'nullable|string|max:20',
        ]);

        $registration = Registration::where([
            'event_id' => $event->id,
            'email' => $data['email'],
        ])->first();

        if (!$registration || $registration->status !== 'terdaftar') {
            return back()->with('error', 'Peserta harus berstatus Terdaftar sebelum dapat melakukan presensi.');
        }

        $registration->name = $data['name'];
        $registration->status = 'hadir';
        $registration->check_in_time = $data['check_in_time'] ?? now()->format('H:i');
        $registration->save();

        return redirect()->route('organizer.events.attendance', $event->id)->with('success', 'Presensi manual berhasil dicatat.');
    }

    public function exportAttendance(int $id)
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        $event = $this->ownedEvent($id, ['registrations' => function ($query) {
            $query->orderBy('name');
        }]);

        $filename = Str::slug($event->title) . '-presensi.csv';

        return response()->streamDownload(function () use ($event) {
            $output = fopen('php://output', 'w');
            fputcsv($output, ['No', 'Nama Peserta', 'Email', 'Waktu Presensi', 'Status']);

            foreach ($event->registrations as $index => $registration) {
                fputcsv($output, [
                    $index + 1,
                    $registration->name,
                    $registration->email,
                    $registration->check_in_time ?: '-',
                    $registration->status === 'hadir' ? 'Present' : ucfirst($registration->status),
                ]);
            }

            fclose($output);
        }, $filename, [
            'Content-Type' => 'text/csv',
        ]);
    }

    public function registrations(Request $request, int $eventId)
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        $event = $this->ownedEvent($eventId, ['registrations' => function ($query) {
            $query->orderBy('created_at', 'desc');
        }]);

        if ($event->status !== 'aktif') {
            return redirect()->to(route('organizer.dashboard') . '#events')
                ->with('error', 'Halaman Kelola Pendaftaran hanya tersedia untuk event Aktif.');
        }

        $tab = $request->get('tab', 'Semua');
        $registrations = $event->registrations;

        if ($tab === 'Menunggu Konfirmasi') {
            $registrations = $registrations->where('status', 'menunggu_konfirmasi');
        } elseif ($tab === 'Menunggu Verifikasi Pembayaran') {
            $registrations = $registrations->where('status', 'menunggu_verifikasi_pembayaran');
        } elseif ($tab === 'Terdaftar') {
            $registrations = $registrations->whereIn('status', ['terdaftar', 'hadir']);
        } elseif ($tab === 'Ditolak') {
            $registrations = $registrations->where('status', 'ditolak');
        }

        $tabs = ['Semua', 'Menunggu Konfirmasi', 'Menunggu Verifikasi Pembayaran', 'Terdaftar', 'Ditolak'];

        return view('organizer.registrations', compact('event', 'registrations', 'tabs', 'tab'));
    }

    public function approveRegistration(int $registrationId)
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        $registration = Registration::with('event')->whereHas('event', fn ($q) => $q->where('organizer_id', Auth::id())->where('status', 'aktif'))->findOrFail($registrationId);

        if ($registration->event->price > 0 || $registration->status !== 'menunggu_konfirmasi') {
            return back()->with('error', 'Konfirmasi ini hanya berlaku untuk pendaftaran event gratis yang sedang menunggu konfirmasi.');
        }

        if ($registration->event->registrations()->confirmed()->count() >= $registration->event->quota_max) {
            return back()->with('error', 'Kuota event sudah penuh.');
        }

        DB::transaction(function () use ($registration) {
            $event = Event::whereKey($registration->event_id)->lockForUpdate()->firstOrFail();
            if ($event->quota_used >= $event->quota_max) {
                abort(422, 'Kuota event sudah penuh.');
            }
            $registration->update(['status' => 'terdaftar', 'ticket_access_granted' => true, 'rejection_reason' => null]);
            $event->increment('quota_used');
        });

        return back()->with('success', 'Pendaftaran peserta berhasil disetujui.');
    }

    public function rejectRegistration(Request $request, int $registrationId)
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        $registration = Registration::with('event')->whereHas('event', fn ($q) => $q->where('organizer_id', Auth::id())->where('status', 'aktif'))->findOrFail($registrationId);

        $request->validate([
            'rejection_reason' => 'required|string|max:500',
        ]);

        $validPendingStatus = $registration->event->price > 0
            ? 'menunggu_verifikasi_pembayaran'
            : 'menunggu_konfirmasi';

        if ($registration->status !== $validPendingStatus) {
            return back()->with('error', 'Hanya pendaftaran yang masih menunggu proses yang dapat ditolak.');
        }

        $registration->update([
            'status' => 'ditolak',
            'rejection_reason' => $request->input('rejection_reason'),
            'ticket_access_granted' => false,
        ]);

        return back()->with('success', 'Pendaftaran peserta berhasil ditolak.');
    }

    public function verifyPayment(int $registrationId)
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        $registration = Registration::with('event')->whereHas('event', fn ($q) => $q->where('organizer_id', Auth::id())->where('status', 'aktif'))->findOrFail($registrationId);

        if ($registration->status !== 'menunggu_verifikasi_pembayaran') {
            return back()->with('error', 'Status pendaftaran tidak memerlukan verifikasi pembayaran.');
        }

        if ($registration->event->price <= 0 || !$registration->payment_proof_path) {
            return back()->with('error', 'Verifikasi pembayaran hanya berlaku untuk event berbayar dengan bukti pembayaran.');
        }

        if ($registration->event->registrations()->confirmed()->count() >= $registration->event->quota_max) {
            return back()->with('error', 'Kuota event sudah penuh.');
        }

        $registration->update([
            'status' => 'terdaftar',
            'payment_verified_at' => now(),
            'ticket_access_granted' => true,
        ]);

        $registration->event->increment('quota_used');

        return back()->with('success', 'Pembayaran berhasil diverifikasi.');
    }

    public function publishEvent(int $id)
    {
        $event = $this->ownedEvent($id);

        if ($event->status !== 'draft') {
            return back()->with('error', 'Hanya event Draft yang dapat dipublikasikan.');
        }

        $missing = collect([
            'judul' => $event->title,
            'pemateri' => $event->speaker,
            'jadwal' => $event->date,
            'deskripsi' => $event->description,
            'flyer' => $event->flyer_path,
            'lokasi/tautan Zoom' => $event->isOnline ? $event->zoom_link : $event->location,
        ])->filter(fn ($value) => blank($value))->keys();

        if ($missing->isNotEmpty()) {
            return back()->with('error', 'Event belum lengkap: ' . $missing->implode(', ') . '.');
        }

        $event->update(['status' => 'aktif', 'published_at' => now()]);

        return redirect()->to(route('organizer.dashboard') . '#events')->with('success', 'Event berhasil dipublikasikan dan kini dapat dilihat peserta.');
    }

    public function toggleAttendance(int $id)
    {
        $event = $this->ownedEvent($id);
        if ($event->status !== 'aktif') {
            return back()->with('error', 'Presensi hanya dapat dibuka pada event Aktif.');
        }

        $event->update(['attendance_open' => !$event->attendance_open]);

        return back()->with('success', $event->attendance_open ? 'Sesi presensi dibuka.' : 'Sesi presensi ditutup.');
    }

    public function completeEvent(int $id)
    {
        $event = $this->ownedEvent($id);
        if ($event->status !== 'aktif') {
            return back()->with('error', 'Hanya event Aktif yang dapat diselesaikan.');
        }

        DB::transaction(function () use ($event) {
            $event->update([
                'status' => 'selesai',
                'attendance_open' => false,
                'completed_at' => now(),
            ]);
        });

        return redirect()->to(route('organizer.dashboard') . '#events')->with('success', 'Event selesai. Unggah template dan generate sertifikat melalui menu Certificate.');
    }

    public function uploadCertificateTemplate(Request $request, int $id)
    {
        $event = $this->ownedEvent($id);
        if ($event->status !== 'selesai') {
            return back()->with('error', 'Template hanya dapat diunggah untuk event Selesai.');
        }

        $request->validate([
            'certificate_template' => 'required|image|mimes:png,jpg,jpeg|max:5120',
            'certificate_name_y' => 'required|integer|min:20|max:80',
            'certificate_name_size' => 'required|integer|min:18|max:72',
            'certificate_name_color' => ['required', 'regex:/^#[0-9A-Fa-f]{6}$/'],
        ], [
            'certificate_template.required' => 'Pilih file template sertifikat terlebih dahulu.',
            'certificate_template.image' => 'Template harus berupa gambar PNG atau JPG.',
        ]);

        if ($event->certificate_template_path) {
            Storage::disk('public')->delete($event->certificate_template_path);
        }

        $file = $request->file('certificate_template');
        $event->update([
            'certificate_template_path' => $file->store('certificate_templates', 'public'),
            'certificate_template_name' => $file->getClientOriginalName(),
            'certificate_generated_at' => null,
            'certificate_name_y' => $request->integer('certificate_name_y'),
            'certificate_name_size' => $request->integer('certificate_name_size'),
            'certificate_name_color' => $request->input('certificate_name_color'),
        ]);

        $event->registrations()->update(['certificate_token' => null]);

        return redirect()->to(route('organizer.dashboard', ['certificate_event' => $event->id]) . '#certificate')
            ->with('success', 'Template sertifikat berhasil diunggah. Silakan generate sertifikat peserta.');
    }

    public function generateCertificates(int $id)
    {
        $event = $this->ownedEvent($id);
        if ($event->status !== 'selesai' || !$event->certificate_template_path) {
            return back()->with('error', 'Event harus Selesai dan memiliki template sebelum sertifikat dapat dibuat.');
        }

        $eligible = $event->registrations()->where('status', 'hadir')->get();
        if ($eligible->isEmpty()) {
            return back()->with('error', 'Belum ada peserta berstatus Hadir yang dapat menerima sertifikat.');
        }

        DB::transaction(function () use ($event, $eligible) {
            foreach ($eligible as $registration) {
                $registration->update(['certificate_token' => $registration->certificate_token ?: (string) Str::uuid()]);
            }
            $event->update(['certificate_generated_at' => now()]);
        });

        return redirect()->to(route('organizer.dashboard', ['certificate_event' => $event->id]) . '#certificate')
            ->with('success', $eligible->count() . ' sertifikat peserta berhasil dibuat.');
    }

    public function deleteEvent(int $id)
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        $event = $this->ownedEvent($id);
        if ($event->status !== 'draft') {
            return back()->with('error', 'Hanya event Draft yang dapat dihapus.');
        }
        if ($event->flyer_path) {
            Storage::disk('public')->delete($event->flyer_path);
        }
        $event->delete();

        return redirect()->to(route('organizer.dashboard') . '#events')->with('success', 'Event deleted successfully.');
    }
}
