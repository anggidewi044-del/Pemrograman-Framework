<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('events', function (Blueprint $table) {
            $table->string('certificate_template_path')->nullable();
            $table->string('certificate_template_name')->nullable();
            $table->timestamp('certificate_generated_at')->nullable();
        });
    }

    public function down(): void
    {
        Schema::table('events', function (Blueprint $table) {
            $table->dropColumn(['certificate_template_path', 'certificate_template_name', 'certificate_generated_at']);
        });
    }
};
