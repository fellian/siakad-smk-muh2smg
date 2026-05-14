@extends('layouts.siswa')

@section('title', 'E-Rapor')
@section('page-title', 'E-Rapor Digital')

@section('content')
<div class="bg-white rounded-lg shadow">
    <div class="p-6 border-b flex items-center justify-between">
        <div>
            <h3 class="text-lg font-semibold">E-Rapor</h3>
            <p class="text-sm text-gray-500 mt-1">
                {{ $siswa->nama_lengkap }} | {{ $siswa->kelas?->nama_kelas ?? '-' }} | {{ $tahunAjaran?->tahun ?? '-' }}
            </p>
        </div>
        <a href="{{ route('siswa.rapor.print') }}" target="_blank" class="px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700">
            <i class="fas fa-file-pdf mr-2"></i>Cetak PDF
        </a>
    </div>

    <div class="p-6">
        <!-- Header Rapor -->
        <div class="text-center border-b pb-6 mb-6">
            <h2 class="text-2xl font-bold">RAPOR PESERTA DIDIK</h2>
            <h3 class="text-lg">SMK MUHAMMADIYAH 2 SEMARANG</h3>
            <p class="text-sm text-gray-500">Tahun Ajaran {{ $tahunAjaran?->tahun ?? '-' }} - Semester {{ $tahunAjaran?->semester ?? '-' }}</p>
        </div>

        <!-- Data Siswa -->
        <div class="grid grid-cols-2 gap-4 mb-6 text-sm">
            <div>
                <p><span class="w-32 inline-block">Nama</span>: <strong>{{ $siswa->nama_lengkap }}</strong></p>
                <p><span class="w-32 inline-block">NIS / NISN</span>: {{ $siswa->nis }} / {{ $siswa->nisn ?? '-' }}</p>
                <p><span class="w-32 inline-block">Kelas</span>: {{ $siswa->kelas?->nama_kelas ?? '-' }}</p>
            </div>
            <div>
                <p><span class="w-32 inline-block">Jurusan</span>: {{ $siswa->kelas?->jurusan->nama_jurusan ?? '-' }}</p>
                <p><span class="w-32 inline-block">Wali Kelas</span>: {{ $siswa->kelas?->waliKelas?->nama_lengkap ?? '-' }}</p>
            </div>
        </div>

        <!-- Nilai -->
        @forelse($nilais->groupBy('semester') as $semester => $nilaiList)
        <div class="mb-6">
            <h4 class="font-semibold mb-3">Semester {{ $semester }}</h4>
            <div class="overflow-x-auto">
                <table class="w-full text-sm border">
                    <thead class="bg-gray-100">
                        <tr>
                            <th class="px-3 py-2 border text-left">No</th>
                            <th class="px-3 py-2 border text-left">Mata Pelajaran</th>
                            <th class="px-3 py-2 border text-center">KKM</th>
                            <th class="px-3 py-2 border text-center">Nilai</th>
                            <th class="px-3 py-2 border text-center">Predikat</th>
                            <th class="px-3 py-2 border text-center">Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($nilaiList as $i => $nilai)
                        <tr>
                            <td class="px-3 py-2 border">{{ $i + 1 }}</td>
                            <td class="px-3 py-2 border">{{ $nilai->mataPelajaran->nama_mapel }}</td>
                            <td class="px-3 py-2 border text-center">{{ $nilai->mataPelajaran->kkm }}</td>
                            <td class="px-3 py-2 border text-center font-bold">{{ number_format($nilai->nilai_akhir, 2) }}</td>
                            <td class="px-3 py-2 border text-center">{{ $nilai->predikat }}</td>
                            <td class="px-3 py-2 border text-center">
                                @if($nilai->nilai_akhir >= $nilai->mataPelajaran->kkm)
                                    <span class="text-green-600">Tuntas</span>
                                @else
                                    <span class="text-red-600">Remedial</span>
                                @endif
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        @empty
        <div class="text-center py-8 text-gray-500">
            <p>Belum ada data nilai</p>
        </div>
        @endforelse

        <!-- Ringkasan -->
        @if($nilais->count() > 0)
        <div class="grid grid-cols-2 gap-6 mt-6">
            <div class="border rounded-lg p-4">
                <h5 class="font-semibold mb-3">Kehadiran</h5>
                <div class="space-y-2 text-sm">
                    <div class="flex justify-between"><span>Hadir</span><span class="font-medium">{{ $absensiData['hadir'] }}</span></div>
                    <div class="flex justify-between"><span>Izin</span><span class="font-medium">{{ $absensiData['izin'] }}</span></div>
                    <div class="flex justify-between"><span>Sakit</span><span class="font-medium">{{ $absensiData['sakit'] }}</span></div>
                    <div class="flex justify-between"><span>Alpha</span><span class="font-medium">{{ $absensiData['alpha'] }}</span></div>
                </div>
            </div>
            <div class="border rounded-lg p-4">
                <h5 class="font-semibold mb-3">Rata-rata Nilai</h5>
                <p class="text-4xl font-bold text-blue-600">{{ number_format($rataRata, 2) }}</p>
                <p class="text-sm text-gray-500 mt-1">Dari {{ $nilais->count() }} mata pelajaran</p>
            </div>
        </div>
        @endif

        <!-- TTD -->
        <div class="mt-12 grid grid-cols-2 gap-8 text-center text-sm">
            <div>
                <p>Orang Tua / Wali</p>
                <div class="h-20"></div>
                <p class="font-medium">(_________________)</p>
            </div>
            <div>
                <p>Wali Kelas</p>
                <div class="h-20"></div>
                <p class="font-medium">{{ $siswa->kelas?->waliKelas?->nama_lengkap ?? '(_________________)' }}</p>
            </div>
        </div>
    </div>
</div>
@endsection