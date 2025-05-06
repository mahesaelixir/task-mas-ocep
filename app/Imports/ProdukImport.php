<?php

namespace App\Imports;

use App\Models\Produk;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class ProdukImport implements ToModel, WithHeadingRow
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return new Produk([
            'nama_produk' => $row['nama_produk'],
            'kategori_id' => $row['kategori_id'],
            'harga' => $row['harga'],
            'stok' => $row['stok'],
        ]);
    }
}
