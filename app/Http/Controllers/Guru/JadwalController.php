<?php

namespace App\Http\Controllers\Guru;

use App\Http\Controllers\Controller;
use App\Support\HariIndonesia;
use Illuminate\Support\Facades\Auth;

class JadwalController extends Controller
{
    public function index()
    {
        $guru = Auth::user()->guru;
        
        $jadwals = HariIndonesia::sortJadwalCollection(
            $guru->jadwals()->with(['kelas', 'mataPelajaran', 'tahunAjaran'])->get()
        )->groupBy('hari');

        $hariOrder = ['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu'];

        return view('guru.jadwal.index', compact('jadwals', 'hariOrder'));
    }
}