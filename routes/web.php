<?php

use App\Http\Controllers\KeranjangController;
use App\Http\Controllers\ProdukController;
use App\Http\Controllers\homeController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TransaksiController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', [ProdukController::class, 'index']);


Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::post('/dashboard', [KeranjangController::class, 'store'])->name('keranjang.store')->middleware('auth');
Route::get('/keranjang/items', [KeranjangController::class, 'index'])->name('keranjang.items');
Route::get('/cart-count', [KeranjangController::class, 'getCartCount']); 
Route::delete('/keranjang/delete/{id}', [KeranjangController::class, 'deleteItem'])->name('keranjang.delete');

 Route::post('/transaksi', [TransaksiController::class, 'store'])->name('transaksi.store');

Route::get('/produk', [ProdukController::class, 'index'])->name('produk.index');
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
