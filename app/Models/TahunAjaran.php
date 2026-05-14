<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class TahunAjaran extends Model
{
    use HasFactory;

    protected $table = 'tahun_ajarans';

    protected $fillable = [
        'tahun',
        'semester',
        'status',
    ];

    // Relasi ke Kelas
    public function kelas(): HasMany
    {
        return $this->hasMany(Kelas::class);
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