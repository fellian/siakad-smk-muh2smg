@extends('layouts.admin')

@section('title', 'Edit Tahun Ajaran')
@section('page-title', 'Edit Tahun Ajaran')

@section('content')
<div class="max-w-2xl mx-auto space-y-4">
    @if($tahunAjaran->status !== 'aktif')
        <div class="p-4 bg-gray-50 border rounded-lg flex flex-wrap items-center justify-between gap-3">
            <p class="text-sm text-gray-600">Aktifkan tahun ajaran ini — yang lain otomatis dinonaktifkan.</p>
            <form action="{{ route('admin.tahun-ajaran.activate', $tahunAjaran) }}" method="POST"
                  onsubmit="return confirm('Jadikan {{ $tahunAjaran->label }} aktif? Semua tahun ajaran lain akan dinonaktifkan.')">
                @csrf
                <button type="submit" class="px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 text-sm whitespace-nowrap">
                    <i class="fas fa-check-circle mr-1"></i> Jadikan Aktif
                </button>
            </form>
        </div>
    @else
        <div class="p-4 bg-green-50 border border-green-200 rounded-lg text-sm text-green-800">
            <i class="fas fa-check-circle mr-1"></i> Tahun ajaran aktif saat ini.
        </div>
    @endif

    <div class="bg-white rounded-lg shadow">
        <div class="p-6 border-b">
            <h3 class="text-lg font-semibold">Form Edit Tahun Ajaran</h3>
        </div>

        <form action="{{ route('admin.tahun-ajaran.update', $tahunAjaran) }}" method="POST" class="p-6">
            @csrf
            @method('PUT')

            <div class="grid grid-cols-2 gap-4 mb-6">
                <div>
                    <label class="block text-gray-700 text-sm font-bold mb-2">Tahun Ajaran</label>
                    <input type="text" name="tahun" value="{{ old('tahun', $tahunAjaran->tahun) }}"
                           class="w-full border rounded-lg px-4 py-2 @error('tahun') border-red-500 @enderror"
                           maxlength="9" required>
                    @error('tahun')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>
                <div>
                    <label class="block text-gray-700 text-sm font-bold mb-2">Semester</label>
                    <select name="semester" class="w-full border rounded-lg px-4 py-2 @error('semester') border-red-500 @enderror" required>
                        <option value="1" {{ old('semester', $tahunAjaran->semester) == '1' ? 'selected' : '' }}>Semester 1 (Ganjil)</option>
                        <option value="2" {{ old('semester', $tahunAjaran->semester) == '2' ? 'selected' : '' }}>Semester 2 (Genap)</option>
                    </select>
                    @error('semester')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div class="flex justify-end gap-3">
                <a href="{{ route('admin.tahun-ajaran.index') }}" class="px-4 py-2 border rounded-lg hover:bg-gray-50">Batal</a>
                <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">Update</button>
            </div>
        </form>
    </div>
</div>
@endsection
