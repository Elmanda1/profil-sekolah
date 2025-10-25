@extends('layouts.frontend')
@section('title', 'Prestasi')
@section('content')
    <div class='w-full bg-gray-100 py-20'>
        <div class='container mx-auto px-4'>
            <div class='flex flex-col gap-2 items-center justify-center'>
                <div class='font-bold text-5xl text-gray-800'>Prestasi Sekolah</div>
                <div class='text-lg text-gray-600'>Galeri Penghargaan dan Pencapaian Siswa dan Sekolah</div>
            </div>
        </div>
    </div>

    <div class='w-full flex flex-col justify-center items-center py-16 px-4'>
        <div class='text-sm text-gray-600 mb-8'>Total: {{ $prestasis->total() }} Prestasi</div>
        
        <div class='grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mt-8'>
            @forelse($prestasis as $item)
                <x-content-card :item="$item" type="prestasi"/>
            @empty
                <div class="col-span-full text-center py-12">
                    <p class='text-gray-500 text-lg'>Belum ada data prestasi.</p>
                </div>
            @endforelse
        </div>

                @if($prestasis->hasPages())
            <div class="mt-12 flex justify-center">
                <nav class="flex items-center space-x-1">
                    {{-- Previous Page Link --}}
                    @if ($prestasis->onFirstPage())
                        <span class="px-4 py-2 text-gray-400 bg-gray-100 rounded-lg cursor-not-allowed">← Previous</span>
                    @else
                        <a href="{{ $prestasis->previousPageUrl() }}" class="px-4 py-2 text-gray-700 bg-white rounded-lg hover:bg-green-100 transition-colors duration-200">← Previous</a>
                    @endif

                    {{-- Page Numbers --}}
                    @for ($i = 1; $i <= $prestasis->lastPage(); $i++)
                        @if ($i == $prestasis->currentPage())
                            <span class="px-4 py-2 bg-green-600 text-white rounded-lg">{{ $i }}</span>
                        @else
                            <a href="{{ $prestasis->url($i) }}" class="px-4 py-2 text-gray-700 bg-white rounded-lg hover:bg-green-100 transition-colors duration-200">{{ $i }}</a>
                        @endif
                    @endfor

                    {{-- Next Page Link --}}
                    @if ($prestasis->hasMorePages())
                        <a href="{{ $prestasis->nextPageUrl() }}" class="px-4 py-2 text-gray-700 bg-white rounded-lg hover:bg-green-100 transition-colors duration-200">Next →</a>
                    @else
                        <span class="px-4 py-2 text-gray-400 bg-gray-100 rounded-lg cursor-not-allowed">Next →</span>
                    @endif
                </nav>
            </div>
        @endif

    </div>
@endsection