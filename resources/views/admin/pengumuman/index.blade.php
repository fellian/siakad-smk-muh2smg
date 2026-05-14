@extends('layouts.admin')

@section('title', 'Pengumuman')
@section('page-title', 'Manajemen Pengumuman')

@section('content')
<div class="bg-white rounded-lg shadow">
    <div class="p-6 border-b flex items-center justify-between">
        <h3 class="text-lg font-semibold">Daftar Pengumuman</h3>
        <a href="{{ route('admin.pengumuman.create') }}" class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700">
            <i class="fas fa-plus mr-2"></i>Buat Pengumuman
        </a>
    </div>

    <div class="p-6">
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-4 py-3 text-left">No</th>
                        <th class="px-4 py-3 text-left">Judul</th>
                        <th class="px-4 py-3 text-left">Target</th>
                        <th class="px-4 py-3 text-left">Periode</th>
                        <th class="px-4 py-3 text-left">Dibuat Oleh</th>
                        <th class="px-4 py-3 text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse($pengumumans as $i => $p)
                    <tr class="hover:bg-gray-50">
                        <td class="px-4 py-3">{{ $pengumumans->firstItem() + $i }}</td>
                        <td class="px-4 py-3">
                            <p class="font-medium">{{ $p->judul }}</p>
                            <p class="text-xs text-gray-500">{{ Str::limit(strip_tags($p->isi), 50) }}</p>
                        </td>
                        <td class="px-4 py-3">
                            <span class="px-2 py-1 rounded text-xs {{ $p->target == 'semua' ? 'bg-purple-100 text-purple-700' : ($p->target == 'siswa' ? 'bg-blue-100 text-blue-700' : 'bg-green-100 text-green-700') }}">
                                {{ ucfirst($p->target) }}
                            </span>
                        </td>
                        <td class="px-4 py-3 text-xs">
                            {{ $p->tanggal_mulai->format('d/m/Y') }}
                            @if($p->tanggal_selesai)
                                - {{ $p->tanggal_selesai->format('d/m/Y') }}
                            @endif
                        </td>
                        <td class="px-4 py-3">{{ $p->user->name }}</td>
                        <td class="px-4 py-3 text-center">
                            <a href="{{ route('admin.pengumuman.edit', $p) }}" class="text-blue-600 hover:text-blue-800 mx-1"><i class="fas fa-edit"></i></a>
                            <form action="{{ route('admin.pengumuman.destroy', $p) }}" method="POST" class="inline" onsubmit="return confirm('Yakin hapus?')">
                                @csrf @method('DELETE')
                                <button type="submit" class="text-red-600 hover:text-red-800 mx-1"><i class="fas fa-trash"></i></button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="px-4 py-8 text-center text-gray-500">Belum ada pengumuman</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="mt-4">{{ $pengumumans->links() }}</div>
    </div>
</div>
@endsection