@extends('layouts.admin')

@section('title', 'Edit Guru')
@section('page-title', 'Edit Data Guru')

@section('content')
<div class="max-w-3xl mx-auto">
    <div class="bg-white rounded-lg shadow">
        <div class="p-6 border-b">
            <h3 class="text-lg font-semibold">Form Edit Guru</h3>
        </div>
        <form action="{{ route('admin.guru.update', $guru) }}" method="POST" enctype="multipart/form-data" class="p-6">
            @csrf 
            @method('PUT')
            
            <!-- Identitas Kepegawaian -->
            <div class="grid grid-cols-2 gap-4 mb-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">NIP</label>
                    <input type="text" name="nip" value="{{ old('nip', $guru->nip) }}" 
                           class="w-full border rounded-lg px-4 py-2 @error('nip') border-red-500 @enderror">
                    @error('nip')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">NUPTK</label>
                    <input type="text" name="nuptk" value="{{ old('nuptk', $guru->nuptk) }}" 
                           class="w-full border rounded-lg px-4 py-2 @error('nuptk') border-red-500 @enderror">
                    @error('nuptk')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                </div>
            </div>

            <!-- Nama Lengkap -->
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700 mb-2">Nama Lengkap <span class="text-red-500">*</span></label>
                <input type="text" name="nama_lengkap" value="{{ old('nama_lengkap', $guru->nama_lengkap) }}" 
                       class="w-full border rounded-lg px-4 py-2 @error('nama_lengkap') border-red-500 @enderror" required>
                @error('nama_lengkap')<p class="text-red-500 text-sm mt-1">{{ $message }}</p>@enderror
            </div>

            <!-- Jenis Kelamin & Status -->
            <div class="grid grid-cols-2 gap-4 mb-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Jenis Kelamin <span class="text-red-500">*</span></label>
                    <select name="jenis_kelamin" class="w-full border rounded-lg px-4 py-2 @error('jenis_kelamin') border-red-500 @enderror" required>
                        <option value="L" {{ old('jenis_kelamin', $guru->jenis_kelamin) == 'L' ? 'selected' : '' }}>Laki-laki</option>
                        <option value="P" {{ old('jenis_kelamin', $guru->jenis_kelamin) == 'P' ? 'selected' : '' }}>Perempuan</option>
                    </select>
                    @error('jenis_kelamin')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Status <span class="text-red-500">*</span></label>
                    <select name="status" class="w-full border rounded-lg px-4 py-2 @error('status') border-red-500 @enderror" required>
                        <option value="aktif" {{ old('status', $guru->status) == 'aktif' ? 'selected' : '' }}>Aktif</option>
                        <option value="nonaktif" {{ old('status', $guru->status) == 'nonaktif' ? 'selected' : '' }}>Nonaktif</option>
                    </select>
                    @error('status')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                </div>
            </div>

            <!-- TTL -->
            <div class="grid grid-cols-2 gap-4 mb-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Tempat Lahir</label>
                    <input type="text" name="tempat_lahir" value="{{ old('tempat_lahir', $guru->tempat_lahir) }}" class="w-full border rounded-lg px-4 py-2">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Tanggal Lahir</label>
                    <input type="date" name="tanggal_lahir" value="{{ old('tanggal_lahir', $guru->tanggal_lahir?->format('Y-m-d')) }}" class="w-full border rounded-lg px-4 py-2">
                </div>
            </div>

            <!-- Alamat & No HP -->
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700 mb-2">Alamat</label>
                <textarea name="alamat" rows="2" class="w-full border rounded-lg px-4 py-2">{{ old('alamat', $guru->alamat) }}</textarea>
            </div>

            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700 mb-2">No HP</label>
                <input type="text" name="no_hp" value="{{ old('no_hp', $guru->no_hp) }}" class="w-full border rounded-lg px-4 py-2">
            </div>

            <!-- Informasi Pendidikan -->
            <div class="grid grid-cols-2 gap-4 mb-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Pendidikan Terakhir</label>
                    <input type="text" name="pendidikan_terakhir" value="{{ old('pendidikan_terakhir', $guru->pendidikan_terakhir) }}" class="w-full border rounded-lg px-4 py-2">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Jurusan Pendidikan</label>
                    <input type="text" name="jurusan_pendidikan" value="{{ old('jurusan_pendidikan', $guru->jurusan_pendidikan) }}" class="w-full border rounded-lg px-4 py-2">
                </div>
            </div>

            <hr class="my-6 border-gray-200">

            
            <div class="grid grid-cols-2 gap-4 mb-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Email Guru</label>
                    <input type="email" name="email_guru" value="{{ old('email_guru', $guru->email) }}" 
                           class="w-full border rounded-lg px-4 py-2 @error('email_guru') border-red-500 @enderror">
                    @error('email_guru')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Email Login<span class="text-red-500">*</span></label>
                    <input type="email" name="email_login" value="{{ old('email_login', $guru->user?->email) }}" 
                           class="w-full border rounded-lg px-4 py-2 @error('email_login') border-red-500 @enderror" required>
                    @error('email_login')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                </div>
            </div>

            <!-- Kredensial Keamanan -->
            <hr class="my-4">
            <h4 class="font-semibold text-gray-700 mb-3">Ubah Password (Opsional)</h4>
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700 mb-2">Password Baru</label>
                <input type="password" name="password" class="w-full border rounded-lg px-4 py-2 @error('password') border-red-500 @enderror" placeholder="Kosongkan jika tidak diubah">
                <p class="text-xs text-gray-500 mt-1">Biarkan kosong jika tidak ingin mengubah password akun login</p>
                @error('password')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
            </div>

            <!-- Media Media Foto -->
            <div class="mb-6">
                <label class="block text-sm font-medium text-gray-700 mb-2">Foto</label>
                @if($guru->foto)
                    <div class="mb-3 flex items-center gap-3">
                        <img src="{{ asset('storage/' . $guru->foto) }}" class="w-20 h-20 rounded-full object-cover border">
                        <label class="flex items-center text-sm text-red-600 gap-1 cursor-pointer">
                            <input type="checkbox" name="hapus_foto" value="1" class="rounded text-red-600 focus:ring-red-500">
                            Hapus foto saat ini
                        </label>
                    </div>
                @endif
                <input type="file" name="foto" accept="image/*" class="w-full border rounded-lg px-4 py-2 @error('foto') border-red-500 @enderror">
                <p class="text-xs text-gray-500 mt-1">Format: JPG, JPEG, PNG. Maksimal 2MB</p>
                @error('foto')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
            </div>

            <!-- Tombol Navigasi/Eksekusi -->
            <div class="flex justify-end gap-3">
                <a href="{{ route('admin.guru.index') }}" class="px-4 py-2 border rounded-lg hover:bg-gray-50">Batal</a>
                <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 flex items-center">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-3m-1 4l-3 3m0 0l-3-3m3 3V4"></path></svg>
                    Update Data
                </button>
            </div>
        </form>
    </div>
</div>
@endsection