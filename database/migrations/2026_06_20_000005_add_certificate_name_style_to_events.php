<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('events', function (Blueprint $table) {
            $table->unsignedTinyInteger('certificate_name_y')->default(47);
            $table->unsignedTinyInteger('certificate_name_size')->default(42);
            $table->string('certificate_name_color', 7)->default('#1e293b');
        });
    }

    public function down(): void
    {
        Schema::table('events', function (Blueprint $table) {
            $table->dropColumn(['certificate_name_y', 'certificate_name_size', 'certificate_name_color']);
        });
    }
};
