@extends('layouts.admin')

@section('title', 'Edit Mata Pelajaran')
@section('page-title', 'Edit Mata Pelajaran')

@section('content')
<div class="max-w-2xl mx-auto bg-white rounded-lg shadow">
    <div class="p-6 border-b">
        <h3 class="text-lg font-semibold">Form Edit Mata Pelajaran</h3>
    </div>

    <form action="{{ route('admin.mapel.update', $mapel) }}" method="POST" class="p-6">
        @csrf @method('PUT')
        
        <div class="grid grid-cols-2 gap-4 mb-4">
            <div>
                <label class="block text-gray-700 text-sm font-bold mb-2">Kode Mapel</label>
                <input type="text" name="kode_mapel" value="{{ old('kode_mapel', $mapel->kode_mapel) }}" 
                       class="w-full border rounded-lg px-4 py-2 @error('kode_mapel') border-red-500 @enderror" maxlength="20">
                @error('kode_mapel')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>
            <div>
                <label class="block text-gray-700 text-sm font-bold mb-2">KKM</label>
                <input type="number" name="kkm" value="{{ old('kkm', $mapel->kkm) }}" 
                       class="w-full border rounded-lg px-4 py-2 @error('kkm') border-red-500 @enderror" min="0" max="100">
                @error('kkm')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>
        </div>

        <div class="mb-4">
            <label class="block text-gray-700 text-sm font-bold mb-2">Nama Mata Pelajaran</label>
            <input type="text" name="nama_mapel" value="{{ old('nama_mapel', $mapel->nama_mapel) }}" 
                   class="w-full border rounded-lg px-4 py-2 @error('nama_mapel') border-red-500 @enderror">
            @error('nama_mapel')
                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div class="grid grid-cols-2 gap-4 mb-4">
            <div>
                <label class="block text-gray-700 text-sm font-bold mb-2">Jurusan</label>
                <select name="jurusan_id" class="w-full border rounded-lg px-4 py-2">
                    <option value="">Umum (Semua Jurusan)</option>
                    @foreach($jurusans as $jurusan)
                        <option value="{{ $jurusan->id }}" {{ old('jurusan_id', $mapel->jurusan_id) == $jurusan->id ? 'selected' : '' }}>
                            {{ $jurusan->nama_jurusan }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div>
                <label class="block text-gray-700 text-sm font-bold mb-2">Kelompok</label>
                <select name="kelompok" class="w-full border rounded-lg px-4 py-2 @error('kelompok') border-red-500 @enderror">
                    <option value="1" {{ old('kelompok', $mapel->kelompok) == '1' ? 'selected' : '' }}>A - Umum</option>
                    <option value="2" {{ old('kelompok', $mapel->kelompok) == '2' ? 'selected' : '' }}>B - Umum</option>
                    <option value="3" {{ old('kelompok', $mapel->kelompok) == '3' ? 'selected' : '' }}>C - Kejuruan</option>
                </select>
                @error('kelompok')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>
        </div>

        <div class="mb-6">
            <label class="block text-gray-700 text-sm font-bold mb-2">Keterangan</label>
            <textarea name="keterangan" rows="3" class="w-full border rounded-lg px-4 py-2">{{ old('keterangan', $mapel->keterangan) }}</textarea>
        </div>

        <div class="flex justify-end gap-3">
            <a href="{{ route('admin.mapel.index') }}" class="px-4 py-2 border rounded-lg hover:bg-gray-50">Batal</a>
            <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">Update</button>
        </div>
    </form>
</div>
@endsection