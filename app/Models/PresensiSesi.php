<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class PresensiSesi extends Model
{
    use HasFactory;

    protected $table = 'presensi_sesis';

    protected $fillable = [
        'jadwal_id',
        'tanggal',
        'guru_id',
        'dibuka_at',
        'ditutup_at',
    ];

    protected function casts(): array
    {
        return [
            'tanggal' => 'date',
            'dibuka_at' => 'datetime',
            'ditutup_at' => 'datetime',
        ];
    }

    public function jadwal(): BelongsTo
    {
        return $this->belongsTo(Jadwal::class);
    }

    public function guru(): BelongsTo
    {
        return $this->belongsTo(Guru::class);
    }

    public function absensis(): HasMany
    {
        return $this->hasMany(Absensi::class);
    }

    public function aktif(): bool
    {
        return $this->ditutup_at === null;
    }
}
