@props(['prestasis' => collect()])
@php
    $prestasis = $prestasis ?? \App\Models\Prestasi::recent(3)->get();
@endphp

<div class="bg-gray-100 py-20">
    <div class="container mx-auto px-4">
        <h2 class="text-3xl font-bold text-center mb-12">Prestasi Terbaru</h2>
        <div class='relative w-full flex justify-center items-center'>
            <button class='prevPrestasiBtn absolute left-0 transform -translate-x-1/2 top-1/2 -translate-y-1/2 bg-white rounded-full p-2 shadow-md hover:bg-gray-200 transition-all duration-200 z-10'>
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                </svg>
            </button>
            <button class='nextPrestasiBtn absolute right-0 transform translate-x-1/2 top-1/2 -translate-y-1/2 bg-white rounded-full p-2 shadow-md hover:bg-gray-200 transition-all duration-200 z-10'>
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                </svg>
            </button>

            <div class='prestasi-container'>
                @forelse ($prestasis as $prestasi)
                    <x-prestasi-slider
                        :tanggal=" \Carbon\Carbon::parse($prestasi->tanggal)->format('d M Y') "
                        :judul="$prestasi->judul"
                        :deskripsi="$prestasi->deskripsi"
                    />
                @empty
                    <div class="text-gray-500">Belum ada data prestasi.</div>
                @endforelse
            </div>
        </div>
    </div>
</div>

@once
@push('scripts')
<script>
{!! file_get_contents(resource_path('js/prestasi-slider.js')) !!}
</script>
@endpush
@endonce
