<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Kelas extends Model
{
    use HasFactory;

    protected $table = 'kelas';

    protected $fillable = [
        'kode_kelas',
        'nama_kelas',
        'jurusan_id',
        'tingkat',
        'wali_kelas_id',
        'tahun_ajaran_id',
    ];

    // Relasi ke Jurusan
    public function jurusan(): BelongsTo
    {
        return $this->belongsTo(Jurusan::class);
    }

    // Relasi ke Guru (wali kelas)
    public function waliKelas(): BelongsTo
    {
        return $this->belongsTo(Guru::class, 'wali_kelas_id');
    }

    // Relasi ke Tahun Ajaran
    public function tahunAjaran(): BelongsTo
    {
        return $this->belongsTo(TahunAjaran::class);
    }

    // Relasi ke Siswa
    public function siswas(): HasMany
    {
        return $this->hasMany(Siswa::class);
    }

    // Relasi ke Jadwal
    public function jadwals(): HasMany
    {
        return $this->hasMany(Jadwal::class);
    }

    // Relasi ke Nilai
    public function nilais(): HasMany
    {
        return $this->hasMany(Nilai::class);
    }
}