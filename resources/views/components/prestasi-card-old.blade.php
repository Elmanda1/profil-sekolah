@props(['prestasi'])

<div>
    <div class='h-[60vh] w-[30vw] bg-[#fffffb] flex flex-col gap-6 shadow-lg p-4 rounded-lg hover:-translate-y-2 transition-all duration-300'>
        @if($prestasi->foto ?? false)
            <img src="{{ asset('storage/' . $prestasi->foto) }}" alt="{{ $prestasi->nama_prestasi }}" class='w-full h-72 object-cover rounded-lg'>
        @else
        <div class="w-full h-72 bg-gray-200 flex items-center justify-center rounded-lg">
            <svg class="w-20 h-20 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                      d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"></path>
            </svg>
        </div>
        @endif
        
        <div class='flex flex-col gap-3'>
            <h3 class='text-2xl font-semibold mt-2'>{{ $prestasi->judul }}</h3>
            
            @if($prestasi->siswa)
                <p class='text-gray-600'>Siswa: {{ $prestasi->siswa->nama_siswa }}</p>
            @endif
            <div class='flex items-center gap-2 text-gray-600'>
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                          d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                </svg>
                <span>{{ \Carbon\Carbon::parse($prestasi->tanggal)->format('d M Y') }}</span>
            </div>
            
            @if($prestasi->deskripsi)
                <p class='line-clamp-4'>{{ $prestasi->deskripsi }}</p>
            @else
                <p class='line-clamp-4'>{{ $prestasi->nama_prestasi }} merupakan prestasi yang membanggakan bagi sekolah dan menunjukkan dedikasi siswa dalam mencapai keunggulan.</p>
            @endif
        </div>
    </div>
</div>