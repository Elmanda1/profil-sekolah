@extends('layouts.frontend')

@section('title', 'berita')

@section('content')
    <div class='min-h-screen w-full flex flex-col justify-center items-center py-40'>
        <div class='flex flex-col gap-4 items-center justify-center'>
            <div class='font-semibold text-4xl'>Prestasi Sekolah</div>
            <div class='text-lg'>Galeri Penghargaan dan Pencapaian Siswa dan Sekolah</div>
        </div>
        <div class='grid grid-cols-3 gap-4 mt-8'>
            <x-berita-prestasi-card/>
            <x-berita-prestasi-card/>
            <x-berita-prestasi-card/>
            <x-berita-prestasi-card/>
        </div>
    </div>
@endsection
