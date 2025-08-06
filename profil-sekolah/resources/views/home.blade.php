<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        @vite('resources/css/app.css')
        
        <title>Laravel</title>        
    </head>
    <body class="bg-[#fffffb]">
        <x-navbar/>
        <x-hero/>
        <x-highlight-prestasi/>
        <x-ekskul-section/>
        <x-prestasi-section/>   
        <x-berita-section/>
        <x-contact-section/>
    </body>
</html>
