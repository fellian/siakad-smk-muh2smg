<?php

namespace App\Http\Controllers\Siswa;

use App\Http\Controllers\Controller;
use App\Models\Pengumuman;

class PengumumanController extends Controller
{
    public function index()
    {
        $pengumumans = Pengumuman::with('user')
            ->forRole('siswa')
            ->aktif()
            ->latest()
            ->paginate(10);

        return view('siswa.pengumuman.index', compact('pengumumans'));
    }

    public function show(Pengumuman $pengumuman)
    {
        abort_unless($pengumuman->isVisibleForRole('siswa'), 404);

        $pengumuman->load('user');

        return view('siswa.pengumuman.show', compact('pengumuman'));
    }
}
