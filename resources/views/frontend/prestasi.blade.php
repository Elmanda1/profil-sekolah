@extends('layouts.frontend')
@section('title', 'Prestasi')
@section('content')
    <div class='min-h-screen w-full flex flex-col justify-center items-center py-40'>
        <div class='flex flex-col gap-4 items-center justify-center'>
            <div class='font-semibold text-4xl'>Prestasi Sekolah</div>
            <div class='text-lg'>Galeri Penghargaan dan Pencapaian Siswa dan Sekolah</div>
        </div>
        
        <div class='grid grid-cols-3 gap-4 mt-8'>
            @forelse($prestasi as $item)
                <x-berita-prestasi-card :prestasi="$item"/>
            @empty
                <div class='col-span-3 text-center py-20'>
                    <p class='text-gray-500 text-lg'>Belum ada data prestasi.</p>
                </div>
            @endforelse
        </div>

        @if($prestasi->hasPages())
            <div class='mt-8'>
                {{ $prestasi->links() }}
            </div>
        @endif
    </div>
@endsection