<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Event;
use App\Models\Registration;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Seed organizer user (pre-made account, cannot register)
        User::updateOrCreate(
            ['email' => 'abdillah.firman@gmail.com'],
            [
                'name' => 'Abdillah',
                'password' => Hash::make('password'),
                'email_verified_at' => now(),
                'role' => 'organizer',
            ]
        );

        // Seed sample participant users
        $novandra = User::updateOrCreate(
            ['email' => 'novandra@example.com'],
            [
                'name' => 'Novandra',
                'password' => Hash::make('password'),
                'email_verified_at' => now(),
                'role' => 'participant',
            ]
        );

        $ayu = User::updateOrCreate(
            ['email' => 'ayu.is3@gmail.com'],
            [
                'name' => 'Ayu Shinta',
                'password' => Hash::make('password'),
                'email_verified_at' => now(),
                'role' => 'participant',
            ]
        );

        Event::truncate();
        Registration::truncate();

        // Active Events
        $techWinter = Event::create([
            'title' => 'Tech Winter',
            'speaker' => 'Oliver Archio, S.Kom., M.T',
            'category' => 'Webinar',
            'date' => '2026-01-25',
            'time' => '10.00 - 12.00',
            'event_type' => 'online',
            'location' => 'Online (Zoom)',
            'zoom_link' => 'https://zoom.us/j/1234567890',
            'zoom_info' => "Meeting ID: 123 456 7890\nPasscode: TECH2026",
            'description' => 'Webinar akan disampaikan oleh Oliver Archio, S.Kom., M.T yang akan membahas mengenai isu Tech Winter.',
            'materi' => "Perkembangan Tech Winter di industri teknologi\nDampak terhadap karir developer\nStrategi bertahan dan berkembang",
            'quota_max' => 100,
            'quota_used' => 2,
            'price' => 0,
            'contact_phone' => '081352637393',
            'status' => 'aktif',
            'image' => 'tech-winter'
        ]);

        $aiVsUi = Event::create([
            'title' => 'AI VS UI',
            'speaker' => 'Dilla Fathya Izati, S.Kom., M.Kom',
            'category' => 'Seminar',
            'date' => '2026-02-02',
            'time' => '13.00 - 15.00',
            'event_type' => 'offline',
            'location' => 'Balai Kota Bandung',
            'zoom_link' => null,
            'zoom_info' => null,
            'description' => 'AI VS UI? Jangan takut! Belajar bersama bagaimana tranformasi AI pada dunia desain.',
            'materi' => "Perbandingan AI dan UI\nPenerapan AI dalam desain\nTren desain berbasis AI",
            'quota_max' => 25,
            'quota_used' => 1,
            'price' => 25000,
            'contact_phone' => '081352637393',
            'status' => 'aktif',
            'image' => ''
        ]);

        $ftinity = Event::create([
            'title' => 'FTINITY',
            'speaker' => 'Venia Restreva Danestriara, S.Si.Kom., M.Sc., M.Si',
            'category' => 'Webinar',
            'date' => '2026-01-25',
            'time' => '09.00 - 12.00',
            'event_type' => 'online',
            'location' => 'Online (Zoom)',
            'zoom_link' => 'https://zoom.us/j/9876543210',
            'zoom_info' => "Meeting ID: 987 654 3210\nPasscode: FTINITY26",
            'description' => 'Webinar yang sangat bermanfaat bagi kamu yang tertarik pada dunia data science.',
            'materi' => "Pendekatan Pre-Klinik dan Klinik\nAnalisis data kesehatan\nStudi kasus FTINITY",
            'quota_max' => 100,
            'quota_used' => 2,
            'price' => 0,
            'contact_phone' => '081352637393',
            'status' => 'aktif',
            'image' => 'ftinity-done'
        ]);

        $beBrave = Event::create([
            'title' => 'Be Brave, Be Creative',
            'speaker' => 'Gerry Geraldy, M.Ds',
            'category' => 'Seminar',
            'date' => '2026-02-12',
            'time' => '09.00 - 11.00',
            'event_type' => 'offline',
            'location' => 'GSG Rancamanyar',
            'zoom_link' => null,
            'zoom_info' => null,
            'description' => 'Belajar menumbuhkan kreativitas dan keberanian berkarya.',
            'materi' => "Membangun keberanian berkarya\nTeknik kreativitas praktis\nStudi kasus karya kreatif",
            'quota_max' => 35,
            'quota_used' => 0,
            'price' => 0,
            'contact_phone' => '081352637393',
            'status' => 'aktif',
            'image' => ''
        ]);

        // Draft Events
        Event::create([
            'title' => 'Power In Perspective',
            'speaker' => 'Angkasa Adiwidjaya, S.M',
            'category' => 'Seminar',
            'date' => '2026-03-05',
            'time' => '14.00 - 16.00',
            'event_type' => 'offline',
            'location' => 'GSG Paku Haji',
            'zoom_link' => null,
            'zoom_info' => null,
            'description' => 'Mengubah sudut pandang kepemimpinan dan manajemen organisasi.',
            'materi' => "Perspektif kepemimpinan\nManajemen organisasi efektif\nStudi kasus perubahan sudut pandang",
            'quota_max' => 50,
            'quota_used' => 0,
            'price' => 50000,
            'contact_phone' => '081352637393',
            'status' => 'draft',
            'image' => ''
        ]);

        Event::create([
            'title' => 'Computer Vision',
            'speaker' => 'Sri Wahyuningsih, Ph.D',
            'category' => 'Workshop',
            'date' => '2026-04-06',
            'time' => '10.00 - 12.00',
            'event_type' => 'offline',
            'location' => 'GSG Paku Haji',
            'zoom_link' => null,
            'zoom_info' => null,
            'description' => 'Mengenal teknologi computer vision dan implementasi praktisnya.',
            'materi' => "Dasar-dasar Computer Vision\nImage processing\nImplementasi dengan Python",
            'quota_max' => 100,
            'quota_used' => 0,
            'price' => 150000,
            'contact_phone' => '081352637393',
            'status' => 'draft',
            'image' => 'computer-vision'
        ]);

        Event::create([
            'title' => 'AI in Industry',
            'speaker' => 'Dr. Nezar Patria',
            'category' => 'Webinar',
            'date' => '2026-05-15',
            'time' => '13.30 - 15.30',
            'event_type' => 'online',
            'location' => 'Online (Zoom)',
            'zoom_link' => 'https://zoom.us/j/1122334455',
            'zoom_info' => "Meeting ID: 112 233 4455\nPasscode: AIIND2026",
            'description' => 'Bagaimana industri saat ini bertransformasi menggunakan Artificial Intelligence.',
            'materi' => "Transformasi industri dengan AI\nStudi kasus implementasi AI\nTantangan dan peluang",
            'quota_max' => 50,
            'quota_used' => 0,
            'price' => 75000,
            'contact_phone' => '081352637393',
            'status' => 'draft',
            'image' => 'ai-industry'
        ]);

        // Completed Events (Selesai)
        $aiVsUiDone = Event::create([
            'title' => 'AI VS UI',
            'speaker' => 'Dilla Fathya Izati, S.Kom., M.Kom',
            'category' => 'Seminar',
            'date' => '2026-02-02',
            'time' => '13.00 - 15.00',
            'event_type' => 'offline',
            'location' => 'Balai Kota Bandung',
            'zoom_link' => null,
            'zoom_info' => null,
            'description' => 'Seminar mengenai perbandingan AI dan UI di industri teknologi modern.',
            'materi' => "Perbandingan AI dan UI\nPenerapan AI dalam desain\nTren desain berbasis AI",
            'quota_max' => 25,
            'quota_used' => 25,
            'price' => 25000,
            'contact_phone' => '081352637393',
            'status' => 'selesai',
            'image' => ''
        ]);

        $ftinityDone = Event::create([
            'title' => 'FTINITY',
            'speaker' => 'Venia Restreva Danestriara, S.Si.Kom., M.Sc., M.Si',
            'category' => 'Webinar',
            'date' => '2026-01-25',
            'time' => '09.00 - 12.00',
            'event_type' => 'online',
            'location' => 'Online (Zoom)',
            'zoom_link' => 'https://zoom.us/j/9876543210',
            'zoom_info' => "Meeting ID: 987 654 3210\nPasscode: FTINITY26",
            'description' => 'Pendekatan Pre-Klinik dan Klinik pada teknologi informasi kesehatan.',
            'materi' => "Pendekatan Pre-Klinik dan Klinik\nAnalisis data kesehatan\nStudi kasus FTINITY",
            'quota_max' => 100,
            'quota_used' => 100,
            'price' => 0,
            'contact_phone' => '081352637393',
            'status' => 'selesai',
            'image' => 'ftinity-done'
        ]);

        $amankanDataDone = Event::create([
            'title' => 'Amankan Data Kamu',
            'speaker' => 'Harun Zunkarnaen, S.T, M.T',
            'category' => 'Workshop',
            'date' => '2026-01-15',
            'time' => '10.00 - 12.00',
            'event_type' => 'offline',
            'location' => 'GSG Turnojoyo',
            'zoom_link' => null,
            'zoom_info' => null,
            'description' => 'Bagaimana mengamankan aset informasi penting Anda.',
            'materi' => "Identifikasi ancaman data\nStrategi keamanan informasi\nPraktik terbaik perlindungan data",
            'quota_max' => 80,
            'quota_used' => 80,
            'price' => 150000,
            'contact_phone' => '081352637393',
            'status' => 'selesai',
            'image' => 'amankan-data-done'
        ]);

        // Registrations for Novandra
        Registration::create([
            'event_id' => $aiVsUiDone->id,
            'user_id' => $novandra->id,
            'name' => $novandra->name,
            'email' => $novandra->email,
            'status' => 'hadir',
            'check_in_time' => '09:45',
            'certificate_token' => (string) Str::uuid(),
            'qr_code' => (string) Str::uuid(),
            'ticket_access_granted' => true,
            'payment_amount' => 25000,
            'payment_verified_at' => now()->subDays(10),
        ]);

        Registration::create([
            'event_id' => $ftinityDone->id,
            'user_id' => $novandra->id,
            'name' => $novandra->name,
            'email' => $novandra->email,
            'status' => 'absent',
            'check_in_time' => null,
            'certificate_token' => null,
            'qr_code' => (string) Str::uuid(),
            'ticket_access_granted' => true,
        ]);

        // Free event registration as terdaftar
        Registration::create([
            'event_id' => $techWinter->id,
            'user_id' => $novandra->id,
            'name' => $novandra->name,
            'email' => $novandra->email,
            'status' => 'terdaftar',
            'qr_code' => (string) Str::uuid(),
            'ticket_access_granted' => true,
        ]);

        // Paid event registration waiting for payment verification
        Registration::create([
            'event_id' => $aiVsUi->id,
            'user_id' => $novandra->id,
            'name' => $novandra->name,
            'email' => $novandra->email,
            'status' => 'menunggu_verifikasi_pembayaran',
            'payment_proof_path' => 'payment_proofs/dummy.jpg',
            'payment_amount' => 25000,
            'qr_code' => (string) Str::uuid(),
            'ticket_access_granted' => false,
        ]);

        // Paid event registration approved
        Registration::create([
            'event_id' => $ftinity->id,
            'user_id' => $ayu->id,
            'name' => $ayu->name,
            'email' => $ayu->email,
            'status' => 'terdaftar',
            'payment_amount' => 0,
            'qr_code' => (string) Str::uuid(),
            'ticket_access_granted' => true,
        ]);

        // Free event registration pending confirmation
        Registration::create([
            'event_id' => $ftinity->id,
            'user_id' => $novandra->id,
            'name' => $novandra->name,
            'email' => $novandra->email,
            'status' => 'menunggu_konfirmasi',
            'qr_code' => (string) Str::uuid(),
            'ticket_access_granted' => false,
        ]);

        // Rejected registration sample
        Registration::create([
            'event_id' => $beBrave->id,
            'user_id' => $novandra->id,
            'name' => $novandra->name,
            'email' => $novandra->email,
            'status' => 'ditolak',
            'rejection_reason' => 'Kuota event sudah penuh saat proses approval.',
            'qr_code' => (string) Str::uuid(),
            'ticket_access_granted' => false,
        ]);

        // Extra approved participant for FTINITY active event
        Registration::create([
            'event_id' => $techWinter->id,
            'user_id' => $ayu->id,
            'name' => $ayu->name,
            'email' => $ayu->email,
            'status' => 'terdaftar',
            'qr_code' => (string) Str::uuid(),
            'ticket_access_granted' => true,
        ]);
    }
}
