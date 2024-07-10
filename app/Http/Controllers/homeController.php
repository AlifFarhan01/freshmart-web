<?php

namespace App\Http\Controllers;

use App\Models\Produk;
use Illuminate\Http\Request;

class homeController extends Controller
{
    public function index()
    {
        $produk = Produk::all();
        $data['title'] = 'Home';
        $data['active'] = 'home';
        $data['produk'] = $produk;
        
        return view('v_public.home', $data);
    }


}
