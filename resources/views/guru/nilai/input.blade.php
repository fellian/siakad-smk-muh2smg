@extends('layouts.guru')

@section('title', 'Input Nilai')
@section('page-title', 'Input Nilai - ' . $mapel->nama_mapel . ' - ' . $kelas->nama_kelas)

@section('content')
<div class="bg-white rounded-lg shadow">
    <div class="p-6 border-b">
        <div class="flex items-center justify-between">
            <div>
                <h3 class="text-lg font-semibold">Input Nilai</h3>
                <p class="text-sm text-gray-500 mt-1">
                    {{ $mapel->nama_mapel }} | {{ $kelas->nama_kelas }} | Semester {{ $semester }} | {{ $tahunAjaran?->tahun }}
                </p>
            </div>
            <form method="GET" class="flex items-center gap-2">
                <input type="hidden" name="kelas_id" value="{{ $kelas->id }}">
                <input type="hidden" name="mapel_id" value="{{ $mapel->id }}">
                <select name="semester" class="border rounded-lg px-3 py-1 text-sm" onchange="this.form.submit()">
                    <option value="1" {{ $semester == '1' ? 'selected' : '' }}>Semester 1</option>
                    <option value="2" {{ $semester == '2' ? 'selected' : '' }}>Semester 2</option>
                </select>
            </form>
        </div>
    </div>

    <form action="{{ route('guru.nilai.store') }}" method="POST" class="p-6">
        @csrf
        <input type="hidden" name="kelas_id" value="{{ $kelas->id }}">
        <input type="hidden" name="mata_pelajaran_id" value="{{ $mapel->id }}">
        <input type="hidden" name="semester" value="{{ $semester }}">

        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-4 py-3 text-left">No</th>
                        <th class="px-4 py-3 text-left">NIS</th>
                        <th class="px-4 py-3 text-left">Nama Siswa</th>
                        <th class="px-4 py-3 text-center w-24">Tugas<br><span class="text-xs font-normal text-gray-500">20%</span></th>
                        <th class="px-4 py-3 text-center w-24">Ulangan<br><span class="text-xs font-normal text-gray-500">20%</span></th>
                        <th class="px-4 py-3 text-center w-24">UTS<br><span class="text-xs font-normal text-gray-500">25%</span></th>
                        <th class="px-4 py-3 text-center w-24">UAS<br><span class="text-xs font-normal text-gray-500">35%</span></th>
                        <th class="px-4 py-3 text-center">Nilai Akhir</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @foreach($siswas as $i => $siswa)
                    @php
                        $nilai = $nilais[$siswa->id] ?? null;
                        $na = $nilai?->nilai_akhir ?? 0;
                    @endphp
                    <tr class="hover:bg-gray-50">
                        <td class="px-4 py-3">{{ $i + 1 }}</td>
                        <td class="px-4 py-3 font-mono">{{ $siswa->nis }}</td>
                        <td class="px-4 py-3 font-medium">{{ $siswa->nama_lengkap }}</td>
                        <td class="px-4 py-3">
                            <input type="number" name="nilai_tugas[]" min="0" max="100" 
                                   value="{{ old('nilai_tugas.'.$i, $nilai?->nilai_tugas ?? 0) }}"
                                   class="w-full border rounded px-2 py-1 text-center focus:ring-2 focus:ring-blue-500">
                        </td>
                        <td class="px-4 py-3">
                            <input type="number" name="nilai_ulangan[]" min="0" max="100" 
                                   value="{{ old('nilai_ulangan.'.$i, $nilai?->nilai_ulangan ?? 0) }}"
                                   class="w-full border rounded px-2 py-1 text-center focus:ring-2 focus:ring-blue-500">
                        </td>
                        <td class="px-4 py-3">
                            <input type="number" name="nilai_uts[]" min="0" max="100" 
                                   value="{{ old('nilai_uts.'.$i, $nilai?->nilai_uts ?? 0) }}"
                                   class="w-full border rounded px-2 py-1 text-center focus:ring-2 focus:ring-blue-500">
                        </td>
                        <td class="px-4 py-3">
                            <input type="number" name="nilai_uas[]" min="0" max="100" 
                                   value="{{ old('nilai_uas.'.$i, $nilai?->nilai_uas ?? 0) }}"
                                   class="w-full border rounded px-2 py-1 text-center focus:ring-2 focus:ring-blue-500">
                        </td>
                        <td class="px-4 py-3 text-center">
                            @if($nilai)
                                <span class="px-2 py-1 rounded text-xs font-bold {{ $na >= 75 ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700' }}">
                                    {{ number_format($na, 2) }}
                                </span>
                                <span class="block text-xs text-gray-500 mt-1">{{ $nilai->predikat }}</span>
                            @else
                                <span class="text-gray-400">-</span>
                            @endif
                        </td>
                        <input type="hidden" name="siswa_id[]" value="{{ $siswa->id }}">
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="flex justify-end gap-3 mt-6">
            <a href="{{ route('guru.nilai.index') }}" class="px-6 py-2 border rounded-lg hover:bg-gray-50">Batal</a>
            <button type="submit" class="px-6 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">
                <i class="fas fa-save mr-2"></i>Simpan Nilai
            </button>
        </div>
    </form>
</div>
@endsection