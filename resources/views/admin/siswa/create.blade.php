@extends('layouts.admin')

@section('title', 'Tambah Siswa')
@section('page-title', 'Tambah Siswa')

@section('breadcrumb')
  <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
  <li class="breadcrumb-item"><a href="{{ route('admin.siswa.index') }}">Data Siswa</a></li>
  <li class="breadcrumb-item active">Tambah Siswa</li>
@endsection

@section('content')
<div class="container-fluid">
  <div class="row">
    <div class="col-md-8">
      <div class="card">
        <div class="card-header">
          <h3 class="card-title">Form Tambah Siswa</h3>
        </div>
        
        <form action="{{ route('admin.siswa.store') }}" method="POST">
          @csrf
          <div class="card-body">
            
            <div class="form-group">
              <label for="nis">NIS <span class="text-danger">*</span></label>
              <input type="text" class="form-control @error('nis') is-invalid @enderror" 
                     id="nis" name="nis" value="{{ old('nis') }}" 
                     placeholder="Masukkan NIS siswa">
              @error('nis')
                <div class="invalid-feedback">{{ $message }}</div>
              @enderror
            </div>

            <div class="form-group">
              <label for="nama_siswa">Nama Siswa <span class="text-danger">*</span></label>
              <input type="text" class="form-control @error('nama_siswa') is-invalid @enderror" 
                     id="nama_siswa" name="nama_siswa" value="{{ old('nama_siswa') }}" 
                     placeholder="Masukkan nama lengkap siswa">
              @error('nama_siswa')
                <div class="invalid-feedback">{{ $message }}</div>
              @enderror
            </div>

            <div class="form-group">
              <label for="jenis_kelamin">Jenis Kelamin <span class="text-danger">*</span></label>
              <select class="form-control @error('jenis_kelamin') is-invalid @enderror" 
                      id="jenis_kelamin" name="jenis_kelamin">
                <option value="">-- Pilih Jenis Kelamin --</option>
                <option value="L" {{ old('jenis_kelamin') == 'L' ? 'selected' : '' }}>Laki-laki</option>
                <option value="P" {{ old('jenis_kelamin') == 'P' ? 'selected' : '' }}>Perempuan</option>
              </select>
              @error('jenis_kelamin')
                <div class="invalid-feedback">{{ $message }}</div>
              @enderror
            </div>

            <div class="form-group">
              <label for="tanggal_lahir">Tanggal Lahir</label>
              <input type="date" class="form-control @error('tanggal_lahir') is-invalid @enderror" 
                     id="tanggal_lahir" name="tanggal_lahir" value="{{ old('tanggal_lahir') }}">
              @error('tanggal_lahir')
                <div class="invalid-feedback">{{ $message }}</div>
              @enderror
            </div>

            <div class="form-group">
              <label for="alamat">Alamat</label>
              <textarea class="form-control @error('alamat') is-invalid @enderror" 
                        id="alamat" name="alamat" rows="3" 
                        placeholder="Masukkan alamat lengkap siswa">{{ old('alamat') }}</textarea>
              @error('alamat')
                <div class="invalid-feedback">{{ $message }}</div>
              @enderror
            </div>

          </div>

          <div class="card-footer">
            <button type="submit" class="btn btn-primary">
              <i class="fas fa-save"></i> Simpan
            </button>
            <a href="{{ route('admin.siswa.index') }}" class="btn btn-secondary">
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
            <li><i class="fas fa-info-circle text-info"></i> NIS harus unik dan tidak boleh sama</li>
            <li><i class="fas fa-info-circle text-info"></i> Nama siswa wajib diisi dengan lengkap</li>
            <li><i class="fas fa-info-circle text-info"></i> Jenis kelamin wajib dipilih</li>
            <li><i class="fas fa-info-circle text-info"></i> Tanggal lahir dan alamat bersifat opsional</li>
          </ul>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection