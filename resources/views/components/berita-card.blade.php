@props(['artikel'])

<div class="flex-shrink-0 w-80 mr-6">
    <div class="bg-white rounded-lg shadow-lg overflow-hidden group transform transition-all duration-300 hover:-translate-y-2 hover:shadow-2xl">
        <a href="{{ route('frontend.berita.detail', $artikel->id_artikel) }}" class="block">
            @if($artikel->gambar && file_exists(public_path('storage/' . $artikel->gambar)))
                <img src="{{ asset('storage/' . $artikel->gambar) }}" alt="Gambar {{ $artikel->judul }}" class="w-full h-48 object-cover">
            @else
                <div class="w-full h-48 bg-gray-200 flex items-center justify-center">
                    <svg class="w-16 h-16 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"></path>
                    </svg>
                </div>
            @endif
            <div class="p-6">
                <h3 class="text-lg font-bold line-clamp-2 mb-2">{{ $artikel->judul }}</h3>
                <p class="text-sm text-gray-600">{{ \Carbon\Carbon::parse($artikel->tanggal)->format('d M Y') }}</p>
            </div>
        </a>
    </div>
</div>