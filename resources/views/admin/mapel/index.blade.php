@extends('layouts.admin')

@section('title', 'Data Mata Pelajaran')
@section('page-title', 'Manajemen Mata Pelajaran')

@section('content')
<div class="bg-white rounded-lg shadow">
    <div class="p-6 border-b">
        <div class="flex flex-wrap justify-between items-center gap-4">
            <h3 class="text-lg font-semibold">Daftar Mata Pelajaran</h3>
            <a href="{{ route('admin.mapel.create') }}" class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700">
                <i class="fas fa-plus mr-2"></i>Tambah Mapel
            </a>
        </div>

        <!-- Filter -->
        <form method="GET" class="flex flex-wrap gap-3 mt-4">
            <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari kode/nama mapel..." 
                   class="border rounded-lg px-4 py-2 w-64">
            
            <select name="jurusan_id" class="border rounded-lg px-4 py-2">
                <option value="">Semua Jurusan</option>
                @foreach($jurusans as $j)
                    <option value="{{ $j->id }}" {{ request('jurusan_id') == $j->id ? 'selected' : '' }}>
                        {{ $j->nama_jurusan }}
                    </option>
                @endforeach
            </select>

            <select name="kelompok" class="border rounded-lg px-4 py-2">
                <option value="">Semua Kelompok</option>
                <option value="1" {{ request('kelompok') == '1' ? 'selected' : '' }}>Kelompok A (Umum)</option>
                <option value="2" {{ request('kelompok') == '2' ? 'selected' : '' }}>Kelompok B (Umum)</option>
                <option value="3" {{ request('kelompok') == '3' ? 'selected' : '' }}>Kelompok C (Kejuruan)</option>
            </select>

            <button type="submit" class="bg-gray-600 text-white px-4 py-2 rounded-lg hover:bg-gray-700">
                <i class="fas fa-filter"></i> Filter
            </button>
        </form>
    </div>

    <div class="p-6">
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-4 py-3 text-left font-medium text-gray-500">No</th>
                        <th class="px-4 py-3 text-left font-medium text-gray-500">Kode</th>
                        <th class="px-4 py-3 text-left font-medium text-gray-500">Nama Mapel</th>
                        <th class="px-4 py-3 text-left font-medium text-gray-500">Jurusan</th>
                        <th class="px-4 py-3 text-center font-medium text-gray-500">Kelompok</th>
                        <th class="px-4 py-3 text-center font-medium text-gray-500">KKM</th>
                        <th class="px-4 py-3 text-center font-medium text-gray-500">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y">
                    @forelse($mapels as $i => $mapel)
                    <tr class="hover:bg-gray-50">
                        <td class="px-4 py-3">{{ $mapels->firstItem() + $i }}</td>
                        <td class="px-4 py-3 font-mono font-medium">{{ $mapel->kode_mapel }}</td>
                        <td class="px-4 py-3">{{ $mapel->nama_mapel }}</td>
                        <td class="px-4 py-3">{{ $mapel->jurusan?->nama_jurusan ?? '-' }}</td>
                        <td class="px-4 py-3 text-center">
                            <span class="px-2 py-1 rounded text-xs font-semibold
                                {{ $mapel->kelompok == 1 ? 'bg-blue-100 text-blue-800' : '' }}
                                {{ $mapel->kelompok == 2 ? 'bg-green-100 text-green-800' : '' }}
                                {{ $mapel->kelompok == 3 ? 'bg-purple-100 text-purple-800' : '' }}">
                                {{ ['', 'A', 'B', 'C'][$mapel->kelompok] }}
                            </span>
                        </td>
                        <td class="px-4 py-3 text-center font-semibold">{{ $mapel->kkm }}</td>
                        <td class="px-4 py-3 text-center">
                            <a href="{{ route('admin.mapel.edit', $mapel) }}" class="text-yellow-600 hover:text-yellow-800 mx-1">
                                <i class="fas fa-edit"></i>
                            </a>
                            <form action="{{ route('admin.mapel.destroy', $mapel) }}" method="POST" class="inline" onsubmit="return confirm('Yakin hapus mapel ini?')">
                                @csrf @method('DELETE')
                                <button type="submit" class="text-red-600 hover:text-red-800 mx-1">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="px-4 py-8 text-center text-gray-500">Belum ada data mata pelajaran</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        <div class="mt-4">
            {{ $mapels->links() }}
        </div>
    </div>
</div>
@endsection