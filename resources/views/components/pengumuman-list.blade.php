@props(['pengumumans', 'showRoute' => 'siswa.pengumuman.show', 'emptyMessage' => 'Belum ada pengumuman aktif.'])

<div class="space-y-4">
    @forelse($pengumumans as $p)
        <a href="{{ route($showRoute, $p) }}" class="block border border-gray-200 rounded-xl p-5 hover:border-blue-200 hover:bg-blue-50/30 transition-all duration-200">
            <div class="flex items-start space-x-4">
                <div @class([
                    'w-10 h-10 rounded-lg flex items-center justify-center flex-shrink-0',
                    'bg-purple-100 text-purple-600' => $p->target === 'semua',
                    'bg-blue-100 text-blue-600' => $p->target === 'siswa',
                    'bg-green-100 text-green-600' => $p->target === 'guru',
                ])>
                    <i class="fas fa-bullhorn"></i>
                </div>
                <div class="min-w-0 flex-1">
                    <h4 class="font-bold text-gray-800 text-sm mb-1 line-clamp-1">{{ $p->judul }}</h4>
                    <p class="text-sm text-gray-500 mb-2 line-clamp-2">{{ Str::limit(strip_tags($p->isi), 120) }}</p>
                    <p class="text-xs text-gray-400 font-medium">
                        <i class="far fa-clock mr-1"></i>{{ $p->created_at->translatedFormat('d F Y') }}
                        @if($p->tanggal_selesai)
                            <span class="mx-1">·</span>
                            Berlaku s/d {{ $p->tanggal_selesai->translatedFormat('d M Y') }}
                        @endif
                    </p>
                </div>
                <i class="fas fa-chevron-right text-gray-300 text-sm mt-1"></i>
            </div>
        </a>
    @empty
        <div class="text-center py-10 text-gray-500">
            <i class="fas fa-bullhorn text-4xl text-gray-300 mb-3"></i>
            <p>{{ $emptyMessage }}</p>
        </div>
    @endforelse
</div>
