@extends('adminlte::page')

@section('title', 'Edit Prestasi')

@section('content')
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">Edit Prestasi</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('admin.prestasi.index') }}">Data Prestasi</a></li>
                    <li class="breadcrumb-item active">Edit Prestasi</li>
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
                        <h3 class="card-title">Form Edit Prestasi</h3>
                    </div>
                    <form id="edit-prestasi-form" action="{{ route('admin.prestasi.update', $prestasi->id_prestasi) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <div class="card-body">
                            <div class="form-group">
                                <label for="id_sekolah">Sekolah</label>
                                <select class="form-control select2 @error('id_sekolah') is-invalid @enderror" 
                                        id="id_sekolah" name="id_sekolah">
                                    <option value="">Pilih Sekolah</option>
                                    @foreach($sekolahs as $sekolah)
                                        <option value="{{ $sekolah->id_sekolah }}" {{ old('id_sekolah', $prestasi->id_sekolah) == $sekolah->id_sekolah ? 'selected' : '' }}>
                                            {{ $sekolah->nama_sekolah }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('id_sekolah')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="judul">Judul Prestasi</label>
                                <input type="text" class="form-control @error('judul') is-invalid @enderror" 
                                       id="judul" name="judul" 
                                       value="{{ old('judul', $prestasi->judul) }}" 
                                       placeholder="Masukkan judul prestasi">
                                @error('judul')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="tanggal">Tanggal</label>
                                <input type="date" class="form-control @error('tanggal') is-invalid @enderror" 
                                       id="tanggal" name="tanggal" value="{{ old('tanggal', $prestasi->tanggal->format('Y-m-d')) }}">
                                @error('tanggal')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="deskripsi">Deskripsi</label>
                                <textarea class="form-control @error('deskripsi') is-invalid @enderror" 
                                          id="deskripsi" name="deskripsi" rows="3" 
                                          placeholder="Masukkan deskripsi prestasi">{{ old('deskripsi', $prestasi->deskripsi) }}</textarea>
                                @error('deskripsi')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="tahun">Tahun</label>
                                <input type="number" class="form-control @error('tahun') is-invalid @enderror" 
                                       id="tahun" name="tahun" value="{{ old('tahun', $prestasi->tahun) }}" 
                                       min="2000" max="{{ date('Y') + 1 }}" placeholder="Tahun prestasi">
                                @error('tahun')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="tingkat">Tingkat</label>
                                <select class="form-control @error('tingkat') is-invalid @enderror" 
                                        id="tingkat" name="tingkat">
                                    <option value="">-- Pilih Tingkat --</option>
                                    @foreach($tingkats as $tingkat)
                                        <option value="{{ $tingkat }}" {{ old('tingkat', $prestasi->tingkat) == $tingkat ? 'selected' : '' }}>
                                            {{ $tingkat }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('tingkat')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="peringkat">Peringkat</label>
                                <select class="form-control @error('peringkat') is-invalid @enderror" 
                                        id="peringkat" name="peringkat">
                                    <option value="">-- Pilih Peringkat --</option>
                                    @foreach($peringkats as $peringkat)
                                        <option value="{{ $peringkat }}" {{ old('peringkat', $prestasi->peringkat) == $peringkat ? 'selected' : '' }}>
                                            {{ $peringkat }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('peringkat')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="gambar">Gambar</label>
                                <div class="input-group">
                                    <div class="custom-file">
                                        <input type="file" class="custom-file-input @error('gambar') is-invalid @enderror" 
                                               id="gambar" name="gambar">
                                        <label class="custom-file-label" for="gambar">Pilih gambar</label>
                                    </div>
                                </div>
                                @error('gambar')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                @enderror

                                @if($prestasi->gambar)
                                    <div class="mt-2">
                                        <img src="{{ asset('photos/' . $prestasi->gambar) }}" alt="Gambar Prestasi" style="max-width: 200px;">
                                    </div>
                                @endif
                            </div>
                        </div>

                        <div class="card-footer">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save"></i> Update
                            </button>
                            <a href="{{ route('admin.prestasi.index') }}" class="btn btn-secondary">
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
    $(document).ready(function() {
        $('.select2').select2({
            theme: 'bootstrap4'
        });
    });

    $('#edit-prestasi-form').on('submit', function(e) {
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
                window.location.href = '{{ route("admin.prestasi.index") }}';
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