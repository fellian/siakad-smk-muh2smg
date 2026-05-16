@extends('layouts.guru')

@section('title', 'Rekap Presensi')
@section('page-title', 'Rekap Sesi Presensi')

@section('content')
<div class="bg-white rounded-lg shadow">
    <div class="p-6 border-b flex flex-col md:flex-row md:items-center md:justify-between gap-4">
        <div>
            <h3 class="text-lg font-semibold">Riwayat sesi per mata pelajaran</h3>
        </div>
        <a href="{{ route('guru.absensi.index') }}" class="text-sm font-semibold text-blue-700 hover:underline">&larr; Kembali ke presensi</a>
    </div>
    <div class="p-6 overflow-x-auto">
        <table class="w-full text-sm">
            <thead class="bg-gray-50 border-b">
                <tr>
                    <th class="text-left px-4 py-3 font-semibold text-gray-600">Tanggal</th>
                    <th class="text-left px-4 py-3 font-semibold text-gray-600">Mapel</th>
                    <th class="text-left px-4 py-3 font-semibold text-gray-600">Kelas</th>
                    <th class="text-left px-4 py-3 font-semibold text-gray-600">Jam</th>
                    <th class="text-left px-4 py-3 font-semibold text-gray-600">Status</th>
                    <th class="text-center px-4 py-3 font-semibold text-gray-600">Rekam</th>
                    <th class="text-right px-4 py-3 font-semibold text-gray-600">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @forelse($sesis as $sesiRow)
                    @php
                        $j = $sesiRow->jadwal;
                    @endphp
                    <tr class="hover:bg-gray-50">
                        <td class="px-4 py-3 whitespace-nowrap">{{ $sesiRow->tanggal->translatedFormat('d M Y') }}</td>
                        <td class="px-4 py-3">{{ $j->mataPelajaran->nama_mapel }}</td>
                        <td class="px-4 py-3">{{ $j->kelas->nama_kelas }}</td>
                        <td class="px-4 py-3">{{ \Carbon\Carbon::parse($j->jam_mulai)->format('H:i') }} – {{ \Carbon\Carbon::parse($j->jam_selesai)->format('H:i') }}</td>
                        <td class="px-4 py-3">
                            @if($sesiRow->aktif())
                                <span class="text-xs font-bold px-2 py-1 rounded-full bg-green-100 text-green-800">Aktif</span>
                            @else
                                <span class="text-xs font-semibold px-2 py-1 rounded-full bg-gray-100 text-gray-700">Ditutup</span>
                            @endif
                        </td>
                        <td class="px-4 py-3 text-center">{{ $sesiRow->jumlah_records }}</td>
                        <td class="px-4 py-3 text-right">
                            <a href="{{ route('guru.absensi.sesi.show', $sesiRow) }}" class="text-blue-700 font-semibold hover:underline">Detail</a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="px-4 py-12 text-center text-gray-500">
                            Belum ada sesi presensi yang tercatat.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
        <div class="mt-4">{{ $sesis->links() }}</div>
    </div>
</div>
@endsection
