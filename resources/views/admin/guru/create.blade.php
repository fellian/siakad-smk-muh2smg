@extends('layouts.admin')

@section('title', 'Tambah Guru')
@section('page-title', 'Tambah Guru Baru')

@section('content')
<div class="max-w-3xl mx-auto bg-white rounded-lg shadow">
    <div class="p-6 border-b">
        <h3 class="text-lg font-semibold">Form Tambah Guru</h3>
    </div>

    <form action="{{ route('admin.guru.store') }}" method="POST" enctype="multipart/form-data" class="p-6">
        @csrf
        
        <!-- Identitas Kepegawaian -->
        <div class="grid grid-cols-2 gap-4 mb-4">
            <div>
                <label class="block text-gray-700 text-sm font-bold mb-2">NIP</label>
                <input type="text" name="nip" value="{{ old('nip') }}" 
                       class="w-full border rounded-lg px-4 py-2 @error('nip') border-red-500 @enderror" placeholder="Nomor Induk Pegawai">
                @error('nip')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
            </div>
            <div>
                <label class="block text-gray-700 text-sm font-bold mb-2">NUPTK</label>
                <input type="text" name="nuptk" value="{{ old('nuptk') }}" 
                       class="w-full border rounded-lg px-4 py-2 @error('nuptk') border-red-500 @enderror" placeholder="NUPTK">
                @error('nuptk')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
            </div>
        </div>

        <!-- Nama Lengkap -->
        <div class="mb-4">
            <label class="block text-gray-700 text-sm font-bold mb-2">Nama Lengkap <span class="text-red-500">*</span></label>
            <input type="text" name="nama_lengkap" value="{{ old('nama_lengkap') }}" 
                   class="w-full border rounded-lg px-4 py-2 @error('nama_lengkap') border-red-500 @enderror" required>
            @error('nama_lengkap')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
        </div>

        <!-- Jenis Kelamin & No HP -->
        <div class="grid grid-cols-2 gap-4 mb-4">
            <div>
                <label class="block text-gray-700 text-sm font-bold mb-2">Jenis Kelamin <span class="text-red-500">*</span></label>
                <select name="jenis_kelamin" class="w-full border rounded-lg px-4 py-2 @error('jenis_kelamin') border-red-500 @enderror" required>
                    <option value="" disabled {{ old('jenis_kelamin') ? '' : 'selected' }}>Pilih Jenis Kelamin</option>
                    <option value="L" {{ old('jenis_kelamin') == 'L' ? 'selected' : '' }}>Laki-laki</option>
                    <option value="P" {{ old('jenis_kelamin') == 'P' ? 'selected' : '' }}>Perempuan</option>
                </select>
                @error('jenis_kelamin')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
            </div>
            <div>
                <label class="block text-gray-700 text-sm font-bold mb-2">No. HP</label>
                <input type="text" name="no_hp" value="{{ old('no_hp') }}" 
                       class="w-full border rounded-lg px-4 py-2" placeholder="08xxxxxxxxxx">
            </div>
        </div>

        <!-- TTL -->
        <div class="grid grid-cols-2 gap-4 mb-4">
            <div>
                <label class="block text-gray-700 text-sm font-bold mb-2">Tempat Lahir</label>
                <input type="text" name="tempat_lahir" value="{{ old('tempat_lahir') }}" 
                       class="w-full border rounded-lg px-4 py-2">
            </div>
            <div>
                <label class="block text-gray-700 text-sm font-bold mb-2">Tanggal Lahir</label>
                <input type="date" name="tanggal_lahir" value="{{ old('tanggal_lahir') }}" 
                       class="w-full border rounded-lg px-4 py-2">
            </div>
        </div>

        <!-- Alamat -->
        <div class="mb-4">
            <label class="block text-gray-700 text-sm font-bold mb-2">Alamat</label>
            <textarea name="alamat" rows="2" class="w-full border rounded-lg px-4 py-2">{{ old('alamat') }}</textarea>
        </div>

        <!-- Informasi Pendidikan -->
        <div class="grid grid-cols-2 gap-4 mb-4">
            <div>
                <label class="block text-gray-700 text-sm font-bold mb-2">Pendidikan Terakhir</label>
                <input type="text" name="pendidikan_terakhir" value="{{ old('pendidikan_terakhir') }}" 
                       class="w-full border rounded-lg px-4 py-2" placeholder="Contoh: S1, S2">
            </div>
            <div>
                <label class="block text-gray-700 text-sm font-bold mb-2">Jurusan Pendidikan</label>
                <input type="text" name="jurusan_pendidikan" value="{{ old('jurusan_pendidikan') }}" 
                       class="w-full border rounded-lg px-4 py-2" placeholder="Contoh: Teknik Informatika">
            </div>
        </div>

        <hr class="my-6 border-gray-200">

       
        <div class="grid grid-cols-2 gap-4 mb-4">
            <div>
                <label class="block text-gray-700 text-sm font-bold mb-2">Email Guru</label>
                <input type="email" name="email_guru" value="{{ old('email_guru') }}" 
                       class="w-full border rounded-lg px-4 py-2 @error('email_guru') border-red-500 @enderror" >
                @error('email_guru')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
            </div>
            <div>
                <label class="block text-gray-700 text-sm font-bold mb-2">Email Login<span class="text-red-500">*</span></label>
                <input type="email" name="email_login" value="{{ old('email_login') }}" 
                       class="w-full border rounded-lg px-4 py-2 @error('email_login') border-red-500 @enderror" required>
                @error('email_login')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
            </div>
        </div>

        <!-- Password Akun Login -->
        <div class="mb-4">
            <label class="block text-gray-700 text-sm font-bold mb-2">Password Login <span class="text-red-500">*</span></label>
            <input type="password" name="password" 
                   class="w-full border rounded-lg px-4 py-2 @error('password') border-red-500 @enderror" required>
            @error('password')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
        </div>

        <!-- Media Foto -->
        <div class="mb-6">
            <label class="block text-gray-700 text-sm font-bold mb-2">Foto</label>
            <input type="file" name="foto" accept="image/*" 
                   class="w-full border rounded-lg px-4 py-2 @error('foto') border-red-500 @enderror">
            <p class="text-xs text-gray-500 mt-1">Format: JPG, JPEG, PNG. Maksimal 2MB</p>
            @error('foto')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
        </div>

        <!-- Tombol Aksi -->
        <div class="flex justify-end gap-3">
            <a href="{{ route('admin.guru.index') }}" class="px-4 py-2 border rounded-lg hover:bg-gray-50">Batal</a>
            <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">Simpan</button>
        </div>
    </form>
</div>
@endsection