@extends('adminlte::page')

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
              <form id="search-form">
                <div class="input-group">
                  <input type="text" id="search-input" name="search" class="form-control" placeholder="Cari nama atau NIS siswa..." value="{{ $search }}">
                  <div class="input-group-append">
                    <button class="btn btn-outline-secondary" type="submit" id="search-button">
                      <i class="fas fa-search"></i>
                    </button>
                    @if($search)
                      <a href="{{ route('admin.siswa.index') }}" class="btn btn-outline-danger" id="clear-search-button">
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
            <table class="table table-bordered table-striped" id="siswa-table">
              <thead>
                <tr>
                  <th width="5%">No</th>
                  <th>NISN</th>
                  <th>Nama Siswa</th>
                  <th>Jenis Kelamin</th>
                  <th>Tanggal Lahir</th>
                  <th>Alamat</th>
                  <th width="15%">Aksi</th>
                </tr>
              </thead>
              <tbody>
                @forelse($siswas as $index => $item)
                  <tr>
                    <td>{{ $siswas->firstItem() + $index }}</td>
                    <td>{{ $item->nisn }}</td>
                    <td>{{ $item->nama_siswa }}</td>
                    <td>
                      @if($item->jenis_kelamin == 'Laki-laki')
                        <span class="badge badge-info">Laki-laki</span>
                      @elseif($item->jenis_kelamin == 'Perempuan')
                        <span class="badge badge-pink">Perempuan</span>
                      @else
                        -
                      @endif
                    </td>
                    <td>{{ $item->tanggal_lahir->format('Y-m-d') ?? '-' }}</td>
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
          @if($siswas->hasPages())
            <div class="d-flex justify-content-center">
              {{ $siswas->appends(request()->query())->links() }}
            </div>
          @endif
        </div>
        
        <div class="card-footer">
          <small class="text-muted">
            Menampilkan {{ $siswas->firstItem() ?? 0 }} - {{ $siswas->lastItem() ?? 0 }} dari {{ $siswas->total() }} data siswa
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
        $.ajax({
            url: '{{ route("api.v1.students.destroy", "") }}/' + id,
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
                alert('Gagal menghapus data siswa.');
            }
        });
    }
}

$('#search-form').on('submit', function(e) {
    e.preventDefault();
    let searchValue = $('#search-input').val();
    fetchStudents(searchValue);
});

function fetchStudents(search = '') {
    $.ajax({
        url: '{{ route("api.v1.students.index") }}',
        type: 'GET',
        data: {
            search: search
        },
        success: function(result) {
            let tableBody = $('#siswa-table tbody');
            tableBody.empty();
            if (result.data.length > 0) {
                $.each(result.data, function(index, item) {
                    let row = `
                        <tr>
                            <td>${index + 1}</td>
                            <td>${item.nisn}</td>
                            <td>${item.nama_siswa}</td>
                            <td>
                                ${item.jenis_kelamin == 'Laki-laki' ? '<span class="badge badge-info">Laki-laki</span>' : (item.jenis_kelamin == 'Perempuan' ? '<span class="badge badge-pink">Perempuan</span>' : '-')}
                            </td>
                            <td>${item.tanggal_lahir ? new Date(item.tanggal_lahir).toISOString().split('T')[0] : '-'}</td>
                            <td>${item.alamat ? item.alamat.substring(0, 50) : '-'}</td>
                            <td>
                                <div class="btn-group">
                                    <a href="/admin/siswa/${item.id_siswa}" class="btn btn-info btn-sm" title="Detail">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <a href="/admin/siswa/${item.id_siswa}/edit" class="btn btn-warning btn-sm" title="Edit">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <button type="button" class="btn btn-danger btn-sm" title="Hapus" onclick="confirmDelete(${item.id_siswa})">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                    `;
                    tableBody.append(row);
                });
            } else {
                let row = `
                    <tr>
                        <td colspan="7" class="text-center text-muted">
                            ${search ? `Tidak ada data siswa yang cocok dengan pencarian "${search}"` : 'Belum ada data siswa'}
                        </td>
                    </tr>
                `;
                tableBody.append(row);
            }
        }
    });
}
</script>
@endpush