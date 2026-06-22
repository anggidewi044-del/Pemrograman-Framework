<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

return new class extends Migration
{
    public function up(): void
    {
        $offlineEventIds = DB::table('events')->where('event_type', 'offline')->pluck('id');

        DB::table('registrations')
            ->whereIn('event_id', $offlineEventIds)
            ->whereNull('qr_code')
            ->orderBy('id')
            ->eachById(function ($registration) {
                DB::table('registrations')->where('id', $registration->id)->update([
                    'qr_code' => (string) Str::uuid(),
                ]);
            });

        $onlineEventIds = DB::table('events')->where('event_type', 'online')->pluck('id');
        DB::table('registrations')->whereIn('event_id', $onlineEventIds)->update(['qr_code' => null]);
    }

    public function down(): void
    {
        // Token QR bersifat data operasional dan tidak perlu dihapus saat rollback.
    }
};
