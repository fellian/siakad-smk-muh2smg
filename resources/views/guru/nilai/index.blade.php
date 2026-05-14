@extends('layouts.guru')

@section('title', 'Input Nilai')
@section('page-title', 'Input Nilai Siswa')

@section('content')
<div class="bg-white rounded-lg shadow">
    <div class="p-6 border-b">
        <h3 class="text-lg font-semibold">Pilih Kelas & Mata Pelajaran</h3>
        <p class="text-sm text-gray-500 mt-1">Tahun Ajaran: {{ $tahunAjaran?->tahun ?? '-' }} - Semester {{ $tahunAjaran?->semester ?? '-' }}</p>
    </div>
    <div class="p-6">
        @if($kelasDiampu->count() > 0)
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
            @foreach($kelasDiampu as $jadwal)
            <div class="border rounded-lg p-4 hover:shadow-md transition-shadow">
                <div class="flex items-center justify-between mb-3">
                    <span class="px-2 py-1 bg-blue-100 text-blue-700 rounded text-xs">{{ $jadwal->kelas->nama_kelas }}</span>
                    <span class="text-xs text-gray-500">{{ $jadwal->hari }}</span>
                </div>
                <h4 class="font-medium mb-1">{{ $jadwal->mataPelajaran->nama_mapel }}</h4>
                <p class="text-sm text-gray-500 mb-3">{{ $jadwal->kelas->jurusan->nama_jurusan }}</p>
                
                <div class="flex gap-2">
                    <a href="{{ route('guru.nilai.input', ['kelas_id' => $jadwal->kelas_id, 'mapel_id' => $jadwal->mata_pelajaran_id]) }}" class="flex-1 text-center px-3 py-2 bg-blue-600 text-white rounded-lg text-sm hover:bg-blue-700">
                        <i class="fas fa-pen mr-1"></i>Input Nilai
                    </a>
                    <a href="{{ route('guru.nilai.rekap', $jadwal->kelas_id) }}" class="px-3 py-2 bg-gray-100 text-gray-700 rounded-lg text-sm hover:bg-gray-200">
                        <i class="fas fa-list mr-1"></i>Rekap
                    </a>
                </div>
            </div>
            @endforeach
        </div>
        @else
        <div class="text-center py-12 text-gray-500">
            <i class="fas fa-book-open text-5xl mb-4 text-gray-300"></i>
            <p>Anda belum memiliki jadwal mengajar</p>
        </div>
        @endif
    </div>
</div>
@endsection