<?php

namespace App\Http\Controllers\Siswa;

use App\Http\Controllers\Controller;
use App\Models\TahunAjaran;
use Illuminate\Support\Facades\Auth;

class AbsensiController extends Controller
{
    public function index()
    {
        $siswa = Auth::user()->siswa;
        $tahunAjaran = TahunAjaran::where('status', 'aktif')->first();

        $absensis = $siswa->absensis()
            ->with(['jadwal.mataPelajaran', 'jadwal.guru'])
            ->whereHas('jadwal', function ($q) use ($tahunAjaran) {
                $q->where('tahun_ajaran_id', $tahunAjaran?->id);
            })
            ->orderByDesc('tanggal')
            ->paginate(20);

        // Ringkasan
        $total = $absensis->total();
        $hadir = $siswa->absensis()->where('status', 'hadir')->count();
        $izin = $siswa->absensis()->where('status', 'izin')->count();
        $sakit = $siswa->absensis()->where('status', 'sakit')->count();
        $alpha = $siswa->absensis()->where('status', 'alpha')->count();

        return view('siswa.absensi.index', compact(
            'siswa', 'absensis', 'tahunAjaran',
            'total', 'hadir', 'izin', 'sakit', 'alpha'
        ));
    }
}