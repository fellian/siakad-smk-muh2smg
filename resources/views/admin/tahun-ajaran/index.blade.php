@extends('layouts.admin')

@section('title', 'Tahun Ajaran')
@section('page-title', 'Manajemen Tahun Ajaran')

@section('content')
@if($tahunAjaranAktif)
    <div class="mb-6 p-4 bg-green-50 border border-green-200 rounded-lg flex items-start gap-3">
        <i class="fas fa-check-circle text-green-600 mt-0.5"></i>
        <div>
            <p class="font-semibold text-green-800">Tahun Ajaran Aktif Saat Ini</p>
            <p class="text-green-700 text-sm mt-1">
                {{ $tahunAjaranAktif->tahun }} — Semester {{ $tahunAjaranAktif->semester }}
                <span class="text-green-600">(Kelas baru & modul akademik memakai ini)</span>
            </p>
        </div>
    </div>
@else
    <div class="mb-6 p-4 bg-amber-50 border border-amber-200 rounded-lg flex items-start gap-3">
        <i class="fas fa-exclamation-triangle text-amber-600 mt-0.5"></i>
        <div>
            <p class="font-semibold text-amber-800">Belum Ada Tahun Ajaran Aktif</p>
            <p class="text-amber-700 text-sm mt-1">Aktifkan satu tahun ajaran agar penambahan kelas dan fitur akademik berjalan normal.</p>
        </div>
    </div>
@endif

<div class="bg-white rounded-lg shadow">
    <div class="p-6 border-b flex flex-wrap justify-between items-center gap-4">
        <div>
            <h3 class="text-lg font-semibold">Daftar Tahun Ajaran</h3>
            <p class="text-sm text-gray-500 mt-1">Hanya satu tahun ajaran yang boleh aktif. Gunakan tombol &quot;Jadikan Aktif&quot; saat ganti semester.</p>
        </div>
        <a href="{{ route('admin.tahun-ajaran.create') }}" class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700">
            <i class="fas fa-plus mr-2"></i>Tambah Tahun Ajaran
        </a>
    </div>

    <div class="p-6 overflow-x-auto">
        <table class="w-full text-sm">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-4 py-3 text-left font-medium text-gray-500">Tahun</th>
                    <th class="px-4 py-3 text-center font-medium text-gray-500">Semester</th>
                    <th class="px-4 py-3 text-center font-medium text-gray-500">Status</th>
                    <th class="px-4 py-3 text-center font-medium text-gray-500">Kelas</th>
                    <th class="px-4 py-3 text-center font-medium text-gray-500">Jadwal</th>
                    <th class="px-4 py-3 text-center font-medium text-gray-500">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y">
                @forelse($tahunAjarans as $ta)
                    <tr class="hover:bg-gray-50 {{ $ta->status === 'aktif' ? 'bg-green-50/50' : '' }}">
                        <td class="px-4 py-3 font-medium">{{ $ta->tahun }}</td>
                        <td class="px-4 py-3 text-center">Semester {{ $ta->semester }}</td>
                        <td class="px-4 py-3 text-center">
                            @if($ta->status === 'aktif')
                                <span class="px-3 py-1 rounded-full text-xs font-semibold bg-green-100 text-green-800">Aktif</span>
                            @else
                                <span class="px-3 py-1 rounded-full text-xs font-semibold bg-gray-100 text-gray-600">Nonaktif</span>
                            @endif
                        </td>
                        <td class="px-4 py-3 text-center">{{ $ta->kelas_count }}</td>
                        <td class="px-4 py-3 text-center">{{ $ta->jadwals_count }}</td>
                        <td class="px-4 py-3 text-center whitespace-nowrap">
                            @if($ta->status !== 'aktif')
                                <form action="{{ route('admin.tahun-ajaran.activate', $ta) }}" method="POST" class="inline"
                                      onsubmit="return confirm('Jadikan {{ $ta->label }} sebagai tahun ajaran aktif? Semua yang lain akan dinonaktifkan.')">
                                    @csrf
                                    <button type="submit" class="inline-flex items-center px-2 py-1 text-xs font-medium text-green-700 bg-green-50 border border-green-200 rounded hover:bg-green-100 mx-1" title="Jadikan Aktif">
                                        <i class="fas fa-check-circle mr-1"></i> Aktifkan
                                    </button>
                                </form>
                            @endif
                            <a href="{{ route('admin.tahun-ajaran.edit', $ta) }}" class="text-yellow-600 hover:text-yellow-800 mx-1" title="Edit">
                                <i class="fas fa-edit"></i>
                            </a>
                            @if($ta->status !== 'aktif' && $ta->kelas_count === 0 && $ta->jadwals_count === 0 && $ta->nilais_count === 0)
                                <form action="{{ route('admin.tahun-ajaran.destroy', $ta) }}" method="POST" class="inline"
                                      onsubmit="return confirm('Yakin hapus tahun ajaran ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-600 hover:text-red-800 mx-1" title="Hapus">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="px-4 py-8 text-center text-gray-500">
                            Belum ada tahun ajaran.
                            <a href="{{ route('admin.tahun-ajaran.create') }}" class="text-blue-600 hover:underline">Tambah sekarang</a>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
