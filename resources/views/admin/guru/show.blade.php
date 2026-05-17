@extends('layouts.admin')

@section('title', 'Detail Guru')
@section('page-title', 'Detail Data Guru')

@section('content')
<div class="grid grid-cols-1 lg:grid-cols-3 gap-6 max-w-7xl mx-auto">
    
    <!-- Kolom Kiri: Profil Guru -->
    <div class="lg:col-span-1">
        <!-- Card Profil -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
            <!-- Header dengan gradient -->
            <div class="bg-gradient-to-br from-blue-800 to-blue-900 h-28 relative">
                <div class="absolute bottom-0 left-0 right-0 h-12 bg-gradient-to-t from-black/10 to-transparent"></div>
            </div>
            
            <!-- Konten Profil -->
            <div class="px-6 pb-6 text-center relative">
                <!-- Foto Profil - absolute agar overlap ke header -->
                <div class="absolute -top-12 left-1/2 -translate-x-1/2">
                    @if($guru->foto)
                        <img src="{{ asset('storage/' . $guru->foto) }}" 
                             alt="Foto {{ $guru->nama_lengkap }}"
                             class="w-24 h-24 rounded-full border-4 border-white object-cover shadow-lg bg-white">
                    @else
                        <div class="w-24 h-24 rounded-full border-4 border-white bg-blue-50 flex items-center justify-center shadow-lg">
                            <svg class="w-10 h-10 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 14l9-5-9-5-9 5 9 5z"></path>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 14l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14z"></path>
                            </svg>
                        </div>
                    @endif
                </div>
                
                <!-- Identitas - padding top agar tidak tertutup foto -->
                <div class="pt-14">
                    <h3 class="text-lg font-bold text-gray-900">{{ $guru->nama_lengkap }}</h3>
                    <div class="mt-2 space-y-1">
                        @if($guru->nip)
                            <p class="text-sm text-gray-500">NIP: {{ $guru->nip }}</p>
                        @elseif($guru->nuptk)
                            <p class="text-sm text-gray-500">NUPTK: {{ $guru->nuptk }}</p>
                        @else
                            <p class="text-sm text-gray-400">NIP/NUPTK belum diisi</p>
                        @endif
                    </div>
                    
                    <div class="mt-3 flex flex-wrap justify-center gap-2">
                        <span class="px-3 py-1 rounded-full text-xs font-medium {{ $guru->status == 'aktif' ? 'bg-green-100 text-green-700 border border-green-200' : 'bg-red-100 text-red-700 border border-red-200' }}">
                            {{ ucfirst($guru->status) }}
                        </span>
                        @if($guru->kelasWali)
                            <span class="px-3 py-1 rounded-full text-xs font-medium bg-purple-100 text-purple-700 border border-purple-200">
                                Wali Kelas: {{ $guru->kelasWali->nama_kelas }}
                            </span>
                        @endif
                    </div>
                </div>

                <hr class="my-5 border-gray-100">

                <!-- Info Kontak -->
                <div class="space-y-4 text-sm text-left">
                    <div class="flex items-start gap-3">
                        <div class="w-8 h-8 rounded-lg bg-blue-50 flex items-center justify-center text-blue-600 shrink-0 mt-0.5">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                            </svg>
                        </div>
                        <div class="min-w-0">
                            <p class="text-xs text-gray-500">Email</p>
                            <p class="font-medium text-gray-900 truncate">{{ $guru->email ?? '-' }}</p>
                        </div>
                    </div>
                    
                    <div class="flex items-start gap-3">
                        <div class="w-8 h-8 rounded-lg bg-green-50 flex items-center justify-center text-green-600 shrink-0 mt-0.5">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path>
                            </svg>
                        </div>
                        <div class="min-w-0">
                            <p class="text-xs text-gray-500">No HP</p>
                            <p class="font-medium text-gray-900">{{ $guru->no_hp ?? '-' }}</p>
                        </div>
                    </div>

                    <div class="flex items-start gap-3">
                        <div class="w-8 h-8 rounded-lg bg-purple-50 flex items-center justify-center text-purple-600 shrink-0 mt-0.5">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                            </svg>
                        </div>
                        <div>
                            <p class="text-xs text-gray-500">Jenis Kelamin</p>
                            <p class="font-medium text-gray-900">{{ $guru->jenis_kelamin == 'L' ? 'Laki-laki' : 'Perempuan' }}</p>
                        </div>
                    </div>

                    <div class="flex items-start gap-3">
                        <div class="w-8 h-8 rounded-lg bg-yellow-50 flex items-center justify-center text-yellow-600 shrink-0 mt-0.5">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                            </svg>
                        </div>
                        <div>
                            <p class="text-xs text-gray-500">Tempat, Tanggal Lahir</p>
                            <p class="font-medium text-gray-900">
                                @if($guru->tempat_lahir && $guru->tanggal_lahir)
                                    {{ $guru->tempat_lahir }}, {{ $guru->tanggal_lahir->format('d F Y') }}
                                @else
                                    -
                                @endif
                            </p>
                        </div>
                    </div>

                    <div class="flex items-start gap-3">
                        <div class="w-8 h-8 rounded-lg bg-red-50 flex items-center justify-center text-red-600 shrink-0 mt-0.5">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                            </svg>
                        </div>
                        <div class="min-w-0 flex-1">
                            <p class="text-xs text-gray-500">Alamat</p>
                            <p class="font-medium text-gray-900">{{ $guru->alamat ?? '-' }}</p>
                        </div>
                    </div>
                </div>

                <hr class="my-5 border-gray-100">

                <!-- Pendidikan -->
                <div class="space-y-4 text-sm text-left">
                    <h4 class="font-semibold text-gray-900 text-sm mb-3">Riwayat Pendidikan</h4>
                    <div class="flex items-start gap-3">
                        <div class="w-8 h-8 rounded-lg bg-indigo-50 flex items-center justify-center text-indigo-600 shrink-0 mt-0.5">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l9-5-9-5-9 5 9 5z"></path>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14z"></path>
                            </svg>
                        </div>
                        <div class="min-w-0">
                            <p class="text-xs text-gray-500">Pendidikan Terakhir</p>
                            <p class="font-medium text-gray-900">{{ $guru->pendidikan_terakhir ?? '-' }}</p>
                        </div>
                    </div>
                    <div class="flex items-start gap-3">
                        <div class="w-8 h-8 rounded-lg bg-pink-50 flex items-center justify-center text-pink-600 shrink-0 mt-0.5">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                            </svg>
                        </div>
                        <div class="min-w-0">
                            <p class="text-xs text-gray-500">Jurusan Pendidikan</p>
                            <p class="font-medium text-gray-900">{{ $guru->jurusan_pendidikan ?? '-' }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Tombol Aksi -->
        <div class="mt-4 flex gap-3">
            <a href="{{ route('admin.guru.edit', $guru) }}" class="flex-1 bg-blue-600 hover:bg-blue-700 text-white text-center px-4 py-2.5 rounded-lg text-sm font-medium transition-colors inline-flex items-center justify-center">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                </svg>
                Edit
            </a>
            <form action="{{ route('admin.guru.destroy', $guru) }}" method="POST" class="flex-1" onsubmit="return confirm('Yakin hapus guru ini?')">
                @csrf @method('DELETE')
                <button type="submit" class="w-full bg-red-600 hover:bg-red-700 text-white px-4 py-2.5 rounded-lg text-sm font-medium transition-colors inline-flex items-center justify-center">
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
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-4">
                <div class="flex items-center">
                    <div class="p-2.5 rounded-xl bg-blue-50 text-blue-600">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                        </svg>
                    </div>
                    <div class="ml-3">
                        <p class="text-gray-500 text-xs">Jadwal Mengajar</p>
                        <p class="text-xl font-bold text-gray-900">{{ $guru->jadwals->count() }}</p>
                    </div>
                </div>
            </div>
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-4">
                <div class="flex items-center">
                    <div class="p-2.5 rounded-xl bg-green-50 text-green-600">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                        </svg>
                    </div>
                    <div class="ml-3">
                        <p class="text-gray-500 text-xs">Mata Pelajaran</p>
                        <p class="text-xl font-bold text-gray-900">{{ $guru->mataPelajarans->count() }}</p>
                    </div>
                </div>
            </div>
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-4">
                <div class="flex items-center">
                    <div class="p-2.5 rounded-xl bg-purple-50 text-purple-600">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                        </svg>
                    </div>
                    <div class="ml-3">
                        <p class="text-gray-500 text-xs">Kelas Diampu</p>
                        <p class="text-xl font-bold text-gray-900">{{ $guru->jadwals->pluck('kelas_id')->unique()->count() }}</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Jadwal Mengajar -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-200">
            <div class="px-6 py-4 border-b border-gray-100">
                <h3 class="text-base font-semibold text-gray-900 flex items-center">
                    <svg class="w-5 h-5 mr-2 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                    </svg>
                    Jadwal Mengajar
                </h3>
            </div>
            <div class="p-6">
                @if($guru->jadwals->count() > 0)
                <div class="overflow-x-auto">
                    <table class="w-full text-sm">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-4 py-3 text-left font-medium text-gray-600 text-xs uppercase tracking-wider">Hari</th>
                                <th class="px-4 py-3 text-left font-medium text-gray-600 text-xs uppercase tracking-wider">Jam</th>
                                <th class="px-4 py-3 text-left font-medium text-gray-600 text-xs uppercase tracking-wider">Mata Pelajaran</th>
                                <th class="px-4 py-3 text-left font-medium text-gray-600 text-xs uppercase tracking-wider">Kelas</th>
                                <th class="px-4 py-3 text-left font-medium text-gray-600 text-xs uppercase tracking-wider">Ruangan</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                            @foreach($guru->jadwals->sortBy(['hari', 'jam_mulai']) as $jadwal)
                            @php
                                $hariOrder = ['Senin' => 1, 'Selasa' => 2, 'Rabu' => 3, 'Kamis' => 4, 'Jumat' => 5, 'Sabtu' => 6];
                            @endphp
                            <tr class="hover:bg-gray-50 transition-colors">
                                <td class="px-4 py-3 font-medium text-gray-900">{{ $jadwal->hari }}</td>
                                <td class="px-4 py-3 text-gray-600">{{ \Carbon\Carbon::parse($jadwal->jam_mulai)->format('H:i') }} - {{ \Carbon\Carbon::parse($jadwal->jam_selesai)->format('H:i') }}</td>
                                <td class="px-4 py-3 text-gray-900">{{ $jadwal->mataPelajaran->nama_mapel }}</td>
                                <td class="px-4 py-3">
                                    <span class="px-2 py-1 bg-blue-50 text-blue-700 rounded-md text-xs font-medium border border-blue-100">{{ $jadwal->kelas->nama_kelas }}</span>
                                </td>
                                <td class="px-4 py-3 text-gray-500">{{ $jadwal->ruangan ?? '-' }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                @else
                <div class="text-center py-10 text-gray-400">
                    <svg class="w-12 h-12 mx-auto mb-3 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                    </svg>
                    <p class="text-sm">Belum ada jadwal mengajar</p>
                </div>
                @endif
            </div>
        </div>

        <!-- Mata Pelajaran yang Diampu -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-200">
            <div class="px-6 py-4 border-b border-gray-100">
                <h3 class="text-base font-semibold text-gray-900 flex items-center">
                    <svg class="w-5 h-5 mr-2 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                    </svg>
                    Mata Pelajaran yang Diampu
                </h3>
            </div>
            <div class="p-6">
                @if($guru->mataPelajarans->count() > 0)
                <div class="flex flex-wrap gap-2">
                    @foreach($guru->mataPelajarans as $mapel)
                    <span class="px-3 py-2 bg-green-50 text-green-700 rounded-lg text-sm font-medium border border-green-100">
                        {{ $mapel->kode_mapel }} - {{ $mapel->nama_mapel }}
                        @if($mapel->jurusan)
                            <span class="text-xs text-green-600 ml-1">({{ $mapel->jurusan->kode_jurusan }})</span>
                        @endif
                    </span>
                    @endforeach
                </div>
                @else
                <div class="text-center py-10 text-gray-400">
                    <svg class="w-12 h-12 mx-auto mb-3 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                    </svg>
                    <p class="text-sm">Belum ada mata pelajaran yang diampu</p>
                </div>
                @endif
            </div>
        </div>

        <!-- Info Akun -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-200">
            <div class="px-6 py-4 border-b border-gray-100">
                <h3 class="text-base font-semibold text-gray-900 flex items-center">
                    <svg class="w-5 h-5 mr-2 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path>
                    </svg>
                    Informasi Akun
                </h3>
            </div>
            <div class="p-6">
                <div class="grid grid-cols-2 gap-4 text-sm">
                    <div class="bg-gray-50 rounded-lg p-3">
                        <p class="text-xs text-gray-500 mb-1">Username/Email Login</p>
                        <p class="font-semibold text-gray-900 truncate">{{ $guru->user->email }}</p>
                    </div>
                    <div class="bg-gray-50 rounded-lg p-3">
                        <p class="text-xs text-gray-500 mb-1">Role</p>
                        <p class="font-semibold text-gray-900 capitalize">{{ $guru->user->role }}</p>
                    </div>
                    <div class="bg-gray-50 rounded-lg p-3">
                        <p class="text-xs text-gray-500 mb-1">Akun Dibuat</p>
                        <p class="font-semibold text-gray-900">{{ $guru->user->created_at->format('d F Y H:i') }}</p>
                    </div>
                    <div class="bg-gray-50 rounded-lg p-3">
                        <p class="text-xs text-gray-500 mb-1">Terakhir Update</p>
                        <p class="font-semibold text-gray-900">{{ $guru->user->updated_at->format('d F Y H:i') }}</p>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>
@endsection