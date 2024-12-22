<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Barang;

class BarangSeeder extends Seeder
{
    public function run()
    {
        // Menggunakan factory untuk menghasilkan 50 data barang
        Barang::factory(100)->create();
    }
}
