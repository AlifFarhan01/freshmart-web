<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Faq extends Model
{
      protected $table = 'faq';
    public $timestamps = false;
    use HasFactory;
    protected $fillable =[
        'pertanyaan',
        'jawaban',
    ];
}

