<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Siswa;
use App\Models\Kelas;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\SiswaImport;

class SiswaController extends Controller
{
    public function index(Request $request)
    {
        $query = Siswa::with('kelas', 'user');

        if ($request->filled('kelas_id')) {
            $query->where('kelas_id', $request->kelas_id);
        }
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }
        if ($request->filled('search')) {
            $query->where('nama_lengkap', 'like', '%' . $request->search . '%')
                ->orWhere('nis', 'like', '%' . $request->search . '%');
        }

        $siswas = $query->latest()->paginate(20);
        $kelas = Kelas::all();

        return view('admin.siswa.index', compact('siswas', 'kelas'));
    }

    public function create()
    {
        $kelas = Kelas::all();
        return view('admin.siswa.create', compact('kelas'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nis' => 'required|unique:siswas',
            'nisn' => 'nullable|unique:siswas',
            'nama_lengkap' => 'required',
            'jenis_kelamin' => 'required|in:L,P',
            'kelas_id' => 'nullable|exists:kelas,id',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:6',
            'tanggal_masuk' => 'required|date',
        ]);

        // Buat user
        $user = User::create([
            'name' => $request->nama_lengkap,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 'siswa',
        ]);

        // Buat siswa
        $siswaData = $request->except(['email', 'password']);
        $siswaData['user_id'] = $user->id;

        if ($request->hasFile('foto')) {
            $siswaData['foto'] = $request->file('foto')->store('siswa', 'public');
        }

        Siswa::create($siswaData);

        return redirect()->route('admin.siswa.index')->with('success', 'Data siswa berhasil ditambahkan!');
    }

    public function edit(Siswa $siswa)
    {
        $kelas = Kelas::all();
        return view('admin.siswa.edit', compact('siswa', 'kelas'));
    }

    public function show(Siswa $siswa)
    {
        $siswa->load(['kelas.jurusan', 'user', 'nilais.mataPelajaran']);
        return view('admin.siswa.show', compact('siswa'));
    }

    public function update(Request $request, Siswa $siswa)
    {
        $validated = $request->validate([
            'nis' => 'required|unique:siswas,nis,' . $siswa->id,
            'nama_lengkap' => 'required',
            'jenis_kelamin' => 'required|in:L,P',
            'status' => 'required|in:aktif,pindah,keluar,lulus',
        ]);

        $siswa->update($request->except(['email', 'password']));

        // Update user
        $userData = ['name' => $request->nama_lengkap];
        if ($request->filled('email')) {
            $userData['email'] = $request->email;
        }
        if ($request->filled('password')) {
            $userData['password'] = Hash::make($request->password);
        }
        $siswa->user->update($userData);

        return redirect()->route('admin.siswa.index')->with('success', 'Data siswa berhasil diupdate!');
    }

    public function destroy(Siswa $siswa)
    {
        $siswa->user->delete(); // Cascade hapus user
        return redirect()->route('admin.siswa.index')->with('success', 'Data siswa berhasil dihapus!');
    }

    public function import(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:xlsx,csv'
        ]);

        Excel::import(new SiswaImport, $request->file('file'));

        return redirect()->back()->with('success', 'Import data siswa berhasil!');
    }
}
