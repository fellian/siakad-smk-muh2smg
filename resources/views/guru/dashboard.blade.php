@extends('layouts.guru')

@section('title', 'Dashboard Guru')
@section('page-title', 'DASHBOARD')

@section('content')

<div class="mb-8">
    <h1 class="text-3xl font-bold text-gray-900 mb-2">Selamat Datang, {{ auth()->user()->name ?? 'Guru' }}</h1>
    <p class="text-gray-500 text-sm">Berikut adalah ringkasan aktivitas mengajar Anda hari ini.</p>
</div>

<!-- Statistik -->
<div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 flex items-center space-x-6">
        <div class="w-16 h-16 rounded-full bg-blue-50 flex items-center justify-center text-blue-700">
            <i data-lucide="book" class="w-6 h-6"></i>
        </div>
        <div>
            <p class="text-xs font-bold text-gray-500 uppercase tracking-wider mb-1">Jadwal Hari Ini</p>
            <div class="flex items-baseline space-x-2">
                <h2 class="text-4xl font-bold text-gray-900">{{ $jadwalHariIni->count() }}</h2>
                <span class="text-gray-500 text-sm">Kelas</span>
            </div>
        </div>
    </div>

    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 flex items-center space-x-6">
        <div class="w-16 h-16 rounded-full bg-cyan-50 flex items-center justify-center text-cyan-600">
            <i data-lucide="users" class="w-6 h-6"></i>
        </div>
        <div>
            <p class="text-xs font-bold text-gray-500 uppercase tracking-wider mb-1">Total Siswa</p>
            <div class="flex items-baseline space-x-2">
                <h2 class="text-4xl font-bold text-gray-900">{{ $totalSiswaHariIni ?? 0 }}</h2>
                <span class="text-gray-500 text-sm">Orang</span>
            </div>
        </div>
    </div>

    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 flex items-center space-x-6">
        <div class="w-16 h-16 rounded-full bg-gray-600 flex items-center justify-center text-white">
            <i data-lucide="calendar" class="w-6 h-6"></i>
        </div>
        <div>
            <p class="text-xs font-bold text-gray-500 uppercase tracking-wider mb-1">Jam Mengajar</p>
            <div class="flex items-baseline space-x-2">
                <h2 class="text-4xl font-bold text-gray-900">{{ $totalJadwal }}</h2>
                <span class="text-gray-500 text-sm">Jam</span>
            </div>
        </div>
    </div>
</div>

<div class="grid grid-cols-1 lg:grid-cols-12 gap-8">

    <div class="lg:col-span-8">
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 flex flex-col h-full">
            <div class="flex flex-col sm:flex-row sm:justify-between sm:items-center gap-4 mb-6">
                <h3 class="text-xl font-bold text-gray-800">Jadwal Mengajar Hari Ini</h3>
                <span class="px-4 py-1.5 bg-indigo-50 text-indigo-700 text-sm font-bold rounded-full">{{ \Carbon\Carbon::now()->translatedFormat('l, d F Y') }}</span>
            </div>

            <div class="space-y-4 flex-1">
                @php $nowDashboard = \Carbon\Carbon::now(); @endphp
                @forelse($jadwalHariIni as $jadwal)
                    @php
                        $jamMulai = \Carbon\Carbon::today()->setTimeFromTimeString(\Carbon\Carbon::parse($jadwal->jam_mulai)->format('H:i:s'));
                        $jamSelesai = \Carbon\Carbon::today()->setTimeFromTimeString(\Carbon\Carbon::parse($jadwal->jam_selesai)->format('H:i:s'));
                        $sesiBuka = $sesiAktifHariIni[$jadwal->id] ?? null;
                        
                        // Active logic: time is between start and end, or session is open
                        $isActive = $nowDashboard->between($jamMulai, $jamSelesai) || $sesiBuka;
                        $isPast = $nowDashboard->greaterThan($jamSelesai) && !$sesiBuka;
                        $isFuture = $nowDashboard->lessThan($jamMulai);
                        
                        // Check if a session was opened and closed already (status selesai)
                        // If it's in the past, and there is no open session, it's considered done.
                    @endphp

                    @if($isActive || $sesiBuka)
                        <div class="border-2 border-blue-800 rounded-xl flex items-stretch overflow-hidden">
                            <div class="w-24 bg-blue-800 text-white flex flex-col justify-center items-center py-4 border-r border-blue-800">
                                <span class="font-bold text-lg">{{ \Carbon\Carbon::parse($jadwal->jam_mulai)->format('H:i') }}</span>
                                <span class="text-xs text-blue-200 mt-1">{{ \Carbon\Carbon::parse($jadwal->jam_selesai)->format('H:i') }}</span>
                            </div>
                            <div class="flex-1 p-5 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 bg-white border-l border-blue-800">
                                <div>
                                    <h4 class="font-bold text-gray-800 text-base mb-1">{{ $jadwal->mataPelajaran->nama_mapel }}</h4>
                                    <div class="flex items-center text-sm text-gray-500 space-x-2">
                                        <i data-lucide="building" class="w-4 h-4"></i>
                                        <span>{{ $jadwal->kelas->nama_kelas }}</span>
                                        <span>•</span>
                                        <i data-lucide="door-open" class="w-4 h-4"></i>
                                        <span>{{ $jadwal->ruangan ?? 'R. Kelas' }}</span>
                                    </div>
                                </div>
                                @if($sesiBuka)
                                    <a href="{{ route('guru.absensi.sesi.show', $sesiBuka) }}" class="inline-flex px-5 py-2 border border-blue-800 text-blue-800 font-bold rounded-lg items-center justify-center hover:bg-blue-50 transition-colors text-sm shadow-sm whitespace-nowrap">
                                        <i data-lucide="settings" class="w-4 h-4 mr-2"></i> Kelola sesi
                                    </a>
                                @else
                                    <form action="{{ route('guru.absensi.sesi.mulai', $jadwal) }}" method="POST" class="inline" onsubmit="return confirm('Buka sesi presensi?');">
                                        @csrf
                                        <button type="submit" class="px-5 py-2 border border-blue-800 text-blue-800 font-bold rounded-lg flex items-center hover:bg-blue-50 transition-colors whitespace-nowrap text-sm">
                                            <i data-lucide="user-check" class="w-4 h-4 mr-2"></i> Mulai Presensi
                                        </button>
                                    </form>
                                @endif
                            </div>
                        </div>
                    @elseif($isPast)
                        <div class="border border-gray-200 rounded-xl flex items-stretch overflow-hidden">
                            <div class="w-24 bg-gray-50 flex flex-col justify-center items-center py-4 border-r border-gray-200">
                                <span class="font-bold text-gray-800 text-lg">{{ \Carbon\Carbon::parse($jadwal->jam_mulai)->format('H:i') }}</span>
                                <span class="text-xs text-gray-500 mt-1">{{ \Carbon\Carbon::parse($jadwal->jam_selesai)->format('H:i') }}</span>
                            </div>
                            <div class="flex-1 p-5 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 bg-white">
                                <div>
                                    <h4 class="font-bold text-gray-800 text-base mb-1">{{ $jadwal->mataPelajaran->nama_mapel }}</h4>
                                    <div class="flex items-center text-sm text-gray-500 space-x-2">
                                        <i data-lucide="building" class="w-4 h-4"></i>
                                        <span>{{ $jadwal->kelas->nama_kelas }}</span>
                                        <span>•</span>
                                        <i data-lucide="door-open" class="w-4 h-4"></i>
                                        <span>{{ $jadwal->ruangan ?? 'R. Kelas' }}</span>
                                    </div>
                                </div>
                                <span class="px-6 py-2 bg-blue-800 text-white font-bold rounded-lg text-sm inline-flex items-center shadow-sm">
                                    Selesai
                                </span>
                            </div>
                        </div>
                    @else
                        <!-- Future -->
                        <div class="border border-gray-200 rounded-xl flex items-stretch overflow-hidden">
                            <div class="w-24 bg-gray-50 flex flex-col justify-center items-center py-4 border-r border-gray-200 opacity-70">
                                <span class="font-bold text-gray-500 text-lg">{{ \Carbon\Carbon::parse($jadwal->jam_mulai)->format('H:i') }}</span>
                                <span class="text-xs text-gray-400 mt-1">{{ \Carbon\Carbon::parse($jadwal->jam_selesai)->format('H:i') }}</span>
                            </div>
                            <div class="flex-1 p-5 flex items-center justify-between bg-white opacity-80">
                                <div>
                                    <h4 class="font-bold text-gray-500 text-base mb-1">{{ $jadwal->mataPelajaran->nama_mapel }}</h4>
                                    <div class="flex items-center text-sm text-gray-400 space-x-2">
                                        <i data-lucide="building" class="w-4 h-4"></i>
                                        <span>{{ $jadwal->kelas->nama_kelas }}</span>
                                        <span>•</span>
                                        <i data-lucide="door-open" class="w-4 h-4"></i>
                                        <span>{{ $jadwal->ruangan ?? 'R. Kelas' }}</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif
                @empty
                    <div class="text-center py-12 border border-dashed border-gray-200 rounded-xl bg-gray-50 text-gray-500">
                        Tidak ada jadwal mengajar hari ini.
                    </div>
                @endforelse
            </div>

            <div class="mt-6 pt-4 text-left">
                <a href="{{ route('guru.jadwal.index') }}" class="text-sm font-bold text-blue-800 hover:text-blue-900">Lihat Semua Jadwal</a>
            </div>
        </div>
    </div>

    <div class="lg:col-span-4 flex flex-col gap-8">
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
            <h3 class="text-xl font-bold text-gray-800 mb-6 text-center">Akses Cepat</h3>

            <div class="grid grid-cols-2 gap-4">
                <a href="{{ route('guru.nilai.index') }}" class="bg-blue-100 hover:bg-blue-200 border border-blue-100 rounded-2xl p-6 flex flex-col items-center justify-center text-center transition-colors group h-32">
                    <div class="w-10 h-10 bg-transparent text-gray-800 flex items-center justify-center mb-2 group-hover:scale-110 transition-transform">
                        <i data-lucide="file-signature" class="w-7 h-7"></i>
                    </div>
                    <span class="font-semibold text-gray-800 text-sm">Input Nilai</span>
                </a>

                <a href="{{ route('guru.absensi.rekap') }}" class="bg-indigo-100 hover:bg-indigo-200 border border-indigo-100 rounded-2xl p-6 flex flex-col items-center justify-center text-center transition-colors group h-32">
                    <div class="w-10 h-10 bg-transparent text-gray-800 flex items-center justify-center mb-2 group-hover:scale-110 transition-transform">
                        <i data-lucide="clipboard-check" class="w-7 h-7"></i>
                    </div>
                    <span class="font-semibold text-gray-800 text-sm">Rekap<br>Presensi</span>
                </a>
            </div>
        </div>
    </div>

</div>

@endsection
