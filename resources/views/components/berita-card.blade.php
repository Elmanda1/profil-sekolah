@props(['artikel'])

<div class="flex-shrink-0 w-80 mr-6">
    <div class="bg-white/80 backdrop-blur-sm rounded-xl shadow-lg overflow-hidden group transition-all duration-300 hover:-translate-y-2 hover:shadow-2xl border border-gray-100">
        <a href="{{ route('frontend.berita.detail', $artikel->id_artikel) }}" class="block">
            <div class="relative overflow-hidden">
                @if($artikel->gambar && file_exists(public_path('storage/' . $artikel->gambar)))
                    <img src="{{ asset('storage/' . $artikel->gambar) }}" alt="Gambar {{ $artikel->judul }}" 
                        class="w-full h-48 object-cover transform transition-transform duration-500 group-hover:scale-110">
                    <div class="absolute inset-0 bg-gradient-to-t from-black/20 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                @else
                    <div class="w-full h-48 bg-gradient-to-br from-green-50 to-gray-100 flex items-center justify-center group-hover:from-green-100 group-hover:to-gray-200 transition-colors duration-300">
                        <svg class="w-16 h-16 text-green-500/50" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"></path>
                        </svg>
                    </div>
                @endif
                <div class="absolute top-4 right-4">
                    <span class="bg-white/90 backdrop-blur-sm text-green-600 text-xs font-semibold px-3 py-1 rounded-full">
                        {{ \Carbon\Carbon::parse($artikel->tanggal)->format('d M Y') }}
                    </span>
                </div>
            </div>
            <div class="p-6">
                <h3 class="text-lg font-bold line-clamp-2 mb-3 group-hover:text-green-600 transition-colors">{{ $artikel->judul }}</h3>
                <div class="flex items-center text-sm text-gray-600">
                    <svg class="w-4 h-4 mr-2 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"/>
                    </svg>
                    <span>Berita Sekolah</span>
                </div>
            </div>
        </a>
    </div>
</div>