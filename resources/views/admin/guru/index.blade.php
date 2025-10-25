@extends('adminlte::page')

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
              <form id="search-form">
                <div class="input-group">
                  <input type="text" id="search-input" name="search" class="form-control" placeholder="Cari nama, NIP, atau mata pelajaran..." value="{{ $search }}">
                  <div class="input-group-append">
                    <button class="btn btn-outline-secondary" type="submit" id="search-button">
                      <i class="fas fa-search"></i>
                    </button>
                    @if($search)
                      <a href="{{ route('admin.guru.index') }}" class="btn btn-outline-danger" id="clear-search-button">
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
            <table class="table table-bordered table-striped" id="guru-table">
              <thead>
                <tr>
                  <th width="5%">No</th>
                  <th>NIP</th>
                  <th>Nama Guru</th>
                  <th>Mata Pelajaran</th>
                  <th>Alamat</th>
                  <th width="15%">Aksi</th>
                </tr>
              </thead>
              <tbody>
                @forelse($gurus as $index => $item)
                  <tr>
                    <td>{{ $gurus->firstItem() + $index }}</td>
                    <td>{{ $item->nip }}</td>
                    <td>{{ $item->nama_guru }}</td>
                    <td>
                      @forelse($item->mapel as $mapel)
                        <span class="badge badge-secondary">{{ $mapel->nama_mapel }}</span>
                      @empty
                        -
                      @endforelse
                    </td>
                    <td>{{ Str::limit($item->alamat, 50) ?? '-' }}</td>
                    <td>
                      <div class="btn-group">
                        <a href="{{ route('admin.guru.show', ['guru' => $item]) }}" class="btn btn-info btn-sm" title="Detail">
                          <i class="fas fa-eye"></i>
                        </a>
                        <a href="{{ route('admin.guru.edit', ['guru' => $item]) }}" class="btn btn-warning btn-sm" title="Edit">
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
          @if($gurus->hasPages())
            <div class="d-flex justify-content-center">
              {{ $gurus->appends(request()->query())->links() }}
            </div>
          @endif
        </div>
        
        <div class="card-footer">
          <small class="text-muted">
            Menampilkan {{ $gurus->firstItem() ?? 0 }} - {{ $gurus->lastItem() ?? 0 }} dari {{ $gurus->total() }} data guru
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
        $.ajax({
            url: '/admin/api/v1/gurus/' + id,
            type: 'DELETE',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function(result) {
                // Do something with the result
                location.reload();
            },
            error: function(err) {
                // Do something with the error
                alert('Gagal menghapus data guru.');
            }
        });
    }
}


</script>
@endpush