<?php use App\Http\Controllers\ProfileController;
use App\Http\Controllers\BarangController;
use App\Http\Controllers\TransaksiController;
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
Route::get('/belanja', function () {
    return view('belanja.index');
})->name('belanja');
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});
Route::post('/save-barang', [BarangController::class, 'store']);
Route::post('/save-transaksi', [TransaksiController::class, 'store']); // Add a name for clarity //route page   // transaksi.riwayat require __DIR__ . '/auth.php';
