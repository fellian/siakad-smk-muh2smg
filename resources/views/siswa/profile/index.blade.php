@extends('layouts.siswa')

@section('title', 'Profil Saya')
@section('page-title', 'Profil Siswa')

@section('content')
<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
    <div class="lg:col-span-1">
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
            <div class="bg-gradient-to-r from-blue-600 to-blue-800 h-32"></div>
            <div class="px-6 pb-6 relative text-center">
                <div class="absolute -top-16 left-1/2 -translate-x-1/2">
                    @if($siswa->foto)
                        <img
                            src="{{ asset('storage/' . $siswa->foto) }}"
                            alt="Foto {{ $siswa->nama_lengkap }}"
                            class="w-32 h-32 rounded-full border-4 border-white object-cover shadow-lg"
                            id="preview-foto"
                        >
                    @else
                        <div class="w-32 h-32 rounded-full border-4 border-white bg-gray-300 flex items-center justify-center text-gray-600 text-4xl shadow-lg" id="preview-foto-placeholder">
                            <i class="fas fa-user-graduate"></i>
                        </div>
                        <img src="" alt="" class="w-32 h-32 rounded-full border-4 border-white object-cover shadow-lg hidden" id="preview-foto">
                    @endif
                </div>
                <div class="mt-20">
                    <h3 class="text-xl font-bold text-gray-900">{{ $siswa->nama_lengkap }}</h3>
                    <p class="text-gray-500 text-sm mt-1">NIS: {{ $siswa->nis }}</p>
                    <p class="text-gray-500 text-sm">{{ $siswa->kelas?->nama_kelas ?? 'Belum ada kelas' }}</p>
                    <span class="inline-block mt-2 px-3 py-1 rounded-full text-sm font-medium bg-green-100 text-green-700">
                        {{ ucfirst($siswa->status) }}
                    </span>
                </div>
            </div>
        </div>
    </div>

    <div class="lg:col-span-2 space-y-4">
        <form action="{{ route('siswa.profile.update') }}" method="POST" enctype="multipart/form-data" class="space-y-4">
            @csrf
            @method('PATCH')

            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
                <h4 class="font-semibold text-gray-900 mb-4 pb-2 border-b border-gray-100">Foto Profil</h4>
                <div>
                    <label for="siswa-foto" class="block text-sm text-gray-600 mb-2">Unggah foto (JPG/PNG, maks. 2MB)</label>
                    <input
                        type="file"
                        name="foto"
                        id="siswa-foto"
                        accept="image/*"
                        class="w-full text-sm text-gray-600 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-medium file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100"
                        onchange="previewImage(this)"
                    >
                    @error('foto')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
                <h4 class="font-semibold text-gray-900 mb-4 pb-2 border-b border-gray-100">Data Pribadi</h4>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-sm">
                    <div>
                        <label for="nama_lengkap" class="block text-gray-500 mb-1">Nama Lengkap <span class="text-red-500">*</span></label>
                        <input type="text" name="nama_lengkap" id="nama_lengkap" value="{{ old('nama_lengkap', $siswa->nama_lengkap) }}" required
                            class="w-full border border-gray-200 rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-200 focus:border-blue-400">
                        @error('nama_lengkap')<p class="text-red-500 text-sm mt-1">{{ $message }}</p>@enderror
                    </div>
                    <div>
                        <label for="nis" class="block text-gray-500 mb-1">NIS <span class="text-red-500">*</span></label>
                        <input type="text" name="nis" id="nis" value="{{ old('nis', $siswa->nis) }}" required
                            class="w-full border border-gray-200 rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-200 focus:border-blue-400">
                        @error('nis')<p class="text-red-500 text-sm mt-1">{{ $message }}</p>@enderror
                    </div>
                    <div>
                        <label for="nisn" class="block text-gray-500 mb-1">NISN</label>
                        <input type="text" name="nisn" id="nisn" value="{{ old('nisn', $siswa->nisn) }}"
                            class="w-full border border-gray-200 rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-200 focus:border-blue-400">
                        @error('nisn')<p class="text-red-500 text-sm mt-1">{{ $message }}</p>@enderror
                    </div>
                    <div>
                        <label for="jenis_kelamin" class="block text-gray-500 mb-1">Jenis Kelamin <span class="text-red-500">*</span></label>
                        <select name="jenis_kelamin" id="jenis_kelamin" required
                            class="w-full border border-gray-200 rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-200 focus:border-blue-400">
                            <option value="L" {{ old('jenis_kelamin', $siswa->jenis_kelamin) === 'L' ? 'selected' : '' }}>Laki-laki</option>
                            <option value="P" {{ old('jenis_kelamin', $siswa->jenis_kelamin) === 'P' ? 'selected' : '' }}>Perempuan</option>
                        </select>
                        @error('jenis_kelamin')<p class="text-red-500 text-sm mt-1">{{ $message }}</p>@enderror
                    </div>
                    <div>
                        <label for="tempat_lahir" class="block text-gray-500 mb-1">Tempat Lahir</label>
                        <input type="text" name="tempat_lahir" id="tempat_lahir" value="{{ old('tempat_lahir', $siswa->tempat_lahir) }}"
                            class="w-full border border-gray-200 rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-200 focus:border-blue-400">
                        @error('tempat_lahir')<p class="text-red-500 text-sm mt-1">{{ $message }}</p>@enderror
                    </div>
                    <div>
                        <label for="tanggal_lahir" class="block text-gray-500 mb-1">Tanggal Lahir</label>
                        <input type="date" name="tanggal_lahir" id="tanggal_lahir"
                            value="{{ old('tanggal_lahir', $siswa->tanggal_lahir?->format('Y-m-d')) }}"
                            class="w-full border border-gray-200 rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-200 focus:border-blue-400">
                        @error('tanggal_lahir')<p class="text-red-500 text-sm mt-1">{{ $message }}</p>@enderror
                    </div>
                    <div class="md:col-span-2">
                        <label for="alamat" class="block text-gray-500 mb-1">Alamat</label>
                        <textarea name="alamat" id="alamat" rows="2"
                            class="w-full border border-gray-200 rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-200 focus:border-blue-400">{{ old('alamat', $siswa->alamat) }}</textarea>
                        @error('alamat')<p class="text-red-500 text-sm mt-1">{{ $message }}</p>@enderror
                    </div>
                    <div>
                        <label for="no_hp" class="block text-gray-500 mb-1">No HP</label>
                        <input type="text" name="no_hp" id="no_hp" value="{{ old('no_hp', $siswa->no_hp) }}"
                            class="w-full border border-gray-200 rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-200 focus:border-blue-400">
                        @error('no_hp')<p class="text-red-500 text-sm mt-1">{{ $message }}</p>@enderror
                    </div>
                    <div>
                        <label for="email" class="block text-gray-500 mb-1">Email <span class="text-red-500">*</span></label>
                        <input type="email" name="email" id="email" value="{{ old('email', $siswa->email ?? $siswa->user->email) }}" required
                            class="w-full border border-gray-200 rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-200 focus:border-blue-400">
                        @error('email')<p class="text-red-500 text-sm mt-1">{{ $message }}</p>@enderror
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
                <h4 class="font-semibold text-gray-900 mb-4 pb-2 border-b border-gray-100">Data Orang Tua / Wali</h4>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-sm">
                    <div>
                        <label for="nama_ortu" class="block text-gray-500 mb-1">Nama Orang Tua / Wali</label>
                        <input type="text" name="nama_ortu" id="nama_ortu" value="{{ old('nama_ortu', $siswa->nama_ortu) }}"
                            class="w-full border border-gray-200 rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-200 focus:border-blue-400">
                        @error('nama_ortu')<p class="text-red-500 text-sm mt-1">{{ $message }}</p>@enderror
                    </div>
                    <div>
                        <label for="no_hp_ortu" class="block text-gray-500 mb-1">No HP Orang Tua / Wali</label>
                        <input type="text" name="no_hp_ortu" id="no_hp_ortu" value="{{ old('no_hp_ortu', $siswa->no_hp_ortu) }}"
                            class="w-full border border-gray-200 rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-200 focus:border-blue-400">
                        @error('no_hp_ortu')<p class="text-red-500 text-sm mt-1">{{ $message }}</p>@enderror
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
                <h4 class="font-semibold text-gray-900 mb-4 pb-2 border-b border-gray-100">Data Akademik</h4>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-sm">
                    <div>
                        <p class="text-gray-500 mb-1">Kelas</p>
                        <p class="font-medium text-gray-900">{{ $siswa->kelas?->nama_kelas ?? '-' }}</p>
                    </div>
                    <div>
                        <p class="text-gray-500 mb-1">Jurusan</p>
                        <p class="font-medium text-gray-900">{{ $siswa->kelas?->jurusan?->nama_jurusan ?? '-' }}</p>
                    </div>
                    <div>
                        <p class="text-gray-500 mb-1">Tanggal Masuk</p>
                        <p class="font-medium text-gray-900">{{ $siswa->tanggal_masuk?->format('d F Y') ?? '-' }}</p>
                    </div>
                    <div>
                        <p class="text-gray-500 mb-1">Status</p>
                        <span class="inline-block px-3 py-1 rounded-full text-xs font-medium bg-green-100 text-green-700">
                            {{ ucfirst($siswa->status) }}
                        </span>
                    </div>
                </div>
                <p class="text-xs text-gray-400 mt-4">Data akademik hanya dapat diubah oleh admin.</p>
            </div>

            <div class="flex justify-end">
                <button type="submit" class="px-6 py-2.5 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors text-sm font-medium">
                    <i class="fas fa-save mr-2"></i>Simpan Perubahan
                </button>
            </div>
        </form>

        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
            <h4 class="font-semibold text-gray-900 mb-4 pb-2 border-b border-gray-100">Ubah Password</h4>
            <form action="{{ route('siswa.profile.password') }}" method="POST">
                @csrf
                @method('PUT')
                <div class="space-y-4 max-w-md">
                    <div>
                        <label for="siswa-current-password" class="block text-sm text-gray-600 mb-1">Password Saat Ini</label>
                        <input type="password" name="current_password" id="siswa-current-password" required
                            class="w-full border border-gray-200 rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-200 focus:border-blue-400">
                        @error('current_password')<p class="text-red-500 text-sm mt-1">{{ $message }}</p>@enderror
                    </div>
                    <div>
                        <label for="siswa-new-password" class="block text-sm text-gray-600 mb-1">Password Baru</label>
                        <input type="password" name="password" id="siswa-new-password" required
                            class="w-full border border-gray-200 rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-200 focus:border-blue-400">
                        @error('password')<p class="text-red-500 text-sm mt-1">{{ $message }}</p>@enderror
                    </div>
                    <div>
                        <label for="siswa-password-confirmation" class="block text-sm text-gray-600 mb-1">Konfirmasi Password Baru</label>
                        <input type="password" name="password_confirmation" id="siswa-password-confirmation" required
                            class="w-full border border-gray-200 rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-200 focus:border-blue-400">
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
            img.className = 'w-32 h-32 rounded-full border-4 border-white object-cover shadow-lg';
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
