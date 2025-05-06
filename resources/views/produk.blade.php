<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Produk</title>

    <!-- Menambahkan DataTables CSS -->
    <link href="https://cdn.datatables.net/1.13.4/css/jquery.dataTables.min.css" rel="stylesheet">

    <!-- Menambahkan Bootstrap CSS untuk tampilan -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
    @extends('layouts.dash')

    <div class="container mt-5">
        @section('content')
            <h2 class="text-center mb-4">Data Produk</h2>

            <a href="{{ route('kategori') }}" class="btn btn-primary mb-2">
                <i class="bi bi-plus-circle"></i> Tambah Data
            </a>
            <div class="table-responsive">
                <div class="form-group w-50 mx-auto mb-3">
                    <input type="text" id="filter-nama" class="form-control" placeholder="Cari Nama Produk">
                </div>

                <table class="table table-bordered w-75 mx-auto" id="produk-table">
                    <thead class="text-center">
                        <tr>
                            <th>Nama Produk</th>
                            <th>Kategori</th>
                            <th>Harga</th>
                            <th>Stok</th>
                            <th>Gambar</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                </table>
                <div class="mt-3 text-center">
                    <!-- Ubah tombol import menjadi tautan -->
                    <a href="#" class="btn btn-success" data-toggle="modal" data-target="#importModal">Import
                        Excel</a>

                    <a href="{{ route('export') }}" class="btn btn-primary ml-2">Export Excel</a>
                </div>
            </div>
        </div>

        <!-- Modal Import -->
        <div class="modal fade" id="importModal" tabindex="-1" role="dialog" aria-labelledby="importModalLabel"
            aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="importModalLabel">Import Produk Excel</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form action="{{ route('import') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="form-group">
                                <label for="file">Pilih File Excel</label>
                                <input type="file" name="file" class="form-control" required>
                            </div>
                            <button type="submit" class="btn btn-success">Import</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    @endsection

    <!-- jQuery & DataTables -->
    <script src="https://code.jquery.com/jquery-3.5.1.js"></script>
    <script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>

    <!-- Bootstrap JS (untuk modal) -->
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.bundle.min.js"></script>

    <script>
        $(document).ready(function() {
            let table = $('#produk-table').DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url: '{{ route('index') }}',
                    data: function(d) {
                        d.nama_produk = $('#filter-nama').val(); // ambil inputan pencarian
                    }
                },
                columns: [{
                        data: 'nama_produk',
                        name: 'nama_produk'
                    },
                    {
                        data: 'kategori.nama_kategori',
                        name: 'kategori.nama_kategori'
                    },
                    {
                        data: 'harga',
                        name: 'harga'
                    },
                    {
                        data: 'stok',
                        name: 'stok'
                    },
                    {
                        data: 'gambar',
                        name: 'gambar'
                    },
                    {
                        data: 'action',
                        name: 'action',
                        orderable: false,
                        searchable: false
                    }
                ]
            });

            // Trigger filter saat user mengetik
            $('#filter-nama').keyup(function() {
                table.draw();
            });
        });
    </script>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        // Alert saat redirect setelah berhasil hapus
        @if (session('success'))
            Swal.fire({
                icon: 'success',
                title: 'Berhasil',
                text: '{{ session('success') }}',
                confirmButtonColor: '#3085d6'
            });
        @endif

        // Tangani tombol Edit
        $(document).on('click', '.btn-edit', function(e) {
            e.preventDefault();
            let link = $(this).attr('href');
            Swal.fire({
                title: 'Yakin ingin merubah data?',
                icon: 'question',
                showCancelButton: true,
                confirmButtonText: 'Ya',
                cancelButtonText: 'Batal',
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33'
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = link;
                }
            });
        });

        // Tangani tombol Delete
        $(document).on('submit', '.form-delete', function(e) {
            e.preventDefault();
            let form = this;
            Swal.fire({
                title: 'Yakin ingin menghapus data?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Ya, hapus!',
                cancelButtonText: 'Batal',
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33'
            }).then((result) => {
                if (result.isConfirmed) {
                    form.submit();
                }
            });
        });
    </script>
</body>

</html>
