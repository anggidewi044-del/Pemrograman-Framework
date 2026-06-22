<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\OrganizerController;
use App\Http\Controllers\ParticipantController;
use App\Http\Controllers\CheckInController;
use App\Http\Controllers\CertificateController;
use App\Models\Event;
use App\Models\EventFeedback;

Route::get('/', function () {
    $events = Event::where('status', 'aktif')->orderBy('date')->take(6)->get();
    $testimonials = EventFeedback::with(['user', 'event', 'registration'])
        ->whereHas('event', fn ($query) => $query->where('status', 'selesai'))
        ->whereNotNull('comment')
        ->latest()
        ->take(3)
        ->get();

    return view('landing', compact('events', 'testimonials'));
})->name('home');

// Authentication Simulation Routes
Route::get('/login', [OrganizerController::class, 'showLogin'])->name('login');
Route::post('/login', [OrganizerController::class, 'login']);
Route::get('/register', [OrganizerController::class, 'showRegister'])->name('register');
Route::post('/register', [OrganizerController::class, 'register']);
Route::post('/logout', [OrganizerController::class, 'logout'])->name('logout');
Route::get('/logout', [OrganizerController::class, 'logout']); // fallback for easy access

// Participant Routes
Route::middleware(['auth', 'role:participant'])->prefix('participant')->name('participant.')->group(function () {
    Route::get('/dashboard', [ParticipantController::class, 'dashboard'])->name('dashboard');
    Route::get('/events', [ParticipantController::class, 'events'])->name('events');
    Route::get('/events/{id}', [ParticipantController::class, 'eventDetail'])->name('events.detail');
    Route::post('/events/{id}/register', [ParticipantController::class, 'registerEvent'])->name('events.register');
    Route::get('/tickets', [ParticipantController::class, 'myTickets'])->name('tickets');
    Route::get('/tickets/{registration}', [ParticipantController::class, 'ticketDetail'])->name('tickets.detail');
    Route::post('/tickets/{registration}/check-in', [ParticipantController::class, 'onlineCheckIn'])->name('tickets.check-in');
    Route::post('/tickets/{registration}/feedback', [ParticipantController::class, 'storeFeedback'])->name('tickets.feedback');
    Route::get('/certificates', [ParticipantController::class, 'certificates'])->name('certificates');
    Route::get('/certificates/{registration}', [ParticipantController::class, 'certificateDetail'])->name('certificates.detail');
});

Route::get('/certificates/{registration}/download', [CertificateController::class, 'download'])->middleware(['auth', 'role:participant'])->name('certificates.download');

// Organizer Routes
Route::middleware(['auth', 'role:organizer'])->prefix('organizer')->name('organizer.')->group(function () {
    Route::get('/dashboard', [OrganizerController::class, 'dashboard'])->name('dashboard');
    Route::post('/events', [OrganizerController::class, 'storeEvent'])->name('events.store');
    Route::delete('/events/{id}', [OrganizerController::class, 'deleteEvent'])->name('events.delete');
    Route::post('/events/{id}/publish', [OrganizerController::class, 'publishEvent'])->name('events.publish');
    Route::post('/events/{id}/attendance/toggle', [OrganizerController::class, 'toggleAttendance'])->name('events.attendance.toggle');
    Route::post('/events/{id}/complete', [OrganizerController::class, 'completeEvent'])->name('events.complete');
    Route::get('/events/{id}/attendance', [OrganizerController::class, 'attendance'])->name('events.attendance');
    Route::get('/events/{id}/attendance/export', [OrganizerController::class, 'exportAttendance'])->name('events.attendance.export');
    Route::post('/events/{id}/attendance/manual', [OrganizerController::class, 'manualCheckin'])->name('events.attendance.manual');
    Route::post('/events/{id}/attendance/scan', [CheckInController::class, 'processAttendance'])->name('events.attendance.scan');
    Route::get('/events/{eventId}/registrations', [OrganizerController::class, 'registrations'])->name('events.registrations');
    Route::post('/registrations/{registration}/approve', [OrganizerController::class, 'approveRegistration'])->name('registrations.approve');
    Route::post('/registrations/{registration}/reject', [OrganizerController::class, 'rejectRegistration'])->name('registrations.reject');
    Route::post('/registrations/{registration}/verify-payment', [OrganizerController::class, 'verifyPayment'])->name('registrations.verify-payment');
    Route::get('/events/{id}/analytics', [OrganizerController::class, 'analytics'])->name('events.analytics');
    Route::post('/events/{id}/certificate-template', [OrganizerController::class, 'uploadCertificateTemplate'])->name('events.certificate-template');
    Route::post('/events/{id}/certificates/generate', [OrganizerController::class, 'generateCertificates'])->name('events.certificates.generate');
    Route::get('/check-in', [CheckInController::class, 'showForm'])->name('check-in');
    Route::post('/check-in', [CheckInController::class, 'process'])->name('check-in.process');
});
