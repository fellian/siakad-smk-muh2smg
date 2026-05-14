@extends('layouts.siswa')

@section('title', 'Profil Saya')
@section('page-title', 'Profil Siswa')

@section('content')
<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
    <!-- Kolom Kiri: Foto & Info Dasar -->
    <div class="lg:col-span-1">
        <div class="bg-white rounded-lg shadow overflow-hidden">
            <div class="bg-gradient-to-r from-blue-600 to-blue-800 h-32"></div>
            <div class="px-6 pb-6 relative text-center">
                <div class="absolute -top-16 left-1/2 transform -translate-x-1/2">
                    @if($siswa->foto)
                        <img src="{{ asset('storage/' . $siswa->foto) }}" class="w-32 h-32 rounded-full border-4 border-white object-cover shadow-lg">
                    @else
                        <div class="w-32 h-32 rounded-full border-4 border-white bg-gray-300 flex items-center justify-center text-gray-600 text-4xl shadow-lg">
                            <i class="fas fa-user-graduate"></i>
                        </div>
                    @endif
                </div>
                
                <div class="mt-20">
                    <h3 class="text-xl font-bold">{{ $siswa->nama_lengkap }}</h3>
                    <p class="text-gray-500 text-sm">NIS: {{ $siswa->nis }}</p>
                    <p class="text-gray-500 text-sm">{{ $siswa->kelas?->nama_kelas ?? 'Belum ada kelas' }}</p>
                    
                    <span class="inline-block mt-2 px-3 py-1 bg-green-100 text-green-700 rounded-full text-sm">
                        {{ ucfirst($siswa->status) }}
                    </span>
                </div>
            </div>
        </div>

        <!-- Ganti Foto -->
        <div class="bg-white rounded-lg shadow mt-4 p-6">
            <h4 class="font-semibold mb-4">Ganti Foto</h4>
            <form action="{{ route('siswa.profile.update') }}" method="POST" enctype="multipart/form-data">
                @csrf @method('PUT')
                <input type="file" name="foto" accept="image/*" class="w-full border rounded-lg px-3 py-2 mb-3">
                <button type="submit" class="w-full px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">
                    <i class="fas fa-camera mr-2"></i>Update Foto
                </button>
            </form>
        </div>
    </div>

    <!-- Kolom Kanan: Detail & Edit -->
    <div class="lg:col-span-2 space-y-6">
        <!-- Data Pribadi -->
        <div class="bg-white rounded-lg shadow p-6">
            <h4 class="font-semibold mb-4 pb-2 border-b">Data Pribadi</h4>
            <form action="{{ route('siswa.profile.update') }}" method="POST">
                @csrf @method('PUT')
                <div class="grid grid-cols-2 gap-4 text-sm">
                    <div>
                        <p class="text-gray-500">Nama Lengkap</p>
                        <p class="font-medium">{{ $siswa->nama_lengkap }}</p>
                    </div>
                    <div>
                        <p class="text-gray-500">NIS / NISN</p>
                        <p class="font-medium">{{ $siswa->nis }} / {{ $siswa->nisn ?? '-' }}</p>
                    </div>
                    <div>
                        <p class="text-gray-500">Jenis Kelamin</p>
                        <p class="font-medium">{{ $siswa->jenis_kelamin == 'L' ? 'Laki-laki' : 'Perempuan' }}</p>
                    </div>
                    <div>
                        <p class="text-gray-500">Tempat, Tanggal Lahir</p>
                        <p class="font-medium">
                            {{ $siswa->tempat_lahir ?? '-' }}{{ $siswa->tanggal_lahir ? ', ' . $siswa->tanggal_lahir->format('d F Y') : '' }}
                        </p>
                    </div>
                    <div class="col-span-2">
                        <label class="block text-gray-500 mb-1">Alamat</label>
                        <textarea name="alamat" rows="2" class="w-full border rounded-lg px-3 py-2">{{ old('alamat', $siswa->alamat) }}</textarea>
                    </div>
                    <div>
                        <label class="block text-gray-500 mb-1">No HP</label>
                        <input type="text" name="no_hp" value="{{ old('no_hp', $siswa->no_hp) }}" class="w-full border rounded-lg px-3 py-2">
                    </div>
                    <div>
                        <p class="text-gray-500">Email</p>
                        <p class="font-medium">{{ $siswa->email ?? $siswa->user->email }}</p>
                    </div>
                </div>
                <div class="mt-4">
                    <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">
                        <i class="fas fa-save mr-2"></i>Simpan Perubahan
                    </button>
                </div>
            </form>
        </div>

        <!-- Data Akademik -->
        <div class="bg-white rounded-lg shadow p-6">
            <h4 class="font-semibold mb-4 pb-2 border-b">Data Akademik</h4>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-sm">
                <div>
                    <p class="text-gray-500">Kelas</p>
                    <p class="font-medium">
                        {{ $siswa->kelas?->nama_kelas ?? '-' }}
                    </p>
                </div>

                <div>
                    <p class="text-gray-500">Jurusan</p>
                    <p class="font-medium">
                        {{ $siswa->kelas?->jurusan?->nama_jurusan ?? '-' }}
                    </p>
                </div>

                <div>
                    <p class="text-gray-500">Tahun Masuk</p>
                    <p class="font-medium">
                        {{ $siswa->tahun_masuk ?? '-' }}
                    </p>
                </div>

                <div>
                    <p class="text-gray-500">Status</p>
                    <span class="inline-block px-3 py-1 bg-green-100 text-green-700 rounded-full text-xs">
                        {{ ucfirst($siswa->status) }}
                    </span>
                </div>
            </div>
        </div>

        <!-- Ubah Password -->
        <div class="bg-white rounded-lg shadow p-6">
            <h4 class="font-semibold mb-4 pb-2 border-b">Ubah Password</h4>

            @if(session('error'))
                <div class="mb-4 bg-red-100 border border-red-300 text-red-700 px-4 py-3 rounded-lg">
                    {{ session('error') }}
                </div>
            @endif

            @if(session('success'))
                <div class="mb-4 bg-green-100 border border-green-300 text-green-700 px-4 py-3 rounded-lg">
                    {{ session('success') }}
                </div>
            @endif

            <form action="{{ route('siswa.profile.password') }}" method="POST">
                @csrf
                @method('PUT')

                <div class="space-y-4">
                    <div>
                        <label class="block text-sm text-gray-600 mb-1">
                            Password Saat Ini
                        </label>

                        <input
                            type="password"
                            name="current_password"
                            class="w-full border rounded-lg px-3 py-2 focus:ring focus:ring-blue-200"
                            required
                        >

                        @error('current_password')
                            <p class="text-red-500 text-sm mt-1">
                                {{ $message }}
                            </p>
                        @enderror
                    </div>

                    <div>
                        <label class="block text-sm text-gray-600 mb-1">
                            Password Baru
                        </label>

                        <input
                            type="password"
                            name="password"
                            class="w-full border rounded-lg px-3 py-2 focus:ring focus:ring-blue-200"
                            required
                        >

                        @error('password')
                            <p class="text-red-500 text-sm mt-1">
                                {{ $message }}
                            </p>
                        @enderror
                    </div>

                    <div>
                        <label class="block text-sm text-gray-600 mb-1">
                            Konfirmasi Password Baru
                        </label>

                        <input
                            type="password"
                            name="password_confirmation"
                            class="w-full border rounded-lg px-3 py-2 focus:ring focus:ring-blue-200"
                            required
                        >
                    </div>

                    <div>
                        <button
                            type="submit"
                            class="px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700"
                        >
                            <i class="fas fa-key mr-2"></i>
                            Update Password
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection