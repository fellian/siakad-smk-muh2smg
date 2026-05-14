@extends('layouts.admin')

@section('title', 'Tambah Kelas')
@section('page-title', 'Tambah Kelas Baru')

@section('content')
<div class="max-w-2xl mx-auto bg-white rounded-lg shadow">
    <div class="p-6 border-b">
        <h3 class="text-lg font-semibold">Form Tambah Kelas</h3>
    </div>

    <form action="{{ route('admin.kelas.store') }}" method="POST" class="p-6">
        @csrf
        
        <div class="grid grid-cols-2 gap-4 mb-4">
            <div>
                <label class="block text-gray-700 text-sm font-bold mb-2">Kode Kelas</label>
                <input type="text" name="kode_kelas" value="{{ old('kode_kelas') }}" 
                       class="w-full border rounded-lg px-4 py-2 @error('kode_kelas') border-red-500 @enderror" 
                       placeholder="Contoh: X-RPL-1" maxlength="20">
                @error('kode_kelas')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>
            <div>
                <label class="block text-gray-700 text-sm font-bold mb-2">Nama Kelas</label>
                <input type="text" name="nama_kelas" value="{{ old('nama_kelas') }}" 
                       class="w-full border rounded-lg px-4 py-2 @error('nama_kelas') border-red-500 @enderror" 
                       placeholder="Contoh: X RPL 1">
                @error('nama_kelas')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>
        </div>

        <div class="grid grid-cols-2 gap-4 mb-4">
            <div>
                <label class="block text-gray-700 text-sm font-bold mb-2">Jurusan</label>
                <select name="jurusan_id" class="w-full border rounded-lg px-4 py-2 @error('jurusan_id') border-red-500 @enderror">
                    <option value="">Pilih Jurusan</option>
                    @foreach($jurusans as $jurusan)
                        <option value="{{ $jurusan->id }}" {{ old('jurusan_id') == $jurusan->id ? 'selected' : '' }}>
                            {{ $jurusan->nama_jurusan }}
                        </option>
                    @endforeach
                </select>
                @error('jurusan_id')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>
            <div>
                <label class="block text-gray-700 text-sm font-bold mb-2">Tingkat</label>
                <select name="tingkat" class="w-full border rounded-lg px-4 py-2 @error('tingkat') border-red-500 @enderror">
                    <option value="10" {{ old('tingkat') == '10' ? 'selected' : '' }}>Kelas X (10)</option>
                    <option value="11" {{ old('tingkat') == '11' ? 'selected' : '' }}>Kelas XI (11)</option>
                    <option value="12" {{ old('tingkat') == '12' ? 'selected' : '' }}>Kelas XII (12)</option>
                </select>
                @error('tingkat')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>
        </div>

        <div class="grid grid-cols-2 gap-4 mb-6">
            <div>
                <label class="block text-gray-700 text-sm font-bold mb-2">Wali Kelas</label>
                <select name="wali_kelas_id" class="w-full border rounded-lg px-4 py-2">
                    <option value="">Belum Ditentukan</option>
                    @foreach($gurus as $guru)
                        <option value="{{ $guru->id }}" {{ old('wali_kelas_id') == $guru->id ? 'selected' : '' }}>
                            {{ $guru->nama_lengkap }} {{ $guru->nip ? "($guru->nip)" : '' }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div>
                <label class="block text-gray-700 text-sm font-bold mb-2">Tahun Ajaran</label>
                <select name="tahun_ajaran_id" class="w-full border rounded-lg px-4 py-2 @error('tahun_ajaran_id') border-red-500 @enderror">
                    <option value="">Pilih Tahun Ajaran</option>
                    @foreach($tahunAjarans as $ta)
                        <option value="{{ $ta->id }}" {{ old('tahun_ajaran_id') == $ta->id ? 'selected' : '' }}>
                            {{ $ta->tahun }} - Semester {{ $ta->semester }} {{ $ta->status == 'aktif' ? '(Aktif)' : '' }}
                        </option>
                    @endforeach
                </select>
                @error('tahun_ajaran_id')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>
        </div>

        <div class="flex justify-end gap-3">
            <a href="{{ route('admin.kelas.index') }}" class="px-4 py-2 border rounded-lg hover:bg-gray-50">Batal</a>
            <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">Simpan</button>
        </div>
    </form>
</div>
@endsection