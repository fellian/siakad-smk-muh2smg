<?php

namespace App\Http\Controllers\Siswa;

use App\Http\Controllers\Controller;
use App\Models\Pengumuman;
use App\Models\TahunAjaran;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $siswa = Auth::user()->siswa;
        $tahunAjaran = TahunAjaran::where('status', 'aktif')->first();

        // Statistik
        $totalMapel = $siswa->nilais()->where('tahun_ajaran_id', $tahunAjaran?->id)->count();
        $rataRata = $siswa->nilais()->where('tahun_ajaran_id', $tahunAjaran?->id)->avg('nilai_akhir');
        
        $totalAbsensi = $siswa->absensis()->count();
        $persenHadir = $totalAbsensi > 0 
            ? round(($siswa->absensis()->where('status', 'hadir')->count() / $totalAbsensi) * 100) 
            : 0;

        // Jadwal hari ini
        $hariIni = now()->locale('id')->dayName;
        $jadwalHariIni = $siswa->kelas?->jadwals()
            ->with(['mataPelajaran', 'guru'])
            ->where('hari', ucfirst($hariIni))
            ->where('tahun_ajaran_id', $tahunAjaran?->id)
            ->orderBy('jam_mulai')
            ->get() ?? collect();

        // Pengumuman untuk siswa
        $pengumumans = Pengumuman::whereIn('target', ['semua', 'siswa'])
            ->where('tanggal_mulai', '<=', now())
            ->where(function ($q) {
                $q->whereNull('tanggal_selesai')->orWhere('tanggal_selesai', '>=', now());
            })
            ->latest()
            ->take(5)
            ->get();

        return view('siswa.dashboard', compact(
            'siswa',
            'tahunAjaran',
            'totalMapel',
            'rataRata',
            'persenHadir',
            'jadwalHariIni',
            'hariIni',
            'pengumumans'
        ));
    }

    public function pengumuman()
    {
        $pengumumans = Pengumuman::whereIn('target', ['semua', 'siswa'])
            ->where('tanggal_mulai', '<=', now())
            ->where(function ($q) {
                $q->whereNull('tanggal_selesai')->orWhere('tanggal_selesai', '>=', now());
            })
            ->latest()
            ->paginate(10);

        return view('siswa.pengumuman', compact('pengumumans'));
    }
}