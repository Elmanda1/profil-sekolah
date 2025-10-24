@extends('layouts.admin')

@section('title', 'Data Berita')

@section('content')
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">Data Berita</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                    <li class="breadcrumb-item active">Data Berita</li>
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
                        <h3 class="card-title">Daftar Berita</h3>
                        <div class="card-tools">
                            <a href="{{ route('admin.berita.create') }}" class="btn btn-primary btn-sm">
                                <i class="fas fa-plus"></i> Tambah Berita
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
                                        <input type="text" id="search-input" name="search" class="form-control" placeholder="Cari judul berita...">
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
                            <table class="table table-bordered table-striped" id="artikel-table">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Judul</th>
                                        <th>Tanggal Berita</th>
                                        <th>Penulis</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($berita as $key => $item)
                                        <tr>
                                            <td>{{ $berita->firstItem() + $key }}</td>
                                            <td>{{ $item->judul }}</td>
                                            <td>{{ $item->tanggal_format }}</td>
                                            <td>{{ $item->penulis ?? '-' }}</td>
                                            <td>
                                                <div class="btn-group">
                                                    <a href="{{ route('admin.berita.show', $item->id_berita) }}" class="btn btn-info btn-sm">
                                                        <i class="fas fa-eye"></i>
                                                    </a>
                                                    <a href="{{ route('admin.berita.edit', $item->id_berita) }}" class="btn btn-warning btn-sm">
                                                        <i class="fas fa-edit"></i>
                                                    </a>
                                                    <a href="{{ route('admin.berita.edit', $item->id_berita) }}" class="btn btn-warning btn-sm">
                                                        <i class="fas fa-edit"></i>
                                                    </a>
                                                    <button type="button" class="btn btn-danger btn-sm" onclick="confirmDelete({{ $item->id_berita }})">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </div>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="5" class="text-center">Tidak ada data berita</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>

                        <div class="mt-3">
                            {{ $berita->links() }}
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
    if (confirm('Apakah Anda yakin ingin menghapus data berita ini?')) {
        $.ajax({
            url: '{{ route("api.v1.artikel.destroy", "") }}/' + id,
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
                alert('Gagal menghapus data berita.');
            }
        });
    }
}

$('#search-form').on('submit', function(e) {
    e.preventDefault();
    let searchValue = $('#search-input').val();
    fetchArtikels(searchValue);
});

function fetchArtikels(search = '') {
    $.ajax({
        url: '{{ route("api.v1.artikel.index") }}',
        type: 'GET',
        data: {
            search: search
        },
        success: function(result) {
            let tableBody = $('#artikel-table tbody');
            tableBody.empty();
            if (result.data.length > 0) {
                $.each(result.data, function(index, item) {
                    let row = `
                        <tr>
                            <td>${index + 1}</td>
                            <td>${item.judul}</td>
                            <td>${item.tanggal_format}</td>
                            <td>${item.penulis ? item.penulis : '-'}</td>
                            <td>
                                <div class="btn-group">
                                    <a href="/admin/berita/${item.id_berita}" class="btn btn-info btn-sm">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <a href="/admin/berita/${item.id_berita}/edit" class="btn btn-warning btn-sm">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <button type="button" class="btn btn-danger btn-sm" onclick="confirmDelete(${item.id_berita})">
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
                        <td colspan="5" class="text-center">Tidak ada data berita</td>
                    </tr>
                `;
                tableBody.append(row);
            }
        }
    });
}
</script>
@endpush