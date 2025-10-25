@props([
    'tanggal' => '',
    'judul' => '',
    'deskripsi' => '',
])

<div class="prestasi-slider h-[60vh] w-[80vw] bg-white rounded-lg shadow-lg p-10 flex flex-col justify-between border border-gray-200">
    <div>
        <p class="text-sm text-gray-500">{{ $tanggal }}</p>
        <h1 class="font-bold text-4xl mt-2 text-gray-800">{{ $judul }}</h1>
    </div>
    <p class="text-lg text-gray-700">{{ $deskripsi }}</p>
</div>
