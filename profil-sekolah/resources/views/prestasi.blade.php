@extends('layout.app')

@section('title', 'berita')

@section('content')
    <div class='min-h-screen w-full flex flex-col justify-center items-center py-40'>
        <div class='flex flex-col gap-4 items-center justify-center'>
            <div class='font-semibold text-4xl'>Warta Sekolah</div>
            <div class='text-lg'>Informasi terkini seputar kegiatan, acara, dan pengumuman sekolah</div>
        </div>
        <div class='grid grid-cols-3 gap-4 mt-8'>
            <x-berita-prestasi-card/>
            <x-berita-prestasi-card/>
            <x-berita-prestasi-card/>
            <x-berita-prestasi-card/>
        </div>
    </div>
@endsection
