<?php

namespace App\Http\Controllers;

use App\Models\Keranjang;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;

class KeranjangController extends Controller
{
    /**
     * Display a listing of the resource.
     */
  public function index()
    {
        try {
            $userId = Auth::id();
            if (!$userId) {
                return response()->json(['error' => 'User not authenticated'], 401);
            }

            $keranjangItems = Keranjang::where('id_user', $userId)->with('produk')->get();
            return response()->json($keranjangItems);
        } catch (\Exception $e) {
            Log::error('Error fetching cart items: ' . $e->getMessage());
            return response()->json(['error' => 'Internal Server Error'], 500);
        }
    }
    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
     Keranjang::create($request->all());
     $cartCount = Keranjang::where('id_user', $request->id_user)->count();
      return response()->json(['success' => 'Item added to cart successfully!','cartCount' => $cartCount]);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
  public function deleteItem($id)
{
    
    // Contoh implementasi sederhana
    $item = Keranjang::find($id);
    if ($item) {
        $item->delete();
        return response()->json(['message' => 'Item deleted successfully'], 200);
    }

    return response()->json(['message' => 'Item not found'], 404);
}

  public function getCartCount()
{
    $cartCount = 0;
    if (Auth::check()) {
        $cartCount = Keranjang::where('id_user', Auth::id())->count();
    }
    return response()->json(['cartCount' => $cartCount]);
}
}
