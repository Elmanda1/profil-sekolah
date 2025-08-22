@extends('layouts.frontend')

@section('title', 'berita')

@section('content')
    <div class='min-h-screen w-full flex flex-col justify-center items-center py-40'>
        <div class='flex flex-col gap-4 items-center justify-center'>
            <div class='font-semibold text-4xl'>Warta Sekolah</div>
            <div class='text-lg'>Informasi terkini seputar kegiatan, acara, dan pengumuman sekolah</div>
            <div class='text-sm text-gray-600'>Total: {{ $artikels->total() }} berita</div>
        </div>
        
        <div class='grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mt-8 px-4'>
            @forelse($artikels as $item)
                <x-berita-card :artikel="$item"/>
            @empty
                <div class="col-span-full text-center py-12">
                    <p class="text-gray-500 text-lg">Belum ada berita tersedia</p>
                </div>
            @endforelse
        </div>

        <!-- Pagination -->
        @if($artikels->hasPages())
            <div class="mt-8 flex justify-center">
                <nav class="flex items-center space-x-2">
                    {{-- Previous Page Link --}}
                    @if ($artikels->onFirstPage())
                        <span class="px-3 py-2 text-gray-400 cursor-not-allowed">← Previous</span>
                    @else
                        <a href="{{ $artikels   ->previousPageUrl() }}" class="px-3 py-2 text-blue-600 hover:text-blue-800">← Previous</a>
                    @endif

                    {{-- Page Numbers --}}
                    @for ($i = 1; $i <= $artikels->lastPage(); $i++)
                        @if ($i == $artikels->currentPage())
                            <span class="px-3 py-2 bg-blue-600 text-white rounded">{{ $i }}</span>
                        @else
                            <a href="{{ $artikels->url($i) }}" class="px-3 py-2 text-blue-600 hover:text-blue-800 hover:bg-gray-100 rounded">{{ $i }}</a>
                        @endif
                    @endfor

                    {{-- Next Page Link --}}
                    @if ($artikels->hasMorePages())
                        <a href="{{ $artikels->nextPageUrl() }}" class="px-3 py-2 text-blue-600 hover:text-blue-800">Next →</a>
                    @else
                        <span class="px-3 py-2 text-gray-400 cursor-not-allowed">Next →</span>
                    @endif
                </nav>
            </div>
        @endif
    </div>
@endsection