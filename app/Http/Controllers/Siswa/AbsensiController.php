<?php

namespace App\Http\Controllers\Siswa;

use App\Http\Controllers\Controller;
use App\Models\Absensi;
use App\Models\Jadwal;
use App\Models\PresensiSesi;
use App\Models\TahunAjaran;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AbsensiController extends Controller
{
    public function index()
    {
        $siswa = Auth::user()->siswa;
        $tahunAjaran = TahunAjaran::where('status', 'aktif')->first();

        $scoped = fn () => $siswa->absensis()
            ->when($tahunAjaran?->id, fn ($q) => $q->whereHas('jadwal', fn ($jq) => $jq->where('tahun_ajaran_id', $tahunAjaran->id)));

        $hadir = $scoped()->where('status', 'hadir')->count();
        $terlambat = $scoped()->where('status', 'terlambat')->count();
        $izin = $scoped()->where('status', 'izin')->count();
        $sakit = $scoped()->where('status', 'sakit')->count();
        $alfa = $scoped()->where('status', 'alfa')->count();

        $absensis = $scoped()
            ->with(['jadwal.mataPelajaran', 'jadwal.guru', 'guru', 'presensiSesi'])
            ->orderByDesc('tanggal')
            ->orderByDesc('waktu_presensi')
            ->paginate(20);

        $total = $scoped()->count();

        return view('siswa.absensi.index', compact(
            'siswa', 'absensis', 'tahunAjaran',
            'hadir', 'terlambat', 'izin', 'sakit', 'alfa', 'total'
        ));
    }

    public function simpanPresensi(Request $request)
    {
        $siswa = Auth::user()->siswa;
        $activeYear = TahunAjaran::where('status', 'aktif')->first();

        $data = $request->validate([
            'presensi_sesi_id' => ['required', 'exists:presensi_sesis,id'],
            'tipe_kehadiran' => ['required', 'in:otomatis,izin,sakit'],
            'keterangan' => ['nullable', 'string', 'max:500'],
        ]);

        if (($data['tipe_kehadiran'] === 'izin' || $data['tipe_kehadiran'] === 'sakit') && blank($request->input('keterangan'))) {
            return redirect()->back()->withInput()->withErrors([
                'keterangan' => 'Keterangan wajib diisi untuk opsi Izin atau Sakit.',
            ]);
        }

        $sesi = PresensiSesi::query()
            ->with('jadwal')
            ->findOrFail($data['presensi_sesi_id']);

        if (! $sesi->aktif()) {
            return redirect()->back()->with('error', 'Sesi presensi sudah ditutup oleh guru.');
        }

        if (! $sesi->tanggal?->isToday()) {
            return redirect()->back()->with('error', 'Presensi tidak tersedia untuk sesi pada tanggal ini.');
        }

        if ((int) $sesi->jadwal->kelas_id !== (int) $siswa->kelas_id) {
            return redirect()->back()->with('error', 'Presensi tidak tersedia untuk kelas Anda.');
        }

        if ($activeYear && (int) $sesi->jadwal->tahun_ajaran_id !== (int) $activeYear->id) {
            return redirect()->back()->with('error', 'Tahun ajaran tidak sesuai.');
        }

        if (Absensi::query()->where('presensi_sesi_id', $sesi->id)->where('siswa_id', $siswa->id)->exists()) {
            return redirect()->back()->with('error', 'Anda sudah tercatat pada sesi presensi ini.');
        }

        $waktuPresensi = now();

        $status = match ($data['tipe_kehadiran']) {
            'izin' => 'izin',
            'sakit' => 'sakit',
            default => $this->statusOtomatisDariJadwal($sesi->jadwal, $sesi->tanggal, $waktuPresensi),
        };

        Absensi::query()->create([
            'presensi_sesi_id' => $sesi->id,
            'siswa_id' => $siswa->id,
            'jadwal_id' => $sesi->jadwal_id,
            'tanggal' => $sesi->tanggal->format('Y-m-d'),
            'status' => $status,
            'keterangan' => filled($request->input('keterangan')) ? $request->input('keterangan') : null,
            'guru_id' => $sesi->guru_id,
            'waktu_presensi' => $waktuPresensi,
        ]);

        return redirect()->back()->with('success', 'Kehadiran berhasil dicatat.');
    }

    /**
     * Hadir: presensi pada atau sebelum jam selesai slot jadwal (selama sesi masih dibuka).
     * Terlambat: presensi setelah jam selesai slot namun sebelum guru menutup sesi (bukan alfa;
     * alfa untuk siswa tanpa presensi ditangani guru lewat "otomatis isi alfa" saat tutup sesi).
     */
    protected function statusOtomatisDariJadwal(Jadwal $jadwal, Carbon $tanggalSesi, Carbon $waktuPresensi): string
    {
        $basis = $tanggalSesi->copy()->startOfDay();

        $jamSelesaiStr = $jadwal->jam_selesai instanceof Carbon
            ? $jadwal->jam_selesai->format('H:i:s')
            : Carbon::parse((string) $jadwal->jam_selesai)->format('H:i:s');

        $batasSelesaiPelajaran = $basis->copy()->setTimeFromTimeString($jamSelesaiStr);

        return $waktuPresensi->greaterThan($batasSelesaiPelajaran) ? 'terlambat' : 'hadir';
    }
}
