@extends('layouts.admin')

@section('title', 'Detail Siswa')
@section('page-title', 'Detail Data Siswa')

@section('content')
<div class="grid grid-cols-1 lg:grid-cols-3 gap-6 max-w-7xl mx-auto">
    
    <!-- Kolom Kiri: Profil Siswa -->
    <div class="lg:col-span-1">
        <!-- Card Profil -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
            <!-- Header dengan gradient -->
            <div class="bg-gradient-to-br from-green-600 to-green-700 h-28 relative">
                <div class="absolute bottom-0 left-0 right-0 h-12 bg-gradient-to-t from-black/10 to-transparent"></div>
            </div>
            
            <!-- Konten Profil -->
            <div class="px-6 pb-6 text-center relative">
                <!-- Foto Profil - absolute agar overlap ke header -->
                <div class="absolute -top-12 left-1/2 -translate-x-1/2">
                    @if($siswa->foto)
                        <img src="{{ asset('storage/' . $siswa->foto) }}" 
                             alt="Foto {{ $siswa->nama_lengkap }}"
                             class="w-24 h-24 rounded-full border-4 border-white object-cover shadow-lg bg-white">
                    @else
                        <div class="w-24 h-24 rounded-full border-4 border-white bg-gray-100 flex items-center justify-center shadow-lg">
                            <svg class="w-10 h-10 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                            </svg>
                        </div>
                    @endif
                </div>
                
                <!-- Identitas - padding top agar tidak tertutup foto -->
                <div class="pt-14">
                    <h3 class="text-lg font-bold text-gray-900">{{ $siswa->nama_lengkap }}</h3>
                    <div class="mt-2 space-y-1">
                        <p class="text-sm text-gray-500">NIS: {{ $siswa->nis }}</p>
                        @if($siswa->nisn)
                            <p class="text-sm text-gray-500">NISN: {{ $siswa->nisn }}</p>
                        @endif
                    </div>
                    
                    <div class="mt-3 flex flex-wrap justify-center gap-2">
                        <span class="px-3 py-1 rounded-full text-xs font-medium {{ $siswa->status == 'aktif' ? 'bg-green-100 text-green-700 border border-green-200' : ($siswa->status == 'pindah' ? 'bg-yellow-100 text-yellow-700 border border-yellow-200' : 'bg-red-100 text-red-700 border border-red-200') }}">
                            {{ ucfirst($siswa->status) }}
                        </span>
                        @if($siswa->kelas)
                            <span class="px-3 py-1 rounded-full text-xs font-medium bg-blue-100 text-blue-700 border border-blue-200">
                                {{ $siswa->kelas->nama_kelas }}
                            </span>
                        @endif
                    </div>
                </div>

                <hr class="my-5 border-gray-100">

                <!-- Info Kontak -->
                <div class="space-y-3 text-sm text-left">
                    <div class="flex items-center p-2 rounded-lg hover:bg-gray-50 transition-colors">
                        <div class="w-8 h-8 rounded-lg bg-blue-100 flex items-center justify-center text-blue-600 mr-3 shrink-0">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                            </svg>
                        </div>
                        <div class="min-w-0">
                            <p class="text-gray-500 text-xs">Email</p>
                            <p class="font-medium text-gray-900 truncate">{{ $siswa->email ?? '-' }}</p>
                        </div>
                    </div>
                    
                    <div class="flex items-center p-2 rounded-lg hover:bg-gray-50 transition-colors">
                        <div class="w-8 h-8 rounded-lg bg-green-100 flex items-center justify-center text-green-600 mr-3 shrink-0">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path>
                            </svg>
                        </div>
                        <div class="min-w-0">
                            <p class="text-gray-500 text-xs">No HP</p>
                            <p class="font-medium text-gray-900">{{ $siswa->no_hp ?? '-' }}</p>
                        </div>
                    </div>

                    <div class="flex items-center p-2 rounded-lg hover:bg-gray-50 transition-colors">
                        <div class="w-8 h-8 rounded-lg bg-purple-100 flex items-center justify-center text-purple-600 mr-3 shrink-0">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                            </svg>
                        </div>
                        <div>
                            <p class="text-gray-500 text-xs">Jenis Kelamin</p>
                            <p class="font-medium text-gray-900">{{ $siswa->jenis_kelamin == 'L' ? 'Laki-laki' : 'Perempuan' }}</p>
                        </div>
                    </div>

                    <div class="flex items-center p-2 rounded-lg hover:bg-gray-50 transition-colors">
                        <div class="w-8 h-8 rounded-lg bg-yellow-100 flex items-center justify-center text-yellow-600 mr-3 shrink-0">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                            </svg>
                        </div>
                        <div class="min-w-0">
                            <p class="text-gray-500 text-xs">Tempat, Tanggal Lahir</p>
                            <p class="font-medium text-gray-900">
                                @if($siswa->tempat_lahir && $siswa->tanggal_lahir)
                                    {{ $siswa->tempat_lahir }}, {{ $siswa->tanggal_lahir->format('d F Y') }}
                                @else
                                    -
                                @endif
                            </p>
                        </div>
                    </div>

                    <div class="flex items-start p-2 rounded-lg hover:bg-gray-50 transition-colors">
                        <div class="w-8 h-8 rounded-lg bg-red-100 flex items-center justify-center text-red-600 mr-3 mt-0.5 shrink-0">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                            </svg>
                        </div>
                        <div class="min-w-0">
                            <p class="text-gray-500 text-xs">Alamat</p>
                            <p class="font-medium text-gray-900">{{ $siswa->alamat ?? '-' }}</p>
                        </div>
                    </div>
                </div>

                <hr class="my-5 border-gray-100">

                <!-- Info Orang Tua -->
                <div class="space-y-3 text-sm text-left">
                    <h4 class="font-semibold text-gray-900 mb-3 flex items-center">
                        <svg class="w-4 h-4 mr-2 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                        </svg>
                        Data Orang Tua/Wali
                    </h4>
                    <div class="flex items-center p-2 rounded-lg hover:bg-gray-50 transition-colors">
                        <div class="w-8 h-8 rounded-lg bg-indigo-100 flex items-center justify-center text-indigo-600 mr-3 shrink-0">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                            </svg>
                        </div>
                        <div class="min-w-0">
                            <p class="text-gray-500 text-xs">Nama Orang Tua</p>
                            <p class="font-medium text-gray-900 truncate">{{ $siswa->nama_ortu ?? '-' }}</p>
                        </div>
                    </div>
                    <div class="flex items-center p-2 rounded-lg hover:bg-gray-50 transition-colors">
                        <div class="w-8 h-8 rounded-lg bg-pink-100 flex items-center justify-center text-pink-600 mr-3 shrink-0">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path>
                            </svg>
                        </div>
                        <div class="min-w-0">
                            <p class="text-gray-500 text-xs">No HP Orang Tua</p>
                            <p class="font-medium text-gray-900">{{ $siswa->no_hp_ortu ?? '-' }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Tombol Aksi -->
        <div class="mt-4 flex gap-3">
            <a href="{{ route('admin.siswa.edit', $siswa) }}" class="flex-1 inline-flex items-center justify-center bg-blue-600 text-white px-4 py-2.5 rounded-lg hover:bg-blue-700 transition-colors text-sm font-medium shadow-sm">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                </svg>
                Edit
            </a>
            <form action="{{ route('admin.siswa.destroy', $siswa) }}" method="POST" class="flex-1" onsubmit="return confirm('Yakin hapus siswa ini?')">
                @csrf @method('DELETE')
                <button type="submit" class="w-full inline-flex items-center justify-center bg-red-600 text-white px-4 py-2.5 rounded-lg hover:bg-red-700 transition-colors text-sm font-medium shadow-sm">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                    </svg>
                    Hapus
                </button>
            </form>
        </div>
    </div>

    <!-- Kolom Kanan: Informasi Akademik -->
    <div class="lg:col-span-2 space-y-6">
        
        <!-- Statistik -->
        <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-4 hover:shadow-md transition-shadow">
                <div class="flex items-center">
                    <div class="p-2.5 rounded-xl bg-blue-100 text-blue-600">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                        </svg>
                    </div>
                    <div class="ml-3">
                        <p class="text-gray-500 text-xs">Jumlah Mapel</p>
                        <p class="text-xl font-bold text-gray-900">{{ $siswa->nilais->pluck('mata_pelajaran_id')->unique()->count() }}</p>
                    </div>
                </div>
            </div>
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-4 hover:shadow-md transition-shadow">
                <div class="flex items-center">
                    <div class="p-2.5 rounded-xl bg-green-100 text-green-600">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                        </svg>
                    </div>
                    <div class="ml-3">
                        <p class="text-gray-500 text-xs">Rata-rata Nilai</p>
                        <p class="text-xl font-bold text-gray-900">{{ $siswa->nilais->avg('nilai_akhir') ? number_format($siswa->nilais->avg('nilai_akhir'), 2) : '-' }}</p>
                    </div>
                </div>
            </div>
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-4 hover:shadow-md transition-shadow">
                <div class="flex items-center">
                    <div class="p-2.5 rounded-xl bg-yellow-100 text-yellow-600">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"></path>
                        </svg>
                    </div>
                    <div class="ml-3">
                        <p class="text-gray-500 text-xs">Kehadiran</p>
                        <p class="text-xl font-bold text-gray-900">
                            @php
                                $totalAbsensi = $siswa->absensis->count();
                                $bukanAlfa = $siswa->absensis->where('status', '!=', 'alfa')->count();
                                echo $totalAbsensi > 0 ? round(($bukanAlfa / max(1, $totalAbsensi)) * 100) . '%' : '-';
                            @endphp
                        </p>
                    </div>
                </div>
            </div>
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-4 hover:shadow-md transition-shadow">
                <div class="flex items-center">
                    <div class="p-2.5 rounded-xl bg-purple-100 text-purple-600">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                        </svg>
                    </div>
                    <div class="ml-3">
                        <p class="text-gray-500 text-xs">Tanggal Masuk</p>
                        <p class="text-sm font-bold text-gray-900">{{ $siswa->tanggal_masuk->format('d/m/Y') }}</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Info Kelas -->
        @if($siswa->kelas)
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-100 bg-gray-50/50">
                <h3 class="text-base font-semibold text-gray-900 flex items-center">
                    <svg class="w-5 h-5 mr-2 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                    </svg>
                    Informasi Kelas
                </h3>
            </div>
            <div class="p-6">
                <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                    <div class="bg-gray-50 rounded-lg p-3">
                        <p class="text-gray-500 text-xs mb-1">Kelas</p>
                        <p class="font-semibold text-gray-900">{{ $siswa->kelas->nama_kelas }}</p>
                    </div>
                    <div class="bg-gray-50 rounded-lg p-3">
                        <p class="text-gray-500 text-xs mb-1">Jurusan</p>
                        <p class="font-semibold text-gray-900">{{ $siswa->kelas->jurusan->nama_jurusan }}</p>
                    </div>
                    <div class="bg-gray-50 rounded-lg p-3">
                        <p class="text-gray-500 text-xs mb-1">Tingkat</p>
                        <p class="font-semibold text-gray-900">Kelas {{ $siswa->kelas->tingkat }}</p>
                    </div>
                    <div class="bg-gray-50 rounded-lg p-3">
                        <p class="text-gray-500 text-xs mb-1">Wali Kelas</p>
                        <p class="font-semibold text-gray-900">{{ $siswa->kelas->waliKelas?->nama_lengkap ?? '-' }}</p>
                    </div>
                </div>
            </div>
        </div>
        @endif

        <!-- Nilai Akademik -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-100 bg-gray-50/50 flex items-center justify-between">
                <h3 class="text-base font-semibold text-gray-900 flex items-center">
                    <svg class="w-5 h-5 mr-2 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                    </svg>
                    Nilai Akademik
                </h3>
                <span class="text-xs text-gray-500 bg-gray-100 px-2 py-1 rounded-md">Semester {{ $siswa->nilais->first()?->semester ?? '-' }} - {{ $siswa->nilais->first()?->tahunAjaran?->tahun ?? '' }}</span>
            </div>
            <div class="p-6">
                @if($siswa->nilais->count() > 0)
                <div class="overflow-x-auto">
                    <table class="w-full text-sm">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-4 py-3 text-left font-medium text-gray-600 text-xs uppercase tracking-wider">No</th>
                                <th class="px-4 py-3 text-left font-medium text-gray-600 text-xs uppercase tracking-wider">Mata Pelajaran</th>
                                <th class="px-4 py-3 text-center font-medium text-gray-600 text-xs uppercase tracking-wider">Tugas</th>
                                <th class="px-4 py-3 text-center font-medium text-gray-600 text-xs uppercase tracking-wider">Ulangan</th>
                                <th class="px-4 py-3 text-center font-medium text-gray-600 text-xs uppercase tracking-wider">UTS</th>
                                <th class="px-4 py-3 text-center font-medium text-gray-600 text-xs uppercase tracking-wider">UAS</th>
                                <th class="px-4 py-3 text-center font-medium text-gray-600 text-xs uppercase tracking-wider">Akhir</th>
                                <th class="px-4 py-3 text-center font-medium text-gray-600 text-xs uppercase tracking-wider">Predikat</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                            @foreach($siswa->nilais as $i => $nilai)
                            <tr class="hover:bg-gray-50 transition-colors">
                                <td class="px-4 py-3 text-gray-500">{{ $i + 1 }}</td>
                                <td class="px-4 py-3 font-medium text-gray-900">{{ $nilai->mataPelajaran->nama_mapel }}</td>
                                <td class="px-4 py-3 text-center text-gray-600">{{ $nilai->nilai_tugas }}</td>
                                <td class="px-4 py-3 text-center text-gray-600">{{ $nilai->nilai_ulangan }}</td>
                                <td class="px-4 py-3 text-center text-gray-600">{{ $nilai->nilai_uts }}</td>
                                <td class="px-4 py-3 text-center text-gray-600">{{ $nilai->nilai_uas }}</td>
                                <td class="px-4 py-3 text-center font-bold {{ $nilai->nilai_akhir >= 75 ? 'text-green-600' : 'text-red-600' }}">
                                    {{ number_format($nilai->nilai_akhir, 2) }}
                                </td>
                                <td class="px-4 py-3 text-center">
                                    <span class="px-2 py-1 rounded-md text-xs font-bold {{ $nilai->predikat == 'A' ? 'bg-green-100 text-green-700' : ($nilai->predikat == 'B' ? 'bg-blue-100 text-blue-700' : ($nilai->predikat == 'C' ? 'bg-yellow-100 text-yellow-700' : 'bg-red-100 text-red-700')) }}">
                                        {{ $nilai->predikat }}
                                    </span>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                @else
                <div class="text-center py-10 text-gray-400">
                    <svg class="w-12 h-12 mx-auto mb-3 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                    </svg>
                    <p class="text-sm">Belum ada data nilai</p>
                </div>
                @endif
            </div>
        </div>

        <!-- Riwayat Absensi -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-100 bg-gray-50/50">
                <h3 class="text-base font-semibold text-gray-900 flex items-center">
                    <svg class="w-5 h-5 mr-2 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"></path>
                    </svg>
                    Riwayat Kehadiran
                </h3>
            </div>
            <div class="p-6">
                @if($siswa->absensis->count() > 0)
                @php
                    $statusCounts = [
                        'hadir' => $siswa->absensis->where('status', 'hadir')->count(),
                        'terlambat' => $siswa->absensis->where('status', 'terlambat')->count(),
                        'izin' => $siswa->absensis->where('status', 'izin')->count(),
                        'sakit' => $siswa->absensis->where('status', 'sakit')->count(),
                        'alfa' => $siswa->absensis->where('status', 'alfa')->count(),
                    ];
                @endphp
                
                <!-- Ringkasan Absensi -->
                <div class="grid grid-cols-2 md:grid-cols-5 gap-3 mb-6">
                    <div class="text-center p-3 bg-green-50 rounded-xl border border-green-100">
                        <p class="text-xl font-bold text-green-600">{{ $statusCounts['hadir'] }}</p>
                        <p class="text-xs text-green-700 font-medium">Hadir</p>
                    </div>
                    <div class="text-center p-3 bg-amber-50 rounded-xl border border-amber-100">
                        <p class="text-xl font-bold text-amber-700">{{ $statusCounts['terlambat'] }}</p>
                        <p class="text-xs text-amber-800 font-medium">Terlambat</p>
                    </div>
                    <div class="text-center p-3 bg-yellow-50 rounded-xl border border-yellow-100">
                        <p class="text-xl font-bold text-yellow-600">{{ $statusCounts['izin'] }}</p>
                        <p class="text-xs text-yellow-700 font-medium">Izin</p>
                    </div>
                    <div class="text-center p-3 bg-blue-50 rounded-xl border border-blue-100">
                        <p class="text-xl font-bold text-blue-600">{{ $statusCounts['sakit'] }}</p>
                        <p class="text-xs text-blue-700 font-medium">Sakit</p>
                    </div>
                    <div class="text-center p-3 bg-red-50 rounded-xl border border-red-100 col-span-2 md:col-span-1">
                        <p class="text-xl font-bold text-red-600">{{ $statusCounts['alfa'] }}</p>
                        <p class="text-xs text-red-700 font-medium">Alfa</p>
                    </div>
                </div>

                <!-- Detail Absensi -->
                <div class="overflow-x-auto">
                    <table class="w-full text-sm">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-4 py-3 text-left font-medium text-gray-600 text-xs uppercase tracking-wider">Tanggal</th>
                                <th class="px-4 py-3 text-left font-medium text-gray-600 text-xs uppercase tracking-wider">Waktu</th>
                                <th class="px-4 py-3 text-left font-medium text-gray-600 text-xs uppercase tracking-wider">Mata Pelajaran</th>
                                <th class="px-4 py-3 text-center font-medium text-gray-600 text-xs uppercase tracking-wider">Status</th>
                                <th class="px-4 py-3 text-left font-medium text-gray-600 text-xs uppercase tracking-wider">Keterangan</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                            @foreach($siswa->absensis->sortByDesc('tanggal')->take(10) as $absensi)
                            <tr class="hover:bg-gray-50 transition-colors">
                                <td class="px-4 py-3 text-gray-900">{{ $absensi->tanggal->format('d F Y') }}</td>
                                <td class="px-4 py-3 text-gray-500 text-xs">{{ $absensi->waktu_presensi?->format('H:i d/m/Y') ?? '—' }}</td>
                                <td class="px-4 py-3 text-gray-900">{{ $absensi->jadwal->mataPelajaran->nama_mapel }}</td>
                                <td class="px-4 py-3 text-center">
                                    @php
                                        $badgeAdmin = match ($absensi->status) {
                                            'hadir' => 'bg-green-100 text-green-700 border border-green-200',
                                            'terlambat' => 'bg-amber-100 text-amber-800 border border-amber-200',
                                            'izin' => 'bg-yellow-100 text-yellow-700 border border-yellow-200',
                                            'sakit' => 'bg-blue-100 text-blue-700 border border-blue-200',
                                            'alfa' => 'bg-red-100 text-red-700 border border-red-200',
                                            default => 'bg-gray-100 text-gray-700 border border-gray-200',
                                        };
                                    @endphp
                                    <span class="px-2 py-1 rounded-md text-xs font-medium {{ $badgeAdmin }}">
                                        {{ ucfirst($absensi->status) }}
                                    </span>
                                </td>
                                <td class="px-4 py-3 text-gray-500 text-xs">{{ $absensi->keterangan ?? '-' }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                @if($siswa->absensis->count() > 10)
                <p class="text-center text-xs text-gray-400 mt-4">Menampilkan 10 dari {{ $siswa->absensis->count() }} data absensi</p>
                @endif
                @else
                <div class="text-center py-10 text-gray-400">
                    <svg class="w-12 h-12 mx-auto mb-3 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"></path>
                    </svg>
                    <p class="text-sm">Belum ada data absensi</p>
                </div>
                @endif
            </div>
        </div>

        <!-- Info Akun -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-100 bg-gray-50/50">
                <h3 class="text-base font-semibold text-gray-900 flex items-center">
                    <svg class="w-5 h-5 mr-2 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path>
                    </svg>
                    Informasi Akun
                </h3>
            </div>
            <div class="p-6">
                <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                    <div class="bg-gray-50 rounded-lg p-3">
                        <p class="text-gray-500 text-xs mb-1">Email Login</p>
                        <p class="font-semibold text-gray-900 text-sm truncate">{{ $siswa->user->email }}</p>
                    </div>
                    <div class="bg-gray-50 rounded-lg p-3">
                        <p class="text-gray-500 text-xs mb-1">Role</p>
                        <p class="font-semibold text-gray-900 text-sm capitalize">{{ $siswa->user->role }}</p>
                    </div>
                    <div class="bg-gray-50 rounded-lg p-3">
                        <p class="text-gray-500 text-xs mb-1">Akun Dibuat</p>
                        <p class="font-semibold text-gray-900 text-sm">{{ $siswa->user->created_at->format('d F Y') }}</p>
                    </div>
                    <div class="bg-gray-50 rounded-lg p-3">
                        <p class="text-gray-500 text-xs mb-1">Terakhir Update</p>
                        <p class="font-semibold text-gray-900 text-sm">{{ $siswa->user->updated_at->format('d F Y') }}</p>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>
@endsection