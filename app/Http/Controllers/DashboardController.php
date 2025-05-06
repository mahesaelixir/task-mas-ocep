<?php

namespace App\Http\Controllers;
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Produk;
use App\Models\Kategori;

class DashboardController extends Controller
{
    public function dashboard()
    {
        // Ambil produk beserta stoknya
        $produk = Produk::select('nama_produk', 'stok')->get();
        $totalProduk = Produk::count();
        $totalKategori = Kategori::count();

        // Kirim data produk ke view
        return view('dashboard', compact('produk', 'totalProduk', 'totalKategori'));
    }
}

