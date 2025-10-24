@props(['prestasi'])

<div class="bg-white rounded-lg shadow-lg overflow-hidden transform transition-all duration-300 hover:-translate-y-2 hover:shadow-2xl">
    @if($prestasi->foto ?? false)
        <img src="{{ asset('storage/' . $prestasi->foto) }}" alt="{{ $prestasi->nama_prestasi }}" class="w-full h-56 object-cover">
    @else
        <div class="w-full h-56 bg-gray-200 flex justify-center items-center">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-20 w-20 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v11.494m-5.747-5.747H17.747" />
            </svg>
        </div>
    @endif
    <div class="p-6">
        <h3 class="text-xl font-bold mb-2">{{ $prestasi->judul }}</h3>
        @if($prestasi->siswa)
            <p class="text-gray-700 text-sm mb-2">{{ $prestasi->siswa->nama_siswa }}</p>
        @endif
        @if($prestasi->deskripsi)
            <p class="text-gray-600 text-sm line-clamp-3 mb-4">{{ $prestasi->deskripsi }}</p>
        @endif
        @if($prestasi->tanggal)
            <div class="flex items-center text-sm text-gray-500">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                </svg>
                <span>{{ \Carbon\Carbon::parse($prestasi->tanggal)->format('d M Y') }}</span>
            </div>
        @endif
    </div>
</div>