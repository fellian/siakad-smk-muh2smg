<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Siswa;
use App\Models\Kelas;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
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
            $query->where(function ($q) use ($request) {
                $q->where('nama_lengkap', 'like', '%' . $request->search . '%')
                    ->orWhere('nis', 'like', '%' . $request->search . '%');
            });
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
            'nis'           => 'required|unique:siswas,nis',
            'nisn'          => 'nullable|unique:siswas,nisn',
            'nama_lengkap'  => 'required',
            'jenis_kelamin' => 'required|in:L,P',
            'kelas_id'      => 'nullable|exists:kelas,id',
            'email_siswa'   => 'nullable|email|unique:siswas,email',
            'email_login'   => 'required|email|unique:users,email',   
            'password'      => 'required|min:6',
            'tanggal_masuk' => 'required|date',
            'foto'          => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        // 2. Buat akun login di tabel Users
        $user = User::create([
            'name'     => $request->nama_lengkap,
            'email'    => $request->email_login,
            'password' => Hash::make($request->password),
            'role'     => 'siswa',
        ]);

        // 3. Siapkan data siswa untuk tabel Siswas
        $siswaData = $request->except([
            'email_siswa',
            'email_login',
            'password',
            'foto'
        ]);

        $siswaData['user_id'] = $user->id;
        $siswaData['email']   = $request->email_siswa; 

        if ($request->hasFile('foto')) {
            $siswaData['foto'] = $request->file('foto')->store('siswa', 'public');
        }

        Siswa::create($siswaData);

        return redirect()
            ->route('admin.siswa.index')
            ->with('success', 'Data siswa berhasil ditambahkan!');
    }

    public function edit(Siswa $siswa)
    {
        $kelas = Kelas::all();
        return view('admin.siswa.edit', compact('siswa', 'kelas'));
    }

    public function show(Siswa $siswa)
    {
        $siswa->load([
            'kelas.jurusan',
            'user',
            'nilais.mataPelajaran'
        ]);

        return view('admin.siswa.show', compact('siswa'));
    }

    public function update(Request $request, Siswa $siswa)
    {

        $validated = $request->validate([
            'nis'           => 'required|unique:siswas,nis,' . $siswa->id,
            'nisn'          => 'nullable|unique:siswas,nisn,' . $siswa->id,
            'nama_lengkap'  => 'required',
            'jenis_kelamin' => 'required|in:L,P',
            'kelas_id'      => 'nullable|exists:kelas,id',
            'email_siswa'   => 'nullable|email|unique:siswas,email,' . $siswa->id,
            'email_login'   => 'required|email|unique:users,email,' . $siswa->user_id,
            'status'        => 'required|in:aktif,pindah,keluar,lulus',
            'foto'          => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        // 2. Olah data tabel Siswas
        $siswaData = $request->except([
            'email_siswa',
            'email_login',
            'password',
            'foto',
            'hapus_foto'
        ]);

        $siswaData['email'] = $request->email_siswa;

        // Manajemen file foto
        if ($request->hasFile('foto')) {
            if ($siswa->foto && Storage::disk('public')->exists($siswa->foto)) {
                Storage::disk('public')->delete($siswa->foto);
            }
            $siswaData['foto'] = $request->file('foto')->store('siswa', 'public');
        }

        if ($request->hapus_foto == 1) {
            if ($siswa->foto && Storage::disk('public')->exists($siswa->foto)) {
                Storage::disk('public')->delete($siswa->foto);
            }
            $siswaData['foto'] = null;
        }

        $siswa->update($siswaData);

        // 3. Olah data tabel Users
        $userData = [
            'name'  => $request->nama_lengkap,
            'email' => $request->email_login
        ];

        if ($request->filled('password')) {
            $userData['password'] = Hash::make($request->password);
        }

        $siswa->user->update($userData);

        return redirect()
            ->route('admin.siswa.index')
            ->with('success', 'Data siswa berhasil diupdate!');
    }

    public function destroy(Siswa $siswa)
    {
        if ($siswa->foto && Storage::disk('public')->exists($siswa->foto)) {
            Storage::disk('public')->delete($siswa->foto);
        }

        $siswa->user->delete();
        $siswa->delete();

        return redirect()
            ->route('admin.siswa.index')
            ->with('success', 'Data siswa berhasil dihapus!');
    }

    public function import(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:xlsx,csv'
        ]);

        Excel::import(new SiswaImport, $request->file('file'));

        return redirect()
            ->back()
            ->with('success', 'Import data siswa berhasil!');
    }
}
