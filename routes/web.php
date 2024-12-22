<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\BarangController;
use App\Http\Controllers\TransaksiController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\LaporanController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use SebastianBergmann\CodeCoverage\Report\Html\Dashboard;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\EmailController;

// dashboard
Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard.index')->middleware('role:admin,employee,vendor');

// user
Route::resource('users', UserController::class)->middleware('auth')->middleware('role:admin');;

// register
Route::get('/register', [RegisterController::class, 'showRegisterForm'])->name('register');
Route::post('/register', [RegisterController::class, 'register'])->name('register.post');

// login
Route::get('/', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('login', [LoginController::class, 'login'])->name('login.post');
Route::post('logout', [LoginController::class, 'logout'])->name('logout');

// email
Route::get('/email', [EmailController::class, 'index'])->name('email');


// Barang
Route::resource('barang', BarangController::class)->middleware('role:admin,employee');
Route::get('barang/{id}/ambil', [BarangController::class, 'ambilBarang'])->name('barang.ambil')->middleware('role:admin,employee'); // Route untuk mengambil barang (form ambil barang)
Route::put('barang/{id}/ambil', [BarangController::class, 'ambilStok'])->name('barang.ambilStok')->middleware('role:admin,employee'); // Route untuk mengupdate stok barang setelah diambil
Route::get('/barang/tambah-stok', [BarangController::class, 'show'])->name('barang.show')->middleware('role:admin,employee');
Route::post('/barang/update-stok', [BarangController::class, 'updateStok'])->name('barang.updateStok')->middleware('role:admin,employee');


// Transaksi
Route::get('/transaksi', [TransaksiController::class, 'index'])->name('transaksi.index')->middleware('role:admin');
Route::post('/transaksi', [TransaksiController::class, 'generate'])->name('transaksi.generate')->middleware('role:admin');



//Laporan
Route::prefix('laporan')->group(function () {
    Route::get('/', [LaporanController::class, 'index'])->name('laporan.index')->middleware('role:admin');
    Route::get('/generate', [LaporanController::class, 'generate'])->name('laporan.generate')->middleware('role:admin');
    Route::get('/export-pdf', [LaporanController::class, 'exportPdf'])->name('laporan.exportPdf')->middleware('role:admin');
});



//notifikasi buat barang yang kadaluarsa & minimum stok
Route::get('/notifikasi', [BarangController::class, 'notifikasi'])->name('notifikasi.index')->middleware('role:admin,employee,vendor');

// Rute untuk menampilkan halaman laporan


