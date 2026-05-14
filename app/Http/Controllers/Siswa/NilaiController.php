<?php

namespace App\Http\Controllers\Siswa;

use App\Http\Controllers\Controller;
use App\Models\TahunAjaran;
use Illuminate\Support\Facades\Auth;

class NilaiController extends Controller
{
    public function index()
    {
        $siswa = Auth::user()->siswa;
        $tahunAjaran = TahunAjaran::where('status', 'aktif')->first();

        $nilais = $siswa->nilais()
            ->with(['mataPelajaran', 'guru'])
            ->where('tahun_ajaran_id', $tahunAjaran?->id)
            ->orderBy('semester')
            ->get()
            ->groupBy('semester');

        // Hitung rata-rata per semester
        $rataRataPerSemester = [];
        foreach ($nilais as $semester => $nilaiList) {
            $rataRataPerSemester[$semester] = $nilaiList->avg('nilai_akhir');
        }

        return view('siswa.nilai.index', compact('siswa', 'nilais', 'tahunAjaran', 'rataRataPerSemester'));
    }
}