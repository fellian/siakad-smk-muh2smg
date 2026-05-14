@extends('layouts.admin')

@section('title', 'Detail Siswa')
@section('page-title', 'Detail Data Siswa')

@section('content')
<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
    
    <!-- Kolom Kiri: Profil Siswa -->
    <div class="lg:col-span-1">
        <!-- Card Profil -->
        <div class="bg-white rounded-lg shadow overflow-hidden">
            <div class="bg-gradient-to-r from-green-600 to-green-800 h-32"></div>
            <div class="px-6 pb-6 relative">
                <!-- Foto -->
                <div class="absolute -top-16 left-1/2 transform -translate-x-1/2">
                    @if($siswa->foto)
                        <img src="{{ asset('storage/' . $siswa->foto) }}" 
                             class="w-32 h-32 rounded-full border-4 border-white object-cover shadow-lg">
                    @else
                        <div class="w-32 h-32 rounded-full border-4 border-white bg-gray-300 flex items-center justify-center text-gray-600 text-4xl shadow-lg">
                            <i class="fas fa-user-graduate"></i>
                        </div>
                    @endif
                </div>
                
                <div class="mt-20 text-center">
                    <h3 class="text-xl font-bold text-gray-800">{{ $siswa->nama_lengkap }}</h3>
                    <p class="text-gray-500 text-sm mt-1">NIS: {{ $siswa->nis }}</p>
                    @if($siswa->nisn)
                        <p class="text-gray-500 text-sm">NISN: {{ $siswa->nisn }}</p>
                    @endif
                    
                    <div class="mt-3">
                        <span class="px-3 py-1 rounded-full text-sm font-medium {{ $siswa->status == 'aktif' ? 'bg-green-100 text-green-700' : ($siswa->status == 'pindah' ? 'bg-yellow-100 text-yellow-700' : 'bg-red-100 text-red-700') }}">
                            {{ ucfirst($siswa->status) }}
                        </span>
                    </div>

                    @if($siswa->kelas)
                    <div class="mt-2">
                        <span class="px-3 py-1 rounded-full text-sm font-medium bg-blue-100 text-blue-700">
                            <i class="fas fa-school mr-1"></i> {{ $siswa->kelas->nama_kelas }}
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
                            <p class="font-medium">{{ $siswa->email ?? '-' }}</p>
                        </div>
                    </div>
                    
                    <div class="flex items-center">
                        <div class="w-8 h-8 rounded-full bg-green-100 flex items-center justify-center text-green-600 mr-3">
                            <i class="fas fa-phone"></i>
                        </div>
                        <div>
                            <p class="text-gray-500 text-xs">No HP</p>
                            <p class="font-medium">{{ $siswa->no_hp ?? '-' }}</p>
                        </div>
                    </div>

                    <div class="flex items-center">
                        <div class="w-8 h-8 rounded-full bg-purple-100 flex items-center justify-center text-purple-600 mr-3">
                            <i class="fas fa-venus-mars"></i>
                        </div>
                        <div>
                            <p class="text-gray-500 text-xs">Jenis Kelamin</p>
                            <p class="font-medium">{{ $siswa->jenis_kelamin == 'L' ? 'Laki-laki' : 'Perempuan' }}</p>
                        </div>
                    </div>

                    <div class="flex items-center">
                        <div class="w-8 h-8 rounded-full bg-yellow-100 flex items-center justify-center text-yellow-600 mr-3">
                            <i class="fas fa-birthday-cake"></i>
                        </div>
                        <div>
                            <p class="text-gray-500 text-xs">Tempat, Tanggal Lahir</p>
                            <p class="font-medium">
                                @if($siswa->tempat_lahir && $siswa->tanggal_lahir)
                                    {{ $siswa->tempat_lahir }}, {{ $siswa->tanggal_lahir->format('d F Y') }}
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
                            <p class="font-medium">{{ $siswa->alamat ?? '-' }}</p>
                        </div>
                    </div>
                </div>

                <hr class="my-4">

                <!-- Info Orang Tua -->
                <div class="space-y-3 text-sm">
                    <h4 class="font-semibold text-gray-700">Data Orang Tua/Wali</h4>
                    <div class="flex items-center">
                        <div class="w-8 h-8 rounded-full bg-indigo-100 flex items-center justify-center text-indigo-600 mr-3">
                            <i class="fas fa-user-tie"></i>
                        </div>
                        <div>
                            <p class="text-gray-500 text-xs">Nama Orang Tua</p>
                            <p class="font-medium">{{ $siswa->nama_ortu ?? '-' }}</p>
                        </div>
                    </div>
                    <div class="flex items-center">
                        <div class="w-8 h-8 rounded-full bg-pink-100 flex items-center justify-center text-pink-600 mr-3">
                            <i class="fas fa-phone-alt"></i>
                        </div>
                        <div>
                            <p class="text-gray-500 text-xs">No HP Orang Tua</p>
                            <p class="font-medium">{{ $siswa->no_hp_ortu ?? '-' }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Tombol Aksi -->
        <div class="mt-4 flex gap-3">
            <a href="{{ route('admin.siswa.edit', $siswa) }}" class="flex-1 bg-blue-600 text-white text-center px-4 py-2 rounded-lg hover:bg-blue-700">
                <i class="fas fa-edit mr-2"></i>Edit
            </a>
            <form action="{{ route('admin.siswa.destroy', $siswa) }}" method="POST" class="flex-1" onsubmit="return confirm('Yakin hapus siswa ini?')">
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
        <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
            <div class="bg-white rounded-lg shadow p-4">
                <div class="flex items-center">
                    <div class="p-3 rounded-full bg-blue-100 text-blue-600">
                        <i class="fas fa-book text-xl"></i>
                    </div>
                    <div class="ml-4">
                        <p class="text-gray-500 text-xs">Jumlah Mapel</p>
                        <p class="text-2xl font-bold">{{ $siswa->nilais->pluck('mata_pelajaran_id')->unique()->count() }}</p>
                    </div>
                </div>
            </div>
            <div class="bg-white rounded-lg shadow p-4">
                <div class="flex items-center">
                    <div class="p-3 rounded-full bg-green-100 text-green-600">
                        <i class="fas fa-chart-line text-xl"></i>
                    </div>
                    <div class="ml-4">
                        <p class="text-gray-500 text-xs">Rata-rata Nilai</p>
                        <p class="text-2xl font-bold">{{ $siswa->nilais->avg('nilai_akhir') ? number_format($siswa->nilais->avg('nilai_akhir'), 2) : '-' }}</p>
                    </div>
                </div>
            </div>
            <div class="bg-white rounded-lg shadow p-4">
                <div class="flex items-center">
                    <div class="p-3 rounded-full bg-yellow-100 text-yellow-600">
                        <i class="fas fa-clipboard-check text-xl"></i>
                    </div>
                    <div class="ml-4">
                        <p class="text-gray-500 text-xs">Kehadiran</p>
                        <p class="text-2xl font-bold">
                            @php
                                $totalAbsensi = $siswa->absensis->count();
                                $hadir = $siswa->absensis->where('status', 'hadir')->count();
                                echo $totalAbsensi > 0 ? round(($hadir / $totalAbsensi) * 100) . '%' : '-';
                            @endphp
                        </p>
                    </div>
                </div>
            </div>
            <div class="bg-white rounded-lg shadow p-4">
                <div class="flex items-center">
                    <div class="p-3 rounded-full bg-purple-100 text-purple-600">
                        <i class="fas fa-calendar-alt text-xl"></i>
                    </div>
                    <div class="ml-4">
                        <p class="text-gray-500 text-xs">Tanggal Masuk</p>
                        <p class="text-lg font-bold">{{ $siswa->tanggal_masuk->format('d/m/Y') }}</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Info Kelas -->
        @if($siswa->kelas)
        <div class="bg-white rounded-lg shadow">
            <div class="p-6 border-b">
                <h3 class="text-lg font-semibold flex items-center">
                    <i class="fas fa-school text-blue-600 mr-2"></i>
                    Informasi Kelas
                </h3>
            </div>
            <div class="p-6">
                <div class="grid grid-cols-2 md:grid-cols-4 gap-4 text-sm">
                    <div>
                        <p class="text-gray-500 text-xs">Kelas</p>
                        <p class="font-medium text-lg">{{ $siswa->kelas->nama_kelas }}</p>
                    </div>
                    <div>
                        <p class="text-gray-500 text-xs">Jurusan</p>
                        <p class="font-medium">{{ $siswa->kelas->jurusan->nama_jurusan }}</p>
                    </div>
                    <div>
                        <p class="text-gray-500 text-xs">Tingkat</p>
                        <p class="font-medium">Kelas {{ $siswa->kelas->tingkat }}</p>
                    </div>
                    <div>
                        <p class="text-gray-500 text-xs">Wali Kelas</p>
                        <p class="font-medium">{{ $siswa->kelas->waliKelas?->nama_lengkap ?? '-' }}</p>
                    </div>
                </div>
            </div>
        </div>
        @endif

        <!-- Nilai Akademik -->
        <div class="bg-white rounded-lg shadow">
            <div class="p-6 border-b flex items-center justify-between">
                <h3 class="text-lg font-semibold flex items-center">
                    <i class="fas fa-chart-bar text-green-600 mr-2"></i>
                    Nilai Akademik
                </h3>
                <span class="text-sm text-gray-500">Semester {{ $siswa->nilais->first()?->semester ?? '-' }} - {{ $siswa->nilais->first()?->tahunAjaran?->tahun ?? '' }}</span>
            </div>
            <div class="p-6">
                @if($siswa->nilais->count() > 0)
                <div class="overflow-x-auto">
                    <table class="w-full text-sm">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-4 py-3 text-left font-medium text-gray-600">No</th>
                                <th class="px-4 py-3 text-left font-medium text-gray-600">Mata Pelajaran</th>
                                <th class="px-4 py-3 text-center font-medium text-gray-600">Tugas</th>
                                <th class="px-4 py-3 text-center font-medium text-gray-600">Ulangan</th>
                                <th class="px-4 py-3 text-center font-medium text-gray-600">UTS</th>
                                <th class="px-4 py-3 text-center font-medium text-gray-600">UAS</th>
                                <th class="px-4 py-3 text-center font-medium text-gray-600">Akhir</th>
                                <th class="px-4 py-3 text-center font-medium text-gray-600">Predikat</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                            @foreach($siswa->nilais as $i => $nilai)
                            <tr class="hover:bg-gray-50">
                                <td class="px-4 py-3">{{ $i + 1 }}</td>
                                <td class="px-4 py-3 font-medium">{{ $nilai->mataPelajaran->nama_mapel }}</td>
                                <td class="px-4 py-3 text-center">{{ $nilai->nilai_tugas }}</td>
                                <td class="px-4 py-3 text-center">{{ $nilai->nilai_ulangan }}</td>
                                <td class="px-4 py-3 text-center">{{ $nilai->nilai_uts }}</td>
                                <td class="px-4 py-3 text-center">{{ $nilai->nilai_uas }}</td>
                                <td class="px-4 py-3 text-center font-bold {{ $nilai->nilai_akhir >= 75 ? 'text-green-600' : 'text-red-600' }}">
                                    {{ number_format($nilai->nilai_akhir, 2) }}
                                </td>
                                <td class="px-4 py-3 text-center">
                                    <span class="px-2 py-1 rounded text-xs font-bold {{ $nilai->predikat == 'A' ? 'bg-green-100 text-green-700' : ($nilai->predikat == 'B' ? 'bg-blue-100 text-blue-700' : ($nilai->predikat == 'C' ? 'bg-yellow-100 text-yellow-700' : 'bg-red-100 text-red-700')) }}">
                                        {{ $nilai->predikat }}
                                    </span>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                @else
                <div class="text-center py-8 text-gray-500">
                    <i class="fas fa-chart-line text-4xl mb-3 text-gray-300"></i>
                    <p>Belum ada data nilai</p>
                </div>
                @endif
            </div>
        </div>

        <!-- Riwayat Absensi -->
        <div class="bg-white rounded-lg shadow">
            <div class="p-6 border-b">
                <h3 class="text-lg font-semibold flex items-center">
                    <i class="fas fa-clipboard-list text-yellow-600 mr-2"></i>
                    Riwayat Kehadiran
                </h3>
            </div>
            <div class="p-6">
                @if($siswa->absensis->count() > 0)
                @php
                    $statusCounts = [
                        'hadir' => $siswa->absensis->where('status', 'hadir')->count(),
                        'izin' => $siswa->absensis->where('status', 'izin')->count(),
                        'sakit' => $siswa->absensis->where('status', 'sakit')->count(),
                        'alpha' => $siswa->absensis->where('status', 'alpha')->count(),
                    ];
                    $total = array_sum($statusCounts);
                @endphp
                
                <!-- Ringkasan Absensi -->
                <div class="grid grid-cols-4 gap-4 mb-6">
                    <div class="text-center p-3 bg-green-50 rounded-lg">
                        <p class="text-2xl font-bold text-green-600">{{ $statusCounts['hadir'] }}</p>
                        <p class="text-xs text-green-700">Hadir</p>
                    </div>
                    <div class="text-center p-3 bg-yellow-50 rounded-lg">
                        <p class="text-2xl font-bold text-yellow-600">{{ $statusCounts['izin'] }}</p>
                        <p class="text-xs text-yellow-700">Izin</p>
                    </div>
                    <div class="text-center p-3 bg-blue-50 rounded-lg">
                        <p class="text-2xl font-bold text-blue-600">{{ $statusCounts['sakit'] }}</p>
                        <p class="text-xs text-blue-700">Sakit</p>
                    </div>
                    <div class="text-center p-3 bg-red-50 rounded-lg">
                        <p class="text-2xl font-bold text-red-600">{{ $statusCounts['alpha'] }}</p>
                        <p class="text-xs text-red-700">Alpha</p>
                    </div>
                </div>

                <!-- Detail Absensi -->
                <div class="overflow-x-auto">
                    <table class="w-full text-sm">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-4 py-3 text-left font-medium text-gray-600">Tanggal</th>
                                <th class="px-4 py-3 text-left font-medium text-gray-600">Mata Pelajaran</th>
                                <th class="px-4 py-3 text-center font-medium text-gray-600">Status</th>
                                <th class="px-4 py-3 text-left font-medium text-gray-600">Keterangan</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                            @foreach($siswa->absensis->sortByDesc('tanggal')->take(10) as $absensi)
                            <tr class="hover:bg-gray-50">
                                <td class="px-4 py-3">{{ $absensi->tanggal->format('d F Y') }}</td>
                                <td class="px-4 py-3">{{ $absensi->jadwal->mataPelajaran->nama_mapel }}</td>
                                <td class="px-4 py-3 text-center">
                                    <span class="px-2 py-1 rounded text-xs font-medium {{ $absensi->status == 'hadir' ? 'bg-green-100 text-green-700' : ($absensi->status == 'izin' ? 'bg-yellow-100 text-yellow-700' : ($absensi->status == 'sakit' ? 'bg-blue-100 text-blue-700' : 'bg-red-100 text-red-700')) }}">
                                        {{ ucfirst($absensi->status) }}
                                    </span>
                                </td>
                                <td class="px-4 py-3 text-gray-500">{{ $absensi->keterangan ?? '-' }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                @if($siswa->absensis->count() > 10)
                <p class="text-center text-sm text-gray-500 mt-3">Menampilkan 10 dari {{ $siswa->absensis->count() }} data absensi</p>
                @endif
                @else
                <div class="text-center py-8 text-gray-500">
                    <i class="fas fa-clipboard-check text-4xl mb-3 text-gray-300"></i>
                    <p>Belum ada data absensi</p>
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
                <div class="grid grid-cols-2 md:grid-cols-4 gap-4 text-sm">
                    <div>
                        <p class="text-gray-500 text-xs">Email Login</p>
                        <p class="font-medium">{{ $siswa->user->email }}</p>
                    </div>
                    <div>
                        <p class="text-gray-500 text-xs">Role</p>
                        <p class="font-medium capitalize">{{ $siswa->user->role }}</p>
                    </div>
                    <div>
                        <p class="text-gray-500 text-xs">Akun Dibuat</p>
                        <p class="font-medium">{{ $siswa->user->created_at->format('d F Y') }}</p>
                    </div>
                    <div>
                        <p class="text-gray-500 text-xs">Terakhir Update</p>
                        <p class="font-medium">{{ $siswa->user->updated_at->format('d F Y') }}</p>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>
@endsection