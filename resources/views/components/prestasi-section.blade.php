@php
    $recentPrestasi = \App\Models\Prestasi::with('siswa')->orderBy('id_prestasi', 'desc')->take(6)->get();
@endphp

<div class="bg-gray-50 py-20">
    <div class="container mx-auto px-4">
        <h2 class="text-3xl font-bold text-center mb-12">Prestasi Sekolah</h2>
        
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            @forelse($recentPrestasi as $prestasi)
                <x-prestasi-card :prestasi="$prestasi"/>
            @empty
                <div class="col-span-3 text-center py-10">
                    <p class="text-gray-500">Belum ada data prestasi.</p>
                </div>
            @endforelse
        </div>
        
        @if($recentPrestasi->count() > 0)
            <div class="text-center mt-12">
                <a href="/prestasi" class="bg-green-600 hover:bg-green-700 text-white font-bold py-3 px-8 rounded-full transition-all duration-300">Lihat Semua Prestasi</a>
            </div>
        @endif
    </div>
</div>