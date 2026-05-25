@extends('layouts.admin')

@section('title', 'Dashboard Admin')
@section('page-title', 'DASHBOARD')

@section('content')

    <!-- Header Selamat Datang -->
    <div class="mb-8">
        <h1 class="text-3xl font-bold text-blue-900 mb-2">Selamat Datang, Admin</h1>
        <p class="text-gray-500 text-sm sm:text-base">Sistem Informasi Akademik SMK Muhammadiyah 2 Semarang</p>
    </div>

    <!-- Statistik Utama -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
        <!-- Siswa -->
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 flex items-center space-x-4 transition-all hover:shadow-md">
            <div class="w-14 h-14 rounded-xl bg-blue-50 flex items-center justify-center text-blue-600 flex-shrink-0">
                <i class="fas fa-user-friends text-xl"></i>
            </div>
            <div>
                <p class="text-xs font-bold text-gray-400 uppercase tracking-wider mb-1">Total Siswa</p>
                <h2 class="text-3xl font-bold text-gray-800">{{ $totalSiswa ?? 0 }}</h2>
            </div>
        </div>

        <!-- Guru -->
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 flex items-center space-x-4 transition-all hover:shadow-md">
            <div class="w-14 h-14 rounded-xl bg-indigo-50 flex items-center justify-center text-indigo-600 flex-shrink-0">
                <i class="fas fa-graduation-cap text-xl"></i>
            </div>
            <div>
                <p class="text-xs font-bold text-gray-400 uppercase tracking-wider mb-1">Total Guru</p>
                <h2 class="text-3xl font-bold text-gray-800">{{ $totalGuru ?? 0 }}</h2>
            </div>
        </div>

        <!-- Kelas -->
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 flex items-center space-x-4 transition-all hover:shadow-md">
            <div class="w-14 h-14 rounded-xl bg-emerald-50 flex items-center justify-center text-emerald-600 flex-shrink-0">
                <i class="fas fa-door-open text-xl"></i>
            </div>
            <div>
                <p class="text-xs font-bold text-gray-400 uppercase tracking-wider mb-1">Total Kelas</p>
                <h2 class="text-3xl font-bold text-gray-800">{{ $totalKelas ?? 0 }}</h2>
            </div>
        </div>

        <!-- Jurusan -->
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 flex items-center space-x-4 transition-all hover:shadow-md">
            <div class="w-14 h-14 rounded-xl bg-amber-50 flex items-center justify-center text-amber-600 flex-shrink-0">
                <i class="fas fa-shapes text-xl"></i>
            </div>
            <div>
                <p class="text-xs font-bold text-gray-400 uppercase tracking-wider mb-1">Total Jurusan</p>
                <h2 class="text-3xl font-bold text-gray-800">{{ $totalJurusan ?? 0 }}</h2>
            </div>
        </div>
    </div>

    <!-- Konten Bawah (Grid 2 Kolom) -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">

        <!-- Aktivitas Sistem Terkini -->
        <div class="lg:col-span-2">
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden h-full flex flex-col justify-between">
                <div>
                    <div class="px-6 py-5 border-b border-gray-100 flex justify-between items-center">
                        <h3 class="text-lg font-bold text-gray-800">Aktivitas Sistem Terkini</h3>
                        <!-- ROUTE REDIRECT: Diarahkan ke halaman aktivitas sistem lengkap -->
                        <a href="{{ route('admin.aktivitas.index') }}" class="text-sm font-semibold text-blue-600 hover:text-blue-800 transition-colors">
                            Lihat Semua
                        </a>
                    </div>

                    <div class="overflow-x-auto">
                        <table class="w-full text-left text-sm whitespace-nowrap">
                            <thead class="bg-gray-50/70 text-gray-500 font-semibold uppercase text-xs tracking-wider border-b border-gray-100">
                                <tr>
                                    <th class="px-6 py-4">Pengguna</th>
                                    <th class="px-6 py-4">Aktivitas</th>
                                    <th class="px-6 py-4">Waktu</th>
                                    <th class="px-6 py-4">Status</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-100">
                                @forelse($activities as $activity)
                                    <tr>
                                        <!-- Pengguna & Inisial Gambar -->
                                        <td class="px-6 py-4">
                                            <div class="flex items-center space-x-3">
                                                <div class="w-8 h-8 rounded-full bg-blue-50 text-blue-600 flex items-center justify-center font-bold text-xs flex-shrink-0 ring-1 ring-gray-100 shadow-sm">
                                                    {{ 
                                                        collect(explode(' ', $activity->user->name ?? 'Sistem'))
                                                            ->map(fn($word) => strtoupper(substr($word, 0, 1)))
                                                            ->take(2)
                                                            ->implode('') 
                                                    }}
                                                </div>
                                                <span class="font-medium text-gray-900">{{ $activity->user->name ?? 'Sistem' }}</span>
                                            </div>
                                        </td>

                                        <!-- Aktivitas -->
                                        <td class="px-6 py-4 text-gray-600">
                                            {{ $activity->activity }}
                                        </td>

                                        <!-- Waktu -->
                                        <td class="px-6 py-4 text-gray-400 text-xs">
                                            {{ $activity->created_at->diffForHumans() }}
                                        </td>

                                        <!-- Status Badge -->
                                        <td class="px-6 py-4">
                                            @if(strtolower($activity->status) == 'sukses')
                                                <span class="inline-flex px-2.5 py-1 rounded-full text-xs font-semibold bg-green-50 text-green-700 ring-1 ring-inset ring-green-600/10">
                                                    Sukses
                                                </span>
                                            @else
                                                <span class="inline-flex px-2.5 py-1 rounded-full text-xs font-semibold bg-rose-50 text-rose-700 ring-1 ring-inset ring-rose-600/10">
                                                    Gagal
                                                </span>
                                            @endif
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" class="px-6 py-8 text-center text-gray-400 text-sm">
                                            Belum ada aktivitas sistem terekam.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <!-- Akses Cepat -->
        <div class="lg:col-span-1">
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 h-full">
                <h3 class="text-lg font-bold text-gray-800 mb-5">Akses Cepat</h3>

                <div class="space-y-3">
                    <!-- Kelola Siswa -->
                    <a href="{{ route('admin.siswa.index') }}" class="block p-4 border border-gray-100 bg-gray-50/30 rounded-xl hover:border-blue-200 hover:bg-blue-50/10 transition-all group">
                        <div class="flex items-center justify-between">
                            <div class="flex items-center space-x-4">
                                <div class="w-10 h-10 rounded-lg bg-blue-50 text-blue-600 flex items-center justify-center group-hover:bg-blue-600 group-hover:text-white transition-all duration-300">
                                    <i class="fas fa-user-plus text-sm"></i>
                                </div>
                                <span class="font-semibold text-sm text-gray-700 group-hover:text-blue-900 transition-colors">Kelola Data Siswa</span>
                            </div>
                            <i class="fas fa-chevron-right text-xs text-gray-300 group-hover:text-blue-500 transform group-hover:translate-x-1 transition-all"></i>
                        </div>
                    </a>

                    <!-- Buat Jadwal -->
                    <a href="{{ route('admin.jadwal.index') }}" class="block p-4 border border-gray-100 bg-gray-50/30 rounded-xl hover:border-blue-200 hover:bg-blue-50/10 transition-all group">
                        <div class="flex items-center justify-between">
                            <div class="flex items-center space-x-4">
                                <div class="w-10 h-10 rounded-lg bg-blue-50 text-blue-600 flex items-center justify-center group-hover:bg-blue-600 group-hover:text-white transition-all duration-300">
                                    <i class="far fa-calendar-alt text-sm"></i>
                                </div>
                                <span class="font-semibold text-sm text-gray-700 group-hover:text-blue-900 transition-colors">Buat Jadwal</span>
                            </div>
                            <i class="fas fa-chevron-right text-xs text-gray-300 group-hover:text-blue-500 transform group-hover:translate-x-1 transition-all"></i>
                        </div>
                    </a>

                    <!-- Tambahkan Pengumuman -->
                    <a href="{{ route('admin.pengumuman.index') }}" class="block p-4 border border-gray-100 bg-gray-50/30 rounded-xl hover:border-blue-200 hover:bg-blue-50/10 transition-all group">
                        <div class="flex items-center justify-between">
                            <div class="flex items-center space-x-4">
                                <div class="w-10 h-10 rounded-lg bg-blue-50 text-blue-600 flex items-center justify-center group-hover:bg-blue-600 group-hover:text-white transition-all duration-300">
                                    <i class="fas fa-bullhorn text-sm"></i>
                                </div>
                                <span class="font-semibold text-sm text-gray-700 group-hover:text-blue-900 transition-colors">Tambahkan Pengumuman</span>
                            </div>
                            <i class="fas fa-chevron-right text-xs text-gray-300 group-hover:text-blue-500 transform group-hover:translate-x-1 transition-all"></i>
                        </div>
                    </a>
                </div>
            </div>
        </div>

    </div>

@endsection