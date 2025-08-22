@php
    // Ambil 5 berita terbaru untuk ditampilkan di homepage
    $latestArtikel = \App\Models\Artikel::orderBy('tanggal', 'desc')->take(5)->get();
@endphp

<div class='flex flex-col h-[70vh] w-full justify-start items-center pb-10 gap-12'>
    <div>
        <h1 class='font-semibold text-5xl'>Berita Sekolah</h1>
    </div>
    <div class='flex w-full h-full relative'>
        <div class='flex w-1/12 justify-center items-center'>
            <button id='prevBtn' class='text-[5rem] text-gray-600 hover:text-gray-800 transition-colors z-50 absolute left-3'><</button>
        </div>
        <div id='beritaContainer' class='flex h-full justify-start items-center gap-4 z-0 pl-20'>
            @forelse($latestArtikel as $artikels)
                <div class='relative berita-card  h-72 w-100 flex-shrink-0 border-3 border-green-600 rounded-lg flex flex-col justify-center items-center hover:-translate-y-2 hover:shadow-xl transition-all duration-300'>
                    @if($artikels->gambar && file_exists(public_path('storage/' . $artikels->gambar)))
                        <div class='absolute inset-0 rounded-lg overflow-hidden'>
                            <img src="{{ asset('storage/' . $artikels->gambar) }}" 
                                 alt="Gambar {{ $artikels->judul }}" 
                                 class='w-full h-full object-cover opacity-30'>
                            <div class='absolute inset-0 bg-opacity-70'></div>
                        </div>
                    @else
                        <div class="w-full h-72 bg-gray-200 flex items-center justify-center rounded-lg">
                            <svg class="w-20 h-20 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                      d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"></path>
                            </svg>
                        </div>

                    @endif
                    
                    <div class='absolute -bottom-10 w-92 h-36 bg-[#fffffb] rounded-lg flex justify-center items-center p-4'>
                        <div class='text-center'>
                            <h1 class='uppercase font-semibold text-black text-sm line-clamp-3'>
                                {{ $artikels->judul }}
                            </h1>
                            <p class='text-xs text-gray-600 mt-2'>
                                {{ \Carbon\Carbon::parse($artikels->tanggal)->format('d M Y') }}
                            </p>
                        </div>
                    </div>
                    
                    <!-- Link to detail -->
                    <a href="{{ route('frontend.berita.detail', $artikels->id_artikel) }}" class='absolute inset-0 z-50'></a>
                </div>
            @empty
                <div class='flex justify-center items-center w-full h-full'>
                    <p class='text-gray-500 text-lg'>Belum ada berita tersedia</p>
                </div>
            @endforelse
        </div>
        <div class='flex w-1/12 justify-center items-center'>
            <button id='nextBtn' class='text-[5rem] text-gray-600 hover:text-gray-800 transition-colors absolute right-3'>></button>
        </div>
    </div>
    <div class='hover:-translate-y-2 transition-all duration-300 hover:shadow-xl'>
        <a href='{{ route('frontend.berita') }}' class='bg-green-50 px-4 py-2 text-lg rounded-full border-2 text-green-600 border-green-600 font-semibold'>Lihat Lebih Banyak</a>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const container = document.getElementById('beritaContainer');
    const prevBtn = document.getElementById('prevBtn');
    const nextBtn = document.getElementById('nextBtn');
    const cards = document.querySelectorAll('.berita-card');
    
    if (cards.length > 0) {
        let currentIndex = 0;
        const cardWidth = cards[0].offsetWidth; // width + gap
        
        prevBtn.addEventListener('click', function() {
            if (currentIndex > 0) {
                currentIndex--;
                container.style.transform = `translateX(-${currentIndex * cardWidth}px)`;
            }
        });
        
        nextBtn.addEventListener('click', function() {
            if (currentIndex < cards.length - 4) { // Show 3 cards at once
                currentIndex++;
                container.style.transform = `translateX(-${currentIndex * cardWidth}px)`;
            }
        });
        
        // Add smooth transition
        container.style.transition = 'transform 0.3s ease-in-out';
    }
});
</script>

<style>
.line-clamp-3 {
    display: -webkit-box;
    -webkit-line-clamp: 3;
    -webkit-box-orient: vertical;
    overflow: hidden;
}
</style>