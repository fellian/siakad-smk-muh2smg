@extends('layouts.admin')

@section('title', 'Data Kelas')
@section('page-title', 'Manajemen Kelas & Jurusan')

@section('content')
<div class="space-y-6">
    <!-- Header Section -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 bg-white p-4 rounded-xl shadow-sm border border-gray-100">
        <div>
            <h3 class="text-xl font-bold text-gray-800">Daftar Kelas</h3>
            <p class="text-sm text-gray-500 mt-1">Kelola data kelas, tingkat, jurusan, dan wali kelas.</p>
        </div>
        <div class="flex flex-col sm:flex-row gap-2 w-full sm:w-auto">
            <a href="{{ route('admin.jurusan.index') }}" class="inline-flex items-center justify-center px-4 py-2.5 border border-gray-300 text-sm font-medium rounded-lg text-gray-700 bg-white hover:bg-gray-50 transition-colors shadow-sm">
                <i class="fas fa-layer-group mr-2 text-gray-400"></i>Kelola Jurusan
            </a>
            <a href="{{ route('admin.kelas.create') }}" class="inline-flex items-center justify-center px-4 py-2.5 bg-blue-600 hover:bg-blue-700 text-sm font-medium rounded-lg text-white transition-colors shadow-sm shadow-blue-100">
                <i class="fas fa-plus mr-2"></i>Tambah Kelas
            </a>
        </div>
    </div>

    <!-- Ringkasan Statistik -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
        <!-- Kelas X -->
        <div class="bg-gradient-to-br from-blue-50 to-blue-100/50 border border-blue-100 rounded-xl p-5 flex items-center justify-between shadow-sm">
            <div>
                <p class="text-blue-600 text-xs font-semibold uppercase tracking-wider">Kelas X (10)</p>
                <p class="text-3xl font-extrabold text-gray-800 mt-1">{{ $kelas->where('tingkat', 10)->count() }}</p>
            </div>
            <div class="w-12 h-12 rounded-lg bg-blue-500/10 flex items-center justify-center text-blue-600">
                <i class="fas fa-school text-xl"></i>
            </div>
        </div>
        
        <!-- Kelas XI -->
        <div class="bg-gradient-to-br from-emerald-50 to-emerald-100/50 border border-emerald-100 rounded-xl p-5 flex items-center justify-between shadow-sm">
            <div>
                <p class="text-emerald-600 text-xs font-semibold uppercase tracking-wider">Kelas XI (11)</p>
                <p class="text-3xl font-extrabold text-gray-800 mt-1">{{ $kelas->where('tingkat', 11)->count() }}</p>
            </div>
            <div class="w-12 h-12 rounded-lg bg-emerald-500/10 flex items-center justify-center text-emerald-600">
                <i class="fas fa-school text-xl"></i>
            </div>
        </div>

        <!-- Kelas XII -->
        <div class="bg-gradient-to-br from-purple-50 to-purple-100/50 border border-purple-100 rounded-xl p-5 flex items-center justify-between shadow-sm sm:col-span-2 lg:col-span-1">
            <div>
                <p class="text-purple-600 text-xs font-semibold uppercase tracking-wider">Kelas XII (12)</p>
                <p class="text-3xl font-extrabold text-gray-800 mt-1">{{ $kelas->where('tingkat', 12)->count() }}</p>
            </div>
            <div class="w-12 h-12 rounded-lg bg-purple-500/10 flex items-center justify-center text-purple-600">
                <i class="fas fa-school text-xl"></i>
            </div>
        </div>
    </div>

    <!-- Tabel Data -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-sm text-left text-gray-600 whitespace-nowrap">
                <thead class="bg-gray-50 text-gray-700 uppercase text-xs tracking-wider border-b border-gray-100">
                    <tr>
                        <th scope="col" class="px-6 py-4 text-center font-semibold w-16">No</th>
                        <th scope="col" class="px-6 py-4 font-semibold">Kode</th>
                        <th scope="col" class="px-6 py-4 font-semibold">Nama Kelas</th>
                        <th scope="col" class="px-6 py-4 font-semibold">Tingkat</th>
                        <th scope="col" class="px-6 py-4 font-semibold">Jurusan</th>
                        <th scope="col" class="px-6 py-4 font-semibold">Wali Kelas</th>
                        <th scope="col" class="px-6 py-4 text-center font-semibold">Total Siswa</th>
                        <th scope="col" class="px-6 py-4 text-center font-semibold w-28">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse($kelas as $i => $k)
                    <tr class="hover:bg-gray-50/70 transition-colors">
                        <td class="px-6 py-4 text-center text-gray-400 font-medium">{{ $i + 1 }}</td>
                        <td class="px-6 py-4 font-mono font-medium text-xs text-blue-600 bg-blue-50/30 rounded-md inline-block my-2 ml-4">{{ $k->kode_kelas }}</td>
                        <td class="px-6 py-4 font-semibold text-gray-900">{{ $k->nama_kelas }}</td>
                        <td class="px-6 py-4">
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800 border border-gray-200">
                                Kelas {{ $k->tingkat }}
                            </span>
                        </td>
                        <td class="px-6 py-4 text-gray-700">{{ $k->jurusan->nama_jurusan }}</td>
                        <td class="px-6 py-4 text-gray-700">
                            @if($k->waliKelas?->nama_lengkap)
                                <span class="font-medium text-gray-800">{{ $k->waliKelas->nama_lengkap }}</span>
                            @else
                                <span class="text-gray-400 italic">Belum ditentukan</span>
                            @endif
                        </td>
                        <td class="px-6 py-4 text-center">
                            <span class="inline-flex items-center px-2.5 py-1 rounded-full bg-blue-50 text-blue-700 text-xs font-bold border border-blue-100">
                                <i class="fas fa-users mr-1.5 opacity-70"></i> {{ $k->siswas->count() }} siswa
                            </span>
                        </td>
                        <td class="px-6 py-4 text-center">
                            <div class="inline-flex items-center justify-center gap-1">
                                <a href="{{ route('admin.kelas.show', $k) }}" class="p-2 text-blue-600 hover:bg-blue-50 rounded-lg transition-colors" title="Detail">
                                    <i class="fas fa-eye text-base"></i>
                                </a>
                                <a href="{{ route('admin.kelas.edit', $k) }}" class="p-2 text-amber-600 hover:bg-amber-50 rounded-lg transition-colors" title="Edit">
                                    <i class="fas fa-edit text-base"></i>
                                </a>
                                <form action="{{ route('admin.kelas.destroy', $k) }}" method="POST" class="inline-block" onsubmit="return confirm('Yakin ingin menghapus kelas ini?')">
                                    @csrf 
                                    @method('DELETE')
                                    <button type="submit" class="p-2 text-red-600 hover:bg-red-50 rounded-lg transition-colors" title="Hapus">
                                        <i class="fas fa-trash text-base"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="8" class="px-6 py-12 text-center">
                            <div class="flex flex-col items-center justify-center text-gray-400">
                                <i class="fas fa-folder-open text-4xl mb-3 opacity-40"></i>
                                <p class="text-sm font-medium">Belum ada data kelas yang terdaftar</p>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection