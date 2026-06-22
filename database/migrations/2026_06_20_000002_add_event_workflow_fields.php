<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('events', function (Blueprint $table) {
            $table->foreignId('organizer_id')->nullable()->after('id')->constrained('users')->nullOnDelete();
            $table->boolean('attendance_open')->default(false)->after('zoom_info');
            $table->timestamp('published_at')->nullable()->after('attendance_open');
            $table->timestamp('completed_at')->nullable()->after('published_at');
        });

        $organizerId = DB::table('users')->where('role', 'organizer')->value('id');
        if ($organizerId) {
            DB::table('events')->whereNull('organizer_id')->update(['organizer_id' => $organizerId]);
        }
    }

    public function down(): void
    {
        Schema::table('events', function (Blueprint $table) {
            $table->dropConstrainedForeignId('organizer_id');
            $table->dropColumn(['attendance_open', 'published_at', 'completed_at']);
        });
    }
};
