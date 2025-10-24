@php
    // Ambil 5 berita terbaru untuk ditampilkan di homepage
    $latestArtikel = \App\Models\Artikel::orderBy('tanggal', 'desc')->take(5)->get();
@endphp

<div class="bg-white py-20">
    <div class="container mx-auto px-4">
        <div class="flex justify-between items-center mb-12">
            <h2 class="text-3xl font-bold">Berita Terbaru</h2>
            <div class="flex gap-4">
                <button id="prevBtn" class="bg-gray-200 rounded-full p-2 shadow-md hover:bg-gray-300 transition-all duration-200">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                    </svg>
                </button>
                <button id="nextBtn" class="bg-gray-200 rounded-full p-2 shadow-md hover:bg-gray-300 transition-all duration-200">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                    </svg>
                </button>
            </div>
        </div>
        <div id="beritaContainer" class="flex overflow-x-auto pb-4 -mx-4 px-4">
            @forelse($latestArtikel as $artikel)
                <x-berita-card :artikel="$artikel" />
            @empty
                <div class="w-full text-center py-10">
                    <p class="text-gray-500">Belum ada data berita.</p>
                </div>
            @endforelse
        </div>
        @if($latestArtikel->count() > 0)
            <div class="text-center mt-12">
                <a href="{{ route('frontend.berita') }}" class="bg-green-600 hover:bg-green-700 text-white font-bold py-3 px-8 rounded-full transition-all duration-300">Lihat Semua Berita</a>
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