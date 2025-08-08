// Script untuk menjalankan slider prestasi dengan 1 card per slide
// Letakkan script ini di bagian bawah layout atau di file terpisah

document.addEventListener('DOMContentLoaded', function() {
    // Variabel untuk prestasi slider
    let currentPrestasiSlide = 0;
    let totalPrestasiSlides = 0;
    let prestasiSliderContainer;
    let prestasiSliders;
    
    // Inisialisasi prestasi slider  
    function initPrestasiSlider() {
    // Ambil container utama
        const prestasiContainer = document.querySelector('.prestasi-container');
        
        if (!prestasiContainer) {
            console.error('Prestasi slider container tidak ditemukan');
            return;
        }

        // Ambil semua prestasi cards
        prestasiSliders = prestasiContainer.querySelectorAll('.prestasi-slider'); // pastikan <x-prestasi-slider> kasih class 'prestasi-card'

        if (prestasiSliders.length === 0) {
            console.error('Prestasi slider tidak ditemukan');
            return;
        }

        // Hitung total slides
        totalPrestasiSlides = prestasiSliders.length;

        // Setup slider
        setupPrestasiSliderContainer(prestasiContainer);
        setupPrestasiNavigationButtons();
        updatePrestasiSliderPosition();
    }

    
    // Setup container untuk prestasi slider behavior
    function setupPrestasiSliderContainer(container) {
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
        sliderTrack.id = 'prestasiSliderTrack';
        sliderTrack.style.cssText = `
            display: flex;
            width: ${totalPrestasiSlides * 100}%;
            height: 100%;
            transition: transform 0.3s ease-in-out;
        `;
        
        // Buat slides dengan 1 card per slide
        for (let i = 0; i < totalPrestasiSlides; i++) {
            const slide = document.createElement('div');
            slide.style.cssText = `
                display: flex;
                width: ${100 / totalPrestasiSlides}%;
                justify-content: center;
                align-items: center;
                flex-shrink: 0;
            `;
            
            // Tambahkan 1 card per slide
            if (prestasiSliders[i]) {
                slide.appendChild(prestasiSliders[i].cloneNode(true));
            }
            
            sliderTrack.appendChild(slide);
        }
        
        // Replace container content
        container.innerHTML = '';
        sliderWrapper.appendChild(sliderTrack);
        container.appendChild(sliderWrapper);
        
        prestasiSliderContainer = sliderTrack;
    }
    
    // Setup tombol navigasi prestasi
    function setupPrestasiNavigationButtons() {
        // Tombol previous (<)
        const prevPrestasiBtn = document.querySelector('.prevPrestasiBtn');
        if (prevPrestasiBtn) {
            prevPrestasiBtn.style.cursor = 'pointer';
            prevPrestasiBtn.style.userSelect = 'none';
            prevPrestasiBtn.style.transition = 'all 0.2s ease';
            prevPrestasiBtn.style.color = '#6b7280'; // text-gray-500
            prevPrestasiBtn.addEventListener('click', previousPrestasiSlide);
            
            // Hover effects
            prevPrestasiBtn.addEventListener('mouseenter', function() {
                this.style.transform = 'scale(1.1)';
                this.style.color = '#3b82f6';
            });
            prevPrestasiBtn.addEventListener('mouseleave', function() {
                this.style.transform = 'scale(1)';
                this.style.color = '#6b7280';
            });
        }
        
        // Tombol next (>)
        const nextPrestasiBtn = document.querySelector('.nextPrestasiBtn');
        if (nextPrestasiBtn) {
            nextPrestasiBtn.style.cursor = 'pointer';
            nextPrestasiBtn.style.userSelect = 'none';
            nextPrestasiBtn.style.transition = 'all 0.2s ease';
            nextPrestasiBtn.style.color = '#6b7280'; // text-gray-500
            nextPrestasiBtn.addEventListener('click', nextPrestasiSlide);
            
            // Hover effects
            nextPrestasiBtn.addEventListener('mouseenter', function() {
                this.style.transform = 'scale(1.1)';
                this.style.color = '#3b82f6';
            });
            nextPrestasiBtn.addEventListener('mouseleave', function() {
                this.style.transform = 'scale(1)';
                this.style.color = '#6b7280';
            });
        }
    }
    
    // Update posisi prestasi slider
    function updatePrestasiSliderPosition() {
        if (!prestasiSliderContainer) return;
        
        const translateX = -currentPrestasiSlide * (100 / totalPrestasiSlides);
        prestasiSliderContainer.style.transform = `translateX(${translateX}%)`;
        updatePrestasiNavigationButtons();
    }
    
    // Update navigation buttons berdasarkan posisi slide
    function updatePrestasiNavigationButtons() {
        const prevBtn = document.querySelector('.relative.h-screen.w-full .absolute.left-7');
        const nextBtn = document.querySelector('.relative.h-screen.w-full .absolute.right-7');
        
        if (prevBtn && nextBtn) {
            // Reset opacity
            prevBtn.style.opacity = '1';
            nextBtn.style.opacity = '1';
            
            // Optional: Fade tombol jika di awal/akhir (uncomment jika diinginkan)
            /*
            if (currentPrestasiSlide === 0) {
                prevBtn.style.opacity = '0.3';
            }
            if (currentPrestasiSlide === totalPrestasiSlides - 1) {
                nextBtn.style.opacity = '0.3';
            }
            */
        }
    }
    
    // Fungsi navigasi - slide berikutnya
    function nextPrestasiSlide() {
        currentPrestasiSlide = (currentPrestasiSlide + 1) % totalPrestasiSlides;
        updatePrestasiSliderPosition();
    }
    
    // Fungsi navigasi - slide sebelumnya
    function previousPrestasiSlide() {
        currentPrestasiSlide = (currentPrestasiSlide - 1 + totalPrestasiSlides) % totalPrestasiSlides;
        updatePrestasiSliderPosition();
    }
    
    // Langsung ke slide tertentu (bisa digunakan programmatically)
    function goToPrestasiSlide(slideIndex) {
        if (slideIndex >= 0 && slideIndex < totalPrestasiSlides) {
            currentPrestasiSlide = slideIndex;
            updatePrestasiSliderPosition();
        }
    }
    
    // Keyboard navigation untuk prestasi slider
    document.addEventListener('keydown', function(e) {
        // Hanya aktif jika prestasi slider terlihat di viewport
        const prestasiSection = document.querySelector('.relative.h-screen.w-full');
        if (!prestasiSection) return;
        
        const rect = prestasiSection.getBoundingClientRect();
        const isVisible = rect.top <= window.innerHeight && rect.bottom >= 0;
        
        if (isVisible) {
            if (e.key === 'ArrowLeft' && e.ctrlKey) { // Ctrl + Arrow Left untuk prestasi
                e.preventDefault();
                previousPrestasiSlide();
            } else if (e.key === 'ArrowRight' && e.ctrlKey) { // Ctrl + Arrow Right untuk prestasi
                e.preventDefault();
                nextPrestasiSlide();
            }
        }
    });
    
    // Touch/Swipe support untuk prestasi slider (mobile)
    let prestasiStartX = null;
    let prestasiStartY = null;
    
    document.addEventListener('touchstart', function(e) {
        const prestasiSection = document.querySelector('.relative.h-screen.w-full');
        if (!prestasiSection || !prestasiSection.contains(e.target)) return;
        
        prestasiStartX = e.touches[0].clientX;
        prestasiStartY = e.touches[0].clientY;
    });
    
    document.addEventListener('touchend', function(e) {
        if (!prestasiStartX || !prestasiStartY) return;
        
        const prestasiSection = document.querySelector('.relative.h-screen.w-full');
        if (!prestasiSection || !prestasiSection.contains(e.target)) return;
        
        let endX = e.changedTouches[0].clientX;
        let endY = e.changedTouches[0].clientY;
        
        let diffX = prestasiStartX - endX;
        let diffY = prestasiStartY - endY;
        
        // Horizontal swipe lebih dominan dari vertical
        if (Math.abs(diffX) > Math.abs(diffY)) {
            if (Math.abs(diffX) > 50) { // Minimum swipe distance
                if (diffX > 0) {
                    nextPrestasiSlide(); // Swipe left = next
                } else {
                    previousPrestasiSlide(); // Swipe right = previous
                }
            }
        }
        
        prestasiStartX = null;
        prestasiStartY = null;
    });
    
    // Auto-slide untuk prestasi (optional) - uncomment jika diperlukan
    /*
    let prestasiAutoSlideInterval = setInterval(() => {
        nextPrestasiSlide();
    }, 7000);
    
    // Pause auto-slide saat hover
    const prestasiSection = document.querySelector('.relative.h-screen.w-full');
    if (prestasiSection) {
        prestasiSection.addEventListener('mouseenter', () => {
            clearInterval(prestasiAutoSlideInterval);
        });
        
        prestasiSection.addEventListener('mouseleave', () => {
            prestasiAutoSlideInterval = setInterval(() => {
                nextPrestasiSlide();
            }, 7000);
        });
    }
    */
    
    // Inisialisasi prestasi slider setelah DOM ready
    // Delay sedikit untuk memastikan semua elemen sudah ter-render
    setTimeout(() => {
        initPrestasiSlider();
    }, 100);
});