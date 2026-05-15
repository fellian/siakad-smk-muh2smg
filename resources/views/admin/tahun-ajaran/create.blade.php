@extends('layouts.admin')

@section('title', 'Tambah Tahun Ajaran')
@section('page-title', 'Tambah Tahun Ajaran')

@section('content')
<div class="max-w-2xl mx-auto bg-white rounded-lg shadow">
    <div class="p-6 border-b">
        <h3 class="text-lg font-semibold">Form Tambah Tahun Ajaran</h3>
        <p class="text-sm text-gray-500 mt-1">Satu tahun ajaran aktif pada satu waktu. Mengaktifkan yang baru akan menonaktifkan yang lama.</p>
    </div>

    <form action="{{ route('admin.tahun-ajaran.store') }}" method="POST" class="p-6">
        @csrf

        <div class="grid grid-cols-2 gap-4 mb-4">
            <div>
                <label class="block text-gray-700 text-sm font-bold mb-2">Tahun Ajaran</label>
                <input type="text" name="tahun" value="{{ old('tahun') }}"
                       class="w-full border rounded-lg px-4 py-2 @error('tahun') border-red-500 @enderror"
                       placeholder="2025/2026" maxlength="9" required>
                @error('tahun')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>
            <div>
                <label class="block text-gray-700 text-sm font-bold mb-2">Semester</label>
                <select name="semester" class="w-full border rounded-lg px-4 py-2 @error('semester') border-red-500 @enderror" required>
                    <option value="">Pilih Semester</option>
                    <option value="1" {{ old('semester') == '1' ? 'selected' : '' }}>Semester 1 (Ganjil)</option>
                    <option value="2" {{ old('semester') == '2' ? 'selected' : '' }}>Semester 2 (Genap)</option>
                </select>
                @error('semester')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>
        </div>

        <div class="mb-6 p-4 bg-blue-50 border border-blue-100 rounded-lg">
            <label class="flex items-start gap-3 cursor-pointer">
                <input type="checkbox" name="set_aktif" value="1"
                       class="mt-1 rounded border-gray-300 text-blue-600 focus:ring-blue-500"
                       {{ old('set_aktif', $hasActive ? false : true) ? 'checked' : '' }}>
                <span>
                    <span class="font-semibold text-gray-800 block">Jadikan tahun ajaran aktif</span>
                    <span class="text-sm text-gray-600">Jika dicentang, semua tahun ajaran lain otomatis menjadi nonaktif.</span>
                </span>
            </label>
        </div>

        <div class="flex justify-end gap-3">
            <a href="{{ route('admin.tahun-ajaran.index') }}" class="px-4 py-2 border rounded-lg hover:bg-gray-50">Batal</a>
            <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">Simpan</button>
        </div>
    </form>
</div>
@endsection
