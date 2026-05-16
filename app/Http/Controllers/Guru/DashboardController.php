<?php

namespace App\Http\Controllers\Guru;

use App\Http\Controllers\Controller;
use App\Models\Nilai;
use App\Models\PresensiSesi;
use App\Models\Siswa;
use App\Models\TahunAjaran;
use Carbon\Carbon;
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
        $hariIni = ucfirst(now()->locale('id')->dayName);
        $jadwalHariIni = $guru->jadwals()
            ->with(['kelas', 'mataPelajaran'])
            ->where('hari', $hariIni)
            ->when($tahunAjaran, fn ($q) => $q->where('tahun_ajaran_id', $tahunAjaran->id))
            ->orderBy('jam_mulai')
            ->get();

        $sesiAktifHariIni = PresensiSesi::query()
            ->whereNull('ditutup_at')
            ->whereDate('tanggal', Carbon::today())
            ->where('guru_id', $guru->id)
            ->whereIn('jadwal_id', $jadwalHariIni->pluck('id'))
            ->get()
            ->keyBy('jadwal_id');

        // Perkiraan total siswa unik dalam kelas yang diajar hari ini
        $kelasIdsHariIni = $jadwalHariIni->pluck('kelas_id')->unique()->filter();
        $totalSiswaHariIni = $kelasIdsHariIni->isEmpty()
            ? 0
            : Siswa::query()->whereIn('kelas_id', $kelasIdsHariIni)->where('status', 'aktif')->count();

        $pengumumans = \App\Models\Pengumuman::forRole('guru')->aktif()->latest()->take(5)->get();

        return view('guru.dashboard', compact(
            'guru',
            'tahunAjaran',
            'totalJadwal',
            'totalKelas',
            'totalMapel',
            'totalNilaiInput',
            'jadwalHariIni',
            'hariIni',
            'sesiAktifHariIni',
            'totalSiswaHariIni',
            'pengumumans'
        ));
    }
}
