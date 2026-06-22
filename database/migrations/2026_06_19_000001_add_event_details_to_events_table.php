<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('events', function (Blueprint $table) {
            $table->string('category')->nullable()->after('speaker');
            $table->integer('price')->default(0)->after('quota_used');
            $table->string('contact_phone')->nullable()->after('price');
            $table->text('materi')->nullable()->after('description');
        });
    }

    public function down(): void
    {
        Schema::table('events', function (Blueprint $table) {
            $table->dropColumn(['category', 'price', 'contact_phone', 'materi']);
        });
    }
};
