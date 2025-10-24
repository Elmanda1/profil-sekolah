@props([
    'tanggal' => '',
    'judul' => '',
    'deskripsi' => '',
])

<div class="prestasi-slider h-[60vh] w-[80vw] bg-white/10 backdrop-blur-lg rounded-lg shadow-lg p-10 flex flex-col justify-between text-white">
    <div>
        <p class="text-sm text-gray-300">{{ $tanggal }}</p>
        <h1 class="font-bold text-4xl mt-2">{{ $judul }}</h1>
    </div>
    <p class="text-lg">{{ $deskripsi }}</p>
</div>
