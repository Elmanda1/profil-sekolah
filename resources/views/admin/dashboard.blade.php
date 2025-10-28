@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content_header')
    <h1 class="m-0 text-dark">Dashboard</h1>
@stop

@section('content')
    @include('partials.alerts')
    <div class="row">
        <div class="col-lg-3 col-6">
            <x-adminlte-small-box title="{{ $totalSiswa }}" text="Total Siswa" icon="fas fa-users text-teal"
                theme="info" url="{{ route('admin.siswa.index') }}" url-text="Lihat Detail"/>
        </div>
        <div class="col-lg-3 col-6">
            <x-adminlte-small-box title="{{ $totalGuru }}" text="Total Guru" icon="fas fa-chalkboard-teacher text-purple"
                theme="success" url="{{ route('admin.guru.index') }}" url-text="Lihat Detail"/>
        </div>
        <div class="col-lg-3 col-6">
            <x-adminlte-small-box title="{{ $totalBerita }}" text="Total Berita" icon="far fa-newspaper text-orange"
                theme="warning" url="{{ route('admin.berita.index') }}" url-text="Lihat Detail"/>
        </div>
        <div class="col-lg-3 col-6">
            <x-adminlte-small-box title="{{ $totalPrestasi }}" text="Total Prestasi" icon="fas fa-trophy text-red"
                theme="danger" url="{{ route('admin.prestasi.index') }}" url-text="Lihat Detail"/>
        </div>
    </div>

    <div class="row">
        <div class="col-md-6">
            <x-adminlte-card title="Siswa Terbaru" theme="lightblue" theme-mode="outline" collapsible
                header-class="d-flex justify-content-between">
                <x-slot name="tools">
                    <a href="{{ route('admin.siswa.index') }}" class="btn btn-sm btn-tool">
                        <i class="fas fa-eye"></i> Lihat Semua
                    </a>
                </x-slot>
                <table class="table table-sm table-striped">
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
                                <td>{{ $siswa->nisn }}</td>
                                <td>{{ $siswa->nama_siswa }}</td>
                                <td>
                                    @if($siswa->jenis_kelamin == 'Laki-laki')
                                        <span class="badge badge-primary">{{ $siswa->jenis_kelamin }}</span>
                                    @elseif($siswa->jenis_kelamin == 'Perempuan')
                                        <span class="badge" style="background-color: #e91e63; color: white;">{{ $siswa->jenis_kelamin }}</span>
                                    @else
                                        <span class="badge badge-secondary">N/A</span>
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
            </x-adminlte-card>
            
            <x-adminlte-card title="Prestasi Terbaru" theme="olive" theme-mode="outline" collapsible>
                <x-slot name="tools">
                    <a href="{{ route('admin.prestasi.index') }}" class="btn btn-sm btn-tool">
                        <i class="fas fa-eye"></i> Lihat Semua
                    </a>
                </x-slot>
                <table class="table table-sm table-striped">
                    <thead>
                        <tr>
                            <th>Judul Prestasi</th>
                            <th>Tanggal</th>
                            <th>Siswa</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($prestasiRecent as $prestasi)
                            <tr>
                                <td>{{ Str::limit($prestasi->judul, 40) }}</td>
                                <td>
                                    <span class="badge bg-info">
                                        {{ $prestasi->tanggal ? $prestasi->tanggal->format('d/m/Y') : '-' }}
                                    </span>
                                </td>
                                <td>
                                    @if($prestasi->siswa)
                                        <small>{{ Str::limit($prestasi->siswa->nama_siswa, 20) }}</small>
                                    @else
                                        <small class="text-muted">-</small>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="3" class="text-center">Tidak ada data prestasi</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </x-adminlte-card>
        </div>

        <div class="col-md-6">
            <x-adminlte-card title="Distribusi Siswa" theme="purple" theme-mode="outline" collapsible>
                <div style="height: 300px;">
                    <canvas id="siswaGenderChart"></canvas>
                </div>
            </x-adminlte-card>
            
            <x-adminlte-card title="Jumlah Prestasi per Tahun" theme="orange" theme-mode="outline" collapsible>
                <div style="height: 300px;">
                    <canvas id="prestasiPerYearChart"></canvas>
                </div>
            </x-adminlte-card>

            <x-adminlte-card title="Jumlah Guru per Sekolah" theme="teal" theme-mode="outline" collapsible>
                <div style="height: 300px;">
                    <canvas id="guruPerSekolahChart"></canvas>
                </div>
            </x-adminlte-card>
        </div>
    </div>
@stop

@section('js')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    function createPieChart(ctx, labels, data, title) {
        new Chart(ctx, {
            type: 'pie',
            data: {
                labels: labels,
                datasets: [{
                    data: data,
                    backgroundColor: ['#36a2eb', '#ff6384', '#ffce56', '#4bc0c0', '#9966ff'],
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        position: 'top',
                    },
                    title: {
                        display: true,
                        text: title
                    }
                }
            },
        });
    }

    function createBarChart(ctx, labels, data, title) {
        new Chart(ctx, {
            type: 'bar',
            data: {
                labels: labels,
                datasets: [{
                    label: 'Jumlah',
                    data: data,
                    backgroundColor: '#36a2eb',
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            stepSize: 1
                        }
                    }
                },
                plugins: {
                    legend: {
                        display: false
                    },
                    title: {
                        display: true,
                        text: title
                    }
                }
            }
        });
    }

    // Data from backend
    const siswaGenderData = @json($siswaGender ?? []);
    const prestasiPerYearData = @json($prestasiPerYear ?? []);
    const guruPerSekolahData = @json($guruPerSekolah ?? []);

    console.log('Guru per Sekolah Data:', guruPerSekolahData);

    // Create Siswa Gender Chart
    if (Object.keys(siswaGenderData).length > 0) {
        const siswaGenderCtx = document.getElementById('siswaGenderChart').getContext('2d');
        createPieChart(
            siswaGenderCtx,
            Object.keys(siswaGenderData),
            Object.values(siswaGenderData),
            'Distribusi Siswa Berdasarkan Jenis Kelamin'
        );
    }

    // Create Prestasi per Year Chart
    if (Object.keys(prestasiPerYearData).length > 0) {
        const prestasiPerYearCtx = document.getElementById('prestasiPerYearChart').getContext('2d');
        createBarChart(
            prestasiPerYearCtx,
            Object.keys(prestasiPerYearData),
            Object.values(prestasiPerYearData),
            'Jumlah Prestasi per Tahun'
        );
    }

    // Create Guru per Sekolah Chart
    if (Object.keys(guruPerSekolahData).length > 0) {
        const guruPerSekolahCtx = document.getElementById('guruPerSekolahChart').getContext('2d');
        createBarChart(
            guruPerSekolahCtx,
            Object.keys(guruPerSekolahData),
            Object.values(guruPerSekolahData),
            'Jumlah Guru per Sekolah'
        );
    }
</script>
@stop