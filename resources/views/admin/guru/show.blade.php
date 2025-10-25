@extends('adminlte::page')

@section('title', 'Detail Guru')
@section('page-title', 'Detail Guru')

@section('breadcrumb')
  <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
  <li class="breadcrumb-item"><a href="{{ route('admin.guru.index') }}">Data Guru</a></li>
  <li class="breadcrumb-item active">Detail Guru</li>
@endsection

@section('content')
<div class="container-fluid">
  <div class="row">
    <div class="col-md-8">
      <div class="card">
        <div class="card-header">
          <h3 class="card-title">
            <i class="fas fa-user"></i> {{ $guru->nama_guru }}
          </h3>
          <div class="card-tools">
            <a href="{{ route('admin.guru.edit', $guru->id_guru) }}" class="btn btn-warning btn-sm">
              <i class="fas fa-edit"></i> Edit
            </a>
          </div>
        </div>
        
        <div class="card-body">
          <div class="row">
            <div class="col-md-6">
              <table class="table table-striped">
                <tr>
                  <th width="40%">ID guru</th>
                  <td>{{ $guru->id_guru }}</td>
                </tr>
                <tr>
                  <th>NIS</th>
                  <td>{{ $guru->nip }}</td>
                </tr>
                <tr>
                  <th>Nama guru</th>
                  <td>{{ $guru->nama_guru }}</td>
                </tr>
                <tr>
                  <th>Jenis Kelamin</th>
                  <td>
                    @if($guru->jenis_kelamin == 'L')
                      <span class="badge badge-info">
                        <i class="fas fa-male"></i> Laki-laki
                      </span>
                    @else
                      <span class="badge badge-pink">
                        <i class="fas fa-female"></i> Perempuan
                      </span>
                    @endif
                  </td>
                </tr>
              </table>
            </div>
            
            <div class="col-md-6">
              <table class="table table-striped">
                <tr>
                  <th width="40%">Tanggal Lahir</th>
                  <td>
                    @if($guru->mata_pelajaran)
                      {{ $guru->mata_pelajaran}}
                      <small class="text-muted">({{ $guru->mata_pelajaran->diffForHumans() }})</small>
                    @else
                      <span class="text-muted">Tidak diisi</span>
                    @endif
                  </td>
                </tr>
                <tr>
                  <th>Alamat</th>
                  <td>
                    @if($guru->alamat)
                      {{ $guru->alamat }}
                    @else
                      <span class="text-muted">Tidak diisi</span>
                    @endif
                  </td>
                </tr>
              </table>
            </div>
          </div>
        </div>

        <div class="card-footer">
          <a href="{{ route('admin.guru.index') }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left"></i> Kembali ke Daftar guru
          </a>
          <a href="{{ route('admin.guru.edit', $guru->id_guru) }}" class="btn btn-warning">
            <i class="fas fa-edit"></i> Edit Data
          </a>
          <button type="button" class="btn btn-danger" onclick="confirmDelete()">
            <i class="fas fa-trash"></i> Hapus Data
          </button>

          <!-- Form Delete -->
          <form id="delete-form" action="{{ route('admin.guru.destroy', $guru->id_guru) }}" method="POST" style="display: none;">
            @csrf
            @method('DELETE')
          </form>
        </div>
      </div>
    </div>

    <div class="col-md-4">
      <div class="card card-success">
        <div class="card-header">
          <h3 class="card-title">Statistik</h3>
        </div>
        <div class="card-body">
          <div class="info-box">
            <span class="info-box-icon bg-info"><i class="fas fa-users"></i></span>
            <div class="info-box-content">
              <span class="info-box-text">Total guru</span>
              <span class="info-box-number">{{ \App\Models\guru::count() }}</span>
            </div>
          </div>

          <div class="info-box">
            <span class="info-box-icon bg-success"><i class="fas fa-male"></i></span>
            <div class="info-box-content">
              <span class="info-box-text">guru Laki-laki</span>
              <span class="info-box-number">{{ \App\Models\guru::where('jenis_kelamin', 'L')->count() }}</span>
            </div>
          </div>

          <div class="info-box">
            <span class="info-box-icon bg-warning"><i class="fas fa-female"></i></span>
            <div class="info-box-content">
              <span class="info-box-text">guru Perempuan</span>
              <span class="info-box-number">{{ \App\Models\guru::where('jenis_kelamin', 'P')->count() }}</span>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection

@push('scripts')
<script>
function confirmDelete() {
    if (confirm('Apakah Anda yakin ingin menghapus data guru "{{ $guru->nama_guru }}"?')) {
        document.getElementById('delete-form').submit();
    }
}
</script>
@endpush