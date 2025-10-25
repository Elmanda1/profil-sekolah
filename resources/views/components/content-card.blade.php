@props([
    'item',
    'type' // 'berita' or 'prestasi'
])

<div class="bg-white rounded-lg shadow-lg overflow-hidden group transform transition-all duration-300 hover:-translate-y-2 hover:shadow-2xl border border-gray-200">
    <a href="{{ $type === 'berita' ? route('frontend.berita.detail', $item->id_artikel) : '#' }}" class="block">
        <div class="relative">
            @if($item->gambar && file_exists(public_path('storage/' . $item->gambar)))
                <img src="{{ asset('storage/' . $item->gambar) }}" alt="Gambar {{ $item->judul }}" class="w-full h-56 object-cover">
            @elseif($item->foto && file_exists(public_path('storage/' . $item->foto)))
                <img src="{{ asset('storage/' . $item->foto) }}" alt="Gambar {{ $item->judul }}" class="w-full h-56 object-cover">
            @else
                <div class="w-full h-56 bg-gray-200 flex items-center justify-center">
                    <svg class="w-16 h-16 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        @if($type === 'berita')
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"></path>
                        @else
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        @endif
                    </svg>
                </div>
            @endif
        </div>
        <div class="p-6">
            <h3 class="text-xl font-bold line-clamp-2 mb-2 text-gray-800">{{ $item->judul }}</h3>
            @if($type === 'prestasi' && $item->siswa)
                <p class="text-gray-600 text-sm mb-2">{{ $item->siswa->nama_siswa }}</p>
            @endif
            <p class="text-gray-600 text-sm line-clamp-3 mb-4">{{ Str::limit(strip_tags($item->deskripsi ?? $item->isi), 120) }}</p>
            <div class="flex items-center justify-between text-sm text-gray-500">
                <span>{{ \Carbon\Carbon::parse($item->tanggal)->format('d M Y') }}</span>
                <span class="font-semibold text-green-600 hover:text-green-700">Read More →</span>
            </div>
        </div>
    </a>
</div>
