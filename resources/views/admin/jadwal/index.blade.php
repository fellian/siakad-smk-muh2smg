@extends('layouts.admin')

@section('title', 'Jadwal Pelajaran')
@section('page-title', 'Manajemen Jadwal Pelajaran')

@section('content')
<div class="bg-white rounded-lg shadow">
    <div class="p-6 border-b">
        <div class="flex flex-wrap items-center justify-between gap-4">
            <h3 class="text-lg font-semibold">Daftar Jadwal</h3>
            <a href="{{ route('admin.jadwal.create') }}" class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700">
                <i class="fas fa-plus mr-2"></i>Tambah Jadwal
            </a>
        </div>
    </div>

    <!-- Filter -->
    <div class="p-4 border-b bg-gray-50">
        <form method="GET" class="flex flex-wrap gap-3">
            <select name="kelas_id" class="border rounded-lg px-4 py-2">
                <option value="">Semua Kelas</option>
                @foreach($kelas as $k)
                    <option value="{{ $k->id }}" {{ request('kelas_id') == $k->id ? 'selected' : '' }}>
                        {{ $k->nama_kelas }}
                    </option>
                @endforeach
            </select>
            <select name="hari" class="border rounded-lg px-4 py-2">
                <option value="">Semua Hari</option>
                @foreach(['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu'] as $h)
                    <option value="{{ $h }}" {{ request('hari') == $h ? 'selected' : '' }}>{{ $h }}</option>
                @endforeach
            </select>
            <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700">
                <i class="fas fa-search mr-2"></i>Filter
            </button>
            @if(request()->hasAny(['kelas_id', 'hari']))
            <a href="{{ route('admin.jadwal.index') }}" class="bg-gray-500 text-white px-4 py-2 rounded-lg hover:bg-gray-600">
                Reset
            </a>
            @endif
        </form>
    </div>

    <div class="p-6">
        @php
            $hariOrder = ['Senin' => 1, 'Selasa' => 2, 'Rabu' => 3, 'Kamis' => 4, 'Jumat' => 5, 'Sabtu' => 6];
        @endphp

        @if(request('kelas_id'))
            <!-- Tampilan per kelas -->
            @php
                $kelasTerpilih = $kelas->firstWhere('id', request('kelas_id'));
                $jadwalPerHari = $jadwals->groupBy('hari')->sortBy(function($items, $key) use ($hariOrder) {
                    return $hariOrder[$key] ?? 99;
                });
            @endphp
            
            <h4 class="font-semibold mb-4 text-lg">Jadwal {{ $kelasTerpilih->nama_kelas }}</h4>
            
            @if($jadwalPerHari->count() > 0)
                @foreach($jadwalPerHari as $hari => $jadwalHari)
                <div class="mb-4">
                    <h5 class="font-medium text-blue-700 mb-2 bg-blue-50 px-3 py-1 rounded">{{ $hari }}</h5>
                    <div class="overflow-x-auto">
                        <table class="w-full text-sm">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-4 py-2 text-left">Jam</th>
                                    <th class="px-4 py-2 text-left">Mapel</th>
                                    <th class="px-4 py-2 text-left">Guru</th>
                                    <th class="px-4 py-2 text-left">Ruangan</th>
                                    <th class="px-4 py-2 text-center">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-100">
                                @foreach($jadwalHari->sortBy('jam_mulai') as $jadwal)
                                <tr class="hover:bg-gray-50">
                                    <td class="px-4 py-2 font-medium">{{ \Carbon\Carbon::parse($jadwal->jam_mulai)->format('H:i') }} - {{ \Carbon\Carbon::parse($jadwal->jam_selesai)->format('H:i') }}</td>
                                    <td class="px-4 py-2">{{ $jadwal->mataPelajaran->nama_mapel }}</td>
                                    <td class="px-4 py-2">{{ $jadwal->guru->nama_lengkap }}</td>
                                    <td class="px-4 py-2">{{ $jadwal->ruangan ?? '-' }}</td>
                                    <td class="px-4 py-2 text-center">
                                        <a href="{{ route('admin.jadwal.edit', $jadwal) }}" class="text-blue-600 hover:text-blue-800 mx-1"><i class="fas fa-edit"></i></a>
                                        <form action="{{ route('admin.jadwal.destroy', $jadwal) }}" method="POST" class="inline" onsubmit="return confirm('Yakin hapus?')">
                                            @csrf @method('DELETE')
                                            <button type="submit" class="text-red-600 hover:text-red-800 mx-1"><i class="fas fa-trash"></i></button>
                                        </form>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
                @endforeach
            @else
                <div class="text-center py-8 text-gray-500">
                    <i class="fas fa-calendar-times text-4xl mb-3 text-gray-300"></i>
                    <p>Belum ada jadwal untuk kelas ini</p>
                </div>
            @endif
        @else
            <!-- Tampilan semua jadwal -->
            <div class="overflow-x-auto">
                <table class="w-full text-sm">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-4 py-3 text-left">No</th>
                            <th class="px-4 py-3 text-left">Hari</th>
                            <th class="px-4 py-3 text-left">Jam</th>
                            <th class="px-4 py-3 text-left">Kelas</th>
                            <th class="px-4 py-3 text-left">Mata Pelajaran</th>
                            <th class="px-4 py-3 text-left">Guru</th>
                            <th class="px-4 py-3 text-left">Ruangan</th>
                            <th class="px-4 py-3 text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @forelse($jadwals as $i => $jadwal)
                        <tr class="hover:bg-gray-50">
                            <td class="px-4 py-3">{{ $i + 1 }}</td>
                            <td class="px-4 py-3 font-medium">{{ $jadwal->hari }}</td>
                            <td class="px-4 py-3">{{ \Carbon\Carbon::parse($jadwal->jam_mulai)->format('H:i') }} - {{ \Carbon\Carbon::parse($jadwal->jam_selesai)->format('H:i') }}</td>
                            <td class="px-4 py-3"><span class="px-2 py-1 bg-blue-100 text-blue-700 rounded text-xs">{{ $jadwal->kelas->nama_kelas }}</span></td>
                            <td class="px-4 py-3">{{ $jadwal->mataPelajaran->nama_mapel }}</td>
                            <td class="px-4 py-3">{{ $jadwal->guru->nama_lengkap }}</td>
                            <td class="px-4 py-3">{{ $jadwal->ruangan ?? '-' }}</td>
                            <td class="px-4 py-3 text-center">
                                <a href="{{ route('admin.jadwal.edit', $jadwal) }}" class="text-blue-600 hover:text-blue-800 mx-1"><i class="fas fa-edit"></i></a>
                                <form action="{{ route('admin.jadwal.destroy', $jadwal) }}" method="POST" class="inline" onsubmit="return confirm('Yakin hapus jadwal ini?')">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="text-red-600 hover:text-red-800 mx-1"><i class="fas fa-trash"></i></button>
                                </form>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="8" class="px-4 py-8 text-center text-gray-500">Belum ada data jadwal</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        @endif
    </div>
</div>
@endsection