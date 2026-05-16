@extends('layouts.siswa')

@section('title', 'Presensi Saya')
@section('page-title', 'Riwayat Kehadiran')

@section('content')
<div class="mb-8 flex flex-col md:flex-row md:items-end justify-between gap-4">
    <div>
        <h1 class="text-2xl md:text-3xl font-bold text-gray-900 mb-1">Rekapitulasi Kehadiran</h1>
        <p class="text-sm text-gray-500">Pantau riwayat kehadiran Anda pada setiap mata pelajaran.</p>
    </div>
</div>

<!-- Statistik Cards -->
<div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-6 gap-4 mb-8">
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-5 flex flex-col items-center justify-center transition-transform hover:-translate-y-1 duration-200 group">
        <div class="w-10 h-10 rounded-full bg-green-50 text-green-600 flex items-center justify-center mb-3 group-hover:scale-110 transition-transform">
            <i data-lucide="check-circle" class="w-5 h-5"></i>
        </div>
        <p class="text-3xl font-bold text-gray-900">{{ $hadir }}</p>
        <p class="text-xs font-semibold text-gray-500 uppercase tracking-wider mt-1">Hadir</p>
    </div>
    
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-5 flex flex-col items-center justify-center transition-transform hover:-translate-y-1 duration-200 group">
        <div class="w-10 h-10 rounded-full bg-amber-50 text-amber-600 flex items-center justify-center mb-3 group-hover:scale-110 transition-transform">
            <i data-lucide="clock" class="w-5 h-5"></i>
        </div>
        <p class="text-3xl font-bold text-gray-900">{{ $terlambat }}</p>
        <p class="text-xs font-semibold text-gray-500 uppercase tracking-wider mt-1">Terlambat</p>
    </div>
    
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-5 flex flex-col items-center justify-center transition-transform hover:-translate-y-1 duration-200 group">
        <div class="w-10 h-10 rounded-full bg-yellow-50 text-yellow-600 flex items-center justify-center mb-3 group-hover:scale-110 transition-transform">
            <i data-lucide="file-text" class="w-5 h-5"></i>
        </div>
        <p class="text-3xl font-bold text-gray-900">{{ $izin }}</p>
        <p class="text-xs font-semibold text-gray-500 uppercase tracking-wider mt-1">Izin</p>
    </div>
    
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-5 flex flex-col items-center justify-center transition-transform hover:-translate-y-1 duration-200 group">
        <div class="w-10 h-10 rounded-full bg-blue-50 text-blue-600 flex items-center justify-center mb-3 group-hover:scale-110 transition-transform">
            <i data-lucide="thermometer" class="w-5 h-5"></i>
        </div>
        <p class="text-3xl font-bold text-gray-900">{{ $sakit }}</p>
        <p class="text-xs font-semibold text-gray-500 uppercase tracking-wider mt-1">Sakit</p>
    </div>
    
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-5 flex flex-col items-center justify-center transition-transform hover:-translate-y-1 duration-200 group">
        <div class="w-10 h-10 rounded-full bg-red-50 text-red-600 flex items-center justify-center mb-3 group-hover:scale-110 transition-transform">
            <i data-lucide="x-circle" class="w-5 h-5"></i>
        </div>
        <p class="text-3xl font-bold text-gray-900">{{ $alfa }}</p>
        <p class="text-xs font-semibold text-gray-500 uppercase tracking-wider mt-1">Alfa</p>
    </div>
    
    <div class="bg-gray-50 rounded-2xl border border-dashed border-gray-200 p-5 flex flex-col items-center justify-center transition-transform hover:-translate-y-1 duration-200 group">
        <div class="w-10 h-10 rounded-full bg-gray-200 text-gray-600 flex items-center justify-center mb-3 group-hover:scale-110 transition-transform">
            <i data-lucide="hash" class="w-5 h-5"></i>
        </div>
        <p class="text-3xl font-bold text-gray-900">{{ $total }}</p>
        <p class="text-xs font-semibold text-gray-500 uppercase tracking-wider mt-1">Total</p>
    </div>
</div>

<!-- Table Section -->
<div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
    <div class="p-6 border-b border-gray-100 flex flex-col sm:flex-row sm:items-center justify-between gap-4 bg-white">
        <h3 class="text-lg font-bold text-gray-800">Detail Riwayat</h3>
        
        <!-- Search & Filter (UI Only for now as requested) -->
        <form method="GET" action="{{ route('siswa.absensi.index') }}" class="flex flex-col sm:flex-row gap-2 w-full sm:w-auto">
            <div class="relative">
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                    <i data-lucide="search" class="w-4 h-4 text-gray-400"></i>
                </div>
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari mapel..." class="pl-10 w-full sm:w-64 rounded-xl border-gray-200 text-sm focus:border-blue-600 focus:ring-blue-600 bg-gray-50 focus:bg-white transition-colors">
            </div>
            <button type="submit" class="px-4 py-2 bg-gray-900 text-white rounded-xl text-sm font-semibold hover:bg-gray-800 transition-colors shadow-sm">
                Filter
            </button>
        </form>
    </div>
    
    <div class="overflow-x-auto">
        <table class="w-full text-sm text-left">
            <thead class="bg-gray-50 text-gray-500 font-semibold uppercase tracking-wider text-[11px]">
                <tr>
                    <th class="px-6 py-4 rounded-tl-lg">Tanggal</th>
                    <th class="px-6 py-4">Waktu Presensi</th>
                    <th class="px-6 py-4">Mata Pelajaran</th>
                    <th class="px-6 py-4">Guru</th>
                    <th class="px-6 py-4 text-center">Status</th>
                    <th class="px-6 py-4 rounded-tr-lg">Keterangan</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @forelse($absensis as $absensi)
                <tr class="hover:bg-blue-50/50 transition-colors group">
                    <td class="px-6 py-4 whitespace-nowrap font-medium text-gray-800">
                        {{ $absensi->tanggal?->format('d M Y') ?? '-' }}
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-gray-500">
                        <div class="flex items-center">
                            <i data-lucide="clock" class="w-3 h-3 mr-2 opacity-50 group-hover:text-blue-600"></i>
                            {{ $absensi->waktu_presensi?->format('H:i') ?? '—' }}
                        </div>
                    </td>
                    <td class="px-6 py-4 font-semibold text-gray-800">
                        {{ $absensi->jadwal->mataPelajaran->nama_mapel }}
                    </td>
                    <td class="px-6 py-4 text-gray-600">
                        <div class="flex items-center">
                            <div class="w-6 h-6 rounded-full bg-blue-100 text-blue-700 flex items-center justify-center text-[10px] font-bold mr-2 shrink-0">
                                {{ substr($absensi->guru->nama_lengkap, 0, 1) }}
                            </div>
                            <span class="truncate">{{ $absensi->guru->nama_lengkap }}</span>
                        </div>
                    </td>
                    <td class="px-6 py-4 text-center">
                        @php
                            $badgeClass = match ($absensi->status) {
                                'hadir' => 'bg-green-100 text-green-700 border-green-200',
                                'terlambat' => 'bg-amber-100 text-amber-700 border-amber-200',
                                'izin' => 'bg-yellow-100 text-yellow-700 border-yellow-200',
                                'sakit' => 'bg-blue-100 text-blue-700 border-blue-200',
                                'alfa' => 'bg-red-100 text-red-700 border-red-200',
                                default => 'bg-gray-100 text-gray-700 border-gray-200',
                            };
                        @endphp
                        <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-semibold border {{ $badgeClass }}">
                            @if($absensi->status === 'hadir') <i data-lucide="check" class="w-3 h-3 mr-1"></i>
                            @elseif($absensi->status === 'alfa') <i data-lucide="x" class="w-3 h-3 mr-1"></i>
                            @else <i data-lucide="circle" class="w-3 h-3 mr-1 fill-current"></i>
                            @endif
                            {{ ucfirst($absensi->status) }}
                        </span>
                    </td>
                    <td class="px-6 py-4 text-gray-500">
                        {{ $absensi->keterangan ?? '-' }}
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="px-6 py-12 text-center">
                        <div class="flex flex-col items-center justify-center text-gray-400">
                            <div class="w-16 h-16 bg-gray-50 rounded-full flex items-center justify-center mb-4">
                                <i data-lucide="clipboard-list" class="w-8 h-8 text-gray-300"></i>
                            </div>
                            <p class="text-base font-medium text-gray-800 mb-1">Belum Ada Riwayat Kehadiran</p>
                            <p class="text-sm text-gray-500">Data presensi Anda akan muncul di sini setelah guru memulai sesi.</p>
                        </div>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    
    @if($absensis->hasPages())
    <div class="p-6 border-t border-gray-100 bg-gray-50/50">
        {{ $absensis->links() }}
    </div>
    @endif
</div>
@endsection
