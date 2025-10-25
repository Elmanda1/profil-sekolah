@props([
    'title' => '',
    'image' => '',
])

<div class="flex-shrink-0 w-80 mr-6">
    <div class="group bg-white rounded-lg shadow-md overflow-hidden transition-all duration-300 hover:shadow-2xl hover:-translate-y-2 border border-gray-200">
        <div class="overflow-hidden">
            <img src="{{ $image }}" alt="{{ $title }}" class="w-full h-56 object-cover group-hover:scale-110 transition-transform duration-300">
        </div>
        <div class="p-6">
            <h3 class="text-xl font-bold text-gray-800">{{ $title }}</h3>
        </div>
    </div>
</div>
