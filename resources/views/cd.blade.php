<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Insert Details</title>

    <!-- Bootstrap CSS -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
    <div class="container mt-5">
        <div class="card shadow">
            <div class="card-header bg-primary text-white">
                <h4 class="mb-0">Insert Details</h4>
            </div>
            <div class="card-body">
                <form action="{{ route('sd') }}" method="POST" enctype="multipart/form-data" id="form-details">
                    @csrf

                    <div class="mb-3">
                        <label for="produk_id" class="form-label">Produk</label>
                        <select name="produk_id" id="produk_id" class="form-control" required>
                            @foreach ($produk as $produk)
                                <option value="{{ $produk->id }}">{{ $produk->nama_produk }}</option>
                            @endforeach
                        </select>
                        @error('produk_id')
                            <div class="text-danger small">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="nama_produk" class="form-label">Deskripsi</label>
                        <input type="text" name="deskripsi" class="form-control" placeholder="Deskripsi">
                        @error('deskripsi')
                            <div class="text-danger small">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="text-end">
                        <input type="submit" class="btn btn-success" value="Konfirmasi">
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS Bundle (Optional if needed for interaction) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        $('#form-details').submit(function (e) {
            e.preventDefault();
    
            $.ajax({
                url: '{{ route('sd') }}',
                method: 'POST',
                data: $(this).serialize(),
                success: function (res) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Sukses!',
                        text: 'Details berhasil ditambahkan',
                    }).then(() => {
                        window.location.href = "{{ route('dp') }}"; // Redirect ke halaman DataTables
                    });
                },
                error: function (xhr) {
                    let err = xhr.responseJSON.errors;
                    let msg = 'Terjadi kesalahan';
    
                    if (err) {
                        msg = Object.values(err).join(', ');
                    }
    
                    Swal.fire({
                        icon: 'error',
                        title: 'Gagal',
                        text: msg,
                    });
                }
            });
        });
    </script>
    
    <script>
        // Check if there is a session flash message for success
        @if (session('success'))
            Swal.fire({
                icon: 'success',
                title: 'Berhasil',
                text: '{{ session('success') }}',
                confirmButtonColor: '#3085d6'
            });
        @endif

        @if ($errors->any())
            Swal.fire({
                icon: 'error',
                title: 'Inputan tidak valid',
                text: 'Silakan periksa kembali isian form Anda.',
                confirmButtonColor: '#d33'
            });
        @endif
    </script>
</body>

</html>
