@extends('layouts.frontend')

@section('title', $artikel->judul_artikel)

@section('content')
    <div class='min-h-screen w-full py-20'>
        <div class='max-w-4xl mx-auto px-4'>
            <!-- Breadcrumb -->
            <nav class='flex items-center space-x-2 text-sm text-gray-600 mb-8'>
                <a href='/' class='hover:text-blue-600'>Home</a>
                <span>→</span>
                <a href='{{ route('frontend.berita') }}' class='hover:text-blue-600'>artikel</a>
                <span>→</span>
                <span class='text-gray-900'>{{ Str::limit($artikel->judul, 50) }}</span>
            </nav>

            <!-- Article Header -->
            <header class='mb-8'>
                <h1 class='text-4xl font-bold text-gray-900 mb-4'>{{ $artikel->judul }}</h1>
                
                <div class='flex items-center gap-4 text-gray-600 mb-6'>
                    <div class='flex items-center gap-2'>
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                        </svg>
                        <span>{{ \Carbon\Carbon::parse($artikel->tanggal)->format('d F Y') }}</span>
                    </div>
                    
                    @if($artikel->penulis)
                        <div class='flex items-center gap-2'>
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                            </svg>
                            <span>{{ $artikel->penulis }}</span>
                        </div>
                    @endif
                </div>
            </header>

            <!-- Featured Image -->
            @if($artikel->gambar && file_exists(public_path('storage/' . $artikel->gambar)))
                <div class='mb-8'>
                    <img src="{{ asset('storage/' . $artikel->gambar) }}" 
                         alt="Gambar {{ $artikel->judul_artikel }}" 
                         class='w-full h-96 object-cover rounded-lg shadow-lg'>
                </div>
            @else
                <div class='mb-8 w-full h-96 object-cover rounded-lg shadow-lg flex items-center justify-center'>
                    tidak ada gambar
                </div>
            @endif

            <!-- Article Content -->
            <article class='prose prose-lg max-w-none mb-12'>
                <div class='text-gray-800 leading-relaxed'>
                    {!! nl2br(e($artikel->isi)) !!}
                </div>
            </article>

            <!-- Back Button -->
            <div class='border-t pt-8'>
                <a href='{{ route('frontend.berita') }}'
                   class='inline-flex items-center gap-2 px-6 py-3 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors'>
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                    </svg>
                    Kembali ke artikel
                </a>
            </div>

            <!-- Related Articles -->
            @php
                $relatedartikel = \App\Models\artikel::where('id_artikel', '!=', $artikel->id_artikel)
                                                   ->orderBy('tanggal', 'desc')
                                                   ->take(3)
                                                   ->get();
            @endphp

            @if($relatedartikel->count() > 0)
                <section class='mt-16'>
                    <h2 class='text-2xl font-bold text-gray-900 mb-8'>artikel Lainnya</h2>
                    
                    <div class='grid grid-cols-1 md:grid-cols-3 gap-6'>
                        @foreach($relatedartikel as $related)
                            <article class='bg-white rounded-lg shadow-lg overflow-hidden hover:-translate-y-2 transition-all duration-300'>
                                @if($related->gambar && file_exists(public_path('storage/' . $related->gambar)))
                                    <img src="{{ asset('storage/' . $related->gambar) }}" 
                                         alt="Gambar {{ $related->judul_artikel }}" 
                                         class='w-full h-48 object-cover'>
                                @else
                                    <div class="w-full h-48 bg-gray-200 flex items-center justify-center">
                                        <svg class="w-12 h-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"></path>
                                        </svg>
                                    </div>
                                @endif
                                
                                <div class='p-4'>
                                    <h3 class='font-semibold text-lg mb-2 line-clamp-2'>
                                        <a href="{{ route('frontend.berita.detail', $related->id_artikel) }}" 
                                           class='hover:text-blue-600 transition-colors'>
                                            {{ $related->judul }}
                                        </a>
                                    </h3>
                                    
                                    <p class='text-gray-600 text-sm mb-3'>
                                        {{ \Carbon\Carbon::parse($related->tanggal)->format('d M Y') }}
                                    </p>
                                    
                                    <p class='text-gray-700 text-sm line-clamp-3'>
                                        {{ Str::limit(strip_tags($related->isi), 120) }}
                                    </p>
                                </div>
                            </article>
                        @endforeach
                    </div>
                </section>
            @endif
        </div>
    </div>
@endsection

<style>
.line-clamp-2 {
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
    overflow: hidden;
}

.line-clamp-3 {
    display: -webkit-box;
    -webkit-line-clamp: 3;
    -webkit-box-orient: vertical;
    overflow: hidden;
}
</style>