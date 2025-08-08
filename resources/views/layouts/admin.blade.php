<!DOCTYPE html>
<html lang="en">
<head>
    @include('components.admin.head', ['title' => 'Dashboard'])
</head>
<body class="hold-transition sidebar-mini layout-fixed">
<div class="wrapper">

    {{-- Navbar --}}
    @include('components.admin.navbar')

    {{-- Sidebar --}}
    @include('components.admin.sidebar')

    {{-- Content Wrapper --}}
    <div class="content-wrapper">
        @yield('content')
    </div>

</div>

@include('components.admin.scripts')
</body>
</html>
