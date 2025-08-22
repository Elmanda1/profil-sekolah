@extends('layouts.frontend')

@section('title', 'profil-siswa')

@section('content')
    <div class='min-h-screen w-full flex flex-col justify-center items-center py-40'>
        <div class='flex flex-col gap-4 items-center justify-center'>
            <div class='font-semibold text-4xl'>Profil Siswa</div>
            <div class='text-lg'>Semua siswa dalam SMA Negeri 100 Jakarta</div>
            <div class='text-sm text-gray-600'>Total: {{ $siswas->total() }} siswa</div>
        </div>
        
        <div class='grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-4 mt-8 px-4'>
            @forelse($siswas as $student)
                <div class='group relative h-72 w-64 bg-[#fffffb] rounded-lg shadow-lg overflow-hidden'>
                    @if($student->foto && file_exists(public_path('storage/' . $student->foto)))
                        <img src="{{ asset('storage/' . $student->foto) }}" 
                             alt="Foto {{ $student->nama_siswa }}" 
                             class='w-full h-full object-cover rounded'>
                    @else
                        <div class="w-full h-full bg-gray-200 flex items-center justify-center">
                            <svg class="w-20 h-20 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd"></path>
                            </svg>
                        </div>
                    @endif
                    
                    <div class='absolute w-full bottom-3  transition-transform duration-400 translate-y-6 group-hover:translate-y-0 bg-white bg-opacity-90 backdrop-blur-sm rounded-lg p-3'>
                        <h3 class='text-lg font-semibold mt-2 truncate' title="{{ $student->nama_siswa }}">
                            {{ $student->nama_siswa }}
                        </h3>
                        <p class='text-gray-600'>NIS: {{ $student->nisn }}</p>
                        @if($student->jenis_kelamin)
                            <p class='text-gray-500'>{{ $student->jenis_kelamin == 'L' ? 'Laki-laki' : 'Perempuan' }}</p>
                        @endif
                        @if($student->tanggal_lahir)
                            <p class='text-gray-500 text-sm'>{{ \Carbon\Carbon::parse($student->tanggal_lahir)->format('d M Y') }}</p>
                        @endif
                    </div>
                </div>
            @empty
                <div class="col-span-full text-center py-12">
                    <p class="text-gray-500 text-lg">Belum ada data siswa</p>
                </div>
            @endforelse
        </div>

        <!-- Pagination -->
        @if($siswas->hasPages())
            <div class="mt-8 flex justify-center">
                <nav class="flex items-center space-x-2">
                    {{-- Previous Page Link --}}
                    @if ($siswas->onFirstPage())
                        <span class="px-3 py-2 text-gray-400 cursor-not-allowed">← Previous</span>
                    @else
                        <a href="{{ $siswas->previousPageUrl() }}" class="px-3 py-2 text-blue-600 hover:text-blue-800">← Previous</a>
                    @endif

                    {{-- Page Numbers --}}
                    @for ($i = 1; $i <= $siswas->lastPage(); $i++)
                        @if ($i == $siswas->currentPage())
                            <span class="px-3 py-2 bg-blue-600 text-white rounded">{{ $i }}</span>
                        @else
                            <a href="{{ $siswas->url($i) }}" class="px-3 py-2 text-blue-600 hover:text-blue-800 hover:bg-gray-100 rounded">{{ $i }}</a>
                        @endif
                    @endfor

                    {{-- Next Page Link --}}
                    @if ($siswas->hasMorePages())
                        <a href="{{ $siswas->nextPageUrl() }}" class="px-3 py-2 text-blue-600 hover:text-blue-800">Next →</a>
                    @else
                        <span class="px-3 py-2 text-gray-400 cursor-not-allowed">Next →</span>
                    @endif
                </nav>
            </div>
        @endif
    </div>
@endsection