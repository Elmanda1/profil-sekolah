@php
    // Ambil 5 berita terbaru untuk ditampilkan di homepage
    $latestBerita = \App\Models\Berita::orderBy('tanggal_berita', 'desc')->take(5)->get();
@endphp

<div class='flex flex-col h-[70vh] w-full justify-start items-center pb-10 gap-12'>
    <div>
        <h1 class='font-semibold text-5xl'>Berita Sekolah</h1>
    </div>
    <div class='flex w-full h-full'>
        <div class='flex w-1/12 justify-center items-center'>
            <button id='prevBtn' class='text-[5rem] text-gray-600 hover:text-gray-800 transition-colors'><</button>
        </div>
        <div id='beritaContainer' class='flex h-full w-full justify-start items-center gap-4 overflow-x-hidden'>
            @forelse($latestBerita as $berita)
                <div class='berita-card relative h-72 w-100 flex-shrink-0 bg-blue-900 rounded-lg flex flex-col justify-center items-center px-7 hover:-translate-y-2 hover:shadow-xl transition-all duration-300'>
                    @if($berita->gambar && file_exists(public_path('storage/' . $berita->gambar)))
                        <div class='absolute inset-0 rounded-lg overflow-hidden'>
                            <img src="{{ asset('storage/' . $berita->gambar) }}" 
                                 alt="Gambar {{ $berita->judul_berita }}" 
                                 class='w-full h-full object-cover opacity-30'>
                            <div class='absolute inset-0 bg-blue-900 bg-opacity-70'></div>
                        </div>
                    @endif
                    
                    <div class='absolute -bottom-10 w-92 h-36 bg-[#fffffb] rounded-lg flex justify-center items-center p-4'>
                        <div class='text-center'>
                            <h1 class='uppercase font-semibold text-black text-sm line-clamp-3'>
                                {{ $berita->judul_berita }}
                            </h1>
                            <p class='text-xs text-gray-600 mt-2'>
                                {{ \Carbon\Carbon::parse($berita->tanggal_berita)->format('d M Y') }}
                            </p>
                        </div>
                    </div>
                    
                    <!-- Link to detail -->
                    <a href="{{ route('frontend.berita.detail', $berita->id_berita) }}" class='absolute inset-0 z-10'></a>
                </div>
            @empty
                <div class='flex justify-center items-center w-full h-full'>
                    <p class='text-gray-500 text-lg'>Belum ada berita tersedia</p>
                </div>
            @endforelse
        </div>
        <div class='flex w-1/12 justify-center items-center'>
            <button id='nextBtn' class='text-[5rem] text-gray-600 hover:text-gray-800 transition-colors'>></button>
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
        const cardWidth = cards[0].offsetWidth + 16; // width + gap
        
        prevBtn.addEventListener('click', function() {
            if (currentIndex > 0) {
                currentIndex--;
                container.style.transform = `translateX(-${currentIndex * cardWidth}px)`;
            }
        });
        
        nextBtn.addEventListener('click', function() {
            if (currentIndex < cards.length - 3) { // Show 3 cards at once
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