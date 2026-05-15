<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\DB;

class TahunAjaran extends Model
{
    use HasFactory;

    protected $table = 'tahun_ajarans';

    protected $fillable = [
        'tahun',
        'semester',
        'status',
    ];

    public function isAktif(): bool
    {
        return $this->status === 'aktif';
    }

    public static function setAsOnlyActive(self $tahunAjaran): void
    {
        DB::transaction(function () use ($tahunAjaran) {
            static::where('id', '!=', $tahunAjaran->id)->update(['status' => 'nonaktif']);
            $tahunAjaran->update(['status' => 'aktif']);
        });
    }

    public static function active(): ?self
    {
        return static::where('status', 'aktif')->first();
    }

    public function getLabelAttribute(): string
    {
        return "{$this->tahun} — Semester {$this->semester}";
    }

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