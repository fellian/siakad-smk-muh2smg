<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('absensis', function (Blueprint $table) {
            $table->foreignId('presensi_sesi_id')
                ->nullable()
                ->after('guru_id')
                ->constrained('presensi_sesis')
                ->nullOnDelete();
            $table->timestamp('waktu_presensi')->nullable()->after('presensi_sesi_id');
            $table->unique(['presensi_sesi_id', 'siswa_id'], 'absensis_sesi_siswa_unique');
        });

        $driver = Schema::getConnection()->getDriverName();

        if ($driver === 'mysql') {
            DB::statement("UPDATE absensis SET status = 'alfa' WHERE status = 'alpha'");
            DB::statement("ALTER TABLE absensis MODIFY COLUMN status ENUM('hadir','terlambat','izin','sakit','alfa') NOT NULL");
        } elseif ($driver === 'sqlite') {
            DB::table('absensis')->where('status', 'alpha')->update(['status' => 'alfa']);
        }
    }

    public function down(): void
    {
        Schema::table('absensis', function (Blueprint $table) {
            $table->dropForeign(['presensi_sesi_id']);
            $table->dropUnique('absensis_sesi_siswa_unique');
            $table->dropColumn(['presensi_sesi_id', 'waktu_presensi']);
        });

        $driver = Schema::getConnection()->getDriverName();

        if ($driver === 'mysql') {
            DB::statement("UPDATE absensis SET status = 'alpha' WHERE status = 'alfa'");
            DB::statement("ALTER TABLE absensis MODIFY COLUMN status ENUM('hadir','izin','sakit','alpha') NOT NULL");
        } elseif ($driver === 'sqlite') {
            DB::table('absensis')->where('status', 'alfa')->update(['status' => 'alpha']);
            DB::table('absensis')->where('status', 'terlambat')->update(['status' => 'hadir']);
        }
    }
};
