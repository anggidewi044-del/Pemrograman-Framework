<?php

namespace Tests\Feature;

use App\Models\Event;
use App\Models\EventFeedback;
use App\Models\Registration;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class EventWorkflowTest extends TestCase
{
    use RefreshDatabase;

    public function test_new_event_is_always_owned_draft_and_can_be_published(): void
    {
        $organizer = User::factory()->create(['role' => 'organizer']);

        $this->actingAs($organizer)->post(route('organizer.events.store'), [
            'title' => 'Laravel Conference',
            'speaker' => 'Rina',
            'category' => 'Seminar',
            'date' => '2026-07-20',
            'time' => '09:00 - 12:00',
            'event_type' => 'offline',
            'location' => 'Bandung',
            'description' => 'Konferensi teknologi.',
            'quota_max' => 100,
            'price' => 0,
            'status' => 'aktif',
        ])->assertSessionHasNoErrors()->assertRedirect();

        $event = Event::firstOrFail();
        $this->assertSame('draft', $event->status);
        $this->assertSame($organizer->id, $event->organizer_id);

        $event->update(['flyer_path' => 'flyers/test.jpg']);
        $this->actingAs($organizer)->post(route('organizer.events.publish', $event))->assertRedirect();
        $this->assertSame('aktif', $event->fresh()->status);
    }

    public function test_event_without_price_is_saved_as_free_event(): void
    {
        $organizer = User::factory()->create(['role' => 'organizer']);

        $this->actingAs($organizer)->post(route('organizer.events.store'), [
            'title' => 'Event Gratis',
            'speaker' => 'Narasumber',
            'category' => 'Seminar',
            'date' => '2026-07-20',
            'time' => '09:00',
            'event_type' => 'offline',
            'location' => 'Jakarta',
            'description' => 'Event tanpa biaya.',
            'quota_max' => 75,
        ])->assertSessionHasNoErrors()->assertRedirect();

        $event = Event::firstOrFail();
        $this->assertSame(0, $event->price);
        $this->assertSame(75, $event->quota_max);
    }

    public function test_certificate_claim_opens_inline_without_detail_page_link(): void
    {
        $organizer = User::factory()->create(['role' => 'organizer']);
        $participant = User::factory()->create(['role' => 'participant']);
        $event = Event::create([
            'organizer_id' => $organizer->id, 'title' => 'Kelas UI', 'speaker' => 'Speaker',
            'date' => '2026-07-20', 'location' => 'Bandung', 'quota_max' => 10,
            'price' => 0, 'status' => 'selesai', 'event_type' => 'offline',
            'certificate_template_path' => 'certificate_templates/ui.png',
            'certificate_generated_at' => now(),
        ]);
        $registration = Registration::create([
            'event_id' => $event->id, 'user_id' => $participant->id,
            'name' => $participant->name, 'email' => $participant->email,
            'status' => 'hadir', 'certificate_token' => 'CERTIFICATE-TOKEN-123',
        ]);

        $this->actingAs($participant)->get(route('participant.certificates'))
            ->assertOk()
            ->assertSee('data-certificate-toggle="certificate-claim-' . $registration->id . '"', false)
            ->assertSee('Diselenggarakan oleh')
            ->assertDontSee('href="' . route('participant.certificates.detail', $registration) . '"', false);
    }

    public function test_ticket_and_certificate_search_filter_their_own_pages(): void
    {
        $organizer = User::factory()->create(['role' => 'organizer']);
        $participant = User::factory()->create(['role' => 'participant']);

        foreach (['Target Design', 'Event Lain'] as $title) {
            $event = Event::create([
                'organizer_id' => $organizer->id, 'title' => $title, 'speaker' => 'Speaker',
                'date' => '2026-07-20', 'location' => 'Bandung', 'quota_max' => 10,
                'price' => 0, 'status' => 'selesai', 'event_type' => 'offline',
            ]);
            Registration::create([
                'event_id' => $event->id, 'user_id' => $participant->id,
                'name' => $participant->name, 'email' => $participant->email, 'status' => 'hadir',
            ]);
        }

        $this->actingAs($participant)->get(route('participant.tickets', ['search' => 'Target']))
            ->assertOk()->assertSee('Target Design')->assertDontSee('Event Lain');
        $this->get(route('participant.certificates', ['search' => 'Target']))
            ->assertOk()->assertSee('Target Design')->assertDontSee('Event Lain');
    }

    public function test_orphaned_registration_does_not_break_ticket_or_certificate_pages(): void
    {
        $organizer = User::factory()->create(['role' => 'organizer']);
        $participant = User::factory()->create(['role' => 'participant']);
        $event = Event::create([
            'organizer_id' => $organizer->id, 'title' => 'Event Terhapus', 'speaker' => 'Speaker',
            'date' => '2026-07-20', 'location' => 'Bandung', 'quota_max' => 10,
            'price' => 0, 'status' => 'selesai', 'event_type' => 'offline',
        ]);
        Registration::create([
            'event_id' => $event->id, 'user_id' => $participant->id,
            'name' => $participant->name, 'email' => $participant->email, 'status' => 'hadir',
        ]);

        DB::statement('PRAGMA foreign_keys = OFF');
        DB::table('events')->where('id', $event->id)->delete();
        DB::statement('PRAGMA foreign_keys = ON');

        $this->actingAs($participant)->get(route('participant.tickets'))
            ->assertOk()->assertSee('Belum ada tiket');
        $this->get(route('participant.certificates'))
            ->assertOk()->assertSee('Belum ada sertifikat');
    }

    public function test_certificate_dashboard_starts_with_finished_event_selection_page(): void
    {
        $organizer = User::factory()->create(['role' => 'organizer']);
        $event = Event::create([
            'organizer_id' => $organizer->id, 'title' => 'Event Selesai Pilihan', 'speaker' => 'Speaker',
            'date' => '2026-06-01', 'location' => 'Bandung', 'quota_max' => 10,
            'price' => 0, 'status' => 'selesai', 'event_type' => 'offline',
        ]);

        $this->actingAs($organizer)->get(route('organizer.dashboard'))
            ->assertOk()->assertSee('Pilih Event untuk Sertifikat')->assertDontSee('id="certificate-real-file"', false);

        $this->get(route('organizer.dashboard', ['certificate_event' => $event->id]))
            ->assertOk()->assertSee('id="certificate-real-file"', false)->assertSee('Kembali ke daftar event');
    }

    public function test_organizer_dashboard_uses_real_upcoming_events_and_activity(): void
    {
        $organizer = User::factory()->create(['role' => 'organizer']);
        Event::create([
            'organizer_id' => $organizer->id, 'title' => 'Event Lampau', 'speaker' => 'A',
            'date' => '2020-01-01', 'location' => 'Bandung', 'quota_max' => 10,
            'price' => 0, 'status' => 'aktif', 'event_type' => 'offline',
        ]);
        $upcoming = Event::create([
            'organizer_id' => $organizer->id, 'title' => 'Event Masa Depan', 'speaker' => 'B',
            'date' => now()->addMonth()->toDateString(), 'location' => 'Jakarta', 'quota_max' => 10,
            'price' => 0, 'status' => 'aktif', 'event_type' => 'offline', 'published_at' => now(),
        ]);
        Registration::create([
            'event_id' => $upcoming->id, 'name' => 'Peserta Nyata', 'email' => 'nyata@example.com',
            'status' => 'menunggu_konfirmasi',
        ]);

        $response = $this->actingAs($organizer)->get(route('organizer.dashboard'));
        $response->assertOk()->assertSee('Event Masa Depan')->assertSee('Peserta Nyata mendaftar');
        $this->assertStringNotContainsString('Transaction Ayu Sulastri', $response->getContent());
    }

    public function test_landing_testimonials_come_from_participant_feedback(): void
    {
        $organizer = User::factory()->create(['role' => 'organizer']);
        $participant = User::factory()->create(['role' => 'participant', 'name' => 'Rizer Nyata']);
        $event = Event::create([
            'organizer_id' => $organizer->id, 'title' => 'Seminar Nyata', 'speaker' => 'Speaker',
            'date' => '2026-06-01', 'location' => 'Bandung', 'quota_max' => 10,
            'price' => 0, 'status' => 'selesai', 'event_type' => 'offline',
        ]);
        $registration = Registration::create([
            'event_id' => $event->id, 'user_id' => $participant->id, 'name' => $participant->name,
            'email' => $participant->email, 'status' => 'hadir',
        ]);
        EventFeedback::create([
            'event_id' => $event->id, 'user_id' => $participant->id,
            'registration_id' => $registration->id, 'rating' => 5,
            'comment' => 'Ulasan asli dari database.',
        ]);

        $this->get(route('home'))->assertOk()
            ->assertSee('Rizer Nyata')
            ->assertSee('Ulasan asli dari database.')
            ->assertSee('Seminar Nyata');
    }

    public function test_only_attended_participants_receive_certificate_when_event_completes(): void
    {
        $organizer = User::factory()->create(['role' => 'organizer']);
        $event = Event::create([
            'organizer_id' => $organizer->id, 'title' => 'Event', 'speaker' => 'Speaker',
            'date' => '2026-07-20', 'location' => 'Bandung', 'description' => 'Desc',
            'quota_max' => 10, 'quota_used' => 2, 'price' => 0, 'status' => 'aktif',
            'event_type' => 'offline',
        ]);
        $present = Registration::create(['event_id' => $event->id, 'name' => 'Hadir', 'email' => 'hadir@example.com', 'status' => 'hadir']);
        $absent = Registration::create(['event_id' => $event->id, 'name' => 'Tidak Hadir', 'email' => 'absen@example.com', 'status' => 'terdaftar']);

        $this->actingAs($organizer)->post(route('organizer.events.complete', $event))->assertRedirect();

        $this->assertSame('selesai', $event->fresh()->status);
        $this->assertNull($present->fresh()->certificate_token);
        $this->assertNull($absent->fresh()->certificate_token);
    }

    public function test_organizer_uploads_template_before_generating_attendee_certificates(): void
    {
        Storage::fake('public');
        $organizer = User::factory()->create(['role' => 'organizer']);
        $event = Event::create([
            'organizer_id' => $organizer->id, 'title' => 'Selesai', 'speaker' => 'Speaker',
            'date' => '2026-07-20', 'location' => 'Bandung', 'quota_max' => 10,
            'price' => 0, 'status' => 'selesai', 'event_type' => 'offline',
        ]);
        $present = Registration::create(['event_id' => $event->id, 'name' => 'Hadir', 'email' => 'hadir@example.com', 'status' => 'hadir']);
        $absent = Registration::create(['event_id' => $event->id, 'name' => 'Absen', 'email' => 'absen@example.com', 'status' => 'terdaftar']);

        $this->actingAs($organizer)->post(route('organizer.events.certificate-template', $event), [
            'certificate_template' => UploadedFile::fake()->createWithContent(
                'template.png',
                base64_decode('iVBORw0KGgoAAAANSUhEUgAAAAEAAAABCAQAAAC1HAwCAAAAC0lEQVR42mP8/x8AAusB9Y9ZQmcAAAAASUVORK5CYII=')
            ),
            'certificate_name_y' => 43,
            'certificate_name_size' => 38,
            'certificate_name_color' => '#8a651f',
        ])->assertSessionHas('success');

        $this->post(route('organizer.events.certificates.generate', $event))->assertSessionHas('success');
        $this->assertNotNull($present->fresh()->certificate_token);
        $this->assertNull($absent->fresh()->certificate_token);
        $this->assertNotNull($event->fresh()->certificate_generated_at);
        $this->get(route('organizer.dashboard', ['certificate_event' => $event->id]))
            ->assertOk()
            ->assertSee('EVENT TERPILIH')
            ->assertSee('certificate-real-file')
            ->assertSee('Analytics Event')
            ->assertSee('Hadir');
        $this->getJson(route('organizer.events.analytics', $event))->assertOk()->assertJsonPath('attended_count', 1);
    }

    public function test_participant_notifications_appear_on_dashboard_tickets_and_certificates(): void
    {
        $organizer = User::factory()->create(['role' => 'organizer']);
        $participant = User::factory()->create(['role' => 'participant']);
        $event = Event::create([
            'organizer_id' => $organizer->id, 'title' => 'Event Notifikasi', 'speaker' => 'Speaker',
            'date' => '2026-07-20', 'location' => 'Bandung', 'quota_max' => 10,
            'price' => 0, 'status' => 'aktif', 'event_type' => 'offline',
        ]);
        Registration::create([
            'event_id' => $event->id, 'user_id' => $participant->id,
            'name' => $participant->name, 'email' => $participant->email,
            'status' => 'terdaftar', 'ticket_access_granted' => true,
        ]);

        foreach (['participant.dashboard', 'participant.tickets', 'participant.certificates'] as $routeName) {
            $this->actingAs($participant)->get(route($routeName))
                ->assertOk()
                ->assertSee('data-notification-toggle', false)
                ->assertSee('Pendaftaran disetujui')
                ->assertSee('Event Notifikasi');
        }
    }

    public function test_attendee_can_submit_feedback_visible_in_analytics(): void
    {
        $organizer = User::factory()->create(['role' => 'organizer']);
        $participant = User::factory()->create(['role' => 'participant']);
        $event = Event::create([
            'organizer_id' => $organizer->id, 'title' => 'Evaluasi', 'speaker' => 'Speaker',
            'date' => '2026-07-20', 'location' => 'Bandung', 'quota_max' => 10,
            'price' => 0, 'status' => 'selesai', 'event_type' => 'offline',
        ]);
        $registration = Registration::create([
            'event_id' => $event->id, 'user_id' => $participant->id, 'name' => $participant->name,
            'email' => $participant->email, 'status' => 'hadir', 'ticket_access_granted' => true,
        ]);

        $this->actingAs($participant)->post(route('participant.tickets.feedback', $registration), [
            'rating' => 5, 'comment' => 'Materi sangat bermanfaat dan penyelenggaraan rapi.',
        ])->assertSessionHas('success');

        $this->actingAs($organizer)->getJson(route('organizer.events.analytics', $event))
            ->assertOk()
            ->assertJsonPath('feedbacks.0.rating', 5)
            ->assertJsonPath('feedbacks.0.comment', 'Materi sangat bermanfaat dan penyelenggaraan rapi.');
    }

    public function test_confirmed_participant_can_review_before_event_is_finished(): void
    {
        $organizer = User::factory()->create(['role' => 'organizer']);
        $participant = User::factory()->create(['role' => 'participant']);
        $event = Event::create([
            'organizer_id' => $organizer->id, 'title' => 'Event Aktif', 'speaker' => 'Speaker',
            'date' => '2026-07-20', 'location' => 'Bandung', 'quota_max' => 10,
            'price' => 0, 'status' => 'aktif', 'event_type' => 'offline',
        ]);
        $registration = Registration::create([
            'event_id' => $event->id, 'user_id' => $participant->id,
            'name' => $participant->name, 'email' => $participant->email,
            'status' => 'terdaftar', 'ticket_access_granted' => true,
        ]);

        $this->actingAs($participant)->get(route('participant.tickets.detail', $registration))
            ->assertOk()
            ->assertSee('Ulasan Event')
            ->assertSee('Pendaftaran Anda telah dikonfirmasi');

        $this->post(route('participant.tickets.feedback', $registration), [
            'rating' => 4,
            'comment' => 'Informasi persiapan event sudah sangat jelas.',
        ])->assertSessionHas('success');

        $this->assertDatabaseHas('event_feedback', [
            'registration_id' => $registration->id,
            'rating' => 4,
        ]);
    }

    public function test_participant_cannot_access_organizer_routes(): void
    {
        $participant = User::factory()->create(['role' => 'participant']);
        $this->actingAs($participant)->get(route('organizer.dashboard'))
            ->assertRedirect(route('participant.dashboard'))
            ->assertSessionHas('error');
    }

    public function test_registration_management_is_only_available_for_active_events(): void
    {
        $organizer = User::factory()->create(['role' => 'organizer']);
        $event = Event::create([
            'organizer_id' => $organizer->id, 'title' => 'Event', 'speaker' => 'Speaker',
            'date' => '2026-07-20', 'location' => 'Bandung', 'description' => 'Desc',
            'quota_max' => 10, 'quota_used' => 0, 'price' => 0, 'status' => 'draft',
            'event_type' => 'offline',
        ]);

        $this->actingAs($organizer)
            ->get(route('organizer.events.registrations', $event))
            ->assertRedirect(route('organizer.dashboard') . '#events');

        $event->update(['status' => 'aktif']);
        $this->get(route('organizer.events.registrations', $event))
            ->assertOk()
            ->assertSee('Manajemen Pendaftaran');
    }

    public function test_registration_actions_follow_free_and_paid_tabs(): void
    {
        $organizer = User::factory()->create(['role' => 'organizer']);
        $freeEvent = Event::create([
            'organizer_id' => $organizer->id, 'title' => 'Gratis', 'speaker' => 'Speaker',
            'date' => '2026-07-20', 'location' => 'Bandung', 'quota_max' => 10,
            'price' => 0, 'status' => 'aktif', 'event_type' => 'offline',
        ]);
        $freeRegistration = Registration::create([
            'event_id' => $freeEvent->id, 'name' => 'Peserta Gratis', 'email' => 'free@example.com',
            'status' => 'menunggu_konfirmasi',
        ]);

        $this->actingAs($organizer)
            ->get(route('organizer.events.registrations', $freeEvent))
            ->assertDontSee('btn-action-approve', false);
        $this->get(route('organizer.events.registrations', ['eventId' => $freeEvent->id, 'tab' => 'Menunggu Konfirmasi']))
            ->assertSee('Konfirmasi')
            ->assertSee('Tolak')
            ->assertDontSee('Lihat Bukti Pembayaran');

        $paidEvent = Event::create([
            'organizer_id' => $organizer->id, 'title' => 'Berbayar', 'speaker' => 'Speaker',
            'date' => '2026-07-20', 'location' => 'Bandung', 'quota_max' => 10,
            'price' => 50000, 'status' => 'aktif', 'event_type' => 'offline',
        ]);
        $paidRegistration = Registration::create([
            'event_id' => $paidEvent->id, 'name' => 'Peserta Berbayar', 'email' => 'paid@example.com',
            'status' => 'menunggu_verifikasi_pembayaran', 'payment_proof_path' => 'payment_proofs/test.jpg',
        ]);

        $this->get(route('organizer.events.registrations', ['eventId' => $paidEvent->id, 'tab' => 'Menunggu Verifikasi Pembayaran']))
            ->assertSee('Lihat Bukti Pembayaran')
            ->assertSee('Konfirmasi')
            ->assertSee('Tolak');

        $this->post(route('organizer.registrations.approve', $paidRegistration))
            ->assertSessionHas('error');
        $this->assertSame('menunggu_verifikasi_pembayaran', $paidRegistration->fresh()->status);
    }

    public function test_online_participant_checks_in_by_button_and_offline_uses_qr(): void
    {
        $organizer = User::factory()->create(['role' => 'organizer']);
        $participant = User::factory()->create(['role' => 'participant']);
        $online = Event::create([
            'organizer_id' => $organizer->id, 'title' => 'Online', 'speaker' => 'Speaker',
            'date' => '2026-07-20', 'location' => '', 'quota_max' => 10, 'price' => 0,
            'status' => 'aktif', 'event_type' => 'online', 'zoom_link' => 'https://zoom.us/j/123',
            'attendance_open' => false,
        ]);
        $onlineRegistration = Registration::create([
            'event_id' => $online->id, 'user_id' => $participant->id, 'name' => $participant->name,
            'email' => $participant->email, 'status' => 'terdaftar', 'ticket_access_granted' => true,
            'qr_code' => 'online-token',
        ]);

        $this->actingAs($participant)
            ->post(route('participant.tickets.check-in', $onlineRegistration))
            ->assertSessionHas('error');
        $online->update(['attendance_open' => true]);
        $this->post(route('participant.tickets.check-in', $onlineRegistration))->assertSessionHas('success');
        $this->assertSame('hadir', $onlineRegistration->fresh()->status);

        $offline = Event::create([
            'organizer_id' => $organizer->id, 'title' => 'Offline', 'speaker' => 'Speaker',
            'date' => '2026-07-20', 'location' => 'Bandung', 'quota_max' => 10, 'price' => 0,
            'status' => 'aktif', 'event_type' => 'offline', 'attendance_open' => true,
        ]);
        $offlineRegistration = Registration::create([
            'event_id' => $offline->id, 'user_id' => $participant->id, 'name' => $participant->name,
            'email' => $participant->email, 'status' => 'terdaftar', 'ticket_access_granted' => true,
            'qr_code' => 'offline-token',
        ]);

        $this->actingAs($organizer)
            ->get(route('organizer.events.attendance', $offline))
            ->assertOk()
            ->assertSee('inline-qr-reader');
        $this->post(route('organizer.events.attendance.scan', $offline), [
            'qr_code' => 'offline-token',
        ])->assertSessionHas('checkin_result');
        $this->assertSame('hadir', $offlineRegistration->fresh()->status);
    }
}
