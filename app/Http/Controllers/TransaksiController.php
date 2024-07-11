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

        
        // elseif(Auth::user()->member == 'non_member'){
        //     if($validatedData['total'] >= 100000){
        //         $jmlh = $point + 100;
        //         if($jmlh > 0 && $jmlh < 200){
        //             $member = 'bronze';
        //         }elseif($jmlh >= 200 && $jmlh < 300){
        //             $member = 'silver';
        //         }elseif($jmlh >= 300 ){
        //             $member = 'gold';
        //         }
        //         $user->update([
        //             'member' => $member,
        //             'point' => $jmlh
        //         ]);
        //     }
        // }
        

        

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



        $user = User::find(Auth::id());
        $detailtransaksi = DetailTransaksi::where('transaksi_id', $transaksi->id)->first();
        $point = $user->point;
        if($user->member != 'non member'){
            if($detailtransaksi->total >= 100000){
                $jmlh = $point + 20;
                if($jmlh > 0 && $jmlh < 200){
                    $member = 'bronze';
                }elseif($jmlh >= 200 && $jmlh < 300){
                    $member = 'silver';
                }elseif($jmlh >= 300 ){
                    $member = 'gold';
                }
                $user->update([
                    'member' => $member,
                    'point' => $jmlh
                ]);
            }
        }

        Keranjang::where('id_user', Auth::id())->delete();
      
        return response()->json(['message' => 'Transaksi berhasil disimpan', 'transaksi' => $transaksi], 201);
    } catch (\Exception $e) {
         Log::error('Error storing transaction: ' . $e->getMessage());
        return response()->json(['message' => 'Terjadi kesalahan', 'error' => $e->getMessage()], 500);
    }
}

}
