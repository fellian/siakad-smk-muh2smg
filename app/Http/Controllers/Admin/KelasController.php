<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Guru;
use App\Models\Jurusan;
use App\Models\Kelas;
use App\Models\TahunAjaran;
use Illuminate\Http\Request;

class KelasController extends Controller
{
    public function index()
    {
        $kelas = Kelas::with(['jurusan', 'waliKelas', 'tahunAjaran', 'siswas'])
            ->orderBy('tingkat')
            ->orderBy('nama_kelas')
            ->get();
            
        return view('admin.kelas.index', compact('kelas'));
    }

    public function create()
    {
        $jurusans = Jurusan::all();
        $gurus = Guru::where('status', 'aktif')->get();
        $tahunAjarans = TahunAjaran::orderBy('tahun', 'desc')->get();
        
        return view('admin.kelas.create', compact('jurusans', 'gurus', 'tahunAjarans'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'kode_kelas' => 'required|string|max:20|unique:kelas',
            'nama_kelas' => 'required|string|max:255',
            'jurusan_id' => 'required|exists:jurusans,id',
            'tingkat' => 'required|in:10,11,12',
            'wali_kelas_id' => 'nullable|exists:gurus,id',
            'tahun_ajaran_id' => 'required|exists:tahun_ajarans,id',
        ]);

        Kelas::create($request->all());

        return redirect()->route('admin.kelas.index')->with('success', 'Kelas berhasil ditambahkan!');
    }

    public function show(Kelas $kelas)
    {
        $kelas->load(['jurusan', 'waliKelas', 'tahunAjaran', 'siswas.user', 'jadwals']);
        return view('admin.kelas.show', compact('kelas'));
    }

    public function edit(Kelas $kelas)
    {
        $jurusans = Jurusan::all();
        $gurus = Guru::where('status', 'aktif')->get();
        $tahunAjarans = TahunAjaran::orderBy('tahun', 'desc')->get();
        
        return view('admin.kelas.edit', compact('kelas', 'jurusans', 'gurus', 'tahunAjarans'));
    }

    public function update(Request $request, Kelas $kelas)
    {
        $request->validate([
            'kode_kelas' => 'required|string|max:20|unique:kelas,kode_kelas,' . $kelas->id,
            'nama_kelas' => 'required|string|max:255',
            'jurusan_id' => 'required|exists:jurusans,id',
            'tingkat' => 'required|in:10,11,12',
            'wali_kelas_id' => 'nullable|exists:gurus,id',
            'tahun_ajaran_id' => 'required|exists:tahun_ajarans,id',
        ]);

        $kelas->update($request->all());

        return redirect()->route('admin.kelas.index')->with('success', 'Kelas berhasil diperbarui!');
    }

    public function destroy(Kelas $kelas)
    {
        if ($kelas->siswas()->count() > 0 || $kelas->jadwals()->count() > 0) {
            return redirect()->route('admin.kelas.index')
                ->with('error', 'Kelas tidak bisa dihapus karena masih memiliki siswa atau jadwal!');
        }

        $kelas->delete();
        return redirect()->route('admin.kelas.index')->with('success', 'Kelas berhasil dihapus!');
    }
}