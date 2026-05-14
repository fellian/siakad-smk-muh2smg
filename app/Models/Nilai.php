<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Nilai extends Model
{
    use HasFactory;

    protected $table = 'nilais';

    protected $fillable = [
        'siswa_id',
        'mata_pelajaran_id',
        'guru_id',
        'kelas_id',
        'semester',
        'tahun_ajaran_id',
        'nilai_tugas',
        'nilai_ulangan',
        'nilai_uts',
        'nilai_uas',
        'nilai_akhir',
        'predikat',
        'catatan',
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    // Boot: auto hitung nilai akhir & predikat
    protected static function boot(): void
    {
        parent::boot();

        static::saving(function ($nilai) {
            // Hitung nilai akhir otomatis
            $nilai->nilai_akhir = (
                ($nilai->nilai_tugas * 0.20) +
                ($nilai->nilai_ulangan * 0.20) +
                ($nilai->nilai_uts * 0.25) +
                ($nilai->nilai_uas * 0.35)
            );

            // Tentukan predikat
            $na = $nilai->nilai_akhir;
            if ($na >= 85) {
                $nilai->predikat = 'A';
            } elseif ($na >= 75) {
                $nilai->predikat = 'B';
            } elseif ($na >= 60) {
                $nilai->predikat = 'C';
            } elseif ($na >= 50) {
                $nilai->predikat = 'D';
            } else {
                $nilai->predikat = 'E';
            }
        });
    }

    // Relasi ke Siswa
    public function siswa(): BelongsTo
    {
        return $this->belongsTo(Siswa::class);
    }

    // Relasi ke Mata Pelajaran
    public function mataPelajaran(): BelongsTo
    {
        return $this->belongsTo(MataPelajaran::class);
    }

    // Relasi ke Guru
    public function guru(): BelongsTo
    {
        return $this->belongsTo(Guru::class);
    }

    // Relasi ke Kelas
    public function kelas(): BelongsTo
    {
        return $this->belongsTo(Kelas::class);
    }

    // Relasi ke Tahun Ajaran
    public function tahunAjaran(): BelongsTo
    {
        return $this->belongsTo(TahunAjaran::class);
    }
}
