<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('pesertas', function (Blueprint $table): void {
            $table->id();
            $table->string('callsign', 100);
            $table->string('nama_peserta', 150);
            $table->dateTime('waktu_checkin');
            $table->string('nomor_sertifikat', 100);
            $table->foreignId('event_id')
                  ->constrained('events')
                  ->onDelete('cascade'); // 🔹 Cascade delete
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pesertas');
    }
};
