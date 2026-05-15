@extends('layouts.admin')

@section('title', 'Detail Jurusan')
@section('page-title', 'Detail Jurusan: ' . $jurusan->nama_jurusan)

@section('content')
<div class="mb-4">
    <a href="{{ route('admin.jurusan.index') }}" class="inline-flex items-center text-sm text-blue-600 hover:text-blue-800">
        <i class="fas fa-arrow-left mr-2"></i>Kembali ke daftar jurusan
    </a>
</div>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
    <div class="lg:col-span-1">
        <div class="bg-white rounded-lg shadow p-6">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-lg font-semibold">Informasi Jurusan</h3>
                <span class="px-3 py-1 bg-blue-100 text-blue-800 rounded-full text-sm font-mono font-bold">
                    {{ $jurusan->kode_jurusan }}
                </span>
            </div>

            <div class="space-y-3 text-sm">
                <div class="border-b pb-3">
                    <p class="text-gray-500 mb-1">Nama Jurusan</p>
                    <p class="font-semibold text-gray-900">{{ $jurusan->nama_jurusan }}</p>
                </div>
                <div class="border-b pb-3">
                    <p class="text-gray-500 mb-1">Keterangan</p>
                    <p class="text-gray-800">{{ $jurusan->keterangan ?: '—' }}</p>
                </div>
                <div class="flex justify-between border-b pb-3">
                    <span class="text-gray-500">Jumlah Kelas</span>
                    <span class="font-bold text-blue-600">{{ $jurusan->kelas->count() }}</span>
                </div>
                <div class="flex justify-between border-b pb-3">
                    <span class="text-gray-500">Mata Pelajaran</span>
                    <span class="font-bold text-blue-600">{{ $jurusan->mataPelajarans->count() }}</span>
                </div>
                <div class="flex justify-between">
                    <span class="text-gray-500">Terakhir Diupdate</span>
                    <span class="font-medium">{{ $jurusan->updated_at->translatedFormat('d M Y H:i') }}</span>
                </div>
            </div>

            <div class="flex gap-2 mt-6 pt-4 border-t">
                <a href="{{ route('admin.jurusan.edit', $jurusan) }}" class="flex-1 text-center px-4 py-2 bg-yellow-500 text-white rounded-lg hover:bg-yellow-600 text-sm font-medium">
                    <i class="fas fa-edit mr-1"></i> Edit
                </a>
                @if($jurusan->kelas->isEmpty() && $jurusan->mataPelajarans->isEmpty())
                    <form action="{{ route('admin.jurusan.destroy', $jurusan) }}" method="POST" class="flex-1" onsubmit="return confirm('Yakin hapus jurusan ini?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="w-full px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 text-sm font-medium">
                            <i class="fas fa-trash mr-1"></i> Hapus
                        </button>
                    </form>
                @endif
            </div>
        </div>
    </div>

    <div class="lg:col-span-2 space-y-6">
        <div class="bg-white rounded-lg shadow">
            <div class="p-6 border-b flex justify-between items-center">
                <h3 class="text-lg font-semibold">Daftar Kelas</h3>
                <a href="{{ route('admin.kelas.create', ['jurusan_id' => $jurusan->id]) }}" class="text-sm text-blue-600 hover:underline">
                    <i class="fas fa-plus mr-1"></i>Tambah Kelas
                </a>
            </div>
            <div class="p-6">
                @if($jurusan->kelas->isNotEmpty())
                    <div class="overflow-x-auto">
                        <table class="w-full text-sm">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-4 py-2 text-left">Kode</th>
                                    <th class="px-4 py-2 text-left">Nama Kelas</th>
                                    <th class="px-4 py-2 text-center">Tingkat</th>
                                    <th class="px-4 py-2 text-center">Siswa</th>
                                    <th class="px-4 py-2 text-center">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y">
                                @foreach($jurusan->kelas as $kelas)
                                    <tr class="hover:bg-gray-50">
                                        <td class="px-4 py-2 font-mono">{{ $kelas->kode_kelas }}</td>
                                        <td class="px-4 py-2 font-medium">{{ $kelas->nama_kelas }}</td>
                                        <td class="px-4 py-2 text-center">{{ $kelas->tingkat }}</td>
                                        <td class="px-4 py-2 text-center">{{ $kelas->siswas_count ?? 0 }}</td>
                                        <td class="px-4 py-2 text-center">
                                            <a href="{{ route('admin.kelas.show', $kelas) }}" class="text-blue-600 hover:text-blue-800" title="Lihat">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <p class="text-center text-gray-500 py-8">Belum ada kelas untuk jurusan ini</p>
                @endif
            </div>
        </div>

        <div class="bg-white rounded-lg shadow">
            <div class="p-6 border-b flex justify-between items-center">
                <h3 class="text-lg font-semibold">Mata Pelajaran Kejuruan</h3>
                <a href="{{ route('admin.mapel.create', ['jurusan_id' => $jurusan->id]) }}" class="text-sm text-blue-600 hover:underline">
                    <i class="fas fa-plus mr-1"></i>Tambah Mapel
                </a>
            </div>
            <div class="p-6">
                @if($jurusan->mataPelajarans->isNotEmpty())
                    <div class="overflow-x-auto">
                        <table class="w-full text-sm">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-4 py-2 text-left">Kode</th>
                                    <th class="px-4 py-2 text-left">Nama Mapel</th>
                                    <th class="px-4 py-2 text-center">Kelompok</th>
                                    <th class="px-4 py-2 text-center">KKM</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y">
                                @foreach($jurusan->mataPelajarans as $mapel)
                                    <tr class="hover:bg-gray-50">
                                        <td class="px-4 py-2 font-mono">{{ $mapel->kode_mapel }}</td>
                                        <td class="px-4 py-2">{{ $mapel->nama_mapel }}</td>
                                        <td class="px-4 py-2 text-center">
                                            <span class="px-2 py-1 rounded text-xs font-semibold bg-purple-100 text-purple-800">
                                                {{ ['', 'A', 'B', 'C'][$mapel->kelompok] ?? '-' }}
                                            </span>
                                        </td>
                                        <td class="px-4 py-2 text-center font-semibold">{{ $mapel->kkm }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <p class="text-center text-gray-500 py-8">Belum ada mata pelajaran untuk jurusan ini</p>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
