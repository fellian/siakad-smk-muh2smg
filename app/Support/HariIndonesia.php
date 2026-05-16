<?php

namespace App\Support;

use Illuminate\Support\Collection;

final class HariIndonesia
{
    /** @var array<string, int> */
    public const URUTAN_HARI = [
        'Senin' => 1,
        'Selasa' => 2,
        'Rabu' => 3,
        'Kamis' => 4,
        'Jumat' => 5,
        'Sabtu' => 6,
    ];

    public static function urutanHari(string $hari): int
    {
        return self::URUTAN_HARI[$hari] ?? 99;
    }

    /**
     * @param  Collection<int, \App\Models\Jadwal>  $jadwals
     * @return Collection<int, \App\Models\Jadwal>
     */
    public static function sortJadwalCollection(Collection $jadwals): Collection
    {
        return $jadwals->sortBy(function ($jadwal) {
            $noHari = self::urutanHari($jadwal->hari);

            return sprintf('%02d-%s', $noHari, (string) $jadwal->jam_mulai);
        })->values();
    }
}
