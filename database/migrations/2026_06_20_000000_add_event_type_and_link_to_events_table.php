<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('events', function (Blueprint $table) {
            $table->enum('event_type', ['offline', 'online'])->default('offline')->after('status');
            $table->text('zoom_link')->nullable()->after('event_type');
            $table->text('zoom_info')->nullable()->after('zoom_link');
        });
    }

    public function down(): void
    {
        Schema::table('events', function (Blueprint $table) {
            $table->dropColumn(['event_type', 'zoom_link', 'zoom_info']);
        });
    }
};
