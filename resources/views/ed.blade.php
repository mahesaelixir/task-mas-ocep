<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Update Details</title>

    <!-- Bootstrap CSS -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
    @extends('layouts.dash')

    @section('content')
        <div class="container mt-5">
            <div class="card shadow">
                <div class="card-header bg-warning text-dark">
                    <h4 class="mb-0">Edit Details</h4>
                </div>
                <div class="card-body">
                    <form action="{{ route('details.update', ['id' => $detail->id]) }}" method="POST" id="form-details">
                        @csrf
                        @method('PUT')

                        <div class="mb-3">
                            <label for="produk_id" class="form-label">Produk</label>
                            <select name="produk_id" class="form-select">
                                @foreach ($produk as $item)
                                    <option value="{{ $item->id }}"
                                        {{ $item->id == $detail->produk_id ? 'selected' : '' }}>
                                        {{ $item->nama_produk }}
                                    </option>
                                @endforeach
                            </select>
                            @error('produk_id')
                                <div class="text-danger small">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="deskripsi" class="form-label">Deskripsi</label>
                            <input type="text" name="deskripsi" class="form-control"
                                value="{{ old('deskripsi', $detail->deskripsi) }}">
                            @error('deskripsi')
                                <div class="text-danger small">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="text-end">
                            <button type="submit" class="btn btn-primary">Simpan</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    @endsection

    @section('scripts')
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        <script>
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
    @endsection

</body>

</html>
