<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Guru extends Model
{
    use HasFactory;

    protected $table = 'gurus';

    protected $fillable = [
        'nip',
        'nuptk',
        'nama_lengkap',
        'jenis_kelamin',
        'tempat_lahir',
        'tanggal_lahir',
        'alamat',
        'no_hp',
        'email',
        'pendidikan_terakhir',
        'jurusan_pendidikan',
        'status',
        'foto',
        'user_id',
    ];

    protected $casts = [
        'tanggal_lahir' => 'date',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    // Relasi ke User
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    // Relasi ke Kelas (sebagai wali kelas)
    public function kelasWali(): HasOne
    {
        return $this->hasOne(Kelas::class, 'wali_kelas_id');
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

    // Relasi ke Absensi
    public function absensis(): HasMany
    {
        return $this->hasMany(Absensi::class);
    }

    // Relasi ke Mata Pelajaran (many-to-many)
    public function mataPelajarans(): BelongsToMany
    {
        return $this->belongsToMany(MataPelajaran::class, 'guru_mapel');
    }
}
