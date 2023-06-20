@extends('layouts/main-layout')
@section('css')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/jquery-datetime-picker@2.5.11/jquery.datetimepicker.min.css">
@endsection
@section('content')
    <div class="content-wrapper">
        <section class="content">
            <!-- Content Header (Page header) -->
            <section class="content-header">
                <div class="container-fluid">
                    <div class="row mb-2">
                        <div class="col-sm-6">
                            <h1>Peminjaman Buku</h1>
                        </div>
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item"><a href="#">Peminjaman buku</a></li>
                                <li class="breadcrumb-item active">
                                    {{ Request::segment(1) == '' ? 'Dashboard' : Request::segment(1) }} </li>
                            </ol>
                        </div>
                    </div>
                </div><!-- /.container-fluid -->
            </section>

            <!-- Default box -->
            <div>
                <div class="card">
                    <div class="card-header p-2">
                        <ul class="nav nav-pills">
                            <li class="nav-item"><a class="nav-link active" href="#settings" data-toggle="tab">Form
                                    peminjaman Buku</a></li>
                            <li class="nav-item"><a class="nav-link" href="#timeline" data-toggle="tab">List Peminjaman
                                    Buku</a></li>
                        </ul>
                    </div><!-- /.card-header -->
                    <div class="card-body">
                        <div class="tab-content">
                            <!-- /.tab-pane -->
                            <div class="tab-pane" id="timeline">

                                <table id="mytable" class="table table-bordered table-striped">
                                    <thead>
                                        <tr>
                                            <th>id</th>
                                            <th>tanggal peminjaman</th>
                                            <th>tanggal pengembalian</th>
                                            <th>buku</th>
                                            <th>status</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($data as $item)
                                            <tr>
                                                <td>{{ $item->id }}</td>
                                                <td>{{ $item->tanggal_peminjaman }}</td>
                                                <td>{{ $item->tanggal_pengembalian }}</td>
                                                {{-- <td>{{ $item->user->name }}</td> --}}
                                                <td>{{ $item->buku->judul_buku }}</td>
                                                <td>{{ $item->status }}
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                            <!-- /.tab-pane -->

                            <div class="tab-pane active" id="settings">
                                <form id="add_data_form" class="form-horizontal">
                                    <div class="form-group row">
                                        <label for="judul_buku" class="col-sm-2 col-form-label">Judul Buku</label>
                                        <div class="col-sm-10">
                                            <select class="custom-select rounded-2" name="buku_id" id="buku_id" required>
                                                <option name="" value="">--Pilih buku--</option>
                                                @foreach ($list_books as $buku)
                                                    <option value="{{ $buku->id }}">{{ $buku->judul_buku }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="tanggal_peminjaman" class="col-sm-2 col-form-label">Tanggal
                                            peminjaman</label>
                                        <div class="col-sm-10">
                                            <input type="date" name="tanggal_peminjaman" id="tanggal_peminjaman"
                                                class="form-control" placeholder="tanggal Peminjaman" required>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="tanggal_pengembalian" class="col-sm-2 col-form-label">Tanggal
                                            Pengembalian</label>
                                        <div class="col-sm-10">
                                            <input type="date" name="tanggal_pengembalian" id="tanggal_pengembalian"
                                                class="form-control" placeholder="tanggal Pengembalian" required>
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <div class="offset-sm-2 col-sm-10">
                                            <button type="submit" id="btn-submit" class="btn btn-success">Submit</button>
                                        </div>
                                    </div>

                                </form>
                            </div>
                            <!-- /.tab-pane -->
                        </div>
                        <!-- /.tab-content -->
                    </div><!-- /.card-body -->
                </div>
                <!-- /.card -->
            </div>
        </section>
    </div>
@endsection

@section('custom-js')
    <script src="https://cdn.jsdelivr.net/npm/jquery-datetime-picker@2.5.11/build/jquery.datetimepicker.full.min.js">
    </script>

    <script></script>
    <script type="text/javascript">
        $(document).ready(function() {
            var table = $('#mytable').DataTable();
        });

        $('#tanggal_peminjaman').datetimepicker({
            format: 'Y-m-d',
            timepicker: false,
            minDate: '0'
        });

        $('#tanggal_pengembalian').datetimepicker({
            format: 'Y-m-d',
            timepicker: false,
            minDate: '0'
        });


        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $("#btn-submit").click(function(e) {
            e.preventDefault();
            var buku_id = $("select[name=buku_id]").val();
            var tanggal_peminjaman = $("input[name=tanggal_peminjaman]").val();
            var tanggal_pengembalian = $("input[name=tanggal_pengembalian]").val();

            if (buku_id == '' || tanggal_peminjaman == '' || tanggal_pengembalian == '') {
                Swal.fire({
                    icon: 'error',
                    title: 'Gagal',
                    text: 'Data Tidak Boleh Kosong',
                })
            } else if (tanggal_pengembalian < tanggal_peminjaman) {
                Swal.fire({
                    icon: 'warning',
                    title: 'Warning',
                    text: 'Tanggal pengembalian tidak boleh kurang dari tanggal peminjaman',
                })
            } else {
                $.ajax({
                    type: 'POST',
                    url: "{{ route('peminjam.store') }}",
                    data: {
                        buku_id: buku_id,
                        tanggal_peminjaman: tanggal_peminjaman,
                        tanggal_pengembalian: tanggal_pengembalian,
                        status: 'Pending'
                    },
                    success: function(data) {
                        alert(data.success);
                        // $('#mytable').DataTable().ajax.reload();
                        location.reload();
                    },
                    error: function(data) {
                        aSwal.fire({
                            icon: 'error',
                            title: 'Data Invalid',
                            text: 'Data Invalid',
                        })
                    }
                });
            }
        });
    </script>
@endsection
