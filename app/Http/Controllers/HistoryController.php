<?php

namespace App\Http\Controllers;

use App\Models\DetailTransaksi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HistoryController extends Controller
{
   public function index()
{
    $user = Auth::user();

    $details = DetailTransaksi::selectRaw('produk_id, sum(qty) as total_qty')
        ->whereHas('transaksi', function ($query) use ($user) {
            $query->where('user_id', $user->id);
        })
        ->groupBy('produk_id')
        ->orderBy('total_qty', 'desc')
        ->limit(5)
        ->get();

    return view('history', ['details' => $details]);
}
}
