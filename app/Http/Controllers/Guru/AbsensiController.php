<?php

namespace App\Http\Controllers\Guru;

use App\Http\Controllers\Controller;
use App\Models\Absensi;
use App\Models\Jadwal;
use App\Models\Siswa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AbsensiController extends Controller
{
    public function index()
    {
        $guru = Auth::user()->guru;
        
        $jadwals = $guru->jadwals()
            ->with(['kelas', 'mataPelajaran'])
            ->orderByRaw("FIELD(hari, 'Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu')")
            ->orderBy('jam_mulai')
            ->get();

        return view('guru.absensi.index', compact('jadwals'));
    }

    public function inputAbsensi($jadwal_id)
    {
        $guru = Auth::user()->guru;
        $jadwal = Jadwal::with(['kelas.siswas' => function($q) {
            $q->where('status', 'aktif')->orderBy('nama_lengkap');
        }, 'mataPelajaran'])->findOrFail($jadwal_id);

        // Cek kepemilikan jadwal
        if ($jadwal->guru_id !== $guru->id) {
            abort(403, 'Anda tidak berhak mengakses jadwal ini.');
        }

        $tanggal = request('tanggal', now()->format('Y-m-d'));

        // Cek apakah sudah ada absensi untuk tanggal ini
        $absensis = Absensi::where('jadwal_id', $jadwal_id)
            ->where('tanggal', $tanggal)
            ->get()
            ->keyBy('siswa_id');

        return view('guru.absensi.input', compact('jadwal', 'tanggal', 'absensis'));
    }

    public function storeAbsensi(Request $request)
    {
        $request->validate([
            'siswa_id.*' => 'required|exists:siswas,id',
            'status.*' => 'required|in:hadir,izin,sakit,alpha',
        ]);

        $guru = Auth::user()->guru;

        foreach ($request->siswa_id as $index => $siswa_id) {
            Absensi::updateOrCreate(
                [
                    'siswa_id' => $siswa_id,
                    'jadwal_id' => $request->jadwal_id,
                    'tanggal' => $request->tanggal,
                ],
                [
                    'status' => $request->status[$index],
                    'keterangan' => $request->keterangan[$index] ?? null,
                    'guru_id' => $guru->id,
                ]
            );
        }

        return redirect()->back()->with('success', 'Absensi berhasil disimpan!');
    }
}