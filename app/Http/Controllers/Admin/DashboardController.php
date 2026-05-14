<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Siswa;
use App\Models\Guru;
use App\Models\Kelas;
use App\Models\Jurusan;

class DashboardController extends Controller
{
    public function index()
{
    return view('admin.dashboard', [
        'totalSiswa' => Siswa::count(),
        'totalGuru' => Guru::count(),
        'totalKelas' => Kelas::count(),
        'totalJurusan' => Jurusan::count(),
    ]);
}
}
