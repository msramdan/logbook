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
        Schema::table('events', function (Blueprint $table) {
            $table->boolean('ada_sertifikat')->default(true)->after('tanggal_selesai');
            $table->string('kode_sertifikat', 100)->nullable()->change();
            $table->string('template_sertifikat')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('events', function (Blueprint $table) {
            $table->dropColumn('ada_sertifikat');
            $table->string('kode_sertifikat', 100)->nullable(false)->change();
            $table->string('template_sertifikat')->nullable(false)->change();
        });
    }
};
