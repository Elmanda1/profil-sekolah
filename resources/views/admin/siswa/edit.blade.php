@extends('adminlte::page')

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
        
        <form id="edit-siswa-form" action="{{ route('admin.siswa.update', $siswa->id_siswa) }}" method="POST">
          @csrf
          @method('PUT')
          <div class="card-body">
            
            <div class="form-group">
              <label for="nisn">NISN <span class="text-danger">*</span></label>
              <input type="text" class="form-control @error('nisn') is-invalid @enderror" 
                     id="nisn" name="nisn" value="{{ old('nisn', $siswa->nisn) }}" 
                     placeholder="Masukkan NISN siswa">
              @error('nisn')
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
                <option value="Laki-laki" {{ old('jenis_kelamin', $siswa->jenis_kelamin) == 'Laki-laki' ? 'selected' : '' }}>Laki-laki</option>
                <option value="Perempuan" {{ old('jenis_kelamin', $siswa->jenis_kelamin) == 'Perempuan' ? 'selected' : '' }}>Perempuan</option>
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

            <div class="form-group">
              <label for="id_sekolah">Sekolah <span class="text-danger">*</span></label>
              <select class="form-control @error('id_sekolah') is-invalid @enderror" 
                      id="id_sekolah" name="id_sekolah">
                <option value="">-- Pilih Sekolah --</option>
                @foreach($sekolahs as $sekolah)
                  <option value="{{ $sekolah->id_sekolah }}" {{ old('id_sekolah', $siswa->id_sekolah) == $sekolah->id_sekolah ? 'selected' : '' }}>
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
                  <option value="{{ $kelas->id_kelas }}" {{ old('id_kelas', $siswa->kelasSiswa->first()->id_kelas ?? '') == $kelas->id_kelas ? 'selected' : '' }}>
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
                     id="tahun_ajaran" name="tahun_ajaran" value="{{ old('tahun_ajaran', $siswa->kelasSiswa->first()->tahun_ajaran ?? '') }}" 
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
                <option value="1" {{ old('semester', $siswa->kelasSiswa->first()->semester ?? '') == '1' ? 'selected' : '' }}>Ganjil</option>
                <option value="2" {{ old('semester', $siswa->kelasSiswa->first()->semester ?? '') == '2' ? 'selected' : '' }}>Genap</option>
              </select>
              @error('semester')
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
              <td>{{ $siswa->nisn }}</td>
            </tr>
            <tr>
              <td><strong>Nama</strong></td>
              <td>{{ $siswa->nama_siswa }}</td>
            </tr>
            <tr>
              <td><strong>JK</strong></td>
              <td>{{ $siswa->jenis_kelamin }}</td>
            </tr>
            <tr>
              <td><strong>Tgl Lahir</strong></td>
              <td>{{ $siswa->tanggal_lahir->format('Y-m-d') ?? '-' }}</td>
            </tr>
          </table>
        </div>
      </div>
    @endsection
    
    @push('scripts')
    <script>
    $('#edit-siswa-form').on('submit', function(e) {
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
                window.location.href = '{{ route("admin.siswa.index") }}';
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
    @endpush