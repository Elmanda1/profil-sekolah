@extends('adminlte::page')

@section('title', 'Detail Berita')
@section('page-title', 'Detail Berita')

@section('breadcrumb')
  <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
  <li class="breadcrumb-item"><a href="{{ route('admin.berita.index') }}">Data Berita</a></li>
  <li class="breadcrumb-item active">Detail Berita</li>
@endsection

@section('content')
<div class="container-fluid">
  <div class="row">
    <div class="col-md-8">
      <div class="card">
        <div class="card-header">
          <h3 class="card-title">
            <i class="fas fa-newspaper"></i> {{ $artikel->judul }}
          </h3>
          <div class="card-tools">
            <a href="{{ route('admin.berita.edit', $artikel->id_artikel) }}" class="btn btn-warning btn-sm">
              <i class="fas fa-edit"></i> Edit
            </a>
          </div>
        </div>
        
        <div class="card-body">
          <div class="row">
            <div class="col-md-12">
              <table class="table table-striped">
                <tr>
                  <th width="20%">ID Artikel</th>
                  <td>{{ $artikel->id_artikel }}</td>
                </tr>
                <tr>
                  <th>Judul</th>
                  <td>{{ $artikel->judul }}</td>
                </tr>
                <tr>
                  <th>Tanggal</th>
                  <td>{{ $artikel->tanggal ? $artikel->tanggal->format('d M Y') : '-' }}</td>
                </tr>
                <tr>
                  <th>Sekolah</th>
                  <td>{{ $artikel->sekolah->nama_sekolah ?? '-' }}</td>
                </tr>
                <tr>
                  <th>Penulis</th>
                  <td>{{ $artikel->penulis ?? '-' }}</td>
                </tr>
                <tr>
                  <th>Gambar</th>
                  <td>
                    @if($artikel->gambar)
                      <img src="{{ asset('photos/' . $artikel->gambar) }}" alt="Gambar Artikel" class="img-thumbnail" style="max-width: 200px;">
                    @else
                      <span class="text-muted">Tidak ada gambar</span>
                    @endif
                  </td>
                </tr>
                <tr>
                  <th>Isi Berita</th>
                  <td>{!! $artikel->isi !!}</td>
                </tr>
              </table>
            </div>
          </div>
        </div>

        <div class="card-footer">
          <a href="{{ route('admin.berita.index') }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left"></i> Kembali ke Daftar Berita
          </a>
          <a href="{{ route('admin.berita.edit', ['berita' => $artikel]) }}" class="btn btn-warning">
            <i class="fas fa-edit"></i> Edit Data
          </a>
          <button type="button" class="btn btn-danger" onclick="confirmDelete()">
            <i class="fas fa-trash"></i> Hapus Data
          </button>

          <!-- Form Delete -->
          <form id="delete-form" action="{{ route('admin.berita.destroy', $artikel->id_artikel) }}" method="POST" style="display: none;">
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
            <li><i class="fas fa-info-circle text-info"></i> Detail lengkap berita yang dipilih.</li>
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
    if (confirm('Apakah Anda yakin ingin menghapus berita "{{ $artikel->judul }}"?')) {
        document.getElementById('delete-form').submit();
    }
}
</script>
@endpush
