<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Insert Kategori</title>

    <!-- Bootstrap CSS -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
    <div class="container mt-5">
        <div class="card shadow">
            <div class="card-header bg-primary text-white">
                <h4 class="mb-0">Insert Kategori</h4>
            </div>
            <div class="card-body">
                <form action="{{ route('sk') }}" method="POST" id="formKategori">
                    @csrf

                    <div class="mb-3">
                        <label for="nama_kategori" class="form-label">Nama Kategori</label>
                        <input type="text" name="nama_kategori" class="form-control" placeholder="Nama Kategori"
                            value="{{ old('nama_kategori') }}">
                        @error('nama_kategori')
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
        $('#formKategori').submit(function(e) {
            e.preventDefault();
            let form = $(this);
            let url = form.attr('action');
            let formData = form.serialize();

            $.ajax({
                url: url,
                type: 'POST',
                data: formData,
                success: function(response) {
                    if (response.status) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Berhasil',
                            text: response.message
                        }).then(() => {
                            window.location.href =
                            "{{ route('kt') }}"; // kembali ke daftar kategori
                        });
                    }
                },
                error: function(xhr) {
                    let msg = 'Terjadi kesalahan.';
                    if (xhr.responseJSON && xhr.responseJSON.errors) {
                        msg = Object.values(xhr.responseJSON.errors).join(', ');
                    }
                    Swal.fire({
                        icon: 'error',
                        title: 'Gagal',
                        text: msg
                    });
                }
            });
        });
        // Pesan sukses dari session
        @if (session('success'))
            Swal.fire({
                icon: 'success',
                title: 'Berhasil',
                text: '{{ session('success') }}',
                confirmButtonColor: '#3085d6'
            });
        @endif

        // Validasi gagal
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
