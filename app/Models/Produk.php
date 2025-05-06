<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Produk extends Model
{
    protected $table = "produk";
    protected $fillable = ["nama_produk", "kategori_id", "harga", "stok", "gambar"];
    public function kategori()
    {
        return $this->belongsTo(Kategori::class, 'kategori_id', 'id');
    }
    public function detail()
    {
        return $this->hasOne(ProdukDetails::class, 'produk_id');
    }
}
