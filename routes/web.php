<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\BarangController;
use App\Http\Controllers\TransaksiController;
use App\Http\Controllers\BelanjaController;
use App\Http\Controllers\SupplierController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\KeranjangController;


Route::get('/', function () {
    return view('auth.login');
});

Route::get('/register', function () {
    return view('auth.register');
})->name('register');

Route::get('/search', [BarangController::class, 'search'])->name('search');

Route::get('/transaksi', [TransaksiController::class, 'index'])->name('transaksi');
Route::get('/riwayat', [TransaksiController::class, 'riwayat'])->name('transaksi-riwayat');
Route::get('/details', [TransaksiController::class, 'details'])->name('details');



Route::get('/dashboard', [BarangController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::post('/cetak-transaksi', [TransaksiController::class, 'cetakTransaksi'])->name('cetak.transaksi');

Route::resource('barang', BarangController::class);
Route::resource('belanja', BelanjaController::class);


Route::get('/belanja', [BelanjaController::class, 'index'])->name('belanja');
Route::get('/supplier', function () {
    return view('supplier.index');
})->name('supplier');

Route::get('/filter', [BelanjaController::class, 'filterByStok'])->name('belanja.filter');


Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::get('/keranjang', [KeranjangController::class, 'index'])->name('keranjang.index');
    
    // Add to cart
    Route::post('/keranjang/add', [KeranjangController::class, 'addToCart'])->name('keranjang.add');
    
    // Update cart item
    Route::put('/keranjang/{id}', [KeranjangController::class, 'update'])->name('keranjang.update');
    
    // Remove from cart
    Route::delete('/keranjang/{id}', [KeranjangController::class, 'destroy'])->name('keranjang.destroy');
});
Route::post('/belanja/reset-stok', [BelanjaController::class, 'reset'])
    ->name('belanja.reset');
Route::post('/save-barang', [BarangController::class, 'store']);
Route::post('/save-transaksi', [TransaksiController::class, 'store']); // Add a name for clarity
Route::post('/save-belanja', [BelanjaController::class, 'store'])->name('belanja.store');
Route::post('/save-supplier', [SupplierController::class, 'store'])->name('supplier.store');

Route::get('cart', [BarangController::class, 'viewCart'])->name('cart.view');
Route::get('add-to-cart/{id}', [BarangController::class, 'addToCart'])->name('cart.add');
Route::get('remove-from-cart/{id}', [BarangController::class, 'removeFromCart'])->name('cart.remove');

//route page
Route::get('/tambah-barang', [BarangController::class, 'getSupplier'])->name('barang.add');

Route::get('/tambah-belanja', [BelanjaController::class, 'addBelanja'])->name('belanja.add');


Route::get('/edit-barang/{product:id}', [BarangController::class, 'details'])->name('barang.edit');

Route::get('/edit-belanja/{belanja:id}', [BelanjaController::class, 'details'])->name('belanja.edit');

require __DIR__ . '/auth.php';