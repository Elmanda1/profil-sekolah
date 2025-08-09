@php
    $recentPrestasi = \App\Models\Prestasi::with('siswa')->orderBy('id_prestasi', 'desc')->take(6)->get();
@endphp

<div class='min-h-full w-full flex flex-col justify-start pt-10 items-center gap-10 pb-30'>
    <h1 class='font-semibold text-5xl'>Prestasi</h1>
    
    <div class='grid grid-cols-3 gap-4 mt-10'>
        @forelse($recentPrestasi as $prestasi)
            <x-prestasi-card :prestasi="$prestasi"/>
        @empty
            <div class='col-span-3 text-center py-10'>
                <p class='text-gray-500'>Belum ada data prestasi.</p>
            </div>
        @endforelse
    </div>
    
    @if($recentPrestasi->count() > 0)
        <div class='hover:-translate-y-2 transition-all duration-300 hover:shadow-xl'>
            <a href='/prestasi' class='bg-green-50 px-4 py-2 text-lg rounded-full border-2 text-green-600 border-green-600 font-semibold'>Lihat Lebih Banyak</a>
        </div>
    @endif
</div>