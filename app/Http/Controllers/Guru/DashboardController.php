<?php

namespace App\Http\Controllers\Guru;

use App\Http\Controllers\Controller;
use App\Models\Guru;
use App\Models\Jadwal;
use App\Models\Nilai;
use App\Models\TahunAjaran;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $guru = Auth::user()->guru;
        $tahunAjaran = TahunAjaran::where('status', 'aktif')->first();

        // Statistik
        $totalJadwal = $guru->jadwals()->where('tahun_ajaran_id', $tahunAjaran?->id)->count();
        $totalKelas = $guru->jadwals()->where('tahun_ajaran_id', $tahunAjaran?->id)->distinct('kelas_id')->count('kelas_id');
        $totalMapel = $guru->jadwals()->where('tahun_ajaran_id', $tahunAjaran?->id)->distinct('mata_pelajaran_id')->count('mata_pelajaran_id');
        $totalNilaiInput = Nilai::where('guru_id', $guru->id)->where('tahun_ajaran_id', $tahunAjaran?->id)->count();

        // Jadwal hari ini
        $hariIni = now()->locale('id')->dayName;
        $jadwalHariIni = $guru->jadwals()
            ->with(['kelas', 'mataPelajaran'])
            ->where('hari', ucfirst($hariIni))
            ->where('tahun_ajaran_id', $tahunAjaran?->id)
            ->orderBy('jam_mulai')
            ->get();

        // Pengumuman untuk guru
        $pengumumans = \App\Models\Pengumuman::whereIn('target', ['semua', 'guru'])
            ->where('tanggal_mulai', '<=', now())
            ->where(function ($q) {
                $q->whereNull('tanggal_selesai')->orWhere('tanggal_selesai', '>=', now());
            })
            ->latest()
            ->take(5)
            ->get();

        return view('guru.dashboard', compact(
            'guru',
            'tahunAjaran',
            'totalJadwal',
            'totalKelas',
            'totalMapel',
            'totalNilaiInput',
            'jadwalHariIni',
            'hariIni',
            'pengumumans'
        ));
    }
}