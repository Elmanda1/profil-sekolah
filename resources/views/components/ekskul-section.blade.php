{{-- resources/views/components/ekskul-section.blade.php --}}

<div class="bg-white py-20">
    <div class="container mx-auto px-4">
        <div class="flex justify-between items-center mb-12">
            <h2 class="text-3xl font-bold">Ekstrakurikuler</h2>
            <div class="flex gap-4">
                <button class='prevEkskulBtn bg-gray-200 rounded-full p-2 shadow-md hover:bg-gray-300 transition-all duration-200'>
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                    </svg>
                </button>
                <button class='nextEkskulBtn bg-gray-200 rounded-full p-2 shadow-md hover:bg-gray-300 transition-all duration-200'>
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                    </svg>
                </button>
            </div>
        </div>
        <div class='relative w-full overflow-hidden'>
            <div class="ekskul-container flex transition-transform duration-500 ease-in-out">
                {{-- Cards will be handled by JavaScript for the slider --}}
                <x-ekskul-card title="Basket" image="{{ asset('photos/club_basket_fix.png') }}" />
                <x-ekskul-card title="Bola" image="{{ asset('photos/club_bola.png') }}" />
                <x-ekskul-card title="Hockey" image="{{ asset('photos/club_hockey.png') }}" />
                <x-ekskul-card title="Musik" image="{{ asset('photos/pentas_seni.jpeg') }}" />
                <x-ekskul-card title="Sains" image="{{ asset('photos/lomba_matematika.jpg') }}" />
            </div>
        </div>
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