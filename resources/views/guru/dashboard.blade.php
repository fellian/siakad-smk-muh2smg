@extends('layouts.guru')

@section('title', 'Dashboard Guru')
@section('page-title', 'DASHBOARD')

@section('content')

<div class="mb-8">
    <h1 class="text-3xl font-bold text-gray-900 mb-2">Selamat Datang, {{ auth()->user()->name ?? 'Ahmad Tohari S.Kom' }}</h1>
    <p class="text-gray-500">Berikut adalah ringkasan aktivitas mengajar Anda hari ini.</p>
</div>

<!-- Statistik -->
<div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
    <!-- Jadwal -->
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 flex items-center space-x-6">
        <div class="w-16 h-16 rounded-full bg-blue-50 flex items-center justify-center text-blue-700">
            <i class="fas fa-book text-xl"></i>
        </div>
        <div>
            <p class="text-xs font-bold text-gray-500 uppercase tracking-wider mb-1">Jadwal Hari Ini</p>
            <div class="flex items-baseline space-x-2">
                <h2 class="text-4xl font-bold text-gray-900">{{ $totalJadwal ?? 3 }}</h2>
                <span class="text-gray-500 text-sm">Kelas</span>
            </div>
        </div>
    </div>

    <!-- Siswa -->
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 flex items-center space-x-6">
        <div class="w-16 h-16 rounded-full bg-blue-50 flex items-center justify-center text-blue-700">
            <i class="fas fa-user-friends text-xl"></i>
        </div>
        <div>
            <p class="text-xs font-bold text-gray-500 uppercase tracking-wider mb-1">Total Siswa</p>
            <div class="flex items-baseline space-x-2">
                <h2 class="text-4xl font-bold text-gray-900">80</h2>
                <span class="text-gray-500 text-sm">Orang</span>
            </div>
        </div>
    </div>

    <!-- Jam Mengajar -->
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 flex items-center space-x-6">
        <div class="w-16 h-16 rounded-full bg-gray-500 flex items-center justify-center text-white">
            <i class="far fa-calendar-alt text-xl"></i>
        </div>
        <div>
            <p class="text-xs font-bold text-gray-500 uppercase tracking-wider mb-1">Jam Mengajar</p>
            <div class="flex items-baseline space-x-2">
                <h2 class="text-4xl font-bold text-gray-900">7</h2>
                <span class="text-gray-500 text-sm">Jam</span>
            </div>
        </div>
    </div>
</div>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
    
    <!-- Jadwal Mengajar Hari Ini -->
    <div class="lg:col-span-2">
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
            <div class="px-8 py-6 border-b border-gray-100 flex justify-between items-center">
                <h3 class="text-xl font-bold text-gray-800">Jadwal Mengajar Hari Ini</h3>
                <span class="px-4 py-1.5 bg-blue-100 text-blue-800 text-sm font-semibold rounded-full">{{ \Carbon\Carbon::now()->translatedFormat('l, d F Y') }}</span>
            </div>
            
            <div class="p-8 space-y-4">
                
                <!-- Selesai Card -->
                <div class="border border-gray-200 rounded-xl flex items-stretch overflow-hidden">
                    <div class="w-24 bg-gray-50 border-r border-gray-200 flex flex-col justify-center items-center py-4">
                        <span class="font-bold text-gray-700">07:15</span>
                        <span class="text-xs text-gray-500">08:45</span>
                    </div>
                    <div class="flex-1 p-5 flex items-center justify-between">
                        <div>
                            <h4 class="font-bold text-gray-800 text-lg mb-1">Pemrograman Web & Perangkat Bergerak</h4>
                            <div class="flex items-center text-sm text-gray-500 space-x-4">
                                <span class="flex items-center"><i class="fas fa-building mr-2"></i> XI TKJ 1</span>
                                <span class="text-gray-300">•</span>
                                <span class="flex items-center"><i class="fas fa-door-open mr-2"></i> R. Kelas</span>
                            </div>
                        </div>
                        <div>
                            <button class="px-6 py-2 bg-blue-800 text-white font-medium rounded-lg shadow-sm">Selesai</button>
                        </div>
                    </div>
                </div>

                <!-- Aktif Card -->
                <div class="border-2 border-blue-800 rounded-xl flex items-stretch overflow-hidden shadow-sm shadow-blue-100">
                    <div class="w-24 bg-blue-800 text-white flex flex-col justify-center items-center py-4">
                        <span class="font-bold text-lg">09:00</span>
                        <span class="text-xs text-blue-200">10:30</span>
                    </div>
                    <div class="flex-1 p-5 flex items-center justify-between">
                        <div>
                            <h4 class="font-bold text-gray-800 text-lg mb-1">Basis Data Lanjut</h4>
                            <div class="flex items-center text-sm text-gray-500 space-x-4">
                                <span class="flex items-center"><i class="fas fa-building mr-2"></i> XII TKJ 2</span>
                                <span class="text-gray-300">•</span>
                                <span class="flex items-center"><i class="fas fa-door-open mr-2"></i> R. Kelas</span>
                            </div>
                        </div>
                        <div>
                            <button class="px-5 py-2 border border-blue-800 text-blue-800 font-medium rounded-lg flex items-center hover:bg-blue-50 transition-colors">
                                <i class="fas fa-user-check mr-2"></i> Mulai Presensi
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Belum Mulai Card -->
                <div class="border border-gray-200 rounded-xl flex items-stretch overflow-hidden opacity-75">
                    <div class="w-24 bg-gray-50 border-r border-gray-200 flex flex-col justify-center items-center py-4">
                        <span class="font-bold text-gray-700">13:00</span>
                        <span class="text-xs text-gray-500">14:30</span>
                    </div>
                    <div class="flex-1 p-5 flex items-center justify-between">
                        <div>
                            <h4 class="font-bold text-gray-500 text-lg mb-1">Administrasi Infrastruktur Jaringan</h4>
                            <div class="flex items-center text-sm text-gray-400 space-x-4">
                                <span class="flex items-center"><i class="fas fa-building mr-2"></i> XI TO 2</span>
                                <span class="text-gray-300">•</span>
                                <span class="flex items-center"><i class="fas fa-door-open mr-2"></i> R. Kelas</span>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
            
            <div class="px-8 py-5 bg-gray-50 border-t border-gray-100">
                <a href="#" class="text-sm font-bold text-blue-800 hover:text-blue-900">Lihat Semua Jadwal</a>
            </div>
        </div>
    </div>

    <!-- Akses Cepat -->
    <div class="lg:col-span-1">
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-8">
            <h3 class="text-xl font-bold text-gray-800 mb-6 text-center">Akses Cepat</h3>
            
            <div class="grid grid-cols-2 gap-4">
                <a href="{{ route('guru.nilai.index') }}" class="bg-blue-100/50 hover:bg-blue-100 border border-blue-100 rounded-2xl p-6 flex flex-col items-center justify-center text-center transition-colors group">
                    <div class="w-12 h-12 bg-white rounded-xl shadow-sm text-blue-800 flex items-center justify-center mb-3 group-hover:scale-110 transition-transform">
                        <i class="fas fa-file-signature text-xl"></i>
                    </div>
                    <span class="font-semibold text-gray-700 text-sm">Input Nilai</span>
                </a>
                
                <a href="{{ route('guru.absensi.index') }}" class="bg-blue-100/50 hover:bg-blue-100 border border-blue-100 rounded-2xl p-6 flex flex-col items-center justify-center text-center transition-colors group">
                    <div class="w-12 h-12 bg-white rounded-xl shadow-sm text-blue-800 flex items-center justify-center mb-3 group-hover:scale-110 transition-transform">
                        <i class="fas fa-clipboard-list text-xl"></i>
                    </div>
                    <span class="font-semibold text-gray-700 text-sm">Rekap<br>Presensi</span>
                </a>
            </div>
        </div>
    </div>

</div>

@endsection