@extends('layouts.admin')

@section('title', 'Aktivitas Sistem')
@section('page-title', 'AKTIVITAS SISTEM')

@section('content')

    <!-- Header & Navigasi Breadcrumb -->
    <div class="mb-8 flex flex-col md:flex-row md:items-center md:justify-between gap-4">
        <div>
            <h1 class="text-3xl font-bold text-blue-900 mb-2">Log Aktivitas Sistem</h1>
            <p class="text-gray-500 text-sm sm:text-base">Riwayat seluruh aktivitas pengguna dan pencatatan sistem</p>
        </div>
        <div>
            <a href="{{ route('admin.dashboard') }}" class="inline-flex items-center space-x-2 text-sm font-semibold text-gray-500 hover:text-blue-600 bg-white px-4 py-2.5 rounded-xl border border-gray-100 shadow-sm transition-colors">
                <i class="fas fa-arrow-left text-xs"></i>
                <span>Kembali ke Dashboard</span>
            </a>
        </div>
    </div>

    <!-- Konten Utama -->
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
        <!-- Tabel Aktivitas -->
        <div class="overflow-x-auto">
            <table class="w-full text-left text-sm whitespace-nowrap">
                <thead class="bg-gray-50/70 text-gray-500 font-semibold uppercase text-xs tracking-wider border-b border-gray-100">
                    <tr>
                        <th class="px-6 py-4 w-16 text-center">No</th>
                        <th class="px-6 py-4">Pengguna</th>
                        <th class="px-6 py-4">Aktivitas Sistem</th>
                        <th class="px-6 py-4">Waktu</th>
                        <th class="px-6 py-4 w-28">Status</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse($activities as $index => $activity)
                        <tr class="hover:bg-gray-50/40 transition-colors">
                            <!-- Nomor Urut Otomatis Pagination -->
                            <td class="px-6 py-4 text-center font-medium text-gray-400 text-xs">
                                {{ $activities->firstItem() + $index }}
                            </td>

                            <!-- Pengguna & Inisial Bulat -->
                            <td class="px-6 py-4">
                                <div class="flex items-center space-x-3">
                                    <div class="w-8 h-8 rounded-full bg-blue-50 text-blue-600 flex items-center justify-center font-bold text-xs flex-shrink-0 ring-1 ring-gray-100 shadow-sm">
                                        {{ 
                                            collect(explode(' ', $activity->user->name ?? 'Sistem'))
                                                ->map(fn($word) => strtoupper(substr($word, 0, 1)))
                                                ->take(2)
                                                ->implode('') 
                                        }}
                                    </div>
                                    <div>
                                        <div class="font-medium text-gray-900 leading-tight">
                                            {{ $activity->user->name ?? 'Sistem Utama' }}
                                        </div>
                                        <div class="text-[11px] text-gray-400 mt-0.5">
                                            {{ $activity->user->email ?? 'system@internal' }}
                                        </div>
                                    </div>
                                </div>
                            </td>

                            <!-- Deskripsi Aktivitas -->
                            <td class="px-6 py-4 text-gray-600 font-medium">
                                {{ $activity->activity }}
                            </td>

                            <!-- Waktu Terperinci -->
                            <td class="px-6 py-4">
                                <div class="text-gray-700 text-xs font-medium">
                                    {{ $activity->created_at->diffForHumans() }}
                                </div>
                                <div class="text-[10px] text-gray-400 mt-0.5">
                                    {{ $activity->created_at->format('d M Y • H:i:s') }} WIB
                                </div>
                            </td>

                            <!-- Status Badge -->
                            <td class="px-6 py-4">
                                @if(strtolower($activity->status) == 'sukses')
                                    <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-semibold bg-green-50 text-green-700 ring-1 ring-inset ring-green-600/10">
                                        <span class="w-1.5 h-1.5 rounded-full bg-green-500"></span>
                                        Sukses
                                    </span>
                                @else
                                    <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-semibold bg-rose-50 text-rose-700 ring-1 ring-inset ring-rose-600/10">
                                        <span class="w-1.5 h-1.5 rounded-full bg-rose-500"></span>
                                        Gagal
                                    </span>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-6 py-12 text-center text-gray-400 text-sm">
                                <div class="flex flex-col items-center justify-center space-y-2">
                                    <i class="fas fa-history text-3xl text-gray-200"></i>
                                    <span>Belum ada rekam aktivitas sistem yang tersimpan.</span>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($activities->hasPages())
            <div class="px-6 py-4 border-t border-gray-100 bg-gray-50/30">
                {{ $activities->links() }}
            </div>
        @endif

    </div>

@endsection