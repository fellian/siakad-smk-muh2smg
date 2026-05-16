<?php

namespace App\Http\Controllers\Siswa;

use App\Http\Controllers\Controller;
use App\Models\TahunAjaran;
use App\Support\HariIndonesia;
use Illuminate\Support\Facades\Auth;

class JadwalController extends Controller
{
    public function index()
    {
        $siswa = Auth::user()->siswa;
        $tahunAjaran = TahunAjaran::where('status', 'aktif')->first();

        $jadwals = collect();
        if ($siswa->kelas) {
            $jadwals = HariIndonesia::sortJadwalCollection(
                $siswa->kelas->jadwals()
                    ->with(['mataPelajaran', 'guru'])
                    ->where('tahun_ajaran_id', $tahunAjaran?->id)
                    ->get()
            )->groupBy('hari');
        }

        $hariOrder = ['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu'];

        return view('siswa.jadwal.index', compact('siswa', 'jadwals', 'hariOrder', 'tahunAjaran'));
    }
}