@php
    // Ambil 5 berita terbaru untuk ditampilkan di homepage
    $latestArtikel = \App\Models\Artikel::orderBy('tanggal', 'desc')->take(5)->get();
@endphp

<div class="relative bg-gradient-to-b from-gray-50 to-white py-20 overflow-hidden">
    <!-- Decorative Elements -->
    <div class="absolute top-0 left-0 w-full h-64 bg-green-50/50"></div>
    <div class="absolute bottom-0 right-0 w-96 h-96 bg-green-100/30 rounded-full blur-3xl transform translate-x-1/2 translate-y-1/2"></div>
    
    <div class="container mx-auto px-4 relative">
        <div class="flex flex-col md:flex-row justify-between items-center mb-12">
            <div class="text-center md:text-left mb-6 md:mb-0">
                <h2 class="text-3xl font-bold text-gray-900 mb-2">Berita Terbaru</h2>
                <p class="text-gray-600">Informasi terkini seputar SMAN 100 Jakarta</p>
            </div>
            <div class="flex gap-4">
                <button id="prevBtn" class="bg-white rounded-full p-3 shadow-lg hover:bg-green-50 hover:text-green-600 transition-all duration-300 transform hover:scale-105 group">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">    
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                    </svg>
                </button>
                <button id="nextBtn" class="bg-white rounded-full p-3 shadow-md hover:bg-gray-300 transition-all duration-200">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                    </svg>
                </button>
            </div>
        </div>
        <div id="beritaContainer" class="flex overflow-x-auto pb-4 -mx-4 px-4">
            @forelse($latestArtikel as $artikel)
                                <div class="transform transition-all duration-500 hover:scale-[1.02]">
                    <x-berita-card :artikel="$artikel" />
                </div>
            @empty
                <div class="col-span-3 text-center py-10">
                    <div class="bg-white rounded-lg shadow-md p-8 max-w-lg mx-auto">
                        <svg class="w-16 h-16 text-green-500/50 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"/>
                        </svg>
                        <p class="text-gray-500 mb-4">Belum ada berita terbaru.</p>
                        <p class="text-gray-400 text-sm">Berita akan ditampilkan di sini setelah dipublikasikan.</p>
                    </div>
                </div>
            @endforelse
        </div>
        @if($latestArtikel->count() > 0)
            <div class="text-center mt-12">
                <a href="{{ route('frontend.berita') }}" class="inline-flex items-center justify-center bg-green-600 hover:bg-green-700 text-white font-bold py-4 px-8 rounded-full transition-all duration-300 transform hover:scale-105 hover:shadow-lg group gap-2">
                    <span>Lihat Semua Berita</span>
                    <svg class="w-5 h-5 group-hover:translate-x-1 transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/>
                    </svg>
                </a>
            </div>
        @endif
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const container = document.getElementById('beritaContainer');
    const prevBtn = document.getElementById('prevBtn');
    const nextBtn = document.getElementById('nextBtn');
    
    if (container) {
        prevBtn.addEventListener('click', function() {
            container.scrollBy({
                left: -300, // Adjust scroll amount as needed
                behavior: 'smooth'
            });
        });
        
        nextBtn.addEventListener('click', function() {
            container.scrollBy({
                left: 300, // Adjust scroll amount as needed
                behavior: 'smooth'
            });
        });
    }
});
</script>