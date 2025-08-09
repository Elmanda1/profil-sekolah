@extends('layouts.admin')

@section('title', 'Data Siswa')
@section('page-title', 'Data Siswa')

@section('breadcrumb')
  <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
  <li class="breadcrumb-item active">Data Siswa</li>
@endsection

@section('content')
<div class="container-fluid">
  <div class="row">
    <div class="col-12">
      <div class="card">
        <div class="card-header">
          <h3 class="card-title">Daftar Siswa</h3>
          <div class="card-tools">
            <a href="{{ route('admin.siswa.create') }}" class="btn btn-primary btn-sm">
              <i class="fas fa-plus"></i> Tambah Siswa
            </a>
          </div>
        </div>
        
        <div class="card-body">
          <!-- Search Form -->
          <div class="row mb-3">
            <div class="col-md-6">
              <form action="{{ route('admin.siswa.index') }}" method="GET">
                <div class="input-group">
                  <input type="text" name="search" class="form-control" placeholder="Cari nama atau NIS siswa..." value="{{ $search }}">
                  <div class="input-group-append">
                    <button class="btn btn-outline-secondary" type="submit">
                      <i class="fas fa-search"></i>
                    </button>
                    @if($search)
                      <a href="{{ route('admin.siswa.index') }}" class="btn btn-outline-danger">
                        <i class="fas fa-times"></i>
                      </a>
                    @endif
                  </div>
                </div>
              </form>
            </div>
          </div>

          <!-- Table -->
          <div class="table-responsive">
            <table class="table table-bordered table-striped">
              <thead>
                <tr>
                  <th width="5%">No</th>
                  <th>NIS</th>
                  <th>Nama Siswa</th>
                  <th>Jenis Kelamin</th>
                  <th>Tanggal Lahir</th>
                  <th>Alamat</th>
                  <th width="15%">Aksi</th>
                </tr>
              </thead>
              <tbody>
                @forelse($siswa as $index => $item)
                  <tr>
                    <td>{{ $siswa->firstItem() + $index }}</td>
                    <td>{{ $item->nis }}</td>
                    <td>{{ $item->nama_siswa }}</td>
                    <td>
                      @if($item->jenis_kelamin == 'L')
                        <span class="badge badge-info">Laki-laki</span>
                      @else
                        <span class="badge badge-pink">Perempuan</span>
                      @endif
                    </td>
                    <td>{{ $item->tanggal_lahir_format }}</td>
                    <td>{{ Str::limit($item->alamat, 50) ?? '-' }}</td>
                    <td>
                      <div class="btn-group">
                        <a href="{{ route('admin.siswa.show', $item->id_siswa) }}" class="btn btn-info btn-sm" title="Detail">
                          <i class="fas fa-eye"></i>
                        </a>
                        <a href="{{ route('admin.siswa.edit', $item->id_siswa) }}" class="btn btn-warning btn-sm" title="Edit">
                          <i class="fas fa-edit"></i>
                        </a>
                        <button type="button" class="btn btn-danger btn-sm" title="Hapus" onclick="confirmDelete({{ $item->id_siswa }})">
                          <i class="fas fa-trash"></i>
                        </button>
                      </div>

                      <!-- Form Delete -->
                      <form id="delete-form-{{ $item->id_siswa }}" action="{{ route('admin.siswa.destroy', $item->id_siswa) }}" method="POST" style="display: none;">
                        @csrf
                        @method('DELETE')
                      </form>
                    </td>
                  </tr>
                @empty
                  <tr>
                    <td colspan="7" class="text-center text-muted">
                      @if($search)
                        Tidak ada data siswa yang cocok dengan pencarian "{{ $search }}"
                      @else
                        Belum ada data siswa
                      @endif
                    </td>
                  </tr>
                @endforelse
              </tbody>
            </table>
          </div>

          <!-- Pagination -->
          @if($siswa->hasPages())
            <div class="d-flex justify-content-center">
              {{ $siswa->appends(request()->query())->links() }}
            </div>
          @endif
        </div>
        
        <div class="card-footer">
          <small class="text-muted">
            Menampilkan {{ $siswa->firstItem() ?? 0 }} - {{ $siswa->lastItem() ?? 0 }} dari {{ $siswa->total() }} data siswa
          </small>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection

@push('scripts')
<script>
function confirmDelete(id) {
    if (confirm('Apakah Anda yakin ingin menghapus data siswa ini?')) {
        document.getElementById('delete-form-' + id).submit();
    }
}
</script>
@endpush