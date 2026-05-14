@extends('layouts.admin')

@section('title', 'Data Siswa')
@section('page-title', 'Manajemen Data Siswa')

@section('content')
<div class="bg-white rounded-lg shadow">
    <!-- Header -->
    <div class="p-6 border-b">
        <div class="flex flex-wrap items-center justify-between gap-4">
            <h3 class="text-lg font-semibold">Daftar Siswa</h3>
            <div class="flex gap-3">
                <a href="{{ route('admin.siswa.create') }}" class="bg-green-600 text-white px-4 py-2 rounded-lg hover:bg-green-700">
                    <i class="fas fa-plus mr-2"></i>Tambah Siswa
                </a>
                <button onclick="document.getElementById('modal-import').classList.remove('hidden')" 
                        class="bg-purple-600 text-white px-4 py-2 rounded-lg hover:bg-purple-700">
                    <i class="fas fa-file-import mr-2"></i>Import Excel
                </button>
            </div>
        </div>
    </div>

    <!-- Filter & Search -->
    <div class="p-6 border-b bg-gray-50">
        <form method="GET" class="flex flex-wrap gap-3">
            <div class="flex-1 min-w-[200px]">
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari NIS/Nama..." 
                       class="w-full border rounded-lg px-4 py-2">
            </div>
            
            <select name="kelas_id" class="border rounded-lg px-4 py-2 min-w-[150px]">
                <option value="">Semua Kelas</option>
                @foreach($kelas as $k)
                    <option value="{{ $k->id }}" {{ request('kelas_id') == $k->id ? 'selected' : '' }}>
                        {{ $k->nama_kelas }}
                    </option>
                @endforeach
            </select>
            
            <select name="status" class="border rounded-lg px-4 py-2 min-w-[150px]">
                <option value="">Semua Status</option>
                <option value="aktif" {{ request('status') == 'aktif' ? 'selected' : '' }}>Aktif</option>
                <option value="pindah" {{ request('status') == 'pindah' ? 'selected' : '' }}>Pindah</option>
                <option value="keluar" {{ request('status') == 'keluar' ? 'selected' : '' }}>Keluar</option>
                <option value="lulus" {{ request('status') == 'lulus' ? 'selected' : '' }}>Lulus</option>
            </select>
            
            <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700">
                <i class="fas fa-search mr-2"></i>Filter
            </button>
            
            @if(request()->hasAny(['search', 'kelas_id', 'status']))
            <a href="{{ route('admin.siswa.index') }}" class="bg-gray-500 text-white px-4 py-2 rounded-lg hover:bg-gray-600">
                <i class="fas fa-times mr-2"></i>Reset
            </a>
            @endif
        </form>
    </div>
    
    <!-- Table -->
    <div class="p-6">
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-4 py-3 text-left font-medium text-gray-600">No</th>
                        <th class="px-4 py-3 text-left font-medium text-gray-600">Foto</th>
                        <th class="px-4 py-3 text-left font-medium text-gray-600">NIS</th>
                        <th class="px-4 py-3 text-left font-medium text-gray-600">Nama Lengkap</th>
                        <th class="px-4 py-3 text-left font-medium text-gray-600">Kelas</th>
                        <th class="px-4 py-3 text-center font-medium text-gray-600">JK</th>
                        <th class="px-4 py-3 text-center font-medium text-gray-600">Status</th>
                        <th class="px-4 py-3 text-center font-medium text-gray-600">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse($siswas as $i => $siswa)
                    <tr class="hover:bg-gray-50 transition-colors">
                        <td class="px-4 py-3">{{ $siswas->firstItem() + $i }}</td>
                        <td class="px-4 py-3">
                            @if($siswa->foto)
                                <img src="{{ asset('storage/' . $siswa->foto) }}" class="w-10 h-10 rounded-full object-cover">
                            @else
                                <div class="w-10 h-10 rounded-full bg-gray-200 flex items-center justify-center text-gray-500">
                                    <i class="fas fa-user-graduate text-sm"></i>
                                </div>
                            @endif
                        </td>
                        <td class="px-4 py-3 font-mono font-medium">{{ $siswa->nis }}</td>
                        <td class="px-4 py-3">
                            <div class="font-medium">{{ $siswa->nama_lengkap }}</div>
                            <div class="text-xs text-gray-500">{{ $siswa->nisn ?? '-' }}</div>
                        </td>
                        <td class="px-4 py-3">
                            @if($siswa->kelas)
                                <span class="px-2 py-1 bg-blue-100 text-blue-700 rounded text-xs">{{ $siswa->kelas->nama_kelas }}</span>
                            @else
                                <span class="text-gray-400">-</span>
                            @endif
                        </td>
                        <td class="px-4 py-3 text-center">
                            @if($siswa->jenis_kelamin == 'L')
                                <span class="px-2 py-1 bg-blue-50 text-blue-600 rounded text-xs" title="Laki-laki"><i class="fas fa-mars"></i></span>
                            @else
                                <span class="px-2 py-1 bg-pink-50 text-pink-600 rounded text-xs" title="Perempuan"><i class="fas fa-venus"></i></span>
                            @endif
                        </td>
                        <td class="px-4 py-3 text-center">
                            <span class="px-2 py-1 rounded-full text-xs font-medium
                                {{ $siswa->status == 'aktif' ? 'bg-green-100 text-green-700' : '' }}
                                {{ $siswa->status == 'pindah' ? 'bg-yellow-100 text-yellow-700' : '' }}
                                {{ $siswa->status == 'keluar' ? 'bg-red-100 text-red-700' : '' }}
                                {{ $siswa->status == 'lulus' ? 'bg-purple-100 text-purple-700' : '' }}">
                                {{ ucfirst($siswa->status) }}
                            </span>
                        </td>
                        <td class="px-4 py-3 text-center">
                            <div class="flex items-center justify-center space-x-2">
                                <a href="{{ route('admin.siswa.show', $siswa) }}" class="w-8 h-8 rounded-full bg-green-100 text-green-600 flex items-center justify-center hover:bg-green-200" title="Detail">
                                    <i class="fas fa-eye text-xs"></i>
                                </a>
                                <a href="{{ route('admin.siswa.edit', $siswa) }}" class="w-8 h-8 rounded-full bg-blue-100 text-blue-600 flex items-center justify-center hover:bg-blue-200" title="Edit">
                                    <i class="fas fa-edit text-xs"></i>
                                </a>
                                <form action="{{ route('admin.siswa.destroy', $siswa) }}" method="POST" class="inline" onsubmit="return confirm('Yakin hapus data siswa {{ $siswa->nama_lengkap }}?')">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="w-8 h-8 rounded-full bg-red-100 text-red-600 flex items-center justify-center hover:bg-red-200" title="Hapus">
                                        <i class="fas fa-trash text-xs"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="8" class="px-4 py-12 text-center text-gray-500">
                            <i class="fas fa-search text-4xl mb-3 text-gray-300"></i>
                            <p>Data siswa tidak ditemukan</p>
                            <p class="text-sm">Coba ubah filter atau tambah data baru</p>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        <!-- Pagination -->
        <div class="mt-6 flex items-center justify-between">
            <p class="text-sm text-gray-500">
                Menampilkan {{ $siswas->firstItem() ?? 0 }} - {{ $siswas->lastItem() ?? 0 }} dari {{ $siswas->total() }} data
            </p>
            {{ $siswas->links() }}
        </div>
    </div>
</div>

<!-- Modal Import -->
<div id="modal-import" class="fixed inset-0 bg-black bg-opacity-50 hidden flex items-center justify-center z-50" onclick="if(event.target === this) this.classList.add('hidden')">
    <div class="bg-white rounded-lg p-6 w-[450px] shadow-xl">
        <div class="flex items-center justify-between mb-4">
            <h3 class="text-lg font-bold">Import Data Siswa</h3>
            <button onclick="document.getElementById('modal-import').classList.add('hidden')" class="text-gray-400 hover:text-gray-600">
                <i class="fas fa-times"></i>
            </button>
        </div>
        <form action="{{ route('admin.siswa.import') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700 mb-2">File Excel/CSV</label>
                <input type="file" name="file" accept=".xlsx,.xls,.csv" required
                       class="w-full border rounded-lg px-3 py-2 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100">
                <p class="text-xs text-gray-500 mt-2">
                    <i class="fas fa-info-circle mr-1"></i>
                    Format: NIS, NISN, Nama, Jenis Kelamin (L/P), Tempat Lahir, Tanggal Lahir, Alamat, No HP, Email, Nama Ortu, No HP Ortu, Kelas ID, Tanggal Masuk
                </p>
            </div>
            <div class="flex justify-end gap-2">
                <button type="button" onclick="document.getElementById('modal-import').classList.add('hidden')" 
                        class="px-4 py-2 border rounded-lg hover:bg-gray-50">Batal</button>
                <button type="submit" class="px-4 py-2 bg-purple-600 text-white rounded-lg hover:bg-purple-700">
                    <i class="fas fa-upload mr-2"></i>Import
                </button>
            </div>
        </form>
    </div>
</div>
@endsection

@push('scripts')
<script>
    // Close modal with Escape key
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') {
            document.getElementById('modal-import').classList.add('hidden');
        }
    });
</script>
@endpush