@extends('layouts.admin')

@section('content')
<div class="container-fluid">
    <h1 class="mb-4">Data Guru</h1>

    <div class="card">
        <div class="card-body">
            <table class="table table-bordered table-hover">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama</th>
                        <th>Mata Pelajaran</th>
                        <th>Alamat</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>1</td>
                        <td>Pak Andi</td>
                        <td>Matematika</td>
                        <td>Surabaya</td>
                    </tr>
                    <tr>
                        <td>2</td>
                        <td>Bu Rina</td>
                        <td>Bahasa Indonesia</td>
                        <td>Yogyakarta</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
