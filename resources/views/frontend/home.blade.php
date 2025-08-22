@extends('layouts.frontend')

@section('title', 'Beranda')

@section('content')
<div class='overflow-x-hidden'>
  <x-hero />
  <x-highlight-prestasi :prestasis="$highlightPrestasis" />
  <x-ekskul-section />
  <x-prestasi-section />
  <x-berita-section />
  <x-contact-section />
</div>
@endsection
