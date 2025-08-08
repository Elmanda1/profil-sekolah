{{-- resources/views/admin/dashboard.blade.php --}}
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Admin Dashboard</title>

    {{-- CSS --}}
    <link rel="stylesheet" href="{{ asset('vendor/adminlte/plugins/fontawesome-free/css/all.min.css') }}">
    <link rel="stylesheet" href="{{ asset('vendor/adminlte/dist/css/adminlte.min.css') }}">
</head>
<body class="hold-transition sidebar-mini">
<div class="wrapper">

    {{-- Navbar --}}
    @include('admin.partials.navbar')

    {{-- Sidebar --}}
    @include('admin.partials.sidebar')

    {{-- Content Wrapper --}}
    <div class="content-wrapper p-3">
        <h1>Selamat Datang di Dashboard Admin</h1>
    </div>

</div>

{{-- Contoh gambar --}}
<img src="{{ asset('vendor/adminlte/dist/img/AdminLTELogo.png') }}" alt="Logo">
<img src="{{ asset('vendor/adminlte/dist/img/user2-160x160.jpg') }}" class="img-circle" alt="User Image">

{{-- JS --}}
<script src="{{ asset('vendor/adminlte/plugins/jquery/jquery.min.js') }}"></script>
<script src="{{ asset('vendor/adminlte/plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
<script src="{{ asset('vendor/adminlte/dist/js/adminlte.min.js') }}"></script>

</body>
</html>
