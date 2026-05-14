<?php

namespace App\Imports;

use App\Models\Siswa;
use Maatwebsite\Excel\Concerns\ToModel;

class SiswaImport implements ToModel
{
    public function model(array $row)
    {
        return new Siswa([
            'nis' => $row[0],
            'nama_lengkap' => $row[1],
            'jenis_kelamin' => $row[2],
            'tanggal_masuk' => $row[3],
        ]);
    }
}