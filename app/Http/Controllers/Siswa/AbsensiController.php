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
use Illuminate\Support\Facades\Schema;

class AbsensiController extends Controller
{
    public function index()
    {
        $siswa = Auth::user()->siswa;
        $tahunAjaran = TahunAjaran::where('status', 'aktif')->first();

        if (!$siswa || !$siswa->kelas_id) {
            return view('siswa.absensi.index', [
                'jadwalHariIni' => collect([]),
                'sesiPresensiAktif' => collect([]),
                'presensiSudahIds' => collect([]),
                'absensis' => collect([]),
                'hadirBulanIni' => 0,
                'alfaBulanIni' => 0,
                'persenHadir' => 0,
                'hadir' => 0,
                'terlambat' => 0,
                'izin' => 0,
                'sakit' => 0,
                'alfa' => 0,
                'total' => 0,
                'siswa' => $siswa,
                'tahunAjaran' => $tahunAjaran
            ]);
        }
        
        $today = now()->toDateString();
        $hariIni = now()->translatedFormat('l');

        $jadwalHariIni = Jadwal::with(['mataPelajaran', 'guru'])
            ->where('kelas_id', $siswa->kelas_id)
            ->when($tahunAjaran, fn($q) => $q->where('tahun_ajaran_id', $tahunAjaran->id))
            ->where('hari', $hariIni)
            ->orderBy('jam_mulai')
            ->get();
        
        $sesiPresensiAktif = PresensiSesi::with('jadwal')
            ->where('tanggal', $today)
            ->where(function($query) {
                if (Schema::hasColumn('presensi_sesis', 'is_active')) {
                    $query->where('is_active', 1);
                } elseif (Schema::hasColumn('presensi_sesis', 'is_aktif')) {
                    $query->where('is_aktif', 1);
                } elseif (Schema::hasColumn('presensi_sesis', 'aktif')) {
                    $query->where('aktif', 1);
                } elseif (Schema::hasColumn('presensi_sesis', 'status')) {
                    $query->where('status', 'aktif');
                } else {
                    $query->whereNotNull('id');
                }
            })
            ->get();
   
        $presensiSudahIds = Absensi::where('siswa_id', $siswa->id)
            ->whereDate('tanggal', $today)
            ->pluck('presensi_sesi_id');
        

        $scoped = fn () => $siswa->absensis()
            ->when($tahunAjaran?->id, fn ($q) => $q->whereHas('jadwal', fn ($jq) => $jq->where('tahun_ajaran_id', $tahunAjaran->id)));
        
        $hadir = $scoped()->where('status', 'hadir')->count();
        $terlambat = $scoped()->where('status', 'terlambat')->count();
        $izin = $scoped()->where('status', 'izin')->count();
        $sakit = $scoped()->where('status', 'sakit')->count();
        $alfa = $scoped()->where('status', 'alfa')->count();
        $total = $scoped()->count();
        
  
        $bulanIni = now()->month;
        $tahunIni = now()->year;
        
        $hadirBulanIni = Absensi::where('siswa_id', $siswa->id)
            ->where('status', 'hadir')
            ->whereMonth('tanggal', $bulanIni)
            ->whereYear('tanggal', $tahunIni)
            ->count();
            
        $alfaBulanIni = Absensi::where('siswa_id', $siswa->id)
            ->whereIn('status', ['alfa', 'izin', 'sakit', 'terlambat'])
            ->whereMonth('tanggal', $bulanIni)
            ->whereYear('tanggal', $tahunIni)
            ->count();
        

        $absensis = $scoped()
            ->with(['jadwal.mataPelajaran', 'jadwal.guru', 'guru', 'presensiSesi'])
            ->orderByDesc('tanggal')
            ->orderByDesc('waktu_presensi')
            ->take(5)
            ->get();
        
        $persenHadir = ($hadirBulanIni + $alfaBulanIni) > 0 
            ? round(($hadirBulanIni / ($hadirBulanIni + $alfaBulanIni)) * 100) 
            : 0;
        
        return view('siswa.absensi.index', compact(
            'jadwalHariIni',
            'sesiPresensiAktif',
            'presensiSudahIds',
            'absensis',
            'hadirBulanIni',
            'alfaBulanIni',
            'persenHadir',
            'hadir',
            'terlambat',
            'izin',
            'sakit',
            'alfa',
            'total',
            'siswa',
            'tahunAjaran'
        ));
    }
    
    public function rekap(Request $request)
    {
        $siswa = Auth::user()->siswa;
        $tahunAjaran = TahunAjaran::where('status', 'aktif')->first();
        
        if (!$siswa) {
            return view('siswa.absensi.rekap', [
                'absensis' => collect([]),
                'hadir' => 0,
                'terlambat' => 0,
                'izin' => 0,
                'sakit' => 0,
                'alfa' => 0,
                'total' => 0,
                'siswa' => $siswa,
                'tahunAjaran' => $tahunAjaran
            ]);
        }
        
        $query = $siswa->absensis()
            ->with(['jadwal.mataPelajaran', 'jadwal.guru', 'guru', 'presensiSesi'])
            ->when($tahunAjaran?->id, fn ($q) => $q->whereHas('jadwal', fn ($jq) => $jq->where('tahun_ajaran_id', $tahunAjaran->id)));
        
  
        if ($request->filled('search')) {
            $search = $request->search;
            $query->whereHas('jadwal.mataPelajaran', function($q) use ($search) {
                $q->where('nama_mapel', 'like', '%' . $search . '%');
            });
        }
        

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('bulan')) {
            $query->whereMonth('tanggal', $request->bulan);
        }
        
        if ($request->filled('tahun')) {
            $query->whereYear('tanggal', $request->tahun);
        }
        
        $absensis = $query->orderByDesc('tanggal')
            ->orderByDesc('waktu_presensi')
            ->paginate(15)
            ->withQueryString();

        $hadir = $siswa->absensis()
            ->when($tahunAjaran?->id, fn ($q) => $q->whereHas('jadwal', fn ($jq) => $jq->where('tahun_ajaran_id', $tahunAjaran->id)))
            ->where('status', 'hadir')
            ->count();
            
        $terlambat = $siswa->absensis()
            ->when($tahunAjaran?->id, fn ($q) => $q->whereHas('jadwal', fn ($jq) => $jq->where('tahun_ajaran_id', $tahunAjaran->id)))
            ->where('status', 'terlambat')
            ->count();
            
        $izin = $siswa->absensis()
            ->when($tahunAjaran?->id, fn ($q) => $q->whereHas('jadwal', fn ($jq) => $jq->where('tahun_ajaran_id', $tahunAjaran->id)))
            ->where('status', 'izin')
            ->count();
            
        $sakit = $siswa->absensis()
            ->when($tahunAjaran?->id, fn ($q) => $q->whereHas('jadwal', fn ($jq) => $jq->where('tahun_ajaran_id', $tahunAjaran->id)))
            ->where('status', 'sakit')
            ->count();
            
        $alfa = $siswa->absensis()
            ->when($tahunAjaran?->id, fn ($q) => $q->whereHas('jadwal', fn ($jq) => $jq->where('tahun_ajaran_id', $tahunAjaran->id)))
            ->where('status', 'alfa')
            ->count();
            
        $total = $hadir + $terlambat + $izin + $sakit + $alfa;
        
        return view('siswa.absensi.rekap', compact(
            'absensis',
            'hadir',
            'terlambat',
            'izin',
            'sakit',
            'alfa',
            'total',
            'siswa',
            'tahunAjaran'
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

        if (method_exists($sesi, 'aktif')) {
            if (! $sesi->aktif()) {
                return redirect()->back()->with('error', 'Sesi presensi sudah ditutup oleh guru.');
            }
        } else {

            $isActive = false;
            if (Schema::hasColumn('presensi_sesis', 'is_active') && $sesi->is_active == 1) {
                $isActive = true;
            } elseif (Schema::hasColumn('presensi_sesis', 'is_aktif') && $sesi->is_aktif == 1) {
                $isActive = true;
            } elseif (Schema::hasColumn('presensi_sesis', 'aktif') && $sesi->aktif == 1) {
                $isActive = true;
            } elseif (Schema::hasColumn('presensi_sesis', 'status') && $sesi->status == 'aktif') {
                $isActive = true;
            }
            
            if (! $isActive) {
                return redirect()->back()->with('error', 'Sesi presensi sudah ditutup oleh guru.');
            }
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