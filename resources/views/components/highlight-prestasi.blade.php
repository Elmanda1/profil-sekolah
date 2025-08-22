@props(['prestasis' => collect()])
@php
    $prestasis = $prestasis ?? \App\Models\Prestasi::recent(3)->get();
@endphp

<div class='relative h-screen w-full flex justify-center items-center'>
    <div class='prevPrestasiBtn text-[5rem] absolute left-7 text-gray-500 hover:text-blue-500 transition-all duration-200 select-none z-10'>&#8249;</div>
    <div class='nextPrestasiBtn text-[5rem] absolute right-7 text-gray-500 hover:text-blue-500 transition-all duration-200 select-none z-10'>&#8250;</div>

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

@once
@push('scripts')
<script>
{!! file_get_contents(resource_path('js/prestasi-slider.js')) !!}
</script>
@endpush
@endonce
