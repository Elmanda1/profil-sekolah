<div class="bg-gray-50 py-20">
    <div class="container mx-auto px-4">
        <div class="max-w-2xl mx-auto text-center mb-16">
            <h2 class="text-3xl font-bold text-gray-900 mb-4">Apa Kata Mereka?</h2>
            <p class="text-gray-600">Dengarkan pengalaman langsung dari siswa dan alumni kami</p>
        </div>

        <div class="relative" x-data="{ activeSlide: 1 }">
            <!-- Previous Button -->
            <button @click="activeSlide = activeSlide === 1 ? 3 : activeSlide - 1" class="absolute left-0 top-1/2 transform -translate-y-1/2 -translate-x-4 lg:-translate-x-8 bg-white rounded-full p-3 shadow-lg hover:bg-gray-50 transition-all duration-200 z-10">
                <svg class="w-6 h-6 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                </svg>
            </button>

            <!-- Next Button -->
            <button @click="activeSlide = activeSlide === 3 ? 1 : activeSlide + 1" class="absolute right-0 top-1/2 transform -translate-y-1/2 translate-x-4 lg:translate-x-8 bg-white rounded-full p-3 shadow-lg hover:bg-gray-50 transition-all duration-200 z-10">
                <svg class="w-6 h-6 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                </svg>
            </button>

            <!-- Testimonial 1 -->
            <div x-show="activeSlide === 1" class="max-w-4xl mx-auto" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 transform scale-90" x-transition:enter-end="opacity-100 transform scale-100" x-transition:leave="transition ease-in duration-300" x-transition:leave-start="opacity-100 transform scale-100" x-transition:leave-end="opacity-0 transform scale-90">
                <div class="bg-white rounded-2xl shadow-xl p-8 md:p-12 text-center">
                    <img src="https://i.pravatar.cc/150?img=32" alt="Student 1" class="w-24 h-24 rounded-full mx-auto mb-6 object-cover">
                    <p class="text-gray-600 text-lg mb-6">"SMAN 100 Jakarta memberikan saya kesempatan untuk mengembangkan bakat dan minat. Para guru sangat supportif dan fasilitas yang tersedia sangat memadai."</p>
                    <div>
                        <h4 class="text-xl font-semibold text-gray-900">Ahmad Syarifuddin</h4>
                        <p class="text-green-600">Alumni 2024</p>
                    </div>
                </div>
            </div>

            <!-- Testimonial 2 -->
            <div x-show="activeSlide === 2" class="max-w-4xl mx-auto" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 transform scale-90" x-transition:enter-end="opacity-100 transform scale-100" x-transition:leave="transition ease-in duration-300" x-transition:leave-start="opacity-100 transform scale-100" x-transition:leave-end="opacity-0 transform scale-90">
                <div class="bg-white rounded-2xl shadow-xl p-8 md:p-12 text-center">
                    <img src="https://i.pravatar.cc/150?img=26" alt="Student 2" class="w-24 h-24 rounded-full mx-auto mb-6 object-cover">
                    <p class="text-gray-600 text-lg mb-6">"Program ekstrakurikuler di sekolah ini sangat beragam. Saya bisa mengembangkan hobi sekaligus mendapatkan prestasi di bidang yang saya sukai."</p>
                    <div>
                        <h4 class="text-xl font-semibold text-gray-900">Sarah Amalia</h4>
                        <p class="text-green-600">Siswa Kelas XII</p>
                    </div>
                </div>
            </div>

            <!-- Testimonial 3 -->
            <div x-show="activeSlide === 3" class="max-w-4xl mx-auto" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 transform scale-90" x-transition:enter-end="opacity-100 transform scale-100" x-transition:leave="transition ease-in duration-300" x-transition:leave-start="opacity-100 transform scale-100" x-transition:leave-end="opacity-0 transform scale-90">
                <div class="bg-white rounded-2xl shadow-xl p-8 md:p-12 text-center">
                    <img src="https://i.pravatar.cc/150?img=69" alt="Parent" class="w-24 h-24 rounded-full mx-auto mb-6 object-cover">
                    <p class="text-gray-600 text-lg mb-6">"Sebagai orang tua, saya sangat puas dengan kualitas pendidikan di SMAN 100 Jakarta. Anak saya mengalami perkembangan yang signifikan baik secara akademik maupun karakter."</p>
                    <div>
                        <h4 class="text-xl font-semibold text-gray-900">Budi Santoso</h4>
                        <p class="text-green-600">Orang Tua Siswa</p>
                    </div>
                </div>
            </div>

            <!-- Indicators -->
            <div class="flex justify-center mt-8 space-x-3">
                <button @click="activeSlide = 1" :class="{'bg-green-600': activeSlide === 1, 'bg-gray-300': activeSlide !== 1}" class="w-3 h-3 rounded-full transition-colors duration-200"></button>
                <button @click="activeSlide = 2" :class="{'bg-green-600': activeSlide === 2, 'bg-gray-300': activeSlide !== 2}" class="w-3 h-3 rounded-full transition-colors duration-200"></button>
                <button @click="activeSlide = 3" :class="{'bg-green-600': activeSlide === 3, 'bg-gray-300': activeSlide !== 3}" class="w-3 h-3 rounded-full transition-colors duration-200"></button>
            </div>
        </div>
    </div>
</div>