@props(['prestasi'])

<div class='h-56 w-132 bg-[#fffffb] rounded-lg flex justify-start items-center px-7 hover:-translate-y-2 hover:shadow-xl transition-all duration-300'>
    <div class='w-1/3 h-full flex justify-center items-center'>
        @if($prestasi->foto ?? false)
            <img src="{{ asset('storage/' . $prestasi->foto) }}" alt="{{ $prestasi->nama_prestasi }}" class='h-40 w-40 object-cover rounded-lg'>
        @else
            <div class='h-40 w-40 bg-purple-300 flex justify-center items-center rounded-lg'>
                <span class='text-white text-sm'>Foto Prestasi</span>
            </div>
        @endif
    </div>    
    
    <div class='w-full h-full flex flex-col justify-center items-start gap-2 pl-4'>
        <h1 class='font-semibold text-lg text-gray-900'>{{ $prestasi->judul }}</h1>
        
        @if($prestasi->siswa)
            <p class='text-gray-600 text-sm'>{{ $prestasi->siswa->nama_siswa }}</p>
        @endif

        @if($prestasi->deskripsi)
            <p class='text-gray-600 text-sm line-clamp-3'>{{ $prestasi->deskripsi }}</p>
        @endif


        @if($prestasi->tanggal)
            <div class='flex items-center gap-2 text-gray-600'>
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                          d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                </svg>
                <span>{{ \Carbon\Carbon::parse($prestasi->tanggal)->format('d M Y') }}</span>
            </div>
        @endif
    </div>
</div>