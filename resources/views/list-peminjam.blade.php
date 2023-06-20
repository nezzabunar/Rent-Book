@extends('layouts.main-layout')

@section('content')
    <div class="content-wrapper">
        <section class="content">
            <section class="content-header">
                <div class="container-fluid">
                    <div class="row mb-2">
                        <div class="col-sm-6">
                            <h1>Data Peminjaman</h1>
                        </div>
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item"><a href="#">Data Peminjaman</a></li>
                                <li class="breadcrumb-item active">
                                    {{ Request::segment(1) == '' ? 'Dashboard' : Request::segment(1) }} </li>
                            </ol>
                        </div>
                    </div>
                </div>
            </section>

            <section class="content">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-12">

                            <div class="card">
                                <div class="card-header">
                                    <h3 class="card-title">DataTable Data Peminjam</h3>
                                </div>
                                <div class="card-body table-responsive">
                                    {{-- <button type="button" name="create_record" id="create_record"
                                        class="btn btn-success mb-2">
                                        <i class="fa fa-plus-square"></i> Add New Data</button> --}}
                                    <div>
                                        <table id="mytable" class="table">
                                            <thead>
                                                <tr>
                                                    <th>id</th>
                                                    <th>tanggal peminjaman</th>
                                                    <th>tanggal pengembalian</th>
                                                    <th>user</th>
                                                    <th>judul buku</th>
                                                    <th>status</th>
                                                    <th>action</th>
                                                </tr>
                                            </thead>
                                            <tbody>

                                            </tbody>
                                        </table>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>

                <div class="modal fade" id="formModal" tabindex="-1" aria-labelledby="ModalLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <form method="post" id="sample_form" class="form-horizontal">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="ModalLabel">Add New Record</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"></button>
                                </div>

                                <div class="modal-body p-4 bg-light">
                                    <span id="form_result"></span>
                                    <div class="form-group">
                                        <label for="buku_id">Judul Buku</label>
                                        <select class="custom-select rounded-2" name="buku_id" id="buku_id">
                                            <option name="" value="">--Pilih buku--</option>
                                            @foreach ($list_books as $buku)
                                                <option value="{{ $buku->id }}">{{ $buku->judul_buku }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label for="user_id">User</label>
                                        <select class="custom-select rounded-2" name="user_id" id="user_id">
                                            <option name="" value="">--Pilih User--</option>
                                            @foreach ($list_users as $user)
                                                <option value="{{ $user->id }}">{{ $user->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label for="tanggal_peminjaman">tanggal Peminjaman</label>
                                        <input type="date" name="tanggal_peminjaman" id="tanggal_peminjaman"
                                            class="form-control" placeholder="tanggal Peminjaman">
                                    </div>
                                    <div class="form-group">
                                        <label for="tanggal_pengembalian">tanggal Pengembalian</label>
                                        <input type="date" name="tanggal_pengembalian" id="tanggal_pengembalian"
                                            class="form-control" placeholder="tanggal Pengembalian">
                                    </div>
                                    <div class="form-group">
                                        <label for="status">status</label>
                                        <select class="custom-select rounded-2" name="status" id="status">
                                            <option name="" value="">--Pilih Status--</option>
                                            <option value="Pending">Pending</option>
                                            <option value="Approve">Approve</option>
                                            <option value="Reject">Reject</option>
                                        </select>
                                    </div>
                                    <input type="hidden" name="action" id="action" value="Add" />
                                    <input type="hidden" name="hidden_id" id="hidden_id" />
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                    <input type="submit" name="action_button" id="action_button" value="Add"
                                        class="btn btn-info" />
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </section>

        </section>
    </div>
@endsection

@section('custom-js')
    <script type="text/javascript">
        $(document).ready(function() {
            var table = $('#mytable').DataTable({
                processing: true,
                serverSide: true,
                ajax: "{{ route('data-peminjaman.index') }}",
                columns: [{
                        data: 'id',
                        name: 'id'
                    },
                    {
                        data: 'tanggal_peminjaman',
                        name: 'tanggal_peminjaman'
                    },
                    {
                        data: 'tanggal_pengembalian',
                        name: 'tanggal_pengembalian'
                    },
                    {
                        data: 'user.name',
                        name: 'user'
                    },
                    {
                        data: 'buku.judul_buku',
                        name: 'buku'
                    },
                    {
                        data: 'status',
                        name: 'status'
                    },
                    {
                        data: 'action',
                        name: 'action',
                        orderable: false,
                        searchable: false
                    },
                ]
            });

            $('#create_record').click(function() {
                $('.modal-title').text('Add New Record');
                $('#action_button').val('Add');
                $('#action').val('Add');
                $('#form_result').html('');
                $('#formModal').modal('show');
            });

            $(document).on('click', '.edit', function(event) {
                event.preventDefault();
                var id = $(this).attr('id');
                $('#form_result').html('');

                $.ajax({
                    url: "/peminjam/edit/" + id + "/",
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    dataType: "json",
                    success: function(data) {

                        $('#tanggal_peminjaman').val(data.result.tanggal_peminjaman);
                        $('#tanggal_pengembalian').val(data.result.tanggal_pengembalian);
                        $('#buku_id').val(data.result.buku_id);
                        $('#user_id').val(data.result.user_id);
                        $('#status').val(data.result.status);
                        $('#hidden_id').val(id);
                        $('.modal-title').text('Edit Record');
                        $('#action_button').val('Update');
                        $('#action').val('Edit');
                        $('#formModal').modal('show');
                    },
                    error: function(data) {
                        var errors = data.responseJSON;
                        console.log(errors);
                    }
                })
            });

            $(document).on('click', '.approve', function(event) {
                event.preventDefault();
                var id = $(this).attr('id');
                $('#form_result').html('');

                $.ajax({
                    url: "/peminjam/edit/" + id + "/",
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    dataType: "json",
                    success: function(data) {

                        $('#tanggal_peminjaman').val(data.result.tanggal_peminjaman);
                        $('#tanggal_pengembalian').val(data.result.tanggal_pengembalian);
                        $('#buku_id').val(data.result.buku_id);
                        $('#user_id').val(data.result.user_id);
                        $('#status').val(data.result.status);
                        $('#hidden_id').val(id);
                        $('.modal-title').text('Aprove Record');
                        $('#action_button').val('Aprove');
                        // $('#action_button').val('Approve');
                        $('#action').val('Aprove');
                        $('#formModal').modal('show');
                    },
                    error: function(data) {
                        var errors = data.responseJSON;
                        console.log(errors);
                    }
                })
            });

            var user_id;

            $(document).on('click', '.delete', function() {
                user_id = $(this).attr('id');
                Swal.fire({
                    title: 'Are you sure?',
                    text: "You won't be able to revert this!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#28a745',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, delete it!'
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            url: "peminjam/destroy/" + user_id,
                            success: function(data) {
                                $('#mytable').DataTable().ajax.reload();
                                Swal.fire(
                                    "Deleted",
                                    "Data Deleted",
                                    "success"
                                )
                            }
                        })
                    }
                })
            });

            // $(document).on('click', '.approve', function() {
            //     user_id = $(this).attr('id');
            //     Swal.fire({
            //         title: 'Are you sure?',
            //         text: "Approve Peminjaman",
            //         icon: 'warning',
            //         showCancelButton: true,
            //         confirmButtonColor: '#28a745',
            //         cancelButtonColor: '#d33',
            //         confirmButtonText: 'Yes, Approve!'
            //     }).then((result) => {
            //         if (result.isConfirmed) {
            //             $.ajax({
            //                     type: 'post',
            //                     headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
            //                     url: '{{ route('peminjam.update') }}',
            //                     data: {
            //                         status: 'Peminjaman'
            //                     },
            //                     dataType: 'json',
            //                     success: function(data) {
            //                         console.log('success: ' + data[0]);
            //                         $('#mytable').DataTable().ajax.reload();
            //                         Swal.fire(
            //                             "Approved",
            //                             "Data Approved",
            //                             "success"
            //                         )
            //                     }
            //                 })
            //                 // .done(function() {
            //                 //     location.reload()
            //                 // })
            //         }
            //     })
            // });

            $('#sample_form').on('submit', function(event) {
                event.preventDefault();
                var action_url = '';

                if ($('#action').val() == 'Add') {
                    action_url = "{{ route('peminjam.store') }}";
                }

                if ($('#action').val() == 'Edit') {
                    action_url = "{{ route('peminjam.update') }}";
                }

                if ($('#action').val() == 'Aprove') {
                    action_url = "{{ route('peminjam.update') }}";
                }

                $.ajax({
                    type: 'post',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    url: action_url,
                    data: $(this).serialize(),
                    dataType: 'json',
                    success: function(data) {

                        var html = '';
                        if (data.errors) {
                            html = '<div class="alert alert-danger">';
                            for (var count = 0; count < data.errors.length; count++) {
                                html += '<p>' + data.errors[count] + '</p>';
                            }
                            html += '</div>';
                        }
                        if (data.success) {
                            html = '<div class="alert alert-success">' + data.success +
                                '</div>';
                            $('#sample_form')[0].reset();
                            $('#formModal').modal('hide');
                            Swal.fire(
                                "Success",
                                "Data Updated",
                                "success"
                            )
                            $('#mytable').DataTable().ajax.reload();
                        }
                        $('#form_result').html(html);
                    },
                    error: function(data) {
                        var errors = data.responseJSON;
                        console.log(errors);
                    }
                });
            });
        });
    </script>
@endsection
