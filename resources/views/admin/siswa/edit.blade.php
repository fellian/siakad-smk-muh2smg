@extends('layouts.admin')

@section('title', 'Edit Siswa')
@section('page-title', 'Edit Data Siswa')

@section('content')
<div class="max-w-4xl mx-auto">
    <div class="bg-white rounded-lg shadow">
        <div class="p-6 border-b flex items-center justify-between">
            <h3 class="text-lg font-semibold">Form Edit Siswa</h3>
            <div class="flex items-center gap-3">
                <a href="{{ route('admin.siswa.show', $siswa) }}" class="text-green-600 hover:text-green-800">
                    <i class="fas fa-eye mr-1"></i>Detail
                </a>
                <a href="{{ route('admin.siswa.index') }}" class="text-gray-500 hover:text-gray-700">
                    <i class="fas fa-arrow-left mr-1"></i>Kembali
                </a>
            </div>
        </div>
        
        <form action="{{ route('admin.siswa.update', $siswa) }}" method="POST" enctype="multipart/form-data" class="p-6">
            @csrf @method('PUT')
            
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
                        <input type="text" name="nis" value="{{ old('nis', $siswa->nis) }}" 
                               class="w-full border rounded-lg px-4 py-2 @error('nis') border-red-500 @enderror" maxlength="20">
                        @error('nis')<p class="text-red-500 text-sm mt-1">{{ $message }}</p>@enderror
                    </div>

                    <!-- NISN -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">NISN</label>
                        <input type="text" name="nisn" value="{{ old('nisn', $siswa->nisn) }}" 
                               class="w-full border rounded-lg px-4 py-2 @error('nisn') border-red-500 @enderror" maxlength="20">
                        @error('nisn')<p class="text-red-500 text-sm mt-1">{{ $message }}</p>@enderror
                    </div>

                    <!-- Nama Lengkap -->
                    <div class="md:col-span-2">
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            Nama Lengkap <span class="text-red-500">*</span>
                        </label>
                        <input type="text" name="nama_lengkap" value="{{ old('nama_lengkap', $siswa->nama_lengkap) }}" 
                               class="w-full border rounded-lg px-4 py-2 @error('nama_lengkap') border-red-500 @enderror">
                        @error('nama_lengkap')<p class="text-red-500 text-sm mt-1">{{ $message }}</p>@enderror
                    </div>

                    <!-- Jenis Kelamin -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            Jenis Kelamin <span class="text-red-500">*</span>
                        </label>
                        <select name="jenis_kelamin" class="w-full border rounded-lg px-4 py-2 @error('jenis_kelamin') border-red-500 @enderror">
                            <option value="L" {{ old('jenis_kelamin', $siswa->jenis_kelamin) == 'L' ? 'selected' : '' }}>Laki-laki</option>
                            <option value="P" {{ old('jenis_kelamin', $siswa->jenis_kelamin) == 'P' ? 'selected' : '' }}>Perempuan</option>
                        </select>
                        @error('jenis_kelamin')<p class="text-red-500 text-sm mt-1">{{ $message }}</p>@enderror
                    </div>

                    <!-- Kelas -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Kelas</label>
                        <select name="kelas_id" class="w-full border rounded-lg px-4 py-2 @error('kelas_id') border-red-500 @enderror">
                            <option value="">Pilih Kelas (Opsional)</option>
                            @foreach($kelas as $k)
                                <option value="{{ $k->id }}" {{ old('kelas_id', $siswa->kelas_id) == $k->id ? 'selected' : '' }}>
                                    {{ $k->nama_kelas }} ({{ $k->jurusan->kode_jurusan }})
                                </option>
                            @endforeach
                        </select>
                        @error('kelas_id')<p class="text-red-500 text-sm mt-1">{{ $message }}</p>@enderror
                    </div>

                    <!-- Tempat Lahir -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Tempat Lahir</label>
                        <input type="text" name="tempat_lahir" value="{{ old('tempat_lahir', $siswa->tempat_lahir) }}" 
                               class="w-full border rounded-lg px-4 py-2">
                    </div>

                    <!-- Tanggal Lahir -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Tanggal Lahir</label>
                        <input type="date" name="tanggal_lahir" 
                               value="{{ old('tanggal_lahir', $siswa->tanggal_lahir?->format('Y-m-d')) }}" 
                               class="w-full border rounded-lg px-4 py-2">
                    </div>
                </div>

                <!-- Alamat -->
                <div class="mt-4">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Alamat</label>
                    <textarea name="alamat" rows="3" 
                              class="w-full border rounded-lg px-4 py-2">{{ old('alamat', $siswa->alamat) }}</textarea>
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
                        <input type="text" name="no_hp" value="{{ old('no_hp', $siswa->no_hp) }}" 
                               class="w-full border rounded-lg px-4 py-2">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Email Siswa</label>
                        <input type="email" name="email_siswa" value="{{ old('email', $siswa->email) }}" 
                               class="w-full border rounded-lg px-4 py-2" disabled>
                        <p class="text-xs text-gray-500 mt-1">Email tidak bisa diubah. Hubungi admin.</p>
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
                        <input type="text" name="nama_ortu" value="{{ old('nama_ortu', $siswa->nama_ortu) }}" 
                               class="w-full border rounded-lg px-4 py-2">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">No HP Orang Tua</label>
                        <input type="text" name="no_hp_ortu" value="{{ old('no_hp_ortu', $siswa->no_hp_ortu) }}" 
                               class="w-full border rounded-lg px-4 py-2">
                    </div>
                </div>
            </div>

            <!-- Info Akademik -->
            <div class="mb-6">
                <h4 class="text-sm font-bold text-gray-700 uppercase tracking-wider mb-4 pb-2 border-b">
                    <i class="fas fa-graduation-cap mr-2"></i>Info Akademik
                </h4>
                
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            Tanggal Masuk <span class="text-red-500">*</span>
                        </label>
                        <input type="date" name="tanggal_masuk" 
                               value="{{ old('tanggal_masuk', $siswa->tanggal_masuk->format('Y-m-d')) }}" 
                               class="w-full border rounded-lg px-4 py-2 @error('tanggal_masuk') border-red-500 @enderror">
                        @error('tanggal_masuk')<p class="text-red-500 text-sm mt-1">{{ $message }}</p>@enderror
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Status</label>
                        <select name="status" class="w-full border rounded-lg px-4 py-2 @error('status') border-red-500 @enderror">
                            <option value="aktif" {{ old('status', $siswa->status) == 'aktif' ? 'selected' : '' }}>Aktif</option>
                            <option value="pindah" {{ old('status', $siswa->status) == 'pindah' ? 'selected' : '' }}>Pindah</option>
                            <option value="keluar" {{ old('status', $siswa->status) == 'keluar' ? 'selected' : '' }}>Keluar</option>
                            <option value="lulus" {{ old('status', $siswa->status) == 'lulus' ? 'selected' : '' }}>Lulus</option>
                        </select>
                        @error('status')<p class="text-red-500 text-sm mt-1">{{ $message }}</p>@enderror
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Tanggal Keluar (Opsional)</label>
                        <input type="date" name="tanggal_keluar" 
                               value="{{ old('tanggal_keluar', $siswa->tanggal_keluar?->format('Y-m-d')) }}" 
                               class="w-full border rounded-lg px-4 py-2">
                    </div>
                </div>
            </div>

            <!-- Ubah Password -->
            <div class="mb-6">
                <h4 class="text-sm font-bold text-gray-700 uppercase tracking-wider mb-4 pb-2 border-b">
                    <i class="fas fa-key mr-2"></i>Ubah Password (Opsional)
                </h4>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Password Baru</label>
                    <input type="password" name="password" 
                           class="w-full border rounded-lg px-4 py-2" 
                           placeholder="Kosongkan jika tidak diubah">
                    <p class="text-xs text-gray-500 mt-1">Biarkan kosong jika tidak ingin mengubah password</p>
                </div>
            </div>

            <!-- Foto -->
            <div class="mb-6">
                <h4 class="text-sm font-bold text-gray-700 uppercase tracking-wider mb-4 pb-2 border-b">
                    <i class="fas fa-camera mr-2"></i>Foto
                </h4>
                <div class="flex items-center gap-4">
                    <div class="w-24 h-24 rounded-full bg-gray-200 flex items-center justify-center text-gray-400 text-3xl overflow-hidden" id="preview-foto">
                        @if($siswa->foto)
                            <img src="{{ asset('storage/' . $siswa->foto) }}" class="w-full h-full object-cover">
                        @else
                            <i class="fas fa-user"></i>
                        @endif
                    </div>
                    <div class="flex-1">
                        <input type="file" name="foto" id="input-foto" accept="image/*" 
                               class="w-full border rounded-lg px-4 py-2">
                        <p class="text-xs text-gray-500 mt-1">Format: JPG, JPEG, PNG. Maksimal 2MB</p>
                        @if($siswa->foto)
                            <label class="flex items-center mt-2">
                                <input type="checkbox" name="hapus_foto" value="1" class="mr-2">
                                <span class="text-sm text-red-600">Hapus foto saat ini</span>
                            </label>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Tombol -->
            <div class="flex justify-end gap-3 pt-4 border-t">
                <a href="{{ route('admin.siswa.index') }}" class="px-6 py-2 border rounded-lg hover:bg-gray-50">
                    Batal
                </a>
                <button type="submit" class="px-6 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">
                    <i class="fas fa-save mr-2"></i>Update
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