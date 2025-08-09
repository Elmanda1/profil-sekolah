@extends('layouts.admin')

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
                    <form action="{{ route('admin.prestasi.update', $prestasi->id_prestasi) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="card-body">
                            <div class="form-group">
                                <label for="id_siswa">Siswa</label>
                                <select class="form-control select2 @error('id_siswa') is-invalid @enderror" 
                                        id="id_siswa" name="id_siswa">
                                    <option value="">Pilih Siswa</option>
                                    @foreach($siswa as $item)
                                        <option value="{{ $item->id_siswa }}" 
                                                {{ old('id_siswa', $prestasi->id_siswa) == $item->id_siswa ? 'selected' : '' }}>
                                            {{ $item->nama }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('id_siswa')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="nama_prestasi">Nama Prestasi</label>
                                <input type="text" class="form-control @error('nama_prestasi') is-invalid @enderror" 
                                       id="nama_prestasi" name="nama_prestasi" 
                                       value="{{ old('nama_prestasi', $prestasi->nama_prestasi) }}" 
                                       placeholder="Masukkan nama prestasi">
                                @error('nama_prestasi')
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
</script>
@endsection