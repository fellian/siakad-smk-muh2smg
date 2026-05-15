<?php

namespace App\Http\Controllers\Guru;

use App\Http\Controllers\Controller;
use App\Models\Pengumuman;

class PengumumanController extends Controller
{
    public function index()
    {
        $pengumumans = Pengumuman::with('user')
            ->forRole('guru')
            ->aktif()
            ->latest()
            ->paginate(10);

        return view('guru.pengumuman.index', compact('pengumumans'));
    }

    public function show(Pengumuman $pengumuman)
    {
        abort_unless($pengumuman->isVisibleForRole('guru'), 404);

        $pengumuman->load('user');

        return view('guru.pengumuman.show', compact('pengumuman'));
    }
}
