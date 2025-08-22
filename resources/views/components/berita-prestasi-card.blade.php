@props(['prestasi'])

<div>
    <div class='h-[60vh] w-[30vw] bg-[#fffffb] flex flex-col gap-6 shadow-lg p-4 rounded-lg hover:-translate-y-2 transition-all duration-300'>
        @if($prestasi->foto ?? false)
            <img src="{{ asset('storage/' . $prestasi->foto) }}" alt="{{ $prestasi->nama_prestasi }}" class='w-full h-72 object-cover rounded-lg'>
        @else
            <div class='w-full h-72 bg-purple-300 flex justify-center items-center rounded-lg'>
                <span class='text-white'>Foto Prestasi</span>
            </div>
        @endif
        
        <div class='flex flex-col gap-3'>
            <h3 class='text-2xl font-semibold mt-2'>{{ $prestasi->judul }}</h3>
            
            @if($prestasi->siswa)
                <p class='text-gray-600'>Siswa: {{ $prestasi->siswa->nama_siswa }}</p>
            @endif
            
            @if($prestasi->tahun)
                <p class='flex gap-2 text-black'><span>📅</span>{{ $prestasi->tahun }}</p>
            @endif
            
            @if($prestasi->deskripsi)
                <p class='line-clamp-4'>{{ $prestasi->deskripsi }}</p>
            @else
                <p class='line-clamp-4'>{{ $prestasi->nama_prestasi }} merupakan prestasi yang membanggakan bagi sekolah dan menunjukkan dedikasi siswa dalam mencapai keunggulan.</p>
            @endif
        </div>
    </div>
</div>