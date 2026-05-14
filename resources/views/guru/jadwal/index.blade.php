@extends('layouts.guru')

@section('title', 'Jadwal Mengajar')
@section('page-title', 'Jadwal Mengajar Saya')

@section('content')
<div class="bg-white rounded-lg shadow">
    <div class="p-6 border-b">
        <h3 class="text-lg font-semibold">Jadwal Pelajaran</h3>
    </div>
    <div class="p-6">
        @foreach($hariOrder as $hari)
            @if(isset($jadwals[$hari]) && $jadwals[$hari]->count() > 0)
            <div class="mb-6">
                <h4 class="font-medium text-blue-700 mb-3 bg-blue-50 px-4 py-2 rounded-lg">{{ $hari }}</h4>
                <div class="overflow-x-auto">
                    <table class="w-full text-sm">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-4 py-3 text-left">Jam</th>
                                <th class="px-4 py-3 text-left">Kelas</th>
                                <th class="px-4 py-3 text-left">Mata Pelajaran</th>
                                <th class="px-4 py-3 text-left">Ruangan</th>
                                <th class="px-4 py-3 text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                            @foreach($jadwals[$hari]->sortBy('jam_mulai') as $jadwal)
                            <tr class="hover:bg-gray-50">
                                <td class="px-4 py-3 font-medium">
                                    {{ \Carbon\Carbon::parse($jadwal->jam_mulai)->format('H:i') }} - {{ \Carbon\Carbon::parse($jadwal->jam_selesai)->format('H:i') }}
                                </td>
                                <td class="px-4 py-3">
                                    <span class="px-2 py-1 bg-blue-100 text-blue-700 rounded text-xs">{{ $jadwal->kelas->nama_kelas }}</span>
                                </td>
                                <td class="px-4 py-3">{{ $jadwal->mataPelajaran->nama_mapel }}</td>
                                <td class="px-4 py-3">{{ $jadwal->ruangan ?? '-' }}</td>
                                <td class="px-4 py-3 text-center">
                                    <a href="{{ route('guru.absensi.input', $jadwal->id) }}" class="px-3 py-1 bg-green-100 text-green-700 rounded text-xs hover:bg-green-200 mr-1">
                                        <i class="fas fa-clipboard-check mr-1"></i>Absen
                                    </a>
                                    <a href="{{ route('guru.nilai.input', ['kelas_id' => $jadwal->kelas_id, 'mapel_id' => $jadwal->mata_pelajaran_id]) }}" class="px-3 py-1 bg-blue-100 text-blue-700 rounded text-xs hover:bg-blue-200">
                                        <i class="fas fa-pen mr-1"></i>Nilai
                                    </a>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            @endif
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