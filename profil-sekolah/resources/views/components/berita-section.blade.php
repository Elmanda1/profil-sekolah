<div class='flex flex-col h-[70vh] w-full justify-start items-center pb-10 gap-12'>
    <div>
        <h1 class='font-semibold text-5xl'>Berita Sekolah</h1>
    </div>
    <div class='flex w-full h-full'>
        <div class='flex w-1/12 justify-center items-center'>
            <button class='text-[5rem]'><</button>
        </div>
        <div class='flex bg-green-300 h-full w-full justify-start items-center gap-4 overflow-x-scroll'>
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
    <div>
        <button class='bg-green-100 px-4 py-2 text-lg rounded-full border-2 border-green-600'>Lihat Lebih Banyak</button>
    </div>
</div>