<?php

namespace App\Http\Controllers\Guru;

use App\Http\Controllers\Controller;
use App\Models\Kelas;
use App\Models\MataPelajaran;
use App\Models\Nilai;
use App\Models\Siswa;
use App\Models\TahunAjaran;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NilaiController extends Controller
{
    public function index()
    {
        $guru = Auth::user()->guru;
        $tahunAjaran = TahunAjaran::where('status', 'aktif')->first();

        $jadwalRaw = $guru->jadwals()
            ->where('tahun_ajaran_id', $tahunAjaran?->id)
            ->with(['kelas.jurusan', 'mataPelajaran'])
            ->get();

        $kelasDiampu = $jadwalRaw->unique(function ($item) {
            return $item->kelas_id . '-' . $item->mata_pelajaran_id;
        });

        return view('guru.nilai.index', compact('kelasDiampu', 'tahunAjaran'));
    }

    public function inputNilai(Request $request, $kelas_id, $mapel_id)
    {
        $guru = Auth::user()->guru;
        $kelas = Kelas::findOrFail($kelas_id);
        $mapel = MataPelajaran::findOrFail($mapel_id);
        $tahunAjaran = TahunAjaran::where('status', 'aktif')->first();

        $semester = $request->get('semester', '1');

        $jadwal = $guru->jadwals()
            ->where('kelas_id', $kelas_id)
            ->where('mata_pelajaran_id', $mapel_id)
            ->where('tahun_ajaran_id', $tahunAjaran?->id)
            ->first();

        if (!$jadwal) {
            abort(403, 'Anda tidak mengajar mapel ini di kelas tersebut.');
        }

        $siswas = Siswa::where('kelas_id', $kelas_id)
            ->where('status', 'aktif')
            ->orderBy('nama_lengkap')
            ->get();

        $nilais = Nilai::where('kelas_id', $kelas_id)
            ->where('mata_pelajaran_id', $mapel_id)
            ->where('guru_id', $guru->id)
            ->where('semester', $semester)
            ->where('tahun_ajaran_id', $tahunAjaran?->id)
            ->get()
            ->keyBy('siswa_id');

        return view('guru.nilai.input', compact('kelas', 'mapel', 'siswas', 'nilais', 'semester', 'tahunAjaran'));
    }

    public function storeNilai(Request $request)
    {
        $request->validate([
            'siswa_id.*' => 'required|exists:siswas,id',
            'nilai_tugas.*' => 'required|numeric|min:0|max:100',
            'nilai_ulangan.*' => 'required|numeric|min:0|max:100',
            'nilai_uts.*' => 'required|numeric|min:0|max:100',
            'nilai_uas.*' => 'required|numeric|min:0|max:100',
        ]);

        $guru = Auth::user()->guru;
        $tahunAjaran = TahunAjaran::where('status', 'aktif')->first();

        foreach ($request->siswa_id as $index => $siswa_id) {
            Nilai::updateOrCreate(
                [
                    'siswa_id' => $siswa_id,
                    'mata_pelajaran_id' => $request->mata_pelajaran_id,
                    'guru_id' => $guru->id,
                    'kelas_id' => $request->kelas_id,
                    'semester' => $request->semester,
                    'tahun_ajaran_id' => $tahunAjaran?->id,
                ],
                [
                    'nilai_tugas' => $request->nilai_tugas[$index],
                    'nilai_ulangan' => $request->nilai_ulangan[$index],
                    'nilai_uts' => $request->nilai_uts[$index],
                    'nilai_uas' => $request->nilai_uas[$index],
                ]
            );
        }

        return redirect()->back()->with('success', 'Nilai berhasil disimpan!');
    }

    public function rekap(Request $request, $kelas_id, $mapel_id)
    {
        $guru = Auth::user()->guru;
        $kelas = Kelas::with('jurusan')->findOrFail($kelas_id);
        $mapel = MataPelajaran::findOrFail($mapel_id);
        $tahunAjaran = TahunAjaran::where('status', 'aktif')->first();

        $semester = $request->get('semester', '1');

        $jadwal = $guru->jadwals()
            ->where('kelas_id', $kelas_id)
            ->where('mata_pelajaran_id', $mapel_id)
            ->where('tahun_ajaran_id', $tahunAjaran?->id)
            ->first();

        if (!$jadwal) {
            abort(403, 'Anda tidak memiliki hak akses untuk rekap nilai kelas ini.');
        }

        $siswas = Siswa::where('kelas_id', $kelas_id)
            ->where('status', 'aktif')
            ->orderBy('nama_lengkap')
            ->get();

        $nilais = Nilai::where('kelas_id', $kelas_id)
            ->where('mata_pelajaran_id', $mapel_id)
            ->where('guru_id', $guru->id)
            ->where('semester', $semester)
            ->where('tahun_ajaran_id', $tahunAjaran?->id)
            ->get();

        return view('guru.nilai.rekap', compact('kelas', 'mapel', 'siswas', 'nilais', 'semester', 'tahunAjaran'));
    }
}
