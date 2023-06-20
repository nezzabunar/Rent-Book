@extends('layouts.main-layout')

@section('content')
    <div class="content-wrapper">
        <!-- Main content -->
        <section class="content">
            <!-- Content Header (Page header) -->
            <section class="content-header">
                <div class="container-fluid">
                    <div class="row mb-2">
                        <div class="col-sm-6">
                            <h1>Data Buku</h1>
                        </div>
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item"><a href="#">List-Buku</a></li>
                                <li class="breadcrumb-item active">
                                    {{ Request::segment(1) == '' ? 'Dashboard' : Request::segment(1) }} </li>
                            </ol>
                        </div>
                    </div>
                </div><!-- /.container-fluid -->
            </section>

            <section class="content">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-12">

                            <div class="card">
                                <div class="card-header">
                                    <h3 class="card-title">DataTable List-Buku</h3>
                                </div>
                                <div class="card-body table-responsive">
                                    <table id="data_table" class="table">
                                        <thead>
                                            <tr>
                                                <th>id</th>
                                                <th>kode buku</th>
                                                <th>judul buku</th>
                                                <th>tahun terbit</th>
                                                <th>penulis</th>
                                                <th>stok buku</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($data as $item)
                                                    <tr>
                                                        <td>{{ $item->id }}</td>
                                                        <td>{{ $item->kode_buku }}</td>
                                                        <td>{{ $item->judul_buku }}</td>
                                                        <td>{{ $item->tahun_terbit }}</td>
                                                        <td>{{ $item->penulis }}</td>
                                                        <td>{{ $item->stok_buku }}</td>
                                                    </tr>
                                                @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </section>
            </div>
@endsection

@section('custom-js')
    <script type="text/javascript">
        $(document).ready(function() {
            var table = $('#data_table').DataTable();
        });
    </script>
@endsection
