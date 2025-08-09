@extends('layouts.admin')

@section('title', 'Edit Guru')
@section('page-title', 'Edit Guru')

@section('breadcrumb')
  <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
  <li class="breadcrumb-item"><a href="{{ route('admin.guru.index') }}">Data Guru</a></li>
  <li class="breadcrumb-item active">Edit Guru</li>
@endsection

@section('content')
<div class="container-fluid">
  <div class="row">
    <div class="col-md-8">
      <div class="card">
        <div class="card-header">
          <h3 class="card-title">Form Edit Guru</h3>
        </div>
        
        <form action="{{ route('admin.guru.update', $guru->id_guru) }}" method="POST">
          @csrf
          @method('PUT')
          <div class="card-body">
            
            <div class="form-group">
              <label for="nip">NIP <span class="text-danger">*</span></label>
              <input type="text" class="form-control @error('nip') is-invalid @enderror" 
                     id="nip" name="nip" value="{{ old('nip', $guru->nip) }}" 
                     placeholder="Masukkan NIP Guru">
              @error('nip')
                <div class="invalid-feedback">{{ $message }}</div>
              @enderror
            </div>

            <div class="form-group">
              <label for="nama_guru">Nama Guru <span class="text-danger">*</span></label>
              <input type="text" class="form-control @error('nama_guru') is-invalid @enderror" 
                     id="nama_guru" name="nama_guru" value="{{ old('nama_guru', $guru->nama_guru) }}" 
                     placeholder="Masukkan nama lengkap guru">
              @error('nama_guru')
                <div class="invalid-feedback">{{ $message }}</div>
              @enderror
            </div>

            <div class="form-group">
              <label for="jenis_kelamin">Jenis Kelamin <span class="text-danger">*</span></label>
              <select class="form-control @error('jenis_kelamin') is-invalid @enderror" 
                      id="jenis_kelamin" name="jenis_kelamin">
                <option value="">-- Pilih Jenis Kelamin --</option>
                <option value="L" {{ old('jenis_kelamin', $guru->jenis_kelamin) == 'L' ? 'selected' : '' }}>Laki-laki</option>
                <option value="P" {{ old('jenis_kelamin', $guru->jenis_kelamin) == 'P' ? 'selected' : '' }}>Perempuan</option>
              </select>
              @error('jenis_kelamin')
                <div class="invalid-feedback">{{ $message }}</div>
              @enderror
            </div>

            <div class="form-group">
              <label for="mata_pelajaran">Tanggal Lahir</label>
              <input type="string" class="form-control @error('mata_pelajaran') is-invalid @enderror" 
                     id="mata_pelajaran" name="mata_pelajaran" 
                     value="{{ old('mata_pelajaran', $guru->mata_pelajaran ? $guru->mata_pelajaran>
              @error('mata_pelajaran')
                <div class="invalid-feedback">{{ $message }}</div>
              @enderror
            </div>

            <div class="form-group">
              <label for="alamat">Alamat</label>
              <textarea class="form-control @error('alamat') is-invalid @enderror" 
                        id="alamat" name="alamat" rows="3" 
                        placeholder="Masukkan alamat lengkap guru">{{ old('alamat', $guru->alamat) }}</textarea>
              @error('alamat')
                <div class="invalid-feedback">{{ $message }}</div>
              @enderror
            </div>

          </div>

          <div class="card-footer">
            <button type="submit" class="btn btn-primary">
              <i class="fas fa-save"></i> Update
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
          <h3 class="card-title">Data Lama</h3>
        </div>
        <div class="card-body">
          <table class="table table-sm">
            <tr>
              <td><strong>NIS</strong></td>
              <td>{{ $guru->nip }}</td>
            </tr>
            <tr>
              <td><strong>Nama</strong></td>
              <td>{{ $guru->nama_guru }}</td>
            </tr>
            <tr>
              <td><strong>JK</strong></td>
              <td>{{ $guru->jenis_kelamin_lengkap }}</td>
            </tr>
            <tr>
              <td><strong>Tgl Lahir</strong></td>
              <td>{{ $guru->tanggal_lahir_format }}</td>
            </tr>
          </table>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection