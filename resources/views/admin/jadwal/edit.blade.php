@extends('layouts.admin')

@section('title', 'Edit Jadwal')
@section('page-title', 'Edit Jadwal Pelajaran')

@section('content')
<div class="max-w-2xl mx-auto">
    <div class="bg-white rounded-lg shadow">
        <div class="p-6 border-b flex items-center justify-between">
            <h3 class="text-lg font-semibold">Form Edit Jadwal</h3>
            <a href="{{ route('admin.jadwal.index') }}" class="text-gray-500 hover:text-gray-700">
                <i class="fas fa-arrow-left mr-1"></i>Kembali
            </a>
        </div>
        
        <form action="{{ route('admin.jadwal.update', $jadwal) }}" method="POST" class="p-6">
            @csrf @method('PUT')
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Kelas <span class="text-red-500">*</span></label>
                    <select name="kelas_id" class="w-full border rounded-lg px-4 py-2 @error('kelas_id') border-red-500 @enderror">
                        @foreach($kelas as $k)
                            <option value="{{ $k->id }}" {{ old('kelas_id', $jadwal->kelas_id) == $k->id ? 'selected' : '' }}>
                                {{ $k->nama_kelas }}
                            </option>
                        @endforeach
                    </select>
                    @error('kelas_id')<p class="text-red-500 text-sm mt-1">{{ $message }}</p>@enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Hari <span class="text-red-500">*</span></label>
                    <select name="hari" class="w-full border rounded-lg px-4 py-2 @error('hari') border-red-500 @enderror">
                        @foreach(['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu'] as $h)
                            <option value="{{ $h }}" {{ old('hari', $jadwal->hari) == $h ? 'selected' : '' }}>{{ $h }}</option>
                        @endforeach
                    </select>
                    @error('hari')<p class="text-red-500 text-sm mt-1">{{ $message }}</p>@enderror
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Mata Pelajaran <span class="text-red-500">*</span></label>
                    <select name="mata_pelajaran_id" class="w-full border rounded-lg px-4 py-2 @error('mata_pelajaran_id') border-red-500 @enderror">
                        @foreach($mapels as $m)
                            <option value="{{ $m->id }}" {{ old('mata_pelajaran_id', $jadwal->mata_pelajaran_id) == $m->id ? 'selected' : '' }}>
                                {{ $m->nama_mapel }}
                            </option>
                        @endforeach
                    </select>
                    @error('mata_pelajaran_id')<p class="text-red-500 text-sm mt-1">{{ $message }}</p>@enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Guru <span class="text-red-500">*</span></label>
                    <select name="guru_id" class="w-full border rounded-lg px-4 py-2 @error('guru_id') border-red-500 @enderror">
                        @foreach($gurus as $g)
                            <option value="{{ $g->id }}" {{ old('guru_id', $jadwal->guru_id) == $g->id ? 'selected' : '' }}>
                                {{ $g->nama_lengkap }}
                            </option>
                        @endforeach
                    </select>
                    @error('guru_id')<p class="text-red-500 text-sm mt-1">{{ $message }}</p>@enderror
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Jam Mulai <span class="text-red-500">*</span></label>
                    <input type="time" name="jam_mulai" value="{{ old('jam_mulai', \Carbon\Carbon::parse($jadwal->jam_mulai)->format('H:i')) }}" 
                           class="w-full border rounded-lg px-4 py-2 @error('jam_mulai') border-red-500 @enderror">
                    @error('jam_mulai')<p class="text-red-500 text-sm mt-1">{{ $message }}</p>@enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Jam Selesai <span class="text-red-500">*</span></label>
                    <input type="time" name="jam_selesai" value="{{ old('jam_selesai', \Carbon\Carbon::parse($jadwal->jam_selesai)->format('H:i')) }}" 
                           class="w-full border rounded-lg px-4 py-2 @error('jam_selesai') border-red-500 @enderror">
                    @error('jam_selesai')<p class="text-red-500 text-sm mt-1">{{ $message }}</p>@enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Ruangan</label>
                    <input type="text" name="ruangan" value="{{ old('ruangan', $jadwal->ruangan) }}" 
                           class="w-full border rounded-lg px-4 py-2">
                </div>
            </div>

            <div class="mb-6">
                <label class="block text-sm font-medium text-gray-700 mb-2">Tahun Ajaran <span class="text-red-500">*</span></label>
                <select name="tahun_ajaran_id" class="w-full border rounded-lg px-4 py-2 @error('tahun_ajaran_id') border-red-500 @enderror">
                    @foreach($tahunAjarans as $ta)
                        <option value="{{ $ta->id }}" {{ old('tahun_ajaran_id', $jadwal->tahun_ajaran_id) == $ta->id ? 'selected' : '' }}>
                            {{ $ta->tahun }} - Semester {{ $ta->semester }} {{ $ta->status == 'aktif' ? '(Aktif)' : '' }}
                        </option>
                    @endforeach
                </select>
                @error('tahun_ajaran_id')<p class="text-red-500 text-sm mt-1">{{ $message }}</p>@enderror
            </div>

            <div class="flex justify-end gap-3">
                <a href="{{ route('admin.jadwal.index') }}" class="px-4 py-2 border rounded-lg hover:bg-gray-50">Batal</a>
                <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">
                    <i class="fas fa-save mr-2"></i>Update
                </button>
            </div>
        </form>
    </div>
</div>
@endsection