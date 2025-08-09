@extends('layouts.admin')

@section('content')
<div class="container-fluid">
    <h1 class="mb-4">Data Siswa</h1>

    <div class="card">
        <div class="card-body">
            <table class="table table-bordered table-hover">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama</th>
                        <th>Kelas</th>
                        <th>Alamat</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>1</td>
                        <td>Budi</td>
                        <td>10 IPA 1</td>
                        <td>Jakarta</td>
                    </tr>
                    <tr>
                        <td>2</td>
                        <td>Siti</td>
                        <td>10 IPA 2</td>
                        <td>Bandung</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
