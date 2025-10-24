@extends('adminlte::page')

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
              <label for="nisn">NISN <span class="text-danger">*</span></label>
              <input type="text" class="form-control @error('nisn') is-invalid @enderror" 
                     id="nisn" name="nisn" value="{{ old('nisn') }}" 
                     placeholder="Masukkan NISN siswa">
              @error('nisn')
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
                <option value="Laki-laki" {{ old('jenis_kelamin') == 'Laki-laki' ? 'selected' : '' }}>Laki-laki</option>
                <option value="Perempuan" {{ old('jenis_kelamin') == 'Perempuan' ? 'selected' : '' }}>Perempuan</option>
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
              <label for="id_kelas">Kelas <span class="text-danger">*</span></label>
              <select class="form-control @error('id_kelas') is-invalid @enderror" 
                      id="id_kelas" name="id_kelas">
                <option value="">-- Pilih Kelas --</option>
                @foreach($kelass as $kelas)
                  <option value="{{ $kelas->id_kelas }}" {{ old('id_kelas') == $kelas->id_kelas ? 'selected' : '' }}>
                    {{ $kelas->nama_kelas }} ({{ $kelas->jurusan->nama_jurusan ?? '-' }})
                  </option>
                @endforeach
              </select>
              @error('id_kelas')
                <div class="invalid-feedback">{{ $message }}</div>
              @enderror
            </div>

            <div class="form-group">
              <label for="tahun_ajaran">Tahun Ajaran <span class="text-danger">*</span></label>
              <input type="text" class="form-control @error('tahun_ajaran') is-invalid @enderror" 
                     id="tahun_ajaran" name="tahun_ajaran" value="{{ old('tahun_ajaran') }}" 
                     placeholder="Contoh: 2023/2024">
              @error('tahun_ajaran')
                <div class="invalid-feedback">{{ $message }}</div>
              @enderror
            </div>

            <div class="form-group">
              <label for="semester">Semester <span class="text-danger">*</span></label>
              <select class="form-control @error('semester') is-invalid @enderror" 
                      id="semester" name="semester">
                <option value="">-- Pilih Semester --</option>
                <option value="1" {{ old('semester') == '1' ? 'selected' : '' }}>Ganjil</option>
                <option value="2" {{ old('semester') == '2' ? 'selected' : '' }}>Genap</option>
              </select>
              @error('semester')
                <div class="invalid-feedback">{{ $message }}</div>
              @enderror
            </div>

            <div class="form-group">
              <div class="custom-control custom-checkbox">
                <input type="checkbox" class="custom-control-input" id="create_account" name="create_account" value="1" {{ old('create_account') ? 'checked' : '' }}>
                <label class="custom-control-label" for="create_account">Buat Akun Pengguna</label>
              </div>
            </div>

            <div id="account_fields" style="display: {{ old('create_account') ? 'block' : 'none' }};">
              <div class="form-group">
                <label for="username">Username <span class="text-danger">*</span></label>
                <input type="text" class="form-control @error('username') is-invalid @enderror" 
                       id="username" name="username" value="{{ old('username') }}" 
                       placeholder="Masukkan username">
                @error('username')
                  <div class="invalid-feedback">{{ $message }}</div>
                @enderror
              </div>

              <div class="form-group">
                <label for="password">Password <span class="text-danger">*</span></label>
                <input type="password" class="form-control @error('password') is-invalid @enderror" 
                       id="password" name="password" placeholder="Masukkan password">
                @error('password')
                  <div class="invalid-feedback">{{ $message }}</div>
                @enderror
              </div>
            </div>

            @push('scripts')
            <script>
              document.getElementById('create_account').addEventListener('change', function() {
                var accountFields = document.getElementById('account_fields');
                if (this.checked) {
                  accountFields.style.display = 'block';
                } else {
                  accountFields.style.display = 'none';
                }
              });
            </script>
            @endpush

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