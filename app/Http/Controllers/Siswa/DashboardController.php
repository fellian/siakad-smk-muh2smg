<?php

namespace App\Http\Controllers\Siswa;

use App\Http\Controllers\Controller;
use App\Models\Pengumuman;
use App\Models\PresensiSesi;
use App\Models\TahunAjaran;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $siswa = Auth::user()->siswa;
        $tahunAjaran = TahunAjaran::where('status', 'aktif')->first();

        $scopedPresensi = fn () => $siswa->absensis()
            ->when($tahunAjaran?->id, fn ($q) => $q->whereHas('jadwal', fn ($jq) => $jq->where('tahun_ajaran_id', $tahunAjaran->id)));

        $totalAbsensiTercatat = $scopedPresensi()->count();

        $tanpaAlfaCount = $scopedPresensi()->where('status', '!=', 'alfa')->count();

        $persenHadir = $totalAbsensiTercatat > 0
            ? round(($tanpaAlfaCount / max(1, $totalAbsensiTercatat)) * 100)
            : 0;

        // Jadwal hari ini
        $hariIni = ucfirst(now()->locale('id')->dayName);
        $jadwalHariIni = collect();
        if ($siswa->kelas) {
            $jadwalHariIni = $siswa->kelas->jadwals()
                ->with(['mataPelajaran', 'guru'])
                ->where('hari', $hariIni)
                ->where('tahun_ajaran_id', $tahunAjaran?->id)
                ->orderBy('jam_mulai')
                ->get();
        }

        // Presensi siswa dibuka guru — sesi aktif kelas siswa pada hari ini
        $kelasId = $siswa->kelas_id;
        $sesiPresensiAktif = collect();
        if ($kelasId) {
            $sesiPresensiAktif = PresensiSesi::query()
                ->whereNull('ditutup_at')
                ->whereDate('tanggal', Carbon::today())
                ->whereHas(
                    'jadwal',
                    fn ($q) => $q->where('kelas_id', $kelasId)
                        ->when($tahunAjaran?->id, fn ($qq) => $qq->where('tahun_ajaran_id', $tahunAjaran->id))
                )
                ->with(['jadwal.mataPelajaran', 'jadwal.guru', 'guru'])
                ->get()
                ->sortBy(fn (PresensiSesi $s) => (string) $s->jadwal?->jam_mulai)
                ->values();
        }

        $presensiSudahIds = collect();
        if ($sesiPresensiAktif->isNotEmpty()) {
            $presensiSudahIds = $siswa->absensis()
                ->whereIn(
                    'presensi_sesi_id',
                    $sesiPresensiAktif->pluck('id')
                )
                ->pluck('presensi_sesi_id');
        }

        // Ringkasan kehadiran bulan berjalan
        $startBulanIni = Carbon::now()->startOfMonth();
        $scopedBulanIni = fn () => $siswa->absensis()->whereBetween('tanggal', [$startBulanIni->format('Y-m-d'), Carbon::now()->format('Y-m-d')])
            ->when($tahunAjaran?->id, fn ($q) => $q->whereHas('jadwal', fn ($jq) => $jq->where('tahun_ajaran_id', $tahunAjaran->id)));

        $hadirBulanIni = $scopedBulanIni()->where('status', 'hadir')->count();
        $terlambatBulanIni = $scopedBulanIni()->where('status', 'terlambat')->count();
        $alfaBulanIni = $scopedBulanIni()->where('status', 'alfa')->count();

        $nilaisTerbaru = $siswa->nilais()
            ->with(['mataPelajaran'])
            ->when($tahunAjaran?->id, fn ($q) => $q->where('tahun_ajaran_id', $tahunAjaran->id))
            ->orderByDesc('updated_at')
            ->take(3)
            ->get();

        $pengumumans = Pengumuman::forRole('siswa')->aktif()->latest()->take(5)->get();

        return view('siswa.dashboard', compact(
            'siswa',
            'tahunAjaran',
            'persenHadir',
            'totalAbsensiTercatat',
            'jadwalHariIni',
            'hariIni',
            'sesiPresensiAktif',
            'presensiSudahIds',
            'hadirBulanIni',
            'terlambatBulanIni',
            'alfaBulanIni',
            'nilaisTerbaru',
            'pengumumans'
        ));
    }

}
