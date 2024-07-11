<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaksi extends Model
{
    use HasFactory;

     protected $table = 'transaksi';
    protected $fillable = [
        'user_id', 'total'
    ];

    public function items()
    {
        return $this->hasMany(DetailTransaksi::class);
    }
    
    public function user()
{
    return $this->belongsTo(User::class);
}
}
