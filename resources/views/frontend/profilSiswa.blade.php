@extends('layouts.frontend')

@section('title', 'Profil Siswa')

@section('content')
<section class="py-20 bg-gray-50">
    <div class="container mx-auto px-4">
        <div class="max-w-2xl mx-auto text-center mb-12">
            <h2 class="text-4xl font-bold text-gray-800">Profil Siswa</h2>
            <p class="text-lg text-gray-600 mt-4">Semua siswa dalam SMA Negeri 100 Jakarta.</p>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-8">
            @forelse($siswas as $student)
                <div class="text-center">
                    <div class="relative w-32 h-32 mx-auto mb-4">
                        @if($student->foto && file_exists(public_path('storage/' . $student->foto)))
                            <img src="{{ asset('storage/' . $student->foto) }}" alt="Foto {{ $student->nama_siswa }}" class="w-full h-full object-cover rounded-full shadow-md">
                        @else
                            <div class="w-full h-full bg-gray-200 flex items-center justify-center rounded-full shadow-md">
                                <svg class="w-16 h-16 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd"></path>
                                </svg>
                            </div>
                        @endif
                    </div>
                    <div class="bg-white rounded-lg shadow-md p-3 max-w-xs mx-auto">
                        <h3 class="text-xl font-bold text-gray-800">{{ $student->nama_siswa }}</h3>
                        <p class="text-gray-600">NIS: {{ $student->nisn }}</p>
                    </div>
                </div>
            @empty
                <div class="col-span-full text-center py-12">
                    <p class="text-gray-500 text-lg">Belum ada data siswa</p>
                </div>
            @endforelse
        </div>

        @if($siswas->hasPages())
            <div class="mt-12 flex justify-center">
                <nav class="flex items-center space-x-1">
                    {{-- Previous Page Link --}}
                    @if ($siswas->onFirstPage())
                        <span class="px-4 py-2 text-gray-400 bg-gray-100 rounded-lg cursor-not-allowed">← Previous</span>
                    @else
                        <a href="{{ $siswas->previousPageUrl() }}" class="px-4 py-2 text-gray-700 bg-white rounded-lg hover:bg-green-100 transition-colors duration-200">← Previous</a>
                    @endif

                    {{-- Page Numbers --}}
                    @for ($i = 1; $i <= $siswas->lastPage(); $i++)
                        @if ($i == $siswas->currentPage())
                            <span class="px-4 py-2 bg-green-600 text-white rounded-lg">{{ $i }}</span>
                        @else
                            <a href="{{ $siswas->url($i) }}" class="px-4 py-2 text-gray-700 bg-white rounded-lg hover:bg-green-100 transition-colors duration-200">{{ $i }}</a>
                        @endif
                    @endfor

                    {{-- Next Page Link --}}
                    @if ($siswas->hasMorePages())
                        <a href="{{ $siswas->nextPageUrl() }}" class="px-4 py-2 text-gray-700 bg-white rounded-lg hover:bg-green-100 transition-colors duration-200">Next →</a>
                    @else
                        <span class="px-4 py-2 text-gray-400 bg-gray-100 rounded-lg cursor-not-allowed">Next →</span>
                    @endif
                </nav>
            </div>
        @endif
    </div>
</section>
@endsection