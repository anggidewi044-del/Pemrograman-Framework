<?php

namespace App\Providers;

use App\Models\Registration;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        View::composer('participant.*', function ($view) {
            $notifications = collect();

            if (Auth::check() && Auth::user()->isParticipant()) {
                $registrations = Registration::with('event')
                    ->where('user_id', Auth::id())
                    ->latest('updated_at')
                    ->get();

                foreach ($registrations as $registration) {
                    $event = $registration->event;
                    if (!$event) {
                        continue;
                    }

                    if ($registration->status === 'hadir'
                        && $registration->certificate_token
                        && $event->certificate_template_path
                        && $event->certificate_generated_at) {
                        $notifications->push([
                            'title' => 'Sertifikat tersedia',
                            'message' => 'Sertifikat ' . $event->title . ' siap diklaim.',
                            'url' => route('participant.certificates'),
                            'type' => 'success',
                            'time' => $event->certificate_generated_at,
                        ]);
                        continue;
                    }

                    if ($event->status === 'aktif' && $event->attendance_open
                        && in_array($registration->status, ['terdaftar', 'hadir'])) {
                        $notifications->push([
                            'title' => 'Presensi dibuka',
                            'message' => 'Sesi presensi ' . $event->title . ' sudah dibuka.',
                            'url' => route('participant.tickets.detail', $registration->id),
                            'type' => 'info',
                            'time' => $event->updated_at,
                        ]);
                        continue;
                    }

                    $statusNotification = match ($registration->status) {
                        'menunggu_konfirmasi' => ['Pendaftaran diproses', 'Pendaftaran ' . $event->title . ' menunggu konfirmasi.', 'warning'],
                        'menunggu_verifikasi_pembayaran' => ['Pembayaran diperiksa', 'Bukti pembayaran ' . $event->title . ' sedang diverifikasi.', 'warning'],
                        'terdaftar' => ['Pendaftaran disetujui', 'Anda terdaftar pada ' . $event->title . '.', 'success'],
                        'ditolak' => ['Pendaftaran ditolak', 'Pendaftaran ' . $event->title . ' belum dapat disetujui.', 'danger'],
                        default => null,
                    };

                    if ($statusNotification) {
                        $notifications->push([
                            'title' => $statusNotification[0],
                            'message' => $statusNotification[1],
                            'url' => route('participant.tickets'),
                            'type' => $statusNotification[2],
                            'time' => $registration->updated_at,
                        ]);
                    }
                }
            }

            $view->with('participantNotifications', $notifications
                ->sortByDesc('time')
                ->take(6)
                ->values());
        });
    }
}
