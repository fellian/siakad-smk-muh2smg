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

        // Hitung absensi
        $totalAbsensi = $siswa->absensis()->count();
        $absensiData = [
            'hadir' => $siswa->absensis()->where('status', 'hadir')->count(),
            'izin' => $siswa->absensis()->where('status', 'izin')->count(),
            'sakit' => $siswa->absensis()->where('status', 'sakit')->count(),
            'alpha' => $siswa->absensis()->where('status', 'alpha')->count(),
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

        $absensiData = [
            'hadir' => $siswa->absensis()->where('status', 'hadir')->count(),
            'izin' => $siswa->absensis()->where('status', 'izin')->count(),
            'sakit' => $siswa->absensis()->where('status', 'sakit')->count(),
            'alpha' => $siswa->absensis()->where('status', 'alpha')->count(),
        ];

        $pdf = Pdf::loadView('siswa.rapor.print', compact(
            'siswa', 'nilais', 'tahunAjaran', 'rataRata', 'absensiData'
        ));

        return $pdf->stream('rapor-' . $siswa->nis . '.pdf');
    }
}