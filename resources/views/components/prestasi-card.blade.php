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
        <h1 class='font-semibold text-lg text-gray-900'>{{ $prestasi->nama_prestasi }}</h1>
        
        @if($prestasi->siswa)
            <p class='text-gray-600 text-sm'>{{ $prestasi->siswa->nama_siswa }}</p>
        @endif
        
        @if($prestasi->tahun)
            <p class='flex gap-2 text-black'><span>📅</span>{{ $prestasi->tahun }}</p>
        @endif
    </div>
</div>