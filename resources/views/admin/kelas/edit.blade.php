@extends('layouts.admin')

@section('title', 'Edit Kelas')
@section('page-title', 'Edit Kelas')

@section('content')

<div class="mb-4">
    <a href="{{ route('admin.kelas.index') }}"
       class="inline-flex items-center text-sm text-blue-600 hover:text-blue-800">
        <i class="fas fa-arrow-left mr-2"></i>
        Kembali ke Daftar Kelas
    </a>
</div>

<div class="bg-white rounded-lg shadow">

    <!-- Header -->
    <div class="p-6 border-b">
        <h3 class="text-lg font-semibold">
            Form Edit Kelas
        </h3>
        <p class="text-sm text-gray-500 mt-1">
            Perbarui informasi kelas di bawah ini
        </p>
    </div>

    <!-- Form -->
    <form action="{{ route('admin.kelas.update', $kelas->id) }}"
          method="POST"
          class="p-6">

        @csrf
        @method('PUT')

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

            <!-- Kode Kelas -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">
                    Kode Kelas
                </label>

                <input type="text"
                       name="kode_kelas"
                       value="{{ old('kode_kelas', $kelas->kode_kelas) }}"
                       class="w-full border rounded-lg px-4 py-2 focus:ring focus:ring-blue-200 @error('kode_kelas') border-red-500 @enderror"
                       placeholder="Contoh: XTKJ1">

                @error('kode_kelas')
                    <p class="text-red-500 text-sm mt-1">
                        {{ $message }}
                    </p>
                @enderror
            </div>

            <!-- Nama Kelas -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">
                    Nama Kelas
                </label>

                <input type="text"
                       name="nama_kelas"
                       value="{{ old('nama_kelas', $kelas->nama_kelas) }}"
                       class="w-full border rounded-lg px-4 py-2 focus:ring focus:ring-blue-200 @error('nama_kelas') border-red-500 @enderror"
                       placeholder="Contoh: X-TKJ 1">

                @error('nama_kelas')
                    <p class="text-red-500 text-sm mt-1">
                        {{ $message }}
                    </p>
                @enderror
            </div>

            <!-- Jurusan -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">
                    Jurusan
                </label>

                <select name="jurusan_id"
                        class="w-full border rounded-lg px-4 py-2 focus:ring focus:ring-blue-200 @error('jurusan_id') border-red-500 @enderror">

                    <option value="">-- Pilih Jurusan --</option>

                    @foreach($jurusans as $jurusan)
                        <option value="{{ $jurusan->id }}"
                            {{ old('jurusan_id', $kelas->jurusan_id) == $jurusan->id ? 'selected' : '' }}>
                            {{ $jurusan->nama_jurusan }}
                        </option>
                    @endforeach

                </select>

                @error('jurusan_id')
                    <p class="text-red-500 text-sm mt-1">
                        {{ $message }}
                    </p>
                @enderror
            </div>

            <!-- Tingkat -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">
                    Tingkat
                </label>

                <select name="tingkat"
                        class="w-full border rounded-lg px-4 py-2 focus:ring focus:ring-blue-200 @error('tingkat') border-red-500 @enderror">

                    <option value="">-- Pilih Tingkat --</option>

                    <option value="10" {{ old('tingkat', $kelas->tingkat) == '10' ? 'selected' : '' }}>
                        Kelas 10
                    </option>

                    <option value="11" {{ old('tingkat', $kelas->tingkat) == '11' ? 'selected' : '' }}>
                        Kelas 11
                    </option>

                    <option value="12" {{ old('tingkat', $kelas->tingkat) == '12' ? 'selected' : '' }}>
                        Kelas 12
                    </option>

                </select>

                @error('tingkat')
                    <p class="text-red-500 text-sm mt-1">
                        {{ $message }}
                    </p>
                @enderror
            </div>

            <!-- Wali Kelas -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">
                    Wali Kelas
                </label>

                <select name="wali_kelas_id"
                        class="w-full border rounded-lg px-4 py-2 focus:ring focus:ring-blue-200 @error('wali_kelas_id') border-red-500 @enderror">

                    <option value="">-- Pilih Wali Kelas --</option>

                    @foreach($gurus as $guru)
                        <option value="{{ $guru->id }}"
                            {{ old('wali_kelas_id', $kelas->wali_kelas_id) == $guru->id ? 'selected' : '' }}>
                            {{ $guru->nama_lengkap }}
                        </option>
                    @endforeach

                </select>

                @error('wali_kelas_id')
                    <p class="text-red-500 text-sm mt-1">
                        {{ $message }}
                    </p>
                @enderror
            </div>

            <!-- Tahun Ajaran -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">
                    Tahun Ajaran
                </label>

                <select name="tahun_ajaran_id"
                        class="w-full border rounded-lg px-4 py-2 focus:ring focus:ring-blue-200 @error('tahun_ajaran_id') border-red-500 @enderror">

                    <option value="">-- Pilih Tahun Ajaran --</option>

                    @foreach($tahunAjarans as $tahun)
                        <option value="{{ $tahun->id }}"
                            {{ old('tahun_ajaran_id', $kelas->tahun_ajaran_id) == $tahun->id ? 'selected' : '' }}>
                            {{ $tahun->tahun }} - Semester {{ $tahun->semester }}
                        </option>
                    @endforeach

                </select>

                @error('tahun_ajaran_id')
                    <p class="text-red-500 text-sm mt-1">
                        {{ $message }}
                    </p>
                @enderror
            </div>

        </div>

        <!-- Tombol -->
        <div class="flex justify-end gap-3 mt-8 pt-6 border-t">

            <a href="{{ route('admin.kelas.index') }}"
               class="px-5 py-2 border rounded-lg hover:bg-gray-50">

                Batal
            </a>

            <button type="submit"
                    class="px-5 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">

                <i class="fas fa-save mr-2"></i>
                Update Kelas
            </button>

        </div>

    </form>

</div>
@endsection