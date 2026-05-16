@extends('layouts.admin')

@section('title', 'Detail Kelas')
@section('page-title', 'Detail Kelas: ' . ($kelas->nama_kelas ?? '-'))

@section('content')
<div class="mb-4">
    <a href="{{ route('admin.kelas.index') }}"
       class="inline-flex items-center px-4 py-2 bg-gray-100 hover:bg-gray-200 text-gray-700 rounded-lg transition">

        <i class="fas fa-arrow-left mr-2"></i>
        Kembali ke Daftar Kelas
    </a>
</div>
<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

    <!-- Informasi Kelas -->
    <div class="lg:col-span-1">
        <div class="bg-white rounded-lg shadow p-6">

            <h3 class="text-lg font-semibold mb-4">
                Informasi Kelas
            </h3>

            <div class="space-y-3">

                <div class="flex justify-between border-b pb-2">
                    <span class="text-gray-500">Kode Kelas</span>
                    <span class="font-medium">
                        {{ $kelas->kode_kelas ?? '-' }}
                    </span>
                </div>

                <div class="flex justify-between border-b pb-2">
                    <span class="text-gray-500">Nama Kelas</span>
                    <span class="font-medium">
                        {{ $kelas->nama_kelas ?? '-' }}
                    </span>
                </div>

                <div class="flex justify-between border-b pb-2">
                    <span class="text-gray-500">Tingkat</span>
                    <span class="font-medium">
                        Kelas {{ $kelas->tingkat ?? '-' }}
                    </span>
                </div>

                <div class="flex justify-between border-b pb-2">
                    <span class="text-gray-500">Jurusan</span>
                    <span class="font-medium">
                        {{ $kelas->jurusan?->nama_jurusan ?? '-' }}
                    </span>
                </div>

                <div class="flex justify-between border-b pb-2">
                    <span class="text-gray-500">Wali Kelas</span>
                    <span class="font-medium">
                        {{ $kelas->waliKelas?->nama_lengkap ?? 'Belum ditentukan' }}
                    </span>
                </div>

                <div class="flex justify-between border-b pb-2">
                    <span class="text-gray-500">Tahun Ajaran</span>

                    <span class="font-medium">
                        @if($kelas->tahunAjaran)
                            {{ $kelas->tahunAjaran->tahun }}
                            -
                            Semester {{ $kelas->tahunAjaran->semester }}
                        @else
                            -
                        @endif
                    </span>
                </div>

                <div class="flex justify-between">
                    <span class="text-gray-500">Jumlah Siswa</span>

                    <span class="font-bold text-blue-600">
                        {{ $kelas->siswas->count() }} orang
                    </span>
                </div>

            </div>

        </div>
    </div>

    <!-- Konten -->
    <div class="lg:col-span-2">

        <!-- Daftar Siswa -->
        <div class="bg-white rounded-lg shadow">

            <div class="p-6 border-b flex justify-between items-center">

                <h3 class="text-lg font-semibold">
                    Daftar Siswa
                </h3>

                <a href="{{ route('admin.siswa.index', ['kelas_id' => $kelas->id]) }}"
                   class="text-blue-600 hover:underline text-sm">

                    Lihat Semua
                    <i class="fas fa-arrow-right"></i>

                </a>

            </div>

            <div class="p-6">

                @if($kelas->siswas->count() > 0)

                    <div class="overflow-x-auto">

                        <table class="w-full text-sm">

                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-4 py-2 text-left">No</th>
                                    <th class="px-4 py-2 text-left">NIS</th>
                                    <th class="px-4 py-2 text-left">Nama Lengkap</th>
                                    <th class="px-4 py-2 text-left">Jenis Kelamin</th>
                                    <th class="px-4 py-2 text-left">Status</th>
                                </tr>
                            </thead>

                            <tbody class="divide-y">

                                @foreach($kelas->siswas as $i => $siswa)

                                    <tr class="hover:bg-gray-50">

                                        <td class="px-4 py-2">
                                            {{ $i + 1 }}
                                        </td>

                                        <td class="px-4 py-2 font-mono">
                                            {{ $siswa->nis ?? '-' }}
                                        </td>

                                        <td class="px-4 py-2">
                                            {{ $siswa->nama_lengkap ?? '-' }}
                                        </td>

                                        <td class="px-4 py-2">
                                            @if($siswa->jenis_kelamin == 'L')
                                                Laki-laki
                                            @elseif($siswa->jenis_kelamin == 'P')
                                                Perempuan
                                            @else
                                                -
                                            @endif
                                        </td>

                                        <td class="px-4 py-2">

                                            <span
                                                class="px-2 py-1 rounded text-xs font-semibold
                                                {{ $siswa->status == 'aktif' ? 'bg-green-100 text-green-800' : '' }}
                                                {{ $siswa->status == 'pindah' ? 'bg-yellow-100 text-yellow-800' : '' }}
                                                {{ $siswa->status == 'keluar' ? 'bg-red-100 text-red-800' : '' }}
                                                {{ $siswa->status == 'lulus' ? 'bg-purple-100 text-purple-800' : '' }}">

                                                {{ ucfirst($siswa->status ?? '-') }}

                                            </span>

                                        </td>

                                    </tr>

                                @endforeach

                            </tbody>

                        </table>

                    </div>

                @else

                    <p class="text-center text-gray-500 py-8">
                        Belum ada siswa di kelas ini
                    </p>

                @endif

            </div>

        </div>

        <!-- Jadwal Pelajaran -->
        <div class="bg-white rounded-lg shadow mt-6">

            <div class="p-6 border-b">
                <h3 class="text-lg font-semibold">
                    Jadwal Pelajaran
                </h3>
            </div>

            <div class="p-6">

                @if($kelas->jadwals->count() > 0)

                    <div class="overflow-x-auto">

                        <table class="w-full text-sm">

                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-4 py-2 text-left">Hari</th>
                                    <th class="px-4 py-2 text-left">Jam</th>
                                    <th class="px-4 py-2 text-left">Mapel</th>
                                    <th class="px-4 py-2 text-left">Guru</th>
                                    <th class="px-4 py-2 text-left">Ruangan</th>
                                </tr>
                            </thead>

                            <tbody class="divide-y">

                                @foreach($kelas->jadwals->sortBy([
                                    ['hari', 'asc'],
                                    ['jam_mulai', 'asc']
                                ]) as $jadwal)

                                    <tr class="hover:bg-gray-50">

                                        <td class="px-4 py-2">
                                            {{ $jadwal->hari ?? '-' }}
                                        </td>

                                        <td class="px-4 py-2">
                                            {{ $jadwal->jam_mulai ?? '-' }}
                                            -
                                            {{ $jadwal->jam_selesai ?? '-' }}
                                        </td>

                                        <td class="px-4 py-2">
                                            {{ $jadwal->mataPelajaran?->nama_mapel ?? '-' }}
                                        </td>

                                        <td class="px-4 py-2">
                                            {{ $jadwal->guru?->nama_lengkap ?? '-' }}
                                        </td>

                                        <td class="px-4 py-2">
                                            {{ $jadwal->ruangan ?? '-' }}
                                        </td>

                                    </tr>

                                @endforeach

                            </tbody>

                        </table>

                    </div>

                @else

                    <p class="text-center text-gray-500 py-8">
                        Belum ada jadwal pelajaran
                    </p>

                @endif

            </div>

        </div>

    </div>

</div>
@endsection