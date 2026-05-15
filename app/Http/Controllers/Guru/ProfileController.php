<?php

namespace App\Http\Controllers\Guru;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Password;

class ProfileController extends Controller
{
    public function index()
    {
        $guru = Auth::user()->guru;
        $guru->load('user', 'kelasWali', 'mataPelajarans');

        return view('guru.profile.index', compact('guru'));
    }

    public function update(Request $request)
    {
        /** @var \App\Models\Guru $guru */
        $guru = Auth::user()->guru;
        $user = Auth::user();

        $validated = $request->validate([
            'nip' => ['nullable', 'string', 'max:20', Rule::unique('gurus', 'nip')->ignore($guru->id)],
            'nuptk' => ['nullable', 'string', 'max:20', Rule::unique('gurus', 'nuptk')->ignore($guru->id)],
            'nama_lengkap' => ['required', 'string', 'max:255'],
            'jenis_kelamin' => ['required', 'in:L,P'],
            'tempat_lahir' => ['nullable', 'string', 'max:255'],
            'tanggal_lahir' => ['nullable', 'date'],
            'alamat' => ['nullable', 'string'],
            'no_hp' => ['nullable', 'string', 'max:15'],
            'email' => ['required', 'email', 'max:255', Rule::unique('users', 'email')->ignore($user->id)],
            'pendidikan_terakhir' => ['nullable', 'string', 'max:255'],
            'jurusan_pendidikan' => ['nullable', 'string', 'max:255'],
            'foto' => ['nullable', 'image', 'mimes:jpg,jpeg,png', 'max:2048'],
        ]);

        $data = collect($validated)->except(['foto'])->toArray();
        $data['nip'] = $data['nip'] ?: null;
        $data['nuptk'] = $data['nuptk'] ?: null;

        if ($request->hasFile('foto')) {
            if ($guru->foto) {
                Storage::disk('public')->delete($guru->foto);
            }

            $data['foto'] = $request->file('foto')->store('guru', 'public');
        }

        $guru->update($data);

        $user->update([
            'name' => $validated['nama_lengkap'],
            'email' => $validated['email'],
        ]);

        return redirect()
            ->route('guru.profile.index')
            ->with('success', 'Profil berhasil diperbarui!');
    }

    public function updatePassword(Request $request)
    {
        $validated = $request->validate([
            'current_password' => ['required', 'current_password'],
            'password' => ['required', Password::defaults(), 'confirmed'],
        ]);

        $request->user()->update([
            'password' => Hash::make($validated['password']),
        ]);

        return redirect()
            ->route('guru.profile.index')
            ->with('success', 'Password berhasil diperbarui!');
    }
}
