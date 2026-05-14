@extends('layouts.admin')

@section('title', 'Data Guru')
@section('page-title', 'Manajemen Data Guru')

@section('content')
<div class="bg-white rounded-lg shadow">
    <div class="p-6 border-b">
        <div class="flex flex-wrap justify-between items-center gap-4">
            <h3 class="text-lg font-semibold">Daftar Guru</h3>
            <a href="{{ route('admin.guru.create') }}" class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700">
                <i class="fas fa-plus mr-2"></i>Tambah Guru
            </a>
        </div>

        <form method="GET" class="mt-4">
            <div class="flex gap-3">
                <input type="text" name="search" value="{{ request('search') }}" 
                       placeholder="Cari NIP/Nama Guru..." 
                       class="border rounded-lg px-4 py-2 w-80">
                <button type="submit" class="bg-gray-600 text-white px-4 py-2 rounded-lg hover:bg-gray-700">
                    <i class="fas fa-search"></i> Cari
                </button>
            </div>
        </form>
    </div>

    <div class="p-6">
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-4 py-3 text-left font-medium text-gray-500">No</th>
                        <th class="px-4 py-3 text-left font-medium text-gray-500">Foto</th>
                        <th class="px-4 py-3 text-left font-medium text-gray-500">NIP/NUPTK</th>
                        <th class="px-4 py-3 text-left font-medium text-gray-500">Nama Lengkap</th>
                        <th class="px-4 py-3 text-left font-medium text-gray-500">Jenis Kelamin</th>
                        <th class="px-4 py-3 text-left font-medium text-gray-500">No. HP</th>
                        <th class="px-4 py-3 text-center font-medium text-gray-500">Status</th>
                        <th class="px-4 py-3 text-center font-medium text-gray-500">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y">
                    @forelse($gurus as $i => $guru)
                    <tr class="hover:bg-gray-50">
                        <td class="px-4 py-3">{{ $gurus->firstItem() + $i }}</td>
                        <td class="px-4 py-3">
                            @if($guru->foto)
                                <img src="{{ asset('storage/' . $guru->foto) }}" class="w-10 h-10 rounded-full object-cover">
                            @else
                                <div class="w-10 h-10 rounded-full bg-gray-200 flex items-center justify-center">
                                    <i class="fas fa-user text-gray-400"></i>
                                </div>
                            @endif
                        </td>
                        <td class="px-4 py-3 font-mono text-xs">
                            {{ $guru->nip ?? '-' }}<br>
                            <span class="text-gray-400">{{ $guru->nuptk ?? '-' }}</span>
                        </td>
                        <td class="px-4 py-3 font-medium">{{ $guru->nama_lengkap }}</td>
                        <td class="px-4 py-3">{{ $guru->jenis_kelamin == 'L' ? 'Laki-laki' : 'Perempuan' }}</td>
                        <td class="px-4 py-3">{{ $guru->no_hp ?? '-' }}</td>
                        <td class="px-4 py-3 text-center">
                            <span class="px-2 py-1 rounded text-xs font-semibold
                                {{ $guru->status == 'aktif' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                {{ ucfirst($guru->status) }}
                            </span>
                        </td>
                        <td class="px-4 py-3 text-center">
                            <a href="{{ route('admin.guru.show', $guru) }}" class="text-blue-600 hover:text-blue-800 mx-1" title="Detail">
                                <i class="fas fa-eye"></i>
                            </a>
                            <a href="{{ route('admin.guru.edit', $guru) }}" class="text-yellow-600 hover:text-yellow-800 mx-1" title="Edit">
                                <i class="fas fa-edit"></i>
                            </a>
                            <form action="{{ route('admin.guru.destroy', $guru) }}" method="POST" class="inline" onsubmit="return confirm('Yakin hapus guru ini?')">
                                @csrf @method('DELETE')
                                <button type="submit" class="text-red-600 hover:text-red-800 mx-1" title="Hapus">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="8" class="px-4 py-8 text-center text-gray-500">Belum ada data guru</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        <div class="mt-4">
            {{ $gurus->links() }}
        </div>
    </div>
</div>
@endsection