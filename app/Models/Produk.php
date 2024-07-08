<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class Produk extends Model implements HasMedia
{
    use HasFactory, InteractsWithMedia;
     protected $table = 'produk';

    protected $fillable =[
        'nama',
        'id_kategori',
        'berat',
        'satuan',
        'harga',
        'deskripsi',
        'image'
    ];

    // protected $appends = [
    //     'status_formatted', 'harga_formatted'
    // ];

    public function kategori()
    {
        return $this->belongsTo(KategoriProduk::class, 'id_kategori')->withDefault();
    }

    public function getPriceFormattedAttribute()
    {
        return 'Rp.' . number_format($this->harga, 0, ',', '.');
    }
}
