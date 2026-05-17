@extends('layouts.admin')

@section('title', 'Tambah Siswa')
@section('page-title', 'Tambah Siswa Baru')

@section('content')
<div class="max-w-4xl mx-auto">
    <div class="bg-white rounded-lg shadow">
        <div class="p-6 border-b flex items-center justify-between">
            <h3 class="text-lg font-semibold">Form Tambah Siswa</h3>
            <a href="{{ route('admin.siswa.index') }}" class="text-gray-500 hover:text-gray-700">
                <i class="fas fa-arrow-left mr-1"></i>Kembali
            </a>
        </div>
        
        <form action="{{ route('admin.siswa.store') }}" method="POST" enctype="multipart/form-data" class="p-6">
            @csrf
            
            <!-- Data Pribadi -->
            <div class="mb-6">
                <h4 class="text-sm font-bold text-gray-700 uppercase tracking-wider mb-4 pb-2 border-b">
                    <i class="fas fa-user mr-2"></i>Data Pribadi
                </h4>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <!-- NIS -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            NIS <span class="text-red-500">*</span>
                        </label>
                        <input type="text" name="nis" value="{{ old('nis') }}" 
                               class="w-full border rounded-lg px-4 py-2 @error('nis') border-red-500 @enderror" 
                               placeholder="Contoh: 20250001" maxlength="20">
                        @error('nis')<p class="text-red-500 text-sm mt-1">{{ $message }}</p>@enderror
                    </div>

                    <!-- NISN -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">NISN</label>
                        <input type="text" name="nisn" value="{{ old('nisn') }}" 
                               class="w-full border rounded-lg px-4 py-2 @error('nisn') border-red-500 @enderror" 
                               placeholder="Contoh: 0012345678" maxlength="20">
                        @error('nisn')<p class="text-red-500 text-sm mt-1">{{ $message }}</p>@enderror
                    </div>

                    <!-- Nama Lengkap -->
                    <div class="md:col-span-2">
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            Nama Lengkap <span class="text-red-500">*</span>
                        </label>
                        <input type="text" name="nama_lengkap" value="{{ old('nama_lengkap') }}" 
                               class="w-full border rounded-lg px-4 py-2 @error('nama_lengkap') border-red-500 @enderror" 
                               placeholder="Nama lengkap siswa">
                        @error('nama_lengkap')<p class="text-red-500 text-sm mt-1">{{ $message }}</p>@enderror
                    </div>

                    <!-- Jenis Kelamin -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            Jenis Kelamin <span class="text-red-500">*</span>
                        </label>
                        <select name="jenis_kelamin" class="w-full border rounded-lg px-4 py-2 @error('jenis_kelamin') border-red-500 @enderror">
                            <option value="">Pilih Jenis Kelamin</option>
                            <option value="L" {{ old('jenis_kelamin') == 'L' ? 'selected' : '' }}>Laki-laki</option>
                            <option value="P" {{ old('jenis_kelamin') == 'P' ? 'selected' : '' }}>Perempuan</option>
                        </select>
                        @error('jenis_kelamin')<p class="text-red-500 text-sm mt-1">{{ $message }}</p>@enderror
                    </div>

                    <!-- Kelas -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Kelas</label>
                        <select name="kelas_id" class="w-full border rounded-lg px-4 py-2 @error('kelas_id') border-red-500 @enderror">
                            <option value="">Pilih Kelas (Opsional)</option>
                            @foreach($kelas as $k)
                                <option value="{{ $k->id }}" {{ old('kelas_id') == $k->id ? 'selected' : '' }}>
                                    {{ $k->nama_kelas }} ({{ $k->jurusan->kode_jurusan }})
                                </option>
                            @endforeach
                        </select>
                        @error('kelas_id')<p class="text-red-500 text-sm mt-1">{{ $message }}</p>@enderror
                    </div>

                    <!-- Tempat Lahir -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Tempat Lahir</label>
                        <input type="text" name="tempat_lahir" value="{{ old('tempat_lahir') }}" 
                               class="w-full border rounded-lg px-4 py-2" placeholder="Kota kelahiran">
                    </div>

                    <!-- Tanggal Lahir -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Tanggal Lahir</label>
                        <input type="date" name="tanggal_lahir" value="{{ old('tanggal_lahir') }}" 
                               class="w-full border rounded-lg px-4 py-2">
                    </div>
                </div>

                <!-- Alamat -->
                <div class="mt-4">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Alamat</label>
                    <textarea name="alamat" rows="3" 
                              class="w-full border rounded-lg px-4 py-2" 
                              placeholder="Alamat lengkap siswa">{{ old('alamat') }}</textarea>
                </div>
            </div>

            <!-- Kontak -->
            <div class="mb-6">
                <h4 class="text-sm font-bold text-gray-700 uppercase tracking-wider mb-4 pb-2 border-b">
                    <i class="fas fa-address-book mr-2"></i>Kontak
                </h4>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">No HP Siswa</label>
                        <input type="text" name="no_hp" value="{{ old('no_hp') }}" 
                               class="w-full border rounded-lg px-4 py-2" placeholder="08xxxxxxxxxx">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Email Siswa</label>
                        <input type="email" name="email_siswa" value="{{ old('email_siswa') }}" 
                               class="w-full border rounded-lg px-4 py-2 @error('email_siswa') border-red-500 @enderror" 
                               placeholder="email@example.com">
                        @error('email_siswa')<p class="text-red-500 text-sm mt-1">{{ $message }}</p>@enderror
                    </div>
                </div>
            </div>

            <!-- Data Orang Tua -->
            <div class="mb-6">
                <h4 class="text-sm font-bold text-gray-700 uppercase tracking-wider mb-4 pb-2 border-b">
                    <i class="fas fa-users mr-2"></i>Data Orang Tua/Wali
                </h4>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Nama Orang Tua</label>
                        <input type="text" name="nama_ortu" value="{{ old('nama_ortu') }}" 
                               class="w-full border rounded-lg px-4 py-2" placeholder="Nama ayah/ibu/wali">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">No HP Orang Tua</label>
                        <input type="text" name="no_hp_ortu" value="{{ old('no_hp_ortu') }}" 
                               class="w-full border rounded-lg px-4 py-2" placeholder="08xxxxxxxxxx">
                    </div>
                </div>
            </div>

            <!-- Info Akademik -->
            <div class="mb-6">
                <h4 class="text-sm font-bold text-gray-700 uppercase tracking-wider mb-4 pb-2 border-b">
                    <i class="fas fa-graduation-cap mr-2"></i>Info Akademik
                </h4>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            Tanggal Masuk <span class="text-red-500">*</span>
                        </label>
                        <input type="date" name="tanggal_masuk" value="{{ old('tanggal_masuk') }}" 
                               class="w-full border rounded-lg px-4 py-2 @error('tanggal_masuk') border-red-500 @enderror">
                        @error('tanggal_masuk')<p class="text-red-500 text-sm mt-1">{{ $message }}</p>@enderror
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Status</label>
                        <select name="status" class="w-full border rounded-lg px-4 py-2">
                            <option value="aktif" {{ old('status') == 'aktif' ? 'selected' : '' }}>Aktif</option>
                            <option value="pindah" {{ old('status') == 'pindah' ? 'selected' : '' }}>Pindah</option>
                            <option value="keluar" {{ old('status') == 'keluar' ? 'selected' : '' }}>Keluar</option>
                        </select>
                    </div>
                </div>
            </div>

            <!-- Akun Login -->
            <div class="mb-6">
                <h4 class="text-sm font-bold text-gray-700 uppercase tracking-wider mb-4 pb-2 border-b">
                    <i class="fas fa-key mr-2"></i>Akun Login
                </h4>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            Email Login <span class="text-red-500">*</span>
                        </label>
                        <input type="email" name="email_login" value="{{ old('email_login') }}" 
                               class="w-full border rounded-lg px-4 py-2 @error('email_login') border-red-500 @enderror" 
                               placeholder="Email untuk login">
                        @error('email_login')<p class="text-red-500 text-sm mt-1">{{ $message }}</p>@enderror
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            Password <span class="text-red-500">*</span>
                        </label>
                        <input type="password" name="password" 
                               class="w-full border rounded-lg px-4 py-2 @error('password') border-red-500 @enderror" 
                               placeholder="Minimal 6 karakter">
                        @error('password')<p class="text-red-500 text-sm mt-1">{{ $message }}</p>@enderror
                    </div>
                </div>
            </div>

            <!-- Foto -->
            <div class="mb-6">
                <h4 class="text-sm font-bold text-gray-700 uppercase tracking-wider mb-4 pb-2 border-b">
                    <i class="fas fa-camera mr-2"></i>Foto
                </h4>
                <div class="flex items-center gap-4">
                    <div class="w-24 h-24 rounded-full bg-gray-200 flex items-center justify-center text-gray-400 text-3xl overflow-hidden" id="preview-foto">
                        <i class="fas fa-user"></i>
                    </div>
                    <div class="flex-1">
                        <input type="file" name="foto" id="input-foto" accept="image/*" 
                               class="w-full border rounded-lg px-4 py-2">
                        <p class="text-xs text-gray-500 mt-1">Format: JPG, JPEG, PNG. Maksimal 2MB</p>
                    </div>
                </div>
            </div>

            <!-- Tombol -->
            <div class="flex justify-end gap-3 pt-4 border-t">
                <a href="{{ route('admin.siswa.index') }}" class="px-6 py-2 border rounded-lg hover:bg-gray-50">
                    Batal
                </a>
                <button type="submit" class="px-6 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">
                    <i class="fas fa-save mr-2"></i>Simpan
                </button>
            </div>
        </form>
    </div>
</div>
@endsection

@push('scripts')
<script>
    // Preview foto sebelum upload
    document.getElementById('input-foto').addEventListener('change', function(e) {
        const file = e.target.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                document.getElementById('preview-foto').innerHTML = 
                    '<img src="' + e.target.result + '" class="w-full h-full object-cover">';
            }
            reader.readAsDataURL(file);
        }
    });
</script>
@endpush