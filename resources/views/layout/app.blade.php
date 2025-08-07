<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'Laravel')</title>
    @vite('resources/css/app.css')
  </head>
  <body class="bg-gray-200">
    <x-navbar />
    
    {{-- Section konten halaman --}}
    @yield('content')
  </body>
   <x-footer/>
</html>
