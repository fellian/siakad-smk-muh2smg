<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Guru;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class GuruController extends Controller
{
    public function index(Request $request)
    {
        $query = Guru::with('user');

        if ($request->filled('search')) {
            $query->where(function ($q) use ($request) {
                $q->where('nama_lengkap', 'like', '%' . $request->search . '%')
                  ->orWhere('nip', 'like', '%' . $request->search . '%');
            });
        }

        $gurus = $query->latest()->paginate(20);
        return view('admin.guru.index', compact('gurus'));
    }

    public function create()
    {
        return view('admin.guru.create');
    }

    public function store(Request $request)
    {

        $request->validate([
            'nip'                 => 'nullable|unique:gurus,nip',
            'nuptk'               => 'nullable|unique:gurus,nuptk',
            'nama_lengkap'        => 'required',
            'jenis_kelamin'       => 'required|in:L,P',
            'email_guru'          => 'nullable|email|unique:gurus,email', 
            'email_login'         => 'required|email|unique:users,email',   
            'password'            => 'required|min:6',
            'foto'                => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        // 2. Buat akun akses login di tabel Users
        $user = User::create([
            'name'     => $request->nama_lengkap,
            'email'    => $request->email_login,
            'password' => Hash::make($request->password),
            'role'     => 'guru',
        ]);

        // 3. Siapkan data untuk profil di tabel Gurus
        $data = $request->except(['email_guru', 'email_login', 'password', 'foto']);
        $data['user_id'] = $user->id;
        $data['email']   = $request->email_guru; 

        if ($request->hasFile('foto')) {
            $data['foto'] = $request->file('foto')->store('guru', 'public');
        }

        Guru::create($data);

        return redirect()->route('admin.guru.index')->with('success', 'Guru berhasil ditambahkan!');
    }

    public function show(Guru $guru)
    {
        return view('admin.guru.show', compact('guru'));
    }

    public function edit(Guru $guru)
    {
        return view('admin.guru.edit', compact('guru'));
    }

    public function update(Request $request, Guru $guru)
    {
        // 1. Validasi data update dengan mengabaikan ID guru/user saat ini agar tidak bentrok
        $request->validate([
            'nip'                 => 'nullable|unique:gurus,nip,' . $guru->id,
            'nuptk'               => 'nullable|unique:gurus,nuptk,' . $guru->id,
            'nama_lengkap'        => 'required',
            'jenis_kelamin'       => 'required|in:L,P',
            'email_guru'          => 'nullable|email|unique:gurus,email,' . $guru->id,
            'email_login'         => 'required|email|unique:users,email,' . $guru->user_id,
            'status'              => 'required|in:aktif,nonaktif',
            'foto'                => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        // 2. Olah data profil untuk tabel Gurus
        $data = $request->except(['email_guru', 'email_login', 'password', 'foto', 'hapus_foto']);
        $data['email'] = $request->email_guru;

        // Manajemen file foto
        if ($request->hasFile('foto')) {
            if ($guru->foto && Storage::disk('public')->exists($guru->foto)) {
                Storage::disk('public')->delete($guru->foto);
            }
            $data['foto'] = $request->file('foto')->store('guru', 'public');
        }

        // Fitur hapus foto jika ada checkbox hapus_foto di halaman edit
        if ($request->hapus_foto == 1) {
            if ($guru->foto && Storage::disk('public')->exists($guru->foto)) {
                Storage::disk('public')->delete($guru->foto);
            }
            $data['foto'] = null;
        }

        $guru->update($data);

        // 3. Olah data kredensial untuk tabel Users
        $userData = [
            'name'  => $request->nama_lengkap,
            'email' => $request->email_login
        ];

        if ($request->filled('password')) {
            $userData['password'] = Hash::make($request->password);
        }
        
        $guru->user->update($userData);

        return redirect()->route('admin.guru.index')->with('success', 'Guru berhasil diperbarui!');
    }

    public function destroy(Guru $guru)
    {
        if ($guru->foto && Storage::disk('public')->exists($guru->foto)) {
            Storage::disk('public')->delete($guru->foto);
        }
        
        $guru->user->delete();
        $guru->delete();

        return redirect()->route('admin.guru.index')->with('success', 'Guru berhasil dihapus!');
    }
}