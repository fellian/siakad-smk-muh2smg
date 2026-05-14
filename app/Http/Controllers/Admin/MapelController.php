<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Jurusan;
use App\Models\MataPelajaran;
use Illuminate\Http\Request;

class MapelController extends Controller
{
    public function index(Request $request)
    {
        $query = MataPelajaran::with('jurusan');

        if ($request->filled('jurusan_id')) {
            $query->where('jurusan_id', $request->jurusan_id);
        }
        if ($request->filled('kelompok')) {
            $query->where('kelompok', $request->kelompok);
        }
        if ($request->filled('search')) {
            $query->where('nama_mapel', 'like', '%' . $request->search . '%')
                  ->orWhere('kode_mapel', 'like', '%' . $request->search . '%');
        }

        $mapels = $query->latest()->paginate(15);
        $jurusans = Jurusan::all();

        return view('admin.mapel.index', compact('mapels', 'jurusans'));
    }

    public function create()
    {
        $jurusans = Jurusan::all();
        return view('admin.mapel.create', compact('jurusans'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'kode_mapel' => 'required|string|max:20|unique:mata_pelajarans',
            'nama_mapel' => 'required|string|max:255',
            'jurusan_id' => 'nullable|exists:jurusans,id',
            'kelompok' => 'required|integer|in:1,2,3',
            'kkm' => 'required|integer|min:0|max:100',
            'keterangan' => 'nullable|string',
        ]);

        MataPelajaran::create($request->all());

        return redirect()->route('admin.mapel.index')->with('success', 'Mata pelajaran berhasil ditambahkan!');
    }

    public function edit(MataPelajaran $mapel)
    {
        $jurusans = Jurusan::all();
        return view('admin.mapel.edit', compact('mapel', 'jurusans'));
    }

    public function update(Request $request, MataPelajaran $mapel)
    {
        $request->validate([
            'kode_mapel' => 'required|string|max:20|unique:mata_pelajarans,kode_mapel,' . $mapel->id,
            'nama_mapel' => 'required|string|max:255',
            'jurusan_id' => 'nullable|exists:jurusans,id',
            'kelompok' => 'required|integer|in:1,2,3',
            'kkm' => 'required|integer|min:0|max:100',
            'keterangan' => 'nullable|string',
        ]);

        $mapel->update($request->all());

        return redirect()->route('admin.mapel.index')->with('success', 'Mata pelajaran berhasil diperbarui!');
    }

    public function destroy(MataPelajaran $mapel)
    {
        if ($mapel->jadwals()->count() > 0 || $mapel->nilais()->count() > 0) {
            return redirect()->route('admin.mapel.index')
                ->with('error', 'Mata pelajaran tidak bisa dihapus karena masih digunakan di jadwal atau nilai!');
        }

        $mapel->delete();
        return redirect()->route('admin.mapel.index')->with('success', 'Mata pelajaran berhasil dihapus!');
    }
}