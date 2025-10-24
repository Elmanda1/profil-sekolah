@extends('adminlte::page')

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
        
        <form id="edit-guru-form" action="{{ route('admin.guru.update', $guru->id_guru) }}" method="POST">
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
              <label for="mapel">Mata Pelajaran</label>
              <select class="form-control select2 @error('mapel') is-invalid @enderror" 
                      id="mapel" name="mapel[]" multiple>
                @foreach($mapels as $mapel)
                  <option value="{{ $mapel->id_mapel }}" {{ in_array($mapel->id_mapel, old('mapel', $guru->mapel->pluck('id_mapel')->toArray())) ? 'selected' : '' }}>
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
              <td><strong>NIP</strong></td>
              <td>{{ $guru->nip }}</td>
            </tr>
            <tr>
              <td><strong>Nama</strong></td>
              <td>{{ $guru->nama_guru }}</td>
            </tr>
          </table>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection

@push('scripts')
<script>
$('#edit-guru-form').on('submit', function(e) {
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
            window.location.href = '{{ route("admin.guru.index") }}';
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