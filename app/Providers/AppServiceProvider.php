<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use App\Models\Barang;
use Carbon\Carbon;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Menggunakan View Composer untuk membagikan variabel ke semua view
        View::composer('*', function ($view) {
            // Hitung barang yang hampir habis stoknya
            $barangAlmostOutOfStockCount = Barang::whereColumn('stok', '<=', 'minimum_Stok')->count();

            // Hitung barang yang akan kadaluarsa dalam 7 hari ke depan
            $barangExpiringSoonCount = Barang::whereBetween('tgl_kadaluarsa', [Carbon::now(), Carbon::now()->addDays(7)])->count();

            $barangExpiredCount = Barang::where('tgl_kadaluarsa', '<', Carbon::now())->count(); // Hitung barang kadaluarsa
            
            // Total notifikasi
            $totalNotifications = $barangAlmostOutOfStockCount + $barangExpiringSoonCount + $barangExpiredCount ;

            // Bagikan variabel ke semua view
            $view->with('totalNotifications', $totalNotifications);
        });
    }
}