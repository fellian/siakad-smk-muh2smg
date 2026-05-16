<?php

namespace App\Http\Controllers\Guru;

use App\Http\Controllers\Controller;
use App\Support\HariIndonesia;
use App\Models\Absensi;
use App\Models\Jadwal;
use App\Models\PresensiSesi;
use App\Models\Siswa;
use App\Models\TahunAjaran;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AbsensiController extends Controller
{
    public function index()
    {
        $guru = Auth::user()->guru;
        $tahunAjaran = TahunAjaran::where('status', 'aktif')->first();

        $jadwals = HariIndonesia::sortJadwalCollection(
            $guru->jadwals()
                ->with(['kelas', 'mataPelajaran'])
                ->when($tahunAjaran, fn ($q) => $q->where('tahun_ajaran_id', $tahunAjaran->id))
                ->get()
        );

        $hariIni = ucfirst(now()->locale('id')->dayName);
        $jadwalHariIni = $jadwals->filter(fn (Jadwal $j) => $j->hari === $hariIni)->values();

        $sesiAktifHariIni = PresensiSesi::query()
            ->where('guru_id', $guru->id)
            ->whereNull('ditutup_at')
            ->whereDate('tanggal', Carbon::today())
            ->whereIn('jadwal_id', $jadwalHariIni->pluck('id'))
            ->get()
            ->keyBy('jadwal_id');

        return view('guru.absensi.index', compact(
            'jadwals',
            'jadwalHariIni',
            'hariIni',
            'sesiAktifHariIni'
        ));
    }

    /**
     * Ringkasan semua sesi presensi yang pernah dibuka (termasuk sudah ditutup).
     */
    public function rekap()
    {
        $guru = Auth::user()->guru;

        $sesis = PresensiSesi::query()
            ->where('guru_id', $guru->id)
            ->with(['jadwal.kelas', 'jadwal.mataPelajaran', 'jadwal'])
            ->withCount(['absensis as jumlah_records'])
            ->orderByDesc('tanggal')
            ->orderByDesc('dibuka_at')
            ->paginate(25);

        return view('guru.absensi.rekap', compact('sesis'));
    }

    public function mulaiSesi(Jadwal $jadwal)
    {
        $guru = Auth::user()->guru;
        $tahunAjaran = TahunAjaran::where('status', 'aktif')->first();

        abort_unless($jadwal->guru_id === $guru->id, 403);
        if ($tahunAjaran) {
            abort_unless((int) $jadwal->tahun_ajaran_id === (int) $tahunAjaran->id, 403);
        }

        $hariIni = ucfirst(now()->locale('id')->dayName);
        if ($jadwal->hari !== $hariIni) {
            return redirect()
                ->back()
                ->with('error', 'Presensi hanya dapat dibuka untuk jadwal pada hari yang sama dengan kalender akademik.');
        }

        $tanggal = Carbon::today();

        if (PresensiSesi::query()
            ->where('jadwal_id', $jadwal->id)
            ->whereDate('tanggal', $tanggal)
            ->whereNull('ditutup_at')
            ->exists()) {
            return redirect()
                ->back()
                ->with('error', 'Sesi presensi untuk slot jadwal ini masih dibuka.');
        }

        $sesi = PresensiSesi::create([
            'jadwal_id' => $jadwal->id,
            'tanggal' => $tanggal,
            'guru_id' => $guru->id,
            'dibuka_at' => now(),
            'ditutup_at' => null,
        ]);

        return redirect()
            ->route('guru.absensi.sesi.show', $sesi)
            ->with('success', 'Sesi presensi dibuka. Siswa dapat melakukan presensi.');
    }

    public function showSesi(PresensiSesi $presensi_sesi)
    {
        $this->assertSesiGuruOwns($presensi_sesi);

        $presensi_sesi->load([
            'jadwal.mataPelajaran',
            'jadwal.kelas.siswas' => fn ($q) => $q->where('status', 'aktif')->orderBy('nama_lengkap'),
            'jadwal.kelas',
        ]);

        $absensis = $presensi_sesi->absensis()
            ->with('siswa')
            ->get()
            ->keyBy('siswa_id');

        return view('guru.absensi.sesi', compact('presensi_sesi', 'absensis'));
    }

    public function tutupSesi(Request $request, PresensiSesi $presensi_sesi)
    {
        $this->assertSesiGuruOwns($presensi_sesi);

        if (! $presensi_sesi->aktif()) {
            return redirect()
                ->route('guru.absensi.rekap')
                ->with('error', 'Sesi presensi sudah ditutup atau tidak aktif.');
        }

        $validated = $request->validate([
            'isi_alfa_tidak_hadir' => ['nullable', 'boolean'],
        ]);

        if (! empty($validated['isi_alfa_tidak_hadir'])) {
            $kelasId = $presensi_sesi->jadwal->kelas_id;

            Siswa::query()
                ->where('kelas_id', $kelasId)
                ->where('status', 'aktif')
                ->cursor()
                ->each(function (Siswa $siswa) use ($presensi_sesi): void {
                    Absensi::query()->firstOrCreate(
                        [
                            'presensi_sesi_id' => $presensi_sesi->id,
                            'siswa_id' => $siswa->id,
                        ],
                        [
                            'jadwal_id' => $presensi_sesi->jadwal_id,
                            'tanggal' => $presensi_sesi->tanggal->format('Y-m-d'),
                            'guru_id' => $presensi_sesi->guru_id,
                            'status' => 'alfa',
                            'waktu_presensi' => null,
                            'keterangan' => null,
                        ]
                    );
                });
        }

        $presensi_sesi->update(['ditutup_at' => now()]);

        return redirect()
            ->route('guru.absensi.rekap')
            ->with('success', 'Sesi presensi ditutup.');
    }

    /**
     * Guru mengoreksi status salah satu siswa selama sesi masih dibuka,
     * atau mencatat kehadiran manual (misalnya menggantikan siswa tanpa akses aplikasi).
     */
    public function upsertAbsensiSiswa(Request $request, PresensiSesi $presensi_sesi)
    {
        $this->assertSesiGuruOwns($presensi_sesi);

        if (! $presensi_sesi->aktif()) {
            return redirect()
                ->back()
                ->with('error', 'Sesi presensi sudah ditutup. Perubahan tidak dapat disimpan.');
        }

        $data = $request->validate([
            'siswa_id' => ['required', 'exists:siswas,id'],
            'status' => ['required', 'in:hadir,terlambat,izin,sakit,alfa'],
            'keterangan' => ['nullable', 'string', 'max:500'],
        ]);

        $siswa = Siswa::query()->findOrFail($data['siswa_id']);

        abort_unless(
            (int) $siswa->kelas_id === (int) $presensi_sesi->jadwal->kelas_id,
            403,
            'Siswa tidak termasuk kelas untuk jadwal ini.'
        );

        $existing = Absensi::query()
            ->where('presensi_sesi_id', $presensi_sesi->id)
            ->where('siswa_id', $siswa->id)
            ->first();

        $waktuPresensi = $existing?->waktu_presensi;
        if ($waktuPresensi === null && in_array($data['status'], ['hadir', 'terlambat'], true)) {
            $waktuPresensi = now();
        }

        Absensi::query()->updateOrCreate(
            [
                'presensi_sesi_id' => $presensi_sesi->id,
                'siswa_id' => $siswa->id,
            ],
            [
                'jadwal_id' => $presensi_sesi->jadwal_id,
                'tanggal' => $presensi_sesi->tanggal->format('Y-m-d'),
                'guru_id' => $presensi_sesi->guru_id,
                'status' => $data['status'],
                'keterangan' => $data['keterangan'] ?? null,
                'waktu_presensi' => $waktuPresensi,
            ]
        );

        return redirect()
            ->back()
            ->with('success', 'Data kehadiran siswa telah disimpan.');
    }

    protected function assertSesiGuruOwns(PresensiSesi $presensi_sesi): void
    {
        $guruId = Auth::user()->guru?->id;
        abort_if(! $guruId || $presensi_sesi->guru_id !== $guruId, 403);
    }
}
