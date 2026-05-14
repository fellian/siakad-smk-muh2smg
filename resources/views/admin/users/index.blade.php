@extends('layouts.admin')

@section('title', 'Manajemen User')
@section('page-title', 'Manajemen Pengguna')

@section('content')
<div class="bg-white rounded-lg shadow">
    <div class="p-6 border-b">
        <h3 class="text-lg font-semibold">Daftar Pengguna</h3>
    </div>

    <div class="p-6">
        <!-- Filter -->
        <form method="GET" class="flex flex-wrap gap-3 mb-4">
            <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari nama/email..." class="border rounded-lg px-4 py-2 w-64">
            <select name="role" class="border rounded-lg px-4 py-2">
                <option value="">Semua Role</option>
                <option value="admin" {{ request('role') == 'admin' ? 'selected' : '' }}>Admin</option>
                <option value="guru" {{ request('role') == 'guru' ? 'selected' : '' }}>Guru</option>
                <option value="siswa" {{ request('role') == 'siswa' ? 'selected' : '' }}>Siswa</option>
            </select>
            <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded-lg"><i class="fas fa-search"></i></button>
        </form>

        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-4 py-3 text-left">No</th>
                        <th class="px-4 py-3 text-left">Nama</th>
                        <th class="px-4 py-3 text-left">Email</th>
                        <th class="px-4 py-3 text-center">Role</th>
                        <th class="px-4 py-3 text-center">Status</th>
                        <th class="px-4 py-3 text-left">Detail</th>
                        <th class="px-4 py-3 text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse($users as $i => $user)
                    <tr class="hover:bg-gray-50">
                        <td class="px-4 py-3">{{ $users->firstItem() + $i }}</td>
                        <td class="px-4 py-3 font-medium">{{ $user->name }}</td>
                        <td class="px-4 py-3">{{ $user->email }}</td>
                        <td class="px-4 py-3 text-center">
                            <span class="px-2 py-1 rounded text-xs {{ $user->role == 'admin' ? 'bg-red-100 text-red-700' : ($user->role == 'guru' ? 'bg-green-100 text-green-700' : 'bg-blue-100 text-blue-700') }}">
                                {{ ucfirst($user->role) }}
                            </span>
                        </td>
                        <td class="px-4 py-3 text-center">
                            <span class="px-2 py-1 rounded text-xs {{ $user->status == 'aktif' ? 'bg-green-100 text-green-700' : 'bg-gray-100 text-gray-700' }}">
                                {{ ucfirst($user->status) }}
                            </span>
                        </td>
                        <td class="px-4 py-3 text-xs text-gray-500">
                            @if($user->siswa)
                                NIS: {{ $user->siswa->nis }}
                            @elseif($user->guru)
                                NIP: {{ $user->guru->nip ?? '-' }}
                            @else
                                Administrator
                            @endif
                        </td>
                        <td class="px-4 py-3 text-center">
                            <form action="{{ route('admin.users.reset-password', $user) }}" method="POST" class="inline" onsubmit="return confirm('Reset password {{ $user->name }}?')">
                                @csrf
                                <button type="submit" class="text-yellow-600 hover:text-yellow-800 mx-1" title="Reset Password">
                                    <i class="fas fa-key"></i>
                                </button>
                            </form>
                            <form action="{{ route('admin.users.toggle-status', $user) }}" method="POST" class="inline">
                                @csrf
                                <button type="submit" class="text-{{ $user->status == 'aktif' ? 'red' : 'green' }}-600 hover:text-{{ $user->status == 'aktif' ? 'red' : 'green' }}-800 mx-1" title="{{ $user->status == 'aktif' ? 'Nonaktifkan' : 'Aktifkan' }}">
                                    <i class="fas fa-{{ $user->status == 'aktif' ? 'ban' : 'check-circle' }}"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr><td colspan="7" class="px-4 py-8 text-center text-gray-500">Tidak ada data</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="mt-4">{{ $users->links() }}</div>
    </div>
</div>
@endsection