@extends('layouts.frontend')

@section('title', 'berita')

@section('content')
    <div class='min-h-screen w-full flex flex-col justify-center items-center py-40'>
        <div class='flex flex-col gap-4 items-center justify-center'>
            <div class='font-semibold text-4xl'>Warta Sekolah</div>
            <div class='text-lg'>Informasi terkini seputar kegiatan, acara, dan pengumuman sekolah</div>
            <div class='text-sm text-gray-600'>Total: {{ $berita->total() }} berita</div>
        </div>
        
        <div class='grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mt-8 px-4'>
            @forelse($berita as $item)
                <div class='h-[60vh] w-full bg-[#fffffb] flex flex-col gap-6 shadow-lg p-4 rounded-lg hover:-translate-y-2 transition-all duration-300'>
                    @if($item->gambar && file_exists(public_path('storage/' . $item->gambar)))
                        <img src="{{ asset('storage/' . $item->gambar) }}" 
                             alt="Gambar {{ $item->judul_berita }}" 
                             class='w-full h-72 object-cover rounded-lg'>
                    @else
                        <div class="w-full h-72 bg-gray-200 flex items-center justify-center rounded-lg">
                            <svg class="w-20 h-20 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"></path>
                            </svg>
                        </div>
                    @endif
                    
                    <div class='flex flex-col gap-3'>
                        <h3 class='text-2xl font-semibold mt-2 line-clamp-2'>{{ $item->judul_berita }}</h3>
                        <div class='flex items-center gap-2 text-gray-600'>
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                            </svg>
                            <span>{{ \Carbon\Carbon::parse($item->tanggal_berita)->format('d M Y') }}</span>
                            @if($item->penulis)
                                <span>•</span>
                                <span>{{ $item->penulis }}</span>
                            @endif
                        </div>
                        <p class='line-clamp-4 text-gray-700'>{{ strip_tags($item->isi_berita) }}</p>
                        <a href="{{ route('frontend.berita.detail', $item->id_berita) }}" 
                           class='text-blue-600 hover:text-blue-800 font-semibold mt-2 inline-block'>
                            Baca Selengkapnya →
                        </a>
                    </div>
                </div>
            @empty
                <div class="col-span-full text-center py-12">
                    <p class="text-gray-500 text-lg">Belum ada berita tersedia</p>
                </div>
            @endforelse
        </div>

        <!-- Pagination -->
        @if($berita->hasPages())
            <div class="mt-8 flex justify-center">
                <nav class="flex items-center space-x-2">
                    {{-- Previous Page Link --}}
                    @if ($berita->onFirstPage())
                        <span class="px-3 py-2 text-gray-400 cursor-not-allowed">← Previous</span>
                    @else
                        <a href="{{ $berita->previousPageUrl() }}" class="px-3 py-2 text-blue-600 hover:text-blue-800">← Previous</a>
                    @endif

                    {{-- Page Numbers --}}
                    @for ($i = 1; $i <= $berita->lastPage(); $i++)
                        @if ($i == $berita->currentPage())
                            <span class="px-3 py-2 bg-blue-600 text-white rounded">{{ $i }}</span>
                        @else
                            <a href="{{ $berita->url($i) }}" class="px-3 py-2 text-blue-600 hover:text-blue-800 hover:bg-gray-100 rounded">{{ $i }}</a>
                        @endif
                    @endfor

                    {{-- Next Page Link --}}
                    @if ($berita->hasMorePages())
                        <a href="{{ $berita->nextPageUrl() }}" class="px-3 py-2 text-blue-600 hover:text-blue-800">Next →</a>
                    @else
                        <span class="px-3 py-2 text-gray-400 cursor-not-allowed">Next →</span>
                    @endif
                </nav>
            </div>
        @endif
    </div>
@endsection