<?php

namespace Database\Seeders;

use App\Models\TahunAjaran;
use Illuminate\Database\Seeder;

class TahunAjaranSeeder extends Seeder
{
    public function run(): void
    {
        $items = [
            ['tahun' => '2024/2025', 'semester' => '1', 'status' => 'nonaktif'],
            ['tahun' => '2024/2025', 'semester' => '2', 'status' => 'nonaktif'],
            ['tahun' => '2025/2026', 'semester' => '1', 'status' => 'nonaktif'],
            ['tahun' => '2025/2026', 'semester' => '2', 'status' => 'aktif'],
        ];

        foreach ($items as $item) {
            TahunAjaran::firstOrCreate(
                ['tahun' => $item['tahun'], 'semester' => $item['semester']],
                ['status' => $item['status']]
            );
        }

        $aktif = TahunAjaran::where('status', 'aktif')->first();
        if ($aktif) {
            TahunAjaran::setAsOnlyActive($aktif);
        }
    }
}
