@extends('layouts.siswa')

@section('title', 'Presensi')
@section('page-title', 'Presensi')

@section('content')
<div class="mb-8 flex flex-col md:flex-row md:items-end justify-between gap-4">
    <div>
        <h1 class="text-2xl md:text-3xl font-bold text-gray-900 mb-1">Presensi Hari Ini</h1>
        <p class="text-sm text-gray-500">Lakukan presensi kehadiran pada mata pelajaran yang sedang berlangsung.</p>
    </div>
    <a href="{{ route('siswa.absensi.rekap') }}" class="inline-flex items-center px-4 py-2 bg-gray-900 hover:bg-gray-800 text-white text-sm font-medium rounded-xl transition-colors shadow-sm">
        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
        </svg>
        Rekap Presensi
    </a>
</div>

<!-- Jadwal Hari Ini Section -->
<div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6 mb-8">
    <div class="flex justify-between items-center mb-5">
        <h3 class="text-lg font-semibold text-gray-900">Jadwal Hari Ini</h3>
        <span class="px-3 py-1 bg-blue-50 text-blue-700 text-xs font-medium rounded-full">
            {{ \Carbon\Carbon::now()->translatedFormat('l, d F Y') }}
        </span>
    </div>

    <div class="space-y-3">
        @php $nowDashboard = \Carbon\Carbon::now(); @endphp
        @forelse($jadwalHariIni as $jadwal)
            @php
                $mulai = \Carbon\Carbon::parse($jadwal->jam_mulai)->format('H:i');
                $selesai = \Carbon\Carbon::parse($jadwal->jam_selesai)->format('H:i');
                $jamMulai = \Carbon\Carbon::today()->setTimeFromTimeString(\Carbon\Carbon::parse($jadwal->jam_mulai)->format('H:i:s'));
                $jamSelesai = \Carbon\Carbon::today()->setTimeFromTimeString(\Carbon\Carbon::parse($jadwal->jam_selesai)->format('H:i:s'));
                $isActive = $nowDashboard->between($jamMulai, $jamSelesai) || $sesiPresensiAktif->contains('jadwal_id', $jadwal->id);
            @endphp
            <div class="flex items-start gap-4 p-4 rounded-xl {{ $isActive ? 'bg-blue-50 border-2 border-blue-200' : 'bg-gray-50/50 border border-gray-100' }}">
                <div class="flex flex-col items-center min-w-[4rem] pt-0.5">
                    <span class="text-base font-bold text-gray-900">{{ $mulai }}</span>
                    <span class="text-xs text-gray-500">{{ $selesai }}</span>
                </div>
                <div class="flex-1 min-w-0">
                    <h4 class="text-base font-semibold text-gray-900">{{ $jadwal->mataPelajaran->nama_mapel }}</h4>
                    <p class="text-sm text-gray-500 mt-0.5">{{ $jadwal->guru->nama_lengkap ?? '-' }} &bull; {{ $jadwal->ruangan ?? '-' }}</p>
                    
                    @if($isActive)
                        @php
                            $sesi = $sesiPresensiAktif->where('jadwal_id', $jadwal->id)->first();
                            $sudah = $sesi ? $presensiSudahIds->contains($sesi->id) : false;
                        @endphp
                        @if($sesi && !$sudah)
                            <form action="{{ route('siswa.absensi.presensi.store') }}" method="POST" class="mt-3">
                                @csrf
                                <input type="hidden" name="presensi_sesi_id" value="{{ $sesi->id }}">
                                <input type="hidden" name="tipe_kehadiran" value="otomatis">
                                <button type="submit" class="inline-flex items-center px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white text-sm font-medium rounded-lg transition-colors shadow-sm">
                                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                    </svg>
                                    Presensi
                                </button>
                            </form>
                        @elseif($sudah)
                            <span class="inline-flex items-center mt-3 px-3 py-1.5 bg-green-100 text-green-700 text-sm font-medium rounded-lg">
                                <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                </svg>
                                Sudah Presensi
                            </span>
                        @endif
                    @else
                        <div class="mt-3">
                            <span class="inline-flex items-center px-3 py-1.5 bg-gray-100 text-gray-500 text-sm font-medium rounded-lg">
                                <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                Belum Waktu Presensi
                            </span>
                        </div>
                    @endif
                </div>
                @if($isActive && !$sudah && $sesi)
                    <div class="hidden sm:flex flex-col items-end">
                        <span class="text-xs font-medium text-blue-600 bg-blue-100 px-2 py-1 rounded-full">
                            Sedang Berlangsung
                        </span>
                    </div>
                @endif
            </div>
        @empty
            <div class="text-center py-12 text-gray-400">
                <svg class="w-16 h-16 mx-auto mb-4 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                </svg>
                <p class="text-base font-medium text-gray-600">Tidak ada jadwal pelajaran hari ini.</p>
            </div>
        @endforelse
    </div>
</div>
@endsection