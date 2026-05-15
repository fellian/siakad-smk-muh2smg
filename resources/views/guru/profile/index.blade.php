@extends('layouts.guru')

@section('title', 'Profil Saya')
@section('page-title', 'Profil Guru')

@section('content')
<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
    <div class="lg:col-span-1">
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
            <div class="bg-gradient-to-r from-blue-800 to-blue-900 h-32"></div>
            <div class="px-6 pb-6 relative text-center">
                <div class="absolute -top-16 left-1/2 -translate-x-1/2">
                    @if($guru->foto)
                        <img
                            src="{{ asset('storage/' . $guru->foto) }}"
                            alt="Foto {{ $guru->nama_lengkap }}"
                            class="w-32 h-32 rounded-full border-4 border-white object-cover shadow-lg"
                            id="preview-foto"
                        >
                    @else
                        <div class="w-32 h-32 rounded-full border-4 border-white bg-blue-100 flex items-center justify-center text-blue-800 text-4xl shadow-lg" id="preview-foto-placeholder">
                            <i class="fas fa-chalkboard-teacher"></i>
                        </div>
                        <img src="" alt="" class="w-32 h-32 rounded-full border-4 border-white object-cover shadow-lg hidden" id="preview-foto">
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
    </div>

    <div class="lg:col-span-2 space-y-4">
        <form action="{{ route('guru.profile.update') }}" method="POST" enctype="multipart/form-data" class="space-y-4">
            @csrf
            @method('PATCH')

            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
                <h4 class="font-semibold text-gray-900 mb-4 pb-2 border-b border-gray-100">Foto Profil</h4>
                <div>
                    <label for="guru-foto" class="block text-sm text-gray-600 mb-2">Unggah foto (JPG/PNG, maks. 2MB)</label>
                    <input
                        type="file"
                        name="foto"
                        id="guru-foto"
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
                        <input type="text" name="nama_lengkap" id="nama_lengkap" value="{{ old('nama_lengkap', $guru->nama_lengkap) }}" required
                            class="w-full border border-gray-200 rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-200 focus:border-blue-400">
                        @error('nama_lengkap')<p class="text-red-500 text-sm mt-1">{{ $message }}</p>@enderror
                    </div>
                    <div>
                        <label for="nip" class="block text-gray-500 mb-1">NIP</label>
                        <input type="text" name="nip" id="nip" value="{{ old('nip', $guru->nip) }}"
                            class="w-full border border-gray-200 rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-200 focus:border-blue-400">
                        @error('nip')<p class="text-red-500 text-sm mt-1">{{ $message }}</p>@enderror
                    </div>
                    <div>
                        <label for="nuptk" class="block text-gray-500 mb-1">NUPTK</label>
                        <input type="text" name="nuptk" id="nuptk" value="{{ old('nuptk', $guru->nuptk) }}"
                            class="w-full border border-gray-200 rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-200 focus:border-blue-400">
                        @error('nuptk')<p class="text-red-500 text-sm mt-1">{{ $message }}</p>@enderror
                    </div>
                    <div>
                        <label for="jenis_kelamin" class="block text-gray-500 mb-1">Jenis Kelamin <span class="text-red-500">*</span></label>
                        <select name="jenis_kelamin" id="jenis_kelamin" required
                            class="w-full border border-gray-200 rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-200 focus:border-blue-400">
                            <option value="L" {{ old('jenis_kelamin', $guru->jenis_kelamin) === 'L' ? 'selected' : '' }}>Laki-laki</option>
                            <option value="P" {{ old('jenis_kelamin', $guru->jenis_kelamin) === 'P' ? 'selected' : '' }}>Perempuan</option>
                        </select>
                        @error('jenis_kelamin')<p class="text-red-500 text-sm mt-1">{{ $message }}</p>@enderror
                    </div>
                    <div>
                        <label for="tempat_lahir" class="block text-gray-500 mb-1">Tempat Lahir</label>
                        <input type="text" name="tempat_lahir" id="tempat_lahir" value="{{ old('tempat_lahir', $guru->tempat_lahir) }}"
                            class="w-full border border-gray-200 rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-200 focus:border-blue-400">
                        @error('tempat_lahir')<p class="text-red-500 text-sm mt-1">{{ $message }}</p>@enderror
                    </div>
                    <div>
                        <label for="tanggal_lahir" class="block text-gray-500 mb-1">Tanggal Lahir</label>
                        <input type="date" name="tanggal_lahir" id="tanggal_lahir"
                            value="{{ old('tanggal_lahir', $guru->tanggal_lahir?->format('Y-m-d')) }}"
                            class="w-full border border-gray-200 rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-200 focus:border-blue-400">
                        @error('tanggal_lahir')<p class="text-red-500 text-sm mt-1">{{ $message }}</p>@enderror
                    </div>
                    <div class="md:col-span-2">
                        <label for="alamat" class="block text-gray-500 mb-1">Alamat</label>
                        <textarea name="alamat" id="alamat" rows="2"
                            class="w-full border border-gray-200 rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-200 focus:border-blue-400">{{ old('alamat', $guru->alamat) }}</textarea>
                        @error('alamat')<p class="text-red-500 text-sm mt-1">{{ $message }}</p>@enderror
                    </div>
                    <div>
                        <label for="no_hp" class="block text-gray-500 mb-1">No HP</label>
                        <input type="text" name="no_hp" id="no_hp" value="{{ old('no_hp', $guru->no_hp) }}"
                            class="w-full border border-gray-200 rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-200 focus:border-blue-400">
                        @error('no_hp')<p class="text-red-500 text-sm mt-1">{{ $message }}</p>@enderror
                    </div>
                    <div>
                        <label for="email" class="block text-gray-500 mb-1">Email <span class="text-red-500">*</span></label>
                        <input type="email" name="email" id="email" value="{{ old('email', $guru->email ?? $guru->user->email) }}" required
                            class="w-full border border-gray-200 rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-200 focus:border-blue-400">
                        @error('email')<p class="text-red-500 text-sm mt-1">{{ $message }}</p>@enderror
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
                <h4 class="font-semibold text-gray-900 mb-4 pb-2 border-b border-gray-100">Data Pendidikan</h4>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-sm">
                    <div>
                        <label for="pendidikan_terakhir" class="block text-gray-500 mb-1">Pendidikan Terakhir</label>
                        <input type="text" name="pendidikan_terakhir" id="pendidikan_terakhir" value="{{ old('pendidikan_terakhir', $guru->pendidikan_terakhir) }}"
                            class="w-full border border-gray-200 rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-200 focus:border-blue-400"
                            placeholder="Contoh: S1 Pendidikan">
                        @error('pendidikan_terakhir')<p class="text-red-500 text-sm mt-1">{{ $message }}</p>@enderror
                    </div>
                    <div>
                        <label for="jurusan_pendidikan" class="block text-gray-500 mb-1">Jurusan Pendidikan</label>
                        <input type="text" name="jurusan_pendidikan" id="jurusan_pendidikan" value="{{ old('jurusan_pendidikan', $guru->jurusan_pendidikan) }}"
                            class="w-full border border-gray-200 rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-200 focus:border-blue-400"
                            placeholder="Contoh: Teknik Informatika">
                        @error('jurusan_pendidikan')<p class="text-red-500 text-sm mt-1">{{ $message }}</p>@enderror
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
                <h4 class="font-semibold text-gray-900 mb-4 pb-2 border-b border-gray-100">Data Kepegawaian</h4>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-sm">
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
                                    <span class="px-3 py-1 bg-blue-50 text-blue-800 rounded-full text-xs font-medium">{{ $mapel->nama_mapel }}</span>
                                @endforeach
                            </div>
                        </div>
                    @endif
                </div>
                <p class="text-xs text-gray-400 mt-4">Wali kelas, mata pelajaran, dan status hanya dapat diubah oleh admin.</p>
            </div>

            <div class="flex justify-end">
                <button type="submit" class="px-6 py-2.5 bg-blue-800 text-white rounded-lg hover:bg-blue-900 transition-colors text-sm font-medium">
                    <i class="fas fa-save mr-2"></i>Simpan Perubahan
                </button>
            </div>
        </form>

        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
            <h4 class="font-semibold text-gray-900 mb-4 pb-2 border-b border-gray-100">Ubah Password</h4>
            <form action="{{ route('guru.profile.password') }}" method="POST">
                @csrf
                @method('PUT')
                <div class="space-y-4 max-w-md">
                    <div>
                        <label for="guru-current-password" class="block text-sm text-gray-600 mb-1">Password Saat Ini</label>
                        <input type="password" name="current_password" id="guru-current-password" required
                            class="w-full border border-gray-200 rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-200 focus:border-blue-400">
                        @error('current_password')<p class="text-red-500 text-sm mt-1">{{ $message }}</p>@enderror
                    </div>
                    <div>
                        <label for="guru-new-password" class="block text-sm text-gray-600 mb-1">Password Baru</label>
                        <input type="password" name="password" id="guru-new-password" required
                            class="w-full border border-gray-200 rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-200 focus:border-blue-400">
                        @error('password')<p class="text-red-500 text-sm mt-1">{{ $message }}</p>@enderror
                    </div>
                    <div>
                        <label for="guru-password-confirmation" class="block text-sm text-gray-600 mb-1">Konfirmasi Password Baru</label>
                        <input type="password" name="password_confirmation" id="guru-password-confirmation" required
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
