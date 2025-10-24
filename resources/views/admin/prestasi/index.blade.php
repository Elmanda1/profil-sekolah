@extends('adminlte::page')

@section('title', 'Data Prestasi')

@section('content')
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">Data Prestasi</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                    <li class="breadcrumb-item active">Data Prestasi</li>
                </ol>
            </div>
        </div>
    </div>
</div>

<section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Daftar Prestasi</h3>
                        <div class="card-tools">
                            <a href="{{ route('admin.prestasi.create') }}" class="btn btn-primary btn-sm">
                                <i class="fas fa-plus"></i> Tambah Prestasi
                            </a>
                        </div>
                    </div>
                    <div class="card-body">
                        @if(session('success'))
                            <div class="alert alert-success alert-dismissible">
                                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                                {{ session('success') }}
                            </div>
                        @endif

                        <div class="row mb-3">
                            <div class="col-md-6">
                                <form id="search-form">
                                    <div class="input-group">
                                        <input type="text" id="search-input" name="search" class="form-control" placeholder="Cari judul prestasi...">
                                        <div class="input-group-append">
                                            <button class="btn btn-outline-secondary" type="submit" id="search-button">
                                                <i class="fas fa-search"></i>
                                            </button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>

                        <div class="table-responsive">
                            <table class="table table-bordered table-striped" id="prestasi-table">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Sekolah</th>
                                        <th>Nama Prestasi</th>
                                        <th>Deskripsi</th>
                                        <th>Tanggal</th>
                                        <th>Tahun</th>
                                        <th>Tingkat</th>
                                        <th>Peringkat</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($prestasis as $key => $item)
                                        <tr>
                                            <td>{{ $prestasis->firstItem() + $key }}</td>
                                            <td>{{ $item->sekolah->nama_sekolah ?? 'N/A' }}</td>
                                            <td>{{ $item->judul }}</td>
                                            <td>{{ Str::limit($item->deskripsi, 50) }}</td>
                                            <td>{{ $item->tanggal->format('Y-m-d') }}</td>
                                            <td>{{ $item->tahun ?? '-' }}</td>
                                            <td>{{ $item->tingkat }}</td>
                                            <td>{{ $item->peringkat }}</td>
                                            <td>
                                                <div class="btn-group">
                                                    <a href="{{ route('admin.prestasi.show', $item->id_prestasi) }}" class="btn btn-info btn-sm">
                                                        <i class="fas fa-eye"></i>
                                                    </a>
                                                    <a href="{{ route('admin.prestasi.edit', $item->id_prestasi) }}" class="btn btn-warning btn-sm">
                                                        <i class="fas fa-edit"></i>
                                                    </a>
                                                    <a href="{{ route('admin.prestasi.edit', $item->id_prestasi) }}" class="btn btn-warning btn-sm">
                                                        <i class="fas fa-edit"></i>
                                                    </a>
                                                    <button type="button" class="btn btn-danger btn-sm" onclick="confirmDelete({{ $item->id_prestasi }})">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </div>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="9" class="text-center">Tidak ada data prestasi</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>

                        <div class="mt-3">
                            {{ $prestasis->links() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection

@push('scripts')
<script>
function confirmDelete(id) {
    if (confirm('Apakah Anda yakin ingin menghapus data prestasi ini?')) {
        $.ajax({
            url: '{{ route("api.v1.prestasi.destroy", "") }}/' + id,
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
                alert('Gagal menghapus data prestasi.');
            }
        });
    }
}

$('#search-form').on('submit', function(e) {
    e.preventDefault();
    let searchValue = $('#search-input').val();
    fetchPrestasi(searchValue);
});

function fetchPrestasi(search = '') {
    $.ajax({
        url: '{{ route("api.v1.prestasi.index") }}',
        type: 'GET',
        data: {
            search: search
        },
        success: function(result) {
            let tableBody = $('#prestasi-table tbody');
            tableBody.empty();
            if (result.data.length > 0) {
                $.each(result.data, function(index, item) {
                    let row = `
                        <tr>
                            <td>${index + 1}</td>
                            <td>${item.sekolah.nama_sekolah}</td>
                            <td>${item.judul}</td>
                            <td>${item.deskripsi ? item.deskripsi.substring(0, 50) : ''}</td>
                            <td>${new Date(item.tanggal).toISOString().split('T')[0]}</td>
                            <td>${item.tahun}</td>
                            <td>${item.tingkat}</td>
                            <td>${item.peringkat}</td>
                            <td>
                                <div class="btn-group">
                                    <a href="/admin/prestasi/${item.id_prestasi}" class="btn btn-info btn-sm">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <a href="/admin/prestasi/${item.id_prestasi}/edit" class="btn btn-warning btn-sm">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <button type="button" class="btn btn-danger btn-sm" onclick="confirmDelete(${item.id_prestasi})">
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
                        <td colspan="9" class="text-center">Tidak ada data prestasi</td>
                    </tr>
                `;
                tableBody.append(row);
            }
        }
    });
}
</script>
@endpush