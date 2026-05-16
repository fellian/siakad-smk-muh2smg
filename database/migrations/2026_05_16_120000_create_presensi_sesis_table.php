<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('presensi_sesis', function (Blueprint $table) {
            $table->id();
            $table->foreignId('jadwal_id')->constrained('jadwals')->onDelete('cascade');
            $table->date('tanggal');
            $table->foreignId('guru_id')->constrained('gurus')->onDelete('cascade');
            $table->timestamp('dibuka_at');
            $table->timestamp('ditutup_at')->nullable();
            $table->timestamps();

            $table->index(['jadwal_id', 'tanggal']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('presensi_sesis');
    }
};
