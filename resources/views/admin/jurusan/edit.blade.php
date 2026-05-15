@extends('layouts.admin')

@section('title', 'Edit Jurusan')
@section('page-title', 'Edit Jurusan')

@section('content')
<div class="max-w-2xl mx-auto bg-white rounded-lg shadow">
    <div class="p-6 border-b">
        <h3 class="text-lg font-semibold">Form Edit Jurusan</h3>
    </div>

    <form action="{{ route('admin.jurusan.update', $jurusan) }}" method="POST" class="p-6">
        @csrf @method('PUT')
        
        <div class="mb-4">
            <label class="block text-gray-700 text-sm font-bold mb-2">Kode Jurusan</label>
            <input type="text" name="kode_jurusan" value="{{ old('kode_jurusan', $jurusan->kode_jurusan) }}" 
                   class="w-full border rounded-lg px-4 py-2 @error('kode_jurusan') border-red-500 @enderror" maxlength="10">
            @error('kode_jurusan')
                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div class="mb-4">
            <label class="block text-gray-700 text-sm font-bold mb-2">Nama Jurusan</label>
            <input type="text" name="nama_jurusan" value="{{ old('nama_jurusan', $jurusan->nama_jurusan) }}" 
                   class="w-full border rounded-lg px-4 py-2 @error('nama_jurusan') border-red-500 @enderror">
            @error('nama_jurusan')
                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div class="mb-6">
            <label class="block text-gray-700 text-sm font-bold mb-2">Keterangan</label>
            <textarea name="keterangan" rows="3" class="w-full border rounded-lg px-4 py-2">{{ old('keterangan', $jurusan->keterangan) }}</textarea>
        </div>

        <div class="flex justify-end gap-3">
            <a href="{{ route('admin.jurusan.show', $jurusan) }}" class="px-4 py-2 border rounded-lg hover:bg-gray-50">Lihat Detail</a>
            <a href="{{ route('admin.jurusan.index') }}" class="px-4 py-2 border rounded-lg hover:bg-gray-50">Batal</a>
            <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">Update</button>
        </div>
    </form>
</div>
@endsection