@extends('layouts.guru')

@section('title', 'Profil Saya')
@section('page-title', 'Profil Guru')

@section('content')
<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
    {{-- Kolom Kiri: Foto & Info Dasar --}}
    <div class="lg:col-span-1 space-y-4">
        {{-- Kartu Profil --}}
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
            <div class="bg-gradient-to-r from-blue-800 to-blue-900 h-32"></div>
            
            <div class="px-6 pb-6 relative text-center">
                <div class="absolute -top-16 left-1/2 -translate-x-1/2">
                    @if($guru->foto)
                        <img 
                            src="{{ asset('storage/' . $guru->foto) }}" 
                            alt="Foto {{ $guru->nama_lengkap }}" 
                            class="w-32 h-32 rounded-full border-4 border-white object-cover shadow-lg"
                        >
                    @else
                        <div class="w-32 h-32 rounded-full border-4 border-white bg-blue-100 flex items-center justify-center text-blue-800 text-4xl shadow-lg">
                            <i class="fas fa-chalkboard-teacher"></i>
                        </div>
                    @endif
                </div>

                <div class="mt-20">
                    <h3 class="text-xl font-bold text-gray-900">{{ $guru->nama_lengkap }}</h3>
                    <p class="text-gray-500 text-sm mt-1">NIP: {{ $guru->nip ?? '-' }}</p>
                    
                    @if($guru->nuptk)
                        <p class="text-gray-500 text-sm">NUPTK: {{ $guru->nuptk }}</p>
                    @endif

                    <span class="inline-block mt-3 px-3 py-1 rounded-full text-sm font-medium {{ $guru->status === 'aktif' ? 'bg-green-100 text-green-700' : 'bg-gray-100 text-gray-600' }}">
                        {{ ucfirst($guru->status) }}
                    </span>
                </div>
            </div>
        </div>

        {{-- Ganti Foto --}}
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
            <h4 class="font-semibold text-gray-900 mb-4">Ganti Foto</h4>
            
            <form action="{{ route('guru.profile.update') }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PATCH')
                
                <div class="mb-3">
                    <input 
                        type="file" 
                        name="foto" 
                        id="guru-foto" 
                        accept="image/*" 
                        class="w-full text-sm text-gray-600 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-medium file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100"
                    >
                    @error('foto')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>
                
                <button type="submit" class="w-full px-4 py-2 bg-blue-800 text-white rounded-lg hover:bg-blue-900 transition-colors text-sm font-medium">
                    <i class="fas fa-camera mr-2"></i>Update Foto
                </button>
            </form>
        </div>
    </div>

    {{-- Kolom Kanan: Detail & Edit --}}
    <div class="lg:col-span-2 space-y-4">
        {{-- Data Pribadi --}}
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
            <h4 class="font-semibold text-gray-900 mb-4 pb-2 border-b border-gray-100">Data Pribadi</h4>
            
            <form action="{{ route('guru.profile.update') }}" method="POST">
                @csrf
                @method('PATCH')
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-sm">
                    <div>
                        <p class="text-gray-500 mb-1">Nama Lengkap</p>
                        <p class="font-medium text-gray-900">{{ $guru->nama_lengkap }}</p>
                    </div>
                    
                    <div>
                        <p class="text-gray-500 mb-1">NIP / NUPTK</p>
                        <p class="font-medium text-gray-900">{{ $guru->nip ?? '-' }} / {{ $guru->nuptk ?? '-' }}</p>
                    </div>
                    
                    <div>
                        <p class="text-gray-500 mb-1">Jenis Kelamin</p>
                        <p class="font-medium text-gray-900">{{ $guru->jenis_kelamin === 'L' ? 'Laki-laki' : 'Perempuan' }}</p>
                    </div>
                    
                    <div>
                        <p class="text-gray-500 mb-1">Tempat, Tanggal Lahir</p>
                        <p class="font-medium text-gray-900">
                            {{ $guru->tempat_lahir ?? '-' }}{{ $guru->tanggal_lahir ? ', ' . $guru->tanggal_lahir->format('d F Y') : '' }}
                        </p>
                    </div>
                    
                    <div class="md:col-span-2">
                        <label for="guru-alamat" class="block text-gray-500 mb-1">Alamat</label>
                        <textarea 
                            name="alamat" 
                            id="guru-alamat" 
                            rows="2" 
                            class="w-full border border-gray-200 rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-200 focus:border-blue-400 transition-all"
                        >{{ old('alamat', $guru->alamat) }}</textarea>
                        @error('alamat')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    
                    <div>
                        <label for="guru-no-hp" class="block text-gray-500 mb-1">No HP</label>
                        <input 
                            type="text" 
                            name="no_hp" 
                            id="guru-no-hp" 
                            value="{{ old('no_hp', $guru->no_hp) }}" 
                            class="w-full border border-gray-200 rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-200 focus:border-blue-400 transition-all"
                        >
                        @error('no_hp')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    
                    <div>
                        <p class="text-gray-500 mb-1">Email</p>
                        <p class="font-medium text-gray-900">{{ $guru->email ?? $guru->user->email }}</p>
                    </div>
                </div>
                
                <div class="mt-4">
                    <button type="submit" class="px-4 py-2 bg-blue-800 text-white rounded-lg hover:bg-blue-900 transition-colors text-sm font-medium">
                        <i class="fas fa-save mr-2"></i>Simpan Perubahan
                    </button>
                </div>
            </form>
        </div>

        {{-- Data Kepegawaian --}}
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
            <h4 class="font-semibold text-gray-900 mb-4 pb-2 border-b border-gray-100">Data Kepegawaian</h4>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-sm">
                <div>
                    <p class="text-gray-500 mb-1">Pendidikan Terakhir</p>
                    <p class="font-medium text-gray-900">{{ $guru->pendidikan_terakhir ?? '-' }}</p>
                </div>
                
                <div>
                    <p class="text-gray-500 mb-1">Jurusan Pendidikan</p>
                    <p class="font-medium text-gray-900">{{ $guru->jurusan_pendidikan ?? '-' }}</p>
                </div>
                
                <div>
                    <p class="text-gray-500 mb-1">Wali Kelas</p>
                    <p class="font-medium text-gray-900">{{ $guru->kelasWali?->nama_kelas ?? '—' }}</p>
                </div>
                
                <div>
                    <p class="text-gray-500 mb-1">Status</p>
                    <span class="inline-block px-3 py-1 rounded-full text-xs font-medium {{ $guru->status === 'aktif' ? 'bg-green-100 text-green-700' : 'bg-gray-100 text-gray-600' }}">
                        {{ ucfirst($guru->status) }}
                    </span>
                </div>
                
                @if($guru->mataPelajarans->isNotEmpty())
                    <div class="md:col-span-2">
                        <p class="text-gray-500 mb-2">Mata Pelajaran</p>
                        <div class="flex flex-wrap gap-2">
                            @foreach($guru->mataPelajarans as $mapel)
                                <span class="px-3 py-1 bg-blue-50 text-blue-800 rounded-full text-xs font-medium">
                                    {{ $mapel->nama_mapel }}
                                </span>
                            @endforeach
                        </div>
                    </div>
                @endif
            </div>
        </div>

        {{-- Ubah Password --}}
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
            <h4 class="font-semibold text-gray-900 mb-4 pb-2 border-b border-gray-100">Ubah Password</h4>
            
            <form action="{{ route('guru.profile.password') }}" method="POST">
                @csrf
                @method('PUT')
                
                <div class="space-y-4 max-w-md">
                    <div>
                        <label for="guru-current-password" class="block text-sm text-gray-600 mb-1">Password Saat Ini</label>
                        <input 
                            type="password" 
                            name="current_password" 
                            id="guru-current-password" 
                            class="w-full border border-gray-200 rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-200 focus:border-blue-400 transition-all" 
                            required
                        >
                        @error('current_password')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    
                    <div>
                        <label for="guru-new-password" class="block text-sm text-gray-600 mb-1">Password Baru</label>
                        <input 
                            type="password" 
                            name="password" 
                            id="guru-new-password" 
                            class="w-full border border-gray-200 rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-200 focus:border-blue-400 transition-all" 
                            required
                        >
                        @error('password')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    
                    <div>
                        <label for="guru-password-confirmation" class="block text-sm text-gray-600 mb-1">Konfirmasi Password Baru</label>
                        <input 
                            type="password" 
                            name="password_confirmation" 
                            id="guru-password-confirmation" 
                            class="w-full border border-gray-200 rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-200 focus:border-blue-400 transition-all" 
                            required
                        >
                    </div>
                    
                    <div>
                        <button type="submit" class="px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 transition-colors text-sm font-medium">
                            <i class="fas fa-key mr-2"></i>Update Password
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection