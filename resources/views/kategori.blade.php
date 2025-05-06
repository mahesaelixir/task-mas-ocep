<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Daftar Kategori</title>
    <script src="https://code.jquery.com/jquery-3.5.1.js"></script>
    <link href="https://cdn.datatables.net/1.13.4/css/jquery.dataTables.min.css" rel="stylesheet">
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
    @extends('layouts.dash')
    
    @section('content')
    <div class="container mt-5">
        <h2 class="text-center mb-4">Daftar Kategori</h2>
        
        <a href="{{ route('ck') }}" class="btn btn-primary mb-2">
            <i class="bi bi-plus-circle"></i> Tambah Kategori
        </a>
        
        <div class="table-responsive">
            <table class="table table-bordered w-75 mx-auto" id="kategori-table">
                <thead class="text-center">
                    <tr>
                        <th>Nama Kategori</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
            </table>
        </div>
    </div>
    @endsection
    
    @push('scripts')
    <script src="https://code.jquery.com/jquery-3.5.1.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
    
    <script>
        $(document).ready(function() {
            // Inisialisasi DataTable
            $('#kategori-table').DataTable({
                processing: true,
                    serverSide: true,
                    ajax: '{{ route('kd') }}',
                    columns: [{
                            data: 'nama_kategori',
                            name: 'nama_kategori'
                        },
                        {
                            data: 'action',
                            name: 'action',
                            orderable: false,
                            searchable: false
                        }
                    ]
                });

                // Menambahkan kategori baru
                $('#formKategori').submit(function(e) {
                    e.preventDefault();
                    let url = $(this).attr('action');
                    let formData = $(this).serialize();

                    $.ajax({
                        url: url,
                        type: 'POST',
                        data: formData,
                        success: function(response) {
                            console.log(response)
                            // Menampilkan SweetAlert saat berhasil
                            if (response.status === true) {
                                Swal.fire({
                                    title: 'Sukses!',
                                    text: response.message,
                                    icon: 'success',
                                    confirmButtonText: 'OK'
                                }).then(function() {
                                    // Refresh data pada DataTable setelah sukses menambah kategori
                                    $('#kategori-table').DataTable().ajax.reload();
                                });
                            }
                        },
                        error: function(xhr) {
                            let errors = xhr.responseJSON.errors;
                            let errorMessage = errors ? Object.values(errors).join(', ') :
                                'Terjadi kesalahan!';
                            Swal.fire({
                                title: 'Gagal!',
                                text: errorMessage,
                                icon: 'error',
                                confirmButtonText: 'OK'
                            });
                        }
                    });
                });

                // Handle DELETE dengan SweetAlert2 dan AJAX
                $(document).on('click', '.btn-delete', function(e) {
                    e.preventDefault();
                    var url = $(this).data('url');

                    Swal.fire({
                        title: 'Apakah kamu yakin?',
                        text: "Data akan dihapus permanen!",
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#d33',
                        cancelButtonColor: '#3085d6',
                        confirmButtonText: 'Ya, hapus!'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            $.ajax({
                                url: url,
                                type: 'DELETE',
                                data: {
                                    _token: '{{ csrf_token() }}'
                                },
                                success: function(response) {
                                    Swal.fire('Berhasil!', response.success, 'success');
                                    $('#kategori-table').DataTable().ajax.reload();
                                },
                                error: function(xhr) {
                                    Swal.fire('Gagal!', xhr.responseJSON.error, 'error');
                                }
                            });
                        }
                    });
                });

                // Handle EDIT (ambil data dan tampilkan via alert sementara)
                $(document).on('click', '.btn-edit', function(e) {
                    e.preventDefault();
                    var url = $(this).data('url');

                    $.get(url, function(data) {
                        console.log(data); // debug di console
                        Swal.fire({
                            title: 'Edit Kategori',
                            text: 'Nama: ' + data.nama_kategori,
                            icon: 'info'
                        });
                    });
                });
            });
        </script>
    @endpush

</body>

</html>
