@php
    $recentPrestasi = \App\Models\Prestasi::with('siswa')->orderBy('id_prestasi', 'desc')->take(6)->get();
@endphp

<div class="bg-gradient-to-b from-white to-gray-50 py-20">
    <div class="container mx-auto px-4">
        <div class="max-w-2xl mx-auto text-center mb-12">
            <h2 class="text-3xl font-bold text-gray-900 mb-4">Prestasi Sekolah</h2>
            <p class="text-gray-600">Pencapaian membanggakan dari siswa-siswi SMAN 100 Jakarta</p>
        </div>
        
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            @forelse($recentPrestasi as $prestasi)
                <div class="group">
                    <x-content-card :item="$prestasi" type="prestasi" class="transform transition-all duration-300 hover:-translate-y-2 hover:shadow-xl"/>
                </div>
            @empty
                <div class="col-span-3 text-center py-10">
                    <div class="bg-white rounded-lg shadow-md p-8">
                        <svg class="w-16 h-16 text-gray-400 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M12 12h.01M12 14h.01M12 16h.01M12 18h.01M12 20h.01M12 22h.01"></path>
                        </svg>
                        <p class="text-gray-500">Belum ada data prestasi.</p>
                    </div>
                </div>
            @endforelse
        </div>
        
        @if($recentPrestasi->count() > 0)
            <div class="text-center mt-12">
                <a href="/prestasi" class="inline-flex items-center justify-center bg-green-600 hover:bg-green-700 text-white font-bold py-4 px-8 rounded-full transition-all duration-300 transform hover:scale-105 hover:shadow-lg gap-2">
                    <span>Lihat Semua Prestasi</span>
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/>
                    </svg>
                </a>
            </div>
        @endif
    </div>
</div>