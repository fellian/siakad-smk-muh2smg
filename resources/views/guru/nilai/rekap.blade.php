@extends('layouts.guru')

@section('title', 'Rekap Nilai')
@section('page-title', 'Rekap Nilai - ' . $kelas->nama_kelas)

@section('content')
<div class="flex justify-between items-center mb-4 print:hidden">
    <a href="{{ route('guru.nilai.index') }}" class="px-4 py-2 border rounded-lg bg-white text-gray-700 hover:bg-gray-50 text-sm flex items-center">
        <i class="fas fa-arrow-left mr-2"></i> Kembali
    </a>
</div>

@if($nilais->count() > 0)
@php
    $allNa = $nilais->pluck('nilai_akhir')->toArray();
    $rataRata = count($allNa) > 0 ? array_sum($allNa) / count($allNa) : 0;
    $tertinggi = count($allNa) > 0 ? max($allNa) : 0;
    $terendah = count($allNa) > 0 ? min($allNa) : 0;
@endphp
<div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6 print:hidden">
    <div class="bg-white p-4 rounded-lg shadow border-l-4 border-blue-500">
        <div class="text-sm font-medium text-gray-500">Rata-rata Kelas</div>
        <div class="text-2xl font-bold text-gray-800 mt-1">{{ number_format($rataRata, 2) }}</div>
    </div>
    <div class="bg-white p-4 rounded-lg shadow border-l-4 border-green-500">
        <div class="text-sm font-medium text-gray-500">Nilai Tertinggi</div>
        <div class="text-2xl font-bold text-gray-800 mt-1">{{ number_format($tertinggi, 2) }}</div>
    </div>
    <div class="bg-white p-4 rounded-lg shadow border-l-4 border-red-500">
        <div class="text-sm font-medium text-gray-500">Nilai Terendah</div>
        <div class="text-2xl font-bold text-gray-800 mt-1">{{ number_format($terendah, 2) }}</div>
    </div>
</div>
@endif

<div class="bg-white rounded-lg shadow p-6 md:p-8 print:shadow-none print:p-0">
    <div class="hidden print:block text-center border-b-2 border-gray-800 pb-4 mb-6">
        <h2 class="text-2xl font-bold uppercase">Laporan Rekapitulasi Nilai Siswa</h2>
        <p class="text-sm mt-1">Tahun Ajaran: {{ $tahunAjaran?->tahun ?? '-' }} | Semester {{ $semester ?? '-' }}</p>
    </div>

    <div class="flex flex-col md:flex-row md:justify-between md:items-center mb-6 gap-2">
        <div>
            <h3 class="text-lg font-semibold text-gray-800">Rekapitulasi Nilai Akhir</h3>
            <p class="text-sm text-gray-500 mt-1">
                {{ $mapel->nama_mapel }} | {{ $kelas->nama_kelas }} ({{ $kelas->jurusan->nama_jurusan }})
            </p>
        </div>
        <div class="text-left md:text-right text-sm text-gray-600">
            <p><strong>Tahun Ajaran:</strong> {{ $tahunAjaran?->tahun ?? '-' }}</p>
            <p><strong>Semester:</strong> {{ $semester ?? '-' }}</p>
        </div>
    </div>

    <div class="overflow-x-auto">
        <table class="w-full text-sm border-collapse print:text-xs">
            <thead class="bg-gray-50 print:bg-transparent">
                <tr class="border-b-2 border-gray-200">
                    <th class="px-4 py-3 text-left w-12">No</th>
                    <th class="px-4 py-3 text-left w-28">NIS</th>
                    <th class="px-4 py-3 text-left">Nama Siswa</th>
                    <th class="px-4 py-3 text-center w-20">Tugas<br><span class="text-xs font-normal text-gray-400 print:hidden">20%</span></th>
                    <th class="px-4 py-3 text-center w-20">Ulangan<br><span class="text-xs font-normal text-gray-400 print:hidden">20%</span></th>
                    <th class="px-4 py-3 text-center w-20">UTS<br><span class="text-xs font-normal text-gray-400 print:hidden">25%</span></th>
                    <th class="px-4 py-3 text-center w-20">UAS<br><span class="text-xs font-normal text-gray-400 print:hidden">35%</span></th>
                    <th class="px-4 py-3 text-center w-24">Nilai Akhir</th>
                    <th class="px-4 py-3 text-center w-20">Predikat</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @forelse($siswas as $i => $siswa)
                @php
                    $nilai = $nilais->firstWhere('siswa_id', $siswa->id);
                    $na = $nilai?->nilai_akhir ?? 0;
                @endphp
                <tr class="hover:bg-gray-50 {{ $na < 75 && $nilai ? 'bg-red-50/50 print:bg-transparent' : '' }}">
                    <td class="px-4 py-3 text-gray-600">{{ $i + 1 }}</td>
                    <td class="px-4 py-3 font-mono text-gray-700">{{ $siswa->nis }}</td>
                    <td class="px-4 py-3 font-medium text-gray-900">{{ $siswa->nama_lengkap }}</td>
                    <td class="px-4 py-3 text-center">{{ $nilai?->nilai_tugas ?? '-' }}</td>
                    <td class="px-4 py-3 text-center">{{ $nilai?->nilai_ulangan ?? '-' }}</td>
                    <td class="px-4 py-3 text-center">{{ $nilai?->nilai_uts ?? '-' }}</td>
                    <td class="px-4 py-3 text-center">{{ $nilai?->nilai_uas ?? '-' }}</td>
                    <td class="px-4 py-3 text-center font-semibold">
                        @if($nilai)
                            <span class="print:text-black {{ $na >= 75 ? 'text-green-600' : 'text-red-600' }}">
                                {{ number_format($na, 2) }}
                            </span>
                        @else
                            <span class="text-gray-400">-</span>
                        @endif
                    </td>
                    <td class="px-4 py-3 text-center font-bold text-gray-700">
                        {{ $nilai?->predikat ?? '-' }}
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="9" class="text-center py-8 text-gray-500">
                        Belum ada data siswa atau nilai di kelas ini.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection