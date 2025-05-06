<?php

namespace App\Exports;

use App\Models\Produk;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class ProdukExport implements FromCollection, WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return Produk::with('kategori') // Memuat relasi kategori
        ->select('nama_produk', 'kategori_id', 'harga', 'stok')
        ->get()
        ->map(function($produk) {
            return [
                'nama_produk' => $produk->nama_produk,
                'kategori' => $produk->kategori_id,
                'harga' => $produk->harga,
                'stok' => $produk->stok,
            ];
        });
    }
    public function headings(): array {
        return ['nama_produk', 'kategori_id', 'harga', 'stok'];
    }
}
