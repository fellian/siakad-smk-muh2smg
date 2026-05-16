@extends('layouts.guru')

@section('title', 'Kelola Sesi Presensi')
@section('page-title', 'Sesi Presensi')

@section('content')
@php
    $jadwal = $presensi_sesi->jadwal;
    $aktif = $presensi_sesi->aktif();
@endphp

<div class="mb-6 flex flex-col md:flex-row md:items-center md:justify-between gap-4">
    <div>
        <a href="{{ route('guru.absensi.index') }}" class="text-sm text-blue-700 font-semibold hover:underline mb-2 inline-block">&larr; Kembali ke jadwal</a>
        <h2 class="text-2xl font-bold text-gray-900">{{ $jadwal->mataPelajaran->nama_mapel }}</h2>
        <p class="text-gray-600">{{ $jadwal->kelas->nama_kelas }} · {{ $presensi_sesi->tanggal->translatedFormat('d F Y') }}</p>
        <p class="text-sm text-gray-500 mt-1">Jam {{ \Carbon\Carbon::parse($jadwal->jam_mulai)->format('H:i') }} – {{ \Carbon\Carbon::parse($jadwal->jam_selesai)->format('H:i') }}</p>
    </div>
    <div class="text-right">
        @if($aktif)
            <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold bg-green-100 text-green-800">Sesi terbuka</span>
        @else
            <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold bg-gray-200 text-gray-700">Sesi ditutup {{ $presensi_sesi->ditutup_at?->format('d/m/Y H:i') }}</span>
        @endif
    </div>
</div>

<div class="bg-white rounded-lg shadow overflow-hidden mb-6">
    <div class="p-6 border-b bg-gray-50 flex flex-col md:flex-row md:justify-between gap-3">
        <div>
            <h3 class="font-semibold text-gray-800">Daftar siswa</h3>
            <p class="text-sm text-gray-500">Data kehadiran disimpan beserta waktu presensi, status, dan guru pengampu.</p>
        </div>
        <div class="text-sm text-gray-600">
            Terisi: <strong>{{ $absensis->count() }}</strong> / {{ $jadwal->kelas->siswas->where('status','aktif')->count() }}
        </div>
    </div>
    <div class="overflow-x-auto">
        <table class="w-full text-sm">
            <thead class="bg-gray-100 text-left text-gray-600 uppercase text-xs">
                <tr>
                    <th class="px-4 py-3">Nama</th>
                    <th class="px-4 py-3">Waktu presensi</th>
                    <th class="px-4 py-3">Status</th>
                    <th class="px-4 py-3">Keterangan</th>
                    @if($aktif)
                        <th class="px-4 py-3 text-center">Aksi</th>
                    @endif
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @foreach($jadwal->kelas->siswas->where('status','aktif')->sortBy('nama_lengkap') as $siswa)
                    @php $row = $absensis->get($siswa->id); @endphp
                    <tr class="hover:bg-gray-50">
                        <td class="px-4 py-3 font-medium text-gray-900">{{ $siswa->nama_lengkap }}</td>
                        <td class="px-4 py-3 text-gray-600">{{ $row?->waktu_presensi?->format('H:i:s d/m/Y') ?? '—' }}</td>
                        <td class="px-4 py-3">
                            @if($row)
                                @php
                                    $badge = match ($row->status) {
                                        'hadir' => 'bg-green-100 text-green-800',
                                        'terlambat' => 'bg-amber-100 text-amber-800',
                                        'izin' => 'bg-yellow-100 text-yellow-800',
                                        'sakit' => 'bg-blue-100 text-blue-800',
                                        'alfa' => 'bg-red-100 text-red-800',
                                        default => 'bg-gray-100 text-gray-800',
                                    };
                                @endphp
                                <span class="px-2 py-1 rounded text-xs font-semibold {{ $badge }}">{{ ucfirst($row->status) }}</span>
                            @else
                                <span class="text-gray-400 text-xs">Belum tercatat</span>
                            @endif
                        </td>
                        <td class="px-4 py-3 text-gray-500 max-w-xs truncate">{{ $row?->keterangan ?? '—' }}</td>
                        @if($aktif)
                            <td class="px-4 py-3">
                                <form action="{{ route('guru.absensi.sesi.siswa', $presensi_sesi) }}" method="POST" class="flex flex-col xl:flex-row gap-2 items-stretch">
                                    @csrf
                                    <input type="hidden" name="siswa_id" value="{{ $siswa->id }}">
                                    <select name="status" class="rounded border-gray-300 text-xs">
                                        <option value="hadir" @selected($row?->status === 'hadir')>Hadir</option>
                                        <option value="terlambat" @selected($row?->status === 'terlambat')>Terlambat</option>
                                        <option value="izin" @selected($row?->status === 'izin')>Izin</option>
                                        <option value="sakit" @selected($row?->status === 'sakit')>Sakit</option>
                                        <option value="alfa" @selected($row?->status === 'alfa')>Alfa</option>
                                    </select>
                                    <input type="text" name="keterangan" value="{{ $row?->keterangan }}" placeholder="Ket." class="rounded border-gray-300 text-xs flex-1 min-w-[8rem]">
                                    <button type="submit" class="px-3 py-1.5 bg-blue-700 text-white rounded text-xs font-semibold hover:bg-blue-800">Simpan</button>
                                </form>
                            </td>
                        @endif
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

@if($aktif)
    <div class="bg-white rounded-lg shadow p-6 border border-red-100">
        <h3 class="font-semibold text-gray-900 mb-2">Tutup sesi presensi</h3>
        <p class="text-sm text-gray-600 mb-4">Setelah sesi ditutup, siswa tidak dapat lagi menambah presensi melalui dashboard. Anda dapat mencatat status manual pada tabel sebelum menutup, atau menggunakan opsi di bawah.</p>
        <form action="{{ route('guru.absensi.sesi.tutup', $presensi_sesi) }}" method="POST" class="space-y-4">
            @csrf
            <label class="flex items-start gap-3 cursor-pointer select-none">
                <input type="checkbox" name="isi_alfa_tidak_hadir" value="1" class="rounded border-gray-300 text-blue-700 focus:ring-blue-700 mt-1">
                <span class="text-sm text-gray-700"><strong>Otomatis isi Alfa</strong> bagi siswa yang belum mempunyai rekaman pada sesi ini. Siswa yang sudah melakukan presensi tidak akan diubah.</span>
            </label>
            <button type="submit" class="px-6 py-2.5 bg-red-700 text-white font-semibold rounded-lg hover:bg-red-800 transition-colors text-sm inline-flex items-center" onclick="return confirm('Pastikan Anda sudah selesai. Tutup sesi presensi sekarang?');">
                <i class="fas fa-lock mr-2"></i>Tutup sesi
            </button>
        </form>
    </div>
@endif

@endsection
