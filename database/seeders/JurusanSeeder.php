<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Jurusan;

class JurusanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $jurusans = [
            ['kode_jurusan' => 'TSM', 'nama_jurusan' => 'Teknik Sepeda Motor'],
            ['kode_jurusan' => 'TKJ', 'nama_jurusan' => 'Teknik Komputer dan Jaringan'],
            ['kode_jurusan' => 'TKR', 'nama_jurusan' => 'Teknik Kendaraan Ringan'],
            ['kode_jurusan' => 'TAB', 'nama_jurusan' => 'Teknik Alat Berat'],
        ];

        foreach ($jurusans as $jurusan) {
            Jurusan::create($jurusan);
        }
    }
}
