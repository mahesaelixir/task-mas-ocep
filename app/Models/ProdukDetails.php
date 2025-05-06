<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProdukDetails extends Model
{
    protected $table = "produk_details";
    protected $fillable = ["produk_id", "deskripsi"];
    public function produk()
    {
        return $this->belongsTo(Produk::class);
    }
}
