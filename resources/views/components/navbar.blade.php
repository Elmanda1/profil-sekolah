<div class='fixed h-17 w-full bg-gray-200 flex items-center justify-center px-6 shadow-xl z-100'>
    <!-- Nav Menu -->
    <ul class='flex gap-12 justify-center items-center'>
        <a href='/' class='flex gap-2 text-lg cursor-pointer text-amber-950'><span>L</span>Beranda</a>
        <div class="relative">
            <button href='#' onclick="toggleDropdown()" class='flex gap-2 text-lg cursor-pointer text-amber-950'><span>L</span>Profil</button>
            <div id="dropdownMenu" class="absolute left-0 mt-2 w-40 bg-[#fffffb] text-amber-950 border border-amber-950 rounded shadow-lg hidden">
                <a href="/profil-pengajar" class="block px-4 py-2 hover:bg-gray-100">Profil Pengajar</a>
                <a href="/profil-siswa" class="block px-4 py-2 hover:bg-gray-100">Profil Siswa</a>
            </div>
        </div>
        <a href='/berita' class='flex gap-2 text-lg cursor-pointer text-amber-950'><span>L</span>Berita</a>
        <a href='/prestasi' class='flex gap-2 text-lg cursor-pointer text-amber-950'><span>L</span>Prestasi</a>
        <a href='{{ route("admin.dashboard") }}' class='flex gap-2 text-lg cursor-pointer text-green-600 font-bold'><span><svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" /></svg></span>Admin</a>
    </ul>
</div>
<script>
    function toggleDropdown() {
        const dropdown = document.getElementById('dropdownMenu');
        dropdown.classList.toggle('hidden');
    }

    // Optional: klik di luar tutup dropdown
    document.addEventListener('click', function (event) {
        const dropdown = document.getElementById('dropdownMenu');
        const button = event.target.closest('button');
        const isInside = event.target.closest('#dropdownMenu');
        if (!button && !isInside) {
            dropdown.classList.add('hidden');
        }
    });
</script>
