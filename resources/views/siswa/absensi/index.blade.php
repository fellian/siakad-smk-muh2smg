@extends('layouts.siswa')

@section('title', 'Presensi Saya')
@section('page-title', 'Riwayat Kehadiran')

@section('content')
<!-- Ringkasan -->
<div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-6">
    <div class="bg-white rounded-lg shadow p-4 text-center">
        <p class="text-3xl font-bold text-green-600">{{ $hadir }}</p>
        <p class="text-sm text-gray-500">Hadir</p>
    </div>
    <div class="bg-white rounded-lg shadow p-4 text-center">
        <p class="text-3xl font-bold text-yellow-600">{{ $izin }}</p>
        <p class="text-sm text-gray-500">Izin</p>
    </div>
    <div class="bg-white rounded-lg shadow p-4 text-center">
        <p class="text-3xl font-bold text-blue-600">{{ $sakit }}</p>
        <p class="text-sm text-gray-500">Sakit</p>
    </div>
    <div class="bg-white rounded-lg shadow p-4 text-center">
        <p class="text-3xl font-bold text-red-600">{{ $alpha }}</p>
        <p class="text-sm text-gray-500">Alpha</p>
    </div>
</div>

<div class="bg-white rounded-lg shadow">
    <div class="p-6 border-b">
        <h3 class="text-lg font-semibold">Detail Kehadiran</h3>
    </div>
    <div class="p-6">
        @if($absensis->count() > 0)
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-4 py-3 text-left">Tanggal</th>
                        <th class="px-4 py-3 text-left">Mata Pelajaran</th>
                        <th class="px-4 py-3 text-left">Guru</th>
                        <th class="px-4 py-3 text-center">Status</th>
                        <th class="px-4 py-3 text-left">Keterangan</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @foreach($absensis as $absensi)
                    <tr class="hover:bg-gray-50">
                        <td class="px-4 py-3">{{ $absensi->tanggal?->format('d F Y') ?? '-' }}</td>
                        <td class="px-4 py-3">{{ $absensi->jadwal->mataPelajaran->nama_mapel }}</td>
                        <td class="px-4 py-3">{{ $absensi->guru->nama_lengkap }}</td>
                        <td class="px-4 py-3 text-center">
                            <span class="px-2 py-1 rounded text-xs font-medium {{ $absensi->status == 'hadir' ? 'bg-green-100 text-green-700' : ($absensi->status == 'izin' ? 'bg-yellow-100 text-yellow-700' : ($absensi->status == 'sakit' ? 'bg-blue-100 text-blue-700' : 'bg-red-100 text-red-700')) }}">
                                {{ ucfirst($absensi->status) }}
                            </span>
                        </td>
                        <td class="px-4 py-3 text-gray-500">{{ $absensi->keterangan ?? '-' }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="mt-4">{{ $absensis->links() }}</div>
        @else
        <div class="text-center py-12 text-gray-500">
            <i class="fas fa-clipboard-check text-5xl mb-4 text-gray-300"></i>
            <p>Belum ada data absensi</p>
        </div>
        @endif
    </div>
</div>
@endsection