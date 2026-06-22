<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        // Kolom status awal sudah berupa string pada SQLite, sehingga tidak perlu
        // dibangun ulang. Ini juga menghindari tabel __temp__ saat file dipakai XAMPP.
        if (DB::getDriverName() !== 'sqlite') {
            Schema::table('registrations', function (Blueprint $table) {
                $table->enum('status', [
                    'menunggu_konfirmasi',
                    'menunggu_verifikasi_pembayaran',
                    'terdaftar',
                    'ditolak',
                    'hadir',
                    'absent',
                ])->default('menunggu_konfirmasi')->change();
            });
        }

        Schema::table('registrations', function (Blueprint $table) {
            $table->string('payment_proof_path')->nullable()->after('status');
            $table->integer('payment_amount')->nullable()->after('payment_proof_path');
            $table->timestamp('payment_verified_at')->nullable()->after('payment_amount');
            $table->text('rejection_reason')->nullable()->after('payment_verified_at');
            $table->string('qr_code')->nullable()->unique()->after('rejection_reason');
            $table->boolean('ticket_access_granted')->default(false)->after('qr_code');
        });

        DB::table('registrations')->where('status', 'registered')->update([
            'status' => 'terdaftar',
            'ticket_access_granted' => true,
        ]);
    }

    public function down(): void
    {
        Schema::table('registrations', function (Blueprint $table) {
            $table->string('status')->default('registered')->change();
            $table->dropColumn([
                'payment_proof_path',
                'payment_amount',
                'payment_verified_at',
                'rejection_reason',
                'qr_code',
                'ticket_access_granted',
            ]);
        });
    }
};
