<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="{{ url('/admin') }}" class="brand-link">
        <span class="brand-text font-weight-light">AdminLTE</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                
                <!-- Dashboard -->
                <li class="nav-item">
                    <a href="{{ route('admin.dashboard') }}" class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-tachometer-alt"></i>
                        <p>Dashboard</p>
                    </a>
                </li>

                <!-- Data Master -->
                <li class="nav-header">DATA MASTER</li>
                
                <!-- Data Siswa -->
                <li class="nav-item">
                    <a href="{{ route('admin.siswa.index') }}" class="nav-link {{ request()->routeIs('admin.siswa.*') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-user-graduate"></i>
                        <p>Data Siswa</p>
                    </a>
                </li>

                <!-- Data Guru -->
                <li class="nav-item">
                    <a href="{{ route('admin.guru.index') }}" class="nav-link {{ request()->routeIs('admin.guru.*') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-chalkboard-teacher"></i>
                        <p>Data Guru</p>
                    </a>
                </li>

                <!-- Content Management -->
                <li class="nav-header">KONTEN</li>
                
                <!-- Data Berita -->
                <li class="nav-item">
                    <a href="{{ route('admin.berita.index') }}" class="nav-link {{ request()->routeIs('admin.berita.*') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-newspaper"></i>
                        <p>
                            Data Berita
                            <span class="right badge badge-info">{{ \App\Models\Berita::count() }}</span>
                        </p>
                    </a>
                </li>

                <!-- Data Prestasi -->
                <li class="nav-item">
                    <a href="{{ route('admin.prestasi.index') }}" class="nav-link {{ request()->routeIs('admin.prestasi.*') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-trophy"></i>
                        <p>
                            Data Prestasi
                            <span class="right badge badge-warning">{{ \App\Models\Prestasi::count() }}</span>
                        </p>
                    </a>
                </li>

                <!-- Divider -->
                <li class="nav-header">LAINNYA</li>

                <!-- Settings (Optional) -->
                <li class="nav-item">
                    <a href="#" class="nav-link">
                        <i class="nav-icon fas fa-cogs"></i>
                        <p>Pengaturan</p>
                    </a>
                </li>

                <!-- Logout (Optional) -->
                <li class="nav-item">
                    <a href="{{ url('/') }}" class="nav-link" target="_blank">
                        <i class="nav-icon fas fa-external-link-alt"></i>
                        <p>Lihat Website</p>
                    </a>
                </li>

            </ul>
        </nav>
    </div>
</aside>