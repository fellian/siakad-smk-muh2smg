@extends('layouts.admin')

@section('title', 'Dashboard Admin')
@section('page-title', 'DASHBOARD')

@section('content')

<div class="mb-8">
    <h1 class="text-3xl font-bold text-blue-900 mb-2">Selamat Datang, Admin</h1>
    <p class="text-gray-500">Sistem Informasi Akademik SMK Muhammadiyah 2 Semarang</p>
</div>

<!-- Statistik -->
<div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
    <!-- Siswa -->
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 flex items-center space-x-6">
        <div class="w-16 h-16 rounded-full bg-blue-100 flex items-center justify-center text-blue-800">
            <i class="fas fa-user-friends text-2xl"></i>
        </div>
        <div>
            <p class="text-xs font-bold text-gray-500 uppercase tracking-wider mb-1">Total Siswa</p>
            <h2 class="text-4xl font-bold text-gray-900">{{ $totalSiswa ?? 400 }}</h2>
        </div>
    </div>

    <!-- Guru -->
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 flex items-center space-x-6">
        <div class="w-16 h-16 rounded-full bg-blue-100 flex items-center justify-center text-blue-800">
            <i class="fas fa-graduation-cap text-2xl"></i>
        </div>
        <div>
            <p class="text-xs font-bold text-gray-500 uppercase tracking-wider mb-1">Total Guru</p>
            <h2 class="text-4xl font-bold text-gray-900">{{ $totalGuru ?? 38 }}</h2>
        </div>
    </div>

    <!-- Kelas -->
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 flex items-center space-x-6">
        <div class="w-16 h-16 rounded-full bg-blue-100 flex items-center justify-center text-blue-800">
            <i class="fas fa-shapes text-2xl"></i>
        </div>
        <div>
            <p class="text-xs font-bold text-gray-500 uppercase tracking-wider mb-1">Total Kelas</p>
            <h2 class="text-4xl font-bold text-gray-900">{{ $totalKelas ?? 16 }}</h2>
        </div>
    </div>
</div>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
    
    <!-- Aktivitas Sistem Terkini -->
    <div class="lg:col-span-2">
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
            <div class="px-6 py-5 border-b border-gray-100 flex justify-between items-center">
                <h3 class="text-lg font-bold text-gray-800">Aktivitas Sistem Terkini</h3>
                <a href="#" class="text-sm font-medium text-blue-600 hover:text-blue-800">Lihat Semua</a>
            </div>
            
            <div class="overflow-x-auto">
                <table class="w-full text-left text-sm">
                    <thead class="bg-gray-50/50 text-gray-500 font-medium">
                        <tr>
                            <th class="px-6 py-4">Pengguna</th>
                            <th class="px-6 py-4">Aktivitas</th>
                            <th class="px-6 py-4">Waktu</th>
                            <th class="px-6 py-4">Status</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        <tr>
                            <td class="px-6 py-4">
                                <div class="flex items-center space-x-3">
                                    <div class="w-8 h-8 rounded-full bg-indigo-100 text-indigo-700 flex items-center justify-center font-bold text-xs">
                                        BW
                                    </div>
                                    <span class="font-medium text-gray-900">Budi Wibowo S.Pd</span>
                                </div>
                            </td>
                            <td class="px-6 py-4 text-gray-500">Menambahkan data nilai kelas X TAB 1</td>
                            <td class="px-6 py-4 text-gray-500">10 menit yang lalu</td>
                            <td class="px-6 py-4">
                                <span class="px-3 py-1 rounded-full text-xs font-medium bg-green-100 text-green-700">Sukses</span>
                            </td>
                        </tr>
                        <tr>
                            <td class="px-6 py-4">
                                <div class="flex items-center space-x-3">
                                    <div class="w-8 h-8 rounded-full bg-blue-100 text-blue-700 flex items-center justify-center font-bold text-xs">
                                        SA
                                    </div>
                                    <span class="font-medium text-gray-900">Siti Aminah S.Pd</span>
                                </div>
                            </td>
                            <td class="px-6 py-4 text-gray-500">Mengaktifkan presensi pelajaran Biologi</td>
                            <td class="px-6 py-4 text-gray-500">45 menit yang lalu</td>
                            <td class="px-6 py-4">
                                <span class="px-3 py-1 rounded-full text-xs font-medium bg-green-100 text-green-700">Sukses</span>
                            </td>
                        </tr>
                        <tr>
                            <td class="px-6 py-4">
                                <div class="flex items-center space-x-3">
                                    <div class="w-8 h-8 rounded-full bg-red-100 text-red-700 flex items-center justify-center font-bold text-xs">
                                        MR
                                    </div>
                                    <span class="font-medium text-gray-900">Muhammad Ridwan</span>
                                </div>
                            </td>
                            <td class="px-6 py-4 text-gray-500">Lihat nilai</td>
                            <td class="px-6 py-4 text-gray-500">2 jam yang lalu</td>
                            <td class="px-6 py-4">
                                <span class="px-3 py-1 rounded-full text-xs font-medium bg-red-100 text-red-700">Gagal</span>
                            </td>
                        </tr>
                        <tr>
                            <td class="px-6 py-4">
                                <div class="flex items-center space-x-3">
                                    <div class="w-8 h-8 rounded-full bg-purple-100 text-purple-700 flex items-center justify-center font-bold text-xs">
                                        HN
                                    </div>
                                    <span class="font-medium text-gray-900">Hasan Nurohman</span>
                                </div>
                            </td>
                            <td class="px-6 py-4 text-gray-500">Mengedit profil data diri</td>
                            <td class="px-6 py-4 text-gray-500">3 jam yang lalu</td>
                            <td class="px-6 py-4">
                                <span class="px-3 py-1 rounded-full text-xs font-medium bg-green-100 text-green-700">Sukses</span>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Akses Cepat -->
    <div class="lg:col-span-1">
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
            <h3 class="text-xl font-bold text-gray-800 mb-6 text-center">Akses Cepat</h3>
            
            <div class="space-y-4">
                <a href="{{ route('admin.siswa.index') }}" class="block p-4 border border-gray-200 rounded-xl hover:border-blue-300 hover:shadow-md transition-all group">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center space-x-4">
                            <div class="w-10 h-10 rounded-lg bg-blue-50 text-blue-600 flex items-center justify-center group-hover:bg-blue-600 group-hover:text-white transition-colors">
                                <i class="fas fa-user-plus"></i>
                            </div>
                            <span class="font-semibold text-gray-700">Kelola Data Siswa</span>
                        </div>
                        <i class="fas fa-chevron-right text-gray-300 group-hover:text-blue-500"></i>
                    </div>
                </a>
                
                <a href="{{ route('admin.jadwal.index') }}" class="block p-4 border border-gray-200 rounded-xl hover:border-blue-300 hover:shadow-md transition-all group">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center space-x-4">
                            <div class="w-10 h-10 rounded-lg bg-blue-50 text-blue-600 flex items-center justify-center group-hover:bg-blue-600 group-hover:text-white transition-colors">
                                <i class="far fa-calendar-alt"></i>
                            </div>
                            <span class="font-semibold text-gray-700">Buat Jadwal</span>
                        </div>
                        <i class="fas fa-chevron-right text-gray-300 group-hover:text-blue-500"></i>
                    </div>
                </a>
                
                <a href="{{ route('admin.pengumuman.index') }}" class="block p-4 border border-gray-200 rounded-xl hover:border-blue-300 hover:shadow-md transition-all group">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center space-x-4">
                            <div class="w-10 h-10 rounded-lg bg-blue-50 text-blue-600 flex items-center justify-center group-hover:bg-blue-600 group-hover:text-white transition-colors">
                                <i class="fas fa-bullhorn"></i>
                            </div>
                            <span class="font-semibold text-gray-700">Tambahkan Pengumuman</span>
                        </div>
                        <i class="fas fa-chevron-right text-gray-300 group-hover:text-blue-500"></i>
                    </div>
                </a>
            </div>
        </div>
    </div>

</div>

@endsection