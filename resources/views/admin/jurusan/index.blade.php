@extends('layouts.admin')

@section('title', 'Data Jurusan')
@section('page-title', 'Manajemen Jurusan')

@section('content')
<div class="bg-white rounded-lg shadow">
    <div class="p-6 border-b flex justify-between items-center">
        <h3 class="text-lg font-semibold">Daftar Jurusan</h3>
        <a href="{{ route('admin.jurusan.create') }}" class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700">
            <i class="fas fa-plus mr-2"></i>Tambah Jurusan
        </a>
    </div>

    <div class="p-6">
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-4 py-3 text-left font-medium text-gray-500">No</th>
                        <th class="px-4 py-3 text-left font-medium text-gray-500">Kode Jurusan</th>
                        <th class="px-4 py-3 text-left font-medium text-gray-500">Nama Jurusan</th>
                        <th class="px-4 py-3 text-left font-medium text-gray-500">Keterangan</th>
                        <th class="px-4 py-3 text-center font-medium text-gray-500">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y">
                    @forelse($jurusans as $i => $jurusan)
                    <tr class="hover:bg-gray-50">
                        <td class="px-4 py-3">{{ $jurusans->firstItem() + $i }}</td>
                        <td class="px-4 py-3 font-mono font-medium">{{ $jurusan->kode_jurusan }}</td>
                        <td class="px-4 py-3">{{ $jurusan->nama_jurusan }}</td>
                        <td class="px-4 py-3 text-gray-500">{{ Str::limit($jurusan->keterangan, 50) }}</td>
                        <td class="px-4 py-3 text-center">
                            <a href="{{ route('admin.jurusan.edit', $jurusan) }}" class="text-yellow-600 hover:text-yellow-800 mx-1" title="Edit">
                                <i class="fas fa-edit"></i>
                            </a>
                            <form action="{{ route('admin.jurusan.destroy', $jurusan) }}" method="POST" class="inline" onsubmit="return confirm('Yakin hapus jurusan ini?')">
                                @csrf @method('DELETE')
                                <button type="submit" class="text-red-600 hover:text-red-800 mx-1" title="Hapus">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="px-4 py-8 text-center text-gray-500">Belum ada data jurusan</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        <div class="mt-4">
            {{ $jurusans->links() }}
        </div>
    </div>
</div>
@endsection