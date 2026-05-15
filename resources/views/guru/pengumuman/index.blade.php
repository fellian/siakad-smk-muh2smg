@extends('layouts.guru')

@section('title', 'Pengumuman')
@section('page-title', 'Pengumuman Sekolah')

@section('content')
<div class="bg-white rounded-2xl shadow-sm border border-gray-100">
    <div class="p-6 border-b border-gray-100">
        <h3 class="text-lg font-bold text-gray-900">Daftar Pengumuman</h3>
        <p class="text-sm text-gray-500 mt-1">Informasi dan pengumuman resmi dari sekolah untuk guru.</p>
    </div>

    <div class="p-6">
        <x-pengumuman-list
            :pengumumans="$pengumumans"
            show-route="guru.pengumuman.show"
        />

        @if($pengumumans->hasPages())
            <div class="mt-6">{{ $pengumumans->links() }}</div>
        @endif
    </div>
</div>
@endsection
