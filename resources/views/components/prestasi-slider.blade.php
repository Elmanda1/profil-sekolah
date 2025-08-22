@php
    $prestasis = \App\Models\Prestasi::orderBy('tanggal', 'desc')->take(3)->get();
@endphp

@props([
    'tanggal' => '',
    'judul' => '',
    'deskripsi' => '',
])

<div 
    class="prestasi-slider h-[90vh] w-[90vw] border-2 border-green-600 bg-green-800 rounded-lg flex flex-col items-start justify-end pr-50 pl-10 pb-20 bg-cover bg-center bg-no-repeat"
>
    
    <p class='flex gap-2 text-[#fffffb]'>
        <span class='text-black'>T</span>{{ $tanggal }}
    </p>
    <h1 class='font-semibold text-4xl text-[#fffffb]'>
        {{ $judul }}
    </h1>
    <p class='text-[#fffffb]'>
        {{ $deskripsi }}
    </p>
</div>
