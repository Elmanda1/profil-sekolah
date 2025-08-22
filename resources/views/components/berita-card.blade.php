@props(['artikel'])

<div class='h-[60vh] w-[30vw] bg-[#fffffb] flex flex-col gap-6 shadow-lg p-4 rounded-lg hover:-translate-y-2 transition-all duration-300'>
    @if($artikel->gambar && file_exists(public_path('storage/' . $artikel->gambar)))
        <img src="{{ asset('storage/' . $artikel->gambar) }}" 
             alt="Gambar {{ $artikel->judul_berita }}" 
             class='w-full h-72 object-cover rounded-lg'>
    @else
        <div class="w-full h-72 bg-gray-200 flex items-center justify-center rounded-lg">
            <svg class="w-20 h-20 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                      d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"></path>
            </svg>
        </div>
    @endif

    <div class='flex flex-col gap-3'>
        <h3 class='text-2xl font-semibold mt-2 line-clamp-2'>{{ $artikel->judul }}</h3>
        <div class='flex items-center gap-2 text-gray-600'>
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                      d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
            </svg>
            <span>{{ \Carbon\Carbon::parse($artikel->tanggal)->format('d M Y') }}</span>
            @if($artikel->penulis)
                <span>•</span>
                <span>{{ $artikel->penulis }}</span>
            @endif
        </div>
        <p class='line-clamp-4 text-gray-700'>{{ strip_tags($artikel->isi) }}</p>
        <a href="{{ route('frontend.berita.detail', $artikel->id_artikel) }}" 
           class='text-blue-600 hover:text-blue-800 font-semibold mt-2 inline-block'>
            Baca Selengkapnya →
        </a>
    </div>
</div>
