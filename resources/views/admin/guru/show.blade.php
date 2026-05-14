@extends('layouts.admin')

@section('title', 'Detail Guru')
@section('page-title', 'Detail Data Guru')

@section('content')
<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
    
    <!-- Kolom Kiri: Profil Guru -->
    <div class="lg:col-span-1">
        <!-- Card Profil -->
        <div class="bg-white rounded-lg shadow overflow-hidden">
            <div class="bg-gradient-to-r from-blue-600 to-blue-800 h-32"></div>
            <div class="px-6 pb-6 relative">
                <!-- Foto -->
                <div class="absolute -top-16 left-1/2 transform -translate-x-1/2">
                    @if($guru->foto)
                        <img src="{{ asset('storage/' . $guru->foto) }}" 
                             class="w-32 h-32 rounded-full border-4 border-white object-cover shadow-lg">
                    @else
                        <div class="w-32 h-32 rounded-full border-4 border-white bg-gray-300 flex items-center justify-center text-gray-600 text-4xl shadow-lg">
                            <i class="fas fa-user"></i>
                        </div>
                    @endif
                </div>
                
                <div class="mt-20 text-center">
                    <h3 class="text-xl font-bold text-gray-800">{{ $guru->nama_lengkap }}</h3>
                    <p class="text-gray-500 text-sm mt-1">
                        @if($guru->nip)
                            NIP: {{ $guru->nip }}
                        @elseif($guru->nuptk)
                            NUPTK: {{ $guru->nuptk }}
                        @else
                            <span class="text-gray-400">NIP/NUPTK belum diisi</span>
                        @endif
                    </p>
                    
                    <div class="mt-3">
                        <span class="px-3 py-1 rounded-full text-sm font-medium {{ $guru->status == 'aktif' ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700' }}">
                            {{ ucfirst($guru->status) }}
                        </span>
                    </div>

                    @if($guru->kelasWali)
                    <div class="mt-2">
                        <span class="px-3 py-1 rounded-full text-sm font-medium bg-purple-100 text-purple-700">
                            <i class="fas fa-chalkboard-teacher mr-1"></i> Wali Kelas: {{ $guru->kelasWali->nama_kelas }}
                        </span>
                    </div>
                    @endif
                </div>

                <hr class="my-4">

                <!-- Info Kontak -->
                <div class="space-y-3 text-sm">
                    <div class="flex items-center">
                        <div class="w-8 h-8 rounded-full bg-blue-100 flex items-center justify-center text-blue-600 mr-3">
                            <i class="fas fa-envelope"></i>
                        </div>
                        <div>
                            <p class="text-gray-500 text-xs">Email</p>
                            <p class="font-medium">{{ $guru->email ?? '-' }}</p>
                        </div>
                    </div>
                    
                    <div class="flex items-center">
                        <div class="w-8 h-8 rounded-full bg-green-100 flex items-center justify-center text-green-600 mr-3">
                            <i class="fas fa-phone"></i>
                        </div>
                        <div>
                            <p class="text-gray-500 text-xs">No HP</p>
                            <p class="font-medium">{{ $guru->no_hp ?? '-' }}</p>
                        </div>
                    </div>

                    <div class="flex items-center">
                        <div class="w-8 h-8 rounded-full bg-purple-100 flex items-center justify-center text-purple-600 mr-3">
                            <i class="fas fa-venus-mars"></i>
                        </div>
                        <div>
                            <p class="text-gray-500 text-xs">Jenis Kelamin</p>
                            <p class="font-medium">{{ $guru->jenis_kelamin == 'L' ? 'Laki-laki' : 'Perempuan' }}</p>
                        </div>
                    </div>

                    <div class="flex items-center">
                        <div class="w-8 h-8 rounded-full bg-yellow-100 flex items-center justify-center text-yellow-600 mr-3">
                            <i class="fas fa-birthday-cake"></i>
                        </div>
                        <div>
                            <p class="text-gray-500 text-xs">Tempat, Tanggal Lahir</p>
                            <p class="font-medium">
                                @if($guru->tempat_lahir && $guru->tanggal_lahir)
                                    {{ $guru->tempat_lahir }}, {{ $guru->tanggal_lahir->format('d F Y') }}
                                @else
                                    -
                                @endif
                            </p>
                        </div>
                    </div>

                    <div class="flex items-start">
                        <div class="w-8 h-8 rounded-full bg-red-100 flex items-center justify-center text-red-600 mr-3 mt-1">
                            <i class="fas fa-map-marker-alt"></i>
                        </div>
                        <div>
                            <p class="text-gray-500 text-xs">Alamat</p>
                            <p class="font-medium">{{ $guru->alamat ?? '-' }}</p>
                        </div>
                    </div>
                </div>

                <hr class="my-4">

                <!-- Pendidikan -->
                <div class="space-y-3 text-sm">
                    <h4 class="font-semibold text-gray-700">Riwayat Pendidikan</h4>
                    <div class="flex items-center">
                        <div class="w-8 h-8 rounded-full bg-indigo-100 flex items-center justify-center text-indigo-600 mr-3">
                            <i class="fas fa-graduation-cap"></i>
                        </div>
                        <div>
                            <p class="text-gray-500 text-xs">Pendidikan Terakhir</p>
                            <p class="font-medium">{{ $guru->pendidikan_terakhir ?? '-' }}</p>
                        </div>
                    </div>
                    <div class="flex items-center">
                        <div class="w-8 h-8 rounded-full bg-pink-100 flex items-center justify-center text-pink-600 mr-3">
                            <i class="fas fa-book"></i>
                        </div>
                        <div>
                            <p class="text-gray-500 text-xs">Jurusan Pendidikan</p>
                            <p class="font-medium">{{ $guru->jurusan_pendidikan ?? '-' }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Tombol Aksi -->
        <div class="mt-4 flex gap-3">
            <a href="{{ route('admin.guru.edit', $guru) }}" class="flex-1 bg-blue-600 text-white text-center px-4 py-2 rounded-lg hover:bg-blue-700">
                <i class="fas fa-edit mr-2"></i>Edit
            </a>
            <form action="{{ route('admin.guru.destroy', $guru) }}" method="POST" class="flex-1" onsubmit="return confirm('Yakin hapus guru ini?')">
                @csrf @method('DELETE')
                <button type="submit" class="w-full bg-red-600 text-white px-4 py-2 rounded-lg hover:bg-red-700">
                    <i class="fas fa-trash mr-2"></i>Hapus
                </button>
            </form>
        </div>
    </div>

    <!-- Kolom Kanan: Informasi Akademik -->
    <div class="lg:col-span-2 space-y-6">
        
        <!-- Statistik -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            <div class="bg-white rounded-lg shadow p-4">
                <div class="flex items-center">
                    <div class="p-3 rounded-full bg-blue-100 text-blue-600">
                        <i class="fas fa-chalkboard text-xl"></i>
                    </div>
                    <div class="ml-4">
                        <p class="text-gray-500 text-xs">Jadwal Mengajar</p>
                        <p class="text-2xl font-bold">{{ $guru->jadwals->count() }}</p>
                    </div>
                </div>
            </div>
            <div class="bg-white rounded-lg shadow p-4">
                <div class="flex items-center">
                    <div class="p-3 rounded-full bg-green-100 text-green-600">
                        <i class="fas fa-book text-xl"></i>
                    </div>
                    <div class="ml-4">
                        <p class="text-gray-500 text-xs">Mata Pelajaran</p>
                        <p class="text-2xl font-bold">{{ $guru->mataPelajarans->count() }}</p>
                    </div>
                </div>
            </div>
            <div class="bg-white rounded-lg shadow p-4">
                <div class="flex items-center">
                    <div class="p-3 rounded-full bg-purple-100 text-purple-600">
                        <i class="fas fa-users text-xl"></i>
                    </div>
                    <div class="ml-4">
                        <p class="text-gray-500 text-xs">Kelas Diampu</p>
                        <p class="text-2xl font-bold">{{ $guru->jadwals->pluck('kelas_id')->unique()->count() }}</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Jadwal Mengajar -->
        <div class="bg-white rounded-lg shadow">
            <div class="p-6 border-b">
                <h3 class="text-lg font-semibold flex items-center">
                    <i class="fas fa-calendar-alt text-blue-600 mr-2"></i>
                    Jadwal Mengajar
                </h3>
            </div>
            <div class="p-6">
                @if($guru->jadwals->count() > 0)
                <div class="overflow-x-auto">
                    <table class="w-full text-sm">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-4 py-3 text-left font-medium text-gray-600">Hari</th>
                                <th class="px-4 py-3 text-left font-medium text-gray-600">Jam</th>
                                <th class="px-4 py-3 text-left font-medium text-gray-600">Mata Pelajaran</th>
                                <th class="px-4 py-3 text-left font-medium text-gray-600">Kelas</th>
                                <th class="px-4 py-3 text-left font-medium text-gray-600">Ruangan</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                            @foreach($guru->jadwals->sortBy(['hari', 'jam_mulai']) as $jadwal)
                            @php
                                $hariOrder = ['Senin' => 1, 'Selasa' => 2, 'Rabu' => 3, 'Kamis' => 4, 'Jumat' => 5, 'Sabtu' => 6];
                            @endphp
                            <tr class="hover:bg-gray-50">
                                <td class="px-4 py-3 font-medium">{{ $jadwal->hari }}</td>
                                <td class="px-4 py-3">{{ \Carbon\Carbon::parse($jadwal->jam_mulai)->format('H:i') }} - {{ \Carbon\Carbon::parse($jadwal->jam_selesai)->format('H:i') }}</td>
                                <td class="px-4 py-3">{{ $jadwal->mataPelajaran->nama_mapel }}</td>
                                <td class="px-4 py-3">
                                    <span class="px-2 py-1 bg-blue-100 text-blue-700 rounded text-xs">{{ $jadwal->kelas->nama_kelas }}</span>
                                </td>
                                <td class="px-4 py-3">{{ $jadwal->ruangan ?? '-' }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                @else
                <div class="text-center py-8 text-gray-500">
                    <i class="fas fa-calendar-times text-4xl mb-3 text-gray-300"></i>
                    <p>Belum ada jadwal mengajar</p>
                </div>
                @endif
            </div>
        </div>

        <!-- Mata Pelajaran yang Diampu -->
        <div class="bg-white rounded-lg shadow">
            <div class="p-6 border-b">
                <h3 class="text-lg font-semibold flex items-center">
                    <i class="fas fa-book-open text-green-600 mr-2"></i>
                    Mata Pelajaran yang Diampu
                </h3>
            </div>
            <div class="p-6">
                @if($guru->mataPelajarans->count() > 0)
                <div class="flex flex-wrap gap-2">
                    @foreach($guru->mataPelajarans as $mapel)
                    <span class="px-3 py-2 bg-green-100 text-green-700 rounded-lg text-sm font-medium">
                        {{ $mapel->kode_mapel }} - {{ $mapel->nama_mapel }}
                        @if($mapel->jurusan)
                            <span class="text-xs text-green-600 ml-1">({{ $mapel->jurusan->kode_jurusan }})</span>
                        @endif
                    </span>
                    @endforeach
                </div>
                @else
                <div class="text-center py-8 text-gray-500">
                    <i class="fas fa-books text-4xl mb-3 text-gray-300"></i>
                    <p>Belum ada mata pelajaran yang diampu</p>
                </div>
                @endif
            </div>
        </div>

        <!-- Info Akun -->
        <div class="bg-white rounded-lg shadow">
            <div class="p-6 border-b">
                <h3 class="text-lg font-semibold flex items-center">
                    <i class="fas fa-user-shield text-purple-600 mr-2"></i>
                    Informasi Akun
                </h3>
            </div>
            <div class="p-6">
                <div class="grid grid-cols-2 gap-4 text-sm">
                    <div>
                        <p class="text-gray-500 text-xs">Username/Email Login</p>
                        <p class="font-medium">{{ $guru->user->email }}</p>
                    </div>
                    <div>
                        <p class="text-gray-500 text-xs">Role</p>
                        <p class="font-medium capitalize">{{ $guru->user->role }}</p>
                    </div>
                    <div>
                        <p class="text-gray-500 text-xs">Akun Dibuat</p>
                        <p class="font-medium">{{ $guru->user->created_at->format('d F Y H:i') }}</p>
                    </div>
                    <div>
                        <p class="text-gray-500 text-xs">Terakhir Update</p>
                        <p class="font-medium">{{ $guru->user->updated_at->format('d F Y H:i') }}</p>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>
@endsection