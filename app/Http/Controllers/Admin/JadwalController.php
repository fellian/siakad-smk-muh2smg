<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Guru;
use App\Models\Jadwal;
use App\Models\Kelas;
use App\Models\MataPelajaran;
use App\Models\TahunAjaran;
use Illuminate\Http\Request;

class JadwalController extends Controller
{
    public function index(Request $request)
    {
        $query = Jadwal::with(['kelas', 'mataPelajaran', 'guru']);

        if ($request->filled('kelas_id')) {
            $query->where('kelas_id', $request->kelas_id);
        }
        if ($request->filled('hari')) {
            $query->where('hari', $request->hari);
        }

        $jadwals = $query->orderBy('hari')->orderBy('jam_mulai')->get();
        $kelas = Kelas::all();

        return view('admin.jadwal.index', compact('jadwals', 'kelas'));
    }

    public function create()
    {
        $kelas = Kelas::all();
        $mapels = MataPelajaran::all();
        $gurus = Guru::where('status', 'aktif')->with('mataPelajarans')->get();
        $tahunAjarans = TahunAjaran::where('status', 'aktif')->get();
        $hari = ['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu'];

        return view('admin.jadwal.create', compact('kelas', 'mapels', 'gurus', 'tahunAjarans', 'hari'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'kelas_id'          => 'required|exists:kelas,id',
            'mata_pelajaran_id' => 'required|exists:mata_pelajarans,id',
            'guru_id'           => 'required|exists:gurus,id',
            'hari'              => 'required|in:Senin,Selasa,Rabu,Kamis,Jumat,Sabtu',
            'jam_mulai'         => 'required|date_format:H:i',
            'jam_selesai'       => 'required|date_format:H:i|after:jam_mulai',
            'ruangan'           => 'nullable|string|max:50',
            'tahun_ajaran_id'   => 'required|exists:tahun_ajarans,id',
        ]);

        $guru = Guru::findOrFail($request->guru_id);
        if (!$guru->mataPelajarans()->where('mata_pelajaran_id', $request->mata_pelajaran_id)->exists()) {
            
            $guru->mataPelajarans()->attach($request->mata_pelajaran_id);
        }

        $jamMulai   = $request->jam_mulai;
        $jamSelesai = $request->jam_selesai;


        $guruBentrok = Jadwal::where('guru_id', $request->guru_id)
            ->where('hari', $request->hari)
            ->where('tahun_ajaran_id', $request->tahun_ajaran_id)
            ->where(function ($q) use ($jamMulai, $jamSelesai) {
                $q->where('jam_mulai', '<', $jamSelesai)
                  ->where('jam_selesai', '>', $jamMulai);
            })
            ->exists();

        if ($guruBentrok) {
            return back()->withErrors(['guru_id' => 'Guru yang dipilih sudah memiliki jadwal mengajar di kelas lain pada waktu tersebut!'])->withInput();
        }

        $kelasBentrok = Jadwal::where('kelas_id', $request->kelas_id)
            ->where('hari', $request->hari)
            ->where('tahun_ajaran_id', $request->tahun_ajaran_id)
            ->where(function ($q) use ($jamMulai, $jamSelesai) {
                $q->where('jam_mulai', '<', $jamSelesai)
                  ->where('jam_selesai', '>', $jamMulai);
            })
            ->exists();

        if ($kelasBentrok) {
            return back()->withErrors(['kelas_id' => 'Kelas yang dipilih sudah memiliki jadwal pelajaran lain pada waktu tersebut!'])->withInput();
        }

        Jadwal::create($request->all());

        return redirect()->route('admin.jadwal.index')->with('success', 'Jadwal berhasil ditambahkan!');
    }

    public function edit(Jadwal $jadwal)
    {
        $kelas = Kelas::all();
        $mapels = MataPelajaran::all();
        $gurus = Guru::where('status', 'aktif')->with('mataPelajarans')->get();
        $tahunAjarans = TahunAjaran::all();
        $hari = ['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu'];

        return view('admin.jadwal.edit', compact('jadwal', 'kelas', 'mapels', 'gurus', 'tahunAjarans', 'hari'));
    }

    public function update(Request $request, Jadwal $jadwal)
    {
        $request->validate([
            'kelas_id'          => 'required|exists:kelas,id',
            'mata_pelajaran_id' => 'required|exists:mata_pelajarans,id',
            'guru_id'           => 'required|exists:gurus,id',
            'hari'              => 'required|in:Senin,Selasa,Rabu,Kamis,Jumat,Sabtu',
            'jam_mulai'         => 'required|date_format:H:i',
            'jam_selesai'       => 'required|date_format:H:i|after:jam_mulai',
            'ruangan'           => 'nullable|string|max:50',
            'tahun_ajaran_id'   => 'required|exists:tahun_ajarans,id',
        ]);

        
        $guru = Guru::findOrFail($request->guru_id);
        if (!$guru->mataPelajarans()->where('mata_pelajaran_id', $request->mata_pelajaran_id)->exists()) {
           
            $guru->mataPelajarans()->attach($request->mata_pelajaran_id);
        }

        $jamMulai   = $request->jam_mulai;
        $jamSelesai = $request->jam_selesai;

        $guruBentrok = Jadwal::where('id', '!=', $jadwal->id)
            ->where('guru_id', $request->guru_id)
            ->where('hari', $request->hari)
            ->where('tahun_ajaran_id', $request->tahun_ajaran_id)
            ->where(function ($q) use ($jamMulai, $jamSelesai) {
                $q->where('jam_mulai', '<', $jamSelesai)
                  ->where('jam_selesai', '>', $jamMulai);
            })
            ->exists();

        if ($guruBentrok) {
            return back()->withErrors(['guru_id' => 'Guru yang dipilih sudah memiliki jadwal mengajar di kelas lain pada waktu tersebut!'])->withInput();
        }

        $kelasBentrok = Jadwal::where('id', '!=', $jadwal->id)
            ->where('kelas_id', $request->kelas_id)
            ->where('hari', $request->hari)
            ->where('tahun_ajaran_id', $request->tahun_ajaran_id)
            ->where(function ($q) use ($jamMulai, $jamSelesai) {
                $q->where('jam_mulai', '<', $jamSelesai)
                  ->where('jam_selesai', '>', $jamMulai);
            })
            ->exists();

        if ($kelasBentrok) {
            return back()->withErrors(['kelas_id' => 'Kelas yang dipilih sudah memiliki jadwal pelajaran lain pada waktu tersebut!'])->withInput();
        }

       
        $jadwal->update($request->all());

        return redirect()->route('admin.jadwal.index')->with('success', 'Jadwal berhasil diperbarui!');
    }

    public function destroy(Jadwal $jadwal)
    {
        $jadwal->delete();
        return redirect()->route('admin.jadwal.index')->with('success', 'Jadwal berhasil dihapus!');
    }
}