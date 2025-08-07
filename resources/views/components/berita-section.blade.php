<div class='flex flex-col h-[70vh] w-full justify-start items-center pb-10 gap-12'>
    <div>
        <h1 class='font-semibold text-5xl'>Berita Sekolah</h1>
    </div>
    <div class='flex w-full h-full'>
        <div class='flex w-1/12 justify-center items-center'>
            <button class='text-[5rem]'><</button>
        </div>
        <div class='flex h-full w-full justify-start items-center gap-4 overflow-x-scroll'>
            <x-berita-card/>
            <x-berita-card/>
                        <x-berita-card/>
            <x-berita-card/>
            <x-berita-card/>

        </div>
        <div class='flex w-1/12 justify-center items-center'>
            <button class='text-[5rem]'>></button>
        </div>
    </div>
    <div class='hover:-translate-y-2 transition-all duration-300 hover:shadow-xl'>
        <a href='/berita'class=' bg-green-50 px-4 py-2 text-lg rounded-full border-2 text-green-600 border-green-600 font-semibold'>Lihat Lebih Banyak</a>
    </div>
</div>