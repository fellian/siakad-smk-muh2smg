<?php

namespace App\Http\Controllers\Siswa;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ProfileController extends Controller
{
    public function index()
    {
        $siswa = Auth::user()->siswa;
        $siswa->load('kelas.jurusan', 'user');
        return view('siswa.profile.index', compact('siswa'));
    }

    public function update(Request $request)
    {
        /** @var \App\Models\Siswa $siswa */
        $siswa = Auth::user()->siswa;

        $request->validate([
            'no_hp' => 'nullable|string|max:15',
            'alamat' => 'nullable|string',
            'foto' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        $data = $request->only(['no_hp', 'alamat']);

        if ($request->hasFile('foto')) {
            if ($siswa->foto) {
                Storage::disk('public')->delete($siswa->foto);
            }

            $data['foto'] = $request->file('foto')->store('siswa', 'public');
        }

        $siswa->update($data);

        return redirect()->back()->with('success', 'Profil berhasil diperbarui!');
    }
}
