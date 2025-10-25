@extends('adminlte::page')

@section('title', 'Edit Berita')

@section('content')
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">Edit Berita</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('admin.berita.index') }}">Data Berita</a></li>
                    <li class="breadcrumb-item active">Edit Berita</li>
                </ol>
            </div>
        </div>
    </div>
</div>

<section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Form Edit Berita</h3>
                    </div>
                    <form id="edit-artikel-form" action="{{ route('admin.berita.update', $berita->id_berita) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="card-body">
                            <div class="form-group">
                                <label for="judul">Judul Berita</label>
                                <input type="text" class="form-control @error('judul') is-invalid @enderror" 
                                       id="judul" name="judul" value="{{ old('judul', $berita->judul) }}" 
                                       placeholder="Masukkan judul berita">
                                @error('judul')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="isi">Isi Berita</label>
                                <textarea class="form-control @error('isi') is-invalid @enderror" 
                                          id="isi" name="isi" rows="10" placeholder="Masukkan isi berita">{{ old('isi', $berita->isi) }}</textarea>
                                @error('isi')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="tanggal_berita">Tanggal Berita</label>
                                        <input type="date" class="form-control @error('tanggal_berita') is-invalid @enderror" 
                                               id="tanggal_berita" name="tanggal_berita" 
                                               value="{{ old('tanggal_berita', $berita->tanggal_berita->format('Y-m-d')) }}">
                                        @error('tanggal_berita')
                                            <span class="invalid-feedback">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="penulis">Penulis</label>
                                        <input type="text" class="form-control @error('penulis') is-invalid @enderror" 
                                               id="penulis" name="penulis" value="{{ old('penulis', $berita->penulis) }}" 
                                               placeholder="Nama penulis (opsional)">
                                        @error('penulis')
                                            <span class="invalid-feedback">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="card-footer">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save"></i> Update
                            </button>
                            <a href="{{ route('admin.berita.index') }}" class="btn btn-secondary">
                                <i class="fas fa-arrow-left"></i> Kembali
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection

@section('scripts')
<script>
    // Initialize Summernote for rich text editor
    $(document).ready(function() {
        $('#isi').summernote({
            height: 200,
            toolbar: [
                ['style', ['style']],
                ['font', ['bold', 'underline', 'clear']],
                ['color', ['color']],
                ['para', ['ul', 'ol', 'paragraph']],
                ['table', ['table']],
                ['insert', ['link']],
                ['view', ['fullscreen', 'codeview', 'help']]
            ]
        });
    });

    $('#edit-artikel-form').on('submit', function(e) {
        e.preventDefault();

        let formData = new FormData(this);
        formData.append('_method', 'PUT');

        $.ajax({
            url: $(this).attr('action'),
            type: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            success: function(result) {
                // Do something with the result
                window.location.href = '{{ route("admin.berita.index") }}';
            },
            error: function(err) {
                // Do something with the error
                let errors = err.responseJSON.errors;
                // Clear previous errors
                $('.is-invalid').removeClass('is-invalid');
                $('.invalid-feedback').remove();

                $.each(errors, function(key, value) {
                    $('#' + key).addClass('is-invalid');
                    $('#' + key).after('<div class="invalid-feedback">' + value[0] + '</div>');
                });
            }
        });
    });
</script>
@endsection