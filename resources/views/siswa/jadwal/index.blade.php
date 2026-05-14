@extends('layouts.siswa')

@section('title', 'Jadwal Pelajaran')
@section('page-title', 'Jadwal Pelajaran')

@section('content')
<div class="bg-white rounded-lg shadow">
    <div class="p-6 border-b">
        <div class="flex items-center justify-between">
            <div>
                <h3 class="text-lg font-semibold">Jadwal Pelajaran</h3>
                <p class="text-sm text-gray-500 mt-1">
                    {{ $siswa->kelas?->nama_kelas ?? '-' }} | {{ $tahunAjaran?->tahun ?? '-' }}
                </p>
            </div>
        </div>
    </div>

    <div class="p-6">
        @if($siswa->kelas)
            @foreach($hariOrder as $hari)
                @if(isset($jadwals[$hari]) && $jadwals[$hari]->count() > 0)
                <div class="mb-6">
                    <h4 class="font-medium text-blue-700 mb-3 bg-blue-50 px-4 py-2 rounded-lg">{{ $hari }}</h4>
                    <div class="overflow-x-auto">
                        <table class="w-full text-sm">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-4 py-3 text-left w-32">Jam</th>
                                    <th class="px-4 py-3 text-left">Mata Pelajaran</th>
                                    <th class="px-4 py-3 text-left">Guru</th>
                                    <th class="px-4 py-3 text-left">Ruangan</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-100">
                                @foreach($jadwals[$hari] as $jadwal)
                                <tr class="hover:bg-gray-50">
                                    <td class="px-4 py-3 font-medium text-blue-600">
                                        {{ \Carbon\Carbon::parse($jadwal->jam_mulai)->format('H:i') }} - {{ \Carbon\Carbon::parse($jadwal->jam_selesai)->format('H:i') }}
                                    </td>
                                    <td class="px-4 py-3 font-medium">{{ $jadwal->mataPelajaran->nama_mapel }}</td>
                                    <td class="px-4 py-3">{{ $jadwal->guru->nama_lengkap }}</td>
                                    <td class="px-4 py-3">{{ $jadwal->ruangan ?? '-' }}</td>
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
                <p>Belum ada jadwal pelajaran</p>
            </div>
            @endif
        @else
        <div class="text-center py-12 text-gray-500">
            <i class="fas fa-school text-5xl mb-4 text-gray-300"></i>
            <p>Anda belum ditentukan kelasnya</p>
            <p class="text-sm">Hubungi admin/tata usaha</p>
        </div>
        @endif
    </div>
</div>
@endsection