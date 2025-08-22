@extends('layouts.frontend')
@section('title', 'Prestasi')
@section('content')
    <div class='min-h-screen w-full flex flex-col justify-center items-center py-40'>
        <div class='flex flex-col gap-4 items-center justify-center'>
            <div class='font-semibold text-4xl'>Prestasi Sekolah</div>
            <div class='text-lg'>Galeri Penghargaan dan Pencapaian Siswa dan Sekolah</div>
            <div class='text-sm text-gray-600'>Total: {{ $prestasis->total() }} Prestasi</div>
        </div>
        
        <div class='grid grid-cols-3 gap-6 mt-8'>
            @forelse($prestasis as $item)
                <x-berita-prestasi-card :prestasi="$item"/>
            @empty
                <div class='col-span-3 text-center py-20'>
                    <p class='text-gray-500 text-lg'>Belum ada data prestasi.</p>
                </div>
            @endforelse
        </div>

                @if($prestasis->hasPages())
            <div class="mt-8 flex justify-center">
                <nav class="flex items-center space-x-2">
                    {{-- Previous Page Link --}}
                    @if ($prestasis->onFirstPage())
                        <span class="px-3 py-2 text-gray-400 cursor-not-allowed">← Previous</span>
                    @else
                        <a href="{{ $prestasis->previousPageUrl() }}" class="px-3 py-2 text-blue-600 hover:text-blue-800">← Previous</a>
                    @endif

                    {{-- Page Numbers --}}
                    @for ($i = 1; $i <= $prestasis->lastPage(); $i++)
                        @if ($i == $prestasis->currentPage())
                            <span class="px-3 py-2 bg-blue-600 text-white rounded">{{ $i }}</span>
                        @else
                            <a href="{{ $prestasis->url($i) }}" class="px-3 py-2 text-blue-600 hover:text-blue-800 hover:bg-gray-100 rounded">{{ $i }}</a>
                        @endif
                    @endfor

                    {{-- Next Page Link --}}
                    @if ($prestasis->hasMorePages())
                        <a href="{{ $prestasis->nextPageUrl() }}" class="px-3 py-2 text-blue-600 hover:text-blue-800">Next →</a>
                    @else
                        <span class="px-3 py-2 text-gray-400 cursor-not-allowed">Next →</span>
                    @endif
                </nav>
            </div>
        @endif

    </div>
@endsection