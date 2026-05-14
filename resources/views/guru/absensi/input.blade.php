@extends('layouts.guru')

@section('title', 'Input Absensi')
@section('page-title', 'Input Absensi - ' . $jadwal->mataPelajaran->nama_mapel . ' - ' . $jadwal->kelas->nama_kelas)

@section('content')
<div class="bg-white rounded-lg shadow">
    <div class="p-6 border-b">
        <div class="flex items-center justify-between">
            <div>
                <h3 class="text-lg font-semibold">Input Absensi</h3>
                <p class="text-sm text-gray-500 mt-1">
                    {{ $jadwal->mataPelajaran->nama_mapel }} | {{ $jadwal->kelas->nama_kelas }} | {{ $jadwal->hari }}
                </p>
            </div>
            <form method="GET" class="flex items-center gap-2">
                <input type="date" name="tanggal" value="{{ $tanggal }}" 
                       class="border rounded-lg px-3 py-1 text-sm" 
                       onchange="this.form.submit()">
            </form>
        </div>
    </div>

    <form action="{{ route('guru.absensi.store') }}" method="POST" class="p-6">
        @csrf
        <input type="hidden" name="jadwal_id" value="{{ $jadwal->id }}">
        <input type="hidden" name="tanggal" value="{{ $tanggal }}">

        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-4 py-3 text-left">No</th>
                        <th class="px-4 py-3 text-left">NIS</th>
                        <th class="px-4 py-3 text-left">Nama Siswa</th>
                        <th class="px-4 py-3 text-center">Status</th>
                        <th class="px-4 py-3 text-left">Keterangan</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @foreach($jadwal->kelas->siswas as $i => $siswa)
                    @php
                        $absensi = $absensis[$siswa->id] ?? null;
                    @endphp
                    <tr class="hover:bg-gray-50">
                        <td class="px-4 py-3">{{ $i + 1 }}</td>
                        <td class="px-4 py-3 font-mono">{{ $siswa->nis }}</td>
                        <td class="px-4 py-3 font-medium">{{ $siswa->nama_lengkap }}</td>
                        <td class="px-4 py-3">
                            <div class="flex justify-center gap-2">
                                <label class="cursor-pointer">
                                    <input type="radio" name="status[{{ $i }}]" value="hadir" 
                                           {{ ($absensi?->status ?? 'hadir') == 'hadir' ? 'checked' : '' }}
                                           class="peer sr-only">
                                    <span class="px-3 py-1 rounded text-xs peer-checked:bg-green-500 peer-checked:text-white bg-gray-100 text-gray-600 hover:bg-green-100">
                                        <i class="fas fa-check mr-1"></i>Hadir
                                    </span>
                                </label>
                                <label class="cursor-pointer">
                                    <input type="radio" name="status[{{ $i }}]" value="izin" 
                                           {{ ($absensi?->status) == 'izin' ? 'checked' : '' }}
                                           class="peer sr-only">
                                    <span class="px-3 py-1 rounded text-xs peer-checked:bg-yellow-500 peer-checked:text-white bg-gray-100 text-gray-600 hover:bg-yellow-100">
                                        <i class="fas fa-envelope mr-1"></i>Izin
                                    </span>
                                </label>
                                <label class="cursor-pointer">
                                    <input type="radio" name="status[{{ $i }}]" value="sakit" 
                                           {{ ($absensi?->status) == 'sakit' ? 'checked' : '' }}
                                           class="peer sr-only">
                                    <span class="px-3 py-1 rounded text-xs peer-checked:bg-blue-500 peer-checked:text-white bg-gray-100 text-gray-600 hover:bg-blue-100">
                                        <i class="fas fa-medkit mr-1"></i>Sakit
                                    </span>
                                </label>
                                <label class="cursor-pointer">
                                    <input type="radio" name="status[{{ $i }}]" value="alpha" 
                                           {{ ($absensi?->status) == 'alpha' ? 'checked' : '' }}
                                           class="peer sr-only">
                                    <span class="px-3 py-1 rounded text-xs peer-checked:bg-red-500 peer-checked:text-white bg-gray-100 text-gray-600 hover:bg-red-100">
                                        <i class="fas fa-times mr-1"></i>Alpha
                                    </span>
                                </label>
                            </div>
                        </td>
                        <td class="px-4 py-3">
                            <input type="text" name="keterangan[{{ $i }}]" 
                                   value="{{ $absensi?->keterangan ?? '' }}"
                                   class="w-full border rounded px-2 py-1 text-sm" 
                                   placeholder="Keterangan (opsional)">
                        </td>
                        <input type="hidden" name="siswa_id[{{ $i }}]" value="{{ $siswa->id }}">
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="flex justify-end gap-3 mt-6">
            <a href="{{ route('guru.absensi.index') }}" class="px-6 py-2 border rounded-lg hover:bg-gray-50">Batal</a>
            <button type="submit" class="px-6 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700">
                <i class="fas fa-save mr-2"></i>Simpan Absensi
            </button>
        </div>
    </form>
</div>
@endsection