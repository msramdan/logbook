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
        Schema::create(table: 'events', callback: function (Blueprint $table): void {
            $table->id();
            $table->string('nama_event', 255);
            $table->dateTime('tanggal_mulai');
            $table->dateTime('tanggal_selesai');
            $table->string('kode_sertifikat', 100);
            $table->string('template_sertifikat');
            $table->string('nama_ncs', 150);
            $table->string('callsign_ncs', 150);
            $table->string('poster');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists(table: 'events');
    }
};
