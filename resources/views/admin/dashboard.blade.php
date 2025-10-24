@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content_header')
    <h1>Dashboard</h1>
@stop

@section('content')
@include('partials.alerts')
<div class="row">
    <!-- Info Boxes -->
    <div class="col-lg-3 col-6">
        <div class="small-box bg-info">
            <div class="inner">
                <h3>{{ $totalSiswa }}</h3>
                <p>Total Siswa</p>
            </div>
            <div class="icon">
                <i class="fas fa-users"></i>
            </div>
            <a href="{{ route('admin.siswa.index') }}" class="small-box-footer">
                Lihat Detail <i class="fas fa-arrow-circle-right"></i>
            </a>
        </div>
    </div>

    <div class="col-lg-3 col-6">
        <div class="small-box bg-success">
            <div class="inner">
                <h3>{{ $totalGuru }}</h3>
                <p>Total Guru</p>
            </div>
            <div class="icon">
                <i class="fas fa-chalkboard-teacher"></i>
            </div>
            <a href="{{ route('admin.guru.index') }}" class="small-box-footer">
                Lihat Detail <i class="fas fa-arrow-circle-right"></i>
            </a>
        </div>
    </div>

    <div class="col-lg-3 col-6">
        <div class="small-box bg-warning">
            <div class="inner">
                <h3>{{ $totalBerita }}</h3>
                <p>Total Berita</p>
            </div>
            <div class="icon">
                <i class="fas fa-newspaper"></i>
            </div>
            <a href="{{ route('admin.berita.index') }}" class="small-box-footer">
                Lihat Detail <i class="fas fa-arrow-circle-right"></i>
            </a>
        </div>
    </div>

    <div class="col-lg-3 col-6">
        <div class="small-box bg-danger">
            <div class="inner">
                <h3>{{ $totalPrestasi }}</h3>
                <p>Total Prestasi</p>
            </div>
            <div class="icon">
                <i class="fas fa-trophy"></i>
            </div>
            <a href="{{ route('admin.prestasi.index') }}" class="small-box-footer">
                Lihat Detail <i class="fas fa-arrow-circle-right"></i>
            </a>
        </div>
    </div>
</div>

<div class="row">
    <!-- Siswa Terbaru -->
    <div class="col-md-6">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Siswa Terbaru</h3>
                <div class="card-tools">
                    <a href="{{ route('admin.siswa.index') }}" class="btn btn-tool">
                        <i class="fas fa-eye"></i> Lihat Semua
                    </a>
                </div>
            </div>
            <div class="card-body p-0">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>NIS</th>
                            <th>Nama</th>
                            <th>Jenis Kelamin</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($siswaRecent as $siswa)
                        <tr>
                            <td>{{ $siswa->nis_siswa }}</td>
                            <td>{{ $siswa->nama_siswa }}</td>
                            <td>
                                @if($siswa->jenis_kelamin == 'Laki-laki')
                                    <span class="badge bg-primary">{{ $siswa->jenis_kelamin }}</span>
                                @else
                                    <span class="badge bg-pink">{{ $siswa->jenis_kelamin }}</span>
                                @endif
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="3" class="text-center">Tidak ada data siswa</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Berita Terbaru -->
    <div class="col-md-6">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Berita Terbaru</h3>
                <div class="card-tools">
                    <a href="{{ route('admin.berita.index') }}" class="btn btn-tool">
                        <i class="fas fa-eye"></i> Lihat Semua
                    </a>
                </div>
            </div>
            <div class="card-body p-0">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>Judul</th>
                            <th>Tanggal</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($beritaRecent as $berita)
                        <tr>
                            <td>{{ Str::limit($berita->judul_berita, 40) }}</td>
                            <td>{{ date('d/m/Y', strtotime($berita->tanggal_berita)) }}</td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="2" class="text-center">Tidak ada data berita</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <!-- Prestasi Terbaru -->
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Prestasi Terbaru</h3>
                <div class="card-tools">
                    <a href="{{ route('admin.prestasi.index') }}" class="btn btn-tool">
                        <i class="fas fa-eye"></i> Lihat Semua
                    </a>
                </div>
            </div>
            <div class="card-body p-0">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>Nama Prestasi</th>
                            <th>Tingkat</th>
                            <th>Peringkat</th>
                            <th>Tahun</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($prestasiRecent as $prestasi)
                        <tr>
                            <td>{{ $prestasi->nama_prestasi }}</td>
                            <td>
                                <span class="badge bg-info">{{ $prestasi->tingkat }}</span>
                            </td>
                            <td>
                                @if($prestasi->peringkat == 1)
                                    <span class="badge bg-warning">🥇 {{ $prestasi->peringkat }}</span>
                                @elseif($prestasi->peringkat == 2)
                                    <span class="badge bg-secondary">🥈 {{ $prestasi->peringkat }}</span>
                                @elseif($prestasi->peringkat == 3)
                                    <span class="badge bg-success">🥉 {{ $prestasi->peringkat }}</span>
                                @else
                                    <span class="badge bg-primary">{{ $prestasi->peringkat }}</span>
                                @endif
                            </td>
                            <td>{{ $prestasi->tahun }}</td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="4" class="text-center">Tidak ada data prestasi</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@stop

@section('css')
<style>
    .small-box .icon {
        font-size: 70px;
    }
    .bg-pink {
        background-color: #e91e63 !important;
    }
</style>
@stop