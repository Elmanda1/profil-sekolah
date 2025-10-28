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
            <a href="{{ route('admin.guru.create') }}" class="btn btn-primary btn-sm">
              <i class="fas fa-plus"></i> Tambah Guru
            </a>
          </div>
        </div>
        
        <div class="card-body">
          <!-- Search Form & Controls -->
            <div class="row mb-3">
                <div class="col-md-6">
                    <div class="input-group">
                        <input type="text" id="search-input" class="form-control" placeholder="Cari nama, NIP, atau email..." autocomplete="off">
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
                <div class="col-md-3">
                    <select id="per-page-select" class="form-control">
                        <option value="10" selected>10 per halaman</option>
                        <option value="25">25 per halaman</option>
                        <option value="50">50 per halaman</option>
                        <option value="100">100 per halaman</option>
                    </select>
                </div>
                <div class="col-md-3 text-right">
                    <span class="badge badge-info" id="loading-indicator" style="display:none;">
                        <i class="fas fa-spinner fa-spin"></i> Loading...
                    </span>
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
            <table class="table table-bordered table-striped table-hover" id="guru-table">
              <thead>
                <tr>
                  <th width="5%">No</th>
                  <th>NIP</th>
                  <th>Nama Guru</th>
                  <th>Email</th>
                  <th>No. Telp</th>
                  <th>Sekolah</th>
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

@section('js')
<script>
console.log('Script initialized! jQuery:', typeof jQuery);

// Global variables
let currentPage = 1;
let currentSearch = '';
let currentLimit = 10; // Default 10 items per page
let isLoading = false;
let searchTimer = null;

// Initialize on page load
$(document).ready(function() {
    console.log('DOM Ready! Starting fetchGurus...');
    
    // Initial load
    fetchGurus();
    
    // Live search (real-time, 300ms debounce)
    $('#search-input').on('input', function() {
        const searchValue = $(this).val().trim();
        
        // Show/hide clear button
        if (searchValue) {
            $('#clear-search-button').show();
        } else {
            $('#clear-search-button').hide();
        }
        
        // Clear previous timer
        clearTimeout(searchTimer);
        
        // Set new timer for live search
        searchTimer = setTimeout(() => {
            currentSearch = searchValue;
            currentPage = 1; // Reset to first page on new search
            fetchGurus();
        }, 300); // 300ms debounce for smooth typing
    });
    
    // Clear search button
    $('#clear-search-button').on('click', function() {
        $('#search-input').val('');
        $(this).hide();
        currentSearch = '';
        currentPage = 1;
        fetchGurus();
    });
    
    // Search button (optional backup)
    $('#search-button').on('click', function() {
        currentSearch = $('#search-input').val().trim();
        currentPage = 1;
        fetchGurus();
    });
    
    // Per page limit selector
    $('#per-page-select').on('change', function() {
        currentLimit = parseInt($(this).val());
        currentPage = 1; // Reset to first page
        console.log('Per page changed to:', currentLimit);
        fetchGurus();
    });
});

/**
 * Fetch gurus data via AJAX
 * ULTRA FAST - No page reload
 */
function fetchGurus(page = null) {
    if (isLoading) return;
    
    isLoading = true;
    
    // Show loading indicator with fade effect
    $('#loading-indicator').fadeIn(200);
    
    // Add loading overlay to table
    
    const requestPage = page || currentPage;
    
    console.log('Fetching gurus... page:', requestPage, 'search:', currentSearch, 'limit:', currentLimit);
    
    $.ajax({
        url: '{{ route("admin.guru.index") }}',
        type: 'GET',
        data: {
            search: currentSearch,
            page: requestPage,
            limit: currentLimit
        },
        headers: {
            'Accept': 'application/json',
            'X-Requested-With': 'XMLHttpRequest'
        },
        success: function(response) {
            console.log('Data received:', response);
            
            // Smooth transition
            $('#guru-table tbody').fadeOut(100, function() {
                renderTable(response);
                $(this).fadeIn(200);
            });
            
            renderPagination(response);
            updateSummary(response);
            currentPage = requestPage;
        },
        error: function(xhr, status, error) {
            console.error('Error fetching gurus:', xhr.status, xhr.responseText);
            showError('Gagal memuat data guru. Silakan refresh halaman.');
            $('#guru-table tbody').css('opacity', '1');
        },
        complete: function() {
            isLoading = false;
            $('#loading-indicator').fadeOut(200);
            $('#guru-table tbody').css('opacity', '1');
        }
    });
}

/**
 * Render table rows
 * OPTIMIZED: Batch DOM manipulation
 */
function renderTable(response) {
    const tbody = $('#guru-table tbody');
    tbody.empty();
    
    if (response.data && response.data.length > 0) {
        let rows = '';
        
        response.data.forEach((item, index) => {
            const rowNumber = response.meta.from + index;
            const sekolah = item.sekolah ? item.sekolah.nama_sekolah : '-';
            
            rows += `
                <tr>
                    <td>${rowNumber}</td>
                    <td>${escapeHtml(item.nip)}</td>
                    <td>${escapeHtml(item.nama_guru)}</td>
                    <td>${escapeHtml(item.email)}</td>
                    <td>${escapeHtml(item.no_telp)}</td>
                    <td>${escapeHtml(sekolah)}</td>
                    <td>
                        <div class="btn-group">
                            <a href="/admin/guru/${item.id_guru}" class="btn btn-info btn-sm" title="Detail">
                                <i class="fas fa-eye"></i>
                            </a>
                            <a href="/admin/guru/${item.id_guru}/edit" class="btn btn-warning btn-sm" title="Edit">
                                <i class="fas fa-edit"></i>
                            </a>
                            <button type="button" class="btn btn-danger btn-sm" title="Hapus" onclick="confirmDelete(${item.id_guru})">
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
            ? `Tidak ada data guru yang cocok dengan pencarian "${escapeHtml(currentSearch)}"` 
            : 'Belum ada data guru';
        
        tbody.html(`
            <tr>
                <td colspan="7" class="text-center text-muted py-4">${emptyMessage}</td>
            </tr>
        `);
    }
}

/**
 * Render pagination
 * SMOOTH: No reload, instant page change
 */
function renderPagination(response) {
    const container = $('#pagination-container');
    container.empty();
    
    if (response.meta.last_page > 1) {
        let paginationHtml = '<ul class="pagination pagination-sm m-0">';
        
        // Previous button
        const prevDisabled = response.meta.current_page === 1 ? 'disabled' : '';
        paginationHtml += `
            <li class="page-item ${prevDisabled}">
                <a class="page-link" href="#" onclick="event.preventDefault(); ${response.meta.current_page > 1 ? `fetchGurus(${response.meta.current_page - 1})` : 'return false'};">
                    &laquo;
                </a>
            </li>
        `;
        
        // Page numbers (smart pagination)
        const currentPage = response.meta.current_page;
        const lastPage = response.meta.last_page;
        
        // Show first page
        if (currentPage > 3) {
            paginationHtml += `
                <li class="page-item">
                    <a class="page-link" href="#" onclick="event.preventDefault(); fetchGurus(1);">1</a>
                </li>
            `;
            if (currentPage > 4) {
                paginationHtml += `<li class="page-item disabled"><span class="page-link">...</span></li>`;
            }
        }
        
        // Show pages around current page
        for (let i = Math.max(1, currentPage - 2); i <= Math.min(lastPage, currentPage + 2); i++) {
            const activeClass = i === currentPage ? 'active' : '';
            paginationHtml += `
                <li class="page-item ${activeClass}">
                    <a class="page-link" href="#" onclick="event.preventDefault(); fetchGurus(${i});">${i}</a>
                </li>
            `;
        }
        
        // Show last page
        if (currentPage < lastPage - 2) {
            if (currentPage < lastPage - 3) {
                paginationHtml += `<li class="page-item disabled"><span class="page-link">...</span></li>`;
            }
            paginationHtml += `
                <li class="page-item">
                    <a class="page-link" href="#" onclick="event.preventDefault(); fetchGurus(${lastPage});">${lastPage}</a>
                </li>
            `;
        }
        
        // Next button
        const nextDisabled = response.meta.current_page === lastPage ? 'disabled' : '';
        paginationHtml += `
            <li class="page-item ${nextDisabled}">
                <a class="page-link" href="#" onclick="event.preventDefault(); ${response.meta.current_page < lastPage ? `fetchGurus(${response.meta.current_page + 1})` : 'return false'};">
                    &raquo;
                </a>
            </li>
        `;
        
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
        summary.html(`
            Menampilkan <strong>${response.meta.from}</strong> - <strong>${response.meta.to}</strong> dari <strong>${response.meta.total}</strong> data guru
        `);
    } else {
        summary.text('Menampilkan 0 - 0 dari 0 data guru');
    }
}

/**
 * Confirm delete with AJAX
 * OPTIMIZED: No page reload
 */
function confirmDelete(id) {
    if (confirm('Apakah Anda yakin ingin menghapus data guru ini?')) {
        // Show loading
        $('#loading-indicator').fadeIn(200);
        
        $.ajax({
            url: '/admin/guru/' + id,
            type: 'DELETE',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                'Accept': 'application/json'
            },
            success: function(result) {
                // Refresh current page
                fetchGurus();
                
                // Show success notification
                showNotification('success', 'Guru berhasil dihapus!');
            },
            error: function(xhr) {
                console.error('Error deleting guru:', xhr);
                showNotification('error', 'Gagal menghapus data guru.');
                $('#loading-indicator').fadeOut(200);
            }
        });
    }
}

/**
 * Show notification (better than alert)
 */
function showNotification(type, message) {
    // Create notification element
    const notification = $(`
        <div class="alert alert-${type === 'success' ? 'success' : 'danger'} alert-dismissible fade show notification-toast" role="alert" style="position: fixed; top: 20px; right: 20px; z-index: 9999; min-width: 300px;">
            <strong>${type === 'success' ? '✓' : '✗'}</strong> ${message}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    `);
    
    // Append to body
    $('body').append(notification);
    
    // Auto remove after 3 seconds
    setTimeout(function() {
        notification.fadeOut(300, function() {
            $(this).remove();
        });
    }, 3000);
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
    showNotification('success', message);
}

function showError(message) {
    showNotification('error', message);
}
</script>
@endsection

@push('css')
<style>
/* Loading animation */
#loading-indicator {
    font-size: 14px;
    padding: 8px 15px;
    box-shadow: 0 2px 4px rgba(0,0,0,0.1);
}

/* Hover effect for table rows */
#guru-table tbody tr {
    transition: all 0.2s ease;
}

#guru-table tbody tr:hover {
    background-color: #f8f9fa !important;
    transform: scale(1.01);
    box-shadow: 0 2px 4px rgba(0,0,0,0.05);
}

/* Smooth table transition */
#guru-table tbody {
    transition: opacity 0.3s ease;
}

/* Pagination styling */
.pagination {
    margin-bottom: 0;
}

.page-link {
    cursor: pointer;
    transition: all 0.2s;
}

.page-link:hover {
    transform: translateY(-2px);
    box-shadow: 0 2px 4px rgba(0,0,0,0.1);
}

.page-item.active .page-link {
    background-color: #007bff;
    border-color: #007bff;
    box-shadow: 0 2px 4px rgba(0,123,255,0.3);
}

/* Per page selector */
#per-page-select {
    cursor: pointer;
    transition: all 0.2s;
}

#per-page-select:focus {
    border-color: #007bff;
    box-shadow: 0 0 0 0.2rem rgba(0,123,255,0.25);
}

/* Search input enhancement */
#search-input {
    transition: all 0.2s;
}

#search-input:focus {
    border-color: #007bff;
    box-shadow: 0 0 0 0.2rem rgba(0,123,255,0.25);
}

/* Notification toast animation */
.notification-toast {
    animation: slideInRight 0.3s ease;
}

@keyframes slideInRight {
    from {
        transform: translateX(100%);
        opacity: 0;
    }
    to {
        transform: translateX(0);
        opacity: 1;
    }
}

/* Button group hover effect */
.btn-group .btn {
    transition: all 0.2s;
}

.btn-group .btn:hover {
    transform: translateY(-2px);
    box-shadow: 0 2px 4px rgba(0,0,0,0.2);
}
</style>
@endpush
