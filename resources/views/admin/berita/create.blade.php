@extends('adminlte::page')

@section('title', 'Tambah Berita')
@section('page-title', 'Tambah Berita')

@section('breadcrumb')
  <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
  <li class="breadcrumb-item"><a href="{{ route('admin.berita.index') }}">Data Berita</a></li>
  <li class="breadcrumb-item active">Tambah Berita</li>
@endsection

@section('content')
<div class="container-fluid">
  <div class="row">
    <div class="col-md-8">
      <div class="card">
        <div class="card-header">
          <h3 class="card-title">Form Tambah Berita</h3>
        </div>
        
        <form id="create-artikel-form" action="{{ route('admin.berita.store') }}" method="POST" enctype="multipart/form-data">
          @csrf
          <div class="card-body">
            
            <div class="form-group">
              <label for="id_sekolah">Sekolah <span class="text-danger">*</span></label>
              <select class="form-control @error('id_sekolah') is-invalid @enderror" 
                      id="id_sekolah" name="id_sekolah">
                <option value="">-- Pilih Sekolah --</option>
                @foreach($sekolahs as $sekolah)
                  <option value="{{ $sekolah->id_sekolah }}" {{ old('id_sekolah') == $sekolah->id_sekolah ? 'selected' : '' }}>
                    {{ $sekolah->nama_sekolah }}
                  </option>
                @endforeach
              </select>
              @error('id_sekolah')
                <div class="invalid-feedback">{{ $message }}</div>
              @enderror
            </div>

            <div class="form-group">
              <label for="judul">Judul Berita <span class="text-danger">*</span></label>
              <input type="text" class="form-control @error('judul') is-invalid @enderror" 
                     id="judul" name="judul" value="{{ old('judul') }}" 
                     placeholder="Masukkan judul berita">
              @error('judul')
                <div class="invalid-feedback">{{ $message }}</div>
              @enderror
            </div>

            <div class="form-group">
              <label for="isi">Isi Berita <span class="text-danger">*</span></label>
              <textarea class="form-control @error('isi') is-invalid @enderror" 
                        id="isi" name="isi" rows="10" 
                        placeholder="Masukkan isi berita">{{ old('isi') }}</textarea>
              @error('isi')
                <div class="invalid-feedback">{{ $message }}</div>
              @enderror
            </div>

            <div class="row">
              <div class="col-md-6">
                <div class="form-group">
                  <label for="tanggal">Tanggal Berita <span class="text-danger">*</span></label>
                  <input type="date" class="form-control @error('tanggal') is-invalid @enderror" 
                         id="tanggal" name="tanggal" value="{{ old('tanggal') }}">
                  @error('tanggal')
                    <div class="invalid-feedback">{{ $message }}</div>
                  @enderror
                </div>
              </div>
              <div class="col-md-6">
                <div class="form-group">
                  <label for="penulis">Penulis</label>
                  <input type="text" class="form-control @error('penulis') is-invalid @enderror" 
                         id="penulis" name="penulis" value="{{ old('penulis') }}" 
                         placeholder="Nama penulis (opsional)">
                  @error('penulis')
                    <div class="invalid-feedback">{{ $message }}</div>
                  @enderror
                </div>
              </div>
            </div>

            <div class="form-group">
              <label for="gambar">Gambar</label>
              <input type="file" class="form-control-file @error('gambar') is-invalid @enderror" 
                     id="gambar" name="gambar">
              @error('gambar')
                <div class="invalid-feedback">{{ $message }}</div>
              @enderror
            </div>

          </div>

          <div class="card-footer">
            <button type="submit" class="btn btn-primary">
              <i class="fas fa-save"></i> Simpan
            </button>
            <a href="{{ route('admin.berita.index') }}" class="btn btn-secondary">
              <i class="fas fa-arrow-left"></i> Kembali
            </a>
          </div>
        </form>
      </div>
    </div>

    <div class="col-md-4">
      <div class="card card-info">
        <div class="card-header">
          <h3 class="card-title">Informasi</h3>
        </div>
        <div class="card-body">
          <p><strong>Petunjuk Pengisian:</strong></p>
          <ul class="list-unstyled">
            <li><i class="fas fa-info-circle text-info"></i> Judul, isi, tanggal, dan sekolah wajib diisi.</li>
            <li><i class="fas fa-info-circle text-info"></i> Penulis dan gambar bersifat opsional.</li>
          </ul>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection

@section('js')
<script>
$(function() {
    console.log('Create artikel script loaded!');

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

    $('#create-artikel-form').on('submit', function(e) {
        e.preventDefault();

        const form = $(this);
        const submitButton = form.find('button[type="submit"]');
        submitButton.prop('disabled', true);

        let formData = new FormData(this);
        console.log('Form data:', Object.fromEntries(formData.entries()));

        $.ajax({
            url: form.attr('action'),
            type: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            success: function(result) {
                console.log('Success:', result);
                window.location.replace('{{ route("admin.berita.index") }}');
            },
            error: function(err) {
                console.error('Error:', err);
                let errors = err.responseJSON.errors;
                console.log('Validation errors:', JSON.stringify(errors, null, 2));
                // Clear previous errors
                $('.is-invalid').removeClass('is-invalid');
                $('.invalid-feedback').remove();

                $.each(errors, function(key, value) {
                    $('#' + key).addClass('is-invalid');
                    $('#' + key).after('<div class="invalid-feedback">' + value[0] + '</div>');
                });
            },
            complete: function() {
                submitButton.prop('disabled', false);
            }
        });
    });
});
</script>
@endsection