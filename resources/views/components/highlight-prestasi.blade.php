{{-- resources/views/components/highlight-prestasi.blade.php --}}

<div class='relative h-screen w-full flex justify-center items-center'>
    {{-- Navigation arrows --}}
    <div class='prevPrestasiBtn text-[5rem] absolute left-7 text-gray-500 hover:text-blue-500 transition-all duration-200 select-none z-10'>&#8249;</div>
    <div class='nextPrestasiBtn text-[5rem] absolute right-7 text-gray-500 hover:text-blue-500 transition-all duration-200 select-none z-10'>&#8250;</div>
    
    {{-- Prestasi cards container --}}
    <div class='prestasi-container'>
        {{-- Cards akan di-handle oleh JavaScript untuk slider --}}
            <x-prestasi-slider/>
            <x-prestasi-slider/>
            <x-prestasi-slider/>
    </div>
</div>

{{-- Include prestasi slider script --}}
@once
@push('scripts')
<script>
{!! file_get_contents(resource_path('js/prestasi-slider.js')) !!}
</script>
@endpush
@endonce