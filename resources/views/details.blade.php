<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Detail Produk</title>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>

    <link href="https://cdn.datatables.net/1.13.4/css/jquery.dataTables.min.css" rel="stylesheet">
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
    @extends('layouts.dash')

    @section('content')
        <div class="container mt-5">
            <h2 class="text-center mb-4">Detail Produk</h2>

            <a href="{{ route('cd') }}" class="btn btn-primary mb-2">
                <i class="bi bi-plus-circle"></i> Tambah Details
            </a>

            <table class="table table-bordered w-75 mx-auto" id="details-table">
                <thead class="text-center">
                    <tr>
                        <th>Produk</th>
                        <th>Deskripsi</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
            </table>
        </div>
    @endsection

    @section('scripts')
        <script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        <script>
            const table = $('#details-table').DataTable({
                processing: true,
                serverSide: true,
                ajax: '{{ route('details.data') }}',
                columns: [{
                        data: 'produk_nama',
                        name: 'produk_nama'
                    },
                    {
                        data: 'deskripsi',
                        name: 'deskripsi'
                    },
                    {
                        data: 'action',
                        name: 'action',
                        orderable: false,
                        searchable: false
                    }
                ]
            });

            $('#form-details').on('submit', function(e) {
                e.preventDefault();
                $.ajax({
                    url: '{{ route('sd') }}',
                    type: 'POST',
                    data: $(this).serialize(),
                    success: function(response) {
                        $('#form-details')[0].reset();
                        Swal.fire('Sukses', 'Data berhasil disimpan!', 'success');
                        table.ajax.reload();
                    },
                    error: function(xhr) {
                        let errMsg = 'Terjadi kesalahan.';
                        if (xhr.responseJSON && xhr.responseJSON.message) {
                            errMsg = xhr.responseJSON.message;
                        }
                        Swal.fire('Gagal', errMsg, 'error');
                    }
                });
            });

            $(document).on('click', '.btn-delete', function() {
                const url = $(this).data('url');
                Swal.fire({
                    title: 'Yakin ingin menghapus data ini?',
                    text: 'Data yang dihapus tidak dapat dikembalikan.',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Ya, hapus!',
                    cancelButtonText: 'Batal'
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            url: url,
                            type: 'DELETE',
                            data: {
                                _token: '{{ csrf_token() }}'
                            },
                            success: function(response) {
                                Swal.fire('Sukses', 'Data berhasil dihapus!', 'success');
                                table.ajax.reload();
                            },
                            error: function() {
                                Swal.fire('Gagal', 'Gagal menghapus data.', 'error');
                            }
                        });
                    }
                });
            });
        </script>
    @endsection

</body>

</html>
