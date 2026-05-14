<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class MataPelajaran extends Model
{
    use HasFactory;

    protected $table = 'mata_pelajarans';

    protected $fillable = [
        'kode_mapel',
        'nama_mapel',
        'jurusan_id',
        'kelompok',
        'kkm',
        'keterangan',
    ];

    // Relasi ke Jurusan
    public function jurusan(): BelongsTo
    {
        return $this->belongsTo(Jurusan::class);
    }

    // Relasi ke Guru (many-to-many via guru_mapel)
    public function gurus(): BelongsToMany
    {
        return $this->belongsToMany(Guru::class, 'guru_mapel');
    }

    // Relasi ke Jadwal
    public function jadwals(): HasMany
    {
        return $this->hasMany(Jadwal::class);
    }

    // Relasi ke Nilai
    public function nilais(): HasMany
    {
        return $this->hasMany(Nilai::class, 'mata_pelajaran_id');
    }
}