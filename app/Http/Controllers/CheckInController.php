<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use App\Models\Event;
use App\Models\Registration;

class CheckInController extends Controller
{
    public function processAttendance(Request $request, int $id)
    {
        $data = $request->validate(['qr_code' => 'required|string|max:255']);
        $event = Event::where('organizer_id', Auth::id())
            ->where('status', 'aktif')
            ->where('event_type', 'offline')
            ->findOrFail($id);

        if (!$event->attendance_open) {
            return back()->with('checkin_result', [
                'success' => false,
                'message' => 'Sesi presensi belum dibuka.',
            ]);
        }

        $registration = Registration::where('event_id', $event->id)
            ->where('qr_code', $data['qr_code'])
            ->first();

        if (!$registration) {
            return back()->with('checkin_result', [
                'success' => false,
                'message' => 'QR tidak valid atau bukan milik event ini.',
            ]);
        }

        if ($registration->status !== 'terdaftar') {
            return back()->with('checkin_result', [
                'success' => false,
                'message' => $registration->status === 'hadir'
                    ? 'Peserta sudah melakukan check-in.'
                    : 'Peserta belum berstatus Terdaftar.',
            ]);
        }

        $registration->update([
            'status' => 'hadir',
            'check_in_time' => now()->format('H:i'),
        ]);

        return back()->with('checkin_result', [
            'success' => true,
            'message' => 'Check-in berhasil untuk ' . $registration->name . '.',
        ]);
    }

    public function showForm(Request $request)
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        $events = Event::where('organizer_id', Auth::id())
            ->where('status', 'aktif')
            ->where('event_type', 'offline')
            ->orderBy('date', 'asc')->get();
        $selectedEventId = $request->get('event_id');
        $selectedEvent = $selectedEventId ? Event::where('organizer_id', Auth::id())
            ->where('status', 'aktif')->where('event_type', 'offline')->find($selectedEventId) : null;
        $result = session('checkin_result');

        return view('organizer.check-in', compact('events', 'selectedEvent', 'result'));
    }

    public function process(Request $request)
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        $data = $request->validate([
            'qr_code' => 'required|string',
            'event_id' => 'nullable|integer',
        ]);

        $registration = Registration::with('event')
            ->where('qr_code', $data['qr_code'])
            ->whereHas('event', fn ($q) => $q->where('organizer_id', Auth::id()))
            ->first();

        if (!$registration) {
            return redirect()->route('organizer.check-in', ['event_id' => $data['event_id'] ?? null])
                ->with('checkin_result', [
                    'success' => false,
                    'message' => 'QR code tidak ditemukan.',
                ]);
        }

        if ($registration->status !== 'terdaftar') {
            return redirect()->route('organizer.check-in', ['event_id' => $data['event_id'] ?? null])
                ->with('checkin_result', [
                    'success' => false,
                    'message' => 'Peserta belum terdaftar atau sudah check-in. Status: ' . str_replace('_', ' ', $registration->status),
                ]);
        }

        if (!$registration->event->isOffline) {
            return redirect()->route('organizer.check-in', ['event_id' => $data['event_id'] ?? null])
                ->with('checkin_result', [
                    'success' => false,
                    'message' => 'QR hanya digunakan untuk event offline. Peserta event online melakukan check-in dari akunnya.',
                ]);
        }

        if ($registration->event->status !== 'aktif' || !$registration->event->attendance_open) {
            return redirect()->route('organizer.check-in', ['event_id' => $data['event_id'] ?? null])
                ->with('checkin_result', [
                    'success' => false,
                    'message' => 'Event tidak aktif atau sesi presensi belum dibuka.',
                ]);
        }

        if (!empty($data['event_id']) && $registration->event_id != $data['event_id']) {
            return redirect()->route('organizer.check-in', ['event_id' => $data['event_id']])
                ->with('checkin_result', [
                    'success' => false,
                    'message' => 'QR code tidak cocok dengan event yang dipilih.',
                ]);
        }

        $registration->update([
            'status' => 'hadir',
            'check_in_time' => now()->format('H:i'),
        ]);

        return redirect()->route('organizer.check-in', ['event_id' => $registration->event_id])
            ->with('checkin_result', [
                'success' => true,
                'message' => 'Check-in berhasil.',
                'registration' => [
                    'name' => $registration->name,
                    'email' => $registration->email,
                    'event' => $registration->event->title,
                ],
            ]);
    }
}
