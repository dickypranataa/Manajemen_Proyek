<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Transaksi;

class TransaksiSeeder extends Seeder
{
    public function run()
    {
        // Menggunakan factory untuk menghasilkan 50 data transaksi
        Transaksi::factory(50)->create();
    }
}
