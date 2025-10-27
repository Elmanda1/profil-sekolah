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
              <div class="input-group">
                <input type="text" id="search-input" class="form-control" placeholder="Cari nama atau NISN siswa...">
                <div class="input-group-append">
                  <button class="btn btn-outline-secondary" type="button" id="search-button">
                    <i class="fas fa-search"></i>
                  </button>
                  <button class="btn btn-outline-danger" type="button" id="clear-search-button" style="display:none;">
                    <i class="fas fa-times"></i>
                  </button>
                </div>
              </div>
            </div>
            <div class="col-md-6 text-right">
              <span class="badge badge-info" id="loading-indicator" style="display:none;">
                <i class="fas fa-spinner fa-spin"></i> Loading...
              </span>
            </div>
          </div>

          <!-- Table -->
          <div class="table-responsive">
            <table class="table table-bordered table-striped table-hover" id="siswa-table">
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
                <!-- Data will be loaded via AJAX -->
              </tbody>
            </table>
          </div>

          <!-- Pagination -->
          <div id="pagination-container" class="d-flex justify-content-center mt-3">
            <!-- Pagination will be loaded via AJAX -->
          </div>
        </div>
        
        <div class="card-footer">
          <small class="text-muted" id="data-summary">
            Memuat data...
          </small>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection

@push('scripts')
<script>
// Global variables
let currentPage = 1;
let currentSearch = '';
let isLoading = false;
let searchTimer = null;

// Initialize on page load
$(document).ready(function() {
    fetchStudents();
    
    // Search with debounce (500ms delay)
    $('#search-input').on('keyup', function() {
        const searchValue = $(this).val().trim();
        
        // Show/hide clear button
        if (searchValue) {
            $('#clear-search-button').show();
        } else {
            $('#clear-search-button').hide();
        }
        
        // Clear previous timer
        clearTimeout(searchTimer);
        
        // Set new timer
        searchTimer = setTimeout(() => {
            currentSearch = searchValue;
            currentPage = 1; // Reset to first page
            fetchStudents();
        }, 500); // 500ms debounce
    });
    
    // Clear search button
    $('#clear-search-button').on('click', function() {
        $('#search-input').val('');
        $(this).hide();
        currentSearch = '';
        currentPage = 1;
        fetchStudents();
    });
    
    // Search button (optional, since we have debounce)
    $('#search-button').on('click', function() {
        currentSearch = $('#search-input').val().trim();
        currentPage = 1;
        fetchStudents();
    });
});

/**
 * Fetch students data via AJAX
 * OPTIMIZED: Fast, cached, paginated
 */
function fetchStudents(page = null) {
    // Prevent multiple simultaneous requests
    if (isLoading) return;
    
    isLoading = true;
    $('#loading-indicator').show();
    
    // Use provided page or current page
    const requestPage = page || currentPage;
    
    $.ajax({
        url: '/api/v1/students',
        type: 'GET',
        data: {
            search: currentSearch,
            page: requestPage,
            limit: 100 // 100 items per page for fast loading
        },
        headers: {
            'Accept': 'application/json',
            'X-Requested-With': 'XMLHttpRequest'
        },
        success: function(response) {
            renderTable(response);
            renderPagination(response);
            updateSummary(response);
            currentPage = requestPage;
        },
        error: function(xhr, status, error) {
            console.error('Error fetching students:', error);
            showError('Gagal memuat data siswa. Silakan refresh halaman.');
        },
        complete: function() {
            isLoading = false;
            $('#loading-indicator').hide();
        }
    });
}

/**
 * Render table rows
 * OPTIMIZED: DOM manipulation in batch
 */
function renderTable(response) {
    const tbody = $('#siswa-table tbody');
    tbody.empty();
    
    if (response.data && response.data.length > 0) {
        let rows = '';
        
        response.data.forEach((item, index) => {
            const rowNumber = response.meta.from + index;
            const jenisKelamin = item.jenis_kelamin === 'Laki-laki' 
                ? '<span class="badge badge-info">Laki-laki</span>' 
                : (item.jenis_kelamin === 'Perempuan' 
                    ? '<span class="badge badge-pink">Perempuan</span>' 
                    : '-');
            
            const tanggalLahir = item.tanggal_lahir || '-';
            const alamat = item.alamat ? truncateText(item.alamat, 50) : '-';
            
            rows += `
                <tr>
                    <td>${rowNumber}</td>
                    <td>${escapeHtml(item.nisn)}</td>
                    <td>${escapeHtml(item.nama_siswa)}</td>
                    <td>${jenisKelamin}</td>
                    <td>${tanggalLahir}</td>
                    <td>${escapeHtml(alamat)}</td>
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
        });
        
        tbody.html(rows);
    } else {
        const emptyMessage = currentSearch 
            ? `Tidak ada data siswa yang cocok dengan pencarian "${escapeHtml(currentSearch)}"` 
            : 'Belum ada data siswa';
        
        tbody.html(`
            <tr>
                <td colspan="7" class="text-center text-muted">${emptyMessage}</td>
            </tr>
        `);
    }
}

/**
 * Render pagination
 * OPTIMIZED: Event delegation
 */
function renderPagination(response) {
    const container = $('#pagination-container');
    container.empty();
    
    if (response.meta.last_page > 1) {
        let paginationHtml = '<ul class="pagination pagination-sm m-0">';
        
        response.meta.links.forEach((link) => {
            let label = link.label;
            let pageNum = null;
            
            // Clean up labels
            if (label === '&laquo; Previous') label = '&laquo;';
            if (label === 'Next &raquo;') label = '&raquo;';
            
            // Extract page number from URL
            if (link.url) {
                const urlParams = new URLSearchParams(new URL(link.url).search);
                pageNum = urlParams.get('page');
            }
            
            const activeClass = link.active ? 'active' : '';
            const disabledClass = !link.url ? 'disabled' : '';
            
            paginationHtml += `
                <li class="page-item ${activeClass} ${disabledClass}">
                    <a class="page-link" href="#" data-page="${pageNum}" onclick="event.preventDefault(); if(${!!link.url}) fetchStudents(${pageNum});">
                        ${label}
                    </a>
                </li>
            `;
        });
        
        paginationHtml += '</ul>';
        container.html(paginationHtml);
    }
}

/**
 * Update data summary
 */
function updateSummary(response) {
    const summary = $('#data-summary');
    
    if (response.meta.total > 0) {
        summary.text(`Menampilkan ${response.meta.from} - ${response.meta.to} dari ${response.meta.total} data siswa`);
    } else {
        summary.text('Menampilkan 0 - 0 dari 0 data siswa');
    }
}

/**
 * Confirm delete with AJAX
 * OPTIMIZED: No page reload
 */
function confirmDelete(id) {
    if (confirm('Apakah Anda yakin ingin menghapus data siswa ini?')) {
        $.ajax({
            url: '/api/v1/students/' + id,
            type: 'DELETE',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                'Accept': 'application/json'
            },
            success: function(result) {
                if (result.success) {
                    // Refresh current page
                    fetchStudents();
                    showSuccess('Siswa berhasil dihapus.');
                } else {
                    showError('Gagal menghapus data siswa.');
                }
            },
            error: function(xhr) {
                console.error('Error deleting student:', xhr);
                showError('Gagal menghapus data siswa.');
            }
        });
    }
}

/**
 * Helper functions
 */
function truncateText(text, length) {
    if (text.length <= length) return text;
    return text.substring(0, length) + '...';
}

function escapeHtml(text) {
    const div = document.createElement('div');
    div.textContent = text;
    return div.innerHTML;
}

function showSuccess(message) {
    // You can use SweetAlert2, Toastr, or native alert
    alert(message);
}

function showError(message) {
    alert(message);
}
</script>
@endpush

@push('css')
<style>
/* Loading animation */
#loading-indicator {
    font-size: 14px;
    padding: 8px 15px;
}

/* Hover effect for table rows */
#siswa-table tbody tr {
    transition: background-color 0.2s;
}

#siswa-table tbody tr:hover {
    background-color: #f5f5f5 !important;
}

/* Pagination styling */
.pagination {
    margin-bottom: 0;
}

.page-link {
    cursor: pointer;
}

/* Badge styling for gender */
.badge-pink {
    background-color: #e83e8c;
    color: white;
}
</style>
@endpush