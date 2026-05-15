@extends('layouts.admin')

@section('title', 'Data Kelas')
@section('page-title', 'Manajemen Kelas & Jurusan')

@section('content')
<div class="mb-6">
    <div class="flex justify-between items-center mb-4">
        <h3 class="text-lg font-semibold">Daftar Kelas</h3>
        <div class="flex gap-2">
            <a href="{{ route('admin.jurusan.index') }}" class="px-4 py-2 border border-blue-600 text-blue-600 rounded-lg hover:bg-blue-50">
                <i class="fas fa-layer-group mr-2"></i>Kelola Jurusan
            </a>
            <a href="{{ route('admin.kelas.create') }}" class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700">
                <i class="fas fa-plus mr-2"></i>Tambah Kelas
            </a>
        </div>
    </div>

    <!-- Ringkasan -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">
        <div class="bg-blue-50 rounded-lg p-4">
            <p class="text-blue-600 text-sm font-medium">Kelas X (10)</p>
            <p class="text-2xl font-bold">{{ $kelas->where('tingkat', 10)->count() }} Kelas</p>
        </div>
        <div class="bg-green-50 rounded-lg p-4">
            <p class="text-green-600 text-sm font-medium">Kelas XI (11)</p>
            <p class="text-2xl font-bold">{{ $kelas->where('tingkat', 11)->count() }} Kelas</p>
        </div>
        <div class="bg-purple-50 rounded-lg p-4">
            <p class="text-purple-600 text-sm font-medium">Kelas XII (12)</p>
            <p class="text-2xl font-bold">{{ $kelas->where('tingkat', 12)->count() }} Kelas</p>
        </div>
    </div>

    <div class="bg-white rounded-lg shadow overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-4 py-3 text-left font-medium text-gray-500">No</th>
                        <th class="px-4 py-3 text-left font-medium text-gray-500">Kode</th>
                        <th class="px-4 py-3 text-left font-medium text-gray-500">Nama Kelas</th>
                        <th class="px-4 py-3 text-left font-medium text-gray-500">Tingkat</th>
                        <th class="px-4 py-3 text-left font-medium text-gray-500">Jurusan</th>
                        <th class="px-4 py-3 text-left font-medium text-gray-500">Wali Kelas</th>
                        <th class="px-4 py-3 text-center font-medium text-gray-500">Siswa</th>
                        <th class="px-4 py-3 text-center font-medium text-gray-500">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y">
                    @forelse($kelas as $i => $k)
                    <tr class="hover:bg-gray-50">
                        <td class="px-4 py-3">{{ $i + 1 }}</td>
                        <td class="px-4 py-3 font-mono font-medium">{{ $k->kode_kelas }}</td>
                        <td class="px-4 py-3 font-semibold">{{ $k->nama_kelas }}</td>
                        <td class="px-4 py-3">
                            <span class="px-2 py-1 rounded text-xs font-semibold bg-gray-100">
                                Kelas {{ $k->tingkat }}
                            </span>
                        </td>
                        <td class="px-4 py-3">{{ $k->jurusan->nama_jurusan }}</td>
                        <td class="px-4 py-3">{{ $k->waliKelas?->nama_lengkap ?? '-' }}</td>
                        <td class="px-4 py-3 text-center">
                            <span class="px-2 py-1 rounded-full bg-blue-100 text-blue-800 text-xs font-semibold">
                                {{ $k->siswas->count() }} siswa
                            </span>
                        </td>
                        <td class="px-4 py-3 text-center">
                            <a href="{{ route('admin.kelas.show', $k) }}" class="text-blue-600 hover:text-blue-800 mx-1" title="Detail">
                                <i class="fas fa-eye"></i>
                            </a>
                            <a href="{{ route('admin.kelas.edit', $k) }}" class="text-yellow-600 hover:text-yellow-800 mx-1" title="Edit">
                                <i class="fas fa-edit"></i>
                            </a>
                            <form action="{{ route('admin.kelas.destroy', $k) }}" method="POST" class="inline" onsubmit="return confirm('Yakin hapus kelas ini?')">
                                @csrf @method('DELETE')
                                <button type="submit" class="text-red-600 hover:text-red-800 mx-1" title="Hapus">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="8" class="px-4 py-8 text-center text-gray-500">Belum ada data kelas</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection