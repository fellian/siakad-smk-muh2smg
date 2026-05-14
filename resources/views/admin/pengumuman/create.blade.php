@extends('layouts.admin')

@section('title', 'Buat Pengumuman')
@section('page-title', 'Buat Pengumuman Baru')

@section('content')
<div class="max-w-3xl mx-auto">
    <div class="bg-white rounded-lg shadow">
        <div class="p-6 border-b">
            <h3 class="text-lg font-semibold">Form Pengumuman</h3>
        </div>
        <form action="{{ route('admin.pengumuman.store') }}" method="POST" class="p-6">
            @csrf
            
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700 mb-2">Judul <span class="text-red-500">*</span></label>
                <input type="text" name="judul" value="{{ old('judul') }}" 
                       class="w-full border rounded-lg px-4 py-2 @error('judul') border-red-500 @enderror">
                @error('judul')<p class="text-red-500 text-sm mt-1">{{ $message }}</p>@enderror
            </div>

            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700 mb-2">Isi Pengumuman <span class="text-red-500">*</span></label>
                <textarea name="isi" rows="6" class="w-full border rounded-lg px-4 py-2 @error('isi') border-red-500 @enderror">{{ old('isi') }}</textarea>
                @error('isi')<p class="text-red-500 text-sm mt-1">{{ $message }}</p>@enderror
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Target <span class="text-red-500">*</span></label>
                    <select name="target" class="w-full border rounded-lg px-4 py-2 @error('target') border-red-500 @enderror">
                        <option value="semua" {{ old('target') == 'semua' ? 'selected' : '' }}>Semua</option>
                        <option value="siswa" {{ old('target') == 'siswa' ? 'selected' : '' }}>Siswa</option>
                        <option value="guru" {{ old('target') == 'guru' ? 'selected' : '' }}>Guru</option>
                    </select>
                    @error('target')<p class="text-red-500 text-sm mt-1">{{ $message }}</p>@enderror
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Tanggal Mulai <span class="text-red-500">*</span></label>
                    <input type="date" name="tanggal_mulai" value="{{ old('tanggal_mulai', now()->format('Y-m-d')) }}" 
                           class="w-full border rounded-lg px-4 py-2 @error('tanggal_mulai') border-red-500 @enderror">
                    @error('tanggal_mulai')<p class="text-red-500 text-sm mt-1">{{ $message }}</p>@enderror
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Tanggal Selesai (Opsional)</label>
                    <input type="date" name="tanggal_selesai" value="{{ old('tanggal_selesai') }}" 
                           class="w-full border rounded-lg px-4 py-2">
                </div>
            </div>

            <div class="flex justify-end gap-3">
                <a href="{{ route('admin.pengumuman.index') }}" class="px-4 py-2 border rounded-lg hover:bg-gray-50">Batal</a>
                <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">
                    <i class="fas fa-paper-plane mr-2"></i>Publikasikan
                </button>
            </div>
        </form>
    </div>
</div>
@endsection