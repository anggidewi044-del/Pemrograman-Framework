<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function fill_data(): void {}

    public function up(): void
    {
        Schema::create('events', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('speaker');
            $table->string('date');
            $table->string('time')->nullable();
            $table->string('location');
            $table->text('description')->nullable();
            $table->integer('quota_max')->default(100);
            $table->integer('quota_used')->default(0);
            $table->string('status')->default('aktif'); // aktif, draft, selesai
            $table->string('image')->nullable(); // path to image
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('events');
    }
};
