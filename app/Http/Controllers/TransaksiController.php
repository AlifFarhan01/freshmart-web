<?php

namespace App\Http\Controllers;

use App\Models\DetailTransaksi;
use App\Models\Keranjang;
use App\Models\Transaksi;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class TransaksiController extends Controller
{
    /**
     * Store a newly created resource in storage.
     */
   public function store(Request $request)
{
    try {
        // Validasi data yang diterima dari request
        $validatedData = $request->validate([
            'total' => 'required|numeric',
        ]);
        
        
        // Buat transaksi baru
        $transaksi = Transaksi::create([
            'user_id' => Auth::id(),
            'total' => $validatedData['total'],
        ]);

        
        
       // Ambil item-item yang ada di keranjang untuk user saat ini
        $items = Keranjang::where('id_user', Auth::id())->get();

        // Simpan setiap item ke dalam detail_transaksi
        foreach ($items as $item) {
            DetailTransaksi::create([
                'transaksi_id' => $transaksi->id,
                'produk_id' => $item->id_produk,
                'qty' => $item->qty,
                'total' => $item->qty * $item->produk->harga, // Jika ada kolom total di tabel Keranjang
            ]);
        }

        $point = floor($validatedData['total'] / 20000) * 10;
        $user = User::find(Auth::id());
        $user->point += $point;
        $user->save();

        
        $member = 1;
        


            if(  $user->point >= 100 &&   $user->point < 200){
                $member = 2;
            }elseif(  $user->point >= 200 &&   $user->point < 300){
                $member = 3;
            }elseif(  $user->point >= 300 ){
                $member = 4;
            }
            
            $user->update([
                'member' => $member,
            ]);
        

        Keranjang::where('id_user', Auth::id())->delete();
      
        return response()->json(['message' => 'Transaksi berhasil disimpan', 'transaksi' => $transaksi], 201);
    } catch (\Exception $e) {
         Log::error('Error storing transaction: ' . $e->getMessage());
        return response()->json(['message' => 'Terjadi kesalahan', 'error' => $e->getMessage()], 500);
    }
}

}
