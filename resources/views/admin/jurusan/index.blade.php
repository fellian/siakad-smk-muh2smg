@extends('layouts.admin')

@section('title', 'Data Jurusan')
@section('page-title', 'Manajemen Jurusan')

@section('content')
<div class="bg-white rounded-lg shadow">
    <div class="p-6 border-b">
        <div class="flex flex-wrap justify-between items-center gap-4">
            <h3 class="text-lg font-semibold">Daftar Jurusan</h3>
            <a href="{{ route('admin.jurusan.create') }}" class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700">
                <i class="fas fa-plus mr-2"></i>Tambah Jurusan
            </a>
        </div>

        <form method="GET" class="flex flex-wrap gap-3 mt-4">
            <input
                type="text"
                name="search"
                value="{{ request('search') }}"
                placeholder="Cari kode, nama, atau keterangan..."
                class="border rounded-lg px-4 py-2 w-full max-w-md"
            >
            <button type="submit" class="bg-gray-600 text-white px-4 py-2 rounded-lg hover:bg-gray-700">
                <i class="fas fa-search mr-1"></i> Cari
            </button>
            @if(request('search'))
                <a href="{{ route('admin.jurusan.index') }}" class="px-4 py-2 border rounded-lg hover:bg-gray-50 text-gray-600">
                    Reset
                </a>
            @endif
        </form>
    </div>

    <div class="p-6">
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-4 py-3 text-left font-medium text-gray-500">No</th>
                        <th class="px-4 py-3 text-left font-medium text-gray-500">Kode</th>
                        <th class="px-4 py-3 text-left font-medium text-gray-500">Nama Jurusan</th>
                        <th class="px-4 py-3 text-left font-medium text-gray-500">Keterangan</th>
                        <th class="px-4 py-3 text-center font-medium text-gray-500">Kelas</th>
                        <th class="px-4 py-3 text-center font-medium text-gray-500">Mapel</th>
                        <th class="px-4 py-3 text-center font-medium text-gray-500">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y">
                    @forelse($jurusans as $i => $jurusan)
                        <tr class="hover:bg-gray-50">
                            <td class="px-4 py-3">{{ $jurusans->firstItem() + $i }}</td>
                            <td class="px-4 py-3 font-mono font-medium text-blue-700">{{ $jurusan->kode_jurusan }}</td>
                            <td class="px-4 py-3 font-medium">{{ $jurusan->nama_jurusan }}</td>
                            <td class="px-4 py-3 text-gray-500">{{ Str::limit($jurusan->keterangan, 50) ?: '—' }}</td>
                            <td class="px-4 py-3 text-center">
                                <span class="px-2 py-1 bg-blue-50 text-blue-700 rounded text-xs font-semibold">{{ $jurusan->kelas_count }}</span>
                            </td>
                            <td class="px-4 py-3 text-center">
                                <span class="px-2 py-1 bg-purple-50 text-purple-700 rounded text-xs font-semibold">{{ $jurusan->mata_pelajarans_count }}</span>
                            </td>
                            <td class="px-4 py-3 text-center whitespace-nowrap">
                                <a href="{{ route('admin.jurusan.show', $jurusan) }}" class="text-blue-600 hover:text-blue-800 mx-1" title="Lihat">
                                    <i class="fas fa-eye"></i>
                                </a>
                                <a href="{{ route('admin.jurusan.edit', $jurusan) }}" class="text-yellow-600 hover:text-yellow-800 mx-1" title="Edit">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <form action="{{ route('admin.jurusan.destroy', $jurusan) }}" method="POST" class="inline" onsubmit="return confirm('Yakin hapus jurusan {{ $jurusan->nama_jurusan }}?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-600 hover:text-red-800 mx-1" title="Hapus" {{ ($jurusan->kelas_count > 0 || $jurusan->mata_pelajarans_count > 0) ? 'disabled' : '' }}>
                                        <i class="fas fa-trash {{ ($jurusan->kelas_count > 0 || $jurusan->mata_pelajarans_count > 0) ? 'opacity-40 cursor-not-allowed' : '' }}"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="px-4 py-8 text-center text-gray-500">
                                @if(request('search'))
                                    Tidak ada jurusan yang cocok dengan pencarian.
                                @else
                                    Belum ada data jurusan. <a href="{{ route('admin.jurusan.create') }}" class="text-blue-600 hover:underline">Tambah jurusan</a>
                                @endif
                            </td>
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
