<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\BarangController;
use App\Http\Controllers\TransaksiController;
use App\Http\Controllers\BelanjaController;


use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('auth.login');
});

Route::get('/register', function () {
    return view('auth.register');
})->name('register');

Route::get('/search', [BarangController::class, 'search'])->name('search');

Route::get('/transaksi', [TransaksiController::class, 'index'])->name('transaksi');
Route::get('/riwayat', [TransaksiController::class, 'riwayat'])->name('transaksi-riwayat');


Route::get('/dashboard', [BarangController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::post('/cetak-transaksi', [TransaksiController::class, 'cetakTransaksi'])->name('cetak.transaksi');

Route::resource('barang', BarangController::class);
Route::resource('belanja', BelanjaController::class);


Route::get('/belanja', [BelanjaController::class, 'index'])->name('belanja');
Route::get('/filter', [BelanjaController::class, 'filterByStok'])->name('belanja.filter');


Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});
Route::post('/belanja/reset-stok', [BelanjaController::class, 'reset'])
    ->name('belanja.reset');
Route::post('/save-barang', [BarangController::class, 'store']);
Route::post('/save-transaksi', [TransaksiController::class, 'store']); // Add a name for clarity
Route::post('/save-belanja', [BelanjaController::class, 'store'])->name('belanja.store');

//route page
Route::get('/tambah-barang', function () {
    return view('barang.add');
})->name('barang.add');

Route::get('/tambah-belanja', function () {
    return view('belanja.add');
})->name('belanja.add');


Route::get('/edit-barang/{product:id}', [BarangController::class, 'details'])->name('barang.edit');

Route::get('/edit-belanja/{belanja:id}', [BelanjaController::class, 'details'])->name('belanja.edit');

require __DIR__ . '/auth.php';
