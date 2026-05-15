@extends('layouts.siswa')

@section('title', 'Dashboard Siswa')
@section('page-title', 'DASHBOARD')

@section('content')

<!-- Header Section -->
<div class="mb-8">
    <h1 class="text-3xl font-bold text-gray-900 mb-1">Selamat datang, {{ auth()->user()->name ?? 'Budi Santoso' }}</h1>
    <p class="text-gray-500 text-base">Kelas XII TKJ 1 &bull; Semester Genap 2025/2026</p>
</div>

<!-- Main Grid -->
<div class="grid grid-cols-1 lg:grid-cols-12 gap-6 mb-8">
    
    <!-- Jadwal Hari Ini (Col Span 7) -->
    <div class="lg:col-span-7 bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
        <div class="flex justify-between items-center mb-6">
            <h3 class="text-xl font-bold text-gray-800">Jadwal Hari Ini</h3>
            <span class="px-3 py-1 bg-indigo-50 text-indigo-600 text-xs font-semibold rounded-full uppercase tracking-wide">
                {{ \Carbon\Carbon::now()->translatedFormat('l, d F Y') }}
            </span>
        </div>
        
        <div class="space-y-4">
            <!-- Active Schedule Item -->
            <div class="group flex items-start space-x-4 p-3 rounded-xl hover:bg-gray-50 transition-colors duration-200">
                <div class="flex flex-col items-center min-w-[60px] pt-1">
                    <span class="text-sm font-bold text-gray-800">07:15</span>
                    <span class="text-xs text-gray-400">08:45</span>
                </div>
                <div class="flex-1 border-l-4 border-blue-600 pl-4 py-1">
                    <h4 class="font-bold text-gray-800 text-base">Matematika</h4>
                    <p class="text-sm text-gray-500 mt-0.5">Drs. Supriyadi &bull; R. Kelas</p>
                </div>
            </div>

            <!-- Next Schedule Item (Highlighted Background) -->
            <div class="group flex items-start space-x-4 p-3 rounded-xl bg-gray-50 border border-gray-100">
                <div class="flex flex-col items-center min-w-[60px] pt-1">
                    <span class="text-sm font-bold text-gray-800">08:45</span>
                    <span class="text-xs text-gray-400">10:15</span>
                </div>
                <div class="flex-1 border-l-4 border-blue-600 pl-4 py-1">
                    <h4 class="font-bold text-gray-800 text-base">Bahasa Indonesia</h4>
                    <p class="text-sm text-gray-500 mt-0.5">Ahmad Faizal, M.Kom &bull; R. Kelas</p>
                </div>
            </div>

            <!-- Future Schedule Item -->
            <div class="group flex items-start space-x-4 p-3 rounded-xl hover:bg-gray-50 transition-colors duration-200">
                <div class="flex flex-col items-center min-w-[60px] pt-1">
                    <span class="text-sm font-bold text-gray-800">10:45</span>
                    <span class="text-xs text-gray-400">12:15</span>
                </div>
                <div class="flex-1 border-l-4 border-gray-200 pl-4 py-1">
                    <h4 class="font-bold text-gray-800 text-base">Pendidikan Agama Islam</h4>
                    <p class="text-sm text-gray-500 mt-0.5">Ust. Hakim &bull; Mushola</p>
                </div>
            </div>
        </div>

        <div class="mt-6 pt-4 border-t border-gray-50 text-center">
            <a href="{{ route('siswa.jadwal.index') }}" class="inline-flex items-center text-sm font-semibold text-blue-600 hover:text-blue-800 transition-colors">
                Lihat Jadwal Lengkap
                <i class="fas fa-chevron-right ml-1 text-xs"></i>
            </a>
        </div>
    </div>

    <!-- Presensi (Col Span 5 split into 2 cols visually inside or separate blocks) -->
    <!-- In reference image, Presensi and Nilai are side by side on the right -->
    <div class="lg:col-span-5 grid grid-cols-1 md:grid-cols-2 gap-6">
        
        <!-- Presensi Card -->
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 flex flex-col h-full">
            <div class="mb-4">
                <h3 class="text-xl font-bold text-gray-800">Presensi</h3>
                <p class="text-sm text-gray-500">Bulan Ini</p>
            </div>

            <div class="flex-1 flex flex-col items-center justify-center relative my-2">
                <!-- Circular Progress -->
                <div class="relative w-32 h-32">
                    <svg class="w-full h-full transform -rotate-90" viewBox="0 0 36 36">
                        <path class="text-gray-100" d="M18 2.0845 a 15.9155 15.9155 0 0 1 0 31.831 a 15.9155 15.9155 0 0 1 0 -31.831" fill="none" stroke="currentColor" stroke-width="3" />
                        <path class="text-blue-600" stroke-dasharray="92, 100" d="M18 2.0845 a 15.9155 15.9155 0 0 1 0 31.831 a 15.9155 15.9155 0 0 1 0 -31.831" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" />
                    </svg>
                    <div class="absolute inset-0 flex items-center justify-center flex-col">
                        <span class="text-3xl font-bold text-gray-800">92%</span>
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-2 gap-3 mt-4">
                <div class="bg-gray-50 rounded-lg p-3 text-center border border-gray-100">
                    <p class="text-xs font-bold text-gray-700 uppercase tracking-wide">Hadir</p>
                    <p class="text-lg font-bold text-gray-800 mt-1">22 <span class="text-xs font-normal text-gray-500">Hari</span></p>
                </div>
                <div class="bg-red-50 rounded-lg p-3 text-center border border-red-100">
                    <p class="text-xs font-bold text-red-700 uppercase tracking-wide">Alpha</p>
                    <p class="text-lg font-bold text-red-600 mt-1">0 <span class="text-xs font-normal text-red-400">Hari</span></p>
                </div>
            </div>
        </div>

        <!-- Nilai Terbaru Card -->
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 flex flex-col h-full">
            <h3 class="text-xl font-bold text-gray-800 mb-5">Nilai Terbaru</h3>

            <div class="space-y-5 flex-1">
                <!-- Grade Item 1 -->
                <div class="flex items-center justify-between group">
                    <div>
                        <h4 class="font-bold text-gray-800 text-sm group-hover:text-blue-600 transition-colors">Tugas P. Web 3</h4>
                        <p class="text-xs text-gray-500 mt-0.5">Infrastruktur Jaringan</p>
                    </div>
                    <div class="flex items-center justify-center w-10 h-10 rounded-full bg-blue-50 text-blue-700 font-bold text-lg">
                        88
                    </div>
                </div>
                
                <!-- Divider -->
                <div class="border-b border-gray-50"></div>

                <!-- Grade Item 2 -->
                <div class="flex items-center justify-between group">
                    <div>
                        <h4 class="font-bold text-gray-800 text-sm group-hover:text-blue-600 transition-colors">UTS Ganjil</h4>
                        <p class="text-xs text-gray-500 mt-0.5">Matematika</p>
                    </div>
                    <div class="flex items-center justify-center w-10 h-10 rounded-full bg-blue-50 text-blue-700 font-bold text-lg">
                        82
                    </div>
                </div>

                <!-- Divider -->
                <div class="border-b border-gray-50"></div>

                <!-- Grade Item 3 -->
                <div class="flex items-center justify-between group">
                    <div>
                        <h4 class="font-bold text-gray-800 text-sm group-hover:text-blue-600 transition-colors">Kuis 2</h4>
                        <p class="text-xs text-gray-500 mt-0.5">Bahasa Inggris</p>
                    </div>
                    <div class="flex items-center justify-center w-10 h-10 rounded-full bg-blue-50 text-blue-700 font-bold text-lg">
                        95
                    </div>
                </div>
            </div>

            <div class="mt-6 pt-2 text-center">
                <a href="{{ route('siswa.nilai.index') }}" class="inline-flex items-center text-sm font-semibold text-blue-600 hover:text-blue-800 transition-colors">
                    Lihat Semua Nilai
                    <i class="fas fa-chevron-right ml-1 text-xs"></i>
                </a>
            </div>
        </div>
    </div>
</div>

<!-- Pengumuman Sekolah -->
<div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
    <div class="flex justify-between items-center mb-6">
        <h3 class="text-xl font-bold text-gray-800">Pengumuman Sekolah</h3>
        <a href="{{ route('siswa.pengumuman.index') }}" class="text-sm font-semibold text-blue-600 hover:text-blue-800 flex items-center">
            Lihat Semua <i class="fas fa-arrow-right ml-1 text-xs"></i>
        </a>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
        <!-- Announcement 1 -->
        <div class="border border-gray-200 rounded-xl p-5 flex items-start space-x-4 hover:border-blue-200 hover:bg-blue-50/30 transition-all duration-200">
            <div class="w-10 h-10 rounded-lg bg-blue-100 text-blue-600 flex items-center justify-center flex-shrink-0">
                <i class="fas fa-bullhorn"></i>
            </div>
            <div>
                <h4 class="font-bold text-gray-800 text-sm mb-1 line-clamp-1">Pendaftaran Ekstrakurikuler Semester Ganjil</h4>
                <p class="text-sm text-gray-500 mb-2 line-clamp-2">Pendaftaran dibuka hingga 25 April 2026. Silakan daftar melalui wali kelas masing-masing.</p>
                <p class="text-xs text-gray-400 font-medium"><i class="far fa-clock mr-1"></i> 19 April 2026</p>
            </div>
        </div>

        <!-- Announcement 2 -->
        <div class="border border-gray-200 rounded-xl p-5 flex items-start space-x-4 hover:border-blue-200 hover:bg-blue-50/30 transition-all duration-200">
            <div class="w-10 h-10 rounded-lg bg-indigo-100 text-indigo-600 flex items-center justify-center flex-shrink-0">
                <i class="fas fa-info-circle"></i>
            </div>
            <div>
                <h4 class="font-bold text-gray-800 text-sm mb-1 line-clamp-1">Perubahan Jadwal Seragam Hari Kamis</h4>
                <p class="text-sm text-gray-500 mb-2 line-clamp-2">Mulai minggu ini, seragam hari Kamis diubah menjadi Batik Sekolah, bukan Pramuka.</p>
                <p class="text-xs text-gray-400 font-medium"><i class="far fa-clock mr-1"></i> 17 April 2026</p>
            </div>
        </div>
    </div>
</div>

@endsection