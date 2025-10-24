@props([
    'title' => '',
    'image' => '',
])

<div class="flex-shrink-0 w-80 mr-6">
    <div class="group bg-white rounded-lg shadow-lg overflow-hidden transition-all duration-300 hover:shadow-xl hover:-translate-y-2">
        <img src="{{ $image }}" alt="{{ $title }}" class="w-full h-56 object-cover">
        <div class="p-6">
            <h3 class="text-xl font-bold">{{ $title }}</h3>
        </div>
    </div>
</div>
