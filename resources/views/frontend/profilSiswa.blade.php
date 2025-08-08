@extends('layout.frontend')

@section('title', 'profil-siswa')

@section('content')
    <div class='min-h-screen w-full flex flex-col justify-center items-center py-40'>
        <div class='flex flex-col gap-4 items-center justify-center'>
            <div class='font-semibold text-4xl'>Profil Siswa</div>
            <div class='text-lg'>Semua siswa dalam sma negeri 100 jakarta</div>
        </div>
        <div class='grid grid-cols-4 gap-4 mt-8'>
            <x-profil-card/>
            <x-profil-card/>
            <x-profil-card/>
            <x-profil-card/>    
            <x-profil-card/>
            <x-profil-card/>
            <x-profil-card/>   
            <x-profil-card/>
            <x-profil-card/>
            <x-profil-card/>
            <x-profil-card/>
            <x-profil-card/>
            <x-profil-card/>
            <x-profil-card/>
            <x-profil-card/>
            <x-profil-card/>
        </div>
    </div>
@endsection

