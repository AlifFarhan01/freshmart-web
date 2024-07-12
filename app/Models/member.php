<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class member extends Model
{

    protected $table = 'member';
    public $timestamps = false;
    use HasFactory;
    protected $fillable =[
        'nama',
        'diskon',
        'status',
    ];
}
