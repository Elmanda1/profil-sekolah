<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="{{ url('/admin/dashboard') }}" class="brand-link">
        <span class="brand-text font-weight-light">AdminLTE</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" role="menu">
                <li class="nav-item">
                    <a href="{{ url('/admin/dashboard') }}" class="nav-link">
                        <i class="nav-icon fas fa-tachometer-alt"></i>
                        <p>Dashboard</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('admin.data-siswa') }}" class="nav-link">
                        <i class="nav-icon fas fa-user-graduate"></i>
                        <p>Data Siswa</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('admin.data-guru') }}" class="nav-link">
                        <i class="nav-icon fas fa-chalkboard-teacher"></i>
                        <p>Data Guru</p>
                    </a>
                </li>
            </ul>
        </nav>
    </div>
</aside>
