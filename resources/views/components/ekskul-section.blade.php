{{-- resources/views/components/ekskul-section.blade.php --}}

<div class='h-[70vh] flex gap-56 items-center justify-center'>
    <div class='font-semibold text-5xl'>Semua<br>Ekstrakulikuler</div>
    <div class='relative h-[50vh] w-[40vw] flex justify-center items-center overflow-hidden'>
        <div>
            {{-- Cards akan di-handle oleh JavaScript untuk slider --}}
            <x-ekskul-card/>
            <x-ekskul-card/>
            <x-ekskul-card/>
            <x-ekskul-card/>
        </div>
        {{-- Navigation arrows --}}
        <div class='prevEkskulBtn text-[5rem] absolute left-7 text-gray-600 hover:text-blue-500 transition-all duration-200 select-none'>&#8249;</div>
        <div class='nextEkskulBtn text-[5rem] absolute right-7 text-gray-600 hover:text-blue-500 transition-all duration-200 select-none'>&#8250;</div>
    </div>  
</div>

{{-- Include slider script --}}
@once
@push('scripts')
<script>
{!! file_get_contents(resource_path('js/ekskul-slider.js')) !!}
</script>
@endpush
@endonce