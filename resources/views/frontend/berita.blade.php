@extends('layouts.frontend')

@section('title', 'berita')

@section('content')
    <div class='w-full bg-gray-100 py-20'>
        <div class='container mx-auto px-4'>
            <div class='flex flex-col gap-2 items-center justify-center'>
                <div class='font-bold text-5xl text-gray-800'>Warta Sekolah</div>
                <div class='text-lg text-gray-600'>Informasi terkini seputar kegiatan, acara, dan pengumuman sekolah</div>
            </div>
        </div>
    </div>

    <div class='w-full flex flex-col justify-center items-center py-16 px-4'>
        <div class='text-sm text-gray-600 mb-8'>Total: {{ $artikels->total() }} berita</div>
        
        <div class='grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mt-8'>
            @forelse($artikels as $item)
                <x-content-card :item="$item" type="berita"/>
            @empty
                <div class="col-span-full text-center py-12">
                    <p class="text-gray-500 text-lg">Belum ada berita tersedia</p>
                </div>
            @endforelse
        </div>

        <!-- Pagination -->
        @if($artikels->hasPages())
            <div class="mt-12 flex justify-center">
                <nav class="flex items-center space-x-1">
                    {{-- Previous Page Link --}}
                    @if ($artikels->onFirstPage())
                        <span class="px-4 py-2 text-gray-400 bg-gray-100 rounded-lg cursor-not-allowed">← Previous</span>
                    @else
                        <a href="{{ $artikels->previousPageUrl() }}" class="px-4 py-2 text-gray-700 bg-white rounded-lg hover:bg-green-100 transition-colors duration-200">← Previous</a>
                    @endif

                    {{-- Page Numbers --}}
                    @php
                        $currentPage = $artikels->currentPage();
                        $lastPage = $artikels->lastPage();
                        $pageRange = 2; // Number of pages to show around the current page
                        $startPage = max(1, $currentPage - $pageRange);
                        $endPage = min($lastPage, $currentPage + $pageRange);
                    @endphp

                    @if ($startPage > 1)
                        <a href="{{ $artikels->url(1) }}" class="px-4 py-2 text-gray-700 bg-white rounded-lg hover:bg-green-100 transition-colors duration-200">1</a>
                        @if ($startPage > 2)
                            <span class="px-4 py-2 text-gray-400 bg-gray-100 rounded-lg cursor-not-allowed">...</span>
                        @endif
                    @endif

                    @for ($i = $startPage; $i <= $endPage; $i++)
                        @if ($i == $currentPage)
                            <span class="px-4 py-2 bg-green-600 text-white rounded-lg">{{ $i }}</span>
                        @else
                            <a href="{{ $artikels->url($i) }}" class="px-4 py-2 text-gray-700 bg-white rounded-lg hover:bg-green-100 transition-colors duration-200">{{ $i }}</a>
                        @endif
                    @endfor

                    @if ($endPage < $lastPage)
                        @if ($endPage < $lastPage - 1)
                            <span class="px-4 py-2 text-gray-400 bg-gray-100 rounded-lg cursor-not-allowed">...</span>
                        @endif
                        <a href="{{ $artikels->url($lastPage) }}" class="px-4 py-2 text-gray-700 bg-white rounded-lg hover:bg-green-100 transition-colors duration-200">{{ $lastPage }}</a>
                    @endif

                    {{-- Next Page Link --}}
                    @if ($artikels->hasMorePages())
                        <a href="{{ $artikels->nextPageUrl() }}" class="px-4 py-2 text-gray-700 bg-white rounded-lg hover:bg-green-100 transition-colors duration-200">Next →</a>
                    @else
                        <span class="px-4 py-2 text-gray-400 bg-gray-100 rounded-lg cursor-not-allowed">Next →</span>
                    @endif
                </nav>
            </div>
        @endif
    </div>
@endsection