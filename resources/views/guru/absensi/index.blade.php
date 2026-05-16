@extends('layouts.guru')

@section('title', 'Presensi Siswa')
@section('page-title', 'Presensi Siswa')

@section('content')
<div class="space-y-8">
    <div class="bg-white rounded-lg shadow">
        <div class="p-6 border-b flex flex-col md:flex-row md:items-center md:justify-between gap-4">
            <div>
                <h3 class="text-lg font-semibold">Jadwal hari ini — {{ $hariIni }}</h3>
            </div>
            <div class="flex gap-2">
                <a href="{{ route('guru.absensi.rekap') }}" class="inline-flex items-center px-4 py-2 border border-blue-200 text-blue-800 rounded-lg text-sm font-semibold hover:bg-blue-50">
                    <i class="fas fa-table mr-2"></i> Rekap sesi
                </a>
            </div>
        </div>
        <div class="p-6">
            @forelse($jadwalHariIni as $jadwal)
                @php
                    $sesiBuka = $sesiAktifHariIni[$jadwal->id] ?? null;
                    $mulaiLabel = \Carbon\Carbon::parse($jadwal->jam_mulai)->format('H:i');
                    $selesaiLabel = \Carbon\Carbon::parse($jadwal->jam_selesai)->format('H:i');
                @endphp
                <div class="mb-4 border rounded-xl overflow-hidden flex flex-col sm:flex-row">
                    <div class="sm:w-32 bg-blue-800 text-white flex flex-col justify-center items-center py-6 px-3">
                        <span class="text-lg font-bold">{{ $mulaiLabel }}</span>
                        <span class="text-xs text-blue-100">{{ $selesaiLabel }}</span>
                    </div>
                    <div class="flex-1 p-5 flex flex-col md:flex-row md:items-center md:justify-between gap-4 bg-white">
                        <div class="flex-1">
                            <span class="text-xs uppercase tracking-wide font-bold text-blue-700">{{ $jadwal->kelas->nama_kelas }}</span>
                            <h4 class="text-xl font-semibold text-gray-900">{{ $jadwal->mataPelajaran->nama_mapel }}</h4>
                            <p class="text-sm text-gray-500">{{ $jadwal->ruangan ? 'Ruangan '.$jadwal->ruangan : 'Tanpa Ruangan Tetap' }}</p>
                            @if($sesiBuka)
                                <p class="text-sm mt-2 text-green-700 font-medium"><i class="fas fa-door-open mr-1"></i> Sesi presensi sedang dibuka sejak {{ $sesiBuka->dibuka_at->format('H:i') }}</p>
                            @endif
                        </div>
                        <div class="flex flex-wrap gap-2">
                            @if($sesiBuka)
                                <a href="{{ route('guru.absensi.sesi.show', $sesiBuka) }}" class="inline-flex items-center px-5 py-2.5 bg-blue-700 text-white font-semibold rounded-lg hover:bg-blue-800 text-sm shadow-sm">
                                    <i class="fas fa-sliders-h mr-2"></i> Kelola sesi
                                </a>
                            @else
                                <form action="{{ route('guru.absensi.sesi.mulai', $jadwal) }}" method="POST" onsubmit="return confirm('Buka sesi presensi untuk {{ $jadwal->mataPelajaran->nama_mapel }}?');">
                                    @csrf
                                    <button type="submit" class="inline-flex items-center px-5 py-2.5 border border-blue-800 text-blue-800 font-semibold rounded-lg hover:bg-blue-50 text-sm">
                                        <i class="fas fa-user-check mr-2"></i> Mulai Presensi
                                    </button>
                                </form>
                            @endif
                        </div>
                    </div>
                </div>
            @empty
                <div class="text-center py-12 border border-dashed border-gray-200 rounded-xl bg-gray-50 text-gray-500">
                    <i class="fas fa-mug-hot text-4xl mb-3 text-gray-300"></i>
                    <p>Anda tidak memiliki jam mengajar untuk hari <strong>{{ $hariIni }}</strong>.</p>
                </div>
            @endforelse
        </div>
    </div>

    <div class="bg-white rounded-lg shadow">
        <div class="p-6 border-b flex items-center justify-between">
            <h3 class="text-lg font-semibold">Semua jadwal mingguan</h3>
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
                    <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-4">
                        @foreach($jadwalHari as $jadwal)
                            <div class="border rounded-lg p-4 hover:shadow-md transition-shadow">
                                <div class="flex items-center justify-between mb-2">
                                    <span class="text-sm font-medium">{{ \Carbon\Carbon::parse($jadwal->jam_mulai)->format('H:i') }} - {{ \Carbon\Carbon::parse($jadwal->jam_selesai)->format('H:i') }}</span>
                                    <span class="px-2 py-1 bg-blue-100 text-blue-700 rounded text-xs">{{ $jadwal->kelas->nama_kelas }}</span>
                                </div>
                                <p class="font-medium mb-1">{{ $jadwal->mataPelajaran->nama_mapel }}</p>
                                <p class="text-sm text-gray-500 mb-3">Ruang {{ $jadwal->ruangan ?? '-' }}</p>
                                @if($hari === $hariIni)
                                    <p class="text-xs text-gray-500 mb-2">Gunakan panel <strong>Jadwal hari ini</strong> di atas untuk membuka sesi.</p>
                                @else
                                    <p class="text-xs text-amber-700 bg-amber-50 border border-amber-100 rounded px-2 py-1">Presensi hanya dapat dibuka pada hari pelajaran (<strong>{{ $hari }}</strong>).</p>
                                @endif
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
</div>
@endsection
