@extends('adminlte::page')

@section('title', 'Tambah Guru')
@section('page-title', 'Tambah Guru')

@section('breadcrumb')
  <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
  <li class="breadcrumb-item"><a href="{{ route('admin.guru.index') }}">Data Guru</a></li>
  <li class="breadcrumb-item active">Tambah Guru</li>
@endsection

@section('content')
<div class="container-fluid">
  <div class="row">
    <div class="col-md-8">
      <div class="card">
        <div class="card-header">
          <h3 class="card-title">Form Tambah Guru</h3>
        </div>
        
        <form action="{{ route('admin.guru.store') }}" method="POST">
          @csrf
          <div class="card-body">
            
            <div class="form-group">
              <label for="nip">NIP <span class="text-danger">*</span></label>
              <input type="text" class="form-control @error('nip') is-invalid @enderror" 
                     id="nip" name="nip" value="{{ old('nip') }}" 
                     placeholder="Masukkan NIP guru">
              @error('nip')
                <div class="invalid-feedback">{{ $message }}</div>
              @enderror
            </div>

            <div class="form-group">
              <label for="nama_guru">Nama Guru <span class="text-danger">*</span></label>
              <input type="text" class="form-control @error('nama_guru') is-invalid @enderror" 
                     id="nama_guru" name="nama_guru" value="{{ old('nama_guru') }}" 
                     placeholder="Masukkan nama lengkap guru">
              @error('nama_guru')
                <div class="invalid-feedback">{{ $message }}</div>
              @enderror
            </div>


            <div class="form-group">
              <label for="mapel">Mata Pelajaran</label>
              <select class="form-control select2 @error('mapel') is-invalid @enderror" 
                      id="mapel" name="mapel[]" multiple>
                @foreach($mapels as $mapel)
                  <option value="{{ $mapel->id_mapel }}" {{ in_array($mapel->id_mapel, old('mapel', [])) ? 'selected' : '' }}>
                    {{ $mapel->nama_mapel }}
                  </option>
                @endforeach
              </select>
              @error('mapel')
                <div class="invalid-feedback">{{ $message }}</div>
              @enderror
            </div>

            <div class="form-group">
              <label for="alamat">Alamat</label>
              <textarea class="form-control @error('alamat') is-invalid @enderror" 
                        id="alamat" name="alamat" rows="3" 
                        placeholder="Masukkan alamat lengkap guru">{{ old('alamat') }}</textarea>
              @error('alamat')
                <div class="invalid-feedback">{{ $message }}</div>
              @enderror
            </div>

          </div>

          <div class="card-footer">
            <button type="submit" class="btn btn-primary">
              <i class="fas fa-save"></i> Simpan
            </button>
            <a href="{{ route('admin.guru.index') }}" class="btn btn-secondary">
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
            <li><i class="fas fa-info-circle text-info"></i> NIP harus unik dan tidak boleh sama</li>
            <li><i class="fas fa-info-circle text-info"></i> Nama Guru wajib diisi dengan lengkap</li>
            <li><i class="fas fa-info-circle text-info"></i> Jenis kelamin wajib dipilih</li>
            <li><i class="fas fa-info-circle text-info"></i> Mata pelajaran wajib diisi</li>
            <li><i class="fas fa-info-circle text-info"></i> Alamat bersifat opsional</li>
          </ul>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection