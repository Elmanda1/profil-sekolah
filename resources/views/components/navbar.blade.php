<nav class="fixed w-full z-50 bg-white shadow-md transition-all duration-300">
    <div class="container mx-auto px-4">
        <div class="flex justify-between items-center h-20">
            <!-- Logo -->
            <a href="/" class="flex items-center space-x-3">
                <img src="{{ asset('photos/icon.png') }}" alt="Logo" class="h-12 w-12">
                <span class="text-xl font-bold text-gray-800">SMAN 100 Jakarta</span>
            </a>

            <!-- Desktop Menu -->
            <div class="hidden md:flex items-center space-x-8">
                <a href="/" class="text-gray-600 hover:text-green-600 transition-colors">Beranda</a>
                <div class="relative group">
                    <button class="text-gray-600 hover:text-green-600 transition-colors flex items-center">
                        Profil
                        <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                        </svg>
                    </button>
                    <div class="absolute left-0 mt-2 w-48 bg-white rounded-md shadow-lg opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-300">
                        <a href="/profil-pengajar" class="block px-4 py-2 text-gray-700 hover:bg-green-50 hover:text-green-600">Profil Pengajar</a>
                        <a href="/profil-siswa" class="block px-4 py-2 text-gray-700 hover:bg-green-50 hover:text-green-600">Profil Siswa</a>
                    </div>
                </div>
                <a href="/berita" class="text-gray-600 hover:text-green-600 transition-colors">Berita</a>
                <a href="/prestasi" class="text-gray-600 hover:text-green-600 transition-colors">Prestasi</a>
                <a href="{{ route('admin.dashboard') }}" class="bg-green-600 hover:bg-green-700 text-white px-6 py-2 rounded-full transition-colors">
                    Admin
                </a>
            </div>

            <!-- Mobile Menu Button -->
            <button class="md:hidden text-gray-600" onclick="toggleMobileMenu()">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16m-16 6h16" />
                </svg>
            </button>
        </div>
    </div>

    <!-- Mobile Menu -->
    <div id="mobileMenu" class="hidden md:hidden bg-white border-t">
        <div class="container mx-auto px-4 py-4">
            <a href="/" class="block py-2 text-gray-600 hover:text-green-600">Beranda</a>
            <button onclick="toggleMobileSubmenu()" class="w-full flex justify-between items-center py-2 text-gray-600 hover:text-green-600">
                Profil
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                </svg>
            </button>
            <div id="mobileSubmenu" class="hidden pl-4">
                <a href="/profil-pengajar" class="block py-2 text-gray-600 hover:text-green-600">Profil Pengajar</a>
                <a href="/profil-siswa" class="block py-2 text-gray-600 hover:text-green-600">Profil Siswa</a>
            </div>
            <a href="/berita" class="block py-2 text-gray-600 hover:text-green-600">Berita</a>
            <a href="/prestasi" class="block py-2 text-gray-600 hover:text-green-600">Prestasi</a>
            <a href="{{ route('admin.dashboard') }}" class="block py-2 text-green-600 font-semibold">Admin</a>
        </div>
    </div>
</nav>

<script>
function toggleMobileMenu() {
    const menu = document.getElementById('mobileMenu');
    menu.classList.toggle('hidden');
}

function toggleMobileSubmenu() {
    const submenu = document.getElementById('mobileSubmenu');
    submenu.classList.toggle('hidden');
}

// Hide mobile menu when clicking outside
document.addEventListener('click', function(event) {
    const menu = document.getElementById('mobileMenu');
    const menuButton = event.target.closest('button');
    if (!menuButton && !menu.contains(event.target)) {
        menu.classList.add('hidden');
    }
});
</script>