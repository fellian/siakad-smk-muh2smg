<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Pengumuman extends Model
{
    use HasFactory;

    protected $table = 'pengumumans';

    protected $fillable = [
        'judul',
        'isi',
        'target',
        'tanggal_mulai',
        'tanggal_selesai',
        'user_id',
    ];

    protected $casts = [
        'tanggal_mulai' => 'date',
        'tanggal_selesai' => 'date',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    // Relasi ke User (pembuat pengumuman)
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function scopeAktif($query)
    {
        return $query->where('tanggal_mulai', '<=', now())
            ->where(function ($q) {
                $q->whereNull('tanggal_selesai')
                    ->orWhere('tanggal_selesai', '>=', now());
            });
    }

    public function scopeForRole($query, string $role)
    {
        $targets = match ($role) {
            'siswa' => ['semua', 'siswa'],
            'guru' => ['semua', 'guru'],
            default => ['semua'],
        };

        return $query->whereIn('target', $targets);
    }

    public function isVisibleForRole(string $role): bool
    {
        $targets = match ($role) {
            'siswa' => ['semua', 'siswa'],
            'guru' => ['semua', 'guru'],
            default => ['semua'],
        };

        if (! in_array($this->target, $targets)) {
            return false;
        }

        if ($this->tanggal_mulai->isFuture()) {
            return false;
        }

        if ($this->tanggal_selesai && $this->tanggal_selesai->isPast()) {
            return false;
        }

        return true;
    }
}
