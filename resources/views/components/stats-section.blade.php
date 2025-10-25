<div class="bg-green-600 py-20">
    <div class="container mx-auto px-4">
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">
            <!-- Total Siswa -->
            <div class="bg-white/10 backdrop-blur-md p-6 rounded-lg text-center transform transition-all duration-300 hover:scale-105">
                <div class="inline-block p-4 bg-white/20 rounded-full mb-4">
                    <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
                    </svg>
                </div>
                <div class="text-4xl font-bold text-white mb-2" x-data="{ count: 0 }" x-init="
                    new IntersectionObserver((entries) => {
                        entries.forEach(entry => {
                            if (entry.isIntersecting) {
                                let counter = 0;
                                const target = 1250;
                                const duration = 2000;
                                const step = timestamp => {
                                    if (!start) start = timestamp;
                                    const progress = timestamp - start;
                                    counter = Math.min(Math.floor((progress / duration) * target), target);
                                    $el.textContent = counter.toLocaleString();
                                    if (progress < duration) {
                                        window.requestAnimationFrame(step);
                                    }
                                };
                                let start = null;
                                window.requestAnimationFrame(step);
                            }
                        });
                    }).observe($el);" x-text="count">0</div>
                <p class="text-white/90">Total Siswa</p>
            </div>

            <!-- Guru Berpengalaman -->
            <div class="bg-white/10 backdrop-blur-md p-6 rounded-lg text-center transform transition-all duration-300 hover:scale-105">
                <div class="inline-block p-4 bg-white/20 rounded-full mb-4">
                    <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path d="M12 14l9-5-9-5-9 5 9 5z"/>
                        <path d="M12 14l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14z"/>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l9-5-9-5-9 5 9 5zm0 0l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14zm-4 6v-7.5l4-2.222"/>
                    </svg>
                </div>
                <div class="text-4xl font-bold text-white mb-2" x-data="{ count: 0 }" x-init="
                    new IntersectionObserver((entries) => {
                        entries.forEach(entry => {
                            if (entry.isIntersecting) {
                                let counter = 0;
                                const target = 85;
                                const duration = 2000;
                                const step = timestamp => {
                                    if (!start) start = timestamp;
                                    const progress = timestamp - start;
                                    counter = Math.min(Math.floor((progress / duration) * target), target);
                                    $el.textContent = counter;
                                    if (progress < duration) {
                                        window.requestAnimationFrame(step);
                                    }
                                };
                                let start = null;
                                window.requestAnimationFrame(step);
                            }
                        });
                    }).observe($el);" x-text="count">0</div>
                <p class="text-white/90">Guru Berpengalaman</p>
            </div>

            <!-- Program Studi -->
            <div class="bg-white/10 backdrop-blur-md p-6 rounded-lg text-center transform transition-all duration-300 hover:scale-105">
                <div class="inline-block p-4 bg-white/20 rounded-full mb-4">
                    <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                    </svg>
                </div>
                <div class="text-4xl font-bold text-white mb-2" x-data="{ count: 0 }" x-init="
                    new IntersectionObserver((entries) => {
                        entries.forEach(entry => {
                            if (entry.isIntersecting) {
                                let counter = 0;
                                const target = 4;
                                const duration = 2000;
                                const step = timestamp => {
                                    if (!start) start = timestamp;
                                    const progress = timestamp - start;
                                    counter = Math.min(Math.floor((progress / duration) * target), target);
                                    $el.textContent = counter;
                                    if (progress < duration) {
                                        window.requestAnimationFrame(step);
                                    }
                                };
                                let start = null;
                                window.requestAnimationFrame(step);
                            }
                        });
                    }).observe($el);" x-text="count">0</div>
                <p class="text-white/90">Program Studi</p>
            </div>

            <!-- Prestasi -->
            <div class="bg-white/10 backdrop-blur-md p-6 rounded-lg text-center transform transition-all duration-300 hover:scale-105">
                <div class="inline-block p-4 bg-white/20 rounded-full mb-4">
                    <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z"/>
                    </svg>
                </div>
                <div class="text-4xl font-bold text-white mb-2" x-data="{ count: 0 }" x-init="
                    new IntersectionObserver((entries) => {
                        entries.forEach(entry => {
                            if (entry.isIntersecting) {
                                let counter = 0;
                                const target = 120;
                                const duration = 2000;
                                const step = timestamp => {
                                    if (!start) start = timestamp;
                                    const progress = timestamp - start;
                                    counter = Math.min(Math.floor((progress / duration) * target), target);
                                    $el.textContent = counter.toLocaleString();
                                    if (progress < duration) {
                                        window.requestAnimationFrame(step);
                                    }
                                };
                                let start = null;
                                window.requestAnimationFrame(step);
                            }
                        });
                    }).observe($el);" x-text="count">0</div>
                <p class="text-white/90">Prestasi</p>
            </div>
        </div>
    </div>
</div>