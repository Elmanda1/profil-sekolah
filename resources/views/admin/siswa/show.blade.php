@extends('layouts.admin')

@section('title', 'Detail Siswa')
@section('page-title', 'Detail Siswa')

@section('breadcrumb')
  <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
  <li class="breadcrumb-item"><a href="{{ route('admin.siswa.index') }}">Data Siswa</a></li>
  <li class="breadcrumb-item active">Detail Siswa</li>
@endsection

@section('content')
<div class="container-fluid">
  <div class="row">
    <div class="col-md-8">
      <div class="card">
        <div class="card-header">
          <h3 class="card-title">
            <i class="fas fa-user"></i> {{ $siswa->nama_siswa }}
          </h3>
          <div class="card-tools">
            <a href="{{ route('admin.siswa.edit', $siswa->id_siswa) }}" class="btn btn-warning btn-sm">
              <i class="fas fa-edit"></i> Edit
            </a>
          </div>
        </div>
        
        <div class="card-body">
          <div class="row">
            <div class="col-md-6">
              <table class="table table-striped">
                <tr>
                  <th width="40%">ID Siswa</th>
                  <td>{{ $siswa->id_siswa }}</td>
                </tr>
                <tr>
                  <th>NIS</th>
                  <td>{{ $siswa->nis }}</td>
                </tr>
                <tr>
                  <th>Nama Siswa</th>
                  <td>{{ $siswa->nama_siswa }}</td>
                </tr>
                <tr>
                  <th>Jenis Kelamin</th>
                  <td>
                    @if($siswa->jenis_kelamin == 'L')
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
                    @if($siswa->tanggal_lahir)
                      {{ $siswa->tanggal_lahir_format }}
                      <small class="text-muted">({{ $siswa->tanggal_lahir->diffForHumans() }})</small>
                    @else
                      <span class="text-muted">Tidak diisi</span>
                    @endif
                  </td>
                </tr>
                <tr>
                  <th>Alamat</th>
                  <td>
                    @if($siswa->alamat)
                      {{ $siswa->alamat }}
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
          <a href="{{ route('admin.siswa.index') }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left"></i> Kembali ke Daftar Siswa
          </a>
          <a href="{{ route('admin.siswa.edit', $siswa->id_siswa) }}" class="btn btn-warning">
            <i class="fas fa-edit"></i> Edit Data
          </a>
          <button type="button" class="btn btn-danger" onclick="confirmDelete()">
            <i class="fas fa-trash"></i> Hapus Data
          </button>

          <!-- Form Delete -->
          <form id="delete-form" action="{{ route('admin.siswa.destroy', $siswa->id_siswa) }}" method="POST" style="display: none;">
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
              <span class="info-box-text">Total Siswa</span>
              <span class="info-box-number">{{ \App\Models\Siswa::count() }}</span>
            </div>
          </div>

          <div class="info-box">
            <span class="info-box-icon bg-success"><i class="fas fa-male"></i></span>
            <div class="info-box-content">
              <span class="info-box-text">Siswa Laki-laki</span>
              <span class="info-box-number">{{ \App\Models\Siswa::where('jenis_kelamin', 'L')->count() }}</span>
            </div>
          </div>

          <div class="info-box">
            <span class="info-box-icon bg-warning"><i class="fas fa-female"></i></span>
            <div class="info-box-content">
              <span class="info-box-text">Siswa Perempuan</span>
              <span class="info-box-number">{{ \App\Models\Siswa::where('jenis_kelamin', 'P')->count() }}</span>
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
    if (confirm('Apakah Anda yakin ingin menghapus data siswa "{{ $siswa->nama_siswa }}"?')) {
        document.getElementById('delete-form').submit();
    }
}
</script>
@endpush