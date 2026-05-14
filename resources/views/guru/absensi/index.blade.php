@extends('layouts.guru')

@section('title', 'Presensi Siswa')
@section('page-title', 'Presensi Siswa')

@section('content')
<div class="bg-white rounded-lg shadow">
    <div class="p-6 border-b">
        <h3 class="text-lg font-semibold">Pilih Jadwal untuk Input Absensi</h3>
    </div>
    <div class="p-6">
        @php
            $hariOrder = ['Senin' => 1, 'Selasa' => 2, 'Rabu' => 3, 'Kamis' => 4, 'Jumat' => 5, 'Sabtu' => 6];
            $jadwalGrouped = $jadwals->groupBy('hari')->sortBy(function($items, $key) use ($hariOrder) {
                return $hariOrder[$key] ?? 99;
            });
        @endphp

        @foreach($jadwalGrouped as $hari => $jadwalHari)
        <div class="mb-6">
            <h4 class="font-medium text-blue-700 mb-3 bg-blue-50 px-4 py-2 rounded-lg">{{ $hari }}</h4>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                @foreach($jadwalHari as $jadwal)
                <div class="border rounded-lg p-4 hover:shadow-md transition-shadow">
                    <div class="flex items-center justify-between mb-2">
                        <span class="text-sm font-medium">{{ \Carbon\Carbon::parse($jadwal->jam_mulai)->format('H:i') }} - {{ \Carbon\Carbon::parse($jadwal->jam_selesai)->format('H:i') }}</span>
                        <span class="px-2 py-1 bg-blue-100 text-blue-700 rounded text-xs">{{ $jadwal->kelas->nama_kelas }}</span>
                    </div>
                    <p class="font-medium mb-1">{{ $jadwal->mataPelajaran->nama_mapel }}</p>
                    <p class="text-sm text-gray-500 mb-3">Ruang {{ $jadwal->ruangan ?? '-' }}</p>
                    <a href="{{ route('guru.absensi.input', $jadwal->id) }}" class="block text-center px-3 py-2 bg-green-600 text-white rounded-lg text-sm hover:bg-green-700">
                        <i class="fas fa-clipboard-check mr-1"></i>Input Absensi
                    </a>
                </div>
                @endforeach
            </div>
        </div>
        @endforeach

        @if($jadwals->count() == 0)
        <div class="text-center py-12 text-gray-500">
            <i class="fas fa-calendar-times text-5xl mb-4 text-gray-300"></i>
            <p>Belum ada jadwal mengajar</p>
        </div>
        @endif
    </div>
</div>
@endsection