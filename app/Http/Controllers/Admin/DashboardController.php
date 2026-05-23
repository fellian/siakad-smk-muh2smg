<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Siswa;
use App\Models\Guru;
use App\Models\Kelas;
use App\Models\Jurusan;
use App\Models\ActivityLog;

class DashboardController extends Controller
{
    public function index()
    {
        $activities = ActivityLog::with('user')->latest()->take(4)->get();

        return view('admin.dashboard', [
            'totalSiswa'   => Siswa::count(),
            'totalGuru'    => Guru::count(),
            'totalKelas'   => Kelas::count(),
            'totalJurusan' => Jurusan::count(),
            'activities'   => $activities,
        ]);
    }
    public function aktivitasSistem()
    {
        $allActivities = ActivityLog::with('user')->latest()->paginate(15);

        return view('admin.aktivitas.index', [
            'activities' => $allActivities
        ]);
    }
}