@extends('layouts.dash')

@section('content')
    <div class="row">
        <div class="col-md-6">
            <div class="card border-primary shadow-sm">
                <div class="card-body">
                    <h5 class="card-title"><i class="bi bi-box-seam"></i> Total Produk</h5>
                    <p class="card-text fs-4">{{ $totalProduk }}</p>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card border-success shadow-sm">
                <div class="card-body">
                    <h5 class="card-title"><i class="bi bi-tags"></i> Total Kategori</h5>
                    <p class="card-text fs-4">{{ $totalKategori }}</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Tambahkan bar chart disini -->
    <div class="row mt-4">
        <div class="col-md-12">
            <div class="card shadow-sm">
                <div class="card-body">
                    <h5 class="card-title">Stok Produk</h5>
                    <canvas id="produkChart" width="400" height="200"></canvas>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        // Ambil data produk dari controller
        const produkData = @json($produk);  // Produk yang dikirim dari Controller

        // Ambil nama produk dan stok untuk chart
        const labels = produkData.map(item => item.nama_produk);
        const data = produkData.map(item => item.stok);

        // Inisialisasi chart
        const ctx = document.getElementById('produkChart').getContext('2d');
        const produkChart = new Chart(ctx, {
            type: 'bar', // Jenis chart: Bar Chart
            data: {
                labels: labels, // Nama produk untuk sumbu X
                datasets: [{
                    label: 'Stok Produk', // Label untuk chart
                    data: data, // Stok produk untuk sumbu Y
                    backgroundColor: 'rgba(54, 162, 235, 0.2)', // Warna bar
                    borderColor: 'rgba(54, 162, 235, 1)', // Warna border
                    borderWidth: 1
                }]
            },
            options: {
                scales: {
                    y: {
                        beginAtZero: true // Mulai dari nol pada sumbu Y
                    }
                }
            }
        });
    </script>
@endsection
