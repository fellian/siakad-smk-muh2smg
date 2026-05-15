@extends('layouts.siswa')

@section('title', $pengumuman->judul)
@section('page-title', 'Detail Pengumuman')

@section('content')
<div class="max-w-3xl">
    <a href="{{ route('siswa.pengumuman.index') }}" class="inline-flex items-center text-sm font-medium text-blue-700 hover:text-blue-900 mb-4">
        <i class="fas fa-arrow-left mr-2"></i>Kembali ke daftar pengumuman
    </a>

    <article class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="bg-gradient-to-r from-blue-800 to-blue-900 px-6 py-8 text-white">
            <span @class([
                'inline-block px-3 py-1 rounded-full text-xs font-semibold mb-3',
                'bg-white/20' => $pengumuman->target === 'semua',
                'bg-blue-400/30' => $pengumuman->target === 'siswa',
            ])>
                {{ $pengumuman->target === 'semua' ? 'Untuk Semua' : 'Untuk Siswa' }}
            </span>
            <h1 class="text-2xl font-bold leading-snug">{{ $pengumuman->judul }}</h1>
            <p class="text-blue-100 text-sm mt-3">
                <i class="far fa-calendar mr-1"></i>
                Dipublikasikan {{ $pengumuman->created_at->translatedFormat('d F Y, H:i') }}
                @if($pengumuman->user)
                    · {{ $pengumuman->user->name }}
                @endif
            </p>
        </div>

        <div class="p-6">
            <div class="flex flex-wrap gap-4 text-sm text-gray-500 mb-6 pb-6 border-b border-gray-100">
                <span>
                    <i class="fas fa-play-circle mr-1 text-blue-600"></i>
                    Mulai: {{ $pengumuman->tanggal_mulai->translatedFormat('d F Y') }}
                </span>
                @if($pengumuman->tanggal_selesai)
                    <span>
                        <i class="fas fa-stop-circle mr-1 text-red-500"></i>
                        Berakhir: {{ $pengumuman->tanggal_selesai->translatedFormat('d F Y') }}
                    </span>
                @endif
            </div>

            <div class="prose prose-sm max-w-none text-gray-700 whitespace-pre-line leading-relaxed">
                {!! nl2br(e($pengumuman->isi)) !!}
            </div>
        </div>
    </article>
</div>
@endsection
