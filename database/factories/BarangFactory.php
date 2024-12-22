<?php

namespace Database\Factories;

use App\Models\Barang;
use Illuminate\Database\Eloquent\Factories\Factory;

class BarangFactory extends Factory
{
    protected $model = Barang::class;

    public function definition()
    {
        return [
            'nama_Barang' => $this->faker->randomElement([
                'Beras', 'Gula', 'Garam', 'Tomat', 'Kentang', 'Wortel', 'Ayam', 'Ikan', 'Apel', 'Jeruk', 'Susu'
            ]), // Menambahkan beberapa nama bahan makanan yang umum
            'satuan' => $this->faker->randomElement(['kg', 'ltr', 'pcs', 'buah']), // Menggunakan satuan yang relevan
            'stok' => $this->faker->numberBetween(10, 1000), // Stok antara 10 hingga 1000, sesuai kebutuhan bahan makanan
            'tanggal' => $this->faker->dateTimeThisDecade(), // Tanggal barang masuk
            'tgl_kadaluarsa' => $this->faker->dateTimeBetween('now', '+2 years'), // Tanggal kadaluarsa bahan makanan
            'minimum_Stok' => $this->faker->numberBetween(5, 50), // Minimum stok untuk bahan makanan
        ];
    }
}
