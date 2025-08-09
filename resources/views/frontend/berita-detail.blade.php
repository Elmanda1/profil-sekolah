@extends('layouts.frontend')

@section('title', $berita->judul)

@section('content')
<!-- Hero Section -->
<section class="bg-primary text-white py-5">
    <div class="container">
        <div class="row">
            <div class="col-lg-8 mx-auto text-center">
                <h1 class="display-5 fw-bold">{{ $berita->judul }}</h1>
                <div class="d-flex justify-content-center align-items-center gap-3 mt-3">
                    <span><i class="fas fa-calendar-alt"></i> {{ $berita->tanggal_format }}</span>
                    @if($berita->penulis)
                        <span><i class="fas fa-user"></i> {{ $berita->penulis }}</span>
                    @endif
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Content Section -->
<section class="py-5">
    <div class="container">
        <div class="row">
            <div class="col-lg-8 mx-auto">
                <div class="card shadow-sm">
                    <div class="card-body">
                        <div class="content-text">
                            {!! nl2br(e($berita->isi)) !!}
                        </div>
                        
                        <hr class="my-4">
                        
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <small class="text-muted">Dipublish pada {{ $berita->tanggal_format }}</small>
                                @if($berita->penulis)
                                    <br><small class="text-muted">Oleh {{ $berita->penulis }}</small>
                                @endif
                            </div>
                            <div>
                                <a href="{{ route('frontend.berita') }}" class="btn btn-outline-primary">
                                    <i class="fas fa-arrow-left"></i> Kembali ke Berita
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection

@section('styles')
<style>
.content-text {
    font-size: 1.1rem;
    line-height: 1.8;
    text-align: justify;
}

.content-text p {
    margin-bottom: 1rem;
}
</style>
@endsection