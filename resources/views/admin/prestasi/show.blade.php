@extends('adminlte::page')

@section('title', 'Detail Prestasi')
@section('page-title', 'Detail Prestasi')

@section('breadcrumb')
  <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
  <li class="breadcrumb-item"><a href="{{ route('admin.prestasi.index') }}">Data Prestasi</a></li>
  <li class="breadcrumb-item active">Detail Prestasi</li>
@endsection

@section('content')
<div class="container-fluid">
  <div class="row">
    <div class="col-md-8">
      <div class="card">
        <div class="card-header">
          <h3 class="card-title">
            <i class="fas fa-trophy"></i> {{ $prestasi->judul }}
          </h3>
          <div class="card-tools">
            <a href="{{ route('admin.prestasi.edit', $prestasi->id_prestasi) }}" class="btn btn-warning btn-sm">
              <i class="fas fa-edit"></i> Edit
            </a>
          </div>
        </div>
        
        <div class="card-body">
          <div class="row">
            <div class="col-md-6">
              <table class="table table-striped">
                <tr>
                  <th width="40%">ID Prestasi</th>
                  <td>{{ $prestasi->id_prestasi }}</td>
                </tr>
                <tr>
                  <th>Judul</th>
                  <td>{{ $prestasi->judul }}</td>
                </tr>
                <tr>
                  <th>Tanggal</th>
                  <td>{{ $prestasi->tanggal ? $prestasi->tanggal->format('d M Y') : '-' }}</td>
                </tr>
                <tr>
                  <th>Tingkat</th>
                  <td>{{ $prestasi->tingkat }}</td>
                </tr>
                <tr>
                  <th>Peringkat</th>
                  <td>{{ $prestasi->peringkat }}</td>
                </tr>
              </table>
            </div>
            
            <div class="col-md-6">
              <table class="table table-striped">
                <tr>
                  <th width="40%">Sekolah</th>
                  <td>{{ $prestasi->sekolah->nama_sekolah ?? '-' }}</td>
                </tr>
                <tr>
                  <th>Deskripsi</th>
                  <td>
                    @if($prestasi->deskripsi)
                      {{ $prestasi->deskripsi }}
                    @else
                      <span class="text-muted">Tidak ada deskripsi</span>
                    @endif
                  </td>
                </tr>
                <tr>
                  <th>Gambar</th>
                  <td>
                    @if($prestasi->gambar)
                      <img src="{{ asset('photos/' . $prestasi->gambar) }}" alt="Gambar Prestasi" class="img-thumbnail" style="max-width: 150px;">
                    @else
                      <span class="text-muted">Tidak ada gambar</span>
                    @endif
                  </td>
                </tr>
              </table>
            </div>
          </div>
        </div>

        <div class="card-footer">
          <a href="{{ route('admin.prestasi.index') }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left"></i> Kembali ke Daftar Prestasi
          </a>
          <a href="{{ route('admin.prestasi.edit', $prestasi->id_prestasi) }}" class="btn btn-warning">
            <i class="fas fa-edit"></i> Edit Data
          </a>
          <button type="button" class="btn btn-danger" onclick="confirmDelete()">
            <i class="fas fa-trash"></i> Hapus Data
          </button>

          <!-- Form Delete -->
          <form id="delete-form" action="{{ route('admin.prestasi.destroy', $prestasi->id_prestasi) }}" method="POST" style="display: none;">
            @csrf
            @method('DELETE')
          </form>
        </div>
      </div>
    </div>

    <div class="col-md-4">
      <div class="card card-info">
        <div class="card-header">
          <h3 class="card-title">Informasi</h3>
        </div>
        <div class="card-body">
          <p><strong>Petunjuk:</strong></p>
          <ul class="list-unstyled">
            <li><i class="fas fa-info-circle text-info"></i> Detail lengkap prestasi yang dipilih.</li>
            <li><i class="fas fa-info-circle text-info"></i> Gunakan tombol edit untuk mengubah data.</li>
            <li><i class="fas fa-info-circle text-info"></i> Gunakan tombol hapus untuk menghapus data.</li>
          </ul>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection

@push('scripts')
<script>
function confirmDelete() {
    if (confirm('Apakah Anda yakin ingin menghapus prestasi "{{ $prestasi->judul }}"?')) {
        document.getElementById('delete-form').submit();
    }
}
</script>
@endpush
