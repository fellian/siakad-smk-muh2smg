@extends('layouts.siswa')

@section('title', 'Nilai Saya')
@section('page-title', 'Nilai Akademik')

@section('content')
<div class="bg-white rounded-lg shadow">
    <div class="p-6 border-b">
        <div class="flex items-center justify-between">
            <div>
                <h3 class="text-lg font-semibold">Nilai Akademik</h3>
                <p class="text-sm text-gray-500 mt-1">
                    {{ $siswa->nama_lengkap }} | {{ $siswa->kelas?->nama_kelas ?? '-' }} | {{ $tahunAjaran?->tahun ?? '-' }}
                </p>
            </div>
            <a href="{{ route('siswa.rapor.index') }}" class="px-4 py-2 bg-purple-600 text-white rounded-lg text-sm hover:bg-purple-700">
                <i class="fas fa-file-alt mr-2"></i>Lihat E-Rapor
            </a>
        </div>
    </div>

    <div class="p-6">
        @forelse($nilais as $semester => $nilaiList)
        <div class="mb-8">
            <div class="flex items-center justify-between mb-4">
                <h4 class="font-semibold text-lg">Semester {{ $semester }}</h4>
                <span class="px-3 py-1 bg-blue-100 text-blue-700 rounded-full text-sm">
                    Rata-rata: {{ number_format($rataRataPerSemester[$semester], 2) }}
                </span>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full text-sm">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-4 py-3 text-left">No</th>
                            <th class="px-4 py-3 text-left">Mata Pelajaran</th>
                            <th class="px-4 py-3 text-left">Guru</th>
                            <th class="px-4 py-3 text-center">Tugas</th>
                            <th class="px-4 py-3 text-center">Ulangan</th>
                            <th class="px-4 py-3 text-center">UTS</th>
                            <th class="px-4 py-3 text-center">UAS</th>
                            <th class="px-4 py-3 text-center">Nilai Akhir</th>
                            <th class="px-4 py-3 text-center">Predikat</th>
                            <th class="px-4 py-3 text-center">Status</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @foreach($nilaiList as $i => $nilai)
                        <tr class="hover:bg-gray-50">
                            <td class="px-4 py-3">{{ $i + 1 }}</td>
                            <td class="px-4 py-3 font-medium">{{ $nilai->mataPelajaran->nama_mapel }}</td>
                            <td class="px-4 py-3 text-sm">{{ $nilai->guru->nama_lengkap }}</td>
                            <td class="px-4 py-3 text-center">{{ $nilai->nilai_tugas }}</td>
                            <td class="px-4 py-3 text-center">{{ $nilai->nilai_ulangan }}</td>
                            <td class="px-4 py-3 text-center">{{ $nilai->nilai_uts }}</td>
                            <td class="px-4 py-3 text-center">{{ $nilai->nilai_uas }}</td>
                            <td class="px-4 py-3 text-center font-bold {{ $nilai->nilai_akhir >= 75 ? 'text-green-600' : 'text-red-600' }}">
                                {{ number_format($nilai->nilai_akhir, 2) }}
                            </td>
                            <td class="px-4 py-3 text-center">
                                <span class="px-2 py-1 rounded text-xs font-bold {{ $nilai->predikat == 'A' ? 'bg-green-100 text-green-700' : ($nilai->predikat == 'B' ? 'bg-blue-100 text-blue-700' : ($nilai->predikat == 'C' ? 'bg-yellow-100 text-yellow-700' : 'bg-red-100 text-red-700')) }}">
                                    {{ $nilai->predikat }}
                                </span>
                            </td>
                            <td class="px-4 py-3 text-center">
                                @if($nilai->nilai_akhir >= $nilai->mataPelajaran->kkm)
                                    <span class="px-2 py-1 bg-green-100 text-green-700 rounded text-xs">Tuntas</span>
                                @else
                                    <span class="px-2 py-1 bg-red-100 text-red-700 rounded text-xs">Remedial</span>
                                @endif
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        @empty
        <div class="text-center py-12 text-gray-500">
            <i class="fas fa-chart-line text-5xl mb-4 text-gray-300"></i>
            <p>Belum ada data nilai</p>
            <p class="text-sm">Nilai akan muncul setelah guru menginputkan nilai Anda</p>
        </div>
        @endforelse
    </div>
</div>
@endsection