<?php

namespace App\Http\Controllers\Siswa;

use App\Http\Controllers\Controller;
use App\Models\TahunAjaran;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Auth;

class RaporController extends Controller
{
    public function index()
    {
        $siswa = Auth::user()->siswa;
        $tahunAjaran = TahunAjaran::where('status', 'aktif')->first();

        $nilais = $siswa->nilais()
            ->with(['mataPelajaran', 'guru'])
            ->where('tahun_ajaran_id', $tahunAjaran?->id)
            ->orderBy('semester')
            ->get();

        // Hitung rata-rata
        $rataRata = $nilais->avg('nilai_akhir');

        $absensiBase = fn () => $siswa->absensis()->when($tahunAjaran?->id, fn ($q) => $q->whereHas('jadwal', fn ($jq) => $jq->where('tahun_ajaran_id', $tahunAjaran->id)));

        $totalAbsensi = $absensiBase()->count();
        $absensiData = [
            'hadir' => $absensiBase()->where('status', 'hadir')->count(),
            'terlambat' => $absensiBase()->where('status', 'terlambat')->count(),
            'izin' => $absensiBase()->where('status', 'izin')->count(),
            'sakit' => $absensiBase()->where('status', 'sakit')->count(),
            'alfa' => $absensiBase()->where('status', 'alfa')->count(),
        ];

        return view('siswa.rapor.index', compact(
            'siswa', 'nilais', 'tahunAjaran', 'rataRata', 'absensiData', 'totalAbsensi'
        ));
    }

    public function print()
    {
        $siswa = Auth::user()->siswa;
        $tahunAjaran = TahunAjaran::where('status', 'aktif')->first();

        $nilais = $siswa->nilais()
            ->with(['mataPelajaran', 'guru'])
            ->where('tahun_ajaran_id', $tahunAjaran?->id)
            ->orderBy('semester')
            ->get();

        $rataRata = $nilais->avg('nilai_akhir');

        $absensiBase = fn () => $siswa->absensis()->when($tahunAjaran?->id, fn ($q) => $q->whereHas('jadwal', fn ($jq) => $jq->where('tahun_ajaran_id', $tahunAjaran->id)));

        $absensiData = [
            'hadir' => $absensiBase()->where('status', 'hadir')->count(),
            'terlambat' => $absensiBase()->where('status', 'terlambat')->count(),
            'izin' => $absensiBase()->where('status', 'izin')->count(),
            'sakit' => $absensiBase()->where('status', 'sakit')->count(),
            'alfa' => $absensiBase()->where('status', 'alfa')->count(),
        ];

        $pdf = Pdf::loadView('siswa.rapor.print', compact(
            'siswa', 'nilais', 'tahunAjaran', 'rataRata', 'absensiData'
        ));

        return $pdf->stream('rapor-' . $siswa->nis . '.pdf');
    }
}