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
        
        <form id="create-guru-form" action="{{ route('admin.guru.store') }}" method="POST" enctype="multipart/form-data">
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
              <label for="email">Email <span class="text-danger">*</span></label>
              <input type="email" class="form-control @error('email') is-invalid @enderror" 
                     id="email" name="email" value="{{ old('email') }}" 
                     placeholder="Masukkan email guru">
              @error('email')
                <div class="invalid-feedback">{{ $message }}</div>
              @enderror
            </div>

            <div class="form-group">
              <label for="no_telp">No. Telepon</label>
              <input type="text" class="form-control @error('no_telp') is-invalid @enderror" 
                     id="no_telp" name="no_telp" value="{{ old('no_telp') }}" 
                     placeholder="Masukkan nomor telepon guru">
              @error('no_telp')
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

            <div class="form-group">
              <label for="foto">Foto</label>
              <input type="file" class="form-control-file @error('foto') is-invalid @enderror" 
                     id="foto" name="foto">
              @error('foto')
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

              <div class="form-group">
                <label for="password_confirmation">Konfirmasi Password <span class="text-danger">*</span></label>
                <input type="password" class="form-control" 
                       id="password_confirmation" name="password_confirmation" placeholder="Konfirmasi password">
              </div>
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

@push('scripts')
<script>
$(function() {
    console.log('Create guru script loaded!');

    document.getElementById('create_account').addEventListener('change', function() {
        var accountFields = document.getElementById('account_fields');
        if (this.checked) {
            accountFields.style.display = 'block';
        } else {
            accountFields.style.display = 'none';
        }
    });

    $('#create-guru-form').on('submit', function(e) {
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
                window.location.replace('{{ route("admin.guru.index") }}');
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
@endpush