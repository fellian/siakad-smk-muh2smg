@extends('layouts.siswa')

@section('title', 'Profil Saya')
@section('page-title', 'Profil Siswa')

@section('content')
<div class="grid grid-cols-1 lg:grid-cols-3 gap-6 max-w-7xl mx-auto">
    
    <!-- Sidebar Profil -->
    <div class="lg:col-span-1">
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
            <!-- Header dengan gradient -->
            <div class="bg-gradient-to-br from-blue-600 to-blue-700 h-28 relative">
                <div class="absolute bottom-0 left-0 right-0 h-12 bg-gradient-to-t from-black/10 to-transparent"></div>
            </div>
            
            <!-- Konten Profil -->
            <div class="px-6 pb-6 text-center relative">
                
                <div class="absolute -top-12 left-1/2 -translate-x-1/2">
                    @if($siswa->foto)
                        <img
                            src="{{ asset('storage/' . $siswa->foto) }}"
                            alt="Foto {{ $siswa->nama_lengkap }}"
                            class="w-24 h-24 rounded-full border-4 border-white object-cover shadow-lg bg-white"
                            id="preview-foto"
                        >
                    @else
                        <div class="w-24 h-24 rounded-full border-4 border-white bg-gray-100 flex items-center justify-center shadow-lg" id="preview-foto-placeholder">
                            <svg class="w-10 h-10 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                            </svg>
                        </div>
                        <img src="" alt="" class="w-24 h-24 rounded-full border-4 border-white object-cover shadow-lg hidden bg-white" id="preview-foto">
                    @endif
                </div>
                
                <!-- Identitas - padding top agar tidak tertutup foto -->
                <div class="pt-14">
                    <h2 class="text-lg font-bold text-gray-900">{{ $siswa->nama_lengkap }}</h2>
                    <div class="mt-2 space-y-1">
                        <p class="text-sm text-gray-500">NIS: {{ $siswa->nis }}</p>
                        <p class="text-sm text-gray-500">{{ $siswa->kelas?->nama_kelas ?? 'Belum ada kelas' }}</p>
                    </div>
                    <span class="inline-block mt-3 px-3 py-1 rounded-full text-xs font-medium bg-green-100 text-green-700 border border-green-200">
                        {{ ucfirst($siswa->status) }}
                    </span>
                </div>
            </div>
        </div>
    </div>

    <!-- Main Content -->
    <div class="lg:col-span-2 space-y-6">
        
        <!-- Foto Profil Upload -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
            <h4 class="text-base font-semibold text-gray-900 mb-4 flex items-center">
                <svg class="w-5 h-5 mr-2 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                </svg>
                Foto Profil
            </h4>
            <div>
                <label for="siswa-foto" class="block text-sm text-gray-600 mb-2">Unggah foto baru (JPG/PNG, maks. 2MB)</label>
                <input
                    type="file"
                    name="foto"
                    id="siswa-foto"
                    accept="image/*"
                    class="block w-full text-sm text-gray-600 file:mr-4 file:py-2.5 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-medium file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100 file:transition-colors cursor-pointer"
                    onchange="previewImage(this)"
                >
                @error('foto')
                    <p class="text-red-500 text-sm mt-2 flex items-center">
                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        {{ $message }}
                    </p>
                @enderror
            </div>
        </div>

        <!-- Data Pribadi -->
        <form action="{{ route('siswa.profile.update') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
            @csrf
            @method('PATCH')

            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                <h4 class="text-base font-semibold text-gray-900 mb-5 flex items-center pb-3 border-b border-gray-100">
                    <svg class="w-5 h-5 mr-2 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                    </svg>
                    Data Pribadi
                </h4>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                    <div>
                        <label for="nama_lengkap" class="block text-sm font-medium text-gray-700 mb-1.5">
                            Nama Lengkap <span class="text-red-500">*</span>
                        </label>
                        <input type="text" name="nama_lengkap" id="nama_lengkap" value="{{ old('nama_lengkap', $siswa->nama_lengkap) }}" required
                            class="w-full border border-gray-300 rounded-lg px-3.5 py-2.5 text-sm focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 transition-colors">
                        @error('nama_lengkap')
                            <p class="text-red-500 text-sm mt-1.5 flex items-center">
                                <svg class="w-4 h-4 mr-1 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                {{ $message }}
                            </p>
                        @enderror
                    </div>
                    <div>
                        <label for="nis" class="block text-sm font-medium text-gray-700 mb-1.5">
                            NIS <span class="text-red-500">*</span>
                        </label>
                        <input type="text" name="nis" id="nis" value="{{ old('nis', $siswa->nis) }}" required
                            class="w-full border border-gray-300 rounded-lg px-3.5 py-2.5 text-sm focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 transition-colors">
                        @error('nis')
                            <p class="text-red-500 text-sm mt-1.5 flex items-center">
                                <svg class="w-4 h-4 mr-1 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                {{ $message }}
                            </p>
                        @enderror
                    </div>
                    <div>
                        <label for="nisn" class="block text-sm font-medium text-gray-700 mb-1.5">NISN</label>
                        <input type="text" name="nisn" id="nisn" value="{{ old('nisn', $siswa->nisn) }}"
                            class="w-full border border-gray-300 rounded-lg px-3.5 py-2.5 text-sm focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 transition-colors">
                        @error('nisn')
                            <p class="text-red-500 text-sm mt-1.5 flex items-center">
                                <svg class="w-4 h-4 mr-1 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                {{ $message }}
                            </p>
                        @enderror
                    </div>
                    <div>
                        <label for="jenis_kelamin" class="block text-sm font-medium text-gray-700 mb-1.5">
                            Jenis Kelamin <span class="text-red-500">*</span>
                        </label>
                        <select name="jenis_kelamin" id="jenis_kelamin" required
                            class="w-full border border-gray-300 rounded-lg px-3.5 py-2.5 text-sm focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 transition-colors bg-white">
                            <option value="L" {{ old('jenis_kelamin', $siswa->jenis_kelamin) === 'L' ? 'selected' : '' }}>Laki-laki</option>
                            <option value="P" {{ old('jenis_kelamin', $siswa->jenis_kelamin) === 'P' ? 'selected' : '' }}>Perempuan</option>
                        </select>
                        @error('jenis_kelamin')
                            <p class="text-red-500 text-sm mt-1.5 flex items-center">
                                <svg class="w-4 h-4 mr-1 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                {{ $message }}
                            </p>
                        @enderror
                    </div>
                    <div>
                        <label for="tempat_lahir" class="block text-sm font-medium text-gray-700 mb-1.5">Tempat Lahir</label>
                        <input type="text" name="tempat_lahir" id="tempat_lahir" value="{{ old('tempat_lahir', $siswa->tempat_lahir) }}"
                            class="w-full border border-gray-300 rounded-lg px-3.5 py-2.5 text-sm focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 transition-colors">
                        @error('tempat_lahir')
                            <p class="text-red-500 text-sm mt-1.5 flex items-center">
                                <svg class="w-4 h-4 mr-1 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                {{ $message }}
                            </p>
                        @enderror
                    </div>
                    <div>
                        <label for="tanggal_lahir" class="block text-sm font-medium text-gray-700 mb-1.5">Tanggal Lahir</label>
                        <input type="date" name="tanggal_lahir" id="tanggal_lahir"
                            value="{{ old('tanggal_lahir', $siswa->tanggal_lahir?->format('Y-m-d')) }}"
                            class="w-full border border-gray-300 rounded-lg px-3.5 py-2.5 text-sm focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 transition-colors">
                        @error('tanggal_lahir')
                            <p class="text-red-500 text-sm mt-1.5 flex items-center">
                                <svg class="w-4 h-4 mr-1 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                {{ $message }}
                            </p>
                        @enderror
                    </div>
                    <div class="md:col-span-2">
                        <label for="alamat" class="block text-sm font-medium text-gray-700 mb-1.5">Alamat</label>
                        <textarea name="alamat" id="alamat" rows="3"
                            class="w-full border border-gray-300 rounded-lg px-3.5 py-2.5 text-sm focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 transition-colors resize-none">{{ old('alamat', $siswa->alamat) }}</textarea>
                        @error('alamat')
                            <p class="text-red-500 text-sm mt-1.5 flex items-center">
                                <svg class="w-4 h-4 mr-1 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                {{ $message }}
                            </p>
                        @enderror
                    </div>
                    <div>
                        <label for="no_hp" class="block text-sm font-medium text-gray-700 mb-1.5">No HP</label>
                        <input type="text" name="no_hp" id="no_hp" value="{{ old('no_hp', $siswa->no_hp) }}"
                            class="w-full border border-gray-300 rounded-lg px-3.5 py-2.5 text-sm focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 transition-colors">
                        @error('no_hp')
                            <p class="text-red-500 text-sm mt-1.5 flex items-center">
                                <svg class="w-4 h-4 mr-1 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                {{ $message }}
                            </p>
                        @enderror
                    </div>
                    <div>
                        <label for="email" class="block text-sm font-medium text-gray-700 mb-1.5">
                            Email <span class="text-red-500">*</span>
                        </label>
                        <input type="email" name="email" id="email" value="{{ old('email', $siswa->email ?? $siswa->user->email) }}" required
                            class="w-full border border-gray-300 rounded-lg px-3.5 py-2.5 text-sm focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 transition-colors">
                        @error('email')
                            <p class="text-red-500 text-sm mt-1.5 flex items-center">
                                <svg class="w-4 h-4 mr-1 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                {{ $message }}
                            </p>
                        @enderror
                    </div>
                </div>
            </div>

            <!-- Data Orang Tua -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                <h4 class="text-base font-semibold text-gray-900 mb-5 flex items-center pb-3 border-b border-gray-100">
                    <svg class="w-5 h-5 mr-2 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                    </svg>
                    Data Orang Tua / Wali
                </h4>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                    <div>
                        <label for="nama_ortu" class="block text-sm font-medium text-gray-700 mb-1.5">Nama Orang Tua / Wali</label>
                        <input type="text" name="nama_ortu" id="nama_ortu" value="{{ old('nama_ortu', $siswa->nama_ortu) }}"
                            class="w-full border border-gray-300 rounded-lg px-3.5 py-2.5 text-sm focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 transition-colors">
                        @error('nama_ortu')
                            <p class="text-red-500 text-sm mt-1.5 flex items-center">
                                <svg class="w-4 h-4 mr-1 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                {{ $message }}
                            </p>
                        @enderror
                    </div>
                    <div>
                        <label for="no_hp_ortu" class="block text-sm font-medium text-gray-700 mb-1.5">No HP Orang Tua / Wali</label>
                        <input type="text" name="no_hp_ortu" id="no_hp_ortu" value="{{ old('no_hp_ortu', $siswa->no_hp_ortu) }}"
                            class="w-full border border-gray-300 rounded-lg px-3.5 py-2.5 text-sm focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 transition-colors">
                        @error('no_hp_ortu')
                            <p class="text-red-500 text-sm mt-1.5 flex items-center">
                                <svg class="w-4 h-4 mr-1 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                {{ $message }}
                            </p>
                        @enderror
                    </div>
                </div>
            </div>

            <!-- Data Akademik (Read Only) -->
            <div class="bg-gray-50/50 rounded-xl border border-gray-200 p-6">
                <h4 class="text-base font-semibold text-gray-900 mb-5 flex items-center pb-3 border-b border-gray-200">
                    <svg class="w-5 h-5 mr-2 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                    </svg>
                    Data Akademik
                </h4>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                    <div class="bg-white rounded-lg p-3 border border-gray-100">
                        <p class="text-xs font-medium text-gray-500 uppercase tracking-wide mb-1">Kelas</p>
                        <p class="text-sm font-semibold text-gray-900">{{ $siswa->kelas?->nama_kelas ?? '-' }}</p>
                    </div>
                    <div class="bg-white rounded-lg p-3 border border-gray-100">
                        <p class="text-xs font-medium text-gray-500 uppercase tracking-wide mb-1">Jurusan</p>
                        <p class="text-sm font-semibold text-gray-900">{{ $siswa->kelas?->jurusan?->nama_jurusan ?? '-' }}</p>
                    </div>
                    <div class="bg-white rounded-lg p-3 border border-gray-100">
                        <p class="text-xs font-medium text-gray-500 uppercase tracking-wide mb-1">Tanggal Masuk</p>
                        <p class="text-sm font-semibold text-gray-900">{{ $siswa->tanggal_masuk?->format('d F Y') ?? '-' }}</p>
                    </div>
                    <div class="bg-white rounded-lg p-3 border border-gray-100">
                        <p class="text-xs font-medium text-gray-500 uppercase tracking-wide mb-1">Status</p>
                        <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium bg-green-100 text-green-700 border border-green-200">
                            <span class="w-1.5 h-1.5 rounded-full bg-green-500 mr-1.5"></span>
                            {{ ucfirst($siswa->status) }}
                        </span>
                    </div>
                </div>
            </div>

            <!-- Submit Button -->
            <div class="flex justify-end pt-2">
                <button type="submit" class="inline-flex items-center px-6 py-2.5 bg-blue-600 hover:bg-blue-700 text-white rounded-lg transition-colors text-sm font-medium shadow-sm hover:shadow focus:ring-2 focus:ring-blue-500/20 focus:outline-none">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                    </svg>
                    Simpan Perubahan
                </button>
            </div>
        </form>

        <!-- Ubah Password -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
            <h4 class="text-base font-semibold text-gray-900 mb-5 flex items-center pb-3 border-b border-gray-100">
                <svg class="w-5 h-5 mr-2 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
                </svg>
                Ubah Password
            </h4>
            <form action="{{ route('siswa.profile.password') }}" method="POST">
                @csrf
                @method('PUT')
                <div class="grid grid-cols-1 md:grid-cols-2 gap-5 max-w-2xl">
                    <div class="md:col-span-2">
                        <label for="siswa-current-password" class="block text-sm font-medium text-gray-700 mb-1.5">Password Saat Ini</label>
                        <input type="password" name="current_password" id="siswa-current-password" required
                            class="w-full border border-gray-300 rounded-lg px-3.5 py-2.5 text-sm focus:ring-2 focus:ring-red-500/20 focus:border-red-500 transition-colors">
                        @error('current_password')
                            <p class="text-red-500 text-sm mt-1.5 flex items-center">
                                <svg class="w-4 h-4 mr-1 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                {{ $message }}
                            </p>
                        @enderror
                    </div>
                    <div>
                        <label for="siswa-new-password" class="block text-sm font-medium text-gray-700 mb-1.5">Password Baru</label>
                        <input type="password" name="password" id="siswa-new-password" required
                            class="w-full border border-gray-300 rounded-lg px-3.5 py-2.5 text-sm focus:ring-2 focus:ring-red-500/20 focus:border-red-500 transition-colors">
                        @error('password')
                            <p class="text-red-500 text-sm mt-1.5 flex items-center">
                                <svg class="w-4 h-4 mr-1 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                {{ $message }}
                            </p>
                        @enderror
                    </div>
                    <div>
                        <label for="siswa-password-confirmation" class="block text-sm font-medium text-gray-700 mb-1.5">Konfirmasi Password Baru</label>
                        <input type="password" name="password_confirmation" id="siswa-password-confirmation" required
                            class="w-full border border-gray-300 rounded-lg px-3.5 py-2.5 text-sm focus:ring-2 focus:ring-red-500/20 focus:border-red-500 transition-colors">
                    </div>
                    <div class="md:col-span-2">
                        <button type="submit" class="inline-flex items-center px-5 py-2.5 bg-red-600 hover:bg-red-700 text-white rounded-lg transition-colors text-sm font-medium shadow-sm hover:shadow focus:ring-2 focus:ring-red-500/20 focus:outline-none">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 17H9v2H7v2H4a1 1 0 01-1-1v-2.586a1 1 0 01.293-.707l5.964-5.964A6 6 0 1121 9z"></path>
                            </svg>
                            Update Password
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

@push('scripts')
<script>
function previewImage(input) {
    if (!input.files || !input.files[0]) return;
    const reader = new FileReader();
    reader.onload = function (e) {
        let img = document.getElementById('preview-foto');
        const placeholder = document.getElementById('preview-foto-placeholder');
        if (!img) {
            img = document.createElement('img');
            img.id = 'preview-foto';
            img.className = 'w-24 h-24 rounded-full border-4 border-white object-cover shadow-lg bg-white';
            placeholder?.parentNode.appendChild(img);
        }
        if (placeholder) placeholder.classList.add('hidden');
        img.src = e.target.result;
        img.classList.remove('hidden');
    };
    reader.readAsDataURL(input.files[0]);
}
</script>
@endpush
@endsection