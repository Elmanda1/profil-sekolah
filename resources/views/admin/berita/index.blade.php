@extends('adminlte::page')

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
                                        <th>Sekolah</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody id="artikel-table-body">
                                    <!-- Data will be loaded here by AJAX -->
                                </tbody>
                            </table>
                        </div>

                        <div class="mt-3 d-flex justify-content-center" id="pagination-links">
                            <!-- Pagination links will be loaded here by AJAX -->
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection

@section('js')
<script>
console.log('Admin Berita script is running!');
$(document).ready(function() {
    let currentPage = 1;
    let currentSearch = '';

    function fetchArtikel(page = 1, search = '') {
        currentPage = page;
        currentSearch = search;
        const url = `/api/v1/berita?page=${page}&search=${search}`;

        // Show a loading state
        const tableBody = $('#artikel-table-body');
        tableBody.html('<tr><td colspan="5" class="text-center"><i class="fas fa-spinner fa-spin"></i> Memuat data...</td></tr>');

        $.ajax({
            url: url,
            type: 'GET',
            dataType: 'json',
            success: function(response) {
                updateTable(response);
                updatePagination(response);
            },
            error: function(err) {
                tableBody.html('<tr><td colspan="5" class="text-center">Gagal memuat data. Silakan coba lagi.</td></tr>');
            }
        });
    }

    function updateTable(response) {
        const tableBody = $('#artikel-table-body');
        tableBody.empty();

        if (response.data.length === 0) {
            tableBody.html('<tr><td colspan="5" class="text-center">Tidak ada data berita yang cocok dengan pencarian.</td></tr>');
            return;
        }

        const firstItem = response.from;
        $.each(response.data, function(index, item) {
            const formattedDate = item.tanggal ? new Date(item.tanggal).toLocaleDateString('id-ID', { year: 'numeric', month: 'long', day: 'numeric' }) : '-';
            const sekolahName = item.sekolah ? item.sekolah.nama_sekolah : 'N/A';
            
            // Construct action URLs
            const showUrl = `{{ route('admin.berita.index') }}/${item.id_artikel}`;
            const editUrl = `${showUrl}/edit`;

            const row = `
                <tr>
                    <td>${firstItem + index}</td>
                    <td>${item.judul}</td>
                    <td>${formattedDate}</td>
                    <td>${sekolahName}</td>
                    <td>
                        <div class="btn-group">
                            <a href="${showUrl}" class="btn btn-info btn-sm">
                                <i class="fas fa-eye"></i>
                            </a>
                            <a href="${editUrl}" class="btn btn-warning btn-sm">
                                <i class="fas fa-edit"></i>
                            </a>
                            <button type="button" class="btn btn-danger btn-sm" onclick="confirmDelete(${item.id_artikel})">
                                <i class="fas fa-trash"></i>
                            </button>
                        </div>
                    </td>
                </tr>
            `;
            tableBody.append(row);
        });
    }

    function updatePagination(response) {
        const paginationLinks = $('#pagination-links');
        paginationLinks.empty();

        if (response.last_page > 1) {
            let paginationHtml = '<ul class="pagination">';

            // Previous button
            paginationHtml += `
                <li class="page-item ${response.current_page === 1 ? 'disabled' : ''}">
                    <a class="page-link" href="#" data-page="${response.current_page - 1}">&laquo;</a>
                </li>
            `;

            // Page numbers
            for (let i = 1; i <= response.last_page; i++) {
                paginationHtml += `
                    <li class="page-item ${i === response.current_page ? 'active' : ''}">
                        <a class="page-link" href="#" data-page="${i}">${i}</a>
                    </li>
                `;
            }

            // Next button
            paginationHtml += `
                <li class="page-item ${response.current_page === response.last_page ? 'disabled' : ''}">
                    <a class="page-link" href="#" data-page="${response.current_page + 1}">&raquo;</a>
                </li>
            `;

            paginationHtml += '</ul>';
            paginationLinks.html(paginationHtml);
        }
    }

    // Initial fetch
    fetchArtikel();

    // Search form submission
    $('#search-form').on('submit', function(e) {
        e.preventDefault();
        const searchTerm = $('#search-input').val();
        fetchArtikel(1, searchTerm);
    });

    // Pagination click handler
    $(document).on('click', '#pagination-links a.page-link', function(e) {
        e.preventDefault();
        const page = $(this).data('page');
        if (page) {
            fetchArtikel(page, currentSearch);
        }
    });
});

function confirmDelete(id) {
    if (confirm('Apakah Anda yakin ingin menghapus data berita ini?')) {
        const deleteUrl = `{{ route('admin.berita.index') }}/${id}`;
        
        $.ajax({
            url: deleteUrl,
            type: 'POST',
            data: {
                _method: 'DELETE',
                _token: '{{ csrf_token() }}'
            },
            success: function(result) {
                alert('Data berhasil dihapus.');
                // Reload the current page in the table without full page refresh
                const currentPage = $('#pagination-links .page-item.active .page-link').data('page') || 1;
                const currentSearch = $('#search-input').val();
                fetchArtikel(currentPage, currentSearch);
            },
            error: function(err) {
                console.error(err);
                alert('Gagal menghapus data berita. Lihat konsol untuk detail.');
            }
        });
    }
}
</script>
@endsection