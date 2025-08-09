@extends('layouts.admin')

@section('title', 'Data Guru')
@section('page-title', 'Data Guru')

@section('breadcrumb')
  <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
  <li class="breadcrumb-item active">Data Guru</li>
@endsection

@section('content')
<div class="container-fluid">
  <div class="row">
    <div class="col-12">
      <div class="card">
        <div class="card-header">
          <h3 class="card-title">Daftar Guru</h3>
          <div class="card-tools">
            <a href="{{ route('admin.guru.create') }}" class="btn btn-success btn-sm">
              <i class="fas fa-plus"></i> Tambah Guru
            </a>
          </div>
        </div>
        
        <div class="card-body">
          <!-- Search Form -->
          <div class="row mb-3">
            <div class="col-md-6">
              <form action="{{ route('admin.guru.index') }}" method="GET">
                <div class="input-group">
                  <input type="text" name="search" class="form-control" placeholder="Cari nama, NIP, atau mata pelajaran..." value="{{ $search }}">
                  <div class="input-group-append">
                    <button class="btn btn-outline-secondary" type="submit">
                      <i class="fas fa-search"></i>
                    </button>
                    @if($search)
                      <a href="{{ route('admin.guru.index') }}" class="btn btn-outline-danger">
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
                  <th>NIP</th>
                  <th>Nama Guru</th>
                  <th>Jenis Kelamin</th>
                  <th>Mata Pelajaran</th>
                  <th>Alamat</th>
                  <th width="15%">Aksi</th>
                </tr>
              </thead>
              <tbody>
                @forelse($guru as $index => $item)
                  <tr>
                    <td>{{ $guru->firstItem() + $index }}</td>
                    <td>{{ $item->nip }}</td>
                    <td>{{ $item->nama_guru }}</td>
                    <td>
                      @if($item->jenis_kelamin == 'L')
                        <span class="badge badge-info">Laki-laki</span>
                      @else
                        <span class="badge badge-pink">Perempuan</span>
                      @endif
                    </td>
                    <td>{{ $item->mata_pelajaran }}</td>
                    <td>{{ Str::limit($item->alamat, 50) ?? '-' }}</td>
                    <td>
                      <div class="btn-group">
                        <a href="{{ route('admin.guru.show', $item->id_guru) }}" class="btn btn-info btn-sm" title="Detail">
                          <i class="fas fa-eye"></i>
                        </a>
                        <a href="{{ route('admin.guru.edit', $item->id_guru) }}" class="btn btn-warning btn-sm" title="Edit">
                          <i class="fas fa-edit"></i>
                        </a>
                        <button type="button" class="btn btn-danger btn-sm" title="Hapus" onclick="confirmDelete({{ $item->id_guru }})">
                          <i class="fas fa-trash"></i>
                        </button>
                      </div>

                      <!-- Form Delete -->
                      <form id="delete-form-{{ $item->id_guru }}" action="{{ route('admin.guru.destroy', $item->id_guru) }}" method="POST" style="display: none;">
                        @csrf
                        @method('DELETE')
                      </form>
                    </td>
                  </tr>
                @empty
                  <tr>
                    <td colspan="7" class="text-center text-muted">
                      @if($search)
                        Tidak ada data guru yang cocok dengan pencarian "{{ $search }}"
                      @else
                        Belum ada data guru
                      @endif
                    </td>
                  </tr>
                @endforelse
              </tbody>
            </table>
          </div>

          <!-- Pagination -->
          @if($guru->hasPages())
            <div class="d-flex justify-content-center">
              {{ $guru->appends(request()->query())->links() }}
            </div>
          @endif
        </div>
        
        <div class="card-footer">
          <small class="text-muted">
            Menampilkan {{ $guru->firstItem() ?? 0 }} - {{ $guru->lastItem() ?? 0 }} dari {{ $guru->total() }} data guru
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
    if (confirm('Apakah Anda yakin ingin menghapus data guru ini?')) {
        document.getElementById('delete-form-' + id).submit();
    }
}
</script>
@endpush