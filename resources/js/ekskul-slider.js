// Script untuk menjalankan slider dengan 1 card per slide
// Letakkan script ini di bagian bawah layout atau di file terpisah

document.addEventListener('DOMContentLoaded', function() {
    // Variabel untuk slider
    let currentSlide = 0;
    let totalSlides = 0;
    let sliderContainer;
    let cards;
    
    // Inisialisasi slider  
    function initSlider() {
        // Ambil container yang berisi cards
        const ekskulContainer = document.querySelector('.relative.h-\\[50vh\\].w-\\[40vw\\] > div:first-child');
        
        if (!ekskulContainer) {
            console.error('Card container tidak ditemukan');
            return;
        }
        
        // Ambil semua ekskul cards
        cards = ekskulContainer.querySelectorAll('div[class*="group hover:-translate-y-2"]');
        
        if (cards.length === 0) {
            console.error('Ekskul cards tidak ditemukan');
            return;
        }
        
        // Hitung total slides (1 card per slide)
        totalSlides = cards.length;
        
        // Setup container untuk slider
        setupSliderContainer(ekskulContainer);
        
        // Setup event listeners untuk tombol navigasi
        setupNavigationButtons();
        
        // Setup dots indicator - DISABLED
        // setupDotsIndicator();
        
        // Inisialisasi posisi
        updateSliderPosition();
    }
    
    // Setup container untuk slider behavior
    function setupSliderContainer(container) {
        // Buat wrapper untuk overflow hidden
        const sliderWrapper = document.createElement('div');
        sliderWrapper.style.cssText = `
            width: 100%;
            height: 100%;
            overflow: hidden;
            position: relative;
        `;
        
        // Buat track untuk sliding
        const sliderTrack = document.createElement('div');
        sliderTrack.id = 'ekskulSliderTrack';
        sliderTrack.style.cssText = `
            display: flex;
            width: ${totalSlides * 100}%;
            height: 100%;
            transition: transform 0.3s ease-in-out;
        `;
        
        // Buat slides dengan 1 card per slide
        for (let i = 0; i < totalSlides; i++) {
            const slide = document.createElement('div');
            slide.style.cssText = `
                display: flex;
                width: ${100 / totalSlides}%;
                justify-content: center;
                align-items: center;
                flex-shrink: 0;
            `;
            
            // Tambahkan 1 card per slide
            if (cards[i]) {
                slide.appendChild(cards[i].cloneNode(true));
            }
            
            sliderTrack.appendChild(slide);
        }
        
        // Replace container content
        container.innerHTML = '';
        sliderWrapper.appendChild(sliderTrack);
        container.appendChild(sliderWrapper);
        
        sliderContainer = sliderTrack;
    }
    
    // Setup tombol navigasi
    function setupNavigationButtons() {
        // Tombol previous (<)
        const prevEkskulBtn = document.querySelector('.prevEkskulBtn');
        if (prevEkskulBtn) {
            prevEkskulBtn.style.cursor = 'pointer';
            prevEkskulBtn.style.userSelect = 'none';
            prevEkskulBtn.style.transition = 'all 0.2s ease';
            prevEkskulBtn.addEventListener('click', previousSlide);
            
            // Hover effects
            prevEkskulBtn.addEventListener('mouseenter', function() {
                this.style.transform = 'scale(1.1)';
                this.style.color = '#3b82f6';
            });
            prevEkskulBtn.addEventListener('mouseleave', function() {
                this.style.transform = 'scale(1)';
                this.style.color = '';
            });
        }
        
        // Tombol next (>)
        const nextEkskulBtn = document.querySelector('.nextEkskulBtn');
        if (nextEkskulBtn) {
            nextEkskulBtn.style.cursor = 'pointer';
            nextEkskulBtn.style.userSelect = 'none';
            nextEkskulBtn.style.transition = 'all 0.2s ease';
            nextEkskulBtn.addEventListener('click', nextSlide);
            
            // Hover effects
            nextEkskulBtn.addEventListener('mouseenter', function() {
                this.style.transform = 'scale(1.1)';
                this.style.color = '#3b82f6';
            });
            nextEkskulBtn.addEventListener('mouseleave', function() {
                this.style.transform = 'scale(1)';
                this.style.color = '';
            });
        }
    }
    
    // Update navigation buttons berdasarkan posisi slide
    function updateNavigationButtons() {
        const prevBtn = document.querySelector('.absolute.left-7');
        const nextBtn = document.querySelector('.absolute.right-7');
        
        if (prevBtn && nextBtn) {
            // Reset opacity
            prevBtn.style.opacity = '1';
            nextBtn.style.opacity = '1';
            
            // Optional: Fade tombol jika di awal/akhir (uncomment jika diinginkan)
            /*
            if (currentSlide === 0) {
                prevBtn.style.opacity = '0.3';
            }
            if (currentSlide === totalSlides - 1) {
                nextBtn.style.opacity = '0.3';
            }
            */
        }
    }
    
    // Setup dots indicator
    function setupDotsIndicator() {
        const parentContainer = document.querySelector('.relative.h-\\[50vh\\].w-\\[40vw\\]');
        if (!parentContainer) return;
        
        // Hapus dots yang sudah ada (jika ada)
        const existingDots = parentContainer.querySelector('.dots-indicator');
        if (existingDots) {
            existingDots.remove();
        }
        
        // Buat dots container
        const dotsContainer = document.createElement('div');
        dotsContainer.className = 'dots-indicator';
        dotsContainer.style.cssText = `
            position: absolute;
            bottom: -3rem;
            left: 50%;
            transform: translateX(-50%);
            display: flex;
            gap: 0.75rem;
            z-index: 10;
        `;
        
        // Buat dots
        for (let i = 0; i < totalSlides; i++) {
            const dot = document.createElement('div');
            dot.style.cssText = `
                width: 1rem;
                height: 1rem;
                border-radius: 50%;
                background-color: ${i === 0 ? '#3b82f6' : '#d1d5db'};
                cursor: pointer;
                transition: all 0.2s;
            `;
            
            dot.addEventListener('click', () => goToSlide(i));
            dot.addEventListener('mouseenter', function() {
                if (i !== currentSlide) {
                    this.style.backgroundColor = '#9ca3af';
                }
            });
            dot.addEventListener('mouseleave', function() {
                if (i !== currentSlide) {
                    this.style.backgroundColor = '#d1d5db';
                }
            });
            
            dotsContainer.appendChild(dot);
        }
        
        parentContainer.appendChild(dotsContainer);
    }
    
    // Update posisi slider
    function updateSliderPosition() {
        if (!sliderContainer) return;
        
        const translateX = -currentSlide * (100 / totalSlides);
        sliderContainer.style.transform = `translateX(${translateX}%)`;
        // updateDots(); // DISABLED - tidak ada dots lagi
        updateNavigationButtons();
    }
    
    // Update dots indicator
    function updateDots() {
        const dots = document.querySelectorAll('.dots-indicator > div');
        dots.forEach((dot, index) => {
            if (index === currentSlide) {
                dot.style.backgroundColor = '#3b82f6';
            } else {
                dot.style.backgroundColor = '#d1d5db';
            }
        });
    }
    
    // Fungsi navigasi - slide berikutnya
    function nextSlide() {
        currentSlide = (currentSlide + 1) % totalSlides;
        updateSliderPosition();
    }
    
    // Fungsi navigasi - slide sebelumnya
    function previousSlide() {
        currentSlide = (currentSlide - 1 + totalSlides) % totalSlides;
        updateSliderPosition();
    }
    
    // Langsung ke slide tertentu (masih bisa digunakan programmatically)
    function goToSlide(slideIndex) {
        if (slideIndex >= 0 && slideIndex < totalSlides) {
            currentSlide = slideIndex;
            updateSliderPosition();
        }
    }
    
    // Keyboard navigation
    document.addEventListener('keydown', function(e) {
        // Hanya aktif jika slider terlihat di viewport
        const sliderSection = document.querySelector('.relative.h-\\[50vh\\].w-\\[40vw\\]');
        if (!sliderSection) return;
        
        const rect = sliderSection.getBoundingClientRect();
        const isVisible = rect.top >= 0 && rect.bottom <= window.innerHeight;
        
        if (isVisible) {
            if (e.key === 'ArrowLeft') {
                e.preventDefault();
                previousSlide();
            } else if (e.key === 'ArrowRight') {
                e.preventDefault();
                nextSlide();
            }
        }
    });
    
    // Touch/Swipe support untuk mobile
    let startX = null;
    let startY = null;
    
    document.addEventListener('touchstart', function(e) {
        const sliderSection = document.querySelector('.relative.h-\\[50vh\\].w-\\[40vw\\]');
        if (!sliderSection || !sliderSection.contains(e.target)) return;
        
        startX = e.touches[0].clientX;
        startY = e.touches[0].clientY;
    });
    
    document.addEventListener('touchend', function(e) {
        if (!startX || !startY) return;
        
        const sliderSection = document.querySelector('.relative.h-\\[50vh\\].w-\\[40vw\\]');
        if (!sliderSection || !sliderSection.contains(e.target)) return;
        
        let endX = e.changedTouches[0].clientX;
        let endY = e.changedTouches[0].clientY;
        
        let diffX = startX - endX;
        let diffY = startY - endY;
        
        // Horizontal swipe lebih dominan dari vertical
        if (Math.abs(diffX) > Math.abs(diffY)) {
            if (Math.abs(diffX) > 50) { // Minimum swipe distance
                if (diffX > 0) {
                    nextSlide(); // Swipe left = next
                } else {
                    previousSlide(); // Swipe right = previous
                }
            }
        }
        
        startX = null;
        startY = null;
    });
    
    // Auto-slide (optional) - uncomment jika diperlukan
    /*
    let autoSlideInterval = setInterval(() => {
        nextSlide();
    }, 5000);
    
    // Pause auto-slide saat hover
    const sliderSection = document.querySelector('.relative.h-\\[50vh\\].w-\\[40vw\\]');
    if (sliderSection) {
        sliderSection.addEventListener('mouseenter', () => {
            clearInterval(autoSlideInterval);
        });
        
        sliderSection.addEventListener('mouseleave', () => {
            autoSlideInterval = setInterval(() => {
                nextSlide();
            }, 5000);
        });
    }
    */
    
    // Inisialisasi slider setelah DOM ready
    initSlider();
});