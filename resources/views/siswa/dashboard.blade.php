@extends('layouts.siswa')

@section('title', 'Dashboard Siswa')
@section('page-title', 'DASHBOARD')

@section('content')
<!-- Header Section -->
<div class="mb-8">
    <h1 class="text-2xl font-bold text-gray-900">Selamat datang, {{ auth()->user()->name ?? '-' }}</h1>
    <p class="text-sm text-gray-500 mt-1">
        Kelas {{ $siswa->kelas->nama_kelas ?? '-' }}
        @if($tahunAjaran)
            <span class="mx-1.5 text-gray-300">|</span>
            {{ $tahunAjaran->label }}
        @endif
    </p>
</div>

<!-- Main Grid -->
<div class="grid grid-cols-1 lg:grid-cols-12 gap-6 mb-8">

    <!-- Jadwal Hari Ini (Col Span 5) -->
    <div class="lg:col-span-5 bg-white rounded-xl shadow-sm border border-gray-200 p-6 flex flex-col">
        <div class="flex justify-between items-center mb-5">
            <h3 class="text-lg font-semibold text-gray-900">Jadwal Hari Ini</h3>
            <span class="px-3 py-1 bg-blue-50 text-blue-700 text-xs font-medium rounded-full">
                {{ \Carbon\Carbon::now()->translatedFormat('l, d F Y') }}
            </span>
        </div>

        <div class="space-y-3 flex-1">
            @php $nowDashboard = \Carbon\Carbon::now(); @endphp
            @forelse($jadwalHariIni as $jadwal)
                @php
                    $mulai = \Carbon\Carbon::parse($jadwal->jam_mulai)->format('H:i');
                    $selesai = \Carbon\Carbon::parse($jadwal->jam_selesai)->format('H:i');
                    $jamMulai = \Carbon\Carbon::today()->setTimeFromTimeString(\Carbon\Carbon::parse($jadwal->jam_mulai)->format('H:i:s'));
                    $jamSelesai = \Carbon\Carbon::today()->setTimeFromTimeString(\Carbon\Carbon::parse($jadwal->jam_selesai)->format('H:i:s'));
                    $isActive = $nowDashboard->between($jamMulai, $jamSelesai) || $sesiPresensiAktif->contains('jadwal_id', $jadwal->id);
                @endphp
                <div class="flex items-start gap-3 p-3 rounded-lg {{ $isActive ? 'bg-blue-50 border border-blue-200' : 'bg-gray-50/50 border border-gray-100' }}">
                    <div class="flex flex-col items-center min-w-[3.5rem] pt-0.5">
                        <span class="text-sm font-semibold text-gray-900">{{ $mulai }}</span>
                        <span class="text-xs text-gray-500">{{ $selesai }}</span>
                    </div>
                    <div class="flex-1 min-w-0">
                        <h4 class="text-sm font-semibold text-gray-900 truncate">{{ $jadwal->mataPelajaran->nama_mapel }}</h4>
                        <p class="text-xs text-gray-500 mt-0.5 truncate">{{ $jadwal->guru->nama_lengkap ?? '-' }} &bull; {{ $jadwal->ruangan ?? '-' }}</p>
                        
                        @if($isActive)
                            @php
                                $sesi = $sesiPresensiAktif->where('jadwal_id', $jadwal->id)->first();
                                $sudah = $sesi ? $presensiSudahIds->contains($sesi->id) : false;
                            @endphp
                            @if($sesi && !$sudah)
                                <form action="{{ route('siswa.absensi.presensi.store') }}" method="POST" class="mt-2">
                                    @csrf
                                    <input type="hidden" name="presensi_sesi_id" value="{{ $sesi->id }}">
                                    <input type="hidden" name="tipe_kehadiran" value="otomatis">
                                    <button type="submit" class="inline-flex items-center px-3 py-1.5 bg-blue-600 hover:bg-blue-700 text-white text-xs font-medium rounded-md transition-colors">
                                        <svg class="w-3.5 h-3.5 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                        </svg>
                                        Presensi
                                    </button>
                                </form>
                            @elseif($sudah)
                                <span class="inline-flex items-center mt-2 px-2 py-1 bg-green-100 text-green-700 text-xs font-medium rounded-md">
                                    <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                    </svg>
                                    Sudah Presensi
                                </span>
                            @endif
                        @endif
                    </div>
                </div>
            @empty
                <div class="text-center py-8 text-gray-400">
                    <svg class="w-12 h-12 mx-auto mb-3 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                    </svg>
                    <p class="text-sm">Tidak ada jadwal pelajaran hari ini.</p>
                </div>
            @endforelse
        </div>

        <div class="mt-5 pt-4 border-t border-gray-100 text-center">
            <a href="{{ route('siswa.jadwal.index') }}" class="inline-flex items-center text-sm font-medium text-blue-600 hover:text-blue-700 transition-colors">
                Lihat Jadwal Lengkap
                <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                </svg>
            </a>
        </div>
    </div>

    <!-- Presensi (Col Span 3) -->
    <div class="lg:col-span-3 bg-white rounded-xl shadow-sm border border-gray-200 p-6 flex flex-col">
        @php($dashPct = max(0, min(100, (int) $persenHadir)))
        <div class="mb-4">
            <h3 class="text-lg font-semibold text-gray-900">Presensi</h3>
            <p class="text-xs text-gray-500 mt-0.5">Bulan Ini</p>
        </div>

        <div class="flex-1 flex flex-col items-center justify-center my-4">
            <div class="relative w-28 h-28">
                <svg class="w-full h-full transform -rotate-90" viewBox="0 0 36 36">
                    <path class="text-gray-100" d="M18 2.0845 a 15.9155 15.9155 0 0 1 0 31.831 a 15.9155 15.9155 0 0 1 0 -31.831" fill="none" stroke="currentColor" stroke-width="3" />
                    <path class="text-blue-600" stroke-dasharray="{{ $dashPct }}, 100" d="M18 2.0845 a 15.9155 15.9155 0 0 1 0 31.831 a 15.9155 15.9155 0 0 1 0 -31.831" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" />
                </svg>
                <div class="absolute inset-0 flex items-center justify-center flex-col">
                    <span class="text-2xl font-bold text-gray-900">{{ $persenHadir }}%</span>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-2 gap-3 mt-auto">
            <div class="bg-gray-50 rounded-lg p-3 text-center border border-gray-100">
                <p class="text-xs font-medium text-gray-500 mb-1">Hadir</p>
                <p class="text-lg font-semibold text-gray-900">{{ $hadirBulanIni }}</p>
                <p class="text-[10px] text-gray-400">Hari</p>
            </div>
            <div class="bg-red-50 rounded-lg p-3 text-center border border-red-100">
                <p class="text-xs font-medium text-red-600 mb-1">Tidak Hadir</p>
                <p class="text-lg font-semibold text-red-700">{{ $alfaBulanIni }}</p>
                <p class="text-[10px] text-red-400">Hari</p>
            </div>
        </div>
    </div>

    <!-- Nilai Terbaru (Col Span 4) -->
    <div class="lg:col-span-4 bg-white rounded-xl shadow-sm border border-gray-200 p-6 flex flex-col">
        <h3 class="text-lg font-semibold text-gray-900 mb-5">Nilai Terbaru</h3>

        <div class="space-y-4 flex-1">
            @forelse(($nilaisTerbaru ?? collect())->take(4) as $nilaiRow)
                <div class="flex items-center justify-between p-3 rounded-lg hover:bg-gray-50 transition-colors group">
                    <div class="min-w-0 flex-1">
                        <h4 class="text-sm font-medium text-gray-900 truncate group-hover:text-blue-600 transition-colors">{{ $nilaiRow->mataPelajaran->nama_mapel ?? 'Tugas' }}</h4>
                        <p class="text-xs text-gray-400 mt-0.5">{{ $nilaiRow->updated_at->translatedFormat('d M Y') }}</p>
                    </div>
                    <div class="ml-4 flex-shrink-0">
                        <span class="inline-flex items-center justify-center w-10 h-10 rounded-lg {{ ((int) round($nilaiRow->nilai_akhir ?? 0)) >= 75 ? 'bg-green-100 text-green-700' : 'bg-yellow-100 text-yellow-700' }} text-sm font-bold">
                            {{ (int) round($nilaiRow->nilai_akhir ?? 0) }}
                        </span>
                    </div>
                </div>
            @empty
                <div class="text-center text-gray-400 py-10">
                    <svg class="w-10 h-10 mx-auto mb-2 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                    </svg>
                    <p class="text-sm">Belum ada data nilai</p>
                </div>
            @endforelse
        </div>

        <div class="mt-5 pt-4 border-t border-gray-100 text-center">
            <a href="{{ route('siswa.nilai.index') }}" class="inline-flex items-center text-sm font-medium text-blue-600 hover:text-blue-700 transition-colors">
                Lihat Semua Nilai
                <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                </svg>
            </a>
        </div>
    </div>
</div>

<!-- Pengumuman Sekolah -->
<div class="mb-8">
    <div class="flex justify-between items-center mb-4">
        <h3 class="text-lg font-semibold text-gray-900">Pengumuman Sekolah</h3>
        <a href="{{ route('siswa.pengumuman.index') }}" class="inline-flex items-center text-sm font-medium text-blue-600 hover:text-blue-700 transition-colors">
            Lihat Semua
            <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
            </svg>
        </a>
    </div>
    
    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
        @forelse($pengumumans->take(2) as $pengumuman)
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-5 flex gap-4 hover:border-blue-200 hover:shadow-md transition-all duration-200">
                <div class="w-10 h-10 rounded-lg {{ $loop->first ? 'bg-blue-100 text-blue-600' : 'bg-indigo-100 text-indigo-600' }} flex items-center justify-center shrink-0">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        @if($loop->first)
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5.882V19.24a1.76 1.76 0 01-3.417.592l-2.147-6.15M18 13a3 3 0 100-6M5.436 13.683A4.001 4.001 0 017 6h1.832c4.1 0 7.625-1.234 9.168-3v14c-1.543-1.766-5.067-3-9.168-3H7a3.988 3.988 0 01-1.564-.317z"></path>
                        @else
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        @endif
                    </svg>
                </div>
                <div class="min-w-0 flex-1">
                    <h4 class="text-sm font-semibold text-gray-900 mb-1 line-clamp-1">{{ $pengumuman->judul }}</h4>
                    <p class="text-xs text-gray-500 line-clamp-2 mb-2 leading-relaxed">{{ Str::limit(strip_tags($pengumuman->isi), 100) }}</p>
                    <p class="text-[10px] font-medium text-gray-400">{{ $pengumuman->created_at->translatedFormat('d F Y') }}</p>
                </div>
            </div>
        @empty
            <div class="col-span-2 bg-white rounded-xl shadow-sm border border-gray-200 p-8 text-center text-gray-400">
                <svg class="w-10 h-10 mx-auto mb-2 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M11 5.882V19.24a1.76 1.76 0 01-3.417.592l-2.147-6.15M18 13a3 3 0 100-6M5.436 13.683A4.001 4.001 0 017 6h1.832c4.1 0 7.625-1.234 9.168-3v14c-1.543-1.766-5.067-3-9.168-3H7a3.988 3.988 0 01-1.564-.317z"></path>
                </svg>
                <p class="text-sm">Tidak ada pengumuman terbaru.</p>
            </div>
        @endforelse
    </div>
</div>
@endsection