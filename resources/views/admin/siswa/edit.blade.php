@extends('layouts.admin')

@section('title', 'Edit Siswa')
@section('page-title', 'Edit Siswa')

@section('breadcrumb')
  <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
  <li class="breadcrumb-item"><a href="{{ route('admin.siswa.index') }}">Data Siswa</a></li>
  <li class="breadcrumb-item active">Edit Siswa</li>
@endsection

@section('content')
<div class="container-fluid">
  <div class="row">
    <div class="col-md-8">
      <div class="card">
        <div class="card-header">
          <h3 class="card-title">Form Edit Siswa</h3>
        </div>
        
        <form action="{{ route('admin.siswa.update', $siswa->id_siswa) }}" method="POST">
          @csrf
          @method('PUT')
          <div class="card-body">
            
            <div class="form-group">
              <label for="nis">NIS <span class="text-danger">*</span></label>
              <input type="text" class="form-control @error('nis') is-invalid @enderror" 
                     id="nis" name="nis" value="{{ old('nis', $siswa->nis) }}" 
                     placeholder="Masukkan NIS siswa">
              @error('nis')
                <div class="invalid-feedback">{{ $message }}</div>
              @enderror
            </div>

            <div class="form-group">
              <label for="nama_siswa">Nama Siswa <span class="text-danger">*</span></label>
              <input type="text" class="form-control @error('nama_siswa') is-invalid @enderror" 
                     id="nama_siswa" name="nama_siswa" value="{{ old('nama_siswa', $siswa->nama_siswa) }}" 
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
                <option value="L" {{ old('jenis_kelamin', $siswa->jenis_kelamin) == 'L' ? 'selected' : '' }}>Laki-laki</option>
                <option value="P" {{ old('jenis_kelamin', $siswa->jenis_kelamin) == 'P' ? 'selected' : '' }}>Perempuan</option>
              </select>
              @error('jenis_kelamin')
                <div class="invalid-feedback">{{ $message }}</div>
              @enderror
            </div>

            <div class="form-group">
              <label for="tanggal_lahir">Tanggal Lahir</label>
              <input type="date" class="form-control @error('tanggal_lahir') is-invalid @enderror" 
                     id="tanggal_lahir" name="tanggal_lahir" 
                     value="{{ old('tanggal_lahir', $siswa->tanggal_lahir ? $siswa->tanggal_lahir->format('Y-m-d') : '') }}">
              @error('tanggal_lahir')
                <div class="invalid-feedback">{{ $message }}</div>
              @enderror
            </div>

            <div class="form-group">
              <label for="alamat">Alamat</label>
              <textarea class="form-control @error('alamat') is-invalid @enderror" 
                        id="alamat" name="alamat" rows="3" 
                        placeholder="Masukkan alamat lengkap siswa">{{ old('alamat', $siswa->alamat) }}</textarea>
              @error('alamat')
                <div class="invalid-feedback">{{ $message }}</div>
              @enderror
            </div>

          </div>

          <div class="card-footer">
            <button type="submit" class="btn btn-primary">
              <i class="fas fa-save"></i> Update
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
          <h3 class="card-title">Data Lama</h3>
        </div>
        <div class="card-body">
          <table class="table table-sm">
            <tr>
              <td><strong>NIS</strong></td>
              <td>{{ $siswa->nis }}</td>
            </tr>
            <tr>
              <td><strong>Nama</strong></td>
              <td>{{ $siswa->nama_siswa }}</td>
            </tr>
            <tr>
              <td><strong>JK</strong></td>
              <td>{{ $siswa->jenis_kelamin_lengkap }}</td>
            </tr>
            <tr>
              <td><strong>Tgl Lahir</strong></td>
              <td>{{ $siswa->tanggal_lahir_format }}</td>
            </tr>
          </table>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection