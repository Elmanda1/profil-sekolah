@extends('layouts.frontend')

@section('title', 'Beranda')

@section('content')
  <x-hero />
  <x-highlight-prestasi />
  <x-ekskul-section />
  <x-prestasi-section />
  <x-berita-section />
  <x-contact-section />
@endsection
